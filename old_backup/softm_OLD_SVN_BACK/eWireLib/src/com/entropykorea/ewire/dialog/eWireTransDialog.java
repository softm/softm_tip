package com.entropykorea.ewire.dialog;

import android.app.Dialog;
import android.content.Context;
import android.os.Build;
import android.os.Bundle;
import android.view.KeyEvent;
import android.view.WindowManager;
import android.widget.ProgressBar;
import android.widget.TextView;

import com.entropykorea.ewire.R;

public class eWireTransDialog extends Dialog {

	private int dialogType = 2; // dialog type
	private boolean indeterminateType = false;  // progress type
	private boolean showstatusbar = false;

	private String message = null; 
	private TextView mMessage = null;
	private ProgressBar mProgressBar = null;
	private TextView mStatus = null;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);

		if( dialogType != 0 ) {
			WindowManager.LayoutParams lpWindow = new WindowManager.LayoutParams();
			lpWindow.flags = WindowManager.LayoutParams.FLAG_DIM_BEHIND;
			lpWindow.dimAmount = 0.5f;
			getWindow().setAttributes(lpWindow);
		}
		
		switch (dialogType) {
		case 0:
			setContentView(R.layout.dialog_ewire_none);
			break;
		case 1:
			setContentView(R.layout.dialog_ewire_wait);
			mProgressBar = (ProgressBar) findViewById(R.id.ewire_dialog_wait_progress);
			mProgressBar.setMax(100);
			mProgressBar.setProgress(50);
			mProgressBar.setIndeterminate(true);
			break;
		case 3:
			setContentView(R.layout.dialog_ewire_wait_progressbar);
			mProgressBar = (ProgressBar) findViewById(R.id.ewire_dialog_wait_progress);
			mProgressBar.setMax(100);
			mProgressBar.setProgress(50);
			mProgressBar.setIndeterminate(true);
			mMessage = (TextView) findViewById(R.id.ewire_dialog_text);
			mMessage.setText(message);
			break;
		case 2:
		default:
			setContentView(R.layout.dialog_ewire_progressbar);
			mProgressBar = (ProgressBar) findViewById(R.id.ewire_dialog_progress);
			mProgressBar.setMax(100);
			mProgressBar.setIndeterminate(this.indeterminateType);
			mStatus = (TextView) findViewById(R.id.ewire_dialog_status);
			mMessage = (TextView) findViewById(R.id.ewire_dialog_text);
			mMessage.setText(message);
			break;
		}

		removeStatusBar(true);
	}

	@Override
	protected void onStop() {
		removeStatusBar(false);
		super.onStop();
	}
	
	private void removeStatusBar(boolean remove) {
		if( this.dialogType == 0 ) {
			return;
		}
		
		if( this.showstatusbar == true ) {
			return;
		}
		// 5.0 에서 화면 위로 올라감 (Nexus 5 5.0)
		// Holo theme 를 사용할 경우 작동하지 않
		if( Build.VERSION.SDK_INT > 19 ) {
			return;
		}

		if (remove) {
			getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
					WindowManager.LayoutParams.FLAG_FULLSCREEN);
		} else {
			getWindow().clearFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN);
		}
	}

	public eWireTransDialog(Context context, int dialogtype, boolean indeterminatetype, boolean showstatusbar ) {
		super(context, android.R.style.Theme_Translucent_NoTitleBar);
		// super(context ,
		// android.R.style.Theme_Holo_Light_Dialog_NoActionBar_MinWidth);
		this.dialogType = dialogtype; // dialog type 
		this.indeterminateType = indeterminatetype; // progress type
		this.showstatusbar = showstatusbar;
	}

	public void setMessage(String message) {
		this.message = message;
		if( this.mMessage != null ) {
			mMessage.setText(message);
		}
	}

	public void setProgressBar(int current, int total) {
		float percent;

		if (mProgressBar == null)
			return;

		percent = (float) current / total * 100;
		mProgressBar.setProgress((int) percent);
		
		if( mStatus != null ) {
			mStatus.setText("" + (int) percent + "/100");
		}

		// Log.d("EWIRE","PPS:" + current + " / " + total );
	}

	@Override
	public boolean onKeyDown(int keyCode, KeyEvent event) {
		if (event.getAction() == KeyEvent.ACTION_DOWN) {
			if (keyCode == KeyEvent.KEYCODE_BACK) {

			}
		}
		return false;
	}


}
