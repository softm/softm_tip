package com.entropykorea.gas.as.activity;

import java.text.DecimalFormat;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Set;

import android.annotation.SuppressLint;
import android.bluetooth.BluetoothDevice;
import android.content.Intent;
import android.content.IntentFilter;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.ArrayAdapter;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.CompoundButton.OnCheckedChangeListener;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import com.bixolon.printer.BixolonPrinter;
import com.entropykorea.gas.as.AppContext;
import com.entropykorea.gas.as.R;
import com.entropykorea.gas.as.SharedApplication;
import com.entropykorea.gas.as.bean.Code;
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
import com.entropykorea.gas.as.common.util.PayUtil;
import com.entropykorea.gas.as.common.util.StringUtil;
import com.entropykorea.gas.as.constants.Constant;
import com.entropykorea.gas.as.database.DbManager_CODE;
import com.entropykorea.gas.as.database.DbManager_MIN;
import com.entropykorea.gas.as.database.DbManager_MIN_FEE_PAY;
import com.entropykorea.gas.as.database.DbManager_MIN_LEGAL_FEE;
import com.entropykorea.gas.as.database.DbManager_MIN_UNPAID_PRICE;
import com.entropykorea.gas.as.database.DbManager_PROVIDER;
import com.entropykorea.gas.as.ewire.CallTrans;
import com.entropykorea.gas.as.ewire.CallTrans.onFinished;
import com.entropykorea.gas.lib.PicCamera;
import com.entropykorea.gas.lib.activity.PicViewerActivity;

/***
 * 
 * @author Hoon
 *
 */
public class DetailOutActivity extends BasedActivity implements OnMethod, OnTopClickListner, OnClickListener, OnCheckedChangeListener, OnMenuItemClickListener {
  private TextView tv_ADDRESS = null;
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
  
  private EditText et_PAID_GAS_PRICE = null;// 요금 수 납 액
  private EditText et_PAID_FEE_PRICE = null;// 수수료 수 납 액
  private EditText et_PAID_PRICE = null; // 실수납액
  private EditText et_CASH_AMT = null; // 현금
  private EditText et_CARD_AMT = null; // 카드
  
  private CheckBox PAY_INFO_SMS_REQ_YN = null;
  private CheckBox seal_check = null; // 미봉
  private Spinner sealSpinner = null;
  private ImageButton btn_bill = null;
  private ImageButton ib_photoview = null;
  
  private ArrayAdapter<String> spinnAdapter = null;
  private String SEAL_CD_NM = "";
  
  private PicCamera pc = null;
  // --------------------------------------
  static final String ACTION_GET_MSR_TRACK_DATA = "com.bixolon.anction.GET_MSR_TRACK_DATA";
  static final String EXTRA_NAME_MSR_TRACK_DATA = "MsrTrackData";
  
  public static BixolonPrinter mBixolonPrinter;
  private boolean printConnected = false; // 블루투스 장비 연결상태 값
  private boolean printComplete = false;
  private String mConnectedDeviceName = null;
  private int printType = 0;
  
  private Provider cPro = new Provider();
  private ArrayList<MinLegalFee> lp = new ArrayList<MinLegalFee>();
  private ArrayList<MinUnpaidPrice> uP = new ArrayList<MinUnpaidPrice>();
  private ArrayList<MinFee> fee = new ArrayList<MinFee>();
  private ArrayList<MinFeePay> mFeepayArray = null;
  private ArrayList<MinUnpaidPrice> unpaidArray = null;
  private ArrayList<MinLegalFee> legalArray = null;
  
  private long isTotalPrice = 0; // 총액
  private long isPurchasePrice = 0; // 실수납액
  private long isGasPrice = 0; // 요금계산
  private long isFeePrice = 0; // 수수료
  private long isCashPrice = 0; // 현금  금액
  private long isCardPrice = 0; // 카드  금액
  private boolean isSmsChecked = false; // 문자발송 요청
  
  private DecimalFormat df = new DecimalFormat("###,###.####");
  private String watcherString = "";
  
  @Override
  protected void onCreate(Bundle savedInstanceState) {
    super.onCreate(savedInstanceState);
    
    View mMainLayout = (View) getLayoutInflater().inflate(R.layout.activity_detail_out_as, null);
    addTopView(mMainLayout);
    setTopBarText("민원처리");
    setTwoBtnVisible(View.GONE);
    setOnTopClickListner(this);
    
    init();
    arrangeView();
  }
  
  @Override
  protected void onResume() {
    try {
      if ("Y".equals(minD.END_YN)) onPrint();
    } catch (Exception e) {
    }
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
    findViewById(R.id.b_payment).setOnClickListener(this);
    findViewById(R.id.b_card).setOnClickListener(this);
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
    tv_ADDRESS = (TextView) findViewById(R.id.ADDRESS); // 주소
    tv_HOUSE_NO = (TextView) findViewById(R.id.HOUSE_NO); // 수 용 가 번호
    tv_PURPOSE_CD = (TextView) findViewById(R.id.PURPOSE_CD);// 용 도
    tv_REQUIRE_CD = (TextView) findViewById(R.id.REQUIRE_CD);// 민원종류
    tv_HOUSE_STATUS_CD = (TextView) findViewById(R.id.HOUSE_STATUS_CD);// 공급상태
    tv_CUST_NM = (TextView) findViewById(R.id.CUST_NM);// 고 객 명
    tv_TEL_NO = (TextView) findViewById(R.id.TEL_NO);// 주연락처
    tv_REQUEST_REMARK = (TextView) findViewById(R.id.REQUEST_REMARK);// 민원내용
    tv_PROC_REMARK = (TextView) findViewById(R.id.PROC_REMARK);// 처리내용
    tv_TOTAL_PRICE = (TextView) findViewById(R.id.TOTAL_PRICE);// 총 액
    tv_TOT_GAS_PRICE = (TextView) findViewById(R.id.TOT_GAS_PRICE);// 요금계산
    tv_FEE_PRICE = (TextView) findViewById(R.id.FEE_PRICE);// 수 수 료
    
    et_PAID_GAS_PRICE = (EditText) findViewById(R.id.PAID_GAS_PRICE);// 요금 수 납 액
    et_PAID_FEE_PRICE = (EditText) findViewById(R.id.PAID_FEE_PRICE);// 수수료 수 납 액
    et_PAID_PRICE = (EditText) findViewById(R.id.PAID_PRICE);// 실수납액
    et_CASH_AMT = (EditText) findViewById(R.id.CASH_AMT); // 현 금
    et_CARD_AMT = (EditText) findViewById(R.id.CARD_AMT); // 카 드
    
    PAY_INFO_SMS_REQ_YN = (CheckBox) findViewById(R.id.PAY_INFO_SMS_REQ_YN);// 입금정보 문자발송 요청
    PAY_INFO_SMS_REQ_YN.setOnCheckedChangeListener(this);
    
    seal_check = (CheckBox) findViewById(R.id.seal_check); // 미봉인
    sealSpinner = (Spinner) findViewById(R.id.spinner);
    
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
    
    DbManager_MIN_LEGAL_FEE db3 = new DbManager_MIN_LEGAL_FEE();
    legalArray = db3.getTotalList(db3.getColumn(minD.REQUIRE_IDX));
    
    DbManager_MIN_UNPAID_PRICE db4 = new DbManager_MIN_UNPAID_PRICE();
    unpaidArray = db4.getTotalList(db4.getColumn(minD.REQUIRE_IDX));
    
    priceSett();
  }
  
  @Override
  public void arrangeView() {
    REQUIRE_IDX = getIntent().getIntExtra("REQUIRE_IDX", 0);
    MLog.e("REQUIRE_IDX:" + REQUIRE_IDX);
    if (REQUIRE_IDX != 0) {
      dbSelector();
      
      // 민원 종류가 “체납봉인해제”인 경우만 요금과 수수료를 동시에 수납 가능함
      // - 체납봉인해제인 경우 영수증 출력시 지침과, 당월요금 출력 불필요
      if ("41".equals(minD.REQUIRE_CD)) {
        setVisibility(R.id.tr_fee);
        setVisibility(R.id.tr_fee_price);
      }
      // HOUSE_LIVING_CD MA210
      // 전출인 경우에 건물주거구분이 단독과 특정인 경우는 “잠금이대상입니다.” 알림창 팝업
      // 단독 2, 특정 3
      if ("2".equals(minD.HOUSE_LIVING_CD) || "3".equals(minD.HOUSE_LIVING_CD)) {
        alert("잠금이대상입니다.");
      }
      // HOUSE_STATUS_CD MA090 04
      // 화면에 들어오면 전출인 경우에 공급상태가 중지인 경우는 “중지세대입니다.” 알림창 팝업
      if ("04".equals(minD.HOUSE_STATUS_CD)) {
        alert("중지세대입니다.");
      }
      
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
      tv_PROC_REMARK.setText(minD.PROC_REMARK);
      
      totalPriceSett(); // 총액
      
      tv_TOT_GAS_PRICE.setText(StringUtil.formatWonEn(isGasPrice + "")); // 요금계산
      tv_FEE_PRICE.setText(StringUtil.formatWonEn(isFeePrice + "")); // 수수료
      tv_TOTAL_PRICE.setText(StringUtil.formatWonEn(isTotalPrice + ""));// 총액
      
      if ("Y".equals(minD.SEND_YN)) {
        et_PAID_GAS_PRICE.setText(StringUtil.formatWonEn(minD.PAID_GAS_PRICE + ""));// 요금 수납 = 요금계산
        et_PAID_FEE_PRICE.setText(StringUtil.formatWonEn(minD.PAID_FEE_PRICE + ""));// 수수료수납금액 = 수수료
      } else {
        et_PAID_GAS_PRICE.setText(StringUtil.formatWonEn(isGasPrice + ""));// 요금 수납 = 요금계산
        et_PAID_FEE_PRICE.setText(StringUtil.formatWonEn(isFeePrice + ""));// 수수료수납금액 = 수수료
      }
      String paidP = "";
      if (!"".equals(StringUtil.isNullString(minD.CASH_AMT)) || !"".equals(StringUtil.isNullString(minD.CARD_AMT))) {
        paidP = (StringUtil.getInteger(minD.CASH_AMT) + StringUtil.getInteger(minD.CARD_AMT)) + "";
      } else {
        paidP = isTotalPrice + "";
      }
      
      et_PAID_PRICE.setText(StringUtil.formatWonEn(paidP));// 실수납액
      isCashPrice = StringUtil.getInteger(minD.CASH_AMT);
      isCardPrice = StringUtil.getInteger(minD.CARD_AMT);
      et_CASH_AMT.setText(StringUtil.formatWonEn(minD.CASH_AMT)); // 현금
      et_CARD_AMT.setText(StringUtil.formatWonEn(minD.CARD_AMT)); // 카드
      
      PAY_INFO_SMS_REQ_YN.setChecked(getChecked(minD.PAY_INFO_SMS_REQ_YN));
      
      Watcher watcher = new Watcher(et_PAID_PRICE);
      et_PAID_PRICE.addTextChangedListener(watcher);
      
      watcher = new Watcher(et_PAID_GAS_PRICE);
      et_PAID_GAS_PRICE.addTextChangedListener(watcher);
      
      watcher = new Watcher(et_PAID_FEE_PRICE);
      et_PAID_FEE_PRICE.addTextChangedListener(watcher);
      
      // watcher = new Watcher(et_CASH_AMT);
      // et_CASH_AMT.addTextChangedListener(watcher);
      //
      // watcher = new Watcher(et_CARD_AMT);
      // et_CARD_AMT.addTextChangedListener(watcher);
      
      et_CASH_AMT.addTextChangedListener(CashWatcher);
      et_CARD_AMT.addTextChangedListener(CardWatcher);
      
      if ("Y".equals(minD.END_YN)) btn_bill.setVisibility(View.VISIBLE);
      
      spinnerData();
      seal_check.setOnCheckedChangeListener(this);
      seal_check.setChecked(true);
      
      fileSave();
    }
  }
  
  private void priceSett() {
    int basePrice = 0;
    int usePrice = 0;
    int udpaidpricePrice = 0;
    int legalPrice = 0;
    
    usePrice = StringUtil.getInteger(minD.USE_PRICE);
    basePrice = StringUtil.getInteger(minD.BASE_PRICE);
    
    udpaidpricePrice = PayUtil.getUnpaidpricePriceSum(unpaidArray);
    legalPrice = PayUtil.getLegalPriceSum(legalArray);
    isGasPrice = PayUtil.getTotalPriceSum(usePrice, basePrice, udpaidpricePrice, legalPrice);
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
  
  /**
   * 봉인상태 스피너
   */
  private void spinnerData() {
    
    ArrayList<Code> data = null;
    Handler h = new Handler() {
      @Override
      public void handleMessage(Message msg) {
        super.handleMessage(msg);
        MLog.e("Code result: " + msg.hashCode() + ",what:" + msg.what);
        if (msg.what == Constant.RESULT_SUCCESS) {
          MLog.e("Code db: RESULT_SUCCESS");
        } else {
          MLog.e("Code db: RESULT_FAILL");
        }
      }
    };
    DbManager_CODE db = new DbManager_CODE();
    db.DbHandler(h);
    data = db.getTotalList(db.getColumn("MA220"));
    if (data.size() == 0) return;
    
    ArrayList<String> spinnerCategories = new ArrayList<String>();
    spinnerCategories.add("선택없음");
    for (Code code : data) {
      spinnerCategories.add(code.CD_NM);
    }
    
    spinnAdapter = new ArrayAdapter<String>(DetailOutActivity.this, android.R.layout.simple_spinner_item, spinnerCategories);
    spinnAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
    sealSpinner.setAdapter(spinnAdapter);
    sealSpinner.setOnItemSelectedListener(new OnItemSelectedListener() {
      
      @Override
      public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
        String item = parent.getItemAtPosition(position).toString();
        SEAL_CD_NM = item;
        if (position == 0) {
          seal_check.setChecked(true);
        } else {
          seal_check.setChecked(false);
        }
        // Toast.makeText(parent.getContext(), "Selected: " + item, Toast.LENGTH_LONG).show();
      }
      
      @Override
      public void onNothingSelected(AdapterView<?> arg0) {
      }
    });
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
  
  /**
   * 완료시 업데이트
   * 
   * @param min
   */
  public void updateDb() {
    
    minD.PROC_USER_CD = SharedApplication.user.USER_ID;
    minD.PROC_DT = DateString.makeDateTimeString(DateString.getToday()).replace("/", "-");
    
    minD.PROC_REMARK = StringUtil.getString(tv_PROC_REMARK);// 처리내용
    minD.PAID_GAS_PRICE = StringUtil.getFormatWonDe(StringUtil.getString(et_PAID_GAS_PRICE));// 요금 수 납 액
    minD.PAID_FEE_PRICE = StringUtil.getFormatWonDe(StringUtil.getString(et_PAID_FEE_PRICE));// 수수료 수 납 액
    
    minD.CASH_AMT = StringUtil.getFormatWonDe(StringUtil.getString(et_CASH_AMT));
    
    BaseCode mBaseCode = new BaseCode(AppContext.getSQLiteDatabase(), "MA220");
    minD.SEAL_CD = mBaseCode.getCodeByName("MA220", SEAL_CD_NM);
    
    minD.PAY_INFO_SMS_REQ_YN = getCheckedYN(PAY_INFO_SMS_REQ_YN.isChecked());
    
    minD.END_YN = "Y";
    
    DbManager_MIN db = new DbManager_MIN();
    boolean result = db.updateColumn(db.TYPE_RESULT, minD);
    // db.close();
    MLog.e("Min count :" + db.getTotalList(db.getAllColumns()).size());
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
    db.close();
  }
  
  // *@ 수수료는 현금으로만 결제 가능하고 요금만 카드로 결제 가능함 *
  // *@ 무통장 : 요금수납= 0, 수수료 수납 = 0, 실수납액 = 0, 현금 = 0, 카드 = 0 모든금액은 무통장 입금처리
  // *@ 수납액 = 요금수납 + 수수료수납 = 카드수납 + 현금수납
  // *@ 현금과 카드는 분할하여 수납은 가능하지만 요금전체를 카드로 받고, 수수료전체는 현금으로 결제하는 경우를 제외하고는 현금과 카드를 동시에 수납할 수 없음
  // *@ 분할인 경우 현금용과 카드영수증 별도 출력 현금 영수증 발행 안함
  // *@ 카드 영수증 별도 출력 - 카드 영수증에는 상세 금액내역 (법적비용 등) 은 필요없음 - 부가세는 없음
  // *@ 수납액 = 요금수납 + 수수료수납 = 카드수납 + 현금수납
  private boolean sendChecked() {
    
    int paidGasP = StringUtil.getInteger(StringUtil.getFormatWonDe(StringUtil.getString(et_PAID_GAS_PRICE)));// 요금 수납
    int paidFeeP = StringUtil.getInteger(StringUtil.getFormatWonDe(StringUtil.getString(et_PAID_FEE_PRICE)));// 수수료 수납
    int paidPrce = StringUtil.getInteger(StringUtil.getFormatWonDe(StringUtil.getString(et_PAID_PRICE))); // 실수납액
    
    int cashAmt = StringUtil.getInteger(StringUtil.getFormatWonDe(StringUtil.getString(et_CASH_AMT))); // 현금수납
    int cardAmt = StringUtil.getInteger(minD.CARD_AMT); // 카드 수납액 
    boolean seal41 = true; // 체납봉인해제 41 봉인해제인에서만 수수료 체
    
    isGasPrice = StringUtil.getInteger(minD.PAID_GAS_PRICE); // 요금계산금액
    
    String message = tv_PROC_REMARK.getText().toString();
    
    // 1. 실수납액이 총액보다 크면 false
    // 2. 요금수납이 요금계산 또는 실수납보다 크면 false
    // 3. 수수료수납이 수수료금액도 아니고 0도 아니면 false
    // 4. 요금수납과 수수료수납 합계가 실수납액과 다르면 false
    // 5. 카드금액이 요금수납과 다르고 0도 아니면 false
    // 6. 현금금액과 카드금액 합계가 실수납액과 다르면 false
    
    // 총액 isTotalPrice
    // 요금계산 isGasPrice
    // 수수료금액 isFeePrice
    // 현금 금액 isCashPrice
    // 카드 수납액 cardAmt;
    if (paidPrce == 0) { // 실수납액 체크
      //Alert.alert(activity, "요금을 입력하지 않습니다.", null);
      return false;
    }
    
    else if (paidPrce > isTotalPrice) {
      return false;
    } else if ((paidGasP > isGasPrice) || (paidGasP > paidPrce)) {
      return false;
    } else if ((paidFeeP != isFeePrice) || (paidFeeP != 0)) {
      return false;
    } else if ((paidGasP + paidFeeP) != paidPrce) {
      return false;
    } else if ((cardAmt != paidGasP) || (cardAmt != 0)) {
      return false;
    } else if ((isCashPrice +cardAmt) != paidPrce) {
      return false;
    }
    
    
    // 요금수납과 수수료수납이 빈상태
//    if ("41".equals(minD.REQUIRE_CD)) {
//      if (paidFeeP == 0 || paidFeeP == paidGasP) {
//        seal41 = true;
//      } else {
//        seal41 = false;
//      }
//    }
//    
//    if (paidGasP > 0 && paidPrce > 0 && seal41) {
//      
//      // 총액 <= 실수납액
//      if (isTotalPrice <= paidPrce) {
//        // 현금만 입금된 경우
//        if (isCashPrice > 0 && isCardPrice == 0) {
//          // 요금수납 <= 실수납액
//          if (paidGasP <= paidPrce) {
//            return true;
//          }
//        }
//        // 카드만 입금된경우
//        else if (isCashPrice == 0 && isCardPrice > 0) {
//          // 카드 승인이 있어야 함
//          if (isCardPrice == StringUtil.getInteger(minD.CARD_AMT)) {
//            // 수수료는 없어야되며 요금수납 <= 실수납액
//            if (isFeePrice == 0 && (paidGasP <= paidPrce)) {
//              return true;
//            }
//          }
//          
//        } else if (isCashPrice > 0 && isCardPrice > 0) {
//          // 요금수납 <= 실수납액
//          if (paidGasP <= paidPrce) {
//            return true;
//          }
//        }
//      }
//    } else {
//      if (paidGasP == 0 && paidPrce == 0 && seal41) {
//        if (isSmsChecked) {
//          return true;
//        }
//      }
//    }
//    Alert.alert(activity, "금액을 다시 확인 바랍니다.", null);
    return true;
  }
  
  /**
   * isTotalPrice 총액
   */
  private void totalPriceSett() {
    int feeP = 0;
    if (mFeepayArray.size() > 0) {
      for (int i = 0; i < mFeepayArray.size(); i++) {
        int unit = StringUtil.getInteger(mFeepayArray.get(i).PROC_UNIT_PRICE);
        int qty = mFeepayArray.get(i).PROC_QTY;
        feeP += (unit * qty);
      }
    }
    
    isTotalPrice = minD.TOT_PRICE; // 총액
    // isGasPrice = StringUtil.getInteger(minD.PAID_GAS_PRICE); // 요금계산금액
    isFeePrice = feeP; // 수수료 계산금액
    
    isTotalPrice = isFeePrice + isGasPrice;
  }
  
  // 반송시
  private void resendAlert() {
    minD.PROC_RESULT_CD = "5";
    Alert.confirm(this, "반송 하시겠습니까?", "updateDb", null);
  }
  
  private boolean getChecked(String key) {
    boolean value = false;
    if ("Y".equals(key)) value = true;
    else value = false;
    
    return value;
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
            printType = Constant.KS_PRINT_PAY_C;
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
  
  @Override
  public void onClick(View v) {
    switch (v.getId()) {
      case R.id.b_payment:
        onResultActivity(PaymentActivity.class, minD);
        break;
      case R.id.b_card:
        if ("N".equals(minD.SEND_YN)) {
          if (isCardPrice == 0) {
            Alert.alert(activity, "카드 금액을 입력하세요.", null);
          } else {
            onResultActivity(CardPayActivity.class, minD, isCardPrice);
          }
        } else {
          alert("이미 완료 되었습니다.");
        }
        break;
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
      case R.id.btn_resend:// 반송
        if ("N".equals(minD.SEND_YN)) {
          resendAlert();
        } else {
          alert("이미 완료 되었습니다.");
        }
        break;
      case R.id.btn_bill:
        if ("Y".equals(minD.END_YN)) {
          if (printConnected) {
            printType = Constant.KS_PRINT_PAY_C;
            printStart();
          } else {
            Alert.confirm(activity, "장비 연결이 끊어진 상태입니다.\n 연결 하시겠습니까?", "onPrint", null);
          }
        }
        // MLog.d(StringUtil.PrintOutBillData(printType, minD, cPro, lp, uP));
        break;
      case R.id.b_commit:
        if ("N".equals(minD.SEND_YN)) {
          minD.PROC_RESULT_CD = "1";
          if (sendChecked()){
            updateDb();
          }else{
            Alert.alert(activity, "금액을 다시 확인 바랍니다.", null);
          }
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
    if (view.getId() == R.id.PAY_INFO_SMS_REQ_YN) {
      isSmsChecked = isChecked;
    } else {
      if (isChecked) {
        sealSpinner.setEnabled(isChecked);
        sealSpinner.setSelection(0);
      }
    }
  }
  
  // ------------------------ 영수증 프린트
  public void onPrint() {
    bluetoosePt();
    cPro = selectProviderDb();
    lp = selectMinLegalFeeDb();
    uP = selectMinUnpaidPriceDb();
    fee = new ArrayList<MinFee>();
  }
  
  private void printSelectAlert() {
    Alert.confirm(activity, "장비 연결이 끊어진 상태입니다.\n 연결 하시겠습니까?", "onPrint", null);
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
          Toast.makeText(context, R.string.msg_memory_capacity_error_print, Toast.LENGTH_SHORT).show();
          return true;
          
        case BixolonPrinter.MESSAGE_ERROR_OUT_OF_MEMORY:
          Toast.makeText(context, R.string.msg_out_of_memory_print, Toast.LENGTH_SHORT).show();
          return true;
          
        case BixolonPrinter.MESSAGE_NETWORK_DEVICE_SET:
          if (msg.obj == null) {
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
  
  /** 텍스트 문자 프린트 */
  class PrintTextThread extends Thread {
    @Override
    public void run() {
      printText();
    }
  }
  
  /**
   * 영수증 시작
   * 
   * @param type
   *          영수증 보관용 :0, 고객용 : 1
   */
  public void printStart() {
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
    if ("41".equals(minD.REQUIRE_CD)) {
      mBixolonPrinter.printText(StringUtil.PrintSealBillData(printType, minD, cPro, lp, uP, fee, mFeepayArray), alignment, attribute, size, true);
    } else {
      mBixolonPrinter.printText(StringUtil.PrintOutBillData(printType, minD, cPro, lp, uP), alignment, attribute, size, true);
    }
  }
  
  public void completStorages() {
    printType = Constant.KS_PRINT_PAY_C;
    printStart();
  }
  
  public void completCancelStorages() {
    printComplete = !printComplete;
  }
  
  /**
   * 보관용 영수증 이후 고객용 선택
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
  @SuppressLint("HandlerLeak")
  private Provider selectProviderDb() {
    Handler h = new Handler() {
      @Override
      public void handleMessage(Message msg) {
        super.handleMessage(msg);
        MLog.e("Min result: " + msg.hashCode() + ",what:" + msg.what);
        if (msg.what == Constant.RESULT_SUCCESS) {
          MLog.e("Min : RESULT_SUCCESS");
        } else {
          MLog.e("Min : RESULT_FAILL");
        }
      }
    };
    DbManager_PROVIDER db = new DbManager_PROVIDER();
    db.DbHandler(h);
    return db.getTotalList(db.getAllColumns());
  }
  
  // 법적조치 금액
  private ArrayList<MinLegalFee> selectMinLegalFeeDb() {
    DbManager_MIN_LEGAL_FEE db = new DbManager_MIN_LEGAL_FEE();
    if (!"".equals(minD.HOUSE_NO)) return lp;
    
    return db.getTotalList(db.getColumn(StringUtil.getInteger(minD.HOUSE_NO)));
  }
  
  // 미납 금액
  private ArrayList<MinUnpaidPrice> selectMinUnpaidPriceDb() {
    DbManager_MIN_UNPAID_PRICE db = new DbManager_MIN_UNPAID_PRICE();
    return db.getTotalList(db.getColumn(minD.REQUIRE_IDX));
  }
  
  TextWatcher CashWatcher = new TextWatcher() {
    
    @Override
    public void onTextChanged(CharSequence s, int start, int before, int count) {
      String sumPrice = "";
      String st = "";
      try {
        if (!s.toString().equals(watcherString)) { // StackOverflow를 막기위해,
        
          st = s.toString();
          isCashPrice = Long.valueOf(StringUtil.getFormatWonDe(st));
          sumPrice = (isCashPrice + isCardPrice) + "";
          
          sumPrice = String.valueOf(sumPrice + "");
          
          watcherString = dfFormat(s.toString()); // 에딧텍스트의 값을 변환하여, result에 저장.
          et_CASH_AMT.setText(watcherString); // 결과 텍스트 셋팅.
          et_CASH_AMT.setSelection(watcherString.length()); // 커서를 제일 끝으로 보냄.
          
          sumPrice = StringUtil.getFormatWonDe(sumPrice);
          setPurchase(sumPrice);
        }
      } catch (NumberFormatException e) {
        isCashPrice = 0;
        setPurchase("0");
      }
    }
    
    @Override
    public void beforeTextChanged(CharSequence s, int start, int count, int after) {
    }
    
    @Override
    public void afterTextChanged(Editable s) {
    }
  };
  
  TextWatcher CardWatcher = new TextWatcher() {
    
    @Override
    public void onTextChanged(CharSequence s, int start, int before, int count) {
      String sumPrice = "";
      String st = "";
      try {
        if (!s.toString().equals(watcherString)) { // StackOverflow를 막기위해,
        
          st = s.toString();
          isCardPrice = Long.valueOf(StringUtil.getFormatWonDe(st));
          sumPrice = (isCardPrice + isCashPrice) + "";
          
          sumPrice = String.valueOf(sumPrice);
          watcherString = dfFormat(s.toString()); // 에딧텍스트의 값을 변환하여, result에 저장.
          et_CARD_AMT.setText(watcherString); // 결과 텍스트 셋팅.
          et_CARD_AMT.setSelection(watcherString.length()); // 커서를 제일 끝으로 보냄.
          
          sumPrice = StringUtil.getFormatWonDe(sumPrice);
          setPurchase(sumPrice);
        }
      } catch (NumberFormatException e) {
        isCardPrice = 0;
        setPurchase("0");
      }
    }
    
    @Override
    public void beforeTextChanged(CharSequence s, int start, int count, int after) {
    }
    
    @Override
    public void afterTextChanged(Editable s) {
    }
  };
  
  private String dfFormat(String str) {
    if (str != null && !"".equals(str)) {
      return df.format(Long.parseLong(str.replaceAll(",", "")));
    } else {
      return "";
    }
  }
  
  /**
   * 수납액 입력
   * 
   * @param sumPrice
   */
  private void setPurchase(String sumPrice) {
    if ("0".equals(sumPrice)) {
      sumPrice = (isCashPrice + isCardPrice) + "";
    }
    // isPurchasePrice = (isCashPrice + isCardPrice);
    String str = dfFormat(sumPrice);
    et_PAID_PRICE.setText("0".equals(str) ? "0" : str);
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
    lanchScan(v);
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
          isGasPrice = StringUtil.getInteger(minD.PAID_GAS_PRICE); // 요금계산금액
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
