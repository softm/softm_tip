package com.webview.hotdeal;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.Dialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.util.Log;
import android.view.Window;
import android.view.WindowManager;


public class PopUp extends Activity
{
	private AlertDialog mDialog = null;
	private String[] str1;
	private String target;
			
    @Override
    public void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.popup);

        String msg=this.getIntent().getStringExtra("url");
        str1=msg.split("http");
        
        //11111111|http://www.naver.com
        
        Log.d("msg",msg);
        Log.d("str1[0]",str1[0]);
        Log.d("str2[1]",str1[1]);
        
        target=str1[1];
        
        mDialog = createDialog(str1[0]);
        mDialog.show();
        
    }

    private AlertDialog createDialog(String message) {
        
		AlertDialog.Builder ab = new AlertDialog.Builder(this);
		 
		ab.setTitle("πÃΩ∫≈Õ«÷µÙ");
	    ab.setMessage(message);
	    ab.setCancelable(false);
	    ab.setIcon(getResources().getDrawable(R.drawable.block1));
	      
	    ab.setPositiveButton("»Æ¿Œ", new DialogInterface.OnClickListener() {
	        public void onClick(DialogInterface arg0, int arg1) {
	        	
	        	Intent intent = new Intent(PopUp.this, Web_View.class);
	        	intent.putExtra("target", "http"+target);
    			startActivity(intent);
    			finish();
	            
	        }
	    });
	      
	    ab.setNegativeButton("√Îº“", new DialogInterface.OnClickListener() {
	        public void onClick(DialogInterface arg0, int arg1) {
	            
	        	setDismiss(mDialog);
	        	finish();
	        }
	    });
	      
	    return ab.create();
    }

	private void setDismiss(Dialog dialog){
	    if(dialog != null && dialog.isShowing())
	        dialog.dismiss();
	}
  
}