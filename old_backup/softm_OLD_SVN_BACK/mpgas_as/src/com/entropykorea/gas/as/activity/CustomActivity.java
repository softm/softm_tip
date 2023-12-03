package com.entropykorea.gas.as.activity;

import java.util.ArrayList;

import android.content.Intent;
import android.os.Bundle;
import android.telephony.PhoneNumberFormattingTextWatcher;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.TextView;

import com.entropykorea.gas.as.AppContext;
import com.entropykorea.gas.as.R;
import com.entropykorea.gas.as.bean.Min;
import com.entropykorea.gas.as.bean.MinCust;
import com.entropykorea.gas.as.common.base.BaseCode;
import com.entropykorea.gas.as.common.base.BasedActivity;
import com.entropykorea.gas.as.common.base.BasedActivity.OnMethod;
import com.entropykorea.gas.as.common.base.TopBar.OnTopClickListner;
import com.entropykorea.gas.as.common.object.Alert;
import com.entropykorea.gas.as.common.object.MLog;
import com.entropykorea.gas.as.common.util.StringUtil;
import com.entropykorea.gas.as.database.DbManager_MIN;
import com.entropykorea.gas.as.database.DbManager_MIN_CUST;

public class CustomActivity extends BasedActivity implements OnMethod, OnTopClickListner, OnClickListener, OnMenuItemClickListener {
  
  private TextView tv_ADDRESS, tv_HOUSE_NO, tv_CUST_NO, tv_CUST_NM;
  private EditText et_TEL_NO, et_WORK_TEL_NO, et_HP_NO, et_CUST_NM;
  private ImageView ch_TEL, ch_WORK_TEL, ch_HP;
  private LinearLayout ch_one, ch_two, ch_thr;
  private int telCheckNo = 0;
  
  private String custNm, telNo, workTelNo, hpNo, telCd;
  
  @Override
  protected void onCreate(Bundle savedInstanceState) {
    super.onCreate(savedInstanceState);
    
    View mMainLayout = (View) getLayoutInflater().inflate(R.layout.activity_customer_as, null);
    addTopView(mMainLayout);
    setTopBarText("고객정보");
    setOnTopClickListner(this);
    
    init();
    arrangeView();
  }
  
  @Override
  public void init() {
    // -----------------------
    tv_ADDRESS = (TextView) findViewById(R.id.ADDRESS); // 주소
    tv_HOUSE_NO = (TextView) findViewById(R.id.HOUSE_NO); // 수 용 가 번호
    tv_CUST_NO = (TextView) findViewById(R.id.CUST_NO); // 고객번호
    tv_CUST_NM = (TextView) findViewById(R.id.tv_CUST_NM); // 고객명
    et_CUST_NM = (EditText) findViewById(R.id.et_CUST_NM); // 고객명 저장
    
    et_TEL_NO = (EditText) findViewById(R.id.TEL_NO); // 자택
    et_TEL_NO.setInputType(android.text.InputType.TYPE_CLASS_PHONE);
    et_TEL_NO.addTextChangedListener(new PhoneNumberFormattingTextWatcher());
    et_WORK_TEL_NO = (EditText) findViewById(R.id.WORK_TEL_NO); // 회사
    et_WORK_TEL_NO.setInputType(android.text.InputType.TYPE_CLASS_PHONE);
    et_WORK_TEL_NO.addTextChangedListener(new PhoneNumberFormattingTextWatcher());
    et_HP_NO = (EditText) findViewById(R.id.HP_NO); // 이동전화
    et_HP_NO.setInputType(android.text.InputType.TYPE_CLASS_PHONE);
    et_HP_NO.addTextChangedListener(new PhoneNumberFormattingTextWatcher());
    
    ch_one = (LinearLayout) findViewById(R.id.ch_one);
    ch_two = (LinearLayout) findViewById(R.id.ch_two);
    ch_thr = (LinearLayout) findViewById(R.id.ch_thr);
    
    ch_TEL = (ImageView) findViewById(R.id.ch_TEL);
    ch_WORK_TEL = (ImageView) findViewById(R.id.ch_WORK_TEL);
    ch_HP = (ImageView) findViewById(R.id.ch_HP);
    
    findViewById(R.id.b_commit).setOnClickListener(this);
    
    ch_one.setOnClickListener(this);
    ch_two.setOnClickListener(this);
    ch_thr.setOnClickListener(this);
  }
  
  @Override
  public void dbSelector() {
    minD = (Min) getExtra();
    
    DbManager_MIN db = new DbManager_MIN();
    ArrayList<Min> data = db.getTotalList(db.getReqIdColumn(minD.REQUIRE_IDX + ""));
    if (data != null) {
      minD = data.get(0);
    }
  }
  
  @Override
  public void arrangeView() {
    dbSelector();
    
    tv_ADDRESS.setText(StringUtil.getAddress(minD));
    
    tv_CUST_NO.setText(minD.CUST_NO);
    tv_HOUSE_NO.setText(minD.HOUSE_NO);
    
    if ("".equals(minD.CUST_NM)) {
      tv_CUST_NM.setVisibility(View.GONE);
      et_CUST_NM.setVisibility(View.VISIBLE);
    } else {
      tv_CUST_NM.setText(minD.CUST_NM);
      tv_CUST_NM.setVisibility(View.VISIBLE);
      et_CUST_NM.setVisibility(View.GONE);
    }
    
    if ("".equals(minD.TEL_CD)) {
      PhonCDChecked(R.id.ch_one);
    } else if (!"".equals(minD.TEL_CD)) {
      custNm = minD.CUST_NM;
      telNo = minD.TEL_NO;
      workTelNo = minD.WORK_TEL_NO;
      hpNo = minD.HP_NO;
      
      et_TEL_NO.setText(minD.TEL_NO);
      et_WORK_TEL_NO.setText(minD.WORK_TEL_NO);
      et_HP_NO.setText(minD.HP_NO);
      telCDChecked(minD.TEL_CD);
    }
  }
  
  @Override
  public void onBackPressed() {
    onfinish();
    super.onBackPressed();
  }
  
  public void onfinish() {
    onFinish(minD, RESULT_OK);
  }
  
  /**
   * MA290 H 전화번호 MA290 M 핸드폰번호 MA290 C 직장전화번호
   * 
   * @param id
   */
  
  private void telCDChecked(String id) {
    if ("H".equals(id)) {
      PhonCDChecked(R.id.ch_one);
    } else if ("M".equals(id)) {
      PhonCDChecked(R.id.ch_two);
    } else if ("C".equals(id)) {
      PhonCDChecked(R.id.ch_thr);
    }
  }
  
  private void PhonCDChecked(int id) {
    BaseCode mBaseCode = new BaseCode(AppContext.getSQLiteDatabase(), "MA290");
    switch (id) {
      case R.id.ch_one:
        telCheckNo = 1;
        ch_TEL.setBackgroundResource(R.drawable.checked_radio);
        ch_WORK_TEL.setBackgroundResource(R.drawable.radio);
        ch_HP.setBackgroundResource(R.drawable.radio);
        
        telCd = mBaseCode.getCodeByName("MA290", "전화번호");
        break;
      case R.id.ch_two:
        telCheckNo = 2;
        ch_TEL.setBackgroundResource(R.drawable.radio);
        ch_WORK_TEL.setBackgroundResource(R.drawable.checked_radio);
        ch_HP.setBackgroundResource(R.drawable.radio);
        telCd = mBaseCode.getCodeByName("MA290", "핸드폰번호");
        break;
      case R.id.ch_thr:
        telCheckNo = 3;
        ch_TEL.setBackgroundResource(R.drawable.radio);
        ch_WORK_TEL.setBackgroundResource(R.drawable.radio);
        ch_HP.setBackgroundResource(R.drawable.checked_radio);
        telCd = mBaseCode.getCodeByName("MA290", "직장전화번호");
        break;
    }
  }
  
  private void sendDataChecks() {
    String tel = StringUtil.getString(et_TEL_NO);
    String workTel = StringUtil.getString(et_WORK_TEL_NO);
    String hp = StringUtil.getString(et_HP_NO);
    
    if (tel.length() == 0 && telCheckNo == 1) {
      Alert.alert(activity, "자택 번호를 입력하세요.", null);
    } else if (workTel.length() == 0 && telCheckNo == 2) {
      Alert.alert(activity, "이동 번호를 입력하세요.", null);
    } else if (hp.length() == 0 && telCheckNo == 3) {
      Alert.alert(activity, "회사 번호를 입력하세요.", null);
    } else {
      MLog.d("telNo:" + tel + "" + "workTel: " + workTel + ", hp" + hp);
      
      updateMinDb();
    }
  }
  
  /**
   * db 업데이트
   * 
   * @param min
   */
  private void updateMinDb() {
    minD.CUST_NM = "".equals(StringUtil.getString(et_CUST_NM)) ? custNm : StringUtil.getString(et_CUST_NM);
    minD.TEL_NO = "".equals(StringUtil.getString(et_TEL_NO)) ? telNo : StringUtil.getString(et_TEL_NO);
    minD.WORK_TEL_NO = "".equals(StringUtil.getString(et_WORK_TEL_NO)) ? workTelNo : StringUtil.getString(et_WORK_TEL_NO);
    minD.HP_NO = "".equals(StringUtil.getString(et_HP_NO)) ? hpNo : StringUtil.getString(et_HP_NO);
    minD.TEL_CD = telCd;
    
    minD.MV_IN_CUST_NM = "".equals(StringUtil.getString(et_CUST_NM)) ? custNm : StringUtil.getString(et_CUST_NM);
    minD.MV_IN_TEL_NO = "".equals(StringUtil.getString(et_TEL_NO)) ? telNo : StringUtil.getString(et_TEL_NO);
    minD.MV_IN_WORK_TEL_NO = "".equals(StringUtil.getString(et_WORK_TEL_NO)) ? workTelNo : StringUtil.getString(et_WORK_TEL_NO);
    minD.MV_IN_HP_NO = "".equals(StringUtil.getString(et_HP_NO)) ? hpNo : StringUtil.getString(et_TEL_NO);
    minD.MV_IN_TEL_CD = telCd;
    
    DbManager_MIN db = new DbManager_MIN();
    boolean result = db.updateColumn(db.TYPE_CUST, minD);
    // db.close();
    if (result) {
      Alert.alert(activity, "저장 되었습니다.", "onfinish");
    } else {
      alert("저장중 오류가 발생 하였습니다.");
    }
    
    MinCust mc = new MinCust();
    mc.REQUIRE_IDX = minD.REQUIRE_IDX;
    mc.HOUSE_NO = minD.HOUSE_NO;
    mc.FAKE_HOUSE_NO = minD.FAKE_HOUSE_NO;
    mc.CUST_NO = minD.CUST_NO;
    mc.CUST_NM = StringUtil.getString(et_CUST_NM);
    mc.TEL_NO = StringUtil.getString(et_TEL_NO);
    mc.WORK_TEL_NO = StringUtil.getString(et_WORK_TEL_NO);
    mc.HP_NO = StringUtil.getString(et_HP_NO);
    mc.TEL_CD = minD.MV_IN_TEL_CD;
    DbManager_MIN_CUST db2 = new DbManager_MIN_CUST();
    db2.insertColumn(mc);
  }
  
  @Override
  public void onClick(View v) {
    switch (v.getId()) {
      case R.id.ch_one:
      case R.id.ch_two:
      case R.id.ch_thr:
        PhonCDChecked(v.getId());
        break;
      case R.id.b_commit:
          if ("N".equals(minD.SEND_YN)) {
            sendDataChecks();
          } else {
            alert("이미 완료 되었습니다.");
          }
        
        break;
    }
  }
  
  @Override
  public void onClickBackButton(View v) {
    // TODO Auto-generated method stub
    
  }
  
  @Override
  public void onClickOneButton(View v) {
    showMenu();
  }
  
  @Override
  public void onClickTwoButton(View v) {
    // TODO Auto-generated method stub
  }
  
  public void showMenu() {
    View anchor = (View) findViewById(R.id.btn_one);
    showMenu(anchor, R.menu.main);
  }
  
  @Override
  public boolean onMenuItemClick(MenuItem item) {
    switch (item.getItemId()) {
      case R.id.menu_action_1:
        if (isInstalledApplication("com.entropykorea.gas.main")) {
          Intent intent = new Intent();
          intent.setClassName("com.entropykorea.gas.main", "com.entropykorea.gas.main.activity.AboutActivity");
          startActivity(intent);
        } else {
          Alert.alert(activity, getString(R.string.app_name) + " ver. " + getString(R.string.app_version), null);
        }
        break;
    }
    return false;
  }
}
