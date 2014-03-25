package com.tracking.kapal.restfull;

import com.tracking.kapal.database.PreferenceHelper;
import com.tracking.kapal.model.Kapal;
import com.tracking.kapal.util.Constant;

import android.content.Context;
import android.location.Location;
import android.util.Log;

public class SenderLocation {
	
	public static void sendLocationToServer(Context context, Location location) {
		Kapal kapal = new PreferenceHelper(context, Constant.SETTING_KAPAL).getObject(Constant.KAPAL, Kapal.class);
		CallWebServiceTask task = new CallWebServiceTask(context, new AsyncTaskCompleteListener<Object>() {
			
			@Override
			public void onTaskComplete(Object... params) {
				String result = (String) params[0];
				Log.i("resultSendLocation", result);
			}
		}, false);
		
		if(kapal!=null && location!=null) {
			task.execute(Constant.URL_SEND_LOCATION + kapal.getNama_kapal()+"/"+location.getLatitude()+"/"+location.getLongitude(), Constant.REST_GET);
		}
	}

}
