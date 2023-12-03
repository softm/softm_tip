package com.entropykorea.gas.as.activity;

import java.io.File;
import java.util.ArrayList;
import java.util.HashMap;

import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.text.TextUtils;
import android.view.KeyEvent;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.TextView;
import android.widget.Toast;

import com.dm.zbar.android.scanner.ZBarConstants;
import com.entropykorea.ewire.eWireUpdate;
import com.entropykorea.ewire.database.SqliteManager;
import com.entropykorea.gas.as.AppContext;
import com.entropykorea.gas.as.R;
import com.entropykorea.gas.as.SharedApplication;
import com.entropykorea.gas.as.bean.Min;
import com.entropykorea.gas.as.common.base.BasedActivity;
import com.entropykorea.gas.as.common.base.TopBar.OnTopClickListner;
import com.entropykorea.gas.as.common.object.MLog;
import com.entropykorea.gas.as.common.util.StringUtil;
import com.entropykorea.gas.as.common.util.Util;
import com.entropykorea.gas.as.constants.Constant;
import com.entropykorea.gas.as.database.DbManager_MIN;
import com.entropykorea.gas.as.ewire.CallTrans;
import com.entropykorea.gas.as.ewire.CallTrans.onFinished;

public class MainActivity extends BasedActivity implements OnTopClickListner, OnClickListener, OnMenuItemClickListener {
  
  private TextView tvInfo, tvTotalCount, tvEndCount, tvNotEndCount, tvNotSendCount;
  private int notsendcount = 0;
  
  @Override
  protected void onCreate(Bundle savedInstanceState) {
    super.onCreate(savedInstanceState);
    
    View mMainLayout = (View) getLayoutInflater().inflate(R.layout.activity_main_as, null);
    addTopView(mMainLayout);
    setTopBarText("요금메인");
    setTwoBtnVisible(View.VISIBLE);
    setTwoBtnImage(R.drawable.barcode_img);
    setOnTopClickListner(this);
    
    String userId = getIntent().getStringExtra("USER_ID");
    String userNm = getIntent().getStringExtra("USER_NM");
    String equipCd = getIntent().getStringExtra("EQUIP_CD");
    String barCdEqipUseYn = getIntent().getStringExtra("BARCD_EQUIP_USE_YN");
    String eWireServerIp = getIntent().getStringExtra("EWIRE_SERVER_IP");
    String eWireServerPort = getIntent().getStringExtra("EWIRE_SERVER_PORT");
    String updateServerUrl = getIntent().getStringExtra("UPDATE_SERVER_URL");
    
    // if (!Constant.DEBUG) {
    if (true) {
      if (userId == null || equipCd == null || barCdEqipUseYn == null || eWireServerIp == null || eWireServerPort == null || updateServerUrl == null) {
        
        Toast.makeText(context, "사용할 수 없는 액세스 입니다", Toast.LENGTH_LONG).show();
        ;
        finish();
        return;
      }
      SharedApplication.user.USER_ID = userId;
      SharedApplication.user.USER_NM = userNm;
      SharedApplication.user.EQUIP_CD = equipCd;
      SharedApplication.user.BARCD_EQUIP_USE_YN = barCdEqipUseYn;
      SharedApplication.user.EWIRE_SERVER_IP = eWireServerIp;
      SharedApplication.user.EWIRE_SERVER_PORT = eWireServerPort;
      SharedApplication.user.UPDATE_SERVER_URL = updateServerUrl;
    } else {
      // for test
      SharedApplication.user.USER_ID = "test";
      SharedApplication.user.EQUIP_CD = "01";
      SharedApplication.user.BARCD_EQUIP_USE_YN = "N";
      SharedApplication.user.EWIRE_SERVER_IP = "110.8.124.30";
      SharedApplication.user.EWIRE_SERVER_PORT = "4000";
      SharedApplication.user.UPDATE_SERVER_URL = "http://110.8.124.30:4001/mobile/setup.xml";
      
    }
    
    context = this;
    
    init();
  }
  
  @Override
  protected void onResume() {
    super.onResume();
    filedDataSet();
  }
  
  private void init() {
    findViewById(R.id.btn_send).setOnClickListener(this);
    findViewById(R.id.btn_receive).setOnClickListener(this);
    findViewById(R.id.btn_read).setOnClickListener(this);
    
    // textview
    tvTotalCount = (TextView) findViewById(R.id.total_count);
    tvEndCount = (TextView) findViewById(R.id.end_count);
    tvNotEndCount = (TextView) findViewById(R.id.not_end_count);
    tvNotSendCount = (TextView) findViewById(R.id.not_send_count);
  }
  
  private void filedDataSet() {
    SqliteManager sqliteManager = AppContext.getSqliteManager();
    if (!sqliteManager.rawQuery(SQL_TOTAL_COUNT)) {
      Toast.makeText(this, sqliteManager.getErrorMessage(), Toast.LENGTH_LONG).show();
      return;
    }
    tvTotalCount.setText(Util.getCommaString(sqliteManager.getValue("TOTAL_COUNT")));
    tvEndCount.setText(Util.getCommaString(sqliteManager.getValue("END_COUNT")));
    tvNotEndCount.setText(Util.getCommaString(sqliteManager.getValue("NOT_END_COUNT")));
    tvNotSendCount.setText(Util.getCommaString(sqliteManager.getValue("NOT_SEND_COUNT")));
    notsendcount = StringUtil.getInteger(Util.getCommaString(sqliteManager.getValue("NOT_SEND_COUNT")));
  }
  
  private static final String SQL_TOTAL_COUNT = "" + " SELECT " + "       COUNT(*) AS TOTAL_COUNT, " + "       COUNT(CASE WHEN END_YN = 'Y' THEN 1 END) AS END_COUNT, " + "       COUNT(CASE WHEN END_YN = 'N' THEN 1 END) AS NOT_END_COUNT, " + "       COUNT(CASE WHEN END_YN = 'Y' AND SEND_YN = 'N' THEN 1 END) AS NOT_SEND_COUNT "
  // + "       COUNT(CASE SEND_YN = 'Y' THEN 1 END) AS NOT_SEND_COUNT "
  + "  FROM MIN";
  
  private Min selectDb(String no) {
    
    ArrayList<Min> data = null;
    Min m = new Min();
    Handler h = new Handler();
    DbManager_MIN db = new DbManager_MIN();
    data = db.getTotalList(db.geGmNoColumn(no));
    if (data != null && data.size() > 1) {
      return data.get(0);
    }
    return m;
  }
  
  // -----------------------------------------------------------------------
  // version check & install
  public void checkVersion() {
    
    String updateUrl = SharedApplication.user.UPDATE_SERVER_URL;
    String packageName = "mpgas_as";
    String versionNumber = getString(R.string.app_version);
    
    MLog.d("updateUrl :" + updateUrl);
    // test
    // versionNumber = "0.1";
    
    eWireUpdate ewireUpdate = new eWireUpdate(this) {
      
      @Override
      public void onFinished(boolean result, String resultMessage) {
        
        if (result) {
          confirm("안정적인 서비스를 위하여 업데이트 프로그램을 설치합니다", "installApk");
        } else {
          if (resultMessage.length() > 0) {
            // 데이타 다운로드
            runMinDown();
          } else {
            alert("잠시후에 다시 시도하십시요");
          }
        }
      }
      
    };
    
    ewireUpdate.checkVersion(updateUrl, packageName, versionNumber);
  }
  
  public void dbSelector(String no) {
    DbManager_MIN db = new DbManager_MIN();
    if ("".equals(no)) {
      minArray = db.getTotalList(db.getEndColum());
    } else {
      minArray = db.getTotalList(db.getReqIdColumn(no));
    }
    
    if (minArray.size() == 0) return;
  }
  
  /**
   * 송신 완료시 Che Send_Yn = Y 처리
   */
  public void updateSendYn() {
    DbManager_MIN db = new DbManager_MIN();
    boolean result = db.updateYnColumn("Y");
    if (result) {
    } else {
      // Alert.alert(activity, "민원 SEND 저장중 오류가 발생 하였습니다.", null);
    }
  }
  
  private HashMap<String, String> getFilenames() {
    dbSelector("");
    HashMap<String, String> filenames = new HashMap<String, String>();
    try {
      String pFilePath = Constant.PIC_PATH + "/";
      String sFilePath = Constant.SIGN_PATH + "/";
      for (Min m : minArray) {
        filenames.put(pFilePath + minD.SIGN_FILE_NM, pFilePath + minD.SIGN_FILE_NM);
        filenames.put(pFilePath + minD.PHOTO_FILE_NM, pFilePath + minD.PHOTO_FILE_NM);
        filenames.put(sFilePath + minD.PHOTO_FILE_NM2, sFilePath + minD.PHOTO_FILE_NM2);
      }
    } catch (Exception e) {
    }
    return filenames;
  }
  
  /**
   * 파일 삭제
   * 
   * @param a_path
   * @return
   */
  public int deleteDir(String a_path) {
    File file = new File(a_path);
    if (file.exists()) {
      File[] childFileList = file.listFiles();
      for (File childFile : childFileList) {
        if (childFile.isDirectory()) {
          deleteDir(childFile.getAbsolutePath());
          
        } else {
          childFile.delete();
        }
      }
      file.delete();
      return 1;
    } else {
      return 0;
    }
  }
  
  // 수신
  public void runMinDown() {
    CallTrans callTrans = new CallTrans(this);
    
    callTrans.callTrans(CallTrans.MIN_DOWN);
    callTrans.setOnFinished(new onFinished() {
      
      @Override
      public void preExcute(int jobType) {
        SharedApplication.mSqliteManager.importSql(R.raw.droptable);
        SharedApplication.mSqliteManager.importSql(R.raw.createtable);
        deleteDir(Constant.SIGN_PATH);
        deleteDir(Constant.PIC_PATH);
      }
      
      @Override
      public void postExcute(int jobType) {
        
      }
      
      @Override
      public void onFinished(int jobType, boolean result, String resultMessage) {
        if (result) {
          filedDataSet();
        } else {
          
        }
      }
    });
  }
  
  // 송신
  public void runMINUpload() {
    CallTrans callTrans = new CallTrans(context);
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
          alert(getString(R.string.msg_success));
          updateSendYn();
        } else {
          
        }
      }
    });
  }
  
  @Override
  protected void onActivityResult(int requestCode, int resultCode, Intent data) {
    MLog.e("requestCode:" + requestCode + " resultCode:" + resultCode + " intent:" + data);
    switch (requestCode) {
      case Constant.ZBAR_SCANNER_REQUEST:
      case Constant.ZBAR_QR_SCANNER_REQUEST:
        if (resultCode == RESULT_OK) {
          String bfGmNo = StringUtil.isNullString(data.getStringExtra(ZBarConstants.SCAN_RESULT));
          if (bfGmNo.length() != 12) {
            alert(R.string.msg_invalid_barcode);
          } else {
            dbSelector(bfGmNo);
            if (minD != null) {
              startIntent(minD);
            } else {
              alert(R.string.msg_invalid_house); // 인식된 세대가 없습니다.\n확인 바랍니다.
            }
          }
          // Toast.makeText(this, "Scan Result = " + data.getStringExtra(ZBarConstants.SCAN_RESULT), Toast.LENGTH_SHORT).show();
        } else if (resultCode == RESULT_CANCELED && data != null) {
          String error = data.getStringExtra(ZBarConstants.ERROR_INFO);
          if (!TextUtils.isEmpty(error)) {
            // .makeText(this, error, Toast.LENGTH_SHORT).show();
          }
        }
        break;
    }
  }
  
  @Override
  public void onClick(View v) {
    switch (v.getId()) {
      case R.id.btn_send:
        runMINUpload();
        break;
      case R.id.btn_receive:
        if (notsendcount > 0) {
          confirm("미송신 자료가 있습니다.\n송신하시겠습니까?\n기존 자료는 삭제 됩니다.", "checkVersion", "");
          return;
        } else {
          checkVersion();
        }
        break;
      case R.id.btn_read:
        onStartActivity(ListActivity.class);
        break;
    }
  }
  
  @Override
  public void onClickBackButton(View v) {
    // TODO Auto-generated method stub
    
  }
  
  @Override
  public void onClickOneButton(View v) {
    showMenu(v, R.menu.main);
  }
  
  @Override
  public void onClickTwoButton(View v) {
    lanchScan(v);
  }
  
  @Override
  public boolean onKeyDown(int keyCode, KeyEvent event) {
    if (event.getAction() == KeyEvent.ACTION_DOWN) {
      switch (keyCode) {
        case KeyEvent.KEYCODE_BACK:
          // if (!isTwoClickBack) {
          // //Toast.makeText(this, "'뒤로'버튼을 한번 더 누르시면 종료됩니다.",
          // Toast.makeText(this, "다시 눌러 종료하십시요.",
          // Toast.LENGTH_SHORT).show();
          // CntTimer timer = new CntTimer(2000, 1);
          // timer.start();
          // } else {
          // finish();
          // //System.exit(0);
          // return true;
          // }
          finish();
          break;
        case KeyEvent.KEYCODE_MENU:
          new Handler().postDelayed(new Runnable() {
            public void run() {
              showMenu();
            }
          }, 100);
          break;
      }
    }
    return false;
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
          alert(getString(R.string.app_name) + " ver. " + getString(R.string.app_version));
        }
        break;
    }
    return false;
  }
}
