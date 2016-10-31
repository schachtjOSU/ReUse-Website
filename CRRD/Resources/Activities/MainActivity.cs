using Android.App;
using Android.Content;
using Android.OS;
using Android.Widget;
using CRRD.Resources.Activities;
using Toolbar = Android.Support.V7.Widget.Toolbar;
using Android.Support.V7.App;
using Android.Views;
using Android.Graphics.Drawables;
using Android.Support.V4.Content;
using Android.Runtime;
using System;

namespace CRRD
{
    /// <summary>
    /// Android Activity: The Main page activity for the application.
    /// </summary>
    /// <seealso cref="Android.App.Activity" />
    [Activity(Label = "@string/MainActivityLabel", MainLauncher = true, Icon = "@drawable/CSCLogo")]
    public class MainActivity : AppCompatActivity
    {
        
        /// <summary>
        /// Called when [create].
        /// </summary>
        /// <param name="bundle">The bundle.</param>
        protected override void OnCreate(Bundle bundle)
        {

            base.OnCreate(bundle);
            SetContentView(Resource.Layout.Main);


            //Set the toolbar
            var toolbar = FindViewById<Toolbar>(Resource.Id.toolbar);
            SetSupportActionBar(toolbar);
            SupportActionBar.Title = this.ApplicationContext.GetString(Resource.String.ApplicationName);

            //Drawable CSCIcon = ContextCompat.GetDrawable(this.ApplicationContext, Resource.Drawable.CSCLogo);
            //CSCIcon.SetBounds(0, 0, (int)(CSCIcon.IntrinsicWidth * 0.1), (int)(CSCIcon.IntrinsicHeight * 0.1));
            //ScaleDrawable scaleCSCIcon = new ScaleDrawable(CSCIcon, 0, (int)(CSCIcon.IntrinsicWidth * 0.3), (int)(CSCIcon.IntrinsicHeight * 0.3));
            //scaleCSCIcon.SetBounds(0, 0, (int)(CSCIcon.IntrinsicWidth * 0.3), (int)(CSCIcon.IntrinsicHeight * 0.3));
            //SupportActionBar.SetIcon(scaleCSCIcon);



            // Get the elements from the view
            Button btnCategories = FindViewById<Button>(Resource.Id.buttonReuse);
            Button btnRecycleInfo = FindViewById<Button>(Resource.Id.buttonRecycle);
            Button btnRepair = FindViewById<Button>(Resource.Id.buttonRepair);

            // Assign events
            btnCategories.Click += BtnCategories_Click;
            btnRecycleInfo.Click += BtnRecycleInfo_Click;
            btnRepair.Click += BtnRepair_Click;
        }

        /// <summary>
        /// Handles the Click event for Categories Navigation (to CategoryListActivity)
        /// </summary>
        /// <param name="sender">The source of the event.</param>
        /// <param name="e">The <see cref="System.EventArgs"/> instance containing the event data.</param>
        private void BtnCategories_Click(object sender, System.EventArgs e)
        {
            var intent = new Intent(this, typeof(CategoryListActivity));
            StartActivity(intent);
        }

        /// <summary>
        /// Handles the Click event for Recycling Navigation (to RecyclingInfoActivity)
        /// </summary>
        /// <param name="sender">The source of the event.</param>
        /// <param name="e">The <see cref="System.EventArgs"/> instance containing the event data.</param>
        private void BtnRecycleInfo_Click(object sender, System.EventArgs e)
        {
            var intent = new Intent(this, typeof(RecyclingInfoActivity));
            StartActivity(intent);
        }

        /// <summary>
        /// Handles the Click event for Recycling Navigation (to RecyclingInfoActivity)
        /// </summary>
        /// <param name="sender">The source of the event.</param>
        /// <param name="e">The <see cref="System.EventArgs"/> instance containing the event data.</param>
        private void BtnRepair_Click(object sender, System.EventArgs e)
        {
            var intent = new Intent(this, typeof(SubcategoryListActivity));
            intent.PutExtra("categoryName", this.ApplicationContext.GetString(Resource.String.RepairCategoryName));
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

