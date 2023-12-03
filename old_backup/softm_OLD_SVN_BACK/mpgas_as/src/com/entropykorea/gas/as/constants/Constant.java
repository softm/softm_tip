package com.entropykorea.gas.as.constants;

import java.io.File;

import android.os.Environment;

import com.entropykorea.gas.as.BuildConfig;

public class Constant {
  
  public final static boolean DEBUG = BuildConfig.DEBUG;
  
  public static final String LOG_TAG = "As";
  
  public final static String SD_DIR = Environment.getExternalStorageDirectory().getAbsolutePath()+ File.separator+(Constant.DEBUG?"":".")+"mpgas/as";
  
  public static final String SHARED_PREPERANCE = "mokpocitygas_pref";
  
  // database 
  public final static String DATABASE_NAME = "/as.db";

  // PATH
  public final static String SIGN_PATH = SD_DIR + "/sign"; // 서명 폴더
  
  public final static String PIC_PATH = SD_DIR + "/pic"; // 서명 폴더
  
  public static String ENCODING = "KSC5601";
  
  //network
  public static String RE_SEND_TYPE = "300001";
  public static String SEND_TYPE = "300002";
  
  // DOWNLOAD
  public final static String PATH_AS_DOWN = SD_DIR + "/min_down.zip"; // 수신 압축파일 경로
  public final static String PATH_AS_UP = SD_DIR + "/min_up.zip"; // 송신 압축파일 경로
  public final static String PATH_AS_PRICE_DOWN = SD_DIR + "/min_price_down.zip"; // 민원요금계산 수신
  
  // KSpay
  public final static String KS_INTEREST_TYPE = "1";// *일반/무이자구분 1:일반 2:무이자
  public final static String KS_IP_ADDR = "210.181.28.116";// *KSNET_IP(개발:210.181.28.116, 운영:210.181.28.137)
  public final static int KS_PORT = 21001;// *KSNET_PORT(21001)
  public final static int KS_PRINT_PAY_S = 1001;// 결제 보관용 
  public final static int KS_PRINT_PAY_C = 1002;// 결제 고객
  public final static int KS_PRINT_CAN_S = 1003;// 결제 취소 보관용
  public final static int KS_PRINT_CAN_C = 1004;// 결제 취소 고객용 
  
  // photo
  public static final int ZBAR_SCANNER_REQUEST = 900;
  public static final int ZBAR_QR_SCANNER_REQUEST = 901;
  public final static int PROC_ID_TAKE_CAMERA = 1; // 사진 촬영.
  public final static int PROC_ID_PIC_VIWER   = 2; // 사진뷰어 오픈.
  
  // db result
  public final static int RESULT_SUCCESS = 100001;
  public final static int RESULT_FAIL = 100000;
  
  //activity Result
  public static final int RESULT_REQUEST_DETAIL = 2001;
  
  
  
  
}
