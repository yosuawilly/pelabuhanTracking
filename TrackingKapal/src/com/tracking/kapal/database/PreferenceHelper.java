package com.tracking.kapal.database;

import com.google.gson.Gson;

import android.content.Context;
import android.content.SharedPreferences;

public class PreferenceHelper {
	
	private Context context;
	private String PreferenceName;
	
	public PreferenceHelper(Context context, String PreferenceName) {
		this.context = context;
		this.PreferenceName = PreferenceName;
	}
	
	public SharedPreferences getPreference() {
		return context.getSharedPreferences(PreferenceName, Context.MODE_PRIVATE);
	}
	
	public <T> void saveObject(String key, T object) {
		SharedPreferences.Editor editor = getPreference().edit();
		String json = new Gson().toJson(object);
		editor.putString(key, json);
		editor.commit();
	}
	
	public <T> T getObject(String key, Class<T> type) {
		T obj = null;
		
		String str = getPreference().getString(key, null);
		if(str != null) {
			obj = new Gson().fromJson(str, type);
		}
		
		return obj;
	}
	
	public void savePreference(String key, String value) {
		SharedPreferences.Editor editor = getPreference().edit();
		editor.putString(key, value);
		editor.commit();
	}
	
	public String getPreference(String key) {
		return getPreference().getString(key, null);
	}
	
	public void removePreference(String key) {
		SharedPreferences.Editor editor = getPreference().edit();
		editor.remove(key);
		editor.commit();
	}

}
