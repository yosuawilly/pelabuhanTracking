package com.tracking.kapal.adapter;

import java.text.SimpleDateFormat;
import java.util.List;

import com.tracking.kapal.R;
import com.tracking.kapal.database.PreferenceHelper;
import com.tracking.kapal.model.Schedule;
import com.tracking.kapal.restfull.AsyncTaskCompleteListener;
import com.tracking.kapal.restfull.CallWebServiceTask;
import com.tracking.kapal.util.Constant;
import com.tracking.kapal.util.Utility;

import android.annotation.SuppressLint;
import android.app.Activity;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.TextView;

@SuppressLint("SimpleDateFormat")
public class JadwalListAdapter extends ArrayAdapter<Schedule> implements AsyncTaskCompleteListener<Object> {
	
	private SimpleDateFormat dateFormat = new SimpleDateFormat(Constant.DATE_FORMAT2);
	
	private Schedule selected = null;

	public JadwalListAdapter(Context context, List<Schedule> schedules) {
		super(context, R.layout.list_item_layout, schedules);
	}
	
	@Override
	public View getView(int position, View convertView, ViewGroup parent) {
		View v = convertView;
		if(v == null) {
			v = ((LayoutInflater) getContext().getSystemService(Context.LAYOUT_INFLATER_SERVICE)).
					inflate(R.layout.list_item_layout, null);
		}
		
		final Schedule s = getItem(position);
		
		((TextView) v.findViewById(R.id.tujuanTV)).setText(s.getDari() + " - " + s.getKe());
		((TextView) v.findViewById(R.id.berangkatTV)).setText(dateFormat.format(s.getJadwal_berangkat()));
		((TextView) v.findViewById(R.id.datangTV)).setText(dateFormat.format(s.getJadwal_datang()));
		
		((Button) v.findViewById(R.id.button_berangkat)).setOnClickListener(new View.OnClickListener() {
			
			@Override
			public void onClick(View v) {
				selected = s;
				
				CallWebServiceTask task = new CallWebServiceTask(getContext(), JadwalListAdapter.this);
				task.execute(Constant.URL_START_STOP_SCHEDULE + s.getId(), Constant.REST_GET);
			}
		});
		
		return v;
	}

	@Override
	public void onTaskComplete(Object... params) {
		String result = (String) params[0];
		
		if (Utility.cekValidResult(result, (Activity) getContext())) {
			new PreferenceHelper(getContext(), Constant.SETTING_KAPAL).saveObject(Constant.SCHEDULE, selected);
			
			((Activity) getContext()).finish();
		}
	}
	
}
