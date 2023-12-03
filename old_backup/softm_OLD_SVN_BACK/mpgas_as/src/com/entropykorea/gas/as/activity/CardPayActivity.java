package com.entropykorea.gas.as.activity;

import java.util.Set;

import android.annotation.SuppressLint;
import android.bluetooth.BluetoothDevice;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.TableLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.bixolon.printer.BixolonPrinter;
import com.entropykorea.gas.as.R;
import com.entropykorea.gas.as.SharedApplication;
import com.entropykorea.gas.as.bean.Min;
import com.entropykorea.gas.as.bean.Provider;
import com.entropykorea.gas.as.common.base.BasedActivity;
import com.entropykorea.gas.as.common.base.BasedActivity.OnMethod;
import com.entropykorea.gas.as.common.base.TopBar.OnTopClickListner;
import com.entropykorea.gas.as.common.kspay.PrinterAndKsPay;
import com.entropykorea.gas.as.common.object.Alert;
import com.entropykorea.gas.as.common.object.MLog;
import com.entropykorea.gas.as.common.object.SignView;
import com.entropykorea.gas.as.common.object.Watcher;
import com.entropykorea.gas.as.common.util.StringUtil;
import com.entropykorea.gas.as.common.util.Util;
import com.entropykorea.gas.as.constants.Constant;
import com.entropykorea.gas.as.constants.KsPayCode;
import com.entropykorea.gas.as.database.DbManager_MIN;
import com.entropykorea.gas.as.database.DbManager_PROVIDER;

public class CardPayActivity extends BasedActivity implements OnMethod, OnTopClickListner, OnClickListener, OnMenuItemClickListener {
  
  private byte[] cardTrackData;
  
  private EditText et_pay, et_card, et_mm, et_yy, et_card_month;
  private TextView ADDRESS, tv_pay, tv_card, tv_mm, tv_yy, tv_card_month;
  private ImageButton btn_close, b_commit, btn_delete;
  private SignView signView = null;
  private TableLayout cacel_layout = null;
  
  private String signFilePath = "";
  private String saveFileName = "";
  private String loadFileName = "";
  
  private String cardTrackII = "";
  // Name of the connected device
  private String mConnectedDeviceName = null;
  
  private long cardAmt = 0;
  
  // 블루투스 장비 연결상태
  private boolean printConnected = false;
  // 보관용 이후 고객용 처리 0:최초 1:보관용 2:고객
  private int printComplete = 0;
  private int printType = 0;
  
  private PrinterAndKsPay printers = null;
  private Provider cPro = new Provider();
  
  @Override
  protected void onCreate(Bundle savedInstanceState) {
    super.onCreate(savedInstanceState);
    
    View mMainLayout = (View) getLayoutInflater().inflate(R.layout.activity_card_pay_as, null);
    addTopView(mMainLayout);
    setOnTopClickListner(this);
    setTopBarText("카드결제");
    
    init();
    
    dbSelector();
    
    arrangeView();
    bluetoosePt();
  }
  
  @Override
  protected void onResume() {
    arrangeView();
    super.onResume();
  }
  
  @Override
  protected void onDestroy() {
    try {
      unregisterReceiver(BlutoothReceiver);
      printers.disconnect();
    } catch (Exception e) {
      e.printStackTrace();
    }
    super.onDestroy();
  }
  
  @Override
  public void onBackPressed() {
    
    if (!isTransStatus()) {
      SignClearFile();
    }
    
    printCancel();
    
    super.onBackPressed();
  }
  
  /**
   * print bluetoothPrinter find *
   **/
  public void bluetoosePt() {
    // 블루투스 프린터 셋팅
    printers = new PrinterAndKsPay(this, signFilePath + saveFileName, BlutoothReceiver);
    printers.setHandler(BluetoothPrinterHandler, KsPaySendHandler);
    printers.setData(minD, cPro);
    printers.connect();
  }
  
  @Override
  public void init() {
    ADDRESS = (TextView) findViewById(R.id.ADDRESS); // 주소
    cacel_layout = (TableLayout) findViewById(R.id.cacel_layout);
    et_pay = (EditText) findViewById(R.id.et_pay);
    et_card = (EditText) findViewById(R.id.et_card);
    et_yy = (EditText) findViewById(R.id.et_yy);
    et_mm = (EditText) findViewById(R.id.et_mm);
    et_card_month = (EditText) findViewById(R.id.et_card_month);
    Watcher watcher = new Watcher(et_pay);
    et_pay.addTextChangedListener(watcher);
    
    btn_close = (ImageButton) findViewById(R.id.btn_close);
    btn_delete = (ImageButton) findViewById(R.id.btn_delete);
    b_commit = (ImageButton) findViewById(R.id.b_commit);
    
    tv_pay = (TextView) findViewById(R.id.tv_pay);
    tv_card = (TextView) findViewById(R.id.tv_card);
    tv_yy = (TextView) findViewById(R.id.tv_yy);
    tv_mm = (TextView) findViewById(R.id.tv_mm);
    tv_card_month = (TextView) findViewById(R.id.tv_card_month);
    
    btn_close.setOnClickListener(this);
    btn_delete.setOnClickListener(this);
    b_commit.setOnClickListener(this);
    
    // 서명 뷰
    signView = (SignView) findViewById(R.id.signview);
  }
  
  @Override
  public void dbSelector() {
    minD = (Min) getExtra();
    cardAmt = getIntent().getLongExtra("cardAmt", 0);
    
    DbManager_PROVIDER db = new DbManager_PROVIDER();
    cPro = db.getTotalList(db.getAllColumns());
  }
  
  @Override
  public void arrangeView() {
    if (minD == null) return;
    
    ADDRESS.setText(StringUtil.getAddress(minD));
    // * SignfileName - 임의로 정의한것 추후 수정
    signFilePath = Constant.SIGN_PATH + "/";
    saveFileName = "S_" + minD.REQUIRE_IDX + "_" + minD.HOUSE_NO + ".bmp";
    loadFileName = signFilePath + minD.SIGN_FILE_NM;
    
    et_pay.setText(StringUtil.formatWonEn(cardAmt + ""));
    
    MLog.d("isCardTrance :" + isTransStatus());
    // 결제 승인 상태 확인후
    if (isTransStatus()) {
      String[] yymm = StringUtil.getYYMM((minD.CARD_YM != null && !"".equals(minD.CARD_YM)) ? minD.CARD_YM : "");
      cacel_layout.setVisibility(View.VISIBLE);
      
      tv_pay.setText(StringUtil.formatWonEn(minD.CARD_AMT));
      tv_card.setText(StringUtil.cardNumEn(minD.CARD_NUM));
      if (yymm.length != 2) {
        yymm = new String[] { "0", "0" };
      }
      tv_yy.setText(yymm[0]);
      String number = String.format("%02d", StringUtil.getInteger(yymm[1]));
      tv_mm.setText(number);
      tv_card_month.setText(minD.CARD_MONTHS + " 개월");
      
      b_commit.setBackgroundResource(R.drawable.b_approve_img);
    } else {
      cacel_layout.setVisibility(View.GONE);
      b_commit.setBackgroundResource(R.drawable.b_payment_img);
    }
    signRefresh();
  }
  
  // 카드 리더기로 읽어온 결과값 적용
  private void resultRefreshView(String trackData) {
    et_card.setText(trackData.replace("=","").substring(0,16));
    et_yy.setText(StringUtil.getCardEnYY(trackData));
    et_mm.setText(StringUtil.getCardEnMM(trackData));
    
    cardTrackII = StringUtil.getCardTrackII(trackData);
  }
  
  private void signRefresh() {
    // * SignfileName - 임의로 정의한것 추후 수정
    if (signView.Load(loadFileName)) {// 파일이 있다면 읽어온다.
      signView.setLock(true);
      btn_delete.setVisibility(View.VISIBLE);
    } else {
      signView.setLock(false);
      btn_delete.setVisibility(View.GONE);
    }
  }
  
  /**
   * 카드 승인시 처리
   */
  public void cardSend() {
    if (isTransStatus()) {
      cardCancelAlert();
    } else {
      cardSendDataChecks();
    }
  }
  
  /***
   * 카드결시 승인시 true
   * 
   * @return
   */
  private boolean isTransStatus() {
    MLog.e("CARD_STATUS : " + minD.CARD_STATUS);
    MLog.e("CARD_CANCEL_TRANS_NUM : " + minD.CARD_CANCEL_TRANS_NUM);
    
    if ("A".equals(minD.CARD_STATUS)) {
      return true;
    } else {
      return false;
    }
  }
  
  /**
   * 서명 파일 저장
   * */
  public boolean SignSaveFile() {
    boolean rtn = false;
    
    // create folder
    Util.creatDir(Constant.SIGN_PATH);
    rtn = signView.Save(signFilePath + saveFileName);
    if (!rtn) {
      Toast.makeText(this, "서명파일 생성 오류", Toast.LENGTH_LONG).show();
    }
    return rtn;
  }
  
  /**
   * 서명 파일 삭제
   * */
  public void SignClearFile() {
    if (signView.Load(loadFileName)) {
      signView.setLock(false);
      signView.Clear();
    }
  }
  
  /**
   * 서명 뷰 삭제시 Alert
   * */
  public void SignDelAlert() {
    String msg = "";
    
    if (!signView.isEdited()) {
      Alert.alert(activity, "서명이 필요합니다.", null);
      return;
    }
    
    if (signView.Load(saveFileName)) msg = this.getString(R.string.card_sign_del_alert);
    else msg = this.getString(R.string.card_sign_del_alert);
    
    Alert.confirm(activity, msg, "SignClearFile", null);
  }
  
  /**
   * 카드 승인 요청
   */
  public void sendTrance() {
    startProgressBar();
    printers.cardSend(cardSendDataKey());
  }
  
  /**
   * 카드 취소 요청
   */
  public void cancelTrance() {
    startProgressBar();
    printers.cardCancel(cardCancelDataKey());
  }
  
  /**
   * 결제 승인
   * */
  private void cardSendAlert() {
    String msg = this.getString(R.string.card_send_alert);
    
    if (!signView.isEdited()) return;
    
    Alert.confirm(activity, msg, "sendTrance", null);
  }
  
  /**
   * 결제 취소
   * */
  private void cardCancelAlert() {
    String msg = this.getString(R.string.card_cancel_alert);
    
    if (!signView.isEdited()) return;
    
    Alert.confirm(activity, msg, "cancelTrance", null);
  }
  
  public void printStart() {
    printers.printStart(printType);
  }
  
  public void printCancel() {
    onFinish(minD, RESULT_OK);
  }
  
  /**
   * 결제후 승인후 dbupdate 후 처리 프린트 출력 안내 팝업
   * */
  private void printAlert(int printType) {
    String msg = "";
    this.printType = printType;
    
    if (printType == Constant.KS_PRINT_PAY_C) SignSaveFile();
    
    if (printConnected) { // 프린트 연결 상태 확인 후~
      // 고객용 출력
      if (printComplete == 2) {
        // printCancel();
      } else {
        // 최초 보관용 출력
        if (printComplete == 0) {
          printComplete = 1;
          printStart(); // 최초 보관용 처리
          return;
        } else if (printComplete == 1) {
          printComplete = 2;
          msg = getString(R.string.card_pay_customer_alert);
          if (printType == Constant.KS_PRINT_PAY_C) this.printType = Constant.KS_PRINT_PAY_S;
          
          if (printType == Constant.KS_PRINT_CAN_C) this.printType = Constant.KS_PRINT_CAN_S;
          
          if (isTransStatus()) {
            Toast.makeText(context, "결제 승인 완료", Toast.LENGTH_LONG).show();
          } else {
            Toast.makeText(context, "결제 취소 완료", Toast.LENGTH_LONG).show();
          }
          Alert.confirm(activity, msg, "printStart", "printCancel");
        }
      }
    } else {
      if (isTransStatus()) {
        Toast.makeText(context, "결제 승인 완료", Toast.LENGTH_LONG).show();
        
        Toast.makeText(context, "프린트 연결이 원할하지 않습니다.", Toast.LENGTH_LONG).show();
      } else {
        Toast.makeText(context, "결제 취소 완료", Toast.LENGTH_LONG).show();
        
        Toast.makeText(context, "프린트 연결이 원할하지 않습니다.", Toast.LENGTH_LONG).show();
        SignClearFile();
      }
    }
    printComplete = 0;
    arrangeView();
    stopProgressBar();
  }
  
  /**
   * Bluetooth 메세지 처리
   * */
  private void BluetoothDispatchMessage(Message msg) {
    switch (msg.arg1) {
      case BixolonPrinter.PROCESS_MSR_TRACK:
        Intent intent = new Intent();
        intent.setAction(printers.ACTION_GET_MSR_TRACK_DATA);
        intent.putExtra(printers.EXTRA_NAME_MSR_TRACK_DATA, msg.getData());
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
    
    printers.getPrinter().connect(items[0]);
  }
  
  private String[] cardSendDataKey() {
    String[] str = new String[14];
    str[0] = cPro.VAN_CARD_NO;// *상점아이디(개발:2999199999, 운영:?)
    // str[0] = "2999199999";// *상점아이디(개발:2999199999, 운영:?)
    // str[1] = "kspay1234";// *주문번호(가맹점요청KEY) ??
    str[1] = "MIN_" + minD.REQUIRE_IDX;// *주문번호(가맹점요청KEY) MIN_REQUIRE_IDX;
    str[2] = SharedApplication.user.USER_NM;// 주문자명
    str[3] = "";// 주민번호(공백 또는 다른 용도로 사용)
    str[4] = "";// 주문자EMAIL(결제내역메일발송용)
    str[5] = "";// 상품명
    str[6] = "";// 전화번호
    str[7] = "K";// KEY-IN유형(K:직접입력,S:리더기사용입력)
    str[8] = Constant.KS_INTEREST_TYPE;// *일반/무이자구분 1:일반 2:무이자
    str[9] = cardTrackII;// *TrackII(KEY-IN방식의 경우 카드번호=유효기간[YYMM])
    str[10] = StringUtil.getCardMonthN(StringUtil.getString(et_card_month));// *할부개월수(00:일시불, 03:3개월할부, ...)
    str[11] = StringUtil.getString(et_pay).replace(",", "");// *결제금액
    str[12] = ""; // 비밀번호앞2자리
    str[13] = ""; // 주민번호뒤7자리 또는 사업자번호10자리
    return str;
  }
  
  private String[] cardCancelDataKey() {
    // 결제시 필요한 항목
    String[] str = new String[3];
    str[0] = cPro.VAN_CARD_NO;// *상점아이디(개발:2999199999, 운영:?)
    str[0] = "2999199999";// *상점아이디(개발:2999199999, 운영:?)
    str[1] = "K";// KEY-IN유형(K:직접입력,S:리더기사용입력)
    str[2] = minD.CARD_TRANS_NUM;// **거래번호(승인응답시의 KEY:1로시작되는 12자리숫자)
    
    return str;
  }
  
  /**
   * 결제후 승인후 처리 db 업데이트 프린트 출력 보관용
   * 
   * @param min
   */
  private void cardSendPayDb(Min min) {
    String cardAmt = StringUtil.getFormatWonDe(StringUtil.getString(et_pay));// 카드 결재금액
    MLog.e("cardTrackII :" + cardTrackII);
    
    minD.CARD_COMPANY = min.CARD_COMPANY;
    minD.CARD_NUM = StringUtil.getCardNumDe(StringUtil.getString(et_card));
    minD.CARD_YM = StringUtil.cardPrintYYMM(cardTrackII);
    minD.CARD_AMT = cardAmt;
    minD.CARD_MONTHS = min.CARD_MONTHS.replace("/", ""); // StringUtil.getCardMonthS(min.CARD_MONTHS);
    minD.CARD_TRANS_NUM = min.CARD_TRANS_NUM;
    minD.CARD_TRANS_DATE = min.CARD_TRANS_DATE;
    minD.CARD_STATUS = min.CARD_STATUS;
    minD.CARD_CANCEL_TRANS_NUM = "";
    minD.CARD_CANCEL_TRANS_DATE = "";
    minD.SIGN_FILE_NM = saveFileName;
    
    DbManager_MIN db = new DbManager_MIN();
    boolean result = db.updateColumn(db.TYPE_CARD, minD);
    // db.close();
    if (result) {
      printAlert(Constant.KS_PRINT_PAY_C);
    } else {
      minD.CARD_NUM = "";
      minD.CARD_YM = "";// min.CARD_YM;
      minD.CARD_AMT = "";
      Alert.alert(activity, "처리중 오류가 발생 하였습니다.", null);
      arrangeView();
      stopProgressBar();
    }
  }
  
  /**
   * 결제취소 승인후 db 업데이트
   * */
  private void cardCancelPayDb(Min min) {
    minD.CARD_AMT = "";
    minD.CARD_STATUS = min.CARD_STATUS;
    minD.CARD_CANCEL_TRANS_NUM = min.CARD_TRANS_NUM;
    minD.CARD_CANCEL_TRANS_DATE = min.CARD_TRANS_DATE;
    minD.SIGN_FILE_NM = "";
    
    DbManager_MIN db = new DbManager_MIN();
    boolean result = db.updateColumn(db.TYPE_CARD, minD);
    // db.close();
    // MLog.e("Min count :" + db.getTotalList(db.getAllColumns()).size());
    if (result) {
      printAlert(Constant.KS_PRINT_CAN_C);
    } else {
      Alert.alert(activity, "처리중 오류가 발생 하였습니다.", null);
      SignClearFile();
      arrangeView();
      stopProgressBar();
    }
  }
  
  /***
   * 결제 시작 전 체크 >
   * 
   * @1. 각 체크 사항 카드입력 사항(결제금액, 카드번호, 유효기간 YY,MM)
   * @2. ksPay 결제 소켓 통신 시작 KsPaySendHandler를 통해 결과 데이터 처리.
   * @3. 결제 승인완료시 데이터 업데이트(cardPayUpdateDb), 사인 저장(SignSave), 영수증 출력(printStart(type))
   * @4. 보관용 영수증 출력후 고객용 출력 처리후 전화면으로 이동
   */
  private void cardSendDataChecks() {
    String cardPay = StringUtil.getString(et_pay);
    String cardNum = StringUtil.getString(et_card);
    String cardYn = StringUtil.getString(et_yy);
    String cardMM = StringUtil.getString(et_mm);
    
    if (!signView.isbEdited()) Alert.alert(activity, "서명이 필요합니다.", null);
    
    if (cardPay.length() == 0) {
      Alert.alert(activity, "결제 금액을 확인 하세요.", null);
      et_pay.setFocusable(true);
    } else if (cardNum.length() < 16) {
      if (cardNum.length() == 0) {
        Alert.alert(activity, "카드번호를 입력 하세요.", null);
      } else {
        Alert.alert(activity, "카드번호가 올바르지 않습니다.", null);
      }
      et_card.setFocusable(true);
    } else if (cardYn.length() < 2) {
      Alert.alert(activity, "유효기간 년을 입력 하세요.", null);
      et_yy.setFocusable(true);
    } else if (cardMM.length() < 1) {
      Alert.alert(activity, "유효기간 월을 입력 하세요.", null);
      et_yy.setFocusable(true);
    } else {
      MLog.d("cardNum:" + cardNum + "" + "cardYn: " + cardYn + ", cardMM" + cardMM);
      if ("".equals(cardTrackII)) cardTrackII = cardNum + "=" + (cardYn + "" + cardMM);
      MLog.d("cardTrackII:" + cardTrackII);
      cardSendAlert();
    }
  }
  
  /**
   * Bluetooth 카드리더기 리시버
   * */
  BroadcastReceiver BlutoothReceiver = new BroadcastReceiver() {
    
    @Override
    public void onReceive(Context context, Intent intent) {
      if (intent.getAction().equals(printers.ACTION_GET_MSR_TRACK_DATA)) {
        Bundle bundle = intent.getBundleExtra(printers.EXTRA_NAME_MSR_TRACK_DATA);
        
        MLog.d("mUsbReceiver.bundle(" + bundle + ")");
        cardTrackData = bundle.getByteArray(BixolonPrinter.KEY_STRING_MSR_TRACK2);
        if (cardTrackData != null) {
          new Handler().postDelayed(new Runnable() {
            
            @Override
            public void run() {
              String trackData = new String(cardTrackData);
              MLog.e("trackData : " + trackData);
              resultRefreshView(trackData);
            }
          }, 100);
        }
      }
    }
  };
  
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
          // Toast.makeText(context, mConnectedDeviceName, Toast.LENGTH_LONG).show();
          Toast.makeText(context, R.string.msg_connected_print, Toast.LENGTH_LONG).show();
          return true;
          
        case BixolonPrinter.MESSAGE_TOAST: // unable divace 처리
          // Toast.makeText(context, msg.getData().getString(BixolonPrinter.KEY_STRING_TOAST), Toast.LENGTH_LONG).show();
          Toast.makeText(context, R.string.msg_no_paired_print, Toast.LENGTH_LONG).show();
          return true;
          
        case BixolonPrinter.MESSAGE_BLUETOOTH_DEVICE_SET:
          if (msg.obj == null) {
            Toast.makeText(context, R.string.msg_no_paired_print, Toast.LENGTH_LONG).show();
          } else {
            BluetoothConnect((Set<BluetoothDevice>) msg.obj);
            // DialogManager.showBluetoothDialog(context, (Set<BluetoothDevice>) msg.obj);
          }
          return true;
          
        case BixolonPrinter.MESSAGE_PRINT_COMPLETE:
          Toast.makeText(context, R.string.msg_complete_to_print, Toast.LENGTH_LONG).show();
          MLog.d("type : " + printComplete);
          if (printComplete == 1) printAlert(printType);
          return true;
          
        case BixolonPrinter.MESSAGE_ERROR_NV_MEMORY_CAPACITY:
          Toast.makeText(context, R.string.msg_memory_capacity_error_print, Toast.LENGTH_LONG).show();
          return true;
          
        case BixolonPrinter.MESSAGE_ERROR_OUT_OF_MEMORY:
          // Toast.makeText(context, "Out of memory", Toast.LENGTH_LONG).show();
          return true;
          
        case BixolonPrinter.MESSAGE_NETWORK_DEVICE_SET:
          if (msg.obj == null) {
            Toast.makeText(context, R.string.msg_no_connectable_print, Toast.LENGTH_LONG).show();
          }
          return true;
      }
      return false;
    }
  });
  
  /**
   * 결제 요청 메세지 msg.what = 1 승인 완료 CARD_TRANS_NUM : 승인 코드 or 오류 코드
   * 
   * */
  @SuppressLint("HandlerLeak")
  private final Handler KsPaySendHandler = new Handler() {
    public void handleMessage(Message msg) {
      Min min = (Min) msg.obj;
      MLog.e("CARD_TRANS_NUM :" + min.CARD_TRANS_NUM);
      MLog.e("CARD_TRANS_DATE :" + min.CARD_TRANS_DATE);
      MLog.e("CARD_STATUS :" + min.CARD_STATUS);
      if (msg.what == 1) {
        MLog.e("isCardTrans : " + isTransStatus() + "카드 승인 AuthNo :" + min.CARD_TRANS_NUM + " message : " + KsPayCode.getKsPayErrorCode(min.CARD_TRANS_NUM) + " status :" + minD.CARD_STATUS);
        
        if ("A".equals(min.CARD_STATUS)) {
          cardSendPayDb(min);
        } else {
          SignClearFile();
          cardCancelPayDb(min);
        }
      } else {
        MLog.e("카드 거절 AuthNo :" + min.CARD_TRANS_NUM + " message : " + KsPayCode.getKsPayErrorCode(min.CARD_TRANS_NUM));
        Alert.alert(activity, KsPayCode.getKsPayErrorCode(min.CARD_TRANS_NUM), null);
      }
    };
  };
  
  @Override
  public void onClick(View v) {
    switch (v.getId()) {
      case R.id.btn_close:
        printCancel();
        break;
      case R.id.btn_delete:
        if (("A".equals(minD.CARD_STATUS))) {
          Alert.alert(activity, "삭제 하실수 없습니다.", null);
        } else {
          SignDelAlert();
        }
        break;
      case R.id.b_commit:
        if (printConnected) { // 프린트 상태 체크
          cardSend();
        } else {
          Alert.confirm(activity, "장비 연결이 끊어진 상태입니다.\n 연결 하시겠습니까?", "bluetoosePt", "cardSend");
        }
        
        // }
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
}
