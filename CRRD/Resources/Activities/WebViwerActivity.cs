
using Android.App;
using Android.Content;
using Android.OS;
using Android.Webkit;
using CRRD.Resources.Adapters;

namespace CRRD.Resources.Activities
{
    /// <summary>
    /// Android Activity: Used for displaying a local application view of a requested web page.
    /// </summary>
    /// <seealso cref="Android.App.Activity" />
    [Activity(Label = "@string/WebViewerActivityLabel", Icon = "@drawable/CSCLogo")]
    public class WebViwerActivity : Activity
    {
        private string GDOCS_VIEWER = "@string/GDocViewer";
        private string PDF_URI;
        private WebView myWebView;

        /// <summary>
        /// Called when [create].
        /// </summary>
        /// <param name="bundle">The bundle.</param>
        protected override void OnCreate(Bundle bundle)
        {
            base.OnCreate(bundle);

            // Get Passed Data
            PDF_URI = Intent.GetStringExtra("PDF_URI") ?? "Data not available";

            // Set our view from the layout resource
            SetContentView(Resource.Layout.WebViewer);

            // Get view Elements
            myWebView = FindViewById<WebView>(Resource.Id.objWebView);

            myWebView.Settings.JavaScriptEnabled = true;
            myWebView.LoadUrl(GDOCS_VIEWER + PDF_URI);
            myWebView.SetWebViewClient(new WebClient());
        }
    }

    /// <summary>
    /// Custom class that inherits from WebViewClient. Used to enable the override of the ShouldOverrideUrlLoading() method.
    /// </summary>
    /// <seealso cref="Android.Webkit.WebViewClient" />
    public class WebClient : WebViewClient
    {
        /// <summary>
        /// Shoulds the override URL loading.
        /// </summary>
        /// <param name="view">The view.</param>
        /// <param name="url">The URL.</param>
        /// <returns>Return true with the requested URL loaded into the object.</returns>
        public override bool ShouldOverrideUrlLoading(WebView view, string url)
        {
            view.LoadUrl(url);
            return true;
        }
    }
}