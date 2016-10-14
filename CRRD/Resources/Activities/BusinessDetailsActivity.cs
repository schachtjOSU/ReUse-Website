
using Android.App;
using Android.Content;
using Android.OS;
using Android.Widget;
using CRRD.Resources.Models;
using System;

using CRRD.Resources.Adapters;

namespace CRRD.Resources.Activities
{
    /// <summary>
    /// Android Activity: Used for displaying the the details of a specific business
    /// </summary>
    /// <seealso cref="Android.App.Activity" />
    [Activity(Label = "@string/BusinessDetailsActivityLabel", Icon = "@drawable/CSCLogo")]
    public class BusinessDetailsActivity : Activity
    {
        private TextView _txtBusName, _txtBusAddress, _txtBusPhone, _txtBusWebsite;
        private Button _btnMapViewer;

        private string _categoryName, _subcategoryName, _businessName;
        private Business _businessObj = new Business();

        // Start class to Get and parse the local XML file to the associated classes (Business & Category)
        private DataHandler _handler = new DataHandler();

        /// <summary>
        /// Called on creation of Business Details Activity.
        /// </summary>
        /// <param name="bundle">The bundle, used for passing data between Activities.</param>
        protected override void OnCreate(Bundle bundle)
        {
            ErrorCheckActivity.checkDataHandlerInitialization(this.ApplicationContext, _handler.isInitialized);

            base.OnCreate(bundle);

            SetContentView(Resource.Layout.BusinessDetails);

            // Get the passed properties
            _categoryName = Intent.GetStringExtra("categoryName") ?? "No Data Found";
            _subcategoryName = Intent.GetStringExtra("subcategoryName") ?? "No Data Found";
            _businessName = Intent.GetStringExtra("businessName") ?? "No Data Found";

            _businessObj = _handler.GetBusinessByName(_businessName);

            // Get layout objects
            _txtBusName = FindViewById<TextView>(Resource.Id.txtBusinessName);
            _txtBusAddress = FindViewById<TextView>(Resource.Id.txtBusinessAddress);
            _txtBusPhone = FindViewById<TextView>(Resource.Id.txtBusinessPhone);
            _txtBusWebsite = FindViewById<TextView>(Resource.Id.txtBusinessWebsite);
            _btnMapViewer = FindViewById<Button>(Resource.Id.BtnViewMap);

            // Set the layout objects
            _txtBusName.Text = _businessObj.Name;
            _txtBusAddress.Text = GetFormattedAddress();
            _txtBusPhone.Text = GetFormattedPhoneNumber();
            _txtBusWebsite.Text = _businessObj.Website;
            _btnMapViewer.Text = CheckBusinessHasLatLng();

            // Event Listeners
            _btnMapViewer.Click += _btnMapViewer_Click;
            _txtBusPhone.Clickable = true;
            _txtBusPhone.Click += _txtBusPhone_Click;
            _txtBusWebsite.Clickable = true;
            _txtBusWebsite.Click += _txtBusWebsite_Click;
        }


        /// <summary>
        /// Check is the business object contains a Latitude or Logitude value ther than 0. If no values are found, 
        /// The _btnMapViewer.Clickable will be set to false. 
        /// </summary>
        /// <returns>
        /// Return the button text string as default if a map marker is available or "Not Available On Map"
        /// if no map marker is available (eg. No LatLng values)
        /// </returns>
        private string CheckBusinessHasLatLng()
        {
            // if no LatLng values then set flag to 0
            int hasMarkerFlag = (_businessObj.Latitude == 0 || _businessObj.Longitude == 0) ? 0 : 1;
            _btnMapViewer.Enabled = (hasMarkerFlag == 0) ? false : true;

            // if flag = 0, return "Not Available On Map", else use default button text
            return (hasMarkerFlag == 0) ? "Not Available On Map" : _btnMapViewer.Text;
        }

        /// <summary>
        /// Handles the Click event of the _txtBusWebsite control.
        /// </summary>
        /// <param name="sender">The source of the event.</param>
        /// <param name="e">The <see cref="EventArgs"/> instance containing the event data.</param>
        private void _txtBusWebsite_Click(object sender, EventArgs e)
        {
            if (_businessObj.Website != "")
            {
                var uri = Android.Net.Uri.Parse(_businessObj.Website);
                var intent = new Intent(Intent.ActionView, uri);
                StartActivity(intent);
            }
        }

        /// <summary>
        /// Opens the phone activity and sets the phone number as the business' phone number to call.
        /// </summary>
        /// <param name="sender">The source of the Event, the PhoneNumber TextView</param>
        /// <param name="e">The <see cref="EventArgs"/> instance containing the event data.</param>
        private void _txtBusPhone_Click(object sender, EventArgs e)
        {
            // Build the uri
            var dialString = "tel:";
            dialString += GetFormattedPhoneNumber();

            var uri = Android.Net.Uri.Parse(dialString);

            var intent = new Intent(Intent.ActionDial, uri);
            StartActivity(intent);
        }

        /// <summary>
        /// Gets a USA formatted Address from the business object.
        /// </summary>
        /// <returns>
        /// A USA formatted Address string value as per the USPS. 
        /// </returns>
        private string GetFormattedAddress()
        {
            string formatedAddr = "";
            string addr_2Str = "";
            string zipStr = "";
            string CityStateZip = "";

            // Check if there is an Addr_2 in the business object
            if (_businessObj.Address_2 != "")
            {
                addr_2Str = String.Format("{0}\n", _businessObj.Address_2);
            }

            // Check Zip is 5 or 9 digits
            switch (_businessObj.Zip.ToString().Length)
            {
                case 5:
                    zipStr = _businessObj.Zip.ToString();
                    break;
                case 9:
                    zipStr = GetFormattedZip(_businessObj.Zip.ToString());
                    break;
            }

            CityStateZip = String.Format("{0} {1}  {2}", _businessObj.City, _businessObj.State, zipStr);

            // Put all the pieces together in standard Address Format USA
            formatedAddr = String.Format("{0}\n{1}{2}", _businessObj.Address_1, addr_2Str, CityStateZip);

            return formatedAddr;
        }

        /// <summary>
        /// Gets a USA formatted 9 digit Zip from the business object.
        /// </summary>
        /// <param name="zip">The Zip in string form.</param>
        /// <returns>
        /// A USA 9 digit formatted Zip string value. (Example: 12345-6789)
        /// </returns>
        private string GetFormattedZip(string zip)
        {
            return String.Format("{0}-{1}", zip.Substring(0, 5), zip.Substring(5, 4));
        }

        /// <summary>
        /// Gets a USA formatted 7, 10, or 11 digit Phone number from the business object.
        /// </summary>
        /// <returns>
        /// A USA formatted 7, 10, or 11 digit Phone number string value. (Example: 1(222)333-4444)
        /// </returns>
        private string GetFormattedPhoneNumber()
        {
            string phoneNum = _businessObj.Phone.ToString();
            string formattedPhone = "";

            switch (phoneNum.Length)
            {
                case 7:
                    formattedPhone = String.Format("{0}-{1}", phoneNum.Substring(0, 3), phoneNum.Substring(3, 4));
                    break;
                case 10:
                    formattedPhone = String.Format("1({0}){1}-{2}", phoneNum.Substring(0, 3), phoneNum.Substring(3, 3), phoneNum.Substring(6, 4));
                    break;
                case 11:
                    formattedPhone = String.Format("1({0}){1}-{2}", phoneNum.Substring(1, 3), phoneNum.Substring(2, 3), phoneNum.Substring(7, 4));
                    break;
            }

            return formattedPhone;
        }

        private void _btnMapViewer_Click(object sender, System.EventArgs e)
        {
            var intent = new Intent(this, typeof(MapViewerActivity));
            intent.PutExtra("categoryName", _categoryName);
            intent.PutExtra("subcategoryName", _subcategoryName);
            intent.PutExtra("businessName", _businessName);
            StartActivity(intent);
        }
    }
}