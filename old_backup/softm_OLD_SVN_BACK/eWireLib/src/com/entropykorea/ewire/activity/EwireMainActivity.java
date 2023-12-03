package com.entropykorea.ewire.activity;

import java.io.File;
import java.util.HashMap;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.database.SQLException;
import android.database.sqlite.SQLiteDatabase;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import com.entropykorea.ewire.R;
import com.entropykorea.ewire.eWireData;
import com.entropykorea.ewire.eWireTrans;
import com.entropykorea.ewire.spec.CodeSpec;
import com.entropykorea.ewire.spec.UserSpec;

public class EwireMainActivity extends Activity implements View.OnClickListener {
	
		
		private SQLiteDatabase sqlitedatabase = null;

		private EditText editText1 = null; // Server IP
		private EditText editText2 = null; // Port
		private EditText editText3 = null; // User ID
		private EditText editText4 = null; // Command
		private EditText editText5 = null; // Instruction
		private EditText editText6 = null; // Param
		private EditText editText7 = null; // File Name
		private EditText editText8 = null; // Path
		private EditText editText9 = null; // Data
		
		static final int REQUESTCODE_EWIRE = 0;

		@Override
		protected void onCreate(Bundle savedInstanceState) {
			super.onCreate(savedInstanceState);
			setContentView(R.layout.activity_ewire_main);

			//getActionBar().setDisplayShowHomeEnabled(false);

			editText1 = (EditText)findViewById(R.id.editText1);
			editText2 = (EditText)findViewById(R.id.editText2);
			editText3 = (EditText)findViewById(R.id.editText3);
			editText4 = (EditText)findViewById(R.id.editText4);
			editText5 = (EditText)findViewById(R.id.editText5);
			editText6 = (EditText)findViewById(R.id.editText6);
			editText7 = (EditText)findViewById(R.id.editText7);
			editText8 = (EditText)findViewById(R.id.editText8);
			editText9 = (EditText)findViewById(R.id.editText9);
			
			findViewById(R.id.button_ewire_excute).setOnClickListener(this);
			findViewById(R.id.button_data_import_excute).setOnClickListener(this);
			findViewById(R.id.button_data_export_excute).setOnClickListener(this);

			// default value
			editText1.setText("110.8.124.30");
			editText2.setText("4000");
			editText3.setText("userid");
			editText4.setText("C");
			editText5.setText("user_down");
			editText6.setText("DOWN|/down/data.zip");
			editText7.setText("/sdcard/mpgas/data.zip");
			editText8.setText("/sdcard/mpgas");
			editText9.setText("/sdcard/mpgas/data.db");
//			editText4.setText("I");
//			editText5.setText("mp_test");
//			editText6.setText("");
//			editText7.setText("");

//			// 검침다운 
//			editText5.setText("gum_down");
//			editText6.setText("DOWN|/DATA/gum_down.zip|201411|01|20141111|01");
			
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
		protected void onResume() {
			
//			// eWire Broadcastreceiver
//			IntentFilter filter = new IntentFilter();
//			filter.addAction(eWireTrans.BROADCAST_ACTION_EWIRETRANS);
//			filter.addAction(eWireData.BROADCAST_ACTION_EWIREDATA);
//			registerReceiver(eWireReceiver, filter);
			
			super.onResume();
		}

		@Override
		protected void onPause() {
			
//			// eWire Broadcastreceiver		
//			unregisterReceiver(eWireReceiver);

			super.onPause();
		}
		
		@Override
		protected void onDestroy() {
			
			closeDatabase();
			
			super.onDestroy();
		}

		@Override
		public void onClick(View v) {
			int viewId = v.getId();
			if( viewId == R.id.button_ewire_excute ) {
				callTrans();
			} else if( viewId == R.id.button_data_import_excute ) {
				callImport();
			} else if( viewId == R.id.button_data_export_excute ) {
				callExport();
			}
		}
		
		// util
		// for sqlite database
		public boolean openDatabase( String dbfilename ) {
			try {
				if( sqlitedatabase == null ) {
					sqlitedatabase = SQLiteDatabase.openOrCreateDatabase( dbfilename, null );
				}
			} catch (Exception e) {
				e.printStackTrace();
				return false;
			}
			return true;
		}
		
		public void closeDatabase() {
			if( sqlitedatabase == null )
				return;
			sqlitedatabase.close();
		}
		
		public void createTable() {
			String createtable = new String();
			
			if( sqlitedatabase == null )
				return;
			
			createtable = 
				"CREATE TABLE USER                         " + 
				"(                                         " +
				"	USER_ID			VARCHAR2(20) NOT NULL ," +
				"	USER_NM			VARCHAR2(50) NOT NULL ," +
				"	PW 				VARCHAR2(20) NOT NULL ," +
				"	DEPT_CD			CHAR(20) NULL ,        " +
				"	HP_NO			CHAR(30) NULL ,        " +
				"	LEVEL_CD		CHAR(20) NULL ,        " +
				"	PDA_USER_YN		CHAR(1) NULL ,         " +
				"	AREA_CENTER_CD	CHAR(20) NULL ,        " +
				"	GUM_AUTH_YN		CHAR(1) NULL ,         " +
				"	CHG_AUTH_YN		CHAR(1) NULL ,         " +
				"	CHK_AUTH_YN		CHAR(1) NULL ,         " +
				"	REQ_AUTH_YN		CHAR(1) NULL ,         " +
				"	DEF_AUTH_YN		CHAR(1) NULL ,         " +
				"                                          " +
				"	PRIMARY KEY (USER_ID   ASC)            " +
				")";
		
			try {
				sqlitedatabase.execSQL(createtable);
			} catch (SQLException e) {
				e.printStackTrace();			
			}

			createtable = 
				"CREATE TABLE CODE (                  " + 
				"		TYPE_CD VARCHAR2(20) NOT NULL," +  
				"		CD VARCHAR2(20) NOT NULL,     " + 
				"		CD_NM VARCHAR2(100) NOT NULL, " + 
				"		MGT_CHAR1 VARCHAR2(20),       " + 
				"		MGT_CHAR2 VARCHAR2(20),       " + 
				"		MGT_CHAR3 VARCHAR2(20),       " + 
				"		MGT_CHAR4 VARCHAR2(20),       " + 
				"		MGT_CHAR5 VARCHAR2(20),       " + 
				"		MGT_CHAR6 VARCHAR2(20),       " + 
				"		MGT_NUM1 NUMBER,              " + 
				"		MGT_NUM2 NUMBER,              " + 
				"		ORD INTEGER,                  " + 
				"		REMARK VARCHAR2(500),          " + 
				"                                          " +
				"	PRIMARY KEY (TYPE_CD   ASC,CD ASC)            " +
				"	);                                ";

				try {
					sqlitedatabase.execSQL(createtable);
				} catch (SQLException e) {
					e.printStackTrace();			
				}
		
		}
		
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
		
		// eWire
		eWireTrans ewireTrans;
		
		public void callTrans() {
			
			String server_ip = editText1.getText().toString();
			String server_port = editText2.getText().toString();
			String userid = editText3.getText().toString();
			String command = editText4.getText().toString();
			String instruction = editText5.getText().toString();
			String param = editText6.getText().toString();
			String filename = editText7.getText().toString();

			// eWire
			ewireTrans = new eWireTrans( this ){

				@Override
				public void onFinished(boolean result, String resultMessage) {
					if( result ) {
						Toast.makeText(EwireMainActivity.this, resultMessage, Toast.LENGTH_SHORT).show();
					} else {
						Toast.makeText(EwireMainActivity.this, resultMessage, Toast.LENGTH_SHORT).show();
					}
				}
				
			};
			ewireTrans.setServerIp(server_ip);
			ewireTrans.setServerPort(server_port);
			ewireTrans.setUserId(userid);
			ewireTrans.setCommand(command);
			ewireTrans.setInstruction(instruction);
			ewireTrans.setParam(param);
			ewireTrans.setFileName(filename);
			
			// option
			ewireTrans.setDialogType(eWireTrans.DIALOGTYPE_PROGRESS); 
			ewireTrans.setDisplayMessage(eWireTrans.DEFAULT_DISPLAYMESSAGE);
			ewireTrans.setShowError(false);
			ewireTrans.setSoundPlay(true);
			
			ewireTrans.setShowStatusBar(false);
			
			ewireTrans.setDelayTime(1000);
			
			// eWire Thread
			ewireTrans.excuteTrans();
		}
		
		public void callImport() {
			
			String zipfilename = editText7.getText().toString();
			String path = editText8.getText().toString();
			String dbfilename = editText9.getText().toString();
			
			if( !openDatabase( dbfilename ) ) {
				showAlert( "Can open database!" );
				return;
			}
			createTable();
			
			// create directory
			try {
				File f = new File( path );
				if( !f.isDirectory() )
					f.mkdirs();
			} catch (Exception e) {
				e.printStackTrace();
				return;
			}		
			
			// set ewiredata
			eWireData ewireData = new eWireData( this ) {

				@Override
				public void onFinished(boolean result, String resultMessage) {
					if( result ) {
						Toast.makeText(EwireMainActivity.this, resultMessage, Toast.LENGTH_SHORT).show();
					} else {
						Toast.makeText(EwireMainActivity.this, resultMessage, Toast.LENGTH_SHORT).show();
					}
				}

				@Override
				public void preExcute() {
					
				}

				@Override
				public void postExcute() {
					
				}
				
			};
			ewireData.setDatabase( sqlitedatabase );
			ewireData.setZipfilename( zipfilename );
			ewireData.setOutputFolder( path );
			Object[] databasespecication = {
					new UserSpec(),
					new CodeSpec(),
			};
			ewireData.setDatabaseSpecication(databasespecication);
			
			// option
			//ewireData.setDialogType(eWireData.DIALOGTYPE_NONE);
			//ewireData.setDialogType(eWireData.DIALOGTYPE_WAIT);
			//ewireData.setDialogType(eWireData.DIALOGTYPE_PROGRESS);
			ewireData.setDialogType(eWireData.DIALOGTYPE_WAIT_PROGRESS);
			ewireData.setDisplayMessage(eWireData.DEFAULT_DISPLAYMESSAGE);
			ewireData.setShowError(false);
			ewireData.setSoundPlay(false);
			
			ewireData.setShowStatusBar(true);
			ewireData.setDelayTime(1000);

			// onFinished callback
//			ewireData.setOnFinished(new eWireData.onFinished() {
//				@Override
//				public void onFinished(boolean result, String resultMessage) {
//					if( result ) {
//						Toast.makeText(MainActivity.this, resultMessage, Toast.LENGTH_SHORT).show();
//					} else {
//						Toast.makeText(MainActivity.this, resultMessage, Toast.LENGTH_SHORT).show();
//					}
//				}
//			});
			
			// do thread
			ewireData.excuteImport();
			
		}
		
		public void callExport() {
			
			String zipfilename = editText7.getText().toString();
			String path = editText8.getText().toString();
			String dbfilename = editText9.getText().toString();
			
			if( !openDatabase( dbfilename ) ) {
				showAlert( "Can open database!" );
				return;
			}
			
			// create directory
			try {
				File f = new File( path );
				if( !f.isDirectory() )
					f.mkdirs();
			} catch (Exception e) {
				e.printStackTrace();
				return;
			}		
			
			// set ewiredata
			eWireData ewireData = new eWireData( this ) {

				@Override
				public void onFinished(boolean result, String resultMessage) {
					if( result ) {
						Toast.makeText(EwireMainActivity.this, resultMessage, Toast.LENGTH_SHORT).show();
					} else {
						Toast.makeText(EwireMainActivity.this, resultMessage, Toast.LENGTH_SHORT).show();
					}
				}

				@Override
				public void preExcute() {
					
				}

				@Override
				public void postExcute() {
					
				}
				
			};
			ewireData.setDatabase( sqlitedatabase );
			ewireData.setZipfilename( zipfilename );
			ewireData.setOutputFolder( path );
			UserSpec userSpec = new UserSpec();
			userSpec.whereClause = new String( "WHERE USER_ID = 'test'" );
			
			Object[] databasespecication = {
				userSpec,
			};
			ewireData.setDatabaseSpecication(databasespecication);

			// file name only
//			String[] files = FileUtils.getFiles(path, ".bmp");
//			ewireData.setAddFiles( path, files ); // 추가 파일 

			// file name with path
			//String[] filesWithDirectory = FileUtils.getFilesWithDirectory(path, ".bmp");
//			String[] filesWithDirectory = {
//					"/sdcard/mpgas/sign.bmp",
//					"/sdcard/mpgas/test.bmp"
//			};
//			ewireData.setAddFiles( filesWithDirectory ); // 추가 파일 
			
			HashMap<String,String> hashmap = new HashMap<String, String>();
			hashmap.put("sign.bmp", "/sdcard/mpgas/sign.bmp");
			hashmap.put("test.bmp", "/sdcard/mpgas/test.bmp");

			ewireData.setAddFiles( hashmap ); // 추가 파일 
			
			// option 
			ewireData.setDialogType(eWireData.DIALOGTYPE_WAIT);
			ewireData.setDisplayMessage(eWireData.DEFAULT_DISPLAYMESSAGE);
			ewireData.setShowError(false);
			ewireData.setSoundPlay(false);

			ewireData.setDelayTime(1000);
			
			// do
			ewireData.excuteExport();

		}
		
		
//		// eWire Broadcastreceiver
//		BroadcastReceiver eWireReceiver = new BroadcastReceiver() {
//			public void onReceive(Context context, Intent intent) {
//				String action = intent.getAction();
//				String resultMessage;
//				boolean result;
//				
//				if (action.equals(eWireTrans.BROADCAST_ACTION_EWIRETRANS)) {
//					
//					result = intent.getBooleanExtra("RESULT", true);
//					resultMessage = ewireTrans.getResult();
//					
//					if( result ) {
//						Toast.makeText(MainActivity.this, resultMessage, Toast.LENGTH_SHORT).show();
//					} else {
//						Toast.makeText(MainActivity.this, resultMessage, Toast.LENGTH_SHORT).show();
//					}
//					
//					// next 
//				}
//				
//				if (action.equals(eWireData.BROADCAST_ACTION_EWIREDATA)) {
//					
//					result = intent.getBooleanExtra("RESULT", true);
//					resultMessage = ewireData.getResult();
//					
//					if( result ) {
//						Toast.makeText(MainActivity.this, resultMessage, Toast.LENGTH_SHORT).show();
//					} else {
//						Toast.makeText(MainActivity.this, resultMessage, Toast.LENGTH_SHORT).show();
//					}
//					
//				}
//			}
//		};


	}
