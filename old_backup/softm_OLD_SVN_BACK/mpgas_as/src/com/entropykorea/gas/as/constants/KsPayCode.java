package com.entropykorea.gas.as.constants;

import java.util.Hashtable;

public class KsPayCode {
  public final static String getKsPayCardCode(String key){
    Hashtable<String, String> ht = setKsPayCardCode();
    return ht.get(key.trim());
  }
  
  public final static String getKsPayBankCode(String key) {
    Hashtable<String, String> ht = setKsPayBankCode();
    return ht.get(key.trim());
  }
  
  public final static String getKsPayErrorCode(String key){
    Hashtable<String, String> ht = setKsPayAuthNo();
    return ht.get(key.trim());
  }
  
  // 카드사 코드
  private static Hashtable<String, String> setKsPayCardCode() {
    Hashtable<String, String> ht = new Hashtable<String, String>();
    ht.put("01", "비씨카드");
    ht.put("02", "국민카드");
    ht.put("03", "외환카드");
    ht.put("04", "삼성카드");
    ht.put("05", "신한카드");// 신한-LG카드사 통합
    ht.put("08", "현대카드");
    ht.put("09", "롯데카드");// 롯데아멕스카드 포함
    ht.put("10", "구신한카드");// 05: 신한카드로 통합
    ht.put("11", "한미은행");
    ht.put("12", "수협");
    ht.put("14", "우리은행");
    ht.put("15", "농협");
    ht.put("16", "제주은행");
    ht.put("17", "광주은행");
    ht.put("18", "전북은행");
    ht.put("19", "조흥은행");// 신한으로 통합
    ht.put("23", "주택은행");// 거절시 발급사코드로 나올수 있음", 승인은 불가
    ht.put("24", "하나은행");
    ht.put("25", "해외카드사");
    ht.put("26", "씨티은행");
    ht.put("99", "기타");
    return ht;
  }
  
  // 은행명 코드
  private static Hashtable<String, String> setKsPayBankCode() {
    Hashtable<String, String> ht = new Hashtable<String, String>();
    ht.put("1", "한국은행");
    ht.put("2", "산업은행");
    ht.put("3", "기업은행");
    ht.put("4", "국민은행");
    ht.put("5", "외환은행");
    ht.put("6", "주택은행");
    ht.put("7", "수협은행");
    ht.put("8", "수출입");
    ht.put("9", "장기신용");
    ht.put("10", "신농협중앙");
    ht.put("11", "농협중앙");
    ht.put("12", "농협회원");
    ht.put("13", "농협회원");
    ht.put("14", "농협회원");
    ht.put("15", "농협회원");
    ht.put("16", "축협중앙");
    ht.put("20", "우리은행");
    ht.put("21", "조흥은행");
    ht.put("22", "상업은행");
    ht.put("23", "제일은행");
    ht.put("24", "한일은행");
    ht.put("25", "서울은행");
    ht.put("26", "신한은행");// 가상계
    ht.put("27", "씨티은행");
    ht.put("28", "동화은행");
    ht.put("29", "동남은행");
    ht.put("30", "대동은행");
    ht.put("31", "대구은행");
    ht.put("32", "부산은행");
    ht.put("33", "충청은행");
    ht.put("34", "광주은행");
    ht.put("35", "제주은행");
    ht.put("36", "경기은행");
    ht.put("37", "전북은행");
    ht.put("38", "강원은행");
    ht.put("39", "경남은행");
    ht.put("40", "충북은행");
    ht.put("45", "새마을금고");
    ht.put("71", "우체국");
    ht.put("76", "신용보증");
    ht.put("81", "하나은행");
    ht.put("82", "보람은행");
    ht.put("83", "평화은행");
    ht.put("88", "신한은행");// 계좌이체
    ht.put("209", "동양종합금융증");
    ht.put("218", "현대증권");
    ht.put("230", "미래에셋증권");
    ht.put("240", "삼성증권");
    ht.put("243", "한국투자증권");
    ht.put("247", "우리투자증권");
    ht.put("261", "교보증권");
    ht.put("262", "하이투자증권");
    ht.put("263", "HMC투자증권");
    ht.put("264", "키움증권");
    ht.put("265", "이트레이드증권");
    ht.put("266", "SK증권");
    ht.put("267", "대신증권");
    ht.put("268", "솔로몬투자증권");
    ht.put("269", "한화증권");
    ht.put("270", "하나대투증권");
    ht.put("278", "굿모닝신한증권");
    ht.put("279", "동부증권");
    ht.put("280", "유진투자증권");
    ht.put("287", "메리츠증권");
    ht.put("289", "NH투자증권");
    ht.put("290", "부국증권");
    ht.put("291", "신영증권");
    ht.put("292", "LIG투자증권");
    return ht;
  }
  
  // 결제 에러 코드
  private static Hashtable<String, String> setKsPayAuthNo() {
    Hashtable<String, String> ht = new Hashtable<String, String>();
    ht.put("0000", "정상완료");
    ht.put("6001", "사업자번호 오류");
    ht.put("6002", "주민등록번호 오류");
    ht.put("6003", "비밀번호 오류");
    ht.put("6004", "인증거래미약정 가맹점");
    ht.put("6005", "주민등록번호 + 비밀번호 오류");
    ht.put("6006", "(인증)추후서비스 예정");
    ht.put("6007", "비밀번호횟수초과");
    ht.put("6008", "주민번호 또는 사업자번호 오류");
    ht.put("6011", "CAVV 오류");
    ht.put("6012", "CAVV 취소후 거래요망");
    ht.put("7001", "이미 취소된 거래");
    ht.put("7002", "이미 매입된 거래");
    ht.put("7003", "원거래 없음");
    ht.put("7570", "할부가맹점이 아님");
    ht.put("7571", "가맹점 한도초과");
    ht.put("7803", "재 조회요망(KSVAN PROCESS ERROR)");
    ht.put("7978", "가맹점 해지");
    ht.put("7979", "가맹점 미등록, 해지, 취소, 거래정지 가맹점");
    ht.put("8000", "신용카드 아님");
    ht.put("8006", "거래금액 1,000원 미만, 또는 99,999,999이상 금액 오류");
    ht.put("8009", "거래금액 미입력");
    ht.put("8032", "할부금액 오류");
    ht.put("8037", "카드번호 잘못입력 (Check Digit Error)");
    ht.put("8038", "Data Format 오류");
    ht.put("8110", "Key-In 불가카드");
    ht.put("8120", "Key-in 불가가맹점");
    ht.put("8314", "유효기간 경과카드");
    ht.put("8324", "거래정지카드(B/L)");
    ht.put("8325", "3일 사용한도액 초과");
    ht.put("8326", "월 사용한도액 초과");
    ht.put("8327", "1회 사용한도액 초과");
    ht.put("8328", "사용 횟수 초과");
    ht.put("8329", "1일 사용한도 초과");
    ht.put("8330", "일 사용횟수 초과");
    ht.put("8331", "월 사용횟수 초과");
    ht.put("8332", "년 사용횟수 초과");
    ht.put("8350", "도난, 분실카드");
    ht.put("8373", "카드사 전화요망");
    ht.put("8375", "기타 에러 처리");
    ht.put("8380", "무응답 또는 지연응답시 (timeout)");
    ht.put("8381", "전산장애 KSNET 전화요망");
    ht.put("8393", "할부개월수 오류");
    ht.put("8417", "할부불가");
    ht.put("8418", "Service 불가카드");
    ht.put("8501", "sub 몰사업자오류");
    ht.put("8502", "할부한도초과 사용금액 수정요망");
    ht.put("2001", "지불불가 선불카드");
    ht.put("2002", "잔액부족 또는 포인트부족");
    ht.put("2003", "SYD 접속오류");
    ht.put("2004", "지불처리중인 카드");
    ht.put("P001", "미개시상점");
    ht.put("P002", "미등록상점");
    ht.put("P004", "미개시그룹");
    ht.put("P006", "미등록그룹");
    ht.put("P101", "그룹월한도초과");
    ht.put("P102", "상점1회한도초과");
    ht.put("P103", "상점월한도초과");
    ht.put("P104", "그룹1회한도초과");
    ht.put("P105", "중복거래");
    ht.put("P106", "카드정보없음");
    ht.put("P108", "카드번호오류");
    ht.put("P109", "통화코드오류");
    ht.put("P10B", "거래번호오류");
    ht.put("P10C", "주문번호오류");
    ht.put("P10D", "환율정보오류");
    ht.put("P10D", "취소거절/주문번호중복");
    ht.put("P10E", "그룹할부오류");
    ht.put("P10F", "매입처리중");
    ht.put("P10F", "상점할부오류");
    ht.put("P10G", "취소불가거래");
    ht.put("P10G", "취소거절/원거래없음");
    ht.put("P10H", "매입취소완료");
    ht.put("P10H", "중복승인요청오류");
    ht.put("P10I", "승인금액오류");
    ht.put("P10I", "사업자번호 오류");
    ht.put("P10J", "유효기간오류");
    ht.put("P10K", "일반무이자오류");
    ht.put("P10L", "취소불가거래/거래일자확인요망");
    ht.put("P10N", "카드번호오류");
    ht.put("P10O", "원거래검색실패");
    ht.put("P10P", "할부개월수오류");
    ht.put("P10Q", "취소거절/기취소거래");
    ht.put("P1D1", "데이터전송후 Timeout발생");
    ht.put("P10K", "일반무이자오류");
    ht.put("P118", "취소거절기간경과");
    ht.put("X101", "비정상데이타");
    ht.put("X102", "데이터 전송에러");
    ht.put("X103", "데이터전송후 Timeout발생");
    return ht;
  }
}
