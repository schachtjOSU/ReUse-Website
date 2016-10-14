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
    /// Android Activity: Used to move to ErrorActivity should the directory data not be available.
    /// </summary>
    /// <seealso cref="Android.App.Activity" />
    public class ErrorCheckActivity : Activity
    {
        
        /// <summary>
        /// Moves to AppErrorActivity if DataHandler is invalid
        /// </summary>
        /// <param name="thisContext">The calling context.</param>
        /// <param name="handlerIsInitialized">The value of DataHandler.isInitialed, which indicates if the Category and Business lists have been set.</param>
        public static void checkDataHandlerInitialization(Context thisContext, Boolean handlerIsInitialized)
            {
                if (!handlerIsInitialized)
                {
                    
                    var intent = new Intent(thisContext, typeof(ErrorActivity));
                    intent.SetFlags(ActivityFlags.NewTask);
                    intent.PutExtra("errorMessage", "@string/errorMissingData");
                    thisContext.StartActivity(intent);
                }
            }
        
    }
}