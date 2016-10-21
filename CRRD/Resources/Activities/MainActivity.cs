using Android.App;
using Android.Content;
using Android.OS;
using Android.Widget;
using CRRD.Resources.Activities;
using CRRD.Resources.Adapters;

namespace CRRD
{
    /// <summary>
    /// Android Activity: The Main page activity for the application.
    /// </summary>
    /// <seealso cref="Android.App.Activity" />
    [Activity(Label = "@string/MainActivityLabel", MainLauncher = true, Icon = "@drawable/CSCLogo")]
    public class MainActivity : Activity
    {
        
        /// <summary>
        /// Called when [create].
        /// </summary>
        /// <param name="bundle">The bundle.</param>
        protected override void OnCreate(Bundle bundle)
        {

            base.OnCreate(bundle);
            SetContentView(Resource.Layout.Main);

            // Get the elements from the view
            Button btnCategories = FindViewById<Button>(Resource.Id.BtnCategories);
            Button btnRecycleInfo = FindViewById<Button>(Resource.Id.BtnRecycleInfo);

            // Assign events
            btnCategories.Click += BtnCategories_Click;
            btnRecycleInfo.Click += BtnRecycleInfo_Click;
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
    }
}

