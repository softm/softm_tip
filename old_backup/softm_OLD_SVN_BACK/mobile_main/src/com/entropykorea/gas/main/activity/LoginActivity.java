package com.entropykorea.gas.main.activity;

import android.content.Intent;
import android.os.Bundle;
import android.os.CountDownTimer;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.KeyEvent;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.inputmethod.EditorInfo;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.TextView;
import android.widget.TextView.OnEditorActionListener;
import android.widget.Toast;

import com.entropykorea.ewire.Aes256;
import com.entropykorea.ewire.eWireUpdate;
import com.entropykorea.ewire.database.SqliteManager;
import com.entropykorea.ewire.dialog.LongTimeDialog;
import com.entropykorea.gas.main.AppContext;
import com.entropykorea.gas.main.R;
import com.entropykorea.gas.main.activity.ui.TitleBar;
import com.entropykorea.gas.main.activity.ui.TitleBar.OnTopClickListner;
import com.entropykorea.gas.main.activity.view.ViewById;
import com.entropykorea.gas.main.common.Constants;
import com.entropykorea.gas.main.common.Pref;
import com.entropykorea.gas.main.database.DataUtil;
import com.entropykorea.gas.main.ewire.CallTrans;
import com.entropykorea.gas.main.ewire.CallTrans.onFinished;

public class LoginActivity extends BasedActivity implements OnClickListener, OnTopClickListner, OnEditorActionListener {

	private boolean isTwoClickBack = false;

	@ViewById(id = R.id.et_user_id)
	EditText mEditLoginId;

	@ViewById(id = R.id.et_user_pw)
	EditText mEditLoginPw;

	@ViewById(id = R.id.cb_save_id)
	CheckBox mCheckSaveId;

	@ViewById(id = R.id.cb_down_code)
	CheckBox mCheckDownData;

	@ViewById(id = R.id.btn_login, click = "this")
	ImageButton mButtonlogin;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		setContentView(R.layout.activity_login);
		super.onCreate(savedInstanceState);
		
		init();
		
		databaseUpgrade();
	}

	@Override
	protected void onResume() {
		showKeyboard();
		super.onResume();
	}

	@Override
	protected void onPause() {
		hideKeyboard();
		super.onPause();
	}

	private void init() {
		// title
		mTitleBar.setTitle(" 목포도시가스 현장지원 시스템");
		mTitleBar.setOnTopClickListner(this);
		mTitleBar.setButtonVisibility(TitleBar.BUTTON_TWO, View.GONE);
		mTitleBar.setButtonVisibility(TitleBar.BUTTON_ONE, View.GONE);
		//mTitleBar.setButtonVisibility(TitleBar.BUTTON_BACK, View.VISIBLE);
		//mTitleBar.setButtonBackgroundResource(TitleBar.BUTTON_BACK, R.drawable.logo);

		// swipe

		// load pref
		loadPref();
		
		// check down 
		if( DataUtil.isEmpty( "USER" ) ) {
			mCheckDownData.setChecked(true);
		}
		
		// edit
		mEditLoginId.addTextChangedListener(new TextWatcher() {
			
			@Override
			public void onTextChanged(CharSequence s, int start, int before, int count) {
				
			}
			
			@Override
			public void beforeTextChanged(CharSequence s, int start, int count,
					int after) {
				
			}
			
			@Override
			public void afterTextChanged(Editable s) {
				if( s.toString().trim().length() == 0 ) {

				} else {
					mEditLoginId.setError(null);
				}
			}
		});
		
		mEditLoginPw.addTextChangedListener(new TextWatcher() {
			
			@Override
			public void onTextChanged(CharSequence s, int start, int before, int count) {
				
			}
			
			@Override
			public void beforeTextChanged(CharSequence s, int start, int count,
					int after) {
				
			}
			
			@Override
			public void afterTextChanged(Editable s) {
				if( s.toString().trim().length() == 0 ) {

				} else {
					mEditLoginPw.setError(null);
				}
			}
		});
		
		mEditLoginPw.setOnEditorActionListener(this);
		
//		showKeyboard();
	}

	// pref
	private void loadPref() {
		String id = Pref.getUserId(this);
		String pw = Pref.getUserPw(this);
		boolean saveid = Pref.getUserIdSaved(this);

		if (saveid) {
			// id
			mEditLoginId.setText(id);

			if (!Constants.REALESE) {
				// pw
				mEditLoginPw.setText(pw);
			}

			mCheckSaveId.setChecked(saveid);
		}
		
		String eqip_cd = Pref.getEquipCd(this);
		if( eqip_cd.length() == 0 ) {
			eqip_cd = "";
		}
		
		var.EQUIP_CD = eqip_cd;
	}

	private void savePref() {
		String id = getString(mEditLoginId);
		String pw = getString(mEditLoginPw);
		boolean saveid = mCheckSaveId.isChecked();

		Pref.setUserId(this, id);
		Pref.setUserPw(this, pw);
		
		Pref.setUserIdSaved(this, saveid);
		
		var.USER_ID = id;
		saveVar();
	}

	public void goMainMenu() {
		hideKeyboard();
		savePref();
		Intent intent = new Intent(this, MainActivity.class);
		startActivity(intent);
		finish();
	}

	public boolean checkBlank() {

		String id = getString( mEditLoginId );
		String pw = getString( mEditLoginPw );

		if (id.length() == 0) {
			mEditLoginId.requestFocus();
			mEditLoginId.setError("아이디를 입력하세요");
			return false;
		} 
		
		if (pw.length() == 0) {
			mEditLoginPw.requestFocus();
			mEditLoginPw.setError("비밀번호를 입력하세요");
			return false;
		}

		return true;
	}
	
	public void checkLogin() {
		
		if( !checkBlank() ) {
			return;
		}
		
		if( mCheckDownData.isChecked() ) {
			hideKeyboard();
			checkVersion();
			return;
		}
		
		doLogin();
		
	}
	
	public void doLogin() {
		
		String test = Aes256.encode( getString( mEditLoginPw ) );
		log( test );
		
		// ok
		if( DataUtil.existUser( getString( mEditLoginId ), Aes256.encode( getString( mEditLoginPw ) ) ) ) {
			goMainMenu();
			return;
		}
		
		// 비밀번호 틀림
		if( DataUtil.existUser( getString( mEditLoginId ) ) ) {
			//if( Constants.REALESE ) {
				alert( "입력하신 아이디와 비밀번호가 맞지 않습니다." );
				mEditLoginPw.requestFocus();
				return;
			//} else {
			//	// for debug
			//	//goMainMenu();
			//	//return;
			//}
		}

		alert( "입력하신 아이디가 존재하지 않습니다." );
		mEditLoginId.requestFocus();
		
	}
	
	// version check & install
	public void checkVersion() {
		
		String updateUrl = Constants.getUpdateServerUrl();
		String packageName = "mpgas_main";
		String versionNumber = getString(R.string.app_version);
		
		// test
		//versionNumber = "0.1";
		
		eWireUpdate ewireUpdate = new eWireUpdate( this ) {

			@Override
			public void onFinished(boolean result, String resultMessage) {
				
				if( result ) {
					confirm("안정적인 서비스를 위하여 업데이트 프로그램을 설치합니다", "installApk" );
				} else {
					if( resultMessage.length() > 0 ) {
						// 데이타 다운로드
						runUserDown();
					} else {
						alert("잠시후에 다시 시도하십시요");
					}
				}
			}
			
		};
		
		ewireUpdate.checkVersion( updateUrl, packageName, versionNumber );
		
	}
	
	public void installApk() {

		String updateUrl = Constants.getUpdateServerUrl();
		String packageName = "mpgas_main";
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

	private void runUserDown() {
		
		CallTrans callTrans = new CallTrans(this, Constants.getEwireServerIp(), Constants.getEwireServerPort(), var.USER_ID, var.EQUIP_CD);
		
		callTrans.callTrans();
		callTrans.setOnFinished(new onFinished() {
			
			@Override
			public void preExcute() {
				// USER 삭제 
				DataUtil.deleteTable("USER");
			}
			
			@Override
			public void postExcute() {
				
			}
			
			@Override
			public void onFinished(boolean result, String resultMessage) {
				if( result ) {
					doLogin();
				} else {
					
				}
			}
		});
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
						Toast.makeText(LoginActivity.this, db.getErrorMessage(), Toast.LENGTH_SHORT).show();
					}

				}
			}.show();
		}
	}
	

	@Override
	public boolean onEditorAction(TextView v, int actionId, KeyEvent event) {
		if ((actionId == EditorInfo.IME_ACTION_DONE) ||
				(event != null && event.getKeyCode() == KeyEvent.KEYCODE_ENTER)) {
			checkLogin();
		}		
		return false;
	}

	
	
	View mNoDoubleClickView = null;

	@Override
	public void onClick(View v) {
	
		switch (v.getId()) {
		case R.id.btn_login:
			checkLogin();
			break;
		}
	
		if (mNoDoubleClickView != null)
			return;
		v.setClickable(false);
		mNoDoubleClickView = v;
	
		v.postDelayed(new Runnable() {
			@Override
			public void run() {
				mNoDoubleClickView.setClickable(true);
				mNoDoubleClickView = null;
			}
		}, 1000);
	}
	
	@Override
	public boolean onKeyDown(int keyCode, KeyEvent event) {
		if (event.getAction() == KeyEvent.ACTION_DOWN) {
			if (keyCode == KeyEvent.KEYCODE_BACK) {
				if (!isTwoClickBack) {
					// Toast.makeText(this, "'뒤로'버튼을 한번 더 누르시면 종료됩니다.",
					Toast.makeText(this, "다시 눌러 종료하십시요.", Toast.LENGTH_SHORT)
							.show();
					CntTimer timer = new CntTimer(2000, 1);
					timer.start();
				} else {
					finish();
					System.exit(0);
					return true;
				}

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

}
