using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Net;
using System.Xml.Linq;
using CRRD.Resources.Models;
using CRRD.Resources.Data;

namespace CRRD.Resources.Adapters
{
    class DataHandler : XMLHandler
    {

        /// <summary>
        /// Costructor for the DataHandler class., which runs miscellaneous parsing methods for Activities.
        /// </summary>
        public DataHandler()
        {
    
        }
        
        /// <summary>
        /// Gets a Business object from the BusinessList by the passed Name parameter.
        /// </summary>
        /// <param name="businessName">Name of the business.</param>
        /// <returns>
        /// The Business object of the given Name perameter is returned.
        /// </returns>
        public Business GetBusinessByName(string businessName)
        {
            return BusinessList.FirstOrDefault(x => x.Name == businessName);
        }
    }
}