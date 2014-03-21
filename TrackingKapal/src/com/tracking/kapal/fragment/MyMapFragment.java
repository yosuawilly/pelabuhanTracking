package com.tracking.kapal.fragment;

import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.GoogleMap.OnMyLocationButtonClickListener;
import com.google.android.gms.maps.SupportMapFragment;
import com.tracking.kapal.R;
import com.tracking.kapal.listener.FragmentListener;
import com.tracking.kapal.util.Utility;

import android.annotation.SuppressLint;
import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.location.LocationManager;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.ImageButton;
import android.widget.Toast;

@SuppressLint("ValidFragment") 
public class MyMapFragment extends Fragment implements OnClickListener, OnMyLocationButtonClickListener{
	
	private Context context;
	private ViewGroup viewGroup;
	private FragmentListener fragmentListener;
	
	private GoogleMap googleMap;
	private ImageButton locationButton;
	
	public MyMapFragment() {
		// TODO Auto-generated constructor stub
	}
	
	public MyMapFragment(Context context, FragmentListener fragmentListener) {
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
		viewGroup = (ViewGroup) inflater.inflate(R.layout.map_layout, container, false);
		
		return viewGroup;
	}
	
	@Override
	public void onViewCreated(View view, Bundle savedInstanceState) {
		super.onViewCreated(view, savedInstanceState);
		
		locationButton = (ImageButton) view.findViewById(R.id.myMapLocationButton);
		locationButton.setOnClickListener(this);
		
		try {
            // Loading map
            initilizeMap();
 
        } catch (Exception e) {
            e.printStackTrace();
        }
	}
	
	private void initilizeMap() {
        if (googleMap == null) {
            googleMap = ((SupportMapFragment) getFragmentManager().findFragmentById(R.id.map)).getMap();
 
            // check if map is created successfully or not
            if (googleMap == null) {
                Toast.makeText(context, "Sorry! unable to create maps", Toast.LENGTH_SHORT).show();
            } else {
//            	googleMap.getUiSettings().setMyLocationButtonEnabled(true);
//            	googleMap.setMyLocationEnabled(true);
//            	googleMap.setOnMyLocationButtonClickListener(this);
            }
        }
    }
	
	@Override
	public void onDestroyView() {
		super.onDestroyView();
		ViewGroup parentViewGroup = (ViewGroup) viewGroup.getParent();
		if(parentViewGroup != null) parentViewGroup.removeView(viewGroup);
		
		Fragment fragment = getFragmentManager().findFragmentById(R.id.map);
		if(fragment!=null){
			getFragmentManager().beginTransaction().remove(fragment).commit();
			Log.i("removeFragment", "run");
		}
	}

	@Override
	public boolean onMyLocationButtonClick() {
		Toast.makeText(context, "My Location Click", Toast.LENGTH_LONG).show();
		return false;
	}

	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.myMapLocationButton:
			if(Utility.checkGpsEnable(context)){
				Toast.makeText(context, "GPS Enable", Toast.LENGTH_LONG).show();
			} else {
				Toast.makeText(context, "GPS not Enable", Toast.LENGTH_LONG).show();
			}
			break;
		default:
			break;
		}
	}

}
