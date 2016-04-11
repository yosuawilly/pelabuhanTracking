package com.tracking.kapal.fragment;

import android.annotation.SuppressLint;
import android.content.Context;
import android.location.Location;
import android.location.LocationManager;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.Button;

import com.actionbarsherlock.app.SherlockFragment;
import com.tracking.kapal.R;
import com.tracking.kapal.listener.FragmentListener;
import com.tracking.kapal.restfull.SenderLocation;
import com.tracking.kapal.util.Gps;

@SuppressLint("ValidFragment")
public class ManualFragment extends SherlockFragment implements OnClickListener{
	
	private Context context;
	private ViewGroup viewGroup;
	@SuppressWarnings("unused")
	private FragmentListener fragmentListener;
	private LocationManager locationManager;
	
	public ManualFragment() {
		// TODO Auto-generated constructor stub
	}
	
	public ManualFragment(Context context, FragmentListener fragmentListener) {
		this.context = context;
		this.fragmentListener = fragmentListener;
	}
	
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		locationManager = (LocationManager) context.getSystemService(Context.LOCATION_SERVICE);
	}
	
	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
		if(viewGroup==null)
		viewGroup = (ViewGroup) inflater.inflate(R.layout.manual_layout, container, false);
		//Log.i("onCreateview", "run");
		return viewGroup;
	}
	
	@Override
	public void onViewCreated(View view, Bundle savedInstanceState) {
		super.onViewCreated(view, savedInstanceState);
		
		((Button) viewGroup.findViewById(R.id.button_manual)).setOnClickListener(this);
	}
	
	@Override
	public void onDestroyView() {
		super.onDestroyView();
		ViewGroup parentViewGroup = (ViewGroup) viewGroup.getParent();
		if(parentViewGroup != null) parentViewGroup.removeView(viewGroup);
	}

	@Override
	public void onClick(View v) {
		if(v.getId() == R.id.button_manual) {
			Location location = new Gps(locationManager).getLocation();
			SenderLocation.sendLocationToServer(context, location);
			System.gc();
		}
	}
	
}
