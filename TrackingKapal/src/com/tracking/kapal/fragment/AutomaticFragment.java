package com.tracking.kapal.fragment;

import com.actionbarsherlock.app.SherlockFragment;
import com.tracking.kapal.R;
import com.tracking.kapal.listener.FragmentListener;
import com.tracking.kapal.service.GetLocationService;
import com.tracking.kapal.util.Utility;

import android.annotation.SuppressLint;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.Button;

@SuppressLint("ValidFragment")
public class AutomaticFragment extends SherlockFragment implements OnClickListener{
	
	private Context context;
	private ViewGroup viewGroup;
	@SuppressWarnings("unused")
	private FragmentListener fragmentListener;
	
	public AutomaticFragment() {
		// TODO Auto-generated constructor stub
	}
	
	public AutomaticFragment(Context context, FragmentListener fragmentListener) {
		this.context = context;
		this.fragmentListener = fragmentListener;
	}
	
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
	}
	
	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
		if(viewGroup==null)
		viewGroup = (ViewGroup) inflater.inflate(R.layout.automatic_layout, container, false);
		
		return viewGroup;
	}
	
	@Override
	public void onViewCreated(View view, Bundle savedInstanceState) {
		super.onViewCreated(view, savedInstanceState);
		
		Button buttonTracking = (Button) viewGroup.findViewById(R.id.button_auto_tracking); 
		buttonTracking.setOnClickListener(this);
		if(Utility.isServiceRunning(context, GetLocationService.class.getName())) {
			buttonTracking.setText("Matikan Auto Tracking");
		} else {
			buttonTracking.setText("Aktifkan Auto Tracking");
		}
	}
	
	@Override
	public void onDestroyView() {
		super.onDestroyView();
		ViewGroup parentViewGroup = (ViewGroup) viewGroup.getParent();
		if(parentViewGroup != null) parentViewGroup.removeView(viewGroup);
	}

	@Override
	public void onClick(View v) {
		if(v.getId() == R.id.button_auto_tracking) {
			if(((Button)v).getText().toString().equals("Aktifkan Auto Tracking")) {
				context.startService(new Intent(GetLocationService.GetLocationService));
				((Button)v).setText("Matikan Auto Tracking");
			} else {
				context.sendBroadcast(new Intent(GetLocationService.ACTION_SHUTDOWN_SERVICE));
				//context.stopService(new Intent(GetLocationService.GetLocationService));
				((Button)v).setText("Aktifkan Auto Tracking");
			}
		}
	}
	
}
