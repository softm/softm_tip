package com.entropykorea.gas.lib.dialog;

import android.app.Dialog;
import android.content.Context;
import android.os.AsyncTask;
import android.os.Bundle;
import android.view.KeyEvent;
import android.view.WindowManager;
import android.widget.TextView;

import com.entropykorea.gas.lib.R;


public abstract class LongTimeDialog {

	public final static String DEFAULT_DISPLAYMESSAGE = "처리중 입니다.\n잠시만 기다리십시요"; // default message

	private Context context;
	private MessageDialog messageDialog;
	private String displaymessage;
	private Boolean showStatusBar = false;
	
	private Object object = null; // for param

	public LongTimeDialog( Context context ) {
		this.context = context;
		this.displaymessage = DEFAULT_DISPLAYMESSAGE;
	}

	public LongTimeDialog( Context context, String message ) {
		this.context = context;
		this.displaymessage = message;
	}

	public LongTimeDialog( Context context, String message, Boolean statusbar ) {
		this.context = context;
		this.displaymessage = message;
		this.showStatusBar = statusbar;
	}

	public LongTimeDialog( Context context, String message, Boolean statusbar, Object obj ) {
		this.context = context;
		this.displaymessage = message;
		this.showStatusBar = statusbar;
		this.object = obj;
	}

	public void show() {
		if( mThreadRunning == true )
			return;
		showDialog();
		new LongTimeTask().execute();
	}

	// require
	public abstract Boolean doBackground( Object object );
	public abstract void doEndExecute( Object object, Boolean result);

	// thread
	boolean mThreadRunning = false;

	class LongTimeTask extends AsyncTask< Void, Void, Boolean > {

		@Override
		protected Boolean doInBackground(Void... params) {
			mThreadRunning = false;
			return doBackground( object );
		}

		@Override
		protected void onPostExecute(Boolean result) {
			mThreadRunning = true;
			hideDialog();
			doEndExecute( object, result );
			super.onPostExecute(result);
		}
	}

	// dialog
	private void showDialog() {
		if( messageDialog != null ) {
			hideDialog();
		}
		messageDialog = new MessageDialog(context); 
		messageDialog.show();
	}

	public void hideDialog() {
		if( messageDialog != null ) {
			messageDialog.hide();
			messageDialog.dismiss();
			messageDialog = null;
		}
	}

	// dialog class
	public class MessageDialog extends Dialog {

		private TextView mMessage = null;

		@Override
		protected void onCreate(Bundle savedInstanceState) {
			super.onCreate(savedInstanceState);

			WindowManager.LayoutParams lpWindow = new WindowManager.LayoutParams();
			lpWindow.flags = WindowManager.LayoutParams.FLAG_DIM_BEHIND;
			lpWindow.dimAmount = 0.5f;
			getWindow().setAttributes(lpWindow);

			setContentView(R.layout.dialog_longtime);
			mMessage = (TextView) findViewById(R.id.dialog_text);
			mMessage.setText(displaymessage);

			if( showStatusBar ) {
				removeStatusBar(true);
			}
		}

		@Override
		protected void onStop() {
			removeStatusBar(false);
			super.onStop();
		}

		public void removeStatusBar(boolean remove) {
			// 5.0 에서 화면 위로 올라감 (Nexus 5 5.0)
			// Holo theme 를 사용할 경우 작동하지 않
			if (remove) {
				getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
						WindowManager.LayoutParams.FLAG_FULLSCREEN);
			} else {
				getWindow().clearFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN);
			}
		}

		public MessageDialog(Context context ) {
			super(context, android.R.style.Theme_Translucent_NoTitleBar);
		}

//		public void setMessage(String message) {
//			if( this.mMessage != null ) {
//				mMessage.setText(message);
//			}
//		}
//		
//		public void setStautsBar( Boolean statusbar ) {
//			this.showStatus = statusbar;
//		}

		@Override
		public boolean onKeyDown(int keyCode, KeyEvent event) {
			if (event.getAction() == KeyEvent.ACTION_DOWN) {
				if (keyCode == KeyEvent.KEYCODE_BACK) {

				}
			}
			return false;
		}


	}




}
