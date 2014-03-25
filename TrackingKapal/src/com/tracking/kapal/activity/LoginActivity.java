package com.tracking.kapal.activity;

import java.lang.reflect.Type;

import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;
import com.tracking.kapal.R;
import com.tracking.kapal.database.PreferenceHelper;
import com.tracking.kapal.model.Kapal;
import com.tracking.kapal.restfull.AsyncTaskCompleteListener;
import com.tracking.kapal.restfull.CallWebServiceTask;
import com.tracking.kapal.util.Constant;
import com.tracking.kapal.util.Utility;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;

public class LoginActivity extends Activity implements OnClickListener, AsyncTaskCompleteListener<Object>{
	
	private EditText namaKapalEdit;
	private Button buttonLogin;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.login_page);
		
		initDesignView();
	}
	
	private void initDesignView() {
		namaKapalEdit = (EditText) findViewById(R.id.namaKapalEdit);
		buttonLogin = (Button) findViewById(R.id.button_login);
		
		buttonLogin.setOnClickListener(this);
	}

	@Override
	public void onClick(View v) {
		if(v.getId() == R.id.button_login) {
			String namaKapal = namaKapalEdit.getText().toString().trim();
			if(namaKapal.equals("")){
				Utility.showMessage(this, "Tutup", getResources().getString(R.string.error_emptyNamaKapal));
				return;
			} else {
				String deviceId = Utility.getTokenId(this);
				CallWebServiceTask task = new CallWebServiceTask(this, this);
				task.execute(Constant.URL_ACTIVATION_DEVICE + namaKapal+"/"+deviceId, Constant.REST_GET);
				
				//startActivity(new Intent(this, MainMenuActivity.class));
				//finish();
			}
		}
	}

	@Override
	public void onTaskComplete(Object... params) {
		String result = (String) params[0];
		if(Utility.cekValidResult(result, this)) {
			Kapal kapal = new Gson().fromJson(result, new TypeToken<Kapal>(){}.getType());
			new PreferenceHelper(this, Constant.SETTING_KAPAL).saveObject(Constant.KAPAL, kapal);
			
			startActivity(new Intent(this, MainMenuActivity.class));
			finish();
		}
	}

}
