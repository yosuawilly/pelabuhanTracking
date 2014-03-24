package com.tracking.kapal.activity;

import android.content.Intent;
import android.support.v4.app.FragmentTransaction;
import android.support.v4.view.ViewPager.OnPageChangeListener;
import android.support.v4.view.WindowCompat;
import android.support.v7.app.ActionBar;
import android.support.v7.app.ActionBar.Tab;
import android.util.Log;
import android.view.View;
import android.widget.FrameLayout;

import com.tracking.kapal.R;
import com.tracking.kapal.activity.base.BaseMyActionBarActivity;
import com.tracking.kapal.adapter.FragmentAdapter;
import com.tracking.kapal.customcomponent.CustomViewPager;
import com.tracking.kapal.listener.FragmentListener;

public class MainMenuActivity extends BaseMyActionBarActivity implements ActionBar.TabListener, FragmentListener, OnPageChangeListener{
	
    private ActionBar actionBar;
    private CustomViewPager viewPager;
    private FragmentAdapter fragmentAdapter;
    // Tab titles
    private String[] tabs = { "Manual", "Automatic", "Tracking" };
    
    private int lastPositionPage = 0;
    
    @Override
    public void initDesign() {
    	super.initDesign();
    	initLayoutHeader();
    	
    	actionBar = getSupportActionBar();
    	actionBar.setDisplayShowTitleEnabled(false);
    	actionBar.setDisplayShowHomeEnabled(false);
    	actionBar.setHomeButtonEnabled(false);
    	actionBar.setNavigationMode(ActionBar.NAVIGATION_MODE_TABS);
    	supportRequestWindowFeature(WindowCompat.FEATURE_ACTION_BAR_OVERLAY);
    	
    	/*init ViewPager*/
    	viewPager = (CustomViewPager) findViewById(R.id.viewPager);
    	viewPager.removeAllViews();
        fragmentAdapter = new FragmentAdapter(getSupportFragmentManager(), this, this);
        fragmentAdapter.removeAllFragment();
        viewPager.setEnableSwipe(false);
        viewPager.setOffscreenPageLimit(3);
        viewPager.setAdapter(fragmentAdapter);
        viewPager.setOnPageChangeListener(this);
        viewPager.requestTransparentRegion(viewPager);
    	
    	// Adding Tabs
        for (String tab_name : tabs) {
            actionBar.addTab(actionBar.newTab().setText(tab_name)
                    .setTabListener(this));
        }
        
        //viewPager.setCurrentItem(lastPositionPage);
        Log.i("initDesign", "run");
    }
    
    protected void initLayoutHeader() {
    	View v = getLayoutInflater().inflate(R.layout.header_layout, null);
    	((FrameLayout)findViewById(android.support.v7.appcompat.R.id.activity_header)).addView(v);
    }

	@Override
	public int getLayoutId() {
		return R.layout.main_menu_page;
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
	public void onTabReselected(Tab tab, FragmentTransaction ft) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onTabSelected(Tab tab, FragmentTransaction ft) {
//		if(tab.getPosition()==2) viewPager.setEnableSwipe(false);
//		else viewPager.setEnableSwipe(true);
		viewPager.setCurrentItem(tab.getPosition());
	}

	@Override
	public void onTabUnselected(Tab tab, FragmentTransaction ft) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onPageScrollStateChanged(int arg0) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onPageScrolled(int arg0, float arg1, int arg2) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onPageSelected(int position) {
//		if(position==2) viewPager.setEnableSwipe(false);
//		else viewPager.setEnableSwipe(true);
		actionBar.setSelectedNavigationItem(position);
	}

	@Override
	public void startGpsSetting() {
		startActivityForResult(new Intent(android.provider.Settings.ACTION_LOCATION_SOURCE_SETTINGS), 0);
	}
	
	@Override
	protected void onPause() {
		super.onPause();
		lastPositionPage = viewPager.getCurrentItem();
		Log.i("onPause", "run");
	}
	
	public void initViewPager(){
//		fragmentAdapter.removeAllFragment();
//		fragmentAdapter = new FragmentAdapter(getSupportFragmentManager(), this, this);
//		viewPager.removeAllViews();
//        viewPager.setAdapter(fragmentAdapter);
//        
//        viewPager.setCurrentItem(lastPositionPage);
	}
	
	@Override
	protected void onResume() {
		initViewPager();
		super.onResume();
		Log.i("onResume", "run");
	}

}
