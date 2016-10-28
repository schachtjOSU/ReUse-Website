using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using Android.App;
using Android.Content;
using Android.OS;
using Android.Runtime;
using Android.Views;
using Android.Widget;
using CRRD.Resources.Adapters;
using Android.Support.V7.App;
using Toolbar = Android.Support.V7.Widget.Toolbar;

namespace CRRD.Resources.Activities
{
    /// <summary>
    /// Android Activity: Used for displaying an error message.
    /// </summary>
    /// <seealso cref="Android.App.Activity" />
    [Activity(Label = "@string/ErrorActivityLabel", Icon = "@drawable/CSCLogo")]
    public class ErrorActivity : AppCompatActivity
    {
        private string _errorMessage;
        private TextView _errorMessageShown;

        /// <summary>
        /// Called when [create].
        /// </summary>
        /// <param name="bundle">The bundle, used to pass data between Activities.</param>
        protected override void OnCreate(Bundle bundle)
        {
            base.OnCreate(bundle);

            // Create your application here  
            SetContentView(Resource.Layout.AppError);

            //Set the toolbar
            var toolbar = FindViewById<Toolbar>(Resource.Id.toolbar);
            SetSupportActionBar(toolbar);
            SupportActionBar.Title = this.ApplicationContext.GetString(Resource.String.ApplicationName);

            // Get the passed error message
            _errorMessage = Intent.GetStringExtra("errorMessage") ?? "@string/errorUnrecognized";

            //set the TextView to the error message passed in
            _errorMessageShown = FindViewById<TextView>(Resource.Id.errorMessage);
            _errorMessageShown.Text = _errorMessage;
        }
    }

}