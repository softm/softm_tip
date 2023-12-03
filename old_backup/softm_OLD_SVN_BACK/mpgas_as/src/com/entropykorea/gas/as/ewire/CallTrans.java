package com.entropykorea.gas.as.ewire;

import java.io.File;
import java.util.HashMap;

import android.content.Context;
import android.database.sqlite.SQLiteDatabase;
import android.provider.SyncStateContract.Constants;

import com.entropykorea.ewire.eWireData;
import com.entropykorea.ewire.eWireTrans;
import com.entropykorea.ewire.spec.CodeSpec;
import com.entropykorea.gas.as.AppContext;
import com.entropykorea.gas.as.SharedApplication;
import com.entropykorea.gas.as.common.object.MLog;
import com.entropykorea.gas.as.common.util.DateString;
import com.entropykorea.gas.as.constants.Constant;
import com.entropykorea.gas.as.spec.AreaCenterSpec;
import com.entropykorea.gas.as.spec.MinCurPriceSpec;
import com.entropykorea.gas.as.spec.MinCustSpec;
import com.entropykorea.gas.as.spec.MinFeePaySpec;
import com.entropykorea.gas.as.spec.MinFeeSpec;
import com.entropykorea.gas.as.spec.MinLegalFeeSpec;
import com.entropykorea.gas.as.spec.MinResultSpec;
import com.entropykorea.gas.as.spec.MinSpec;
import com.entropykorea.gas.as.spec.MinUnpaidPriceSpec;
import com.entropykorea.gas.as.spec.ProviderSpec;

public class CallTrans {
  
  public final static int MIN_PRICE_DOWN = 0;
  public final static int MIN_DOWN = 1;
  public final static int MIN_UP = 2;
  
  private static String ZIPFILENAME = "";// "/sdcard/mpgas/MIN/data.zip";
  private final static String FILEPATH = Constant.SD_DIR;// "/sdcard/mpgas/MIN/";
  
  private Context mContext = null;
  private SQLiteDatabase mSqliteDatabase = null;
  
  private String mUserId = "";
  private String mHousId = "";
  private String mCustNo = "";
  private String mREQUIRE_IDX = "";//REQUIRE_IDX
  private String mMeter = "";
  private String mDeviceNumber = "";
  
  private String mCommand = "";
  private String mInstruction = "";
  private String mParam = "";
  
  private HashMap<String, String> filenames = null;
  
  private int mJobType = 0;
  
  public CallTrans(Context ctx) {
    this.mContext = ctx;
    this.mSqliteDatabase = AppContext.getSQLiteDatabase();
    this.mUserId = SharedApplication.user.USER_ID;
    this.mDeviceNumber = SharedApplication.user.EQUIP_CD;
  }
  
  public CallTrans(Context ctx, String custNo, String reqId, String housId, String meter) {
    // TODO Auto-generated constructor stub
    
    this.mContext = ctx;
    this.mSqliteDatabase = AppContext.getSQLiteDatabase();
    this.mHousId = housId;
    this.mCustNo = custNo;
    this.mMeter = meter;
    this.mREQUIRE_IDX = reqId;
    this.mDeviceNumber = SharedApplication.user.EQUIP_CD;
  }
  
  public CallTrans(Context ctx, String custNo, String housId, String meter) {
    // TODO Auto-generated constructor stub
    
    this.mContext = ctx;
    this.mSqliteDatabase = AppContext.getSQLiteDatabase();
    this.mHousId = housId;
    this.mCustNo = custNo;
    this.mMeter = meter;
    this.mUserId = SharedApplication.user.USER_ID;
    this.mDeviceNumber = SharedApplication.user.EQUIP_CD;
  }
  /***
   * 업로드 파일 등록 
   * @param filenames
   */
  public void setAddFiles(HashMap<String, String> filenames) {
    this.filenames = filenames;
  }
  
  public void setParam() {
    //this.mJobYm = jobYm;
  }
  
  public void callTrans(int jobType) {
    this.mJobType = jobType;
    switch (jobType) {
      case MIN_PRICE_DOWN:
        ZIPFILENAME = Constant.PATH_AS_PRICE_DOWN;
        callMINFeeDown();
        break;
      case MIN_DOWN:
        ZIPFILENAME = Constant.PATH_AS_DOWN;
        callMINDown();
        break;
      case MIN_UP:
        ZIPFILENAME = Constant.PATH_AS_UP;
        callMINUpload();
        break;
    }
  }
  
  private void callMINDown() {
    
    // DOWN|/DATA/MIN/DN/(YYYYMMDD)/DN_MIN_(기기번호)_hhmmss.ZIP|사용자아이디
    String format = "DOWN|/DATA/MIN/DN/%s/DN_MIN_%s_%s.ZIP|%s";
    // this.mParam = "DOWN|/DATA/MIN/DN/20141030/DN_USER_01_144203.ZIP|test";//TEST
    
    setParam();
    this.mCommand = "C";
    this.mInstruction = "min_down";
    this.mParam = String.format(format, DateString.getTodayYMD(), mDeviceNumber, DateString.getTodayHMS(), mUserId);
    
    MLog.d(this.mParam);
    
    callTrans();
  }
  
  private void callMINFeeDown() {
    // DOWN|/DATA/MIN/DN/(YYYYMMDD)/DN_MIN_PRICE_(기기번호)_hhmmss.ZIP|민원인덱스|고객번호|수용가번호|지침
    String format = "DOWN|/DATA/MIN/DN/%s/DN_MIN_PRICE_%s.ZIP|%s|%s|%s|%s";
    // String param = "DOWN|/DATA/MIN/DN/20141113/DN_MIN_PRICE_01_170103.ZIP|13|" + minD.REQUIRE_IDX + "|" + minD.HOUSE_NO + "|125";
    setParam();
    this.mCommand = "C";
    this.mInstruction = "min_price_down";
    this.mParam = String.format(format, DateString.getTodayYMD(), mDeviceNumber, mREQUIRE_IDX, mCustNo, mHousId, mMeter);
    
    MLog.d(this.mParam);
    
    callTrans();
    
  }
  
  private void callMINUpload() {
    // UP|/DATA/MIN/UP/(YYYYMMDD)/UP_MIN_(기기번호)_hhmmss.ZIP|현재일자(YYYYMMDD)/사용자아이디
    String format = "UP|/DATA/MIN/UP/%s/UP_MIN_%s_%s.ZIP|%s|%s";
    
    setParam();
    this.mCommand = "C";
    this.mInstruction = "min_up";
    this.mParam = String.format(format, DateString.getTodayYMD(), mDeviceNumber, DateString.getTodayHMS(), DateString.getTodayYMD(), mUserId);
    
    MLog.d(this.mParam);
    
    callExport();
  }
  
  // interface
  // public void onFinished(boolean result, String resultMessage);
  
  public interface onFinished {
    void onFinished(int jobType, boolean result, String resultMessage);
    
    void preExcute(int jobType);
    
    void postExcute(int jobType);
  }
  
  private onFinished callbackOnFinished = null;
  
  public void setOnFinished(onFinished callback) {
    this.callbackOnFinished = callback;
  }
  
  // eWire
  private void callTrans() {
    
    // eWire
    eWireTrans ewireTrans = new eWireTrans(mContext) {
      
      @Override
      public void onFinished(boolean result, String resultMessage) {
        if (result) {
          // 다운의 경우 import 실행
          if (mJobType != MIN_UP) {
            callImport();
          } else if (callbackOnFinished != null) {
            callbackOnFinished.onFinished(mJobType, result, resultMessage);
          }
        } else {
          if (callbackOnFinished != null) {
            callbackOnFinished.onFinished(mJobType, result, resultMessage);
          }
        }
      }
      
    };
    ewireTrans.setServerIp(SharedApplication.user.EWIRE_SERVER_IP);
    ewireTrans.setServerPort(SharedApplication.user.EWIRE_SERVER_PORT);
    ewireTrans.setUserId(mUserId);
    ewireTrans.setCommand(mCommand);
    ewireTrans.setInstruction(mInstruction);
    ewireTrans.setParam(mParam);
    ewireTrans.setFileName(ZIPFILENAME);
    
    // option
    if (mJobType == MIN_PRICE_DOWN) {
      ewireTrans.setDialogType(eWireTrans.DIALOGTYPE_WAIT);
    } else {
      ewireTrans.setDialogType(eWireTrans.DIALOGTYPE_PROGRESS);
    }
    ewireTrans.setDisplayMessage(eWireTrans.DEFAULT_DISPLAYMESSAGE);
    ewireTrans.setShowError(true);
    
    if (mJobType == MIN_UP) {
      // 업로드의 경우
      ewireTrans.setSoundPlay(true);
    } else {
      ewireTrans.setSoundPlay(false);
    }
    
    // eWire Thread
    ewireTrans.excuteTrans();
  }
  
  private void callImport() {
    
    // create directory
    mkDir();
    
    // set ewiredata
    eWireData ewireData = new eWireData(mContext) {
      
      @Override
      public void onFinished(boolean result, String resultMessage) {
        
        if (callbackOnFinished != null) {
          callbackOnFinished.onFinished(mJobType, result, resultMessage);
        }
        
        if (result) {
          
        } else {
          
        }
      }
      
      @Override
      public void preExcute() {
        if (callbackOnFinished != null) {
          callbackOnFinished.preExcute(mJobType);
        }
      }
      
      @Override
      public void postExcute() {
        if (callbackOnFinished != null) {
          callbackOnFinished.postExcute(mJobType);
        }
      }
      
    };
    ewireData.setDatabase(mSqliteDatabase);
    ewireData.setZipfilename(ZIPFILENAME);
    ewireData.setOutputFolder(FILEPATH);
    
    Object[] databasespecication = null;
    if (mJobType == MIN_PRICE_DOWN) {
      databasespecication = new Object[]{ 
        //min_cur_price.dat, min_unpaid_price.dat, min_legal_fee.dat
        
        new MinCurPriceSpec(), 
        new MinUnpaidPriceSpec(), 
        new MinLegalFeeSpec(), };
    
    }else{
      databasespecication = new Object[]{ 
          //code.dat, provider.dat, area_center.dat, min.dat, minFee.dat
          new CodeSpec(), 
          new ProviderSpec(), 
          new AreaCenterSpec(), 
          new MinSpec(), 
          new MinFeeSpec(), 
          };
    }
    ewireData.setDatabaseSpecication(databasespecication);
    
    // option
    // ewireData.setDialogType(eWireData.DIALOGTYPE_NONE);
    // ewireData.setDialogType(eWireData.DIALOGTYPE_WAIT);
    // ewireData.setDialogType(eWireData.DIALOGTYPE_WAIT_PROGRESS);
    if (mJobType == MIN_PRICE_DOWN) {
      ewireData.setDialogType(eWireTrans.DIALOGTYPE_WAIT);
      ewireData.setSoundPlay(false);
    } else {
      ewireData.setDialogType(eWireData.DIALOGTYPE_PROGRESS);
      ewireData.setSoundPlay(true);
    }
    ewireData.setDisplayMessage(eWireData.DEFAULT_DISPLAYMESSAGE);
    ewireData.setShowError(true);
    
    if( Constant.DEBUG ) {
      ewireData.setDeleteAfterImport(false);
    }
    // do thread
    ewireData.excuteImport();
  }
  
  // 송신전 데이터 파일 생성
  private void callExport() {
    
    // set ewiredata
    eWireData ewireData = new eWireData(mContext) {
      
      @Override
      public void onFinished(boolean result, String resultMessage) {
        
        if (result) {
          callTrans();
        } else {
          if (callbackOnFinished != null) {
             callbackOnFinished.onFinished(mJobType, result, resultMessage);
          }
        }
      }
      
      @Override
      public void preExcute() {
        if (callbackOnFinished != null) {
           callbackOnFinished.preExcute(mJobType);
        }
      }
      
      @Override
      public void postExcute() {
        if (callbackOnFinished != null) {
           callbackOnFinished.postExcute(mJobType);
        }
      }
    };
    ewireData.setDatabase(mSqliteDatabase);
    ewireData.setZipfilename(ZIPFILENAME);
    ewireData.setOutputFolder(FILEPATH);
    // %% sms 발송을 위해 고객 정보를 먼저 송신함 %%
    Object[] databasespecication = { 
        new MinCustSpec(), 
        new MinFeePaySpec(), 
        new MinResultSpec(), 
        };
    ewireData.setDatabaseSpecication(databasespecication);
    
    // file name only
    // String[] files = FileUtils.getFiles(path, ".bmp");
    // ewireData.setAddFiles(path, files); // 추가 파일
    
    // file name with path
    if (filenames != null) ewireData.setAddFiles(filenames); // 추가 파일

    // option
    // ewireData.setDialogType(eWireData.DIALOGTYPE_NONE);
    // ewireData.setDialogType(eWireData.DIALOGTYPE_WAIT);
    // ewireData.setDialogType(eWireData.DIALOGTYPE_WAIT_PROGRESS);
    if (mJobType == MIN_UP) {
      ewireData.setDialogType(eWireTrans.DIALOGTYPE_WAIT);
      ewireData.setSoundPlay(false);
    } else {
      ewireData.setDialogType(eWireData.DIALOGTYPE_PROGRESS);
      ewireData.setSoundPlay(true);
    }
    ewireData.setDisplayMessage(eWireData.DEFAULT_DISPLAYMESSAGE);
    ewireData.setShowError(true);
    
    // do thread
    ewireData.excuteExport();
  }
  
  // 파일 생성
  private void mkDir() {
    // create directory
    try {
      File f = new File(FILEPATH);
      if (!f.isDirectory()) f.mkdirs();
    } catch (Exception e) {
      e.printStackTrace();
      return;
    }
    
  }
}
