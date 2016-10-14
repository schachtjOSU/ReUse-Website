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

namespace CRRD.Resources.Activities
{
    /// <summary>
    /// Android Activity: Used for displaying an error message.
    /// </summary>
    /// <seealso cref="Android.App.Activity" />
    [Activity(Label = "Error",Icon = "@drawable/CSCLogo")]
    public class AppErrorActivity : Activity
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

            // Get the passed properties
             _errorMessage = Intent.GetStringExtra("errorMessage") ?? "There was an unrecognized error.";

            _errorMessageShown = FindViewById<TextView>(Resource.Id.errorMessage);
            _errorMessageShown.Text = _errorMessage;
        }
    }
}