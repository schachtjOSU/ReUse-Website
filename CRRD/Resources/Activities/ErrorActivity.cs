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

namespace CRRD.Resources.Activities
{
    /// <summary>
    /// Android Activity: Used for displaying an error message.
    /// </summary>
    /// <seealso cref="Android.App.Activity" />
    [Activity(Label = "@string/ErrorActivityLabel", Icon = "@drawable/CSCLogo")]
    public class ErrorActivity : Activity
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

            // Get the passed error message
             _errorMessage = Intent.GetStringExtra("errorMessage") ?? "There was an unrecognized error.";

            //set the TextView to the error message passed in
            _errorMessageShown = FindViewById<TextView>(Resource.Id.errorMessage);
            _errorMessageShown.Text = _errorMessage;
        }
    }

}