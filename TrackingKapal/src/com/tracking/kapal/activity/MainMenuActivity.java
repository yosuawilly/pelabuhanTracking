package com.tracking.kapal.activity;

import android.support.v4.app.FragmentTransaction;
import android.support.v7.app.ActionBar;
import android.support.v7.app.ActionBar.Tab;

import com.tracking.kapal.R;
import com.tracking.kapal.activity.base.BaseMyFragmentActivity;

public class MainMenuActivity extends BaseMyFragmentActivity implements ActionBar.TabListener{
	
//	private TabsPagerAdapter mAdapter;
    private ActionBar actionBar;
    // Tab titles
    private String[] tabs = { "Manual", "Automatic", "Tracking" };
    
    @Override
    public void initDesign() {
    	super.initDesign();
    	actionBar = getSupportActionBar();
    	actionBar.setDisplayShowTitleEnabled(false);
    	actionBar.setDisplayShowHomeEnabled(false);
    	actionBar.setHomeButtonEnabled(false);
    	actionBar.setNavigationMode(ActionBar.NAVIGATION_MODE_TABS);
    	
    	// Adding Tabs
        for (String tab_name : tabs) {
            actionBar.addTab(actionBar.newTab().setText(tab_name)
                    .setTabListener(this));
        }
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
	public void onTabReselected(Tab arg0, FragmentTransaction arg1) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onTabSelected(Tab arg0, FragmentTransaction arg1) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onTabUnselected(Tab arg0, FragmentTransaction arg1) {
		// TODO Auto-generated method stub
		
	}

}
