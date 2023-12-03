package com.entropykorea.gas.as.common.kspay;

import java.io.Serializable;

import android.app.Activity;
import android.content.BroadcastReceiver;
import android.content.IntentFilter;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.Handler;

import com.bixolon.printer.BixolonPrinter;
import com.entropykorea.gas.as.bean.Min;
import com.entropykorea.gas.as.bean.Provider;
import com.entropykorea.gas.as.common.object.MLog;
import com.entropykorea.gas.as.common.util.StringUtil;

public class PrinterAndKsPay {
  public static BixolonPrinter mBixolonPrinter;
  private boolean printConnected = false; // 블루투스 장비 연결상태 값
  private boolean printComplete = false;
  
  private BroadcastReceiver BlutoothReceiver = null;
  private Handler BluetoothPrinterHandler = new Handler();
  private Handler KsPaySendHandler = new Handler();
  private Activity activity = null;
  
  private String signFileName = "";
  private int printType = 0;
  private String[] cancelDataKey = null;
  private String[] sendDataKey = null;
  private byte[] cardTrackData = null;
  
  protected Min minD = new Min();
  private Provider cPro = new Provider();
  
  public final String ACTION_GET_MSR_TRACK_DATA = "com.bixolon.anction.GET_MSR_TRACK_DATA";
  public final String EXTRA_NAME_MSR_TRACK_DATA = "MsrTrackData";
  
  public PrinterAndKsPay(Activity activity, String signFileName, BroadcastReceiver receiver) {
    
    this.activity = activity;
    this.signFileName = signFileName;
    BlutoothReceiver = receiver;
  }
  
  public PrinterAndKsPay(Activity activity) {
    
    this.activity = activity;
  }
  
  public void setData(Serializable data, Serializable data2) {
    minD = (Min) data;
    cPro = (Provider) data2;
  }
  
  public void setHandler(Handler handler1, Handler handler2) {
    BluetoothPrinterHandler = handler1;
    KsPaySendHandler = handler2;
  }
  public void setHandler(Handler handler1) {
    BluetoothPrinterHandler = handler1;
  }
  
  /**
   * print bluetoothPrinter find *
   **/
  public void connect() {
    mBixolonPrinter = new BixolonPrinter(activity, BluetoothPrinterHandler, null);
    mBixolonPrinter.findBluetoothPrinters();// Print Connect lib
    mBixolonPrinter.getMsrMode();// Psr Connect lib
    
    IntentFilter filter = new IntentFilter();
    filter.addAction(ACTION_GET_MSR_TRACK_DATA);
    
    if (BlutoothReceiver != null) {
      activity.registerReceiver(BlutoothReceiver, filter);
    }
  }
  
  public void disconnect() {
    if (mBixolonPrinter != null) mBixolonPrinter.disconnect();
  }
  
  public BixolonPrinter getPrinter() {
    return mBixolonPrinter;
  }
  
  /**
   * 카드 승인
   * 
   * @param sendDataKey
   */
  public void cardSend(String[] sendDataKey) {
    this.sendDataKey = sendDataKey;
    
    new CardPayStartThred().start();
  }
  
  /**
   * 카드 취소
   * 
   * @param cancelDataKey
   */
  public void cardCancel(String[] cancelDataKey) {
    this.cancelDataKey = cancelDataKey;
    new CancelThred().start();
  }
  
  /**
   * 영수증 시작
   * 
   * @param type
   *          영수증 보관용 :0, 고객용 : 1
   */
  public void printStart(int type) {
    // setContentData(type);
    printType = type;
    PrintTextThread thread = new PrintTextThread();
    thread.start();
    PrintBitmapThread thread2 = new PrintBitmapThread();
    thread2.start();
  }
  
  /**
   * 
   * Bluetooth 영수증 텍스트 출력
   * */
  public void printText() {
    int alignment = BixolonPrinter.ALIGNMENT_LEFT;
    int attribute = BixolonPrinter.TEXT_ATTRIBUTE_FONT_A;
    int size = BixolonPrinter.TEXT_SIZE_VERTICAL1;
    
    mBixolonPrinter.printText(StringUtil.PrintBillData(printType, minD, cPro), alignment, attribute, size, true);
  }
  
  /**
   * Bluetooth 영수증 출력 비트맵 이미지
   * */
  public void printBitmap() {
    
    int mAlignment = BixolonPrinter.ALIGNMENT_CENTER;
    int width = BixolonPrinter.BITMAP_WIDTH_NONE;
    
    boolean dither = false;
    boolean compress = false;
    int level = 50;
    
    // BitmapDrawable drawable = (BitmapDrawable) getResources().getDrawable(R.drawable.bixolon);
    // Bitmap bitmap = drawable.getBitmap();// 이미지 경로
    if("".equals(signFileName)) signFileName = minD.SIGN_FILE_NM;
    MLog.e("signFileName : " + signFileName);
    Bitmap bitmap = null;
    try {
      bitmap = BitmapFactory.decodeFile(signFileName);
      mBixolonPrinter.printBitmap(bitmap, mAlignment, width, level, dither, compress, true);
    } catch (Exception e) {
      // alert("영수증 출력이 되지 않았습니다.");
    }
  }
  
  /** 텍스트 문자 프린트 */
  class PrintTextThread extends Thread {
    @Override
    public void run() {
      printText();
    }
  }
  
  /** 비트맵 이미지 프린트 */
  class PrintBitmapThread extends Thread {
    @Override
    public void run() {
      try {
        printBitmap();
      } catch (Exception e) {
      }
    }
  }
  
  /**
   * 카드결제 승인 처리
   * */
  class CardPayStartThred extends Thread {
    @Override
    public void run() {
      try {
        KSPayMsgBean.sendCard(sendDataKey, KsPaySendHandler);
      } catch (Exception e) {
        // TODO Auto-generated catch block
        e.printStackTrace();
      }
      super.run();
    }
  }
  
  /**
   * 카드결제 취소 처리
   * */
  class CancelThred extends Thread {
    @Override
    public void run() {
      try {
        KSPayMsgBean.cancelCard(cancelDataKey, KsPaySendHandler);
      } catch (Exception e) {
        // TODO Auto-generated catch block
        e.printStackTrace();
      }
      super.run();
    }
  }
  
}
