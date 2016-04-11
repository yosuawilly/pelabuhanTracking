package com.tracking.kapal.util;

import android.annotation.SuppressLint;

@SuppressLint("SdCardPath") 
public final class Constant {
	
	public static final String ANDROID_ID = "11";
	
	//public static final String BASE_URL = "http://192.168.16.45/TrackingPelabuhanServer/rest/";
	public static final String BASE_URL = "http://192.168.1.102/TrackingPelabuhanServer/rest/";
	//public static final String BASE_URL = "http://pelabuhan.esy.es/rest/";
	
	public static final String DB_NAME="TrackingKapalDB";
	public static final String DB_PATH="/data/data/com.tracking.kapal/databases/";
	
	/*Constant for restfull http request*/
	public static final int REST_GET = 0;
	public static final int REST_PUT = 1;
	public static final int REST_POST = 2;
	public static final int REST_DELETE = 3;
	
	public static final String URL = "url";
	public static final String REST_METHOD = "rest_method";
	public static final String REST_RESULT = "rest_result";
	public static final String REST_CONN_TIMEOUT = "conn_timeout";
	
	public static final int DELETE_ACTIVE_DEVICE = 1;
	public static final int CHECK_ACTIVE_DEVICE = 2;
	
	public static final String URL_DELETE_ACTIVE_DEVICE = BASE_URL + "deleteActiveDevice/";
	public static final String URL_CHECK_ACTIVE_DEVICE = BASE_URL + "checkActiveDevice/";
	public static final String URL_ACTIVATION_DEVICE = BASE_URL + "activation/";
	public static final String URL_SEND_LOCATION = BASE_URL + "sendKordinatKapal/";
	public static final String URL_SEND_LOCATION_WITH_SCHEDULE = BASE_URL + "sendKordinatWithScheduleId/";
	public static final String URL_GET_AKTIF_SCHEDULE = BASE_URL + "getAktifSchedule/";
	public static final String URL_START_STOP_SCHEDULE = BASE_URL + "startStopSchedule/";
	
	public static final String SETTING_KAPAL = "SETTING_KAPAL";
	public static final String KAPAL = "KAPAL";
	public static final String SCHEDULE = "SCHEDULE";
	
	public static final float DISTANCE_CHANGE_FOR_UPDATE_LOCATION = 10F; //10 meter (per meter)
	public static final long INTERVAL_TIME_UPDATE_LOCATION = 1000 * 5 * 1; // 1000 * 60 * 1 = 1 minute
	
	public static final String NOTIFICATION_NAME = "Tracking Kapal";
	public static final int NOTIFICATION_LOCATION = 123;
	
	public static final String SIMPLE_DATE_FORMAT = "E MMM dd ss:mm:HH z yyyy";
	public static final String DATE_FORMAT = "yyyy-MM-dd HH:mm:ss";
	public static final String DATE_FORMAT2 = "dd-MM-yyyy HH:mm";

}
