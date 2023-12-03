package com.entropykorea.gas.main.activity;

import java.util.HashMap;

import junit.framework.TestResult;
import android.content.pm.PackageInfo;
import android.content.pm.PackageManager;
import android.graphics.Color;
import android.os.Bundle;
import android.os.Handler;
import android.view.KeyEvent;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.View.OnLongClickListener;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.TextView;

import com.entropykorea.ewire.eWireUpdate;
import com.entropykorea.gas.lib.R.color;
import com.entropykorea.gas.main.R;
import com.entropykorea.gas.main.activity.ui.TitleBar;
import com.entropykorea.gas.main.activity.ui.TitleBar.OnTopClickListner;
import com.entropykorea.gas.main.activity.view.ViewById;
import com.entropykorea.gas.main.common.Constants;
import com.entropykorea.gas.main.common.PackageName;
import com.entropykorea.gas.main.common.RunActivity;
import com.entropykorea.gas.main.common.Utils;


public class AboutActivity extends BasedActivity implements OnClickListener, OnLongClickListener, OnMenuItemClickListener, OnTopClickListner {

	@ViewById(id=R.id.tv_main_version, click="this")
	TextView mTextMainVersion;

	@ViewById(id=R.id.tv_gum_version, click="this")
	TextView mTextGumVersion;
	
	@ViewById(id=R.id.tv_as_version, click="this")
	TextView mTextAsVersion;
	
	@ViewById(id=R.id.tv_chg_version, click="this")
	TextView mTextChgVersion;
	
	@ViewById(id=R.id.tv_chk_version, click="this")
	TextView mTextChkVersion;
	
	@ViewById(id=R.id.tv_che_version, click="this")
	TextView mTextCheVersion;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		setContentView(R.layout.activity_about);
		super.onCreate(savedInstanceState);

		init();
	}

	private void init() {
		// title
		mTitleBar.setTitle("프로그램 정보");
		mTitleBar.setOnTopClickListner(this);
		mTitleBar.setButtonVisibility(TitleBar.BUTTON_TWO, View.GONE);
		mTitleBar.setButtonVisibility(TitleBar.BUTTON_ONE, View.VISIBLE);
		mTitleBar.setButtonVisibility(TitleBar.BUTTON_BACK, View.GONE);
		//mTitleBar.setButtonEnable(TitleBar.BUTTON_ONE, false);

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
	    
	    mTextMainVersion.setOnLongClickListener(this);
	    mTextGumVersion.setOnLongClickListener(this);
	    mTextAsVersion.setOnLongClickListener(this);
	    mTextChgVersion.setOnLongClickListener(this);
	    mTextChkVersion.setOnLongClickListener(this);
	    mTextCheVersion.setOnLongClickListener(this);
	    
	    //setFields();
	}

	private void setFields() {
		// version
		setVersion( mTextGumVersion, PackageName.GUM.getPackageName() );
		setVersion( mTextAsVersion, PackageName.AS.getPackageName() );
		setVersion( mTextChkVersion, PackageName.CHK.getPackageName() );
		setVersion( mTextChgVersion, PackageName.CHG.getPackageName() );
		setVersion( mTextCheVersion, PackageName.CHE.getPackageName() );
	}

	public void setVersion( TextView textView, String packageName ) {
		String versionName;
		try {
			PackageInfo info = getPackageManager().getPackageInfo(packageName, 0);
			versionName = info.versionName;
			textView.setTextColor(Color.WHITE);
		} catch (PackageManager.NameNotFoundException ignored) {
			versionName = "미설치";
			textView.setTextColor(Color.LTGRAY);
		}
		textView.setText( versionName );
	}

	public void showMenu() {
		View anchor = (View) findViewById( R.id.btn_one );
		showMenu(anchor, R.menu.about);
	}
	
	@Override
	protected void onResume() {
		setFields();
		super.onResume();
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
	
	public void doPackage( PackageName packageName ) {
		
		mPackageName = packageName;
				
		// 재설치 
		confirm( packageName.getPackageString() + " 프로그램을 설치하시겠습니까?", "installPackage", "");
	}

	
	@Override
	public boolean onMenuItemClick(MenuItem item) {
		switch( item.getItemId() ) {
		// 프로그램설치
		case R.id.menu_action_1:
			break;
		case R.id.menu_action_1_0:
			doPackage( PackageName.MAIN );
			break;
		case R.id.menu_action_1_1:
			doPackage( PackageName.GUM );
			break;
		case R.id.menu_action_1_2:
			doPackage( PackageName.AS );
			break;
		case R.id.menu_action_1_3:
			doPackage( PackageName.CHK );
			break;
		case R.id.menu_action_1_4:
			doPackage( PackageName.CHG );
			break;
		case R.id.menu_action_1_5:
			doPackage( PackageName.CHE );
			break;
		}
		return false;
	}
	
	@Override
	public void onClick(View v) {
		switch( v.getId() ) {
		case R.id.tv_gum_version:
			break;
		case R.id.tv_as_version:
			break;
		case R.id.tv_chk_version:
			break;
		case R.id.tv_chg_version:
			break;
		case R.id.tv_che_version:
			break;
		}
	}

	@Override
	public boolean onLongClick(View v) {
		switch( v.getId() ) {
		case R.id.tv_main_version:
			doPackage( PackageName.MAIN );
			break;
		case R.id.tv_gum_version:
			doPackage( PackageName.GUM );
			break;
		case R.id.tv_as_version:
			doPackage( PackageName.AS );
			break;
		case R.id.tv_chk_version:
			doPackage( PackageName.CHK );
			break;
		case R.id.tv_chg_version:
			doPackage( PackageName.CHG );
			break;
		case R.id.tv_che_version:
			doPackage( PackageName.CHE );
			break;
		}
		return false;
	}
	
	@Override
	public boolean onKeyDown(int keyCode, KeyEvent event) {
		if (event.getAction() == KeyEvent.ACTION_DOWN) {
			switch( keyCode ) {
			case KeyEvent.KEYCODE_BACK:
				finish();
				return true;
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

	
}
