using Android.App;
using Android.Content;
using Android.Gms.Maps;
using Android.Gms.Maps.Model;
using Android.OS;
using CRRD.Resources.Models;
using System;
using System.Collections.Generic;
using System.Linq;
using CRRD.Resources.Adapters;
using Android.Support.V4.App;
using Android.Support.V7.App;
using Toolbar = Android.Support.V7.Widget.Toolbar;
using Android.Views;


namespace CRRD.Resources.Activities
{
    /// <summary>
    /// Android Activity: Used for displaying the The Google Map Fragment populated by the user's current location and any business location map markers.
    /// </summary>
    /// <seealso cref="Android.App.Activity" />
    /// <seealso cref="Android.Gms.Maps.IOnMapReadyCallback" />
    [Activity(Label = "@string/MapViewerActivityLabel", Icon = "@drawable/CSCLogo")]
    public class MapViewerActivity : AppCompatActivity, IOnMapReadyCallback
    {
        private GoogleMap _Map;
        private IEnumerable<Business> _businessList = new List<Business>();
        private string _businessName, _categoryName, _subcategoryName;
        private LatLng _Corvallis;

        // Start class to Get and parse the local XML file to the associated classes (Business & Category)
        private DataHandler _handler = new DataHandler();

        /// <summary>
        /// Called when [create].
        /// </summary>
        /// <param name="bundle">The bundle.</param>
        protected override void OnCreate(Bundle bundle)
        {
            ErrorCheckActivity.checkDataHandlerInitialization(this.ApplicationContext, _handler.isInitialized);

            base.OnCreate(bundle);
            SetContentView(Resource.Layout.MapViewer);

            //Set the toolbar
            var toolbar = FindViewById<Toolbar>(Resource.Id.toolbar);
            SetSupportActionBar(toolbar);
            SupportActionBar.Title = this.ApplicationContext.GetString(Resource.String.ApplicationName);

            //get the coordinates for Corvallis
            _Corvallis = new LatLng(Double.Parse(this.ApplicationContext.GetString(Resource.String.CorvallisLat)), Double.Parse(this.ApplicationContext.GetString(Resource.String.CorvallisLong)));

            // Get the passed categoryName
            _businessName = Intent.GetStringExtra("businessName") ?? "No Data Found";
            _categoryName = Intent.GetStringExtra("categoryName") ?? "No Data Found";
            _subcategoryName = Intent.GetStringExtra("subcategoryName") ?? "No Data Found";

            GetBusinessList(_businessName, _categoryName, _subcategoryName);

            SetUpMap();
        }

        /// <summary>
        /// Gets the list of all possible business objects for a given categoryName and subcategoryName combination key.
        /// Populates the global List(Business), _businessList.
        /// </summary>
        /// <param name="businessName">Name of the business.</param>
        /// <param name="categoryName">Name of the category.</param>
        /// <param name="subcategoryName">Name of the subcategory.</param>
        private void GetBusinessList(string businessName, string categoryName, string subcategoryName)
        {
            // businessName = "No Data Found" when a List of business is requested (not 1 specific business)
            if (businessName == "No Data Found")
            {
                _businessList = _handler.BusinessList.Where
                                        (
                                        x => x.CategoryList.Any(y => y.Name == categoryName &&
                                        y.SubcategoryList.Contains(subcategoryName))
                                        );
            }
            // this will find 1 specific business in the list
            else
            {
                ((List<Business>)_businessList).Add(_handler.BusinessList.Single(b => b.Name == businessName));
            }
        }

        /// <summary>
        /// Starts up an instance of Google Maps
        /// </summary>
        private void SetUpMap()
        {
            if (_Map == null)
            {
                FragmentManager.FindFragmentById<MapFragment>(Resource.Id.map).GetMapAsync(this);
                /* 
                MapFragment _mapFragment = MapFragment.NewInstance();
                _mapFragment.GetMapAsync(this);
                Android.App.FragmentTransaction _transaction = FragmentManager.BeginTransaction();
                _transaction.Add(Resource.Id.map_parent, _mapFragment);
                _transaction.Commit();
                */
                
                

            }
        }

        /// <summary>
        /// Called when [map ready]. Populates the map with requested markers and canters the map on Corvallis at the city level.
        /// </summary>
        /// <param name="googleMap">The google map.</param>
        public void OnMapReady(GoogleMap googleMap)
        {
            // loads the googlemap passed into the global instance
            _Map = googleMap;

            // Show the current location
            _Map.MyLocationEnabled = true;


            // Get the Camera to focus and zoom to the location
            /* ===== Note on Zoom =====
                1: World
                5: Landmass/continent
                10: City
                15: Streets
                20: Buildings
            */
            CameraUpdate camera = CameraUpdateFactory.NewLatLngZoom(_Corvallis, Int32.Parse(this.ApplicationContext.GetString(Resource.String.CorvallisZoomLevel)));
            _Map.MoveCamera(camera);

            // Set markers from the bussinessList
            foreach (var business in _businessList)
            {
                _Map.AddMarker(new MarkerOptions()
                    .SetPosition(new LatLng(business.Latitude, business.Longitude))
                    .SetTitle(business.Name)
                    );
            }
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
            else
            {
                return base.OnOptionsItemSelected(item);
            }


        }
    }
}
