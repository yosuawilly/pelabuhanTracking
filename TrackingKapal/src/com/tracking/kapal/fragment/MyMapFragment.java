package com.tracking.kapal.fragment;

import com.actionbarsherlock.app.SherlockFragment;
import com.google.android.gms.maps.CameraUpdate;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.GoogleMap.OnMyLocationButtonClickListener;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.BitmapDescriptorFactory;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;
import com.tracking.kapal.R;
import com.tracking.kapal.listener.FragmentListener;
import com.tracking.kapal.util.Constant;
import com.tracking.kapal.util.Gps;
import android.annotation.SuppressLint;
import android.content.Context;
import android.location.Criteria;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.ImageButton;
import android.widget.Toast;

@SuppressLint("ValidFragment") 
public class MyMapFragment extends SherlockFragment implements OnClickListener, OnMyLocationButtonClickListener, LocationListener{
	
	private Context context;
	private ViewGroup viewGroup;
	private FragmentListener fragmentListener;
	
	private GoogleMap googleMap;
	private ImageButton locationButton;
	
	LocationManager locationManager;
	String locationProvider;
	Marker marker;
	
	public MyMapFragment() {
		// TODO Auto-generated constructor stub
	}
	
	public MyMapFragment(Context context, FragmentListener fragmentListener) {
		this.context = context;
		this.fragmentListener = fragmentListener;
	}
	
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
	}
	
	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
		if(viewGroup==null)
		viewGroup = (ViewGroup) inflater.inflate(R.layout.map_layout, container, false);
		
		return viewGroup;
	}
	
	@Override
	public void onViewCreated(View view, Bundle savedInstanceState) {
		super.onViewCreated(view, savedInstanceState);
		
		locationButton = (ImageButton) view.findViewById(R.id.myMapLocationButton);
		locationButton.setOnClickListener(this);
		
		try {
            // Loading map
            initilizeMap();
            initializeLocationManager();
 
        } catch (Exception e) {
            e.printStackTrace();
        }
	}
	
	private void initilizeMap() {
        if (googleMap == null) {
            googleMap = ((SupportMapFragment) getFragmentManager().findFragmentById(R.id.map)).getMap();
 
            // check if map is created successfully or not
            if (googleMap == null) {
                Toast.makeText(context, "Sorry! unable to create maps", Toast.LENGTH_SHORT).show();
            } else {
//            	googleMap.getUiSettings().setMyLocationButtonEnabled(true);
//            	googleMap.setMyLocationEnabled(true);
//            	googleMap.setOnMyLocationButtonClickListener(this);
            }
        }
    }
	
	@Override
	public void onDestroyView() {
		super.onDestroyView();
		if(locationManager!=null) locationManager.removeUpdates(this);
		
		ViewGroup parentViewGroup = (ViewGroup) viewGroup.getParent();
		if(parentViewGroup != null) parentViewGroup.removeView(viewGroup);
		
//		Fragment fragment = getFragmentManager().findFragmentById(R.id.map);
//		if(fragment!=null){
//			getFragmentManager().beginTransaction().remove(fragment).commit();
//			Log.i("removeFragment", "run");
//		}
	}
	
    private void initializeLocationManager() {
		
		//get the location manager
		this.locationManager = (LocationManager) context.getSystemService(Context.LOCATION_SERVICE);
		Location location = null;
		
		boolean gpsIsEnabled = locationManager.isProviderEnabled(LocationManager.GPS_PROVIDER);
        boolean networkIsEnabled = locationManager.isProviderEnabled(LocationManager.NETWORK_PROVIDER);
         
        if(gpsIsEnabled)
        {
            locationManager.requestLocationUpdates(LocationManager.GPS_PROVIDER, Constant.INTERVAL_TIME_UPDATE_LOCATION, Constant.DISTANCE_CHANGE_FOR_UPDATE_LOCATION, this);
            location = locationManager.getLastKnownLocation(LocationManager.GPS_PROVIDER);
        }
        else if(networkIsEnabled)
        {
            locationManager.requestLocationUpdates(LocationManager.NETWORK_PROVIDER, Constant.INTERVAL_TIME_UPDATE_LOCATION, Constant.DISTANCE_CHANGE_FOR_UPDATE_LOCATION, this);
            location = locationManager.getLastKnownLocation(LocationManager.NETWORK_PROVIDER);
        }
        else
        {
        	//define the location manager criteria
    		Criteria criteria = new Criteria();
    		
    		this.locationProvider = locationManager.getBestProvider(criteria, false);
    		this.locationManager.requestLocationUpdates(this.locationProvider, Constant.INTERVAL_TIME_UPDATE_LOCATION, Constant.DISTANCE_CHANGE_FOR_UPDATE_LOCATION, this);
    		
    		location = locationManager.getLastKnownLocation(locationProvider);
    		
        	Toast.makeText(context, "No GPS enable", Toast.LENGTH_LONG).show();
            //Show an error dialog that GPS is disabled...
        }
		
		
		//initialize the location
		if(location != null) {
		    onLocationChanged(location);
		}
	}
    
    protected MarkerOptions initMarker(LatLng position) {
    	return new MarkerOptions().position(position)
    			.title("Test").icon(BitmapDescriptorFactory.fromResource(R.drawable.ship2))
    			.snippet("The last location");
    }

	@Override
	public boolean onMyLocationButtonClick() {
		Toast.makeText(context, "My Location Click", Toast.LENGTH_LONG).show();
		return false;
	}

	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.myMapLocationButton:
			Location location = new Gps(locationManager).getLocation();
			if(location!=null) {
				onLocationChanged(location);
			}
//			if(Utility.checkGpsEnable(context)){
//				Toast.makeText(context, "GPS Enable", Toast.LENGTH_LONG).show();
//			} else {
//				Toast.makeText(context, "GPS not Enable", Toast.LENGTH_LONG).show();
//			}
			break;
		default:
			break;
		}
	}

	@Override
	public void onLocationChanged(Location location) {
		
		//when the location changes, update the map by zooming to the location
		CameraUpdate center = CameraUpdateFactory.newLatLng(new LatLng(location.getLatitude(),location.getLongitude()));
		this.googleMap.moveCamera(center);
		//this.googleMap.animateCamera(center);
		
		CameraUpdate zoom=CameraUpdateFactory.zoomTo(15);
		this.googleMap.animateCamera(zoom);
		
		if(marker==null) {
			marker = googleMap.addMarker(initMarker(new LatLng(location.getLatitude(), location.getLongitude())));
		} else {
			marker.setPosition(new LatLng(location.getLatitude(),location.getLongitude()));
		}
		
	}

	@Override
	public void onProviderDisabled(String provider) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onProviderEnabled(String provider) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onStatusChanged(String provider, int status, Bundle extras) {
		// TODO Auto-generated method stub
		
	}

}
