package com.entropykorea.gas.as.activity;

import java.util.ArrayList;

import android.content.Intent;
import android.os.Bundle;
import android.view.KeyEvent;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.inputmethod.EditorInfo;
import android.widget.EditText;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.TextView;
import android.widget.TextView.OnEditorActionListener;

import com.entropykorea.gas.as.AppContext;
import com.entropykorea.gas.as.R;
import com.entropykorea.gas.as.SharedApplication;
import com.entropykorea.gas.as.bean.Min;
import com.entropykorea.gas.as.common.base.BaseCode;
import com.entropykorea.gas.as.common.base.BasedActivity;
import com.entropykorea.gas.as.common.base.BasedActivity.OnMethod;
import com.entropykorea.gas.as.common.base.TopBar.OnTopClickListner;
import com.entropykorea.gas.as.common.object.Alert;
import com.entropykorea.gas.as.common.object.MLog;
import com.entropykorea.gas.as.common.util.DateString;
import com.entropykorea.gas.as.common.util.StringUtil;
import com.entropykorea.gas.as.common.util.Util;
import com.entropykorea.gas.as.constants.Constant;
import com.entropykorea.gas.as.database.DbManager_MIN;
import com.entropykorea.gas.as.ewire.CallTrans;
import com.entropykorea.gas.as.ewire.CallTrans.onFinished;

public class DetailOtherActivity extends BasedActivity implements OnMethod, OnTopClickListner, OnClickListener, OnMenuItemClickListener {
  private TextView tv_ADDRESS, tv_HOUSE_NO, tv_PURPOSE_CD, tv_REQUIRE_CD, tv_HOUSE_STATUS_CD, tv_CUST_NM, tv_TEL_NO, tv_REQUEST_REMARK;
  private EditText PROC_REMARK = null;
  private TextView PROC_DT = null;
  private EditText METER = null;
  
  private View tr_layout, tr_layout2;
  
  // private String sendType = "";// 반송시:RE_SEND_TYPE
  
  @Override
  protected void onCreate(Bundle savedInstanceState) {
    super.onCreate(savedInstanceState);
    
    View mMainLayout = (View) getLayoutInflater().inflate(R.layout.activity_detail_other_as, null);
    addTopView(mMainLayout);
    setTopBarText("민원처리");
    setTwoBtnVisible(View.VISIBLE);
    setTwoBtnImage(R.drawable.info_img);
    setOnTopClickListner(this);
    
    init();
  }
  
  @Override
  protected void onResume() {
    super.onResume();
    
    arrangeView();
  }
  
  public void onfinish() {
    onFinish(minD, RESULT_OK);
  }
  
  @Override
  public void init() {
    
    findViewById(R.id.btn_close).setOnClickListener(this);
    findViewById(R.id.btn_resend).setOnClickListener(this);
    findViewById(R.id.btn_commit).setOnClickListener(this);
    
    tv_ADDRESS = (TextView) findViewById(R.id.ADDRESS); // 주소
    tv_HOUSE_NO = (TextView) findViewById(R.id.HOUSE_NO); // 수 용 가 번호
    tv_PURPOSE_CD = (TextView) findViewById(R.id.PURPOSE_CD);// 용 도
    tv_REQUIRE_CD = (TextView) findViewById(R.id.REQUIRE_CD);// 민원종류
    tv_HOUSE_STATUS_CD = (TextView) findViewById(R.id.HOUSE_STATUS_CD);// 공급상태
    tv_CUST_NM = (TextView) findViewById(R.id.CUST_NM);// 고 객 명
    tv_TEL_NO = (TextView) findViewById(R.id.TEL_NO);// 주연락처
    tv_REQUEST_REMARK = (TextView) findViewById(R.id.REQUEST_REMARK);// 민원내용
    
    PROC_REMARK = (EditText) findViewById(R.id.PROC_REMARK);// 처리내용
    
    tr_layout = (View) findViewById(R.id.tr_layout);// 해제일자,해제지침
    tr_layout2 = (View) findViewById(R.id.tr_layout2);// 해제일자,해제지침
    
    PROC_DT = (TextView) findViewById(R.id.PROC_DT);// 해제일자
    METER = (EditText) findViewById(R.id.METER);// 해제지침
  }
  
  @Override
  public void dbSelector() {
    ArrayList<Min> data = null;
    DbManager_MIN db = new DbManager_MIN();
    data = db.getTotalList(db.getReqIdColumn(REQUIRE_IDX + ""));
    if (data.size() == 0) return;
    minD = data.get(0);
  }
  
  @Override
  public void arrangeView() {
    REQUIRE_IDX = getIntent().getIntExtra("REQUIRE_IDX", 0);
    MLog.e("REQUIRE_IDX:" + REQUIRE_IDX);
    if (REQUIRE_IDX != 0) {
      dbSelector();
      
      tv_ADDRESS.setText(StringUtil.getAddress(minD));
      tv_HOUSE_NO.setText(minD.HOUSE_NO);
      
      BaseCode mBaseCode = new BaseCode(AppContext.getSQLiteDatabase(), "MA040");
      tv_PURPOSE_CD.setText(mBaseCode.getNameByCode("MA040", minD.PURPOSE_CD));
      mBaseCode = new BaseCode(AppContext.getSQLiteDatabase(), "RQ010");
      tv_REQUIRE_CD.setText(mBaseCode.getNameByCode("RQ010", minD.REQUIRE_CD));// 민원구분
      mBaseCode = new BaseCode(AppContext.getSQLiteDatabase(), "MA090");
      tv_HOUSE_STATUS_CD.setText(mBaseCode.getNameByCode("MA090", minD.HOUSE_STATUS_CD));
      
      tv_CUST_NM.setText(minD.CUST_NM);
      tv_TEL_NO.setText(StringUtil.getTelCode(minD));
      tv_REQUEST_REMARK.setText(minD.REQUEST_REMARK);
      
      PROC_REMARK.setText(minD.PROC_REMARK);
      PROC_REMARK.setImeOptions(EditorInfo.IME_ACTION_SEND);
      PROC_REMARK.setOnEditorActionListener(eidtAction);
      if (sealType()) {
        // android:imeOptions="actionNext"
        PROC_REMARK.setImeOptions(EditorInfo.IME_ACTION_NEXT);
        tr_layout.setVisibility(View.VISIBLE);
        tr_layout2.setVisibility(View.VISIBLE);
        PROC_DT.setText(getProcDate(minD.END_YN, minD.PROC_DT));
        
        METER.setText(minD.METER);
        METER.setImeOptions(EditorInfo.IME_ACTION_SEND);
        METER.setOnEditorActionListener(eidtAction);
      }
    }
  }
  
  /***
   * 봉인상태 리턴
   * 
   * @return 봉인시 true
   */
  private boolean sealType() {
    // "시설봉인 06"안전점검봉인해제 53"미사용봉인 53";
    return "06".equals(minD.REQUIRE_CD) || "53".equals(minD.REQUIRE_CD) || "53".equals(minD.REQUIRE_CD);
  }
  
  /**
   * 업데이트
   * 
   * @param min
   */
  public void updateDb() {
    minD.PROC_USER_CD = SharedApplication.user.USER_ID;
    minD.PROC_DT = DateString.makeDateTimeString(DateString.getToday()).replace("/", "-");
    
    minD.PROC_REMARK = StringUtil.getString(PROC_REMARK);
    
    if (sealType()) {
      minD.PROC_DT = StringUtil.getString(PROC_DT);
      minD.METER = StringUtil.getString(METER);
    }
    minD.END_YN = "Y";
    
    DbManager_MIN db = new DbManager_MIN();
    boolean result = db.updateColumn(db.TYPE_RESULT, minD);
    MLog.d("result : " + result);
    // db.close();
    if (result) {
      runMINUpload();
    } else {
      Alert.alert(activity, "저장중 오류가 발생 하였습니다.", null);
    }
  }
  
  /**
   * 송신 완료시 Send_Yn = Y 처리
   */
  public void updateSendYn() {
    DbManager_MIN db = new DbManager_MIN();
    boolean result = db.updateYnColumn("Y");
    if (result) {
      minD.SEND_YN = "Y";
    } else {
      Alert.alert(activity, "민원 SEND 저장중 오류가 발생 하였습니다.", null);
    }
    // db.close();
  }
  
  // 완료버튼 송신
  private void runMINUpload() {
    CallTrans callTrans = new CallTrans(this);
    callTrans.callTrans(CallTrans.MIN_UP);
    callTrans.setOnFinished(new onFinished() {
      
      @Override
      public void preExcute(int jobType) {
        
      }
      
      @Override
      public void postExcute(int jobType) {
        
      }
      
      @Override
      public void onFinished(int jobType, boolean result, String resultMessage) {
        if (result) {
          Alert.alert(activity, getString(R.string.msg_success), null);
          updateSendYn();
        } else {
          Alert.alert(activity, getString(R.string.msg_fail) + "\n" + resultMessage, null);
        }
      }
    });
  }
  
  // 반송시
  private void resendAlert() {
    minD.PROC_RESULT_CD = "5";
    Alert.confirm(this, "반송 하시겠습니까?", "updateDb", null);
  }
  
  // 해제일자 현재날짜
  public String getProcDate(String endYn, String proDt) {
    String date = "";
    if ("N".equals(endYn)) {
      date = Util.getProcDate();
    } else {
      date = proDt;
    }
    return date;
  }
  
  private boolean sendChecked() {
    
    String rStr = StringUtil.getString(tv_REQUIRE_CD);
    
    if (StringUtil.getContains(rStr, "보일러")) {
      if ("".equals(minD.PHOTO_FILE_NM) && "".equals(minD.PHOTO_FILE_NM2)) {
        Alert.alert(activity, "보일러 교체 관련 사진이 필요합니다.", null);
      } else {
        return true;
      }
    }
    
    if ("".equals(StringUtil.getString(PROC_REMARK))) {
      Alert.alert(activity, "처리내용이 입력되지 않습니다.", null);
      PROC_REMARK.setFocusable(true);
      return false;
    }
    
    if (sealType()) {
      if ("".equals(StringUtil.getString(PROC_DT))) {
        Alert.alert(activity, "해제일자가 입력되지 않습니다.", null);
        PROC_DT.setFocusable(true);
        return false;
      } else if ("".equals(StringUtil.getString(METER))) {
        Alert.alert(activity, "해제지침이 입력되지 않습니다.", null);
        METER.setFocusable(true);
        return false;
      }
    }
    return true;
  }
  
  OnEditorActionListener eidtAction = new OnEditorActionListener() {
    
    @Override
    public boolean onEditorAction(TextView v, int actionId, KeyEvent event) {
      
      switch (actionId) {
        case EditorInfo.IME_ACTION_SEND:
          if ("N".equals(minD.SEND_YN)) {
            if (sendChecked()) updateDb();
          } else {
            alert("이미 완료 되었습니다.");
          }
          break;
      }
      
      return false;
    }
  };
  
  @Override
  public void onClick(View v) {
    switch (v.getId()) {
      case R.id.btn_close:
        onfinish();
        break;
      case R.id.btn_resend:
        if ("N".equals(minD.SEND_YN)) {
          resendAlert();
        } else {
          alert("이미 완료 되었습니다.");
        }
        break;
      case R.id.btn_commit:
        if ("N".equals(minD.SEND_YN)) {
          minD.PROC_RESULT_CD = "1";
          if (sendChecked()) updateDb();
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
    onResultActivity(CustomActivity.class, minD);
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
  
  @Override
  protected void onActivityResult(int requestCode, int resultCode, Intent data) {
    switch (requestCode) {
    
      case Constant.RESULT_REQUEST_DETAIL:
        try {
          minD = (Min) data.getSerializableExtra("value");
        } catch (Exception e) {
        }
        arrangeView();
        break;
    }
  }
}
