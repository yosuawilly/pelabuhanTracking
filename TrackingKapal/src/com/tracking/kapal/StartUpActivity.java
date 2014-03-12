package com.tracking.kapal;

import com.tracking.kapal.activity.LoginActivity;

import android.os.Bundle;
import android.app.Activity;
import android.content.Intent;
import android.view.Menu;

public class StartUpActivity extends Activity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.start_up);
        
		Thread timer = new Thread(){
			
			@Override
			public void run() {
				try{
					int time = 0;
					while(time < 3000){
						sleep(100);
						time += 100;
					}
				}catch(Exception ex){
					ex.printStackTrace();
				} finally {
					startActivity(new Intent(StartUpActivity.this, LoginActivity.class));
					finish();
				}
			}
			
		};
		
		timer.start();
        
//        Intent intent = new Intent(this, LoginActivity.class);
//		startActivity(intent);
//		this.finish();
    }


    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        //getMenuInflater().inflate(R.menu.start_up, menu);
        return false;
    }
    
}
