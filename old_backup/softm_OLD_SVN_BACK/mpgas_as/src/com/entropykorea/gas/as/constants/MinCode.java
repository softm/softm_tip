package com.entropykorea.gas.as.constants;

import java.util.Hashtable;

public class MinCode {
  
  public final static String getPushNm(String key) {
    Hashtable<String, String> ht = setPushCode();
    return ht.get(key);
  }
  
  // 독촉구분 코드
  public static Hashtable<String, String> setPushCode() {
    Hashtable<String, String> ht = new Hashtable<String, String>();
    ht.put("Y", "독촉");
    ht.put("N", "");
    return ht;
  }
  
}
