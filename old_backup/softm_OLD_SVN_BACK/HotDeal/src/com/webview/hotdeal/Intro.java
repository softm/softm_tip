package com.webview.hotdeal;

import android.app.Activity;
import android.content.Intent;
import android.graphics.drawable.AnimationDrawable;
import android.os.Bundle;
import android.os.Handler;
import android.view.Menu;
import android.widget.ImageView;
import com.webview.hotdeal.R;

public class Intro extends Activity {

	private AnimationDrawable frameAnimation;
    private ImageView view;
	
	String result1="";
	String ver=""; //???ë²? ë²?
	String v = ""; //ë¡?ì»? ë²???? 

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_main);
	
        view = (ImageView) findViewById(R.id.imageAnimation);
 
        
        
        view.setBackgroundResource(R.drawable.frame_animation_list);
        frameAnimation = (AnimationDrawable) view.getBackground();
        
        Handler handle = new Handler();
        
    	handle.postDelayed(new Runnable(){
			public void run(){
				
				Intent intent = new Intent(Intro.this, Web_View.class);
				startActivity(intent);
				finish();
				
				
			}
    	},3000);
	}
	
	@Override
    public void onWindowFocusChanged(boolean hasFocus) {
        super.onWindowFocusChanged(hasFocus);
        if (hasFocus) {
            frameAnimation.start();
        } else {
            frameAnimation.stop();
        }
    }
}
