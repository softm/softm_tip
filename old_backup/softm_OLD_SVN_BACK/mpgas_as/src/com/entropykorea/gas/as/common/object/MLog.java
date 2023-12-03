package com.entropykorea.gas.as.common.object;

import android.util.Log;

import com.entropykorea.gas.as.constants.Constant;

public class MLog {
  
  public static void d(String tag, String log) {
    if (Constant.DEBUG) Log.d(tag, log);
  }
  
  public static void d(String log) {
    if (Constant.DEBUG) Log.d(Constant.LOG_TAG, log);
  }
  
  public static void e(String tag, String log) {
    if (Constant.DEBUG) Log.e(tag, log);
  }
  
  public static void e(String log) {
    if (Constant.DEBUG) Log.e(Constant.LOG_TAG, log);
  }
  
  public static void i(String tag, String log) {
    if (Constant.DEBUG) Log.i(tag, log);
  }
  
  public static void i(String log) {
    if (Constant.DEBUG) Log.i(Constant.LOG_TAG, log);
  }
  
  public static void v(String log) {
    if (Constant.DEBUG) Log.v(Constant.LOG_TAG, log);
  }
}
