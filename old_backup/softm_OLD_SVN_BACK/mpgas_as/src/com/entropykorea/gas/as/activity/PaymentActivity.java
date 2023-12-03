package com.entropykorea.gas.as.activity;

import java.util.ArrayList;

import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.TextView;

import com.entropykorea.gas.as.R;
import com.entropykorea.gas.as.bean.Min;
import com.entropykorea.gas.as.bean.MinCurPrice;
import com.entropykorea.gas.as.bean.MinLegalFee;
import com.entropykorea.gas.as.bean.MinUnpaidPrice;
import com.entropykorea.gas.as.common.base.BasedActivity;
import com.entropykorea.gas.as.common.base.BasedActivity.OnMethod;
import com.entropykorea.gas.as.common.base.TopBar.OnTopClickListner;
import com.entropykorea.gas.as.common.object.MLog;
import com.entropykorea.gas.as.common.util.DateString;
import com.entropykorea.gas.as.common.util.PayUtil;
import com.entropykorea.gas.as.common.util.StringUtil;
import com.entropykorea.gas.as.constants.Constant;
import com.entropykorea.gas.as.database.DbManager_MIN;
import com.entropykorea.gas.as.database.DbManager_MIN_CUR_PRICE;
import com.entropykorea.gas.as.database.DbManager_MIN_LEGAL_FEE;
import com.entropykorea.gas.as.database.DbManager_MIN_UNPAID_PRICE;
import com.entropykorea.gas.as.ewire.CallTrans;
import com.entropykorea.gas.as.ewire.CallTrans.onFinished;

public class PaymentActivity extends BasedActivity implements OnMethod, OnTopClickListner, OnClickListener {
  
  private TextView ADDRESS = null;
  private TextView BF_METER = null; // 수 용 가 번호
  private EditText METER = null; // 지침
  private TextView USE_AMOUNT = null; // 사 용 량
  private TextView BASE_PRICE = null; // 기본요금
  private TextView USE_PRICE = null; // 당월요금
  private TextView CHE_PRICE = null; // 미납금액
  private TextView LEGAL_PRICE = null; // 법적비용
  private TextView TOTAL_PRICE = null; // 총 액
  private TextView unpaid_list = null; // 계좌및 미납금액
  // 추
  private TextView PENALTY_PRICE = null; // 위약금
  private TextView UNSEAL_PRICE = null; // 봉인해제비용
  
  private ImageButton b_cal = null;
  private ImageButton b_commit = null; // 확인버튼
  
  private int totalPrice, basePrice, usePrice, udpaidpricePrice, legalPrice = 0;
  
  private ArrayList<MinCurPrice> mcpArray = null;
  private ArrayList<MinUnpaidPrice> unpaidArray = null;
  private ArrayList<MinLegalFee> legalArray = null;
  
  @Override
  protected void onCreate(Bundle savedInstanceState) {
    super.onCreate(savedInstanceState);
    
    View mMainLayout = (View) getLayoutInflater().inflate(R.layout.activity_payment_as, null);
    addTopView(mMainLayout);
    setTopBarText("요금계산");
    
    init();
    
    arrangeView();
  }
  
  @Override
  public void onBackPressed() {
    commit();
    super.onBackPressed();
  }
  
  @Override
  public void init() {
    // -----------------------
    ADDRESS = (TextView) findViewById(R.id.ADDRESS); // 주소
    BF_METER = (TextView) findViewById(R.id.BF_METER); // 수 용 가 번호
    METER = (EditText) findViewById(R.id.METER); // 전입지침
    USE_AMOUNT = (TextView) findViewById(R.id.USE_AMOUNT); // 사용량
    BASE_PRICE = (TextView) findViewById(R.id.BASE_PRICE); // 기본요금
    USE_PRICE = (TextView) findViewById(R.id.USE_PRICE); // 당월요금
    CHE_PRICE = (TextView) findViewById(R.id.CHE_PRICE); // 미납금액
    LEGAL_PRICE = (TextView) findViewById(R.id.LEGAL_PRICE); // 법적비용
    TOTAL_PRICE = (TextView) findViewById(R.id.TOTAL_PRICE); // 총 액
    unpaid_list = (TextView) findViewById(R.id.unpaid_list); // 계좌및 미납금액
    PENALTY_PRICE = (TextView) findViewById(R.id.PENALTY_PRICE); // 위약금
    UNSEAL_PRICE = (TextView) findViewById(R.id.UNSEAL_PRICE); // 봉인해제비용
    
    b_cal = (ImageButton) findViewById(R.id.b_cal); // 요금계산
    b_commit = (ImageButton) findViewById(R.id.b_commit); // 확인버튼
    
    b_cal.setOnClickListener(this);
    b_commit.setOnClickListener(this);
  }
  
  @Override
  public void dbSelector() {
    minD = (Min) getExtra();
    if (minD == null) {
      DbManager_MIN db = new DbManager_MIN();
      ArrayList<Min> data = db.getTotalList(db.getReqIdColumn(minD.REQUIRE_IDX + ""));
      minD = data.get(0);
    }
    
    DbManager_MIN_LEGAL_FEE db1 = new DbManager_MIN_LEGAL_FEE();
    legalArray = db1.getTotalList(db1.getColumn(minD.REQUIRE_IDX));
    
    DbManager_MIN_UNPAID_PRICE db2 = new DbManager_MIN_UNPAID_PRICE();
    unpaidArray = db2.getTotalList(db2.getColumn(minD.REQUIRE_IDX));
    
    priceSett();
  }
  
  @Override
  public void arrangeView() {
    dbSelector();
    
    ADDRESS.setText(StringUtil.getAddress(minD));
    BF_METER.setText(minD.BF_METER);
    METER.setText(minD.METER);
    USE_AMOUNT.setText(minD.USE_AMOUNT);
    BASE_PRICE.setText(StringUtil.formatWonEn(minD.BASE_PRICE + ""));
    USE_PRICE.setText(StringUtil.formatWonEn(minD.USE_PRICE + ""));
    CHE_PRICE.setText(StringUtil.formatWonEn(udpaidpricePrice + ""));
    LEGAL_PRICE.setText(StringUtil.formatWonEn(legalPrice + ""));
    TOTAL_PRICE.setText(StringUtil.formatWonEn(totalPrice + ""));
    unpaid_list.setText(getUnpaidText());// 미납 금액 출력
    //추가 
    PENALTY_PRICE.setText(StringUtil.formatWonEn(minD.PENALTY_PRICE + ""));//위약금 
    UNSEAL_PRICE.setText(StringUtil.formatWonEn(minD.UNSEAL_PRICE + ""));//해제수수료 
  }
  
  private void priceSett() {
    usePrice = StringUtil.getInteger(minD.USE_PRICE);
    basePrice = StringUtil.getInteger(minD.BASE_PRICE);
    
    udpaidpricePrice = PayUtil.getUnpaidpricePriceSum(unpaidArray);
    legalPrice = PayUtil.getLegalPriceSum(legalArray);
    
    totalPrice = PayUtil.getTotalPriceSum(usePrice, basePrice, udpaidpricePrice, legalPrice);
  }
  
  public void savePayDb() {
    
    Handler h = new Handler() {
      @Override
      public void handleMessage(Message msg) {
        super.handleMessage(msg);
        MLog.e("savePayDb result: " + msg.hashCode() + ",what:" + msg.what);
        if (msg.what == Constant.RESULT_SUCCESS) {
          alert(getString(R.string.msg_success));
          arrangeView();
        } else {
          alert(getString(R.string.msg_fail));
        }
      }
    };
    DbManager_MIN_CUR_PRICE db = new DbManager_MIN_CUR_PRICE();
    mcpArray = db.getTotalList(db.getColumn(minD.REQUIRE_IDX));
    
    minD.LAST_CALC_TIME = DateString.makeDateTimeString(DateString.getToday()).replace("/", "-"); // 송신한 시간 업데이
    minD.METER = StringUtil.getString(METER); // 현재지침
    
    minD.BF_METER = mcpArray.get(0).BF_METER; // 전월지침
    minD.USE_AMOUNT = mcpArray.get(0).USE_AMOUNT;// 전출-사용량
    minD.USE_PRICE = mcpArray.get(0).USE_PRICE;// 전출-사용요금
    minD.BASE_PRICE = mcpArray.get(0).BASE_PRICE;// 전출-기본요금
    
    PENALTY_PRICE.setText(StringUtil.formatWonEn(minD.PENALTY_PRICE + ""));
    UNSEAL_PRICE.setText(StringUtil.formatWonEn(minD.UNSEAL_PRICE + ""));
    
    DbManager_MIN db1 = new DbManager_MIN();
    db1.DbHandler(h);
    db1.updateColumn(db1.TYPE_CUR, minD);
  }
  
  private void runCheFeeDown() {
    // public CallTrans(Context ctx, String userId, String custNo, String housId, String meter, String deviceNumber) {
    CallTrans callTrans = new CallTrans(context, minD.CUST_NO, minD.REQUIRE_IDX + "", minD.HOUSE_NO, StringUtil.getString(METER) + "");
    
    callTrans.callTrans(CallTrans.MIN_PRICE_DOWN);
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
          savePayDb();
        } else {
          
        }
      }
    });
  }
  
  /**
   * 비용 조합 text
   * 
   * @return
   */
  private String getUnpaidText() {
    String unpaidStr = "";
    if (legalArray == null) return "";
    unpaidStr = "가상계좌\n";
    unpaidStr += "기업은행 : " + minD.VIR_ACC_NO_IBK + "\n";
    unpaidStr += "농협 : " + minD.VIR_ACC_NO_NH + "\n\n";
    unpaidStr += PayUtil.getUnpaidList(unpaidArray);
    unpaidStr += PayUtil.getLegalList(legalArray);
    return unpaidStr;
  }
  
  /**
   * db 업데이트
   * 
   * @param min
   */
  private void commit() {
    minD.PAID_GAS_PRICE = totalPrice + "";
    minD.METER = StringUtil.getString(METER);
    
    onFinish(minD, RESULT_OK);
    
    // DbManager_MIN db = new DbManager_MIN();
    // boolean result = db.updateColumn(minD.REQUIRE_IDX, minD);
    // // db.close();
    // MLog.e("Min count :" + db.getTotalList(db.getAllColumns()).size());
    // if (result) {
    // onFinish(minD, RESULT_OK);
    // } else {
    // alert("저장중 오류가 발생 하였습니다.");
    // }
  }
  
  @Override
  public void onClick(View v) {
    switch (v.getId()) {
      case R.id.b_cal:
        if ("".equals(StringUtil.getString(METER))) {
          alert("지침을 입력 하세요.");
        } else {
          runCheFeeDown();
        }
        // callTrans();
        break;
      case R.id.b_commit:
        commit();
        break;
    }
  }
  
  @Override
  public void onClickBackButton(View v) {
    // TODO Auto-generated method stub
    
  }
  
  @Override
  public void onClickOneButton(View v) {
    // TODO Auto-generated method stub
    
  }
  
  @Override
  public void onClickTwoButton(View v) {
    // TODO Auto-generated method stub
    
  }
  
}
