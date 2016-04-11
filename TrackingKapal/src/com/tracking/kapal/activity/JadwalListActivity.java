package com.tracking.kapal.activity;

import java.util.List;

import android.widget.ListView;

import com.tracking.kapal.R;
import com.tracking.kapal.activity.base.BaseMyActionBarActivity;
import com.tracking.kapal.adapter.JadwalListAdapter;
import com.tracking.kapal.model.Schedule;

public class JadwalListActivity extends BaseMyActionBarActivity {
	
	private ListView listView;
	
	private List<Schedule> schedules;
	
	@Override
	public void initBundle() {
		super.initBundle();
		
		schedules = getIntent().getParcelableArrayListExtra("schedule");
	}
	
	@Override
	public void initDesign() {
		super.initDesign();
		getSupportActionBar().hide();
		
		listView = (ListView) findViewById(android.R.id.list);
		JadwalListAdapter adapter = new JadwalListAdapter(this, schedules);
		listView.setAdapter(adapter);
	}

	@Override
	public int getLayoutId() {
		return R.layout.jadwal_list_activity_layout;
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

}
