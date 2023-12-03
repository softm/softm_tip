package com.entropykorea.gas.gum.activity;

import android.os.Bundle;
import android.os.Handler;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.KeyEvent;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.View.OnLongClickListener;
import android.view.inputmethod.EditorInfo;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.CompoundButton.OnCheckedChangeListener;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.LinearLayout;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.ScrollView;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.TextView.OnEditorActionListener;
import android.widget.Toast;
import android.widget.ToggleButton;

import com.entropykorea.ewire.database.Sqlite;
import com.entropykorea.gas.gum.AppContext;
import com.entropykorea.gas.gum.R;
import com.entropykorea.gas.gum.activity.ui.TitleBar;
import com.entropykorea.gas.gum.activity.ui.TitleBar.OnTopClickListner;
import com.entropykorea.gas.gum.activity.view.ViewById;
import com.entropykorea.gas.gum.adapter.CodeAdapter;
import com.entropykorea.gas.gum.adapter.NothingSelectedSpinnerAdapter;
import com.entropykorea.gas.gum.common.DateString;
import com.entropykorea.gas.gum.common.IntegerEx;
import com.entropykorea.gas.gum.common.Saved;
import com.entropykorea.gas.gum.common.Utils;
import com.entropykorea.gas.gum.database.BaseCode;
import com.entropykorea.gas.gum.database.CodeData;

public class ProcessActivity extends BasedActivity implements OnClickListener, OnTopClickListner, OnLongClickListener,OnEditorActionListener, OnMenuItemClickListener {

	// buttons
	@ViewById(id=R.id.btn_street_address, click="this")
	ToggleButton mButtonStreetAddress; // 지번/도로명

	@ViewById(id=R.id.btn_save, click="this")
	ImageButton mButtonSave; // 저장

	@ViewById(id=R.id.btn_cancel, click="this")
	ImageButton mButtonCancel; // 검침취소

	// textview
	@ViewById(id=R.id.tv_bf_mm_meter)
	TextView mTextBfMmMeter; // 지침(전월)

	@ViewById(id=R.id.tv_use_amt)
	TextView mTextUseAmt; // 사용량(당월)

	// editview 
	@ViewById(id=R.id.et_meter)
	EditText mEditMeter; // 지침

	@ViewById(id=R.id.et_adj_meter)
	EditText mEditAdjMeter; // 보정지침

	@ViewById(id=R.id.et_un_adj_meter)
	EditText mEditUnAdjMeter; // 비보정지침

	@ViewById(id=R.id.et_temper)
	EditText mEditTemper; // 온도

	@ViewById(id=R.id.et_pressure)
	EditText mEditPressure; // 압력

	@ViewById(id=R.id.et_rev_factor)
	EditText mEditRevFactor; // 보정계수

	@ViewById(id=R.id.et_comp_factor)
	EditText mEditCompFactor; // 압력계수

	@ViewById(id=R.id.cb_oil_err_yn)
	CheckBox mCheckOilErrYn; // 오일이상

	@ViewById(id=R.id.cb_battery_err_yn)
	CheckBox mCheckBatteryErrYn; // 밧데리이상

	@ViewById(id=R.id.cb_oil_err_yn2)
	CheckBox mCheckOilErrYn2; // 오일이상

	@ViewById(id=R.id.cb_meter_err_yn)
	CheckBox mCheckMeterErrYn; // 계량기이상

	@ViewById(id=R.id.scrollview)
	ScrollView mScrollview;
	
	// spinner 
	@ViewById(id=R.id.sp_meter_cd)
	private Spinner mSpinnerMeterCd = null; // 검침코드

	private BaseCode mBaseCodeMeterCd = null; // 검침코드(데이타)

	// database
	private Sqlite mSqlite = null;
	//private ProcessActivity mContext = null;

	private Saved mSaved = new Saved(); // 저장된 값 비교 
	
	private boolean mEnded = false;
	private boolean mSended = false;

	private boolean mFirstRunning = true; // 최초실행여부 (키보드판단)
	private boolean mUseBgmYn = false; // 보정기사용유무 
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		setContentView(R.layout.activity_process);
		super.onCreate(savedInstanceState);
		//mContext = this;
		
		init();
	}


	private void init() {

		// title
		mTitleBar.setTitle("검침등록");
		//mTitleBar.setButtonVisibility(TitleBar.BUTTON_TWO, View.GONE);
		mTitleBar.setButtonEnable(TitleBar.BUTTON_ONE, false);
		mTitleBar.setButtonBackgroundResource(TitleBar.BUTTON_TWO, R.drawable.info_img);
		mTitleBar.setOnTopClickListner(this);
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
				//ScrollView scrollview = (ScrollView) findViewById( R.id.scrollview );
				switch( direction ) {
				case BasedActivity.SWIPE_DOWN:
					if( mScrollview.getScrollY() == 0 ) { 
						moveCheckUp();
					}
					break;
				case BasedActivity.SWIPE_UP:
					//View view = (View) findViewById( R.id.scrollviewchild );
					//int diff = (view.getBottom()-(scrollview.getHeight()+scrollview.getScrollY()+view.getTop()));// Calculate the scrolldiff
					//if( diff == 0 ){ 
					//	
					//	runActivity(CustomerActivity.class);
					//}
					break;
				case BasedActivity.SWIPE_RIGHT :
					movePrevCheck( false );
					break;
				case BasedActivity.SWIPE_LEFT :
					moveNextCheck( false );
					break;
				}
			}

			@Override
			public void onDoubleTap() {
				//isClaimCust( true );
			}
		});

		// textview
		findViewById(R.id.tv_cust_nm).setOnClickListener(this);
		findViewById(R.id.tv_tel_no_title).setOnClickListener(this);
		findViewById(R.id.tv_tel_no).setOnLongClickListener(this);

		// Sqlite
		mSqlite = new Sqlite(AppContext.getSQLiteDatabase());

		// basecode 검침코드
		mBaseCodeMeterCd = new BaseCode(AppContext.getSQLiteDatabase(), "ME010" );

		// 보정기 사용 세대
		LinearLayout layout = (LinearLayout) findViewById(R.id.layout_container);
		if( isUseBgmYn() ) {
			layout.setVisibility(View.VISIBLE);
		} else {
			layout.setVisibility(View.GONE);
		}

		// 지침(당월)
		mEditMeter.setOnEditorActionListener(this);
		mEditMeter.addTextChangedListener( new TextWatcher() {

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
					mEditMeter.setError(null);
				}
				calcUseAmt();
				setAdjMeter();
			}
		});

		// 근거(당월)
		setSpinner();

		// 보정지침(당월)
		mEditAdjMeter.setOnEditorActionListener(this);
		mEditAdjMeter.addTextChangedListener( new TextWatcher() {

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
					mEditAdjMeter.setError(null);
				}
			}
		});

		// 비보정지침(당월)
		mEditUnAdjMeter.setOnEditorActionListener(this);
		mEditUnAdjMeter.addTextChangedListener( new TextWatcher() {

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
					mEditUnAdjMeter.setError(null);
				}
			}
		});

		// 온도(당월)
		mEditTemper.setOnEditorActionListener(this);

		// 압력(당월)
		mEditPressure.setOnEditorActionListener(this);

		// 보정계수(당월)
		mEditRevFactor.setOnEditorActionListener(this);

		// 압력계수(당월)
		mEditCompFactor.setOnEditorActionListener(this);

		// 밧데리이상
		mCheckBatteryErrYn.setOnCheckedChangeListener(new OnCheckedChangeListener() {

			@Override
			public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
				
					//if( isChecked ) {
					//	mEditAdjMeter.setText("");
					//	mEditUnAdjMeter.setText("");
					//	mEditTemper.setText("");
					//	mEditPressure.setText("");
					//	mEditCompFactor.setText("");
					//	mEditRevFactor.setText("");
					//} else {
					//}
					//setEnabled( mEditAdjMeter, !isChecked );
					//setEnabled( mEditUnAdjMeter, !isChecked );
					//setEnabled( mEditTemper, !isChecked );
					//setEnabled( mEditPressure, !isChecked );
					//setEnabled( mEditCompFactor, !isChecked );
					//setEnabled( mEditRevFactor, !isChecked );

			}
		});
		
	}

	// 세대이동
	private void moveCheckUp() {
		if( isEdited() ) {
			confirm( "변경된 내용을 저장하지 않고 이동하시겠습니까?", "finishActivity", "" );
		} else {
			finishActivity();
		}
	}

	private void movePrevCheck( boolean b ) {
		if( isEdited() ) {
			confirm( "변경된 내용을 저장하지 않고 이동하시겠습니까?", "movePrev", "" );
		} else {
			movePrev( b );
		}
	}

	private void moveNextCheck( boolean b ) {
		if( isEdited() ) {
			confirm( "변경된 내용을 저장하지 않고 이동하시겠습니까?", "moveNext", "" );
		} else {
			moveNext( b );
		}
	}

	/**
	 * 이전화면
	 */
	public void finishActivity() {
		//hideKeyboard();
		finish();
	}

	/**
	 * 이전세대
	 * @param b
	 */
	public void movePrev() {
		movePrev( false );
	}

	public void movePrev(boolean b) {
		if( var.isFirst() ) {
			Toast.makeText(ProcessActivity.this, "첫번째 수용가 입니다.", Toast.LENGTH_LONG).show();
			if( b ) {
				finishActivity();
			}
			return;
		}
		var.setPrev();
		saveVar();
		runActivity( ProcessActivity.class );
		overridePendingTransition(  R.anim.slide_left_in, R.anim.slide_left_out );
		finishActivity();
	}

	/**
	 * 다음세대
	 * @param b
	 */
	public void moveNext() {
		moveNext( true );
	}

	public void moveNext( boolean b ) {
		if( var.isLast() ) {
			Toast.makeText(ProcessActivity.this, "마지막 수용가 입니다.", Toast.LENGTH_LONG).show();
			if( b ) {
				finishActivity();
			}
			return;
		}
		var.setNext();
		saveVar();
		runActivity( ProcessActivity.class );
		overridePendingTransition(  R.anim.slide_right_out, R.anim.slide_right_in );
		finishActivity();
	}

	private void setActivity( boolean clear ) {
		var.setByReadIdx();
		var.setTotalCurrentCount();

		// data
		if( !mSqlite.rawQuery(genSql()) ) {
			Toast.makeText(this, "세대정보를 가져올 수 없습니다. ", Toast.LENGTH_LONG).show();
			finishActivity();
			return;
		}

		// 완료여부
		if( mSqlite.getValue("END_YN").equals("Y") ) {
			mEnded = true;
		} else {
			mEnded = false;
		}
			
		// 전송여부
		if( mSqlite.getValue("SEND_YN").equals("Y") ) {
			mSended = true;
		} else {
			mSended = false;
		}
		
		// title
		mTitleBar.setTitle("검침등록 (" + ( var.current_count + 1 ) + "/" + var.total_count + ")");

		// 주소
		setAddress();

		// fields
		setFields( clear );


		// 클레임고객판단
		boolean isClained = isClaimCust( false );

		// 중지세대판단
		isStopHouse();
		
		// keyboard
		if( !isClained && !clear && !isEnded() && mFirstRunning ) {
			mEditMeter.requestFocus();
			showKeyboard();
		}
		
		mFirstRunning = false;
	}

	private void setFields( boolean clear ) {

		String string, value;
		int position;
		String USE_BGM_YN; // 보정기

		// 보정기유무
		USE_BGM_YN = mSqlite.getValue("USE_BGM_YN");

		// 지침(전월)
		setTextString(R.id.tv_bf_mm_meter,
				Utils.getCommaString(mSqlite.getValue("BF_MM_METER")));
		// 지침(당월)
		string = getString( mEditMeter );
		if ( clear || string.length() == 0) {
			setTextString( mEditMeter,
					(String) mSaved.put("METER", mSqlite.getValue("METER")));
		}
		if( !USE_BGM_YN.equals("Y") ) {
			// 보정기가 아닐 경우 actionDone 으로
			mEditMeter.setImeOptions(EditorInfo.IME_ACTION_DONE);
		}
		setEnabled( mEditMeter, !isEnded() );
		
		// 근거(전월)
		setTextString( R.id.tv_bf_mm_meter_cd,
				BaseCode.getNameByCode(AppContext.getSQLiteDatabase(), "ME010", mSqlite.getValue("BF_MM_METER_CD") ));
		// 근거(당월)
		position = mSpinnerMeterCd.getSelectedItemPosition();
		if( position == 0 ) {
			
			string = mSqlite.getValue("METER_CD");
			
			if( string.length() == 0 ) {
				if( USE_BGM_YN.equals("Y") ) {
					// 보정기의 경우 확인 default
					string = "02";
				} else {
					String loc = mSqlite.getValue("INSTALL_LOC_CD"); // GM130
					// DEFAULT VALUE 
					// 실내 1 실외 2
					if( loc.equals("2") ) {
						//- 실외 : 확인
						string = "02";
					} else {
						//- 실내 : 정상(기존 기록)
						string = "01";
					}
				}
			}
			position = mBaseCodeMeterCd.getIndex(string, CodeData.TYPE_CD);
			mSpinnerMeterCd.setSelection(position + 1); // 정상 01 확인 02
			mSaved.put("METER_CD", string);
		}
		setEnabled( mSpinnerMeterCd, !isEnded() );

		// 사용량(전월)
		setTextString( R.id.tv_bf_mm_use_amt, 
				Utils.getCommaString( mSqlite.getValue("BF_MM_USE_AMT") ) );

		// 사용량(당월) - 자동계산

		// 보정기의 경우
		if( USE_BGM_YN.equals("Y") ) {

			// 보정지침(전월)
			setTextString( R.id.tv_bf_mm_adj_meter, 
					Utils.getCommaString( mSqlite.getValue("BF_MM_ADJ_METER") ) );
			// 보정지침(당월)
			string = mEditAdjMeter.getText().toString();
			if( clear || string.length() == 0 ) {
				value = mSqlite.getValue("ADJ_METER");
				mEditAdjMeter.setText( value );
				mSaved.put("ADJ_METER", value);
			}
			setEnabled( mEditAdjMeter, !isEnded() );

			// 비보정지침(전월)
			setTextString( R.id.tv_bf_mm_un_adj_meter,
					Utils.getCommaString( mSqlite.getValue("BF_MM_UN_ADJ_METER") ) );
			// 비보정지침(당월)
			string = mEditUnAdjMeter.getText().toString();
			if( clear || string.length() == 0 ) {
				value = mSqlite.getValue("UN_ADJ_METER");
				mEditUnAdjMeter.setText( value );
				mSaved.put("UN_ADJ_METER", value);
			}
			setEnabled( mEditUnAdjMeter, !isEnded() );

			// 온도(전월)
			setTextString( R.id.tv_bf_mm_temper, 
					mSqlite.getValue("BF_MM_TEMPER") );
			// 온도(당월)
			string = mEditTemper.getText().toString();
			if( clear || string.length() == 0 ) {
				value = mSqlite.getValue("TEMPER");
				mEditTemper.setText( value );
				mSaved.put("TEMPER", value);
			}
			setEnabled( mEditTemper, !isEnded() );

			// 압력(전월)
			setTextString( R.id.tv_bf_mm_pressure,
					mSqlite.getValue("BF_MM_PRESSURE") );
			// 압력(당월)
			string = mEditPressure.getText().toString();
			if( clear || string.length() == 0 ) {
				value = mSqlite.getValue("PRESSURE");
				mEditPressure.setText( value );
				mSaved.put("PRESSURE", value);
			}
			setEnabled( mEditPressure, !isEnded() );

			// 보정계수(전월)
			setTextString( R.id.tv_bf_mm_rev_factor,
					mSqlite.getValue("BF_MM_REV_FACTOR") );
			// 보정계수(당월)
			string = mEditRevFactor.getText().toString();
			if( clear || string.length() == 0 ) {
				value = mSqlite.getValue("REV_FACTOR");
				mEditRevFactor.setText( value );
				mSaved.put("REV_FACTOR", value);
			}
			setEnabled( mEditRevFactor, !isEnded() );

			// 압력계수(전월)
			setTextString( R.id.tv_bf_mm_comp_factor, 
					mSqlite.getValue("BF_MM_COMP_FACTOR") );
			// 압력계수(당월)
			string = mEditCompFactor.getText().toString();
			if( clear || string.length() == 0 ) {
				value = mSqlite.getValue("COMP_FACTOR");
				mEditCompFactor.setText( value );
				mSaved.put("COMP_FACTOR", value);
			}
			setEnabled( mEditCompFactor, !isEnded() );

			// 오일이상(전월)
			setTextString( R.id.tv_bf_mm_oil_yn,
					mSqlite.getValue("BF_MM_OIL_YN") );
			// 오일이상(당월)
			string = mSqlite.getValue("OIL_YN");
			if( string.equals("Y") ) {
				mCheckOilErrYn.setChecked(true);
				mSaved.put("OIL_YN", "Y");
			} else {
				mCheckOilErrYn.setChecked(false);
				mSaved.put("OIL_YN", "N");
			}
			setEnabled( mCheckOilErrYn, !isEnded() );

			// 밧데리이상(전월)
			setTextString( R.id.tv_bf_mm_battery_yn,
					mSqlite.getValue("BF_MM_BATTERY_YN") );
			// 밧데리이상(당월)
			string = mSqlite.getValue("BATTERY_YN");
			if( string.equals("Y") ) {
				mCheckBatteryErrYn.setChecked(true);
				mSaved.put("BATTERY_YN", "Y");
			} else {
				mCheckBatteryErrYn.setChecked(false);
				mSaved.put("BATTERY_YN", "N");
			}
			setEnabled( mCheckBatteryErrYn, !isEnded() );

		} else {

			// 오일이상
			string = mSqlite.getValue("OIL_YN");
			if( string.equals("Y") ) {
				mCheckOilErrYn2.setChecked(true);
				mSaved.put("OIL_YN", "Y");
			} else {
				mCheckOilErrYn2.setChecked(false);
				mSaved.put("OIL_YN", "N");
			}
			setEnabled( mCheckOilErrYn2, !isEnded() );

			// 계량기 타입이 로타리 및 터빈일 경우 오일이상 유무란 추가되어 저장할 수 있도록 함
			// xml 에서 gone 으로 되어 있음 
			if( isKindCd23() ) {
				mCheckOilErrYn2.setVisibility(View.VISIBLE);
			}
		}

		// 계량기이상
		string = mSqlite.getValue("PDA_METER_ERROR_YN");
		if( string.equals("Y") ) {
			mCheckMeterErrYn.setChecked(true);
			mSaved.put("PDA_METER_ERROR_YN", "Y");
		} else {
			mCheckMeterErrYn.setChecked(false);
			mSaved.put("PDA_METER_ERROR_YN", "N");
		}
		setEnabled( mCheckMeterErrYn, !isEnded() );

		// 고객정보
		Sqlite sqlite = isGumCust();
		if( sqlite != null ) {
			// GUM_CUST 에 데이타가 있으면 
			showCustomer( sqlite );
			sqlite.close();
		} else {
			showCustomer( mSqlite );
		}

		// 쳬납개월
		setTextString( R.id.tv_che_month,
				mSqlite.getValue("CHE_MONTH") );

		// 체납금액
		setTextString( R.id.tv_che_price,
				Utils.getCommaString( mSqlite.getValue("CHE_PRICE") ) );

		// 계량기번호
		setTextString( R.id.tv_gm_no,
				mSqlite.getValue("GM_NO") );
		
		
		// button 
		if( isSended() ) {
			setVisible( mButtonCancel, mButtonSave);
			setEnabled( mButtonCancel, false );
		} else if ( isEnded() ) {
			setVisible( mButtonCancel, mButtonSave);
			setEnabled( mButtonCancel, true );
		} else {
			setVisible( mButtonSave, mButtonCancel );
			setEnabled( mButtonSave, true );
		}

	}

	private Sqlite isGumCust() {
		Sqlite sqlite = new Sqlite( AppContext.getSQLiteDatabase() );
		String format = "SELECT * FROM GUM_CUST WHERE READ_IDX = '%s'";
		String sql = String.format(format, var.READ_IDX);

		if( !sqlite.rawQuery(sql) ) {
			sqlite.close();
			return null;
		}

		if( sqlite.getCount() == 0 ) {
			sqlite.close();
			return null;
		}

		return sqlite;
	}

	private void showCustomer( Sqlite sqlite ) {
		TextView textview;
		String string;

		// 고객명
		setTextString( R.id.tv_cust_nm, 
				sqlite.getValue("CUST_NM") );

		// 연락처
		textview = (TextView) findViewById(R.id.tv_tel_no);
		string = sqlite.getValue("TEL_CD");
		if( string.equals( "H" ) ) {
			textview.setText(sqlite.getValue("TEL_NO"));
		} else if( string.equals( "M" ) ) {
			textview.setText(sqlite.getValue("HP_NO"));
		} else if( string.equals( "C" ) ) {
			textview.setText(sqlite.getValue("WORK_TEL_NO"));
		}
		// jdk 1.7 에서 가능한 코드 
//		switch( string ) {
//		case "H":
//			textview.setText(sqlite.getValue("TEL_NO"));
//			break;
//		case "M":
//			textview.setText(sqlite.getValue("HP_NO"));
//			break;
//		case "C":
//			textview.setText(sqlite.getValue("WORK_TEL_NO"));
//			break;
//		}

	}

	/**
	 * Saved에 저장된 값 비교
	 * @return
	 */
	public boolean isEdited() {
		String string;

		// 지침(당월)
		if ( !mSaved.equals("METER", getString( mEditMeter ) ) ) {
			return true;
		}

		// 근거(당월)
		string = mBaseCodeMeterCd.getCode( mSpinnerMeterCd.getSelectedItemPosition() - 1 );
		if (!mSaved.equals("METER_CD", string)) {
			return true;
		}

		// 보정기
		string = mSqlite.getValue("USE_BGM_YN");
		if (string.equals("Y")) {
			if( mEditAdjMeter.isEnabled() ) {
				// 보정지침(당월)
				if ( !mSaved.equals("ADJ_METER", getString( mEditAdjMeter ) ) ) {
					return true;
				}
				// 비보정지침(당월)
				if ( !mSaved.equals("UN_ADJ_METER", getString( mEditUnAdjMeter ) ) ) {
					return true;
				}
				// 온도
				if ( !mSaved.equals("TEMPER", getString( mEditTemper ) ) ) {
					return true;
				}
				// 압력
				if ( !mSaved.equals("PRESSURE", getString( mEditPressure ) ) ) {
					return true;
				}
				// 보정계수
				if ( !mSaved.equals("REV_FACTOR", getString( mEditRevFactor ) ) ) {
					return true;
				}
				// 압력계수
				if ( !mSaved.equals("COMP_FACTOR", getString( mEditCompFactor ) ) ) {
					return true;
				}
			}
			// 오일이상
			if ( !mSaved.equals("OIL_YN", getChecked( mCheckOilErrYn ) ) ) {
				return true;
			}
			// 밧데리이상
			if ( !mSaved.equals("BATTERY_YN", getChecked( mCheckBatteryErrYn ) ) ) {
				return true;
			}

		} else {
			if( mCheckOilErrYn2.getVisibility() != View.GONE ) {
				// 오일이상
				if ( !mSaved.equals("OIL_YN", getChecked( mCheckOilErrYn2 ) ) ) {
					return true;
				}
			}
		}

		// 계량기이상
		if ( mCheckBatteryErrYn.getVisibility() == View.VISIBLE ) {
			if ( !mSaved.equals("PDA_METER_ERROR_YN", getChecked( mCheckMeterErrYn ) ) ) {
				return true;
			}
		}

		return false;
	}

	public boolean checkEmpty() {

		// 지침
		if( getString( mEditMeter ).length() == 0 ) {
			mEditMeter.setError("필수입력입니다");
			mEditMeter.requestFocus();
			beep();
			return false;
		}

		// 근거
		if( mSpinnerMeterCd.getSelectedItemPosition() == 0 ) {
			return false;
		}

		if( isUseBgmYn() )
		{
			// 보정지침
			if( mEditAdjMeter.isEnabled() ) {
				if( getString( mEditAdjMeter ).length() == 0 ) {
					mEditAdjMeter.setError("필수입력입니다");
					mEditAdjMeter.requestFocus();
					beep();
					return false;
				}
			}
	
			// 비보정지침
			if( mEditUnAdjMeter.isEnabled() ) {
				if( getString( mEditUnAdjMeter ).length() == 0 ) {
					mEditUnAdjMeter.setError("필수입력입니다");
					mEditUnAdjMeter.requestFocus();
					beep();
					return false;
				}
			}
		}

		return true;
	}

	//
	//
	public boolean saveThisCheck() {
		
		// 비어있는지 확인
		if( !checkEmpty() ) {
			return false;
		}
		
		int use_amt = calcUseAmt();
		
		//	검침저장시에 전월보다 검침 값이 낮은(-사용량) 경우 "재 확인" 메시지 표시 후 저장은 가능하도록 함
		//	 - “재확인이 필요합니다. 저장하시겠습니까?” 알림 팝업 후 확인 버튼 터치하면 저장하고, 다음세대로 이동함
		if( use_amt < 0 ){
			confirm( "재확인이 필요합니다. 저장하시겠습니까?", "saveThis", "" );
			return false;
		}
		
		//	▷ 검침저장시에 전년동월에 비해 사용량이 +- 20% 일 경우 "재 확인" 메시지 표시 후 저장은 가능하도록 함
		//	- “재확인이 필요합니다. 저장하시겠습니까?” 알림 팝업 후 확인 버튼 터치하면 저장하고, 다음세대로 이동함
		// 20150121 50% 로 변경 
		int bf_yy_use_amt = mSqlite.getValueInteger("BF_YY_USE_AMT");
		int diff = (int)(bf_yy_use_amt * 0.5);
		
		if( use_amt > ( bf_yy_use_amt + diff ) ||
				use_amt < ( bf_yy_use_amt - diff ) ) {
			confirm( "재확인이 필요합니다. 저장하시겠습니까?", "saveThis", "" );
			return false;
		}
		
		//	▷ 검침저장시에 전월지침과 금월지침이 같은(사용량 0) 경우 계량기 이상 유무 체크 메시지 표시 및 고장유무 체크항목 추가
		//	 - 계량기이상 체크박스 표시 및 “계량기이상 유무 확인바랍니다.” 알림 팝업 후 다시 저장버튼 터치하면 저장하고, 다음세대로 이동함
		if( use_amt == 0 && !getChecked( mCheckMeterErrYn ).equals("Y") ) {
			alert( "계량기이상 유무 확인바랍니다" );
			return false;
		}

		return saveThis();
	}

	private String genSqlField( String fieldName, String fieldValue ) {
		String sql = new String();
		sql = fieldName + "='" + fieldValue + "',";
		return sql;
	}
	
	public boolean saveThis() {
		return saveThis( false );
	}
	
	public boolean saveThis( boolean clear ) {

		String fields = "";
		// 지침
		fields += genSqlField( "METER", clear?"":getString( mEditMeter ) );
		// 근거
		fields += genSqlField( "METER_CD", clear?"":mBaseCodeMeterCd.getCode( mSpinnerMeterCd.getSelectedItemPosition() - 1 ) );

		if( isUseBgmYn() ) {
			// 보정지침
			fields += genSqlField( "ADJ_METER", clear?"":getString( mEditAdjMeter ) );
			// 비보정지침
			fields += genSqlField( "UN_ADJ_METER", clear?"":getString( mEditUnAdjMeter ) );
			// 온도
			fields += genSqlField( "TEMPER", clear?"":getString( mEditTemper ) );
			// 압력
			fields += genSqlField( "PRESSURE", clear?"":getString( mEditPressure ) );
			// 보정계수
			fields += genSqlField( "REV_FACTOR", clear?"":getString( mEditRevFactor ) );
			// 압력계수
			fields += genSqlField( "COMP_FACTOR", clear?"":getString( mEditCompFactor ) );
			// 오일이상
			fields += genSqlField( "OIL_YN", clear?"":getChecked( mCheckOilErrYn ) );
			// 밧데리이상
			fields += genSqlField( "BATTERY_YN", clear?"":getChecked( mCheckBatteryErrYn ) );
		} else {
			// 오일이상
			fields += genSqlField( "OIL_YN", clear?"":getChecked( mCheckOilErrYn2 ) );
		}
		// 계량기이상
		fields += genSqlField( "PDA_METER_ERROR_YN", clear?"":getChecked( mCheckMeterErrYn ) );

		// 검침작업자
		fields += genSqlField( "METER_USER_CD", clear?"":var.USER_ID );
		// 당월검침일자
		fields += genSqlField( "METER_DT", clear?"":DateString.getTodayYMD() );
		// 당월검침시간
		fields += genSqlField( "METER_TIME", clear?"":DateString.getTodayHMS() );
		// 완료여부
		if( clear ) {
			fields += "END_YN='N'";
		} else {
			fields += "END_YN='Y'";
		}
		
		String sql = "UPDATE GUM SET " + fields + " WHERE READ_IDX = '" + var.READ_IDX + "'";
		
		log( sql );
		
		if( !mSqlite.execSql(sql) ) {
			if( clear ) {
				toast( "취소할 수 없습니다" );
			} else {
				toast( "저장할 수 없습니다" );
			}
			return false;
		} else {
			if( clear ) {
				toast( "취소되었습니다" );
			} else {
				toast( "저장되었습니다" );
			}
		}
		
		if( !clear) {
			
			moveNext(true);
		}

		return true;
	}

	public boolean removeThis() {
		if( saveThis( true ) ) {
			setActivity( true );
			scrollUp();
			return true;
		}
		return false;
	}
	
	public void removeThisCheck() {
		confirm( "저장된 검침을 취소하시겠습니까?", "removeThis", "" );
	}
	
	/**
	 * 계량기 입력시 자동으로 보정기 입력
	 */
	public void setAdjMeter() {
		if( mUseBgmYn ) {
			mEditAdjMeter.setText( getString( mEditMeter) );
		}
	}
	
	/**
	 * 사용량 계산 
	 * @param s
	 */
	public int calcUseAmt() {
		// 사용량 = (당월지침-설치지침)+(철거지침-전월지침)
		// METER	당월검침지침
		// INSTALL_METER	설치지침
		// CHG_REMOVE_METER	교체철거지침 
		// BF_MM_METER	전월검침지침 
		int meter, first_install_meter, chg_remove_meter, bf_mm_meter, use_amt;
		String meter_string;

		meter_string = getString( mEditMeter );
		meter = IntegerEx.parseInt( meter_string );
		first_install_meter = IntegerEx.parseInt( mSqlite.getValue("INSTALL_METER") );
		chg_remove_meter = IntegerEx.parseInt( mSqlite.getValue("CHG_REMOVE_METER") );
		//bf_mm_meter = IntegerEx.parseInt( mSqlite.getValue("BF_MM_METER") );
		bf_mm_meter = IntegerEx.parseInt( getString( mTextBfMmMeter ) );
		use_amt = ( meter - first_install_meter ) + ( chg_remove_meter - bf_mm_meter );
		
		//log( "" + use_amt + "=(" + meter + "-" + first_install_meter + ")+(" + chg_remove_meter + "-" + bf_mm_meter + ")");

		if( meter_string.length() == 0 ) {
			mTextUseAmt.setText( "" );
		} else {
			mTextUseAmt.setText( "" + use_amt );
		}

		return use_amt;
	}

	/**
	 * 계량기 타입이 로타리 및 터빈일 경우
	 * @return
	 */
	private boolean isKindCd23() {
		String string = mSqlite.getValue("KIND_CD");
		if( string.equals("2") || string.equals("3") ) {
			return true;
		}
		return false;
	}
	
	/**
	 * 중지세대판단
	 * 수용가상태 : STATUS_CD (공통: MA090), (공급중지 : 04)
	 * @return
	 */
	private boolean isStopHouse() {
		String string = mSqlite.getValue("STATUS_CD");
		if (string.equals("04") && !isEnded() ) {
			confirm("중지세대입니다 검침을 입력하시겠습니까?","","moveNext" );
			beep();
			return true;
		}
		return false;
	}

	/**
	 * 클레임고객판단
	 * 클레임고객여부 : GUM.CLAIM_CUST_YN
	 * 클레임내용 : GUM.CLAIM_CONTENT
	 * @return
	 */
	private boolean mClaimNotShowed = false; // onResume 시 재실행 방지
	private boolean isClaimCust( boolean show ) {
		String string = mSqlite.getValue("CLAIM_CUST_YN");
		String message = mSqlite.getValue("CLAIM_CONTENT");
		if( string.equals("Y") ) {
			if( !mClaimNotShowed || show ) {
				mClaimNotShowed = true; 
				
				if( message.length() == 0 ) {
					message = "클레임고객입니다";
				}

				mTitleBar.setButtonEnable(TitleBar.BUTTON_ONE, true); // 메뉴 클레임 보기 
				showInfoPopup( message );
			}
			return true;
		}
		return false;
	}

	/**
	 * 전송여부판단
	 * @return
	 */
	private boolean isSended() {
//		String string = mSqlite.getValue("SEND_YN");
//		if( string.equals("Y") ) {
//			return true;
//		}
//		return false;
		return mSended;
	}

	/**
	 * 완료여부판단
	 * @return
	 */
	private boolean isEnded() {
//		String string = mSqlite.getValue("END_YN");
//		if( string.equals("Y") ) {
//			return true;
//		}
//		return false;
		return mEnded;
	}

	/**
	 * 보정기사용여부
	 */
	private boolean isUseBgmYn() {
		boolean rtn = false;
		Sqlite sqlite = new Sqlite(AppContext.getSQLiteDatabase());
		String string;

		mUseBgmYn = false;
		
		sqlite.rawQuery("SELECT USE_BGM_YN FROM GUM WHERE READ_IDX = '" + var.READ_IDX + "'");
		string = sqlite.getValue("USE_BGM_YN");
		if( string.equals("Y") ) {
			rtn = true;
			mUseBgmYn = true;
		}

		sqlite.close();
		
		return rtn;
	}

	private void goMenu() {
		View v = (View) findViewById(R.id.btn_one);
		// 클레임 고객
		if( mClaimNotShowed == true ) {
			showMenu(v, R.menu.process_claiim);
		} else {
			
		}
	}
	
	@Override
	protected void onResume() {
		setActivity( false );
		super.onResume();
	}
	
	@Override
	protected void onPause() {
		hideKeyboard();
		super.onPause();
	}

	@Override
	public void onClickBackButton(View v) {
	}

	@Override
	public void onClickOneButton(View v) {
		goMenu();
	}

	@Override
	public void onClickTwoButton(View v) {
		runActivity( CustomerActivity.class );
	}

	@Override
	public void onClick(View v) {
		switch( v.getId() ) {
		// 저장
		case R.id.btn_save:
			saveThisCheck();
			break;
			// 취소
		case R.id.btn_cancel:
			removeThisCheck();
			break;

			// 지번/도로명
		case R.id.btn_street_address:
			setAddress();
			break;
			// 고객명
			//case R.id.tv_cust_nm_title:
			// 연락처
		case R.id.tv_tel_no_title:
			runActivity( CustomerActivity.class );
			break;
		}
	}

	@Override
	public boolean onLongClick(View v) {
		switch( v.getId() ) {
		// 연락처
		case R.id.tv_tel_no:
			String number = getTextString( R.id.tv_tel_no );
			if( number.length() > 0 ) {
				goDial(number);
			}
			break;
		}
		return false;
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

	private void setSpinner() {

		// adapter
		CodeAdapter mAdapter;
		//ArrayList<String> al = mBaseCodeMeterCd.getArrayList();
		//String[] strings = mBaseCodeMeterCd.getStrings();

		mAdapter = new CodeAdapter(this, mBaseCodeMeterCd );
		//mAdapter = new CodeAdapter(this, strings );

		mSpinnerMeterCd.setAdapter( new NothingSelectedSpinnerAdapter( mAdapter, this ) );
		mSpinnerMeterCd.setPrompt("검침코드");
		//mSpinnerMeterCd.setSelection(1); // NothingSelectedSp... 를 사용할 경우 +1 해줘야 함

	}

	private String genSql() {

		String sql = new String();
		String format = "SELECT * FROM GUM WHERE READ_IDX = '%s'";

		sql = String.format(format, var.READ_IDX);

		log(sql);

		return sql;
	}

	private void scrollUp() {
		mScrollview.postDelayed(new Runnable() {
		    @Override
		    public void run() {
		    	mScrollview.fullScroll(ScrollView.FOCUS_UP);
		    }
		}, 600);
	}

	@Override
	public boolean onKeyDown(int keyCode, KeyEvent event) {
		if (event.getAction() == KeyEvent.ACTION_DOWN) {
			switch( keyCode ) {
			case KeyEvent.KEYCODE_BACK:
				moveCheckUp();
				return false;
			case KeyEvent.KEYCODE_MENU:
				new Handler().postDelayed(new Runnable() {
					public void run() {
						goMenu();
	    			}
	    		},100);
				break;
			} 
		}
		return false;
	}

	@Override
	public boolean onMenuItemClick(MenuItem item) {
		switch( item.getItemId() ) {
		case R.id.menu_action_1:
			isClaimCust(true); // 클레임 내용 보기
			break;
		}
		return false;
	}

	@Override
	public boolean onEditorAction(TextView v, int actionId, KeyEvent event) {
		if ((actionId == EditorInfo.IME_ACTION_DONE) ||
				(event != null && event.getKeyCode() == KeyEvent.KEYCODE_ENTER)) {
			hideKeyboard();
			mButtonSave.requestFocus();
		}		
		return false;
	}


}
