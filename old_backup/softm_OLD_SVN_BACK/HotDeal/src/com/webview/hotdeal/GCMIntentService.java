package com.webview.hotdeal;


import java.net.URL;
import java.util.Iterator;
import java.util.List;

import org.xmlpull.v1.XmlPullParser;
import org.xmlpull.v1.XmlPullParserFactory;

import android.app.Activity;
import android.app.ActivityManager;
import android.app.ActivityManager.RunningTaskInfo;
import android.app.AlertDialog;
import android.app.Dialog;
import android.app.Notification;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.ComponentName;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.os.PowerManager;
import android.os.Vibrator;
import android.telephony.TelephonyManager;
import android.util.Log;
import android.widget.Toast;


import com.google.android.gcm.GCMBaseIntentService;



public class GCMIntentService extends GCMBaseIntentService {
	
	private static final String tag = "GCMIntentService";
	public static final String SEND_ID = "478424439155"; //"769628476872"; //"478424439155"; //"82126532768";
	private String c2dm_msg="";

	private static PowerManager pm;
	private static PowerManager.WakeLock wl;

	public GCMIntentService(){ this(SEND_ID); }	
	public GCMIntentService(String senderId) { super(senderId); }

	private Dialog mDialog = null;
	
	@Override
    protected void onMessage(Context arg0, Intent arg1)
    {
        // TODO Auto-generated method stub
        Log.d(TAG, "onMessage");
        generateNotification(arg0, arg1.getStringExtra("message"));
    }
	
    @SuppressWarnings("deprecation")
	private static void generateNotification(Context context, String message) {
    	
        long when = System.currentTimeMillis();
        
    	String[] str1;
        str1=message.split(",");
        
        String gourl=str1[1];
        
        Log.d("url",gourl);
        Log.d("sound",str1[2]);
        Log.d("vibrate",str1[3]);
        
        
        NotificationManager notificationManager = (NotificationManager) context
                .getSystemService(Context.NOTIFICATION_SERVICE);
        
        Notification notification = new Notification(R.drawable.icon72,
                str1[0], when);
        
        String title = context.getString(R.string.app_name);
        
//        Vibrator vibrator = 
//       		 (Vibrator) context.getSystemService(Context.VIBRATOR_SERVICE);
//        
//        vibrator.vibrate(1000);
       
        
        Intent notificationIntent = new Intent(context,
                Web_View.class);
        
        notificationIntent.putExtra("target", str1[1]);
        
        // set intent so it does not start a new activity
        notificationIntent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP
                | Intent.FLAG_ACTIVITY_NEW_TASK);
        PendingIntent intent = PendingIntent.getActivity(context, 0,
                notificationIntent, PendingIntent.FLAG_UPDATE_CURRENT);
        
        notification.setLatestEventInfo(context, title, str1[0], intent);
        
        notification.flags |= Notification.FLAG_AUTO_CANCEL;
        
        // Play default notification sound
        if(str1[2].endsWith("1")){
        	notification.defaults |= Notification.DEFAULT_SOUND;
        }
        // Vibrate if vibrate is enabled
        if(str1[3].endsWith("1")){
        	notification.defaults |= Notification.DEFAULT_VIBRATE;
        }
        
        notificationManager.notify(0, notification); 

        pm = (PowerManager) context.getSystemService(Context.POWER_SERVICE); 
        wl = pm.newWakeLock(PowerManager.FULL_WAKE_LOCK
                | PowerManager.ACQUIRE_CAUSES_WAKEUP
                | PowerManager.ON_AFTER_RELEASE, "ScreenOn");
        wl.acquire(); 
              
       //Dialog ³Ö´Â°÷
       //notificationManager.notify(0, notification);Intent.FLAG_ACTIVITY_CLEAR_TOP |
              
      Intent pop = new Intent(context, PopUp.class);
      pop.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK |  Intent.FLAG_ACTIVITY_SINGLE_TOP);
      pop.putExtra("url", str1[0]+str1[1]);
	  context.startActivity(pop);

              
    }
 
	public void GET_GCM() { 
	    
	    Thread thread = new Thread(new Runnable() { 
	        public void run() { 
	        	
	        handler.sendEmptyMessage(0); 
	        } 
	    }); 
	    thread.start(); 
	} 

	private Handler handler = new Handler() { 
	    public void handleMessage(Message msg) { 
	                    	
	        Context context = getApplicationContext();
	        int duration = Toast.LENGTH_LONG;
	        
	        Toast toast = Toast.makeText(context, c2dm_msg, duration);
	        toast.show(); 
	        
	        c2dm_msg = null;
	    } 
    };
	
	
	@Override
	protected void onError(Context context, String errorId) {
		Log.d(tag, "onError. errorId : "+errorId);
	}

	@Override
	protected void onRegistered(Context context, String regId) {
		Log.d(tag, "onRegistered. regId : "+regId);
		RegisterDeviceNo(regId);
	}

	private void RegisterDeviceNo(String regId){
		
		String PHONE_NUMBER;
		TelephonyManager telManager = (TelephonyManager) getSystemService(Context.TELEPHONY_SERVICE);
		PHONE_NUMBER = telManager.getLine1Number().toString().trim();
		//		PHONE_NUMBER = PHONE_NUMBER.replace("82", "0").replace("-", "").replace("+82","0");
		PHONE_NUMBER = PHONE_NUMBER.replace("82", "0").replace("+82","0");		
		
		try{
//			URL text = new URL( "http://eyaki.co.kr/joinssen.php?devno="+regId );
			URL text = new URL( "http://www.mrhotdeal.co.kr/joinssen.php?devno="+regId+"&tel="+ PHONE_NUMBER );			

			XmlPullParserFactory parserCreator = XmlPullParserFactory.newInstance();
			XmlPullParser parser = parserCreator.newPullParser();

			parser.setInput( text.openStream(), null );

		}
		catch(Exception e)
		{
			e.printStackTrace();
		}
	}
	
	@Override
	protected void onUnregistered(Context context, String regId) {
		Log.d(tag, "onUnregistered. regId : "+regId);
		RegisterDeviceNo(regId);
	}

	@Override
	protected boolean onRecoverableError(Context context, String errorId) {
		Log.d(tag, "onRecoverableError. errorId : "+errorId);
		return super.onRecoverableError(context, errorId);
	}
	
}