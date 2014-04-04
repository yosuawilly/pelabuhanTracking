package com.tracking.kapal.service;

import com.tracking.kapal.R;
import com.tracking.kapal.activity.MainMenuActivity;
import com.tracking.kapal.listener.MyLocationListener;
import com.tracking.kapal.util.Constant;

import android.app.Notification;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.app.Service;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.location.LocationManager;
import android.os.Binder;
import android.os.IBinder;
import android.util.Log;
import android.widget.Toast;

public class GetLocationService extends Service {
	
	public static final String GetLocationService = "com.tracking.kapal.service.GetLocationService";
	
	public static final String ACTION_SHUTDOWN_SERVICE = "ACTION_SHUTDOWN_SERVICE";
	
	private NotificationManager mNM;
	private final IBinder mBinder = new LocalBinder();
	private MyLocationListener myLocationListener = new MyLocationListener(this);
	private LocationManager locationManager;
	
	@Override
	public void onCreate() {
		super.onCreate();
		mNM = (NotificationManager)getSystemService(NOTIFICATION_SERVICE);
		showNotification();
		
		locationManager = (LocationManager) getSystemService(Context.LOCATION_SERVICE);
		locationManager.requestLocationUpdates(LocationManager.NETWORK_PROVIDER, Constant.INTERVAL_TIME_UPDATE_LOCATION, Constant.DISTANCE_CHANGE_FOR_UPDATE_LOCATION, myLocationListener);
	    locationManager.requestLocationUpdates(LocationManager.GPS_PROVIDER, Constant.INTERVAL_TIME_UPDATE_LOCATION, Constant.DISTANCE_CHANGE_FOR_UPDATE_LOCATION, myLocationListener);
		
		registerReceiver(shutDownServiceReceiver, new IntentFilter(ACTION_SHUTDOWN_SERVICE));
		
		Toast.makeText(this, "LocationService Started", Toast.LENGTH_LONG).show();
	}
	
	@Override
	public void onStart(Intent intent, int startId) {
		super.onStart(intent, startId);
	}
	
	@Override
	public int onStartCommand(Intent intent, int flags, int startId) {
//		myLocationListener = new MyLocationListener(this);
//		locationManager = (LocationManager) getSystemService(Context.LOCATION_SERVICE);
//		locationManager.requestLocationUpdates(LocationManager.NETWORK_PROVIDER, Constant.INTERVAL_TIME_UPDATE_LOCATION, Constant.DISTANCE_CHANGE_FOR_UPDATE_LOCATION, myLocationListener);
//	    locationManager.requestLocationUpdates(LocationManager.GPS_PROVIDER, Constant.INTERVAL_TIME_UPDATE_LOCATION, Constant.DISTANCE_CHANGE_FOR_UPDATE_LOCATION, myLocationListener);
	    
	    Log.i("onStart", "run");
	    
		return START_REDELIVER_INTENT;
	}
	
	@Override
	public void onDestroy() {
		locationManager.removeUpdates(myLocationListener);
		mNM.cancel(Constant.NOTIFICATION_LOCATION);
		unregisterReceiver(shutDownServiceReceiver);
		Toast.makeText(this, "LocationService stoped", Toast.LENGTH_LONG).show();
		
		super.onDestroy();
	}

	@Override
	public IBinder onBind(Intent intent) {
		return mBinder;
	}
	
	private void showNotification() {
      // In this sample, we'll use the same text for the ticker and the expanded notification
      CharSequence text = Constant.NOTIFICATION_NAME;

      // Set the icon, scrolling text and timestamp
      Notification notification = new Notification(R.drawable.kemudi2, text,
              System.currentTimeMillis());
      notification.flags |= Notification.FLAG_ONGOING_EVENT;

      // The PendingIntent to launch our activity if the user selects this notification
      PendingIntent contentIntent = PendingIntent.getActivity(this, 0,
              new Intent(this, MainMenuActivity.class), 0);

      // Set the info for the views that show in the notification panel.
      notification.setLatestEventInfo(this, Constant.NOTIFICATION_NAME,
                     text, contentIntent);

      // Send the notification.
      mNM.notify(Constant.NOTIFICATION_LOCATION, notification);
  }
	
	public class LocalBinder extends Binder {
        GetLocationService getService() {
            return GetLocationService.this;
        }
    }
	
	BroadcastReceiver shutDownServiceReceiver = new BroadcastReceiver() {
		
		@Override
		public void onReceive(Context context, Intent intent) {
			GetLocationService.this.stopSelf();
			//startService(new Intent(GetLocationService.this, GetLocationService.class));
			//stopService(new Intent(GetLocationService.this, GetLocationService.class));
		}
	};

}
