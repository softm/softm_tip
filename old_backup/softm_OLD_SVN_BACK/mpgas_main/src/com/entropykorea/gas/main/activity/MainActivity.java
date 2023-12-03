package com.entropykorea.gas.main.activity;

import java.util.HashMap;

import android.content.Intent;
import android.os.Bundle;
import android.os.CountDownTimer;
import android.os.Handler;
import android.view.KeyEvent;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ImageButton;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.Toast;

import com.entropykorea.ewire.eWireUpdate;
import com.entropykorea.gas.main.R;
import com.entropykorea.gas.main.activity.ui.TitleBar;
import com.entropykorea.gas.main.activity.view.ViewById;
import com.entropykorea.gas.main.common.Constants;
import com.entropykorea.gas.main.common.PackageName;
import com.entropykorea.gas.main.common.RunActivity;
import com.entropykorea.gas.main.database.DataUtil;
import com.entropykorea.gas.main.ewire.CheckUpdate;


public class MainActivity extends BasedActivity implements OnClickListener, OnMenuItemClickListener {
	
	private boolean isTwoClickBack = false;
	
	@ViewById(id=R.id.btn_gum, click="this")
	ImageButton mButtonGum;
	
	@ViewById(id=R.id.btn_che, click="this")
	ImageButton mButtonChe;
	
	@ViewById(id=R.id.btn_as, click="this")
	ImageButton mButtonAs;
	
	@ViewById(id=R.id.btn_chg, click="this")
	ImageButton mButtonChg;
	
	@ViewById(id=R.id.btn_chk, click="this")
	ImageButton mButtonChk;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		setContentView(R.layout.activity_main);
		super.onCreate(savedInstanceState);

		init();
	}
	
	private void init() {
		// title
		mTitleBar.setTitle(" 목포도시가스 현장지원 시스템");
		mTitleBar.setOnTopClickListner(this);
		mTitleBar.setButtonVisibility(TitleBar.BUTTON_TWO, View.GONE);
		mTitleBar.setButtonVisibility(TitleBar.BUTTON_ONE, View.VISIBLE);
		//mTitleBar.setButtonVisibility(TitleBar.BUTTON_BACK, View.VISIBLE);
		//mTitleBar.setButtonBackgroundResource(TitleBar.BUTTON_BACK, R.drawable.logo);
		
		// swipe
	}

	@Override
	protected void onResume() {
		checkUpgradable();
		super.onResume();
	}

	private PackageName mPackageName;

	public void installPackage() {

		String updateUrl = Constants.getUpdateServerUrl();
		String packageName = mPackageName.getPackageCode();
		//String versionNumber = context.getString(R.string.app_version);
		String downloadPath = Constants.main_path;
		
		eWireUpdate ewireUpdate = new eWireUpdate( this ) {

			@Override
			public void onFinished(boolean result, String resultMessage) {
				
				if( result ) {
					this.installApk(resultMessage);
					//finish();
					//System.exit(0);
				} else {
					alert( "내려받기 실패입니다. 잠시후에 다시 시도하십시요." );
				}
				
			}
		};
		
		ewireUpdate.downloadApk(updateUrl, packageName, downloadPath);
	}
	
	private boolean checkAuth(PackageName packageName) {
		String authField = "";

		if( packageName.equals( PackageName.GUM ) ) {
			authField = "GUM_AUTH_YN";
		} else if( packageName.equals( PackageName.AS ) ) {
			authField = "REQ_AUTH_YN";
		} else if( packageName.equals( PackageName.CHG ) ) {
			authField = "CHG_AUTH_YN";
		} else if( packageName.equals( PackageName.CHK ) ) {
			authField = "CHK_AUTH_YN";
		} else if( packageName.equals( PackageName.CHE ) ) {
			authField = "DEF_AUTH_YN";
		}
		
		return DataUtil.getAuth( var.USER_ID, authField );
	}
	
	public void doPackage( PackageName packageName ) {
		
		HashMap<String, String> putExtra = new HashMap<String,String>();
		
		mPackageName = packageName;
		
		// check EQIP_CD
		if( var.EQUIP_CD.length() != 2 ) {
			//alert("기기번호를 설정하지 않았습니다");
			confirm("기기번호를 설정하지 않았습니다\n지금 설정하시겠습니까?", "doSetting", "");
			return;
		}
		
		// check auth
		if( !checkAuth( packageName ) ) {
			alert("사용권한이 없습니다.\n관리소에 문의 하십시요");
			return;
		}
		
		// collect intent string
		putExtra.put("USER_ID", var.USER_ID);
		putExtra.put("EQUIP_CD", var.EQUIP_CD);
		putExtra.put("BARCD_EQUIP_USE_YN", var.BARCD_EQUIP_USE_YN);
		putExtra.put("EWIRE_SERVER_IP", Constants.getEwireServerIp() );
		putExtra.put("EWIRE_SERVER_PORT", Constants.getEwireServerPort() );
		putExtra.put("UPDATE_SERVER_URL", Constants.getUpdateServerUrl() );
		
		putExtra.put("USER_NM", var.USER_NM);
		putExtra.put("AREA_CENTER_CD", var.AREA_CENTER_CD);
		
		// run
		if( RunActivity.runActivity( this, packageName, putExtra ) ) {
			return;
		}
		
		// 미설치 
		confirm( packageName.getPackageString() + " 프로그램을 설치하시겠습니까?", "installPackage", "");
	}
	
	

	@Override
	public void onClick(View v) {
		// TODO Auto-generated method stub
		switch (v.getId()) {
		case R.id.btn_gum:
			doPackage( PackageName.GUM );
			break;
		case R.id.btn_as:
			doPackage( PackageName.AS );
			break;
		case R.id.btn_che:
			doPackage( PackageName.CHE );
			break;
		case R.id.btn_chg:
			doPackage( PackageName.CHG );
			break;
		case R.id.btn_chk:
			doPackage( PackageName.CHK );
			break;
		}
	}
	
	public void doSetting() {
		Intent intent = new Intent(this, SettingActivity.class);
		intent.putExtra("ENABLE", true);
		startActivity( intent );
	}
	
	@Override
	public boolean onMenuItemClick(MenuItem item) {
		switch( item.getItemId() ) {
		// 환경설정
		case R.id.menu_action_1:
			runActivity(AboutActivity.class);
			break;
		// 프로그램 정보
		case R.id.menu_action_2:
			doSetting();
			//runActivity(SettingActivity.class);
			break;
		}
		return false;
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
		showMenu();
	}

	@Override
	public void onClickTwoButton(View v) {
		
	}
	
	@Override
	public boolean onKeyDown(int keyCode, KeyEvent event) {
		if (event.getAction() == KeyEvent.ACTION_DOWN) {
			switch( keyCode ) {
			case KeyEvent.KEYCODE_BACK:
				if (!isTwoClickBack) {
					//Toast.makeText(this, "'뒤로'버튼을 한번 더 누르시면 종료됩니다.",
					Toast.makeText(this, "다시 눌러 종료하십시요.",
							Toast.LENGTH_SHORT).show();
					CntTimer timer = new CntTimer(2000, 1);
					timer.start();
				} else {
					finish();
					System.exit(0);
					return true;
				}
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

	class CntTimer extends CountDownTimer {

		public CntTimer(long millisInFuture, long countDownInterval) {
			super(millisInFuture, countDownInterval);
			isTwoClickBack = true;
		}

		@Override
		public void onFinish() {
			isTwoClickBack = false;
		}

		@Override
		public void onTick(long millisUntilFinished) {
			// Log.i("Test"," isTwoClickBack " + isTwoClickBack);
		}

	}

	
	public void checkUpgradable() {
		CheckUpdate checkUpdate = new CheckUpdate( this ) {

			@Override
			public void onFinished(boolean result, PackageName packageName, String resultMessage) {
				if( result ) {
					mPackageName = packageName;
					confirm( packageName.getPackageString() + " 프로그램이 업데이트 되었습니다\n지금 설치하시겠습니까?", "installPackage", "");					
				} else {
					
				}
			}
			
		};
		checkUpdate.check();
	}
	
	
}
