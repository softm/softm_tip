package com.entropykorea.gas.gum.activity;

import java.util.ArrayList;
import java.util.Calendar;

import android.content.Context;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.TextView;

import com.entropykorea.ewire.eWireUpdate;
import com.entropykorea.ewire.database.Sqlite;
import com.entropykorea.gas.gum.AppContext;
import com.entropykorea.gas.gum.R;
import com.entropykorea.gas.gum.activity.ui.NoAdapterSpinner;
import com.entropykorea.gas.gum.activity.ui.NoAdapterSpinner.OnPerformClick;
import com.entropykorea.gas.gum.activity.ui.TitleBar;
import com.entropykorea.gas.gum.activity.ui.TitleBar.OnTopClickListner;
import com.entropykorea.gas.gum.common.Constants;
import com.entropykorea.gas.gum.common.DateString;
import com.entropykorea.gas.gum.database.DataUtil;
import com.entropykorea.gas.gum.ewire.CallTrans;
import com.entropykorea.gas.gum.ewire.CallTrans.onFinished;


public class ReceiveActivity extends BasedActivity implements OnClickListener, OnTopClickListner {

	// DateString for YYYYMM
	DateString mDateString = new DateString();
	EditText mYear, mMonth;
	
	// Spinner
	Spinner mSpinnerTurn = null; // 차수
	NoAdapterSpinner mSpinnerCreateDt = null; // 생성일자
	
	private Sqlite mSqlite = new Sqlite( AppContext.getSQLiteDatabase() );

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		setContentView(R.layout.activity_receive);
		super.onCreate(savedInstanceState);
		
		// 데이타 삭제
		deleteGumCreateDt();
		
		init();
	}

	private void init() {
		// title
	    mTitleBar.setTitle("검침대상 수신");
	    mTitleBar.setOnTopClickListner(this);
	    //mTitleBar.setButtonVisibility(TitleBar.BUTTON_ONE, View.GONE);
	    mTitleBar.setButtonVisibility(TitleBar.BUTTON_TWO, View.GONE);
	    mTitleBar.setButtonEnable(TitleBar.BUTTON_ONE, false);
	    
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
		findViewById(R.id.ib_receive).setOnClickListener(this);
		// up down 
		findViewById(R.id.btn_yyyy_up).setOnClickListener(this);
		findViewById(R.id.btn_mm_up).setOnClickListener(this);
		findViewById(R.id.btn_yyyy_dn).setOnClickListener(this);
		findViewById(R.id.btn_mm_dn).setOnClickListener(this);
		
		// edittext
		mYear = (EditText) findViewById(R.id.et_yyyy);
		mMonth = (EditText) findViewById(R.id.et_mm);
		
		mYear.setText( ""+mDateString.year() );
		mMonth.setText( ""+mDateString.month() );
		
		// spinner (차수)
		mSpinnerTurn = (Spinner) findViewById(R.id.sp_turn);
		
		// spinner (생성일자)
		mSpinnerCreateDt = (NoAdapterSpinner) findViewById(R.id.sp_create_dt);
		
		setSpinner();
		setSpinnerCreateDt( null );
	}
	
	private void setSpinner() {
		String[] sa = { "1차", "2차", "3차" };

		// adapter
		ArrayAdapter<String> mAdapter;
		mAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, sa);
		mAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
		
		mSpinnerTurn.setAdapter(mAdapter);
		mSpinnerTurn.setPrompt("차수");
		mSpinnerTurn.setSelection(0);
		
		mSpinnerTurn.setOnItemSelectedListener( new OnItemSelectedListener() {

			@Override
			public void onItemSelected(AdapterView<?> parent, View view,
					int position, long id) {
				setSpinnerCreateDt(null); // 변경시 생성일자 삭제
			}

			@Override
			public void onNothingSelected(AdapterView<?> parent) {
				
			}
		});
	}
	
	SpinnerAdapter mAdapter;
	private void setSpinnerCreateDt( ArrayList<String> sa ) {

		// adapter
		//ArrayAdapter<String> mAdapter;
		
		//sa = getGumCreateDt();
		
		mAdapter = new SpinnerAdapter(this, sa);
		
		if( sa == null ) {
			mSpinnerCreateDt.setAdapter( null );
		} else {
			mSpinnerCreateDt.setAdapter( mAdapter );
		}

		mSpinnerCreateDt.setPrompt("생성일자");
		mSpinnerCreateDt.setSelection(0);
		mSpinnerCreateDt.setOnPerformClickListener(new OnPerformClick() {
			
			@Override
			public boolean performCick() {
				runGumCreateDtDown();
				return true;
			}
		});
	}

	private void setActivity() {
		
		
	}
	
	private void setFields() {
		
	}
	
	@Override
	protected void onResume() {
		super.onResume();
	}

	@Override
	public void onClickBackButton(View v) {
	}

	@Override
	public void onClickOneButton(View v) {
	}

	@Override
	public void onClickTwoButton(View v) {
	}

	@Override
	public void onClick(View v) {
		switch( v.getId() ) {
		case R.id.btn_yyyy_up:
			mDateString.add(Calendar.YEAR, 1);
			mYear.setText(""+mDateString.year());
			setSpinnerCreateDt(null); // 변경시 생성일자 삭제
			break;
		case R.id.btn_yyyy_dn:
			mDateString.add(Calendar.YEAR, -1);
			mYear.setText(""+mDateString.year());
			setSpinnerCreateDt(null); // 변경시 생성일자 삭제
			break;
		case R.id.btn_mm_up:
			mDateString.add(Calendar.MONTH, 1);
			mYear.setText(""+mDateString.year());
			mMonth.setText(""+mDateString.month());
			setSpinnerCreateDt(null); // 변경시 생성일자 삭제
			break;
		case R.id.btn_mm_dn:
			mDateString.add(Calendar.MONTH, -1);
			mYear.setText(""+mDateString.year());
			mMonth.setText(""+mDateString.month());
			setSpinnerCreateDt(null); // 변경시 생성일자 삭제
			break;
		case R.id.ib_receive:
			runGumDownAfterCheckVersion();
			break;
		}
	}

	private void runGumCreateDtDown() {
		CallTrans callTrans = new CallTrans(this, var.EWIRE_SERVER_IP, var.EWIRE_SERVER_PORT, var.USER_ID, var.EQUIP_CD);
		
		String jobYm = mDateString.getString(6);
		String turn = "0" + ( mSpinnerTurn.getSelectedItemPosition() + 1 );
		
		callTrans.callTrans(CallTrans.JOB_GUM_CREATE_DT_DOWN, jobYm, turn, "");
		callTrans.setOnFinished(new onFinished() {
			
			@Override
			public void preExcute(int jobType) {
				// 생성일자 삭제
				deleteGumCreateDt();
			}
			
			@Override
			public void postExcute(int jobType) {
				
			}
			
			@Override
			public void onFinished(int jobType, boolean result, String resultMessage) {
				if( result ) {
					// spinner set and view
					ArrayList<String> sa = getGumCreateDt();
					setSpinnerCreateDt( sa );
					
					if( sa != null ){
						
					}
					
				} else {
					
				}
			}
		});
	}
	
	private void runGumDownAfterCheckVersion() {
		if( mSpinnerCreateDt.getAdapter() == null || mSpinnerCreateDt.getCount() == 0 ) {
			alert( "생성일자가 없습니다" );
			return;
		}
		
		checkVersion();
	}
	
	private void runGumDown() {
		CallTrans callTrans = new CallTrans(this, var.EWIRE_SERVER_IP, var.EWIRE_SERVER_PORT, var.USER_ID, var.EQUIP_CD);
		
		String jobYm = mDateString.getString(6);
		String turn = "0" + ( mSpinnerTurn.getSelectedItemPosition() + 1 );
		String createDt; 
		
		
//		if( mSpinnerCreateDt.getAdapter() == null || mSpinnerCreateDt.getCount() == 0 ) {
//			alert( "생성일자가 없습니다" );
//			return;
//		}
		
		createDt = mSpinnerCreateDt.getSelectedItem().toString().trim().replaceAll("[^0-9]+","");
		
		callTrans.callTrans(CallTrans.JOB_GUM_DOWN, jobYm, turn, createDt );
		callTrans.setOnFinished(new onFinished() {
			
			@Override
			public void preExcute(int jobType) {
				// 데이타 삭제
				deleteGum();
			}
			
			@Override
			public void postExcute(int jobType) {
				
			}
			
			@Override
			public void onFinished(int jobType, boolean result, String resultMessage) {
				if( result ) {
					confirm( "수신 완료 되었습니다.", "finishThisActivity" );
				} else {
					
				}
			}
		});
	}
	
	public void finishThisActivity() {
		finish();
	}

	private boolean deleteGumCreateDt() {
		return DataUtil.deleteTable( "GUM_CREATE_DT" );
	}
	
	private boolean deleteGum() {
		return DataUtil.deleteAllData();
	}
	
	private ArrayList<String> getGumCreateDt() {
		int i,count;
		String sql = "SELECT * FROM GUM_CREATE_DT";
		mSqlite.rawQuery(sql);
		
		count = mSqlite.getCount();
		if( count == 0 ) {
			mSqlite.closeCursor();
			toast( "생성일자가 없습니다" );
			return null;
		}
		
		ArrayList<String> result = new ArrayList<String>();
		for( i=0 ; i<count ; i++ ) {
			result.add( DateString.makeDateString( mSqlite.getValue("METER_CREATE_DT", i) ));
			//result[i] = mSqlite.getValue("METER_CREATE_DT", i);
		}
		
		mSqlite.closeCursor();
		return result;
	}

	public class SpinnerAdapter extends ArrayAdapter<String>{
		private Context context;
		private final ArrayList<String> values;

		public SpinnerAdapter(Context context, ArrayList<String> arTitle) {
			super(context, android.R.layout.simple_spinner_item, arTitle);
			setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
			this.context = context;
			this.values = arTitle;
		}

//		boolean firsttime = true;
//		@Override
//		public View getView(int position, View convertView, ViewGroup parent) { 
//			if(firsttime){
//				firsttime = false;
//				//just return some empty view
//				//return new ImageView(context);
//				//return super.getView(position, convertView, parent);
//			}
//			// 선택없음을 클릭하면 지운다..
//			if( position == 0 )
//				return new ImageView(context);
//			//let the array adapter takecare this time      
//			return super.getView(position, convertView, parent);
//		}
		
		public void setError( String errorMessage ) {
			TextView tv = (TextView) findViewById( android.R.id.text1 );
			if( errorMessage != null ) {
				tv.setError( errorMessage );
			} else {
				tv.setError( null );
			}
		}
		
	}
	
	// version check & install
	public void checkVersion() {
		
		String updateUrl = var.UPDATE_SERVER_URL;
		String packageName = "mpgas_gum";
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
						runGumDown();
					} else {
						alert("잠시후에 다시 시도하십시요");
					}
				}
			}
			
		};
		
		ewireUpdate.checkVersion( updateUrl, packageName, versionNumber );
		
	}
	
	public void installApk() {

		String updateUrl = var.UPDATE_SERVER_URL;
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
	
}
