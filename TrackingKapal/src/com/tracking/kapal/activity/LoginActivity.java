package com.tracking.kapal.activity;

import com.tracking.kapal.R;
import com.tracking.kapal.util.Utility;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;

public class LoginActivity extends Activity implements OnClickListener{
	
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
				startActivity(new Intent(this, MainMenuActivity.class));
				finish();
			}
		}
	}

}
