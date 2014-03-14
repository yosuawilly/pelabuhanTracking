package com.tracking.kapal.customcomponent;

import java.lang.reflect.Field;

import android.content.Context;
import android.support.v4.view.ViewPager;
import android.util.AttributeSet;

public class CustomViewPager extends ViewPager{
	
	private static final int MY_MIN_DISTANCE_FOR_FLING = 3; // dips
	private static final int MY_MIN_FLING_VELOCITY = 100; // dips
	private int myMFlingDistance;
	private int MymMinimumVelocity;
	Context context;
	
	public CustomViewPager(Context context) {
		super(context);
		this.context = context;
		postInitViewPager();
	}

	public CustomViewPager(Context context, AttributeSet attrs) {
		super(context, attrs);
		this.context = context;
		postInitViewPager();
	}
	
	private void postInitViewPager() {
		Class<?> viewpager = ViewPager.class;
		try {
			final float density = context.getResources().getDisplayMetrics().density;
			Field flingDistance = viewpager.getDeclaredField("mFlingDistance");
			flingDistance.setAccessible(true);
			Field minimumVelocity = viewpager.getDeclaredField("mMinimumVelocity");
			minimumVelocity.setAccessible(true);
			
			myMFlingDistance = (int) (MY_MIN_DISTANCE_FOR_FLING * density);
			flingDistance.set(this, myMFlingDistance);
			
			MymMinimumVelocity = (int) (MY_MIN_FLING_VELOCITY * density);
			minimumVelocity.set(this, MymMinimumVelocity);
		} catch (SecurityException e) {
			e.printStackTrace();
		} catch (NoSuchFieldException e) {
			e.printStackTrace();
		} catch (IllegalArgumentException e) {
			e.printStackTrace();
		} catch (IllegalAccessException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} 
	}

}
