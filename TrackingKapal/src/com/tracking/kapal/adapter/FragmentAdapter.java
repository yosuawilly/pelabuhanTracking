package com.tracking.kapal.adapter;

import com.tracking.kapal.fragment.AutomaticFragment;
import com.tracking.kapal.fragment.ManualFragment;
import com.tracking.kapal.fragment.MyMapFragment;
import com.tracking.kapal.listener.FragmentListener;

import android.content.Context;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentStatePagerAdapter;

public class FragmentAdapter extends FragmentStatePagerAdapter{
	
	private Context context;
	private FragmentListener fragmentListener;
	
	private ManualFragment manualFragment;
	private AutomaticFragment automaticFragment;
	private MyMapFragment mapFragment;

	public FragmentAdapter(FragmentManager fm, Context context, FragmentListener fragmentListener) {
		super(fm);
		this.context = context;
		this.fragmentListener = fragmentListener;
	}

	@Override
	public Fragment getItem(int position) {
		switch (position) {
		case 0:
			if(manualFragment==null){
				manualFragment = new ManualFragment(context, fragmentListener);
			}
			return manualFragment;
		case 1:
			if(automaticFragment==null){
				automaticFragment = new AutomaticFragment(context, fragmentListener);
			}
			return automaticFragment;
		case 2:
			if(mapFragment==null){
				mapFragment = new MyMapFragment(context, fragmentListener);
			}
			return mapFragment;
		default:
			break;
		}
		return null;
	}

	@Override
	public int getCount() {
		return 3;
	}

}
