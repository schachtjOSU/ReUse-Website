
using Android.App;
using Android.Content;
using Android.OS;
using Android.Widget;
using CRRD.Resources.Adapters;
using Android.Support.V7.App;
using Toolbar = Android.Support.V7.Widget.Toolbar;
using Android.Views;

namespace CRRD.Resources.Activities
{
    /// <summary>
    /// Android Activity: Used for displaying the local recycling facility information. Provides navigation for facility information links.
    /// </summary>
    /// <seealso cref="Android.App.Activity" />
    [Activity(Label = "@string/RecyclingInfoActivityLabel", Icon = "@drawable/CSCLogo")]
    public class RecyclingInfoActivity : AppCompatActivity
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

            //Set the toolbar
            var toolbar = FindViewById<Toolbar>(Resource.Id.toolbar);
            SetSupportActionBar(toolbar);
            SupportActionBar.Title = this.ApplicationContext.GetString(Resource.String.ApplicationName);

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

        /// <summary>
		/// Creates the menu for the Toolbar/Action Bar to use
		/// </summary>
		/// <param name="menu">The menu</param>
		public override bool OnCreateOptionsMenu(IMenu menu)
        {
            MenuInflater.Inflate(Resource.Layout.Menu, menu);
            return base.OnCreateOptionsMenu(menu);
        }

        /// <summary>
        /// Manages on-click actions when menu options are selected
        /// </summary>
        /// <param name="item">The menu</param>
        public override bool OnOptionsItemSelected(IMenuItem item)
        {
            if (item.ItemId.Equals(Resource.Id.menu_home))
            {
                var intent = new Intent(this, typeof(MainActivity));
                StartActivity(intent);
                return base.OnOptionsItemSelected(item);
            }
            else if (item.ItemId.Equals(Resource.Id.menu_about))
            {
                var intent = new Intent(this, typeof(AboutActivity));
                StartActivity(intent);
                return base.OnOptionsItemSelected(item);
            }
            else if (item.ItemId.Equals(Resource.Id.menu_contact))
            {
                var intent = new Intent(this, typeof(ContactActivity));
                StartActivity(intent);
                return base.OnOptionsItemSelected(item);
            }
            else
            {
                return base.OnOptionsItemSelected(item);
            }
        }
    }
}