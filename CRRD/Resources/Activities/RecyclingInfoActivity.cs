
using Android.App;
using Android.Content;
using Android.OS;
using Android.Widget;
using CRRD.Resources.Adapters;

namespace CRRD.Resources.Activities
{
    /// <summary>
    /// Android Activity: Used for displaying the local recycling facility information. Provides navigation for facility information links.
    /// </summary>
    /// <seealso cref="Android.App.Activity" />
    [Activity(Label = "@string/RecyclingInfoActivityLabel", Icon = "@drawable/RepublicServices")]
    public class RecyclingInfoActivity : Activity
    {
        /// <summary>
        /// Called when [create].
        /// </summary>
        /// <param name="bundle">The bundle.</param>
        protected override void OnCreate(Bundle bundle)
        {
            base.OnCreate(bundle);

            // Set our view from the layout resource
            SetContentView(Resource.Layout.RecyclingInfo);

            // Get view Elements
            Button lnkRecFacility = FindViewById<Button>(Resource.Id.lnkRecyclingFacility);
            Button lnkRecCurbside = FindViewById<Button>(Resource.Id.lnkRecyclingCurbside);

            // Set Events
            lnkRecFacility.Click += LnkRecFacility_Click;
            lnkRecCurbside.Click += LnkRecCurbside_Click;
        }

        private void LnkRecFacility_Click(object sender, System.EventArgs e)
        {
            var intent = new Intent(this, typeof(WebViwerActivity));
            intent.PutExtra("PDF_URI", this.ApplicationContext.GetString(Resource.String.RSRecycleDepotPDF));
            StartActivity(intent);
        }

        private void LnkRecCurbside_Click(object sender, System.EventArgs e)
        {
            var intent = new Intent(this, typeof(WebViwerActivity));
            intent.PutExtra("PDF_URI", this.ApplicationContext.GetString(Resource.String.RSCurbsidePDF));
            StartActivity(intent);
        }
    }
}