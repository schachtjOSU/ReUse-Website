using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Net;
using System.Xml.Linq;
using CRRD.Resources.Models;

namespace CRRD.Resources.Data
{
    class XMLHandler
    {
        public Boolean isInitialized { get; private set; }

        private XDocument xDoc { get; set; }
        public List<Category> CategoryList { get; private set; }
        public List<Business> BusinessList { get; private set; }
        private MyDeviceIO deviceIO { get; set; }

        private const string fileName = "@string/SavedXMLfilename";
        private const string _ERR_NO_NETWORK = "No Active Network Found";
        private const string _ERR_BAD_URI = "Bad URI Request";

        // Current Link provided from Josh
        private string BUSINESS_LIST_URI = "@string/APIBusinessURI";

        /// <summary>
        /// Costructor for the XMLHandler class. Instanciates and sets collection properties. Runs all parsing methods 
        /// for setting the Business and Category classes. 
        /// </summary>
        public XMLHandler()
        {
            // instanciate the lists
            CategoryList = new List<Category>();
            BusinessList = new List<Business>();

            // Set the MyDeviceIO class
            deviceIO = new MyDeviceIO(fileName);

            // Get the XML Business List from the Database URL
            // Save the XML file to the local device
            string xmlResult = GetXMLFromURL();

            /*
                Checks the result of the XML File process
                - if _ERR_BAD_URI:      The requested URI is down or incorrect (changed) -> check if an old XML file exists on the device
                - if _ERR_NO_NETWORK:   The device is not currently connected to a network -> check if an old XML file exists on the device
                - default:              Will save the new XML file to the device and parse it to the class structure
            */
            switch (xmlResult)
            {
                case _ERR_BAD_URI:
                case _ERR_NO_NETWORK:
                    if (deviceIO.BusinessFileExists())
                    {
                        // Get the locally saved XML document
                        xDoc = XDocument.Parse(GetXmlFromDevice());

                        // Set class collections
                        SetBusinessList();
                        SetCategoryList();
						
						isInitialized = true;
                    }
                    else
                    {
                        // Set isInitialized in case of bad URI
                        isInitialized = false;
                    }
                    break;
                default:
                    SaveXmlToDevice(xmlResult);
                    // Get the locally saved XML document
                    xDoc = XDocument.Parse(GetXmlFromDevice());

                    // Set class collections
                    SetBusinessList();
                    SetCategoryList();

                    isInitialized = true;

                    break;
            }

            
        }

        /// <summary>
        /// Parses the data in the CRRD Database XML file into the Business and Category classes
        /// </summary>
        private void SetBusinessList()
        {
            // Collect all Elements (business) and all its decendants
            var businesses = from qry in xDoc.Descendants("business")
                             select new
                             {
                                 // string values
                                 Name = qry.Element("name").Value,
                                 Addr1 = qry.Element("contact_info").Element("address").Element("address_line_1").Value,
                                 Addr2 = qry.Element("contact_info").Element("address").Element("address_line_2").Value,
                                 City = qry.Element("contact_info").Element("address").Element("city").Value,
                                 State = qry.Element("contact_info").Element("address").Element("state").Value,
                                 Phone = qry.Element("contact_info").Element("phone").Value,
                                 Website = qry.Element("contact_info").Element("website").Value,

                                 // collection values
                                 Categories = qry.Element("category_list").Elements("category"),

                                 // int & double values
                                 ID = qry.Element("id").Value,
                                 Zip = (qry.Element("contact_info").Element("address").Element("zip").Value != "")
                                                ? qry.Element("contact_info").Element("address").Element("zip").Value : "0",
                                 Lat = (qry.Element("contact_info").Element("latlong").Element("latitude").Value != "")
                                                ? qry.Element("contact_info").Element("latlong").Element("latitude").Value : "0",
                                 Lng = (qry.Element("contact_info").Element("latlong").Element("longitude").Value != "")
                                                ? qry.Element("contact_info").Element("latlong").Element("longitude").Value : "0"
                             };

            Business tmpBus;
            List<Category> tmpCatList;

            // Fill the Business and Category objects with the gathered XML data
            foreach (var bus in businesses)
            {
                tmpBus = new Business();
                tmpCatList = new List<Category>();

                tmpBus.Name = bus.Name;
                tmpBus.Address_1 = bus.Addr1;
                tmpBus.Address_2 = bus.Addr2;
                tmpBus.City = bus.City;
                tmpBus.State = bus.State;
                tmpBus.Phone = bus.Phone;
                tmpBus.Website = bus.Website;
                tmpBus.Database_ID = Int32.Parse(bus.ID);
                tmpBus.Zip = Int32.Parse(bus.Zip);
                tmpBus.Latitude = double.Parse(bus.Lat);
                tmpBus.Longitude = double.Parse(bus.Lng);

                // Process for Subcategory Lists
                foreach (var c in bus.Categories)
                {
                    var subcategories = from qry in c.Descendants("subcategory")
                                        select new
                                        {
                                            Subcat = qry.Value
                                        };

                    List<string> tmpSubList = new List<string>();
                    foreach (var s in subcategories)
                    {
                        tmpSubList.Add(s.Subcat);
                    }

                    tmpCatList.Add(new Category(c.Element("name").Value, tmpSubList));
                }
                tmpBus.CategoryList = tmpCatList;

                BusinessList.Add(tmpBus);
            }
        }

        /// <summary>
        /// Sets the category list of Category objects.
        /// </summary>
        private void SetCategoryList()
        {
            // Iterate through the list of Business to get each Category
            foreach (var b in BusinessList)
            {
                // A Business will have n Categories (a given Category may have a unique list of Subcategories)
                foreach (var c in b.CategoryList)
                {
                    CategoryList.Add(c);
                }
            }
        }

        /// <summary>
        /// Gets the XML from device.
        /// </summary>
        /// <returns>The XML string</returns>
        private string GetXmlFromDevice()
        {
            return deviceIO.ReadFromDevice();
        }

        /// <summary>
        /// Gets the XML from URL.
        /// </summary>
        /// <returns>A string result of the requested XML file</returns>
        private string GetXMLFromURL()
        {
            var result = "";

            if (deviceIO.HasNetwork())
            {
                HttpWebRequest req = (HttpWebRequest)WebRequest.Create(BUSINESS_LIST_URI);

                try
                {
                    HttpWebResponse resp = (HttpWebResponse)req.GetResponse();

                    StreamReader sr = new StreamReader(resp.GetResponseStream());
                    result = sr.ReadToEnd();
                    sr.Close();
                }
                catch
                {
                    result = _ERR_BAD_URI;
                }

                return result;
            }

            return _ERR_NO_NETWORK;
        }

        /// <summary>
        /// Saves the XML to device.
        /// </summary>
        /// <param name="xmlString">The XML string.</param>
        private void SaveXmlToDevice(string xmlString)
        {
            deviceIO.SaveToDevice(xmlString);
        }
        
    }
}