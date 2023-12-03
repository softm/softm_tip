package com.entropykorea.gas.gum.activity;

import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.view.KeyEvent;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.TextView;
import android.widget.Toast;

import com.entropykorea.ewire.database.SqliteManager;
import com.entropykorea.ewire.dialog.LongTimeDialog;
import com.entropykorea.gas.gum.AppContext;
import com.entropykorea.gas.gum.R;
import com.entropykorea.gas.gum.activity.ui.TitleBar.OnTopClickListner;
import com.entropykorea.gas.gum.activity.view.ViewById;
import com.entropykorea.gas.gum.common.Constants;
import com.entropykorea.gas.gum.common.Utils;
import com.entropykorea.gas.gum.database.DataUtil;
import com.entropykorea.gas.gum.ewire.CallTrans;
import com.entropykorea.gas.gum.ewire.CallTrans.onFinished;


public class MainActivity extends BasedActivity implements OnClickListener, OnTopClickListner, OnMenuItemClickListener {

	private int notsendcount = 0;
	//private boolean isTwoClickBack = false;
	
	@ViewById(id=R.id.gum_status)
	TextView tvGumStatus;
	
	@ViewById(id=R.id.total_count)
	TextView tvTotalCount;
	
	@ViewById(id=R.id.end_count)
	TextView tvEndCount;
	
	@ViewById(id=R.id.not_end_count)
	TextView tvNotEndCount;
	
	@ViewById(id=R.id.not_send_count)
	TextView tvNotSendCount;
	
	String mREAD_IDX;
	String mBILL_YM;
	String mTURN;
	String mMETER_CREATE_DT;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		setContentView(R.layout.activity_main);
		super.onCreate(savedInstanceState);

		String userId = getIntent().getStringExtra("USER_ID");
		String equipCd = getIntent().getStringExtra("EQUIP_CD");
		String barCdEqipUseYn = getIntent().getStringExtra("BARCD_EQUIP_USE_YN");
		String eWireServerIp = getIntent().getStringExtra("EWIRE_SERVER_IP");
		String eWireServerPort = getIntent().getStringExtra("EWIRE_SERVER_PORT");
		String updateServerUrl = getIntent().getStringExtra("UPDATE_SERVER_URL");
		
		if( Constants.DEBUG ) {
			// for test
			var.USER_ID = "test";
			var.EQUIP_CD = "01";
			var.BARCD_EQUIP_USE_YN = "Y";
			var.EWIRE_SERVER_IP = "110.8.124.30";
			var.EWIRE_SERVER_PORT = "4000";
			var.UPDATE_SERVER_URL = "http://110.8.124.30:4001/mobile/setup.xml";
			
			toast( var.USER_ID + ":" + var.EQUIP_CD + ":" + var.BARCD_EQUIP_USE_YN );
		} else {
			if( userId == null || equipCd == null || barCdEqipUseYn == null || 
				eWireServerIp == null || eWireServerPort == null || updateServerUrl == null ) {

				toast("사용할 수 없는 액세스 입니다");
				finish();
				return;
			}
			
			var.USER_ID = userId;
			var.EQUIP_CD = equipCd;
			var.BARCD_EQUIP_USE_YN = barCdEqipUseYn;
			var.EWIRE_SERVER_IP = eWireServerIp;
			var.EWIRE_SERVER_PORT = eWireServerPort;
			var.UPDATE_SERVER_URL = updateServerUrl;
		}
		
		saveVar();

		init();
		
		databaseUpgrade();
	}

	private void init() {

		// title
	    mTitleBar.setTitle("검침메인");
	    mTitleBar.setOnTopClickListner(this);
	    //mTitleBar.setButtonEnable(TitleBar.BUTTON_ONE, false);
	    //mTitleBar.setButtonBackgroundResource(TitleBar.BUTTON_TWO, android.R.drawable.ic_menu_add);
		
	    // swipe
	    setOnSwipe(this, new OnSwipeListner() {
			@Override
			public void onSwipe(int direction) {
				if( direction == BasedActivity.SWIPE_DOWN ) {
						finish();
				}
			}
			
			@Override
			public void onDoubleTap() {
			}
		});
	    
	    
		// button 
		findViewById(R.id.btn_send).setOnClickListener(this);
		findViewById(R.id.btn_receive).setOnClickListener(this);
		findViewById(R.id.btn_start).setOnClickListener(this);

	}

	private void setActivity() {
		
		String SQL_TOTAL_COUNT = ""
				+ "SELECT READ_IDX, BILL_YM, TURN, METER_CREATE_DT, "
				+ "       COUNT(*) AS TOTAL_COUNT, "
				+ "       COUNT(CASE WHEN END_YN = 'Y' THEN 1 END) AS END_COUNT, "
				+ "       COUNT(CASE WHEN END_YN = 'N' THEN 1 END) AS NOT_END_COUNT, "
				+ "       COUNT(CASE WHEN END_YN = 'Y' AND SEND_YN = 'N' THEN 1 END) AS NOT_SEND_COUNT "
				+ "  FROM GUM";
	
		SqliteManager sqliteManager = AppContext.getSqliteManager();

		if( !sqliteManager.rawQuery(SQL_TOTAL_COUNT) ) {
			Toast.makeText(this, sqliteManager.getErrorMessage(), Toast.LENGTH_LONG).show();
			return;
		}
		
		notsendcount = sqliteManager.getValueInteger( "NOT_SEND_COUNT" );
		
		tvTotalCount.setText( Utils.getCommaString( sqliteManager.getValue( "TOTAL_COUNT" )));
		tvEndCount.setText( Utils.getCommaString( sqliteManager.getValue( "END_COUNT" )));
		tvNotEndCount.setText( Utils.getCommaString( sqliteManager.getValue( "NOT_END_COUNT" )));
		tvNotSendCount.setText( Utils.getCommaString( sqliteManager.getValue( "NOT_SEND_COUNT" )));
		
		// BILL_YM, TURN, METER_CREATE_DT
		
		mREAD_IDX = sqliteManager.getValue( "READ_IDX" );
		mBILL_YM = sqliteManager.getValue( "BILL_YM" );
		mTURN = sqliteManager.getValue( "TURN" );
		mMETER_CREATE_DT = sqliteManager.getValue( "METER_CREATE_DT" );
		int turn = sqliteManager.getValueInteger( "TURN" );
		
		String infoText;
		infoText = "작업년월: "; 
		infoText += mBILL_YM.length() > 0 ? Utils.makeDateString(mBILL_YM) : " ";
		infoText += mTURN.length() > 0 ? String.format("%02d차",  turn) : " ";
		infoText += "\n생성일자: ";
		infoText += mMETER_CREATE_DT.length() > 0 ? Utils.makeDateString(mMETER_CREATE_DT) : "";

		tvGumStatus.setText( infoText );
	}

	public void showMenu() {
		View anchor = (View) findViewById( R.id.btn_one );
		showMenu(anchor, R.menu.main);
	}
	
	@Override
	public void onClickBackButton(View v) {
		
	}

	@Override
	public void onClickOneButton(View v) {
		showMenu(v, R.menu.main);
	}

	@Override
	public void onClickTwoButton(View v) {
		lanchScan(v);
	}

	@Override
	protected void onPause() {
		super.onPause();
	}

	@Override
	protected void onResume() {
		super.onResume();
		setActivity();
	}

	@Override
	public void onClick(View v) {
		switch( v.getId() ) {
		case R.id.btn_send:
			sendTrans();
			break;
		case R.id.btn_receive:
			if( notsendcount > 0 ) {
				confirm( "미송신 자료가 있습니다.\n송신하시겠습니까?", "runGumUp", "" );
				return;
			} else {
				runActivity( ReceiveActivity.class );
			}
			break;
		case R.id.btn_start:
			runActivity( BuildingActivity.class );
			break;
		}
	}

	public void sendTrans() {
		if( notsendcount == 0 ) {
			alert( "송신할 자료가 없습니다" );
			return;
		}

		confirm( "송신하시겠습니까?", "runGumUp", "" );
	}
	
	public void runGumUp() {
		CallTrans callTrans = new CallTrans(this, var.EWIRE_SERVER_IP, var.EWIRE_SERVER_PORT, var.USER_ID, var.EQUIP_CD);
		
		callTrans.callTrans(CallTrans.JOB_GUM_UP, mBILL_YM, mTURN, mMETER_CREATE_DT );
		callTrans.setOnFinished(new onFinished() {
			
			@Override
			public void preExcute(int jobType) {
			}
			
			@Override
			public void postExcute(int jobType) {
				
			}
			
			@Override
			public void onFinished(int jobType, boolean result, String resultMessage) {
				if( result ) {
					// set send_yn
					setSendYn();
					setActivity();
					alert( "송신이 완료되었습니다." );
				} else {
					confirm( "송신이 실패하였습니다. 다시 시도하시겠습니까?", "runGumUp", "" );
				}
			}
		});
	}
	
	private boolean setSendYn() {
		return DataUtil.setSended();
	}
	
	// data upgrade
	public void databaseUpgrade() {

		//SqliteManager sqliteManager = new SqliteManager( this, mApp.getDatabase() );
		SqliteManager sqliteManager = AppContext.getSqliteManager();
		
		if( sqliteManager.isVersionDiff( getString( R.string.db_user_version )) ) {

			new LongTimeDialog( this, "안정적인 서비스를 위하여\n데이타베이스를 업그레이드 중입니다.\n\n잠시만 기다리십시요...", true, sqliteManager ) {

				@Override
				public Boolean doBackground( Object obj ) {

					SqliteManager db = (SqliteManager)obj;

					try {
						Thread.sleep(3000);
					} catch (InterruptedException e) {
						e.printStackTrace();
					}

					// upgrade
					if( !db.upgradeTables( R.raw.createtable, getString( R.string.db_user_version ) ) ) {
						return false;
					}
					return true;
				}

				@Override
				public void doEndExecute( Object obj, Boolean result) {

					SqliteManager db = (SqliteManager)obj;

					if( result ) {
						//Toast.makeText(MainActivity.this, "완료되었습니다.", Toast.LENGTH_SHORT).show();
					} else {
						Toast.makeText(MainActivity.this, db.getErrorMessage(), Toast.LENGTH_SHORT).show();
					}

				}
			}.show();
		}
	}

	@Override
	public boolean onKeyDown(int keyCode, KeyEvent event) {
		if (event.getAction() == KeyEvent.ACTION_DOWN) {
			switch( keyCode ) {
			case KeyEvent.KEYCODE_BACK:
//				if (!isTwoClickBack) {
//					//Toast.makeText(this, "'뒤로'버튼을 한번 더 누르시면 종료됩니다.",
//					Toast.makeText(this, "다시 눌러 종료하십시요.",
//							Toast.LENGTH_SHORT).show();
//					CntTimer timer = new CntTimer(2000, 1);
//					timer.start();
//				} else {
//					finish();
//					//System.exit(0);
//					return true;
//				}
				finish();
				break;
			case KeyEvent.KEYCODE_MENU:
				new Handler().postDelayed(new Runnable() {
					public void run() {
						showMenu();
	    			}
	    		},100);
				break;
			} 
		}
		return false;
	}

//	class CntTimer extends CountDownTimer {
//
//		public CntTimer(long millisInFuture, long countDownInterval) {
//			super(millisInFuture, countDownInterval);
//			isTwoClickBack = true;
//		}
//
//		@Override
//		public void onFinish() {
//			isTwoClickBack = false;
//		}
//
//		@Override
//		public void onTick(long millisUntilFinished) {
//			// Log.i("Test"," isTwoClickBack " + isTwoClickBack);
//		}
//
//	}

	@Override
	public boolean onMenuItemClick(MenuItem item) {
		switch( item.getItemId() ) {
		case R.id.menu_action_1:
			if( isInstalledApplication("com.entropykorea.gas.main") ) {
				try {
					Intent intent = new Intent();
					intent.setClassName("com.entropykorea.gas.main", "com.entropykorea.gas.main.activity.AboutActivity");
					startActivity( intent );
				} catch (Exception e) {
					e.printStackTrace();
				}
			} else {
				alert( getString(R.string.app_name) + " ver. " + getString(R.string.app_version) );
			}
			
			break;
		case R.id.menu_action_2:
			if( isInstalledApplication("com.entropykorea.gas.main") ) {
				try {
					Intent intent = new Intent();
					intent.setClassName("com.entropykorea.gas.main", "com.entropykorea.gas.main.activity.SettingActivity");
					startActivityForResult(intent, 100);
				} catch (Exception e) {
					e.printStackTrace();
				}
			} else {
				//alert( "메인화면에서 지원하지 않습니다." );
			}
			
			break;
		}
		return false;
	}

	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		switch(resultCode) {
		case 100:
			var.BARCD_EQUIP_USE_YN = data.getStringExtra("BARCD_EQUIP_USE_YN");
			saveVar();
			break;
		}
		super.onActivityResult(requestCode, resultCode, data);
	}
	
}
