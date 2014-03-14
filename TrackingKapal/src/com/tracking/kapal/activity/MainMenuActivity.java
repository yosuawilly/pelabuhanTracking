package com.tracking.kapal.activity;

import android.support.v4.app.FragmentTransaction;
import android.support.v4.view.WindowCompat;
import android.support.v7.app.ActionBar;
import android.support.v7.app.ActionBar.Tab;
import android.view.View;
import android.widget.FrameLayout;

import com.tracking.kapal.R;
import com.tracking.kapal.activity.base.BaseMyActionBarActivity;

public class MainMenuActivity extends BaseMyActionBarActivity implements ActionBar.TabListener{
	
//	private TabsPagerAdapter mAdapter;
    private ActionBar actionBar;
    // Tab titles
    private String[] tabs = { "Manual", "Automatic", "Tracking" };
    
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
    	
    	// Adding Tabs
        for (String tab_name : tabs) {
            actionBar.addTab(actionBar.newTab().setText(tab_name)
                    .setTabListener(this));
        }
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
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onTabUnselected(Tab tab, FragmentTransaction ft) {
		// TODO Auto-generated method stub
		
	}

}
