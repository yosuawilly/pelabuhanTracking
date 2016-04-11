package com.tracking.kapal.util;

import com.tracking.kapal.StartUpActivity;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.os.Process;

public class ForceCloseHandler implements Thread.UncaughtExceptionHandler{
	
	@SuppressWarnings("unused")
	private Context context ;
	private Activity activity ;
	private boolean inquiry = true ;
	//private WebService task ;
	
	public ForceCloseHandler(Activity activity,  Context context) {
		// TODO Auto-generated constructor stub
		this.activity = activity ;
		this.context = context ;
		//task = new WebService(WebService.INSTRUKSI_LOGOUT_NASABAH, context);
	}
	
	

	@Override
	public void uncaughtException(Thread thread, Throwable ex) {
		// TODO Auto-generated method stub
		ex.printStackTrace();
		LogMe.activity("ForceCloseHandler - Thread.UncaughtExceptionHandler \n"+ex.getLocalizedMessage()+" \n");
		LogMe.write(ex);
		
		if (inquiry) {
			inquiry = false ;
//			if (GlobalVar.getInstance().getNasabah()==null) {
//				task.execute(GlobalVar.getInstance().getClientDevice().getKodeClientDevice());
//			}else{
//				task.execute(GlobalVar.getInstance().getClientDevice().getKodeClientDevice(), GlobalVar.getInstance().getNasabah().getKodeNasabah());	
//			}
			activity.startActivity(new Intent(activity, StartUpActivity.class));
			activity.finish();
			Process.killProcess(Process.myPid());
			System.exit(0);
		}
	}
}
