package com.entropykorea.gas.main.activity;

import android.content.Intent;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.Spinner;

import com.entropykorea.gas.main.R;
import com.entropykorea.gas.main.activity.ui.TitleBar;
import com.entropykorea.gas.main.activity.view.ViewById;
import com.entropykorea.gas.main.common.Pref;


public class SettingActivity extends BasedActivity implements OnClickListener{

	@ViewById(id=R.id.et_equip_cd)
	EditText mEditEquipCd;
	
	@ViewById(id=R.id.sp_barcd_equip_use_yn)
	Spinner mSpinnerBarcdEquipUseYn;
	
	@ViewById(id=R.id.btn_save, click="this")
	ImageButton mButtonSave;
	
	Boolean isEnableEquipCd = true;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		setContentView(R.layout.activity_setting);
		super.onCreate(savedInstanceState);
		
		isEnableEquipCd = getIntent().getBooleanExtra( "ENABLE", false );
		
		init();
	}
	
	private void init() {
		// title
		mTitleBar.setTitle("환경설정");
		mTitleBar.setOnTopClickListner(this);
		mTitleBar.setButtonVisibility(TitleBar.BUTTON_TWO, View.GONE);
		mTitleBar.setButtonVisibility(TitleBar.BUTTON_ONE, View.VISIBLE);
		mTitleBar.setButtonVisibility(TitleBar.BUTTON_BACK, View.GONE);
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
		
		mEditEquipCd.addTextChangedListener(new TextWatcher() {
			
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
					mEditEquipCd.setError(null);
				}
			}
		});
		
		setFields();
		setSpinner();
	}
	
	private void setFields() {
		mEditEquipCd.setText( var.EQUIP_CD );

		mEditEquipCd.setEnabled( isEnableEquipCd );
		mEditEquipCd.setClickable(isEnableEquipCd);
		mEditEquipCd.clearFocus();
		
		if( isEnableEquipCd ) {
			
		} else {
			
		}
	}

	private void setSpinner() {
		String[] sa = { "사용", "미사용" };

		// adapter
		ArrayAdapter<String> mAdapter;
		mAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, sa);
		mAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
		
		mSpinnerBarcdEquipUseYn.setAdapter(mAdapter);
		mSpinnerBarcdEquipUseYn.setPrompt("바코드인식장비");
		if( var.BARCD_EQUIP_USE_YN.equals("Y") ) {
			mSpinnerBarcdEquipUseYn.setSelection(0);
		} else {
			mSpinnerBarcdEquipUseYn.setSelection(1);
		}
		
		mSpinnerBarcdEquipUseYn.setOnItemSelectedListener( new OnItemSelectedListener() {

			@Override
			public void onItemSelected(AdapterView<?> parent, View view,
					int position, long id) {
			}

			@Override
			public void onNothingSelected(AdapterView<?> parent) {
				
			}
		});
	}
	
	public boolean checkThis() {
		String string;
		
		string = getString( mEditEquipCd );
		if( string.length() != 2 ) {
			mEditEquipCd.setError("기기번호를 입력하십시요");
			mEditEquipCd.requestFocus();
			return false;
		}
		
		return true;
	}
	
	public void saveThisConfirm() {
		if( !checkThis() ) {
			return;
		}
		confirm( "변경된 데이타를 저장하시겠습니까?\n(기기번호가 변경될 경우 기존 데이타가 삭제됩니다)", "saveThis", "" );
	}
	
	public void saveThis() {
		
		var.EQUIP_CD = getString( mEditEquipCd );
		if( mSpinnerBarcdEquipUseYn.getSelectedItemPosition() == 0 ) {
			var.BARCD_EQUIP_USE_YN = "Y";
		} else {
			var.BARCD_EQUIP_USE_YN = "N";
		}

		saveVar();
		savePref();
		
		// result code 
		Intent intent = new Intent();
		intent.putExtra("BARCD_EQUIP_USE_YN", var.BARCD_EQUIP_USE_YN);
		setResult(100, intent);		
		
		finish();
	}

	private void savePref() {
		Pref.setBarcdEquipUseYn(this, var.BARCD_EQUIP_USE_YN);
		Pref.setEqipCd(this, var.EQUIP_CD);
	}
	
	@Override
	public void onClick(View v) {
		switch( v.getId() ) {
		case R.id.btn_save:
			saveThisConfirm();
			break;
		}

	}

	
}
