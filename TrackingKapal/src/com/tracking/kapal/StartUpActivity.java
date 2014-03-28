package com.tracking.kapal;

import org.json.JSONException;
import org.json.JSONObject;

import com.tracking.kapal.activity.ConnectionErrorActivity;
import com.tracking.kapal.activity.LoginActivity;
import com.tracking.kapal.activity.MainMenuActivity;
import com.tracking.kapal.database.PreferenceHelper;
import com.tracking.kapal.model.Kapal;
import com.tracking.kapal.restfull.AsyncTaskCompleteListener;
import com.tracking.kapal.restfull.CallWebServiceTask;
import com.tracking.kapal.util.Constant;
import com.tracking.kapal.util.Utility;

import android.os.Bundle;
import android.app.Activity;
import android.content.Intent;
import android.util.Log;
import android.view.Menu;

public class StartUpActivity extends Activity implements AsyncTaskCompleteListener<Object>{

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.start_up);
        
        checkDeviceForUsing();
        
//		Thread timer = new Thread(){
//			
//			@Override
//			public void run() {
//				try{
//					int time = 0;
//					while(time < 3000){
//						sleep(100);
//						time += 100;
//					}
//				}catch(Exception ex){
//					ex.printStackTrace();
//				} finally {
//					startActivity(new Intent(StartUpActivity.this, LoginActivity.class));
//					finish();
//				}
//			}
//			
//		};
//		
//		timer.start();
        
//        Intent intent = new Intent(this, LoginActivity.class);
//		startActivity(intent);
//		this.finish();
    }
    
    private void checkDeviceForUsing() {
    	PreferenceHelper helper = new PreferenceHelper(this, Constant.SETTING_KAPAL);
    	Kapal kapal = helper.getObject(Constant.KAPAL, Kapal.class);
    	
    	CallWebServiceTask task = new CallWebServiceTask(this, this, false);
    	String deviceId = Utility.getTokenId(this);
    	
    	if(kapal == null) {
    		task.execute(Constant.URL_DELETE_ACTIVE_DEVICE + deviceId, Constant.REST_GET, Constant.DELETE_ACTIVE_DEVICE);
    		
    	} else {
    		task.execute(Constant.URL_CHECK_ACTIVE_DEVICE + kapal.getKode_kapal()+"/"+deviceId, Constant.REST_GET, Constant.CHECK_ACTIVE_DEVICE);
    		
    	}
    }


    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        //getMenuInflater().inflate(R.menu.start_up, menu);
        return false;
    }

	@Override
	public void onTaskComplete(Object... params) {
		String result = (String) params[0];
		int idCaller = (Integer) params[1];
		
		Log.i("result", result);
		
		if(idCaller==Constant.DELETE_ACTIVE_DEVICE) {
			try {
				JSONObject jsonObject = new JSONObject(result);
				if(jsonObject.has("status")) {
					if(jsonObject.getBoolean("status")) {
						startActivity(new Intent(StartUpActivity.this, LoginActivity.class));
						finish();
						return;
					}
				}
				// error server
				startActivity(new Intent(this, ConnectionErrorActivity.class));
				finish();
			} catch (JSONException e) {
				e.printStackTrace();
				// error server
				startActivity(new Intent(this, ConnectionErrorActivity.class));
				finish();
			}
			
		} else if(idCaller==Constant.CHECK_ACTIVE_DEVICE) {
			try {
				JSONObject jsonObject = new JSONObject(result);
				if(jsonObject.has("status")) {
					new PreferenceHelper(this, Constant.SETTING_KAPAL).removePreference(Constant.KAPAL);
					startActivity(new Intent(StartUpActivity.this, LoginActivity.class));
					finish();
				} else if(jsonObject.has("errorCode")) {
					// error server
					startActivity(new Intent(this, ConnectionErrorActivity.class));
					finish();
				} else {
					startActivity(new Intent(StartUpActivity.this, MainMenuActivity.class));
					finish();
				}
			} catch (JSONException e) {
				e.printStackTrace();
				// error server
				startActivity(new Intent(this, ConnectionErrorActivity.class));
				finish();
			}
		}
	}
    
}
