package com.tracking.kapal.util;

import android.annotation.SuppressLint;

@SuppressLint("SdCardPath") 
public final class Constant {
	
	public static final String BASE_URL = "http://192.168.16.90/TrackingPelabuhanServer/rest/";
	
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

}
