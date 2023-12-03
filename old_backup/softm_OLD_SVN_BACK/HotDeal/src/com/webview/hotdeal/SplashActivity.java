package com.webview.hotdeal;


import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;

public class SplashActivity extends Activity
{
    @Override
    public void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.loading);

        initialize();
    }

    private void initialize()
    {
    	Handler handle = new Handler();
    	handle.postDelayed(new Runnable(){
    		
    		public void run(){
    			Intent intent = new Intent(SplashActivity.this, Web_View.class);
    			startActivity(intent);
    			finish();
    		}
    	},3000);
    }
}