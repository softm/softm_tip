package com.entropykorea.gas.gum.activity;

import android.os.Bundle;
import android.telephony.PhoneNumberFormattingTextWatcher;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.KeyEvent;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.View.OnLongClickListener;
import android.view.inputmethod.EditorInfo;
import android.widget.CompoundButton;
import android.widget.CompoundButton.OnCheckedChangeListener;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.RadioButton;
import android.widget.ScrollView;
import android.widget.TextView;
import android.widget.TextView.OnEditorActionListener;
import android.widget.Toast;
import android.widget.ToggleButton;

import com.entropykorea.ewire.database.Sqlite;
import com.entropykorea.gas.gum.AppContext;
import com.entropykorea.gas.gum.R;
import com.entropykorea.gas.gum.activity.ui.TitleBar;
import com.entropykorea.gas.gum.activity.view.ViewById;
import com.entropykorea.gas.gum.common.Constants;
import com.entropykorea.gas.gum.common.DLog;
import com.entropykorea.gas.gum.common.Utils;
import com.entropykorea.gas.gum.database.DataUtil;

public class CustomerActivity extends BasedActivity implements OnClickListener, OnLongClickListener, OnCheckedChangeListener, OnEditorActionListener {

	// buttons
	@ViewById(id=R.id.btn_street_address, click="this")
	ToggleButton mButtonStreetAddress;
	
	@ViewById(id=R.id.btn_save, click="this")
	ImageButton mButtonSave;

	@ViewById(id=R.id.rb_tel_no)
	RadioButton mRadioTelNo;
	
	@ViewById(id=R.id.rb_hp_no)
	RadioButton mRadioHpNo;
	
	@ViewById(id=R.id.rb_work_tel_no)
	RadioButton mRadioWorkTelNo;
	
	// edit
	@ViewById(id=R.id.et_cust_nm)
	EditText mEditCustNm; // 고객명
	
	@ViewById(id=R.id.et_tel_no)
	EditText mEditTelNo; // 자택
	
	@ViewById(id=R.id.et_hp_no)
	EditText mEditHpNo; // 이동
	
	@ViewById(id=R.id.et_work_tel_no)
	EditText mEditWorkTelNo; // 회사

	// text
	@ViewById(id=R.id.tv_cust_nm)
	TextView mTextCustNm; // 고객명(TEXT)
	
	// database
	private Sqlite mSqlite = null;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		setContentView(R.layout.activity_customer);
		super.onCreate(savedInstanceState);
			
		init();
	}

	private void init() {
		// title
	    mTitleBar.setTitle("고객정보");
	    //mTitleBar.setButtonVisibility(TitleBar.BUTTON_ONE, View.GONE);
	    mTitleBar.setButtonVisibility(TitleBar.BUTTON_TWO, View.GONE);
	    mTitleBar.setButtonEnable(TitleBar.BUTTON_ONE, false);
	    mTitleBar.setOnClickTitleText(new TitleBar.OnClickTitleText() {

	    	@Override
	    	public void OnClickTitleText(View v) {
	    		mTitleBar.setTitle( "" + var.HOUSE_NO );
	    	}
	    });

	    // swipe
	    setOnSwipe(this, new OnSwipeListner() {
			@Override
			public void onSwipe(int direction) {
				if( direction == BasedActivity.SWIPE_DOWN ) {
					ScrollView scrollview = (ScrollView) findViewById( R.id.scrollview );
					if( scrollview.getScrollY() == 0 ) { 
						finish();
					}
				}
			}
			
			@Override
			public void onDoubleTap() {
				
			}
		});
	    
		// edit
		mEditCustNm.addTextChangedListener(new TextWatcher() {
			
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
					mEditCustNm.setError("필수항목입니다");
				} else {
					mEditCustNm.setError(null);
				}
			}
		}); 
		
		// 자택
		//mEditTelNo.addTextChangedListener(new PhoneNumberFormattingTextWatcher());
		//mEditTelNo.addTextChangedListener(PhoneNumberTextWatcher);
		// 이동
		//mEditHpNo.addTextChangedListener(new PhoneNumberFormattingTextWatcher());
		//mEditHpNo.addTextChangedListener(PhoneNumberTextWatcher);
		// 회사
		//mEditWorkTelNo.addTextChangedListener(new PhoneNumberFormattingTextWatcher());
		//mEditWorkTelNo.addTextChangedListener(PhoneNumberTextWatcher);
		mEditWorkTelNo.setOnEditorActionListener(this); // done
		
		// text
		// 고객명
		mTextCustNm.setOnLongClickListener(this);
		
		// radiobutton : RadioGroup 대신 Listener 로 처리
		mRadioTelNo.setOnCheckedChangeListener( this ); // 자택
		mRadioHpNo.setOnCheckedChangeListener( this ); // 이동
		mRadioWorkTelNo.setOnCheckedChangeListener( this ); // 회사
		
		// Sqlite
		mSqlite = new Sqlite(AppContext.getSQLiteDatabase());

		// data
		if( !mSqlite.rawQuery(genSql( "GUM_CUST" )) ) {
		}
		
		if( mSqlite.getCount() == 0 ) {
			if( !mSqlite.rawQuery(genSql( "GUM" )) ) {
				Toast.makeText(this, "세대정보를 가져올 수 없습니다", Toast.LENGTH_LONG).show();
				finish();
				return;
			}
		}

	}
	
	private void setActivity() {
		var.setByReadIdx();
		var.setTotalCurrentCount();
		
		// 주소
		setAddress();
		
		// fields
		setFields();
	}

	private void saveActivity() {

		String string = new String();
		String TEL_CD = new String();
		
		// Check 
		if( getString( mEditCustNm ).length() == 0 ) {
			mEditCustNm.setError("필수입력입니다");
			mEditCustNm.requestFocus();
			return;
		}
		
//		string = getString( mEditTelNo );
//		if( string.length() != 0 && !Utils.isPhoneNumber(string)) {
//			mEditTelNo.setError("잘못된 전화번호 입니다");
//			mEditTelNo.requestFocus();
//			return;
//		}
//
//		string = getString( mEditHpNo );
//		if( string.length() != 0 && !Utils.isPhoneNumber(string)) {
//			mEditHpNo.setError("잘못된 전화번호 입니다");
//			mEditHpNo.requestFocus();
//			return;
//		}
//	
//		string = getString( mEditWorkTelNo );
//		if( string.length() != 0 && !Utils.isPhoneNumber(string)) {
//			mEditWorkTelNo.setError("잘못된 전화번호 입니다");
//			mEditWorkTelNo.requestFocus();
//			return;
//		}
		
		if( mRadioTelNo.isChecked() ) {
			TEL_CD = "H";
			string = getString( mEditTelNo );
			if( string.length() == 0 ) {
				mEditTelNo.setError("전화번호를 입력하십시요");
				mEditTelNo.requestFocus();
				return;
			}
		} else if( mRadioHpNo.isChecked() ) {
			TEL_CD = "M";
			string = getString( mEditHpNo );
			if( string.length() == 0 ) {
				mEditHpNo.setError("잘못된 전화번호 입니다");
				mEditHpNo.requestFocus();
				return;
			}
		} else if( mRadioWorkTelNo.isChecked() ) {
			TEL_CD = "C";
			string = getString( mEditWorkTelNo );
			if( string.length() == 0 ) {
				mEditWorkTelNo.setError("잘못된 전화번호 입니다");
				mEditWorkTelNo.requestFocus();
				return;
			}
		}
		
		// sql
		String format = "" +
				"INSERT OR REPLACE INTO GUM_CUST " +
				" (READ_IDX,BILL_YM,TURN,METER_CREATE_DT,HOUSE_NO,CUST_NO,CUST_NM,TEL_NO,WORK_TEL_NO,HP_NO,TEL_CD) " +
				" VALUES" +
				" ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')";
		String sql = String.format(format,
				var.READ_IDX,
				var.BILL_YM,
				var.TURN,
				var.METER_CREATE_DT,
				var.HOUSE_NO,
				var.CUST_NO,
				getString( mEditCustNm ),
				getString( mEditTelNo ),
				getString( mEditWorkTelNo ),
				getString( mEditHpNo ),
				TEL_CD
				);
		
		log( sql );
		
		if( !mSqlite.execSql(sql) ) {
			toast( "저장할 수 없습니다" );
		} else {
			toast( "저장되었습니다" );
			finish();
		}
	}
	
	private void setFields() {
		
		String string;
		
		string = mSqlite.getValue("CUST_NM");
		
		// 고객명
		if( !isEditFilled( mEditCustNm ) ) {
			mEditCustNm.setText(string);
		}
		
		mTextCustNm.setText(string);
		
		if( string.length() > 0 ) {
			mEditCustNm.setVisibility(View.GONE);
			mTextCustNm.setVisibility(View.VISIBLE);
			//mEditCustNm.setEnabled(false);
			//mEditCustNm.setFocusable(false);
		}
		
		// 자택
		if( !isEditFilled( mEditTelNo ) ) {
			mEditTelNo.setText(mSqlite.getValue("TEL_NO"));
		}
		
		// 이동
		if( !isEditFilled( mEditHpNo ) ) {
			mEditHpNo.setText(mSqlite.getValue("HP_NO"));
		}
		
		// 회사
		if( !isEditFilled( mEditWorkTelNo ) ) {
			mEditWorkTelNo.setText(mSqlite.getValue("WORK_TEL_NO"));
		}
		
		// radio button
		string = mSqlite.getValue("TEL_CD");
		// 체크가 있다면 이전 상태로 판단
		if( !isRadioChecked( mRadioTelNo, mRadioHpNo, mRadioWorkTelNo ) ) {
			if( string.equals( "H" ) ) {
				mRadioTelNo.setChecked(true);
			} else if( string.equals( "M" ) ) {
				mRadioHpNo.setChecked(true);
			} else if( string.equals( "C" ) ) {
				mRadioWorkTelNo.setChecked(true);
			}
			// 1.7 용
//			switch( string ) {
//			case "H":
//				mRadioTelNo.setChecked(true);
//				break;
//			case "M":
//				mRadioHpNo.setChecked(true);
//				break;
//			case "C":
//				mRadioWorkTelNo.setChecked(true);
//				break;
//			}
		}
		
		// button
		if( isSended() ) {
			setEnabled( mEditCustNm, false );
			setEnabled( mEditTelNo, false );
			setEnabled( mEditHpNo, false );
			setEnabled( mEditWorkTelNo, false );
			setEnabled( mRadioTelNo, false );
			setEnabled( mRadioHpNo, false );
			setEnabled( mRadioWorkTelNo, false );
			// 저장
			setEnabled( mButtonSave, false );
		}
	}

	private void setAddress() {
	
		TextView textView = (TextView) findViewById(R.id.tv_address);
		String address;
		String CO_NM = mSqlite.getValue("CO_NM");
		
		if( mButtonStreetAddress.isChecked() ) {
			address = var.ADDRESS_1;
		} else {
			address = var.ADDRESS_2;
		}
		address += "\n" + mSqlite.getValue("ROOM_NO") + " ";
		if( CO_NM.length() > 0 ) {
			address += CO_NM;
		} else {
			address += mSqlite.getValue("CUST_NM");
		}
		
		textView.setText( address );
	}

	private String genSql( String from ) {
	
		// SELECT
		String format = "SELECT * FROM %s WHERE READ_IDX = '%s'";
		String sql = new String();
		
		sql = String.format(format, from, var.READ_IDX);

		DLog.d(sql);
	
		return sql;
	}

	/**
	 * 전송 여부 판단
	 */
	private boolean isSended() {
		return DataUtil.isSended( var.READ_IDX );
	}
	
	@Override
	protected void onResume() {
		setActivity();
		super.onResume();
	}

	TextWatcher PhoneNumberTextWatcher = new TextWatcher() {
		
		private boolean mSelfChange = false;
		
		@Override
		public void onTextChanged(CharSequence s, int start, int before, int count) {
		}
		
		@Override
		public void beforeTextChanged(CharSequence s, int start, int count,
				int after) {
		}
		
		@Override
		public void afterTextChanged(Editable s) {
			
			if( mSelfChange ) {
				return;
			}
			
			checkReformated( mEditTelNo );
			checkReformated( mEditHpNo );
			checkReformated( mEditWorkTelNo );
		}
		
		private void checkReformated(EditText editText) {
			String string;
			
			string = getString( editText );
			if( string.length() != 0 ) {
				
				if( !Utils.isPhoneNumber2(string)) {
					editText.setError("잘못된 전화번호 입니다");
				} else {
					editText.setError(null);
				}
			}
		}
		
	};
	
	@Override
	public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
		if( isChecked ) {
			mRadioTelNo.setChecked(false);
			mRadioHpNo.setChecked(false);
			mRadioWorkTelNo.setChecked(false);
			buttonView.setChecked(true);
		}
	}

	@Override
	public void onClick(View v) {
		switch( v.getId() ) {
		// 저장
		case R.id.btn_save:
			saveActivity();
			break;
		// 지번/도로명
		case R.id.btn_street_address:
			setAddress();
			break;
		}
	}
	
	@Override
	public boolean onLongClick(View v) {
		switch( v.getId() ) {
		// 고객명 
		case R.id.tv_cust_nm:
			if( Constants.DEBUG ) {
				// 전송전이라면 에디트로 변경 가능 (디버그)
				if( !isSended() ) {
					mEditCustNm.setVisibility(View.VISIBLE);
					mTextCustNm.setVisibility(View.GONE);
				}
			}
			break;
		}
		return false;
	}


	@Override
	public boolean onEditorAction(TextView v, int actionId, KeyEvent event) {
		switch( v.getId() ) {
		case R.id.et_work_tel_no:
			// 전송전이라면 저장
			if( !isSended() ) {
				if ((actionId == EditorInfo.IME_ACTION_DONE) ||
						(event != null && event.getKeyCode() == KeyEvent.KEYCODE_ENTER)) {
					saveActivity();
				}		
			}
			break;
		}
		return false;
	}
	
}
