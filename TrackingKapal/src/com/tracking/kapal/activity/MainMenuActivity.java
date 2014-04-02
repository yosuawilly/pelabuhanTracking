package com.tracking.kapal.activity;

import android.content.Intent;
import android.os.Bundle;
import android.support.v4.view.ViewPager.OnPageChangeListener;
import android.util.Log;
import android.widget.TextView;

import com.actionbarsherlock.app.ActionBar;
import com.tracking.kapal.R;
import com.tracking.kapal.activity.base.BaseMyActionBarActivity;
import com.tracking.kapal.adapter.FragmentAdapter;
import com.tracking.kapal.customcomponent.CustomViewPager;
import com.tracking.kapal.database.PreferenceHelper;
import com.tracking.kapal.listener.FragmentListener;
import com.tracking.kapal.model.Kapal;
import com.tracking.kapal.util.Constant;
import com.tracking.kapal.util.TabSetupTools;
import com.tracking.kapal.util.TabSetupTools.OnTabChanged;

public class MainMenuActivity extends BaseMyActionBarActivity implements FragmentListener, OnPageChangeListener, OnTabChanged{
	
    private ActionBar actionBar;
    private CustomViewPager viewPager;
    private FragmentAdapter fragmentAdapter;
    // Tab titles
    private String[] tabs = { "Manual", "Automatic", "Tracking" };
    
    private TabSetupTools tabSetupTools;
    
    @Override
    protected void onCreate(Bundle savedInstanceState) {
    	super.onCreate(savedInstanceState);
    	
    	tabSetupTools = new TabSetupTools(this, this, savedInstanceState, R.id.tabhost, tabs);
		tabSetupTools.generateTabs();
    }
    
    @Override
    public void initDesign() {
    	super.initDesign();
    	
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
        
        /*init ActionBar*/
        actionBar = getSupportActionBar();
        actionBar.hide();
//    	actionBar.setDisplayShowTitleEnabled(false);
//    	actionBar.setDisplayShowHomeEnabled(false);
//    	actionBar.setHomeButtonEnabled(false);
//    	actionBar.setNavigationMode(ActionBar.NAVIGATION_MODE_TABS);
//    	//supportRequestWindowFeature(WindowCompat.FEATURE_ACTION_BAR_OVERLAY);
//    	
//    	// Adding Tabs
//        for (String tab_name : tabs) {
//            actionBar.addTab(actionBar.newTab().setText(tab_name)
//                    .setTabListener(this));
//        }
        
        initLayoutHeader();
        
        //viewPager.setCurrentItem(lastPositionPage);
        Log.i("initDesign", "run");
    }
    
    protected void initLayoutHeader() {
    	//LinearLayout v = (LinearLayout) getLayoutInflater().inflate(R.layout.header_layout, null);
    	
    	Kapal kapal = new PreferenceHelper(this, Constant.SETTING_KAPAL).getObject(Constant.KAPAL, Kapal.class);
    	if(kapal!=null) {
    		((TextView) findViewById(R.id.kodeKapalText)).setText(kapal.getKode_kapal());
    		((TextView) findViewById(R.id.namaKapalText)).setText(kapal.getNama_kapal());
    	}
    	
    	//ViewGroup decor = (ViewGroup) getWindow().getDecorView();
		//ViewGroup child = (ViewGroup) decor.getChildAt(0);
		//child.addView(v, 0);
    	
    	//((FrameLayout)findViewById(android.support.v7.appcompat.R.id.activity_header)).addView(v);
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
	public void onPageScrollStateChanged(int arg0) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onPageScrolled(int arg0, float arg1, int arg2) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onPageSelected(int position) {
		//actionBar.setSelectedNavigationItem(position);
	}

	@Override
	public void startGpsSetting() {
		startActivityForResult(new Intent(android.provider.Settings.ACTION_LOCATION_SOURCE_SETTINGS), 0);
	}
	
	@Override
	protected void onPause() {
		super.onPause();
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
	
	@Override
	protected void onDestroy() {
		super.onDestroy();
		System.gc();
		Log.i("onDestroy", "run");
	}

	@Override
	public void onTabChanged(String tabId) {
		if(tabId.equals(tabs[0])) {
			viewPager.setCurrentItem(0);
		} else if(tabId.equals(tabs[1])) {
			viewPager.setCurrentItem(1);
		} else if(tabId.equals(tabs[2])) {
			viewPager.setCurrentItem(2);
		}
	}

}
