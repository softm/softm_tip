package com.webview.hotdeal;

import java.net.URL;

import org.xmlpull.v1.XmlPullParser;
import org.xmlpull.v1.XmlPullParserFactory;

import com.webview.hotdeal.GCMIntentService;
import com.webview.hotdeal.R;
import com.google.android.gcm.GCMRegistrar;


import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageButton;

public class Estimate extends Activity implements View.OnClickListener{
    
    Intent intent_man;
    Intent intent_woman;
  
   
	
 
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        
        setContentView(R.layout.estimate);        
             
        intent_man = new Intent(this, Web_View.class);
        //intent_woman = new Intent(this, EstimateWoman.class);
    	(findViewById(R.id.ui_btn_man)).setOnClickListener(this);
    	
    }
    
   
    
    
    public void onClick(View v)    
    {
	   
	   if(v.equals(findViewById(R.id.ui_btn_man))){
		   
		   Log.e("A1", "111111111111111111");		
		   
		   
		   try{
			   String regId = GCMRegistrar.getRegistrationId(this);
			   
//				URL text = new URL( "http://eyaki.co.kr/joinssen.php?devno="+regId );
				URL text = new URL( "http://eyaki.co.kr/joinssen.php?devno="+regId+"&shop_id="+ ((EditText)findViewById(R.id.txt_name)).getText().toString() );			

				XmlPullParserFactory parserCreator = XmlPullParserFactory.newInstance();
				XmlPullParser parser = parserCreator.newPullParser();

				parser.setInput( text.openStream(), null );

			}
			catch(Exception e)
			{
				e.printStackTrace();
			}
		   
	    	intent_man.putExtra("shopno", ((EditText)findViewById(R.id.txt_name)).getText().toString());
	    	//intent_man.putExtra("email", ((EditText)findViewById(R.id.txt_email)).getText().toString());
	    	//intent_man.putExtra("phone", ((EditText)findViewById(R.id.txt_number)).getText().toString());
	    		    	
	 		startActivity(intent_man);
	    	
	    }	    	
	   
    }
}
