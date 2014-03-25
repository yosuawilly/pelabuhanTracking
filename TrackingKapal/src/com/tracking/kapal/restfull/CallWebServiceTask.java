package com.tracking.kapal.restfull;

import java.net.SocketException;
import java.net.SocketTimeoutException;

import org.apache.http.client.ClientProtocolException;
import org.apache.http.conn.ConnectTimeoutException;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.os.AsyncTask;
import android.util.Log;

public class CallWebServiceTask extends AsyncTask<Object, String, String>{
	private Context applicationContext;
	private AsyncTaskCompleteListener<Object> callback;	
	private ProgressDialog dialog;
	private String message = "Retrieving data ...";
	private Integer idCaller = null;
	private boolean withDialog = true;
	
	public CallWebServiceTask() {
		// TODO Auto-generated constructor stub
	}
	
	public CallWebServiceTask(Context applicationContext,
			AsyncTaskCompleteListener<Object> callback) {
		this.applicationContext = applicationContext;
		this.callback = callback;
	}
	
	public CallWebServiceTask(Context applicationContext,
			AsyncTaskCompleteListener<Object> callback, boolean withDialog) {
		this.applicationContext = applicationContext;
		this.callback = callback;
		this.withDialog = withDialog;
	}
	
	public CallWebServiceTask(Context applicationContext,
			AsyncTaskCompleteListener<Object> callback, String message) {
		this.applicationContext = applicationContext;
		this.callback = callback;
		this.message = message;
	}

	@Override
	protected void onPreExecute() {
		if(withDialog)
		dialog = ProgressDialog.show(applicationContext,    
                "Please wait...", message, true, true, 
                new DialogInterface.OnCancelListener(){
                @Override
                public void onCancel(DialogInterface dialog) {
                }
            }
        );
	}

	/* (non-Javadoc)
	 * @see android.os.AsyncTask#doInBackground(Params[])
	 */
	@Override
	protected String doInBackground(Object... params) {	
		String url = (String) params[0];
		int method = (Integer) params[1];
		if(params.length > 2)
			idCaller = (Integer) params[2];
		
		String result = "{\"errorCode\":\"LK-0000\"}";
		try {
			result = RestfulHttpMethod.connect(url, method);
			if(result.equalsIgnoreCase("null") || result.equalsIgnoreCase("[]"))
				result = "{\"errorCode\":\"LK-0002\"}";
		} catch (ClientProtocolException e) {
			e.printStackTrace();
		} catch (SocketException e) {
			e.printStackTrace();
		} catch (SocketTimeoutException e) {
			e.printStackTrace();
		} catch (ConnectTimeoutException e) {
			result = "{\"errorCode\":\"LK-0000\"}";
			e.printStackTrace();
		} catch (Exception e) {
			result = "{\"errorCode\":\"LK-0600\"}";
			e.printStackTrace();
		}		
			
		return result;
	}

	/* (non-Javadoc)
	 * @see android.os.AsyncTask#onPostExecute(java.lang.Object)
	 */
	@Override
	protected void onPostExecute(String result) {
		// Log.i("CALL BACK ", "POST EXECUTE");
		if (withDialog)
		if (dialog.isShowing()) {
			try {
				dialog.dismiss();
			} catch (IllegalArgumentException e) {				
				//do nothing
				e.printStackTrace();
			}
		}
		
		if(idCaller != null)
			callback.onTaskComplete(result, idCaller);
		else
			callback.onTaskComplete(result);
	}		
}
