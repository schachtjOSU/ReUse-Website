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
using Android.Support.Fragment;



namespace CRRD.Resources.Activities
{
    /// <summary>
    /// Android Activity: Used for displaying the The Google Map Fragment populated by the user's current location and any business location map markers.
    /// </summary>
    /// <seealso cref="Android.App.Activity" />
    /// <seealso cref="Android.Gms.Maps.IOnMapReadyCallback" />
    [Activity(Label = "@string/MapViewerActivityLabel", Icon = "@drawable/CSCLogo")]
    public class MapPRACTICEActivity : Activity//, IOnMapReadyCallback
    {
        private GoogleMap _Map;

        /// <summary>
        /// Called when [create].
        /// </summary>
        /// <param name="bundle">The bundle.</param>
        protected override void OnCreate(Bundle bundle)
        {


            base.OnCreate(bundle);
            SetContentView(Resource.Layout.mapPRACTICE);

            //FragmentManager.FindFragmentById<MapFragment>(Resource.Id.mapPRACTICE).GetMapAsync(this);

        }




        /*
        /// <summary>
        /// Called when [map ready]. Populates the map with requested markers and canters the map on Corvallis at the city level.
        /// </summary>
        /// <param name="map">The google map.</param>
        public void OnMapReady(GoogleMap map)
        {


            LatLng sydney = new LatLng(-33.867, 151.206);
            
            map.MoveCamera(CameraUpdateFactory.NewLatLngZoom(sydney, 13));
            /*
            map.addMarker(new MarkerOptions()
                    .title("Sydney")
                    .snippet("The most populous city in Australia.")
                    .position(sydney));

    
        }*/
    }
}
