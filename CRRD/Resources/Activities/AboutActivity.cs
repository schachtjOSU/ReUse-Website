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
    /// Android Activity: Used for displaying information about the app
    /// </summary>
    /// <seealso cref="Android.App.Activity" />
    [Activity(Label = "@string/AboutActivityLabel", Icon = "@drawable/CSCLogo")]
    public class AboutActivity : Activity
    {
        /// <summary>
        /// Called on creation of the About Activity.
        /// </summary>
        /// <param name="bundle">The bundle, used for passing data between Activities.</param>
        protected override void OnCreate(Bundle bundle)
        {
            base.OnCreate(bundle);

            SetContentView(Resource.Layout.About);
        }
    }
}