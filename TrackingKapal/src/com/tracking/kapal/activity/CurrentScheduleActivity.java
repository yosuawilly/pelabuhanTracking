package com.tracking.kapal.activity;

import java.text.SimpleDateFormat;

import android.annotation.SuppressLint;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.TextView;

import com.tracking.kapal.R;
import com.tracking.kapal.activity.base.BaseMyActionBarActivity;
import com.tracking.kapal.database.PreferenceHelper;
import com.tracking.kapal.model.Schedule;
import com.tracking.kapal.restfull.AsyncTaskCompleteListener;
import com.tracking.kapal.restfull.CallWebServiceTask;
import com.tracking.kapal.util.Constant;
import com.tracking.kapal.util.Utility;

@SuppressLint("SimpleDateFormat")
public class CurrentScheduleActivity extends BaseMyActionBarActivity 
	implements OnClickListener, AsyncTaskCompleteListener<Object> {
	
	private SimpleDateFormat dateFormat = new SimpleDateFormat(Constant.DATE_FORMAT2);
	
	private Schedule s = null;
	
	@Override
	public void initDesign() {
		super.initDesign();
		getSupportActionBar().hide();
		
		s = new PreferenceHelper(this, Constant.SETTING_KAPAL).
				getObject(Constant.SCHEDULE, Schedule.class);
		
		((TextView) findViewById(R.id.tujuanTV)).setText(s.getDari() + " - " + s.getKe());
		((TextView) findViewById(R.id.berangkatTV)).setText(dateFormat.format(s.getJadwal_berangkat()));
		((TextView) findViewById(R.id.datangTV)).setText(dateFormat.format(s.getJadwal_datang()));
		
		((Button) findViewById(R.id.button_datang)).setOnClickListener(this);
	}

	@Override
	public int getLayoutId() {
		return R.layout.current_schedule_layout;
	}

	@Override
	public int getIdViewToAppendFromInflate() {
		// TODO Auto-generated method stub
		return 0;
	}

	@Override
	public int getIdViewToInflate() {
		// TODO Auto-generated method stub
		return 0;
	}

	@Override
	public void onClick(View v) {
		CallWebServiceTask task = new CallWebServiceTask(this, this);
		task.execute(Constant.URL_START_STOP_SCHEDULE + s.getId() + "/0", Constant.REST_GET);
	}

	@Override
	public void onTaskComplete(Object... params) {
		String result = (String) params[0];
		
		if (Utility.cekValidResult(result, this)) {
			new PreferenceHelper(this, Constant.SETTING_KAPAL).removePreference(Constant.SCHEDULE);
			
			finish();
		}
	}

}
