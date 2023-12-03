package com.entropykorea.ewire.activity;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.EditText;

import com.entropykorea.ewire.R;
import com.entropykorea.ewire.eWireUpdate;


public class EwireUpdateActivity extends Activity implements OnClickListener {
	
	private EditText editText1 = null; // Update Url
	private EditText editText2 = null; // Name 
	private EditText editText3 = null; // Version
	private EditText editText4 = null; // Down Path
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_ewire_update);

		//getActionBar().setDisplayShowHomeEnabled(false);

		editText1 = (EditText)findViewById(R.id.editText1);
		editText2 = (EditText)findViewById(R.id.editText2);
		editText3 = (EditText)findViewById(R.id.editText3);
		editText4 = (EditText)findViewById(R.id.editText4);
		
		findViewById(R.id.button1).setOnClickListener(this);
		findViewById(R.id.button2).setOnClickListener(this);

		// default value
		editText1.setText("http://110.8.124.30:4001/mobile/setup.xml");
		editText2.setText("mpgas_gum");
		editText3.setText("0.0.1");
		editText4.setText("/sdcard/mpgas");

	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.main, menu);
		return true;
	}

	@Override
	public boolean onOptionsItemSelected(MenuItem item) {
		// Handle action bar item clicks here. The action bar will
		// automatically handle clicks on the Home/Up button, so long
		// as you specify a parent activity in AndroidManifest.xml.
		int id = item.getItemId();
		if (id == R.id.action_settings) {
			return true;
		}
		return super.onOptionsItemSelected(item);
	}
	
	@Override
	public void onClick(View v) {
		int viewId = v.getId();
		if( viewId == R.id.button1 ) {
			checkVersion();
		} else if( viewId == R.id.button2 ) {
			downloadApk();
		}
	}
	
	// util
	public void showAlert( String message ) {
		new AlertDialog.Builder(this)
		//.setIcon(android.R.drawable.ic_dialog_alert)
		//.setCancelable(false)
		//.setTitle(R.string.alert_title)
		.setMessage(message)
		.setPositiveButton( "OK", new DialogInterface.OnClickListener() {
			public void onClick(DialogInterface dialog, int whichButton) {
			}
		})
		.create()
		.show();
	}

	
	public void checkVersion() {
		
		String updateUrl = editText1.getText().toString();
		String packageName = editText2.getText().toString();
		String versionNumber = editText3.getText().toString();
		
		eWireUpdate ewireUpdate = new eWireUpdate( this ) {

			@Override
			public void onFinished(boolean result, String resultMessage) {
				
				if( result ) {
					showAlert( "NEED UPGRADE : server Verion : " + resultMessage );
				} else {
					showAlert( resultMessage );
				}
				
			}
			
		};
		
		ewireUpdate.checkVersion( updateUrl, packageName, versionNumber );
		
	}
	
	public void downloadApk() {

		String updateUrl = editText1.getText().toString();
		String packageName = editText2.getText().toString();
		String versionNumber = editText3.getText().toString();
		String downloadPath = editText4.getText().toString();
		
		eWireUpdate ewireUpdate = new eWireUpdate( this ) {

			@Override
			public void onFinished(boolean result, String resultMessage) {
				
				if( result ) {
					//showAlert( "download ok" + resultMessage );
					this.installApk(resultMessage);
				} else {
					showAlert( "download fail" );
				}
				
			}
			
		};
		
		ewireUpdate.downloadApk(updateUrl, packageName, downloadPath);
	}
	
	
	


}
