package com.tracking.kapal.util;

import java.util.List;

import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.Bundle;
import android.os.Handler;

public class Gps{
	private volatile Location location;
	private LocationManager mlocManager;
	private LocationListener mlocListenerNetwork;
	private LocationListener mlocListenerGps;

	public Gps(LocationManager mlocManager) {
		this.mlocManager = mlocManager;
		this.mlocListenerNetwork = null;
		this.mlocListenerGps = null;
	}
	
	public LocationManager getLocationManager() {
		return mlocManager;
	}
	
	public boolean isLocationListenerAvailable() {
		return (mlocListenerNetwork != null) && (mlocListenerGps != null);
	}

	public Location getLocation() {
		if (location != null) {
			return location;
		}
		List<String> providers = mlocManager.getProviders(true);
		Location l = null;

		for (int i = providers.size() - 1; i >= 0; i--) {
			if (l == null) {
				l = mlocManager.getLastKnownLocation(providers.get(i));
			}
		}
		return l;
	}

	@SuppressWarnings("unused")
	public Location getMyLocationWait(Handler handler) {
		String locationProvider = null;
		/* Use the LocationManager class to obtain GPS locations */
		if (!mlocManager.isProviderEnabled(LocationManager.GPS_PROVIDER)) {
			locationProvider = LocationManager.GPS_PROVIDER;
		} else {
			locationProvider = LocationManager.NETWORK_PROVIDER;
		}

		mlocListenerNetwork = new MyLocationListener();
		mlocListenerGps = new MyLocationListener();

		handler.post(new Runnable() {
			@Override
			public void run() {
				mlocManager.requestLocationUpdates(LocationManager.NETWORK_PROVIDER, 0,	0, mlocListenerNetwork);
				mlocManager.requestLocationUpdates(LocationManager.GPS_PROVIDER, 0,	0, mlocListenerGps);
			}
		});
		
		return location;
	}

	public void stopLocationUpdate() {
		if (mlocListenerNetwork != null)
			mlocManager.removeUpdates(mlocListenerNetwork);
		if (mlocListenerGps != null)
			mlocManager.removeUpdates(mlocListenerGps);
		mlocListenerNetwork = null;
		mlocListenerGps = null;
	}

	/* Class My Location Listener */
	public class MyLocationListener implements LocationListener {
		@Override
		public void onLocationChanged(Location loc) {
			location = loc;
			stopLocationUpdate();
		}

		@Override
		public void onProviderDisabled(String arg0) {
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

	}/* End of Class MyLocationListener */
}