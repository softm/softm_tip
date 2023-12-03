package com.entropykorea.gas.as.common.util;

import java.util.ArrayList;

import com.entropykorea.gas.as.bean.MinFee;
import com.entropykorea.gas.as.bean.MinFeePay;
import com.entropykorea.gas.as.bean.MinLegalFee;
import com.entropykorea.gas.as.bean.MinUnpaidPrice;
import com.entropykorea.gas.as.common.object.MLog;

public class PayUtil {
  /**
   * 각월별 미납금 합계 미납금액 합계 MIN_UNPAID_PRICE Table
   * */
  public static int getUnpaidpricePriceSum(ArrayList<MinUnpaidPrice> arr) {
    int value = 0;
    
    for (MinUnpaidPrice data : arr) {
      value += Integer.valueOf(data.CHE_PRICE);
    }
    MLog.e("미납금액 : " + value);
    return value;
  }
  
  /**
   * 법적비용 합계 미납금액 합계 MIN_LEGAL_FEE Table
   * */
  public static int getLegalPriceSum(ArrayList<MinLegalFee> arr) {
    int value = 0;
    
    for (MinLegalFee data : arr) {
      value += Integer.valueOf(data.LEGAL_PRICE);
    }
    
    return value;
  }
  
  /**
   * 계산된 총액
   * 
   * @param int basePrice 기본요금 : MIN.BASE_PRICE
   * @param int usePrice 당월요금(사용요금-기본요금)
   * @param int cheprice 미납금액(미납금액 합계)
   * @param int legalPrice 법적비용(법적비용 합계)
   * 
   * */
  public static int getTotalPriceSum(int basePrice, int usePrice, int cheprice, int legalPrice) {
    return basePrice + usePrice + cheprice + legalPrice;
  }
  
  /**
   * 미납금액: 월, 원
   * 
   * @param unpaidArray
   * @return
   */
  public static String getUnpaidList(ArrayList<MinUnpaidPrice> unpaidArray) {
    String unpaidStr = "미납금액\n";
    for (MinUnpaidPrice data : unpaidArray) {
      unpaidStr += data.CHE_MONTH + " : " + StringUtil.padLeft(StringUtil.formatWonEn(data.CHE_PRICE) + " 원", 20) + "\n";
    }
    return unpaidStr;
  }
  
  /**
   * 법적금액: 법적조치내용, 원
   * 
   * @param unpaidArray
   * @return
   */
  public static String getLegalList(ArrayList<MinLegalFee> legalArray) {
    String unpaidStr = "법적금액\n";
    for (MinLegalFee data : legalArray) {
      unpaidStr += StringUtil.padLine(data.LEGAL_JOB + " : ", StringUtil.formatWonEn(data.LEGAL_PRICE) + " 원");
    }
    return unpaidStr;
  }
  
  /**
   * 수수료 : 품목, 원
   * 
   * @param unpaidArray
   * @return
   */
  public static String getMinFeeList(ArrayList<MinFee> fee, ArrayList<MinFeePay> feePay) {
    String unpaidStr = "";
    int i = 0;
    int sum = 0;
    try {
      for (MinFee data : fee) {
        if (data.AREA_CD.equals(feePay.get(i).AREA_CD)) {
          MLog.d(feePay.get(i).PROC_UNIT_PRICE + "p :" + StringUtil.getInteger(feePay.get(i).PROC_UNIT_PRICE));
          MLog.d(feePay.get(i).PROC_QTY + " q :" + feePay.get(i).PROC_QTY);
          sum += (StringUtil.getInteger(feePay.get(i).PROC_UNIT_PRICE) * feePay.get(i).PROC_QTY);
          unpaidStr += StringUtil.padLine(data.ITEM_NM + " * " + feePay.get(i).PROC_QTY + "(개)", StringUtil.formatWonEn(sum+"") + " 원");
          i++;
          sum = 0;
        }
      }
    } catch (Exception e) {
      MLog.d("print e :" + e.getMessage());
    }
    return unpaidStr;
  }
  
  /**
   * 수수료 합계 미납금액 합계 MIN_FEE Table
   * */
  public static int getFeePriceSum(ArrayList<MinFee> fee, ArrayList<MinFeePay> feePay) {
    int i = 0;
    int sum = 0;
    try {
      for (MinFee data : fee) {
        if (data.AREA_CD.equals(feePay.get(i).AREA_CD)) {
          sum += StringUtil.getInteger(feePay.get(i).PROC_UNIT_PRICE) * feePay.get(i).PROC_QTY;
          i++;
        }
      }
    } catch (Exception e) {
    }
    return sum;
  }
}
