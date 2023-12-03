package kr.go.citis.main.activity;

import kr.go.citis.lib.TitleView.OnTopClickListner;
import kr.go.citis.lib.Util;
import kr.go.citis.lib.common.Aes256;
import kr.go.citis.lib.common.CallBackEvent;
import kr.go.citis.lib.common.Pref;
import kr.go.citis.lib.type.SiteType;
import kr.go.citis.main.BasicActivity;
import kr.go.citis.main.R;
import kr.go.citis.main.common.DUtil;
import kr.go.citis.main.common.WUtil;
import kr.go.citis.main.dto.LoginDTO;
import kr.go.citis.main.dto.out.LoginDTOOut;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.KeyEvent;
import android.view.View;
import android.view.inputmethod.EditorInfo;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import butterknife.Bind;
import butterknife.OnClick;
import butterknife.OnEditorAction;
import butterknife.OnLongClick;
/**
 * LoginActivity
 * @author softm
 */
public class LoginActivity extends BasicActivity implements OnTopClickListner {
	
	@Bind(R.id.et_user_id)	EditText mEditLoginId;
	@Bind(R.id.et_user_pw)	EditText mEditLoginPw;
	@Bind(R.id.btn_login)	Button   mButtonlogin;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		init();
	}
	
	private void init() {
	    setLayout(R.layout.activity_login,false);
	    setTopTitle(R.string.title_login);	
		getTopTitleBar().setImageResource0(R.drawable.logo_icon);
		
//TODO 제거[로그인정보셋].		
		setText(mEditLoginId,"student01");
		setText(mEditLoginPw,"citis#1234");
		
		// load pref
		loadPref();
		
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
		
//		mEditLoginPw.setOnEditorActionListener(this);
		
//		showKeyboard();
	}

	// pref
	private void loadPref() {
	}

	private void savePref() {
		String id = getString(mEditLoginId);
		String pw = getString(mEditLoginPw);

		Pref.setUserId(this, id);
		Pref.setUserPw(this, pw);
		
	}

	public void goMainMenu() {
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
		
		doLogin();
	}
	
	public void doLogin() {
		startProgressBar();
		String test = Aes256.encode( getString( mEditLoginPw ) );
		hideKeyboard();
		log( test );
		
		WUtil.setEnvironMent(this);
		
		if( DUtil.existUser( LoginActivity.this, getString( mEditLoginId ), ( getString( mEditLoginPw ) ), new CallBackEvent (){
			@Override
			public void success(String eventId,final Object dto) {
 				LoginDTO data = (LoginDTO) dto;
				var.USER_ID = data.getUserid();		
				var.USER_NM = data.getUsernm();
				if        ( SiteType.SIGONG.getTypeCd().equals(data.getSiteType()) ) { // 시공사
					var.SITE_TYPE =  SiteType.SIGONG;
				} else if ( SiteType.GAMRI.getTypeCd().equals(data.getSiteType()) ) { // 감리사
					var.SITE_TYPE =  SiteType.GAMRI;
				}
				Util.i(data.toString());
				saveVar();				
				savePref();
				Util.i(var);
				goMainMenu();
			}
			@Override
			public void error(String eventId,Object dto) {
				LoginDTOOut data = ((LoginDTOOut) dto);
//				data.getMsg()
				alert(data.getMsg(),new DialogInterface.OnClickListener() {
					@Override
					public void onClick(DialogInterface dialog, int which) {
					}
				});

			}
        }  ) ) {
			return;
		}
		setFocus(mEditLoginId);
	}
	
	@OnEditorAction({R.id.et_user_pw})
	public boolean onEditorAction(TextView v, int actionId, KeyEvent event) {
		if ((actionId == EditorInfo.IME_ACTION_DONE) ||
				(event != null && event.getKeyCode() == KeyEvent.KEYCODE_ENTER)) {
			checkLogin();
		}		
		return false;
	}
	
	View mNoDoubleClickView = null;
	@OnClick({ R.id.btn_login })
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

	@OnLongClick({ R.id.body })
	public boolean onLongClick(View v) {
		switch (v.getId()) {
		case R.id.body:
			Intent sIntent5 = new Intent(LoginActivity.this,SetupActivity.class); //설정
			startActivity(sIntent5);	
			break;
		}
		return false;
	}
	
	@Override
	public void onClickMainButton(View v) {
		
	}

	@Override
	public void onClickOneButton(View v) {
		
	}

	@Override
	public void onClickTwoButton(View v) {
		
	}	
	
	public void exit() {
		finish();
		System.exit(0);
	}
//	
	@Override
	protected void onResume() {
			onResum2();
		super.onResume();
	}
	
	public void onResum2() {
		showKeyboard();
	}

	@Override
	protected void onPause() {
		hideKeyboard();
		super.onPause();
	}
	
}
