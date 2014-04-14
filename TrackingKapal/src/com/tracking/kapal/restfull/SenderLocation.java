package com.tracking.kapal.restfull;

import org.json.JSONException;
import org.json.JSONObject;

import com.tracking.kapal.database.PreferenceHelper;
import com.tracking.kapal.model.Kapal;
import com.tracking.kapal.util.Constant;

import android.content.Context;
import android.location.Location;
import android.util.Log;
import android.widget.Toast;

public class SenderLocation {
	
	public static void sendLocationToServer(final Context context, Location location) {
		Kapal kapal = new PreferenceHelper(context, Constant.SETTING_KAPAL).getObject(Constant.KAPAL, Kapal.class);
		CallWebServiceTask task = new CallWebServiceTask(context, new AsyncTaskCompleteListener<Object>() {
			
			@Override
			public void onTaskComplete(Object... params) {
				String result = (String) params[0];
				Log.i("resultSendLocation", result);
				
				try {
					JSONObject jsonObject = new JSONObject(result);
					if(jsonObject.has("status")) {
						if(jsonObject.getBoolean("status")) {
							Toast.makeText(context, "Kordinat Terkirim", Toast.LENGTH_LONG).show();
							return;
						}
					}
					Toast.makeText(context, "Kordinat Gagal Terkirim", Toast.LENGTH_LONG).show();
				} catch (JSONException e) {
					Toast.makeText(context, "Kordinat Gagal Terkirim", Toast.LENGTH_LONG).show();
					e.printStackTrace();
				}
			}
		}, false);
		
		if(kapal!=null && location!=null) {
			//task.execute(Constant.URL_SEND_LOCATION + kapal.getNama_kapal()+"/"+location.getLatitude()+"/"+location.getLongitude(), Constant.REST_GET);
			task.execute(Constant.URL_SEND_LOCATION + kapal.getKode_kapal() + "/" + kapal.getNama_kapal()+"/"+location.getLatitude()+"/"+location.getLongitude(), Constant.REST_GET);
		}
	}

}
