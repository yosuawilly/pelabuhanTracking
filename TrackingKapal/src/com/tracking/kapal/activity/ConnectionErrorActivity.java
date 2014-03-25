package com.tracking.kapal.activity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;

import com.tracking.kapal.R;
import com.tracking.kapal.StartUpActivity;
import com.tracking.kapal.activity.base.BaseActivity;

public class ConnectionErrorActivity extends BaseActivity implements OnClickListener{
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.connection_error_page);
		((Button) findViewById(R.id.retryBtn)).setOnClickListener(this);
	}

	@Override
	public void onClick(View v) {
		startActivity(new Intent(this, StartUpActivity.class));
		finish();
	}

}
