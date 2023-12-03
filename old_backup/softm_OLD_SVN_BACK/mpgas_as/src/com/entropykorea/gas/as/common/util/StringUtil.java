package com.entropykorea.gas.as.common.util;

import java.text.DecimalFormat;
import java.util.ArrayList;

import android.widget.TextView;

import com.entropykorea.gas.as.SharedApplication;
import com.entropykorea.gas.as.bean.Min;
import com.entropykorea.gas.as.bean.MinFee;
import com.entropykorea.gas.as.bean.MinFeePay;
import com.entropykorea.gas.as.bean.MinLegalFee;
import com.entropykorea.gas.as.bean.MinUnpaidPrice;
import com.entropykorea.gas.as.bean.Provider;
import com.entropykorea.gas.as.common.object.MLog;
import com.entropykorea.gas.as.constants.Constant;
import com.entropykorea.gas.as.constants.KsPayCode;

public class StringUtil {
  public static String getString(TextView editText) {
    return editText.getText().toString().trim();
  }
  
  public static boolean getContains(String str, String CharSequence) {
    return str.contains(CharSequence);
  }
  
  public static boolean isData(String str) {
    if (str == null || "".equals(str)) {
      return true;
    } else {
      return false;
    }
  }
  
  public static String cardNumEn(String data) {
    if (isData(data)) {
      return "";
    } else {
      return data.substring(0, 4) + "-" + data.substring(4, 8) + "-" + data.substring(8, 12) + "-" + data.substring(12, 16);
    }
  }
  
  public static String getCardNumDe(String data) {
    if (isData(data)) {
      return "";
    } else {
      return data.replaceFirst("-", "");
    }
  }
  
  public static String getCardNum(String data) {
    if (isData(data)) {
      return "";
    } else {
      if (data.contains("-")) {
        return data;
      } else {
        return cardNumEn(data);
      }
    }
  }
  
  public static String getCardEnYY(String data) {
    if (isData(data)) {
      return "";
    } else {
      String[] str = data.split("=");
      return str[1].substring(0, 2);
    }
  }
  
  public static String getCardEnMM(String data) {
    String result = "";
    if (isData(data)) {
      return "";
    } else {
      String[] str = data.split("=");
      if (str[1].length() == 3) {
        result = str[1].substring(2, 3);
      } else {
        result = str[1].substring(2, 4);
      }
      return result;
    }
  }
  
  public static String getCardEnYYMM(String data) {
    if (isData(data)) {
      return "";
    } else {
      return data.substring(17, 21);// 21
    }
  }
  
  public static String[] getYYMM(String str) {
    
    return str.split("/");
  }
  
  /**
   * 영수증 출력용 yy/mm
   * 
   * @param date
   * @return
   */
  public static String cardPrintYYMM(String data) {
    if (isData(data)) {
      return "";
    } else {
      String result = "";
      String[] str1 = data.split("=");
      MLog.e("" + str1.length);
      if (data != null) {
        if (str1.length > 1) {
          if (str1[1].length() == 1) {
            result = "0" + str1[1].substring(0, 1);
          } else if (str1[1].length() == 2) {
            result = str1[1].substring(0, 2) + "/";
          } else if (str1[1].length() == 3) {
            result = str1[1].substring(0, 2) + "/0" + str1[1].substring(2, 3);
          } else if (str1[1].length() == 4) {
            result = str1[1].substring(0, 2) + "/" + str1[1].substring(2, 4);
          }
        }
      }
      return result;
    }
  }
  
  /**
   * 01=12 > 01/12
   * 
   * @param data
   * @return
   */
  public static String printYYMM(String data) {
    if (isData(data)) {
      return "";
    } else {
      String result = "";
      String[] str1 = data.split("=");
      MLog.e("" + str1.length);
      if (data != null) {
        if (str1.length > 1) {
          if (str1[1].length() == 1) {
            result = "0" + str1[1].substring(0, 1);
          } else if (str1[1].length() == 2) {
            result = str1[1].substring(0, 2) + "/";
          } else if (str1[1].length() == 3) {
            result = str1[1].substring(0, 2) + "/" + str1[1].substring(2, 3);
          } else if (str1[1].length() == 4) {
            result = str1[1].substring(0, 2) + "/" + str1[1].substring(2, 4);
          }
        }
      }
      return result;
    }
  }
  
  /**
   * (카드번호=유효기간[YYMM]);
   * 
   * @param str
   * @return
   */
  public static String getCardTrackII(String data) {
    if (isData(data)) {
      return "";
    } else {
      return data.substring(0, 16) + "=" + data.substring(17, 21);
    }
  }
  
  /**
   * 카드 할부 화면처리
   * 
   * @param month
   * @return 00:일시불, 03:3개월할부
   */
  public static String cardMonthS(String data) {
    if (isData(data)) {
      return "";
    } else {
      String cardMonth = data;
      return ("".equals(cardMonth) || "0".equals(cardMonth) || "00".equals(cardMonth)) ? "일시불" : cardMonth;
    }
  }
  
  /**
   * 카드 할부 통신시 변경
   * 
   * @param month
   * @return 일시불:00, 3:03
   */
  public static String getCardMonthN(String data) {
    if (isData(data)) {
      return "";
    } else {
      if ("일시불".equals(data) || "".equals(data) || "0".equals(data) || "00".equals(data)) {
        return "00";
      } else {
        if (data.length() < 2) {
          return "0" + data;
        }
        return data;
      }
    }
  }
  
  /**
   * 원화 , 넣기
   * 
   * @param data
   * @return
   */
  public static String formatWonEn(String data) {
    if (isData(data)) {
      return "";
    } else {
      long value = Long.parseLong(data);
      DecimalFormat format = new DecimalFormat("###,###");
      return format.format(value);
    }
  }
  
  /**
   * 원화 , 넣기
   * 
   * @param data
   * @return
   */
  public static long getlongFormatWonEn(String data) {
    isData(data);
    long value = Long.parseLong(data);
    DecimalFormat format = new DecimalFormat("###,###");
    long result = Integer.valueOf(format.format(value));
    return result;
  }
  
  /**
   * 원화 , 빼기
   * 
   * @param data
   * @return
   */
  public static String getFormatWonDe(String data) {
    isData(data);
    return data.replace(",", "");
  }
  
  public static int length(String str) {
    if (str == null) return 0;
    
    int length = str.length();
    
    for (int i = 0; i < str.length(); i++) {
      if (str.charAt(i) > 256) length++;
    }
    
    return length;
  }
  
  public static String makeFrontSpaceSting(String str, int len) {
    String result = new String();
    int strlen = length(str);
    
    if (strlen >= len) return str;
    
    for (int i = 0; i < (len - strlen); i++) {
      result += " ";
    }
    
    if (str != null) result += str;
    
    // Log.d("SKGACS", "SPACE:" + strlen );
    
    return result;
  }
  
  public static String padLine(String one, String two) {
    String result;
    int len1 = length(one);
    int tlen = 32 - len1;
    
    result = one;
    result += makeFrontSpaceSting(two, tlen);
    result += "\n";
    return result;
  }
  
  // pad with " " to the left to the given length (n)
  public static String padLeft(String s, int n) {
    return String.format("%1$" + n + "s\n", s);
  }
  
  // pad with " " to the left to the given length (n)
  public static String padLeft(int s, int n) {
    return String.format("%1$" + n + "s\n", s);
  }
  
  public static int getInteger(String str) {
    int value = 0;
    if (str != null && !"".equals(str)) {
      return Integer.valueOf(str);
    } else {
      return value;
    }
  }
  
  public static String isNullString(String str) {
    if (str != null && !"".equals(str)) {
      return str;
    } else {
      return "";
    }
    
  }
  
  public static String isNullInteger(int i) {
    if (i != 0) return i + "";
    else return "0";
  }
  
  /**
   * code value return MA290 H 전화번호 MA290 M 핸드폰번호 MA290 C 직장전화번호
   * 
   * @param key
   *          typekey ex) MA290
   * @param min
   * @return
   */
  public static String getTelCode(Min min) {
    String tel = "";
    if ("H".equals(min.TEL_CD)) {
      tel = min.TEL_NO;
    } else if ("M".equals(min.TEL_CD)) {
      tel = min.WORK_TEL_NO;
    } else if ("C".equals(min.TEL_CD)) {
      tel = min.HP_NO;
    }
    return tel;
  }
  
  /**
   * 주소 텍스트 조합
   * */
  public static String getAddress(Min bean) {
    String str = "";
    str = bean.SECTOR_NM + " ";
    str += bean.BLDG_NO + " ";
    str += bean.COMPLEX_NM + " ";
    str += bean.BLDG_NO + " ";
    str += bean.BLDG_NM + " ";
    str += bean.ROAD_NM + " ";
    str += bean.ROOM_NO + " ";
    str += bean.CO_NM;
    return str;
  }
  
  /***
   * 빌드 분기처
   * 
   * @param type
   * @param min
   * @param provider
   * @return
   */
  public static String PrintBillData(int type, Object min, Object provider) {
    if (type == Constant.KS_PRINT_PAY_S || type == Constant.KS_PRINT_PAY_C) {
      return PrintSendBillData(type, min, provider);
    } else {
      return PrintCancelBillData(type, min, provider);
    }
  }
  
  public static String printCardNumStar(String str) {
    String result = "";
    if (str.length() >= 16) {
      result = "****" + "-" + "****" + "-" + str.substring(8, 12) + "-" + str.substring(12, 16);
    }
    return result;
  }
  
  /**
   * 카드 승인용
   * 
   * @param type
   *          보관용 ,고객용
   * @param min
   * @param provider
   * @return
   */
  public static String PrintSendBillData(int type, Object min, Object provider) {
    String data = "";
    Min cM = (Min) min;
    Provider cP = (Provider) provider;
    data += "================================\n";
    data += padLeft("매 출 전 표  " + (type == Constant.KS_PRINT_PAY_S ? "(보관용)" : "(고객용)"), 18);
    data += "================================\n";
    data += padLine(KsPayCode.getKsPayCardCode(cM.CARD_COMPANY), "거래승인");
    data += padLine("거래 일시 : ", DateString.makeDateTimeString(cM.CARD_TRANS_DATE));
    data += padLine("카드 번호 : ", printCardNumStar(cM.CARD_NUM));
    data += padLine("유효기간(년/월) : ", cM.CARD_YM);
    data += padLine("할    부 : ", cardMonthS(cM.CARD_MONTHS) + " 개월");
    data += padLine("가맹점번호 : ", cP.VAN_NO);
    data += padLine("승인 번호 : ", cM.CARD_TRANS_NUM);
    data += padLine("매 입 사 : ", KsPayCode.getKsPayCardCode(cM.CARD_COMPANY));
    data += "--------------------------------\n";
    data += padLine("판매 금액 : ", formatWonEn(cM.CARD_AMT));
    data += "--------------------------------\n";
    data += padLine("가맹 점명 : ", cP.CO_NM);
    data += padLine("사업자번호 : ", cP.CO_NO);
    data += padLine("대 표 자 : ", cP.CEO_NM);
    data += padLine("T E L : ", cP.TEL_NO);
    data += padLine("주 소 : ", cP.ADDR);
    // data += "주소 : ",provider.ROAD_ADDR1, 18);
    data += "--------------------------------\n";
    data += padLeft("서   명", 18);
    data += "--------------------------------\n\n";
    MLog.e(data);
    return data;
  }
  
  /**
   * 카드 취소용
   * 
   * @param type
   *          보관용 ,고객용
   * @param min
   * @param provider
   * @return
   */
  public static String PrintCancelBillData(int type, Object min, Object provider) {
    // line total 32
    String data = "";
    Min cM = (Min) min;
    Provider cP = (Provider) provider;
    data += "================================\n";
    data += padLeft("매 출 전 표  " + (type == Constant.KS_PRINT_CAN_S ? "(보관용)" : "(고객용)"), 18);
    data += "================================\n";
    data += padLine(KsPayCode.getKsPayCardCode(cM.CARD_COMPANY), "거래취소");
    data += padLine("취소시 원거래일자 : ", DateString.makeDateTimeString(cM.CARD_CANCEL_TRANS_DATE));
    data += padLine("카드 번호 : ", printCardNumStar(cM.CARD_NUM));
    data += padLine("유효기간(년/월) : ", cM.CARD_YM);
    data += padLine("할   부 : ", cardMonthS(cM.CARD_MONTHS) + " 개월");
    data += padLine("가맹점번호 : ", cP.VAN_NO);
    data += padLine("승인 번호 : ", cM.CARD_TRANS_NUM);
    data += padLine("매 입 사 : ", KsPayCode.getKsPayCardCode(cM.CARD_COMPANY));
    data += "--------------------------------\n";
    data += padLine("판매 금액 : ", formatWonEn(cM.CARD_AMT));
    data += "--------------------------------\n";
    data += padLine("가맹 점명 : ", cP.CO_NM);
    data += padLine("사업자번호 : ", cP.CO_NO);
    data += padLine("대 표 자 : ", cP.CEO_NM);
    data += padLine("T E L : ", cP.TEL_NO);
    data += padLine("주 소 : ", cP.ADDR);
    data += "--------------------------------\n\n\n";
    MLog.e(data);
    return data;
  }
  
  /**
   * 전입 현금 영수증
   * 
   * @param type
   * @param m
   * @param provider
   * @param fee
   * @param feePay
   * @return
   */
  public static String PrinInBillData(int type, Min m, Provider provider, ArrayList<MinFee> fee, ArrayList<MinFeePay> feePay) {
    
    String data = "";
    Min min = m;
    Provider cP = provider;
    
    if (fee == null) fee = new ArrayList<MinFee>();
    
    data += "================================\n";
    data += padLeft("매 출 전 표  " + (type == Constant.KS_PRINT_PAY_S ? "(보관용)" : "(고객용)"), 18);
    data += "================================\n";
    data += padLine("수용가번호 : ", min.HOUSE_NO);
    data += padLine("주 소 : ", getAddress(min));
    data += "--------------------------------\n";
    if (feePay.size() > 0) {
      data += PayUtil.getMinFeeList(fee, feePay);
      data += "--------------------------------\n";
      data += padLine("수수료 합계 : ", formatWonEn(PayUtil.getFeePriceSum(fee, feePay) + "") + " 원");
      data += "--------------------------------\n";
    }
    data += padLine("현금 수납 : ", formatWonEn(min.CASH_AMT) + " 원");
    data += "--------------------------------\n";
    data += padLine("가맹 점명 : ", cP.CO_NM);
    data += padLine("주 소 : ", cP.ADDR);
    data += padLine("T E L : ", cP.TEL_NO);
    data += padLine("담당 기사 : ", SharedApplication.user.USER_NM);
    data += padLine("일   시 : ", DateString.makeDateTimeString(DateString.getToday()));
    data += "\n";
    data += "이 영수증은 세금계산서로 활용할수 없습니다.";
    data += "\n";
    data += "--------------------------------\n";
    data += type == Constant.KS_PRINT_PAY_C ? "담당기사 서명 :\n\n\n\n\n" : "\n";
    MLog.e(data);
    return data;
  }
  
  /**
   * 전출 현금 영수증
   * 
   * @param type
   * @param m
   * @param provider
   * @param legalfee
   * @param unpaid
   * @return
   */
  public static String PrintOutBillData(int type, Min m, Provider provider, ArrayList<MinLegalFee> legalfee, ArrayList<MinUnpaidPrice> unpaid) {
    
    String data = "";
    Min min = m;
    Provider cP = provider;
    ArrayList<MinLegalFee> lp = legalfee;// 법적비용
    ArrayList<MinUnpaidPrice> uP = unpaid;// 미납금액
    int udpaidpricePrice, legalPrice = 0;
    
    if (lp == null) lp = new ArrayList<MinLegalFee>();
    if (uP == null) uP = new ArrayList<MinUnpaidPrice>();
    
    udpaidpricePrice = PayUtil.getUnpaidpricePriceSum(uP);
    legalPrice = PayUtil.getLegalPriceSum(lp);
    
    data += "================================\n";
    data += padLeft("매 출 전 표  " + (type == Constant.KS_PRINT_PAY_S ? "(보관용)" : "(고객용)"), 18);
    data += "================================\n";
    data += padLine("수용가번호 : ", min.HOUSE_NO);
    data += padLine("주 소 : ", getAddress(min));
    data += "--------------------------------\n";
    if (!"".equals(min.METER)) {
      data += padLine("지   침 : ", "" + min.METER);
    }
    if (uP.size() > 0) {
      data += padLine("당월 요금 : ", formatWonEn("" + min.USE_PRICE));
      data += padLine("미납 요금 : ", formatWonEn("" + udpaidpricePrice));
      data += "--------------------------------\n";
    }
    if (lp.size() > 0) {
      data += "[법적비용] : \n";
      data += PayUtil.getLegalList(lp);
      data += "--------------------------------\n";
      data += padLine("법적비용 합계 : ", formatWonEn("" + legalPrice));
      data += "--------------------------------\n";
    }
    data += padLine("현금 수납 : ", formatWonEn(min.CASH_AMT) + " 원");
    data += "--------------------------------\n";
    data += "\n";
    data += padLine("가맹 점명 : ", cP.CO_NM);
    data += padLine("주 소 : ", cP.ADDR);
    data += padLine("T E L : ", cP.TEL_NO);
    data += padLine("담당 기사 : ", SharedApplication.user.USER_NM);
    data += padLine("일   시 : ", DateString.makeDateTimeString(DateString.getToday()));
    data += "\n";
    data += "이 영수증은 세금계산서로 활용할수 없습니다.";
    data += "\n";
    data += "--------------------------------\n";
    data += type == Constant.KS_PRINT_PAY_C ? "담당기사 서명 :\n\n\n\n\n" : "";
    MLog.e(data);
    return data;
  }
  
  /**
   * 봉인해제 현금 영수증
   * 
   * @param type
   * @param m
   * @param provider
   * @param legalfee
   * @param unpaid
   * @param minFee
   * @param minFeePay
   * @return
   */
  public static String PrintSealBillData(int type, Min m, Provider provider, ArrayList<MinLegalFee> legalfee, ArrayList<MinUnpaidPrice> unpaid, ArrayList<MinFee> minFee, ArrayList<MinFeePay> minFeePay) {
    
    String data = "";
    Min min = m;
    Provider cP = provider;
    ArrayList<MinLegalFee> lp = legalfee;// 법적비용
    ArrayList<MinUnpaidPrice> uP = unpaid;// 미납금액
    ArrayList<MinFee> fee = minFee; // 수수료
    ArrayList<MinFeePay> feePay = minFeePay;// 수수료 수납
    int totalPrice, basePrice, usePrice, udpaidpricePrice, legalPrice = 0;
    
    if (lp == null) lp = new ArrayList<MinLegalFee>();
    if (uP == null) uP = new ArrayList<MinUnpaidPrice>();
    if (fee == null) fee = new ArrayList<MinFee>();
    
    udpaidpricePrice = PayUtil.getUnpaidpricePriceSum(uP);
    legalPrice = PayUtil.getLegalPriceSum(lp);
    totalPrice = PayUtil.getTotalPriceSum(StringUtil.getInteger(min.USE_PRICE), StringUtil.getInteger(min.BASE_PRICE), udpaidpricePrice, legalPrice);
    
    data += "================================\n";
    data += padLeft("매 출 전 표  " + (type == Constant.KS_PRINT_PAY_S ? "(보관용)" : "(고객용)"), 18);
    data += "================================\n";
    data += padLine("수용가번호 : ", min.HOUSE_NO);
    data += padLine("주 소 : ", getAddress(min));
    data += "--------------------------------\n";
    if (uP.size() > 0) {
      data += padLine("미납 요금 : ", formatWonEn("" + udpaidpricePrice));
      data += "--------------------------------\n";
    }
    if (lp.size() > 0) {
      data += "[법적비용] : \n";
      data += PayUtil.getLegalList(lp);
      data += "--------------------------------\n";
      data += padLine("법적비용 합계 : ", formatWonEn("" + legalPrice));
      data += "--------------------------------\n";
    }
    if (feePay.size() > 0) {
      data += PayUtil.getMinFeeList(fee, feePay);
      data += "--------------------------------\n";
      data += padLine("수수료 합계 : ", formatWonEn("" + PayUtil.getFeePriceSum(fee, feePay)));
      data += "--------------------------------\n";
    }
    data += padLine("현금 수납 : ", formatWonEn(min.CASH_AMT) + " 원");
    data += "--------------------------------\n";
    data += "\n";
    data += padLine("가맹 점명 : ", cP.CO_NM);
    data += padLine("주 소 : ", cP.ADDR);
    data += padLine("T E L : ", cP.TEL_NO);
    data += padLine("담당 기사 : ", SharedApplication.user.USER_NM);
    data += padLine("일   시 : ", DateString.makeDateTimeString(DateString.getToday()));
    data += "\n";
    data += "이 영수증은 세금계산서로 활용할수 없습니다.";
    data += "\n";
    data += "--------------------------------\n";
    data += type == Constant.KS_PRINT_PAY_C ? "담당기사 서명 :\n\n\n\n\n" : "";
    MLog.e(data);
    return data;
  }
}