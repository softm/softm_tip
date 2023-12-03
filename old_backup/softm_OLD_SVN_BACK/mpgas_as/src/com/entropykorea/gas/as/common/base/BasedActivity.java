package com.entropykorea.gas.as.common.base;

import java.io.Serializable;
import java.util.ArrayList;

import android.annotation.SuppressLint;
import android.app.ActionBar.LayoutParams;
import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.text.TextUtils;
import android.view.View;
import android.widget.FrameLayout;
import android.widget.PopupMenu;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.Toast;

import com.dm.zbar.android.scanner.ZBarConstants;
import com.entropykorea.gas.as.R;
import com.entropykorea.gas.as.SharedApplication;
import com.entropykorea.gas.as.activity.DetailInActivity;
import com.entropykorea.gas.as.activity.DetailOtherActivity;
import com.entropykorea.gas.as.activity.DetailOutActivity;
import com.entropykorea.gas.as.bean.Code;
import com.entropykorea.gas.as.bean.Min;
import com.entropykorea.gas.as.common.base.TopBar.OnTopClickListner;
import com.entropykorea.gas.as.constants.Constant;
import com.entropykorea.gas.as.database.DbManager_CODE;
import com.entropykorea.gas.as.database.DbManager_MIN;
import com.entropykorea.gas.lib.BaseActivity;
import com.mypidion.BI300.BI300Bluetooth;

public class BasedActivity extends BaseActivity {
  protected Activity activity = this;
  protected Context context = this;
  
  protected TopBar mTopBar = null;
  protected FrameLayout mLayBody = null;
  protected ArrayList<Min> minArray = new ArrayList<Min>();
  protected Min minD = null;
  protected SharedApplication mApp;
  protected int REQUIRE_IDX = 0;
  protected String photoSeq = "";
  
  private BI300Bluetooth bi300 = null;
  
  @Override
  protected void onCreate(Bundle savedInstanceState) {
    // TODO Auto-generated method stub
    super.onCreate(savedInstanceState);
    setContentView(R.layout.activity_base_as);
    
    mLayBody = (FrameLayout) findViewById(R.id.layBaseBody);
    mTopBar = (TopBar) findViewById(R.id.baseTopBar);
    
    mApp = (SharedApplication) getApplicationContext();
  }
  
  public interface OnMethod {
    
    public void init();
    
    public void dbSelector();
    
    public void arrangeView();
  }
  
  protected void addTopView(View view) {
    mLayBody.addView(view, new LayoutParams(LayoutParams.MATCH_PARENT, LayoutParams.MATCH_PARENT));
  }
  
  protected void setTopBarBackground(int resId1, int resId2, int resId3) {
    mTopBar.setTopBarBackground(resId1, resId2, resId3);
  }
  
  protected void setTopBarText(String str) {
    mTopBar.setTopBarText(str);
  }
  
  protected void setTwoBtnVisible(int visibility) {
    mTopBar.setTwoBtnVisible(visibility);
  }
  
  protected void setTwoBtnImage(int resId) {
    mTopBar.setTwoBtnImage(resId);
  }
  
  protected void setOnTopClickListner(OnTopClickListner l) {
    mTopBar.setOnTopBarButtonCollection(l);
  }
  
  protected String getCheckedYN(boolean b) {
    return b ? "Y" : "N";
  }
  
  protected Serializable getExtra() {
    
    return getIntent().getSerializableExtra("value");
  }
  
  protected void onStartActivity(Class<?> cls) {
    Intent intent = new Intent(context, cls);
    startActivity(intent);
  }
  
  protected void onStartActivity(Class<?> cls, Serializable value) {
    Intent i = new Intent(context, cls);
    i.putExtra("value", value);
    startActivity(i);
  }
  
  protected void onResultActivity(Class<?> cls, Serializable value, long cardAmt) {
    Intent i = new Intent(context, cls);
    i.putExtra("value", value);
    i.putExtra("cardAmt", cardAmt);
    startActivityForResult(i, Constant.RESULT_REQUEST_DETAIL);
  }
  
  protected void onResultActivity(Class<?> cls, Serializable value) {
    Intent i = new Intent(context, cls);
    i.putExtra("value", value);
    startActivityForResult(i, Constant.RESULT_REQUEST_DETAIL);
  }
  
  protected void onFinish(Serializable value, int resultCode) {
    Intent i = new Intent();
    i.putExtra("value", value);
    setResult(resultCode, i);
    finish();
  }
  
  /**
   * 보이게 안보이게
   * 
   * @param v
   */
  protected void setVisibility(int id, int visibility) {
    View v = (View) findViewById(id);
    v.setVisibility(visibility);
  }
  
  protected void startIntent(Min min) {
    Intent i = null;
    
    // 전입 47
    // 렌지연결(49), 렌지교체(48), 호스교체(50), 중간밸브A/S(교체)(52), 보일러교체(57), 가스기기 철거(45), 안전점검 봉인해제(53),미사용봉인(44)
    if ("47".equals(min.REQUIRE_CD)||"49".equals(min.REQUIRE_CD) || "48".equals(min.REQUIRE_CD) || "50".equals(min.REQUIRE_CD) || "52".equals(min.REQUIRE_CD) || "57".equals(min.REQUIRE_CD) || "45".equals(min.REQUIRE_CD) || "53".equals(min.REQUIRE_CD)|| "44".equals(min.REQUIRE_CD)) {
      i = new Intent(getBaseContext(), DetailInActivity.class);
    }
    // 전출 33, 체납봉인해제 41
    else if ("33".equals(min.REQUIRE_CD) || "41".equals(min.REQUIRE_CD)) {
      i = new Intent(getBaseContext(), DetailOutActivity.class);
    }
    
    // 기타
    else {
      i = new Intent(getBaseContext(), DetailOtherActivity.class);
    }
    i.putExtra("REQUIRE_IDX", min.REQUIRE_IDX);
    startActivity(i);
  }
  
  // protected boolean getViewType(String requireCd, String nm) {
  // String rStr = SharedApplication.code.getNameByCode("RQ010", requireCd);
  // MLog.d("상태 : " + rStr);
  // return StringUtil.getContains(rStr, nm);
  // }
  
  protected Min getMinData(String gm_no) {
    
    ArrayList<Min> data = null;
    Min m = new Min();
    Handler h = new Handler();
    DbManager_MIN db = new DbManager_MIN();
    data = db.getTotalList(db.geGmNoColumn(gm_no));
    if (data != null && data.size() > 1) {
      return data.get(0);
    }
    return m;
  }
  
  // protected Code getCode(String type, String nm) {
  // Code code = new Code();
  //
  // DbManager_CODE db = new DbManager_CODE();
  // try {
  // ArrayList<Code> c = db.getTotalList(db.getCode(type, nm));
  // if (c != null) code = c.get(0);
  // } catch (Exception e) {
  // }
  // return code;
  // }
  
  // scnner
  protected boolean goProcessActivity(String gm_no) {
    Min m = getMinData(gm_no);
    if (m != null) {
      startIntent(m);
    } else {
      alert(R.string.msg_invalid_house); // 인식된 세대가 없습니다.\n확인 바랍니다.
    }
    return false;
  }
  
  // showmenu
  @SuppressLint("NewApi")
  public void showMenu(View anchor, int menuRes) {
    // Context wrapper = new ContextThemeWrapper(getBaseContext(), R.style.PopupMenu);
    PopupMenu popup = new PopupMenu(this, anchor);
    popup.setOnMenuItemClickListener((OnMenuItemClickListener) this);
    popup.inflate(menuRes);
    popup.show();
  }
  
  // Bi300 스캐너
  public void stopBi300() {
    if (bi300 != null) {
      new Runnable() {
        @Override
        public void run() {
          bi300.stopBI300();
          bi300 = null;
        }
      }.run();
    }
  }
  
  public void lanchScan(View v) {
    if (SharedApplication.user.BARCD_EQUIP_USE_YN.equals("Y")) {
      try {
        // 바코드 블루투스 리더기 연동
        if (bi300 == null) {
          bi300 = new BI300Bluetooth(this, new Handler() {
            @Override
            public void handleMessage(android.os.Message msg) {
              String message = (String) msg.obj;
              switch (msg.what) {
                case 1:
                  bi300.setDialogText("세대를 검색중입니다.");
                  goProcessActivity(message.trim());
                  stopBi300();
                  break;
              }
            };
          });
        } else {
          
        }
        
        new Runnable() {
          @Override
          public void run() {
            bi300.startBI300();
          }
        }.run();
        
        // alert("바코드 스캐너를 ")
      } catch (Exception e) {
        // toast("바코드스캐너 블루투스 연결하세요.");
      }
    } else {
      launchScanner(v);
    }
  }
  
  @Override
  protected void onActivityResult(int requestCode, int resultCode, Intent data) {
    switch (requestCode) {
      case Constant.ZBAR_SCANNER_REQUEST:
        
        if (resultCode == RESULT_OK) {
          String number = data.getStringExtra(ZBarConstants.SCAN_RESULT);
          if (number.length() > 0) {
            goProcessActivity(number);
          }
          // toast( number );
        } else if (resultCode == RESULT_CANCELED && data != null) {
          String error = data.getStringExtra(ZBarConstants.ERROR_INFO);
          if (!TextUtils.isEmpty(error)) {
            Toast.makeText(this, error, Toast.LENGTH_SHORT).show();
          }
        }
        break;
      case Constant.ZBAR_QR_SCANNER_REQUEST:
        break;
    }
  }
}