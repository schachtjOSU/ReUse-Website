using Android.App;
using Android.Content;
using Android.OS;
using Android.Widget;
using CRRD.Resources.Models;
using System.Collections.Generic;
using System.Linq;

namespace CRRD.Resources.Activities
{
    /// <summary>
    /// Android Activity: Used for displaying the List of Subcategories the user may select.
    /// </summary>
    /// <seealso cref="Android.App.Activity" />
    [Activity(Label = "List of Subcategories", Icon = "@drawable/CSCLogo")]
    public class SubcategoryListActivity : Activity
    {
        private ListView _ListView;
        private List<string> _SubcategoryList;
        private string _categoryName;

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

            SetContentView(Resource.Layout.ListSubcategory);

            _ListView = FindViewById<ListView>(Resource.Id.lvListArea);

            // Get the passed categoryName
            _categoryName = Intent.GetStringExtra("categoryName") ?? "No Data Found";

            // Get unique List of all possible subcategories for the given categoryName
            _SubcategoryList = GetSubcategoryListUnique(_categoryName);

            // Set the custom adapter
            SubcategoryListAdapter adapter = new SubcategoryListAdapter(this, _SubcategoryList);
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

        /// <summary>
        /// Gets a unique List of all possible subcategories for the given categoryName.
        /// </summary>
        /// <param name="categoryName">Name of the category.</param>
        /// <returns>The sorted, unique list of subcategories for the given categoryName.</returns>
        private List<string> GetSubcategoryListUnique(string categoryName)
        {
            List<string> subcategoryList = new List<string>();

            foreach (var c in _handler.CategoryList)
            {
                if (c.Name == categoryName)
                {
                    // A category may have n number of subcategories
                    foreach (var sc in c.SubcategoryList)
                    {
                        subcategoryList.Add(sc);
                    }
                }
            }
            subcategoryList = subcategoryList.Distinct().ToList();
            subcategoryList.Sort();

            return subcategoryList;
        }

        private void _ListView_ItemClick(object sender, AdapterView.ItemClickEventArgs e)
        {
            var intent = new Intent(this, typeof(BusinessListActivity));
            intent.PutExtra("categoryName", _categoryName);
            intent.PutExtra("subcategoryName", _SubcategoryList[e.Position]);
            StartActivity(intent);
        }
    }
}