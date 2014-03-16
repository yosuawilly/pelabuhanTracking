package com.tracking.kapal.fragment;

import android.content.Context;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.tracking.kapal.R;
import com.tracking.kapal.listener.FragmentListener;

public class ManualFragment extends Fragment{
	
	private Context context;
	private ViewGroup viewGroup;
	private FragmentListener fragmentListener;
	
	public ManualFragment(Context context, FragmentListener fragmentListener) {
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
		viewGroup = (ViewGroup) inflater.inflate(R.layout.manual_layout, container, false);
		
		return viewGroup;
	}
	
	@Override
	public void onDestroy() {
		if(viewGroup!=null){
			((ViewGroup)viewGroup.getParent()).removeAllViews();
		}
		super.onDestroy();
	}
	
}
