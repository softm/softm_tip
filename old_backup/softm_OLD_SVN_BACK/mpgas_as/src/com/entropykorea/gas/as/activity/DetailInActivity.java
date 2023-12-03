package com.entropykorea.gas.as.activity;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Set;

import android.bluetooth.BluetoothDevice;
import android.content.Intent;
import android.content.IntentFilter;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.CompoundButton.OnCheckedChangeListener;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.TextView;
import android.widget.Toast;

import com.bixolon.printer.BixolonPrinter;
import com.entropykorea.gas.as.AppContext;
import com.entropykorea.gas.as.R;
import com.entropykorea.gas.as.SharedApplication;
import com.entropykorea.gas.as.bean.Min;
import com.entropykorea.gas.as.bean.MinFee;
import com.entropykorea.gas.as.bean.MinFeePay;
import com.entropykorea.gas.as.bean.MinLegalFee;
import com.entropykorea.gas.as.bean.MinUnpaidPrice;
import com.entropykorea.gas.as.bean.Provider;
import com.entropykorea.gas.as.common.base.BaseCode;
import com.entropykorea.gas.as.common.base.BasedActivity;
import com.entropykorea.gas.as.common.base.BasedActivity.OnMethod;
import com.entropykorea.gas.as.common.base.TopBar.OnTopClickListner;
import com.entropykorea.gas.as.common.object.Alert;
import com.entropykorea.gas.as.common.object.MLog;
import com.entropykorea.gas.as.common.object.Watcher;
import com.entropykorea.gas.as.common.util.DateString;
import com.entropykorea.gas.as.common.util.StringUtil;
import com.entropykorea.gas.as.common.util.Util;
import com.entropykorea.gas.as.constants.Constant;
import com.entropykorea.gas.as.database.DbManager_MIN;
import com.entropykorea.gas.as.database.DbManager_MIN_FEE;
import com.entropykorea.gas.as.database.DbManager_MIN_FEE_PAY;
import com.entropykorea.gas.as.database.DbManager_MIN_LEGAL_FEE;
import com.entropykorea.gas.as.database.DbManager_MIN_UNPAID_PRICE;
import com.entropykorea.gas.as.database.DbManager_PROVIDER;
import com.entropykorea.gas.as.ewire.CallTrans;
import com.entropykorea.gas.as.ewire.CallTrans.onFinished;
import com.entropykorea.gas.lib.PicCamera;
import com.entropykorea.gas.lib.activity.PicViewerActivity;

public class DetailInActivity extends BasedActivity implements OnMethod, OnTopClickListner, OnClickListener, OnCheckedChangeListener, OnMenuItemClickListener {
  private TextView ADDRESS = null;
  
  private TextView tv_HOUSE_NO = null;
  private TextView tv_PURPOSE_CD = null;
  private TextView tv_REQUIRE_CD = null;
  private TextView tv_HOUSE_STATUS_CD = null;
  private TextView tv_CUST_NM = null;
  private TextView tv_TEL_NO = null;
  private TextView tv_REQUEST_REMARK = null;
  private TextView tv_PROC_REMARK = null;
  private TextView tv_TOT_GAS_PRICE = null;
  private TextView tv_FEE_PRICE = null;
  private TextView tv_TOTAL_PRICE = null;
  private TextView tv_seal_proc_dt_text = null;// 해제일자
  private TextView tv_seal_meter_text = null;// 해제일자 텍스트
  private TextView tv_PROC_DT = null;// 해제일자
  
  private EditText et_PAID_FEE_PRICE = null;
  private EditText et_PAID_PRICE = null;
  private EditText et_CASH_AMT = null;
  private EditText tv_METER = null; // 지침
  
  private CheckBox ALL_CHG_SMS_YN = null;
  private CheckBox CHG_SMS_RECV_YN = null;
  private CheckBox CHECKUP_SMS_RECV_YN = null;
  private CheckBox BILL_SMS_RECV_YN = null;
  private CheckBox READ_SMS_RECV_YN = null;
  private CheckBox UNPAID_SMS_RECV_YN = null;
  private CheckBox PAY_INFO_SMS_REQ_YN = null;
  
  private ImageButton btn_bill = null;
  private ImageButton ib_photoview = null;
  
  private PicCamera pc = null;
  // --------------------------------------
  static final String ACTION_GET_MSR_TRACK_DATA = "com.bixolon.anction.GET_MSR_TRACK_DATA";
  static final String EXTRA_NAME_MSR_TRACK_DATA = "MsrTrackData";
  
  public static BixolonPrinter mBixolonPrinter;
  private boolean printConnected = false; // 블루투스 장비 연결상태 값
  private boolean printComplete = false;
  private String mConnectedDeviceName = null;
  private int printType = 0;
  
  // private long isTotalPrice = 0; // 총액
  private long isPurchasePrice = 0; // 실수납액
  private long isGasPrice = 0; // 요금계
  private long isFeePrice = 0; // 수수료
  private long isCashPrice = 0; // 현금 입력 금액
  // private long isCardPrice = 0; // 카드 입력 금액
  
  private Provider cPro = new Provider();
  private ArrayList<MinFee> fee = new ArrayList<MinFee>();
  private ArrayList<MinFeePay> mFeepayArray = new ArrayList<MinFeePay>();
  
  //
  @Override
  protected void onCreate(Bundle savedInstanceState) {
    super.onCreate(savedInstanceState);
    
    View mMainLayout = (View) getLayoutInflater().inflate(R.layout.activity_detail_in_as, null);
    addTopView(mMainLayout);
    setTopBarText("민원처리");
    setTwoBtnVisible(View.VISIBLE);
    setTwoBtnImage(R.drawable.info_img);
    setOnTopClickListner(this);
    
    init();
    arrangeView();
  }
  
  @Override
  protected void onResume() {
    
    if ("Y".equals(minD.END_YN)) onPrint();
    super.onResume();
  }
  
  public void onfinish() {
    onFinish(minD, RESULT_OK);
  }
  
  @Override
  protected void onPause() {
    if (mBixolonPrinter != null) mBixolonPrinter.disconnect();
    super.onPause();
  }
  
  @Override
  public void init() {
    // 전출 : 전출(33)
    // 전입 : 전입(47)
    // 렌지연결(49), 렌지교체(48), 호스교체(50), 중간밸브A/S(교체)(52), 보일러교체(57), 가스기기 철거(45)
    // 안전점검 봉인해제 : 안전점검 봉인해제(53)
    // 미사용봉인 : 미사용봉인(44)
    
    findViewById(R.id.b_fee).setOnClickListener(this);
    
    findViewById(R.id.btn_close).setOnClickListener(this);
    findViewById(R.id.btn_resend).setOnClickListener(this);
    findViewById(R.id.b_commit).setOnClickListener(this);
    
    findViewById(R.id.b_camera).setOnClickListener(this);
    ib_photoview = (ImageButton) findViewById(R.id.ib_photoview);
    ib_photoview.setOnClickListener(this);
    btn_bill = (ImageButton) findViewById(R.id.btn_bill);
    btn_bill.setOnClickListener(this);
    
    // -----------------------
    ADDRESS = (TextView) findViewById(R.id.ADDRESS); // 주소
    tv_HOUSE_NO = (TextView) findViewById(R.id.HOUSE_NO); // 수 용 가 번호
    tv_PURPOSE_CD = (TextView) findViewById(R.id.PURPOSE_CD);// 용 도
    tv_REQUIRE_CD = (TextView) findViewById(R.id.REQUIRE_CD);// 민원종류
    tv_HOUSE_STATUS_CD = (TextView) findViewById(R.id.HOUSE_STATUS_CD);// 공급상태
    tv_CUST_NM = (TextView) findViewById(R.id.CUST_NM);// 고 객 명
    tv_TEL_NO = (TextView) findViewById(R.id.TEL_NO);// 주연락처
    tv_REQUEST_REMARK = (TextView) findViewById(R.id.REQUEST_REMARK);// 민원내용
    tv_PROC_REMARK = (TextView) findViewById(R.id.PROC_REMARK);// 처리내용
    
    tv_TOT_GAS_PRICE = (TextView) findViewById(R.id.TOT_GAS_PRICE);// 요금계산
    tv_FEE_PRICE = (TextView) findViewById(R.id.FEE_PRICE);// 수 수 료
    tv_TOTAL_PRICE = (TextView) findViewById(R.id.TOTAL_PRICE);// 총 액
    
    et_PAID_FEE_PRICE = (EditText) findViewById(R.id.PAID_FEE_PRICE);// 수수료 수 납 액
    et_PAID_PRICE = (EditText) findViewById(R.id.PAID_PRICE);// 실수납액
    et_CASH_AMT = (EditText) findViewById(R.id.CASH_AMT);// 현 금
    
    ALL_CHG_SMS_YN = (CheckBox) findViewById(R.id.ALL_CHG_SMS_YN);// 전체선택
    CHG_SMS_RECV_YN = (CheckBox) findViewById(R.id.CHG_SMS_RECV_YN);// 교체SMS 수신동의
    CHECKUP_SMS_RECV_YN = (CheckBox) findViewById(R.id.CHECKUP_SMS_RECV_YN);// 점검SMS 수신동의
    BILL_SMS_RECV_YN = (CheckBox) findViewById(R.id.BILL_SMS_RECV_YN);// 고지SMS 수신동의
    READ_SMS_RECV_YN = (CheckBox) findViewById(R.id.READ_SMS_RECV_YN);// 검침SMS 수신동의
    UNPAID_SMS_RECV_YN = (CheckBox) findViewById(R.id.UNPAID_SMS_RECV_YN);// 채납SMS 수신동의
    PAY_INFO_SMS_REQ_YN = (CheckBox) findViewById(R.id.PAY_INFO_SMS_REQ_YN);// 입금정보 문자발송 요청
    
    // 추가사항 해제일자,해제지침 해제일자는 시스테데이트
    tv_seal_proc_dt_text = (TextView) findViewById(R.id.tv_seal_proc_dt_text);// 해제일자 텍스
    tv_seal_meter_text = (TextView) findViewById(R.id.tv_seal_proc_dt_text);// 해제일자 텍스트
    
    tv_PROC_DT = (TextView) findViewById(R.id.tv_PROC_DT);// 해제일자 텍스
    tv_METER = (EditText) findViewById(R.id.tv_METER);// 해제일자 텍스
  }
  
  @Override
  public void dbSelector() {
    ArrayList<Min> data = null;
    DbManager_MIN db = new DbManager_MIN();
    data = db.getTotalList(db.getReqIdColumn(REQUIRE_IDX + ""));
    if (data.size() == 0) return;
    minD = data.get(0);
    
    DbManager_MIN_FEE_PAY db2 = new DbManager_MIN_FEE_PAY();
    mFeepayArray = db2.getTotalList(db2.getColumn(minD.REQUIRE_IDX));
  }
  
  @Override
  public void arrangeView() {
    
    REQUIRE_IDX = getIntent().getIntExtra("REQUIRE_IDX", 0);
    MLog.e("REQUIRE_IDX:" + REQUIRE_IDX);
    if (REQUIRE_IDX != 0) {
      dbSelector();
      // 전출 33
      if ("47".equals(minD.REQUIRE_CD)) {
        setTwoBtnVisible(View.VISIBLE);
        setTwoBtnImage(R.drawable.info_img);
      }
      // 전입 47
      if ("47".equals(minD.REQUIRE_CD)) {
        setVisibility(R.id.Ll_chek1);
        setVisibility(R.id.Ll_chek2);
      }
      // 안전점검봉인해제 53" 미사용봉인 44" 체크 데이터 입력시 12
      else if (sealTypeCheck()) {
        
        if ("44".equals(minD.REQUIRE_CD)) {
          setVisibility(R.id.tr_check1);
          setVisibility(R.id.tr_check2);
          tv_seal_meter_text.setText("봉인일자");
          tv_seal_meter_text.setText("봉인지침");
        }
        
        tv_PROC_DT.setText("".equals(minD.PROC_DT) ? DateString.makeDateString(DateString.getToday()) : minD.PROC_DT);
        tv_METER.setText(minD.METER);
      }
      
      ADDRESS.setText(StringUtil.getAddress(minD));
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
      tv_PROC_REMARK.setText(minD.PROC_REMARK);
      
      tv_TOT_GAS_PRICE.setText(StringUtil.formatWonEn(minD.PAID_GAS_PRICE + "")); // 요금계산
      int feeP = 0;
      if (mFeepayArray.size() > 0) {
        for (int i = 0; i < mFeepayArray.size(); i++) {
          int unit = StringUtil.getInteger(mFeepayArray.get(i).PROC_UNIT_PRICE);
          int qty = mFeepayArray.get(i).PROC_QTY;
          feeP += (unit * qty);
        }
      }
      tv_FEE_PRICE.setText(StringUtil.formatWonEn(feeP + ""));// 수수료
      tv_TOTAL_PRICE.setText(StringUtil.formatWonEn(feeP + ""));// 총액
      
      if ("Y".equals(minD.SEND_YN)) {
        et_PAID_FEE_PRICE.setText(StringUtil.formatWonEn(minD.PAID_FEE_PRICE + ""));// 수수료수납금액
      } else {
        et_PAID_FEE_PRICE.setText(StringUtil.formatWonEn(feeP + ""));// 수수료수납금액
      }
      
      String paidP = "";
      if (!"".equals(StringUtil.isNullString(minD.CASH_AMT)) || !"".equals(StringUtil.isNullString(minD.CARD_AMT))) {
        paidP = (minD.CASH_AMT + minD.CARD_AMT) + "";
      } else {
        paidP = feeP + "";
      }
      
      et_PAID_PRICE.setText(StringUtil.formatWonEn(paidP));// 실수납액
      
      isCashPrice = StringUtil.getInteger(minD.CASH_AMT);
      et_CASH_AMT.setText(StringUtil.formatWonEn(minD.CASH_AMT));// 현금
      
      Watcher watcher = new Watcher(et_PAID_FEE_PRICE);
      et_PAID_FEE_PRICE.addTextChangedListener(watcher);
      
      watcher = new Watcher(et_PAID_PRICE);
      et_PAID_PRICE.addTextChangedListener(watcher);
      
      watcher = new Watcher(et_CASH_AMT);
      watcher.setText(et_PAID_PRICE, et_PAID_FEE_PRICE);
      et_CASH_AMT.addTextChangedListener(watcher);
      
      ALL_CHG_SMS_YN.setOnCheckedChangeListener(this);// 전체 체크
      
      CHG_SMS_RECV_YN.setChecked(getCheckedBoolean(minD.CHG_SMS_RECV_YN));
      CHECKUP_SMS_RECV_YN.setChecked(getCheckedBoolean(minD.CHECKUP_SMS_RECV_YN));
      BILL_SMS_RECV_YN.setChecked(getCheckedBoolean(minD.BILL_SMS_RECV_YN));
      READ_SMS_RECV_YN.setChecked(getCheckedBoolean(minD.READ_SMS_RECV_YN));
      UNPAID_SMS_RECV_YN.setChecked(getCheckedBoolean(minD.UNPAID_SMS_RECV_YN));
      PAY_INFO_SMS_REQ_YN.setChecked(getCheckedBoolean(minD.PAY_INFO_SMS_REQ_YN));
      
      if ("Y".equals(minD.END_YN)) btn_bill.setVisibility(View.VISIBLE);
      
      checkBoxAll();
      
      fileSave();
    }
  }
  
  /**
   * 사진 파일 저장
   */
  private void fileSave() {
    // 카메라 설정
    try {
      photoSeq = minD.REQUIRE_IDX + "";
      pc = new PicCamera(this, Constant.PIC_PATH, PicCamera.MODE_PICTURE, photoSeq + "", ".jpg");
      pc.setSingleMode(Boolean.FALSE);
      
      if (pc.fileCount() > 0) {
        ib_photoview.setVisibility(View.VISIBLE);
      } else {
        ib_photoview.setVisibility(View.GONE);
      }
      
      int cnt = 0;
      if (pc.fileCount() > 0) {
        
        String[] files = pc.getFiles();
        if (files.length > 0) {
          try {
            
            for (String str : files) {
              if (!"".equals(str) && cnt == 0) {
                cnt++;
                minD.PHOTO_FILE_NM = str;
              } else if (!"".equals(str) && cnt == 1) {
                cnt++;
                minD.PHOTO_FILE_NM2 = str;
              }
            }
          } catch (Exception ex) {
            // alert(R.string.msg_db_error); // 저장중 오류가 발생하였습니다.
          } finally {
          }
          MLog.d("photo : " + minD.PHOTO_FILE_NM + ", photo 2 : " + minD.PHOTO_FILE_NM2);
        }
        setVisibility(R.id.ib_photoview, View.VISIBLE);
      } else {
        pc.tempDelete();
        if (pc.fileCount() == 0) {
          minD.PHOTO_FILE_NM = "";
          minD.PHOTO_FILE_NM2 = "";
          setVisibility(R.id.ib_photoview, View.GONE);
        }
      }
    } catch (Exception e) {
    }
  }
  
  /***
   * 봉인상태 리턴
   * 
   * @return 봉인시 true
   */
  private boolean sealTypeCheck() {
    // "안전점검봉인해제 53" 미사용봉인 44";
    return "44".equals(minD.REQUIRE_CD) || "53".equals(minD.REQUIRE_CD);
  }
  
  // 렌지연결(49), 렌지교체(48), 호스교체(50), 중간밸브A/S(교체)(52), 보일러교체(57), 가스기기 철거(45)
  private boolean secondTypeCheck() {
    return "49".equals(minD.REQUIRE_CD) || "48".equals(minD.REQUIRE_CD) || "50".equals(minD.REQUIRE_CD) || "57".equals(minD.REQUIRE_CD) || "45".equals(minD.REQUIRE_CD);
  }
  
  /**
   * 업데이트
   * 
   * @param min
   */
  public void updateDb() {
    minD.PROC_USER_CD = SharedApplication.user.USER_ID;
    
    if (sealTypeCheck()) {// 현재 시간
      minD.METER = StringUtil.getString(tv_METER);
    }
    minD.PROC_DT = DateString.makeDateTimeString(DateString.getToday()).replace("/", "-");
    // 미사용봉인은 봉인처리코드를 미사용봉인 으로 등록해야함. (콤보 변경불가) 12로 처리
    if ("44".equals(minD.REQUIRE_CD)) {
      minD.SEAL_CD = "12";
    }
    minD.PROC_REMARK = StringUtil.getString(tv_PROC_REMARK);// 처리내용
    minD.PAID_FEE_PRICE = StringUtil.getFormatWonDe(StringUtil.getString(et_PAID_FEE_PRICE)); // 수수료 수 납 액
    
    minD.CASH_AMT = StringUtil.getFormatWonDe(StringUtil.getString(et_CASH_AMT));
    // sms 체크박스
    if ("47".equals(minD.REQUIRE_CD)) {
      minD.CHG_SMS_RECV_YN = getCheckedYN(CHG_SMS_RECV_YN.isChecked());
      minD.CHECKUP_SMS_RECV_YN = getCheckedYN(CHECKUP_SMS_RECV_YN.isChecked());
      minD.BILL_SMS_RECV_YN = getCheckedYN(BILL_SMS_RECV_YN.isChecked());
      minD.READ_SMS_RECV_YN = getCheckedYN(READ_SMS_RECV_YN.isChecked());
      minD.UNPAID_SMS_RECV_YN = getCheckedYN(UNPAID_SMS_RECV_YN.isChecked());
    }
    minD.PAY_INFO_SMS_REQ_YN = getCheckedYN(PAY_INFO_SMS_REQ_YN.isChecked());
    minD.END_YN = "Y";
    
    DbManager_MIN db = new DbManager_MIN();
    boolean result = db.updateColumn(db.TYPE_RESULT, minD);
    if (result) {
      Alert.alert(activity, getString(R.string.msg_saved), "runMINUpload");
    } else {
      alert(getString(R.string.msg_db_error));
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
      dbSelector();
    } else {
      Alert.alert(activity, "민원 SEND 저장중 오류가 발생 하였습니다.", null);
    }
    // db.close();
  }
  
  public String getProcDate(String endYn, String proDt) {
    String date = "";
    if ("N".equals(endYn)) {
      date = Util.getProcDate();
    } else {
      date = proDt;
    }
    return date;
  }
  
  private boolean getCheckedBoolean(String key) {
    boolean value = false;
    if ("Y".equals(key)) value = true;
    else value = false;
    return value;
  }
  
  private void setCheckBox(boolean ischeked) {
    if (ischeked) {
      CHG_SMS_RECV_YN.setChecked(true);
      CHECKUP_SMS_RECV_YN.setChecked(true);
      BILL_SMS_RECV_YN.setChecked(true);
      READ_SMS_RECV_YN.setChecked(true);
      UNPAID_SMS_RECV_YN.setChecked(true);
      // PAY_INFO_SMS_REQ_YN.setChecked(true);
    } else {
      CHG_SMS_RECV_YN.setChecked(false);
      CHECKUP_SMS_RECV_YN.setChecked(false);
      BILL_SMS_RECV_YN.setChecked(false);
      READ_SMS_RECV_YN.setChecked(false);
      UNPAID_SMS_RECV_YN.setChecked(false);
      // PAY_INFO_SMS_REQ_YN.setChecked(false);
    }
  }
  
  /**
   * 모든 체크박스 체크
   */
  public void checkBoxAll() {
    int isCheckNm = 0;
    
    if (CHG_SMS_RECV_YN.isChecked()) isCheckNm++;
    
    if (CHECKUP_SMS_RECV_YN.isChecked()) isCheckNm++;
    
    if (BILL_SMS_RECV_YN.isChecked()) isCheckNm++;
    
    if (READ_SMS_RECV_YN.isChecked()) isCheckNm++;
    
    if (UNPAID_SMS_RECV_YN.isChecked()) isCheckNm++;
    
    if (PAY_INFO_SMS_REQ_YN.isChecked()) isCheckNm++;
    
    ALL_CHG_SMS_YN.setChecked(isCheckNm >= 6 ? true : false);
  }
  
  // *@ 수수료는 현금으로만 결제 가능하고 요금만 카드로 결제 가능함 *
  // *@ 수수료는 무통장입금하는 경우 모두 안 받을 수 있음 : 일부만 수납할 수는 없음 *
  // *@ 수납액 = 요금수납 + 수수료수납 = 카드수납 + 현금수납
  // *@ 현금과 카드는 분할하여 수납은 가능하지만 요금전체를 카드로 받고, 수수료전체는 현금으로 결제하는 경우를 제외하고는 현금과 카드를 동시에 수납할 수 없음
  // *@ 분할인 경우 현금용과 카드영수증 별도 출력 현금 영수증 발행 안함
  // *@ 카드 영수증 별도 출력 - 카드 영수증에는 상세 금액내역 (법적비용 등) 은 필요없음 - 부가세는 없음
  // *@ 수납액 = 요금수납 + 수수료수납 = 카드수납 + 현금수납
  private boolean sendChecked() {
    
    // int paidcardP = StringUtil.getInteger(CARD_AMT.getText().toString()); // 카드 수납액
    // int paidGasP = StringUtil.getInteger(PAID_GAS_PRICE.getText().toString());// 요금 수납액
    
    int paidcashP = StringUtil.getInteger(StringUtil.getFormatWonDe(StringUtil.getString(et_CASH_AMT))); // 현금 수납액
    int paidFeeP = StringUtil.getInteger(StringUtil.getFormatWonDe(StringUtil.getString(et_PAID_FEE_PRICE)));// 수수료 수납액
    int paidPrce = StringUtil.getInteger(StringUtil.getFormatWonDe(StringUtil.getString(et_PAID_PRICE))); // 실수납액
    
    int feePrice = StringUtil.getInteger(StringUtil.getFormatWonDe(StringUtil.getString(tv_FEE_PRICE))); // 수수료
    
    int totalP = StringUtil.getInteger(StringUtil.getFormatWonDe(StringUtil.getString(tv_TOTAL_PRICE))); // 총액
    // int gasP = StringUtil.getInteger(minD.PAID_GAS_PRICE); // 요금계산금액
    int feeP = StringUtil.getInteger(StringUtil.getFormatWonDe(StringUtil.getString(tv_FEE_PRICE))); // 수수료 계산금액
    
    MLog.d("수납액 : " + paidcashP + ",수수료 수납액 :" + paidFeeP + ",실수납액" + paidPrce + ",수수료 계산금액" + feeP);
    
    if ("47".equals(minD.REQUIRE_CD)) {
      if ("".equals(minD.MV_IN_TEL_CD)) {
        alert("전입 고객정보 등록이 되지 않았습니다.");
        return false;
      }
    }
    // 수수료가 0인경우
    if (feePrice == 0) {
      Alert.confirm(activity, "수수료가 입력되지 않았습니다. 계속하시겠습니까?", "updateDb", null);
      return false;
    }
    // 수수료가 있고 수수료수납액과 실수납액이 0인경우
    else if (feePrice > 0 && (paidFeeP == 0 && paidPrce == 0)) {
      Alert.confirm(activity, "수납액이 없습니다 계속하시겠습니까?", "updateDb", null);
      return false;
    }
    
    if (paidFeeP == 0) Alert.alert(activity, "수수료가 입력되지 않습니다.", null);
    else if (paidPrce == 0) Alert.alert(activity, "수납액이 입력되지 않습니다.", null);
    else if (paidcashP == 0) Alert.alert(activity, "현금이 입력되지 않습니다.", null);
    
    if (feeP > 0) {
      // 총액 == 실수납액(실수납액 == 현금 수납액)
      if (paidPrce == paidcashP) {
        if (totalP == paidPrce) {
          return true;
        }
      }
    }
    
    if ("57".equals(minD.REQUIRE_CD)) {
      if (pc.fileCount() < 2) {
        alert("보일러 교체 민원 촬영 사진이 부족 합니다.");
        return false;
      }
    }
    Alert.alert(activity, "금액이 잘못 입력되었습니다.", null);
    return false;
  }
  
  // 반송시
  private void resendAlert() {
    minD.PROC_RESULT_CD = "5";
    Alert.confirm(this, "반송 하시겠습니까?", "updateDb", null);
  }
  
  private HashMap<String, String> getFilenames() {
    HashMap<String, String> filenames = new HashMap<String, String>();
    String pFilePath = Constant.PIC_PATH + "/";
    String sFilePath = Constant.SIGN_PATH + "/";
    if ("".equals(minD.SIGN_FILE_NM)) {
      filenames.put(pFilePath + minD.SIGN_FILE_NM, pFilePath + minD.SIGN_FILE_NM);
    } else if ("".equals(minD.PHOTO_FILE_NM)) {
      filenames.put(pFilePath + minD.PHOTO_FILE_NM, pFilePath + minD.PHOTO_FILE_NM);
    } else if ("".equals(minD.PHOTO_FILE_NM2)) {
      filenames.put(sFilePath + minD.PHOTO_FILE_NM2, sFilePath + minD.PHOTO_FILE_NM2);
    }
    return filenames;
  }
  
  // 완료버튼 송신
  public void runMINUpload() {
    CallTrans callTrans = new CallTrans(this);
    callTrans.callTrans(CallTrans.MIN_UP);
    callTrans.setAddFiles(getFilenames());
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
          // Toast.makeText(ReceiveActivity.this, resultMessage, Toast.LENGTH_SHORT).show();
          
          if (printConnected) {
            printType = Constant.KS_PRINT_PAY_S;
            Alert.alert(activity, getString(R.string.msg_success), "printStart");
          } else {
            Alert.confirm(activity, "장비 연결이 끊어진 상태입니다.\n 연결 하시겠습니까?", "onPrint", null);
          }
          setVisibility(R.id.btn_bill);
          updateSendYn();
        } else {
          Alert.alert(activity, getString(R.string.msg_fail) + "\n" + resultMessage, null);
          // Toast.makeText(ReceiveActivity.this, resultMessage, Toast.LENGTH_SHORT).show();
        }
      }
    });
  }
  
  // ------------------------ 영수증 프린트
  public void onPrint() {
    bluetoosePt();
    cPro = selectProviderDb();
    fee = selectMinFeeDb();
  }
  
  /**
   * Bluetooth 장비 핸들러
   * */
  private final Handler BluetoothPrinterHandler = new Handler(new Handler.Callback() {
    
    @SuppressWarnings("unchecked")
    @Override
    public boolean handleMessage(Message msg) {
      MLog.d("mHandler.handleMessage(" + msg + ")");
      
      switch (msg.what) {
        case BixolonPrinter.MESSAGE_STATE_CHANGE:
          switch (msg.arg1) {
            case BixolonPrinter.STATE_CONNECTED:
              printConnected = true;
              break;
            
            case BixolonPrinter.STATE_CONNECTING:
              break;
            
            case BixolonPrinter.STATE_NONE:
              printConnected = false;
              // mProgressBar.setVisibility(View.INVISIBLE);
              break;
          }
          return true;
          
        case BixolonPrinter.MESSAGE_READ:
          BluetoothDispatchMessage(msg);
          return true;
          
        case BixolonPrinter.MESSAGE_DEVICE_NAME:
          // mConnectedDeviceName = msg.getData().getString(BixolonPrinter.KEY_STRING_DEVICE_NAME);
          // Toast.makeText(context, mConnectedDeviceName, Toast.LENGTH_LONG).show();
          Toast.makeText(context, R.string.msg_connected_print, Toast.LENGTH_LONG).show();
          return true;
          
        case BixolonPrinter.MESSAGE_TOAST: // unable divace 처리
          // Toast.makeText(context, msg.getData().getString(BixolonPrinter.KEY_STRING_TOAST), Toast.LENGTH_SHORT).show();
          return true;
          
        case BixolonPrinter.MESSAGE_BLUETOOTH_DEVICE_SET:
          if (msg.obj == null) {
            Toast.makeText(context, R.string.msg_no_paired_print, Toast.LENGTH_SHORT).show();
          } else {
            BluetoothConnect((Set<BluetoothDevice>) msg.obj);
            
            // DialogManager.showBluetoothDialog(context, (Set<BluetoothDevice>) msg.obj);
          }
          return true;
          
        case BixolonPrinter.MESSAGE_PRINT_COMPLETE:
          Toast.makeText(context, R.string.msg_complete_to_print, Toast.LENGTH_SHORT).show();
          printComplete = !printComplete;
          printStorage();
          return true;
          
        case BixolonPrinter.MESSAGE_ERROR_NV_MEMORY_CAPACITY:
          // Toast.makeText(context, "NV memory capacity error", Toast.LENGTH_SHORT).show();
          Toast.makeText(context, R.string.msg_memory_capacity_error_print, Toast.LENGTH_SHORT).show();
          return true;
          
        case BixolonPrinter.MESSAGE_ERROR_OUT_OF_MEMORY:
          Toast.makeText(context, R.string.msg_out_of_memory_print, Toast.LENGTH_SHORT).show();
          return true;
          
        case BixolonPrinter.MESSAGE_NETWORK_DEVICE_SET:
          if (msg.obj == null) {
            // Toast.makeText(context, "No connectable device", Toast.LENGTH_SHORT).show();
            Toast.makeText(context, R.string.msg_no_connectable_print, Toast.LENGTH_SHORT).show();
          }
          return true;
      }
      return false;
    }
  });
  
  /**
   * print bluetoothPrinter find *
   **/
  private void bluetoosePt() {
    mBixolonPrinter = new BixolonPrinter(this, BluetoothPrinterHandler, null);
    mBixolonPrinter.findBluetoothPrinters();// Print Connect lib
    mBixolonPrinter.getMsrMode();// Psr Connect lib
    
    IntentFilter filter = new IntentFilter();
    filter.addAction(ACTION_GET_MSR_TRACK_DATA);
  }
  
  /**
   * 영수증 시작
   * 
   * @param type
   *          영수증 보관용 :0, 고객용 : 1
   */
  public void printStart() {
    if (!"Y".equals(minD.END_YN)) return;
    // setContentData(type);
    PrintTextThread thread = new PrintTextThread();
    thread.start();
  }
  
  /**
   * 
   * Bluetooth 영수증 텍스트 출력
   * */
  private void printText() {
    int alignment = BixolonPrinter.ALIGNMENT_LEFT;
    int attribute = BixolonPrinter.TEXT_ATTRIBUTE_FONT_A;
    int size = BixolonPrinter.TEXT_SIZE_VERTICAL1;
    // int type, Object min, Provider provider, ArrayList<MinLegalFee> legalfee, ArrayList<MinUnpaidPrice> unpaid, ArrayList<MinFee> minFee) {
    
    mBixolonPrinter.printText(StringUtil.PrinInBillData(printType, minD, cPro, fee, mFeepayArray), alignment, attribute, size, true);
  }
  
  public void completStorages() {
    printType = Constant.KS_PRINT_PAY_C;
    printStart();
  }
  
  public void completCancelStorages() {
    printComplete = !printComplete;
    // onFinish(minD, RESULT_OK);
  }
  
  /**
   * 고객용 > 보관용
   * */
  private void printStorage() {
    String msg = "";
    if (!printComplete) {
      Alert.confirm(activity, "영수증 출력이 잘 되었습니까?", "onfinish","printStart");
    }else{
      msg = getString(R.string.card_pay_customer_alert);
      Alert.confirm(activity, msg, "completStorages", "completCancelStorages");
    }
  }
  
  /** 텍스트 문자 프린트 */
  class PrintTextThread extends Thread {
    @Override
    public void run() {
      printText();
    }
  }
  
  /**
   * Bluetooth 메세지 처리
   * */
  private void BluetoothDispatchMessage(Message msg) {
    switch (msg.arg1) {
      case BixolonPrinter.PROCESS_MSR_TRACK:
        Intent intent = new Intent();
        intent.setAction(ACTION_GET_MSR_TRACK_DATA);
        intent.putExtra(EXTRA_NAME_MSR_TRACK_DATA, msg.getData());
        sendBroadcast(intent);
        break;
    }
  }
  
  /**
   * Bluetooth 프린터기 연결
   * */
  private void BluetoothConnect(final Set<BluetoothDevice> pairedDevices) {
    final String[] items = new String[pairedDevices.size()];
    int index = 0;
    for (BluetoothDevice device : pairedDevices) {
      items[index++] = device.getAddress();
    }
    
    mBixolonPrinter.connect(items[0]);
  }
  
  // 가맹점 정보
  private Provider selectProviderDb() {
    DbManager_PROVIDER db = new DbManager_PROVIDER();
    return db.getTotalList(db.getAllColumns());
  }
  
  // 법적조치 금액
  private ArrayList<MinLegalFee> selectMinLegalFeeDb() {
    DbManager_MIN_LEGAL_FEE db = new DbManager_MIN_LEGAL_FEE();
    if ("".equals(minD.REQUIRE_IDX)) return null;
    
    return db.getTotalList(db.getColumn(minD.REQUIRE_IDX));
  }
  
  // 수수료 금액
  private ArrayList<MinFee> selectMinFeeDb() {
    DbManager_MIN_FEE db = new DbManager_MIN_FEE();
    if ("".equals(minD.AREA_CD)) return null;
    
    return db.getTotalList(db.getItemCdColumn(minD.AREA_CD));
  }
  
  // 미납 금액
  private ArrayList<MinUnpaidPrice> selectMinUnpaidPriceDb() {
    DbManager_MIN_UNPAID_PRICE db = new DbManager_MIN_UNPAID_PRICE();
    if ("".equals(minD.REQUIRE_IDX)) return null;
    
    return db.getTotalList(db.getColumn(minD.REQUIRE_IDX));
  }
  
  @Override
  public void onClick(View v) {
    switch (v.getId()) {
      case R.id.b_fee:
        if ("N".equals(minD.SEND_YN)) {
          onResultActivity(CommissionActivity.class, minD);
        } else {
          alert("이미 완료 되었습니다.");
        }
        break;
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
      case R.id.btn_bill:
        MLog.d("send : " + minD.SEND_YN + "end : " + minD.END_YN);
        if ("Y".equals(minD.END_YN)) {
          if (printConnected) {
            printType = Constant.KS_PRINT_PAY_C;
            printStart();
          } else {
            Alert.confirm(activity, "장비 연결이 끊어진 상태입니다.\n 연결 하시겠습니까?", "onPrint", null);
          }
        }
        break;
      case R.id.b_commit:
        if ("N".equals(minD.SEND_YN)) {
          minD.PROC_RESULT_CD = "1";
          if (sendChecked()) updateDb();
        } else {
          alert("이미 완료 되었습니다.");
        }
        break;
      case R.id.b_camera:
        if ("N".equals(minD.SEND_YN)) {
          pc.start();
        } else {
          alert("이미 완료 되었습니다.");
        }
        break;
      case R.id.ib_photoview:
        Intent intentPic = new Intent(activity, PicViewerActivity.class);
        intentPic.putExtra("imgRoot", Constant.PIC_PATH);
        intentPic.putExtra("mode", PicCamera.MODE_PICTURE);
        intentPic.putExtra("prefix", photoSeq);
        intentPic.putExtra("suffix", ".jpg");
        if ("Y".equals(minD.SEND_YN)) { // 송신완료.
          intentPic.putExtra("delAble", false);
        }
        startActivityForResult(intentPic, Constant.PROC_ID_PIC_VIWER);
        break;
    }
  }
  
  @Override
  public void onCheckedChanged(CompoundButton view, boolean isChecked) {
    // TODO Auto-generated method stub
    if (view.getId() == R.id.ALL_CHG_SMS_YN) {
      setCheckBox(isChecked);
    }
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
          dbSelector();
        } catch (Exception e) {
        }
        arrangeView();
        break;
      case Constant.PROC_ID_TAKE_CAMERA:
        if (resultCode != 0) {
          pc.save();
          if (pc.fileCount() > 2) {
            pc.delete();
            pc.tempDelete();
          }
          fileSave();
        } else {
          pc.tempDelete();
        }
        break;
      case Constant.PROC_ID_PIC_VIWER:
        boolean rtn = data.getBooleanExtra("FILE_DELETED", false);
        String fileName = data.getStringExtra("FILE_DELETED_NAME");
        if (rtn) {
          if (pc.fileCount() > 0) {
            setVisibility(R.id.ib_photoview, View.VISIBLE);
          } else {
            setVisibility(R.id.ib_photoview, View.INVISIBLE);
          }
          fileSave();
        }
        break;
    }
  }
}
