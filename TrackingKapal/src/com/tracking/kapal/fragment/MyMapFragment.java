package com.tracking.kapal.fragment;

import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.SupportMapFragment;
import com.tracking.kapal.R;
import com.tracking.kapal.listener.FragmentListener;

import android.annotation.SuppressLint;
import android.content.Context;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Toast;

@SuppressLint("ValidFragment") 
public class MyMapFragment extends Fragment{
	
	private Context context;
	private ViewGroup viewGroup;
	private FragmentListener fragmentListener;
	
	private GoogleMap googleMap;
	
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
            	googleMap.setMyLocationEnabled(true);
            }
        }
    }
	
	@Override
	public void onDestroy() {
		if(viewGroup!=null){
			((ViewGroup)viewGroup.getParent()).removeAllViews();
		}
		super.onDestroy();
	}

}
