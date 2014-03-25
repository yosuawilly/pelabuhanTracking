package com.tracking.kapal.listener;

import com.tracking.kapal.restfull.SenderLocation;

import android.content.Context;
import android.location.Location;
import android.location.LocationListener;
import android.os.Bundle;
import android.widget.Toast;

public class MyLocationListener implements LocationListener{
	
	private Context context;
	
	public MyLocationListener(Context context) {
		this.context = context;
	}

	@Override
	public void onLocationChanged(Location location) {
		SenderLocation.sendLocationToServer(context, location);
		Toast.makeText(context, String.valueOf(location.getLatitude() + " " + location.getLongitude()), Toast.LENGTH_LONG).show();
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
