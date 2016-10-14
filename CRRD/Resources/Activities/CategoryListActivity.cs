using Android.App;
using Android.Content;
using Android.OS;
using Android.Widget;
using CRRD.Resources.Models;
using System;
using System.Collections.Generic;
using System.Linq;

namespace CRRD.Resources.Activities
{
    /// <summary>
    /// Android Activity: Used for displaying the List of Categories a user may select.
    /// </summary>
    /// <seealso cref="Android.App.Activity" />
    [Activity(Label = "List of Categories", Icon = "@drawable/CSCLogo")]
    public class CategoryListActivity : Activity
    {
        private ListView _ListView;
        private List<string> _categoryListStrings;

        // Start class to Get and parse the local XML file to the associated classes (Business & Category)
        private XMLHandeler _handler = new XMLHandeler();

        /// <summary>
        /// Called when [create].
        /// </summary>
        /// <param name="bundle">The bundle.</param>
        protected override void OnCreate(Bundle bundle)
        {

            checkXMLHandlerInitialization(_handler.isInitialized);

            base.OnCreate(bundle);

            SetContentView(Resource.Layout.ListCategory);

            _ListView = FindViewById<ListView>(Resource.Id.lvListArea);
            
            // Get a sorted Unique List<sring> of Categories
            _categoryListStrings = new List<string>();
            
            foreach (var c in _handler.CategoryList)
            {
                _categoryListStrings.Add(c.Name);
            }
            
            _categoryListStrings = _categoryListStrings.Distinct().ToList();
            _categoryListStrings.Sort();
            
            // Set the custom adapter
            CategoryListAdapter adapter = new CategoryListAdapter(this, _categoryListStrings);
            _ListView.Adapter = adapter;

            // Events ...
            _ListView.ItemClick += _ListView_ItemClick;
            
        }

        /// <summary>
        /// Moves to AppErrorActivity if XMLHandler is invalid
        /// </summary>
        /// <param name="handlerIsInitialized">The XMLHandler.isValid value</param>
        private void checkXMLHandlerInitialization(Boolean handlerIsInitialized)
        {
            if (!handlerIsInitialized)
            {
                var intent = new Intent(this, typeof(AppErrorActivity));
                intent.PutExtra("errorMessage", "The directory data cannot be retrieved.");
                StartActivity(intent);
            }
        }

        private void _ListView_ItemClick(object sender, AdapterView.ItemClickEventArgs e)
        {
            var intent = new Intent(this, typeof(SubcategoryListActivity));
            intent.PutExtra("categoryName", _categoryListStrings[e.Position]);
            StartActivity(intent);
        }
    }
}