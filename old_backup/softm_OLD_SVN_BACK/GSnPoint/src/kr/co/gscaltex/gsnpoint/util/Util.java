package kr.co.gscaltex.gsnpoint.util;

import kr.co.gscaltex.gsnpoint.DefaultApplication;
import kr.co.gscaltex.gsnpoint.R;
import android.app.Activity;

public class Util {
	public final static String GTAG = "GSPoint";
	public final static String DIR = "GsPoint";
	public final static String MAP_FILE = "map.zip";
	public final static String SERVER_ALERT_STATUS="2";
	public final static String SERVER_GO_STATUS="3";
	public final static int REC=10;
	
	/**적립 */
	public final static String POINT_KIND_1_VALUE="01";
	/**사용 */
	public final static String POINT_KIND_2_VALUE="02";
	/**적립취소 */
	public final static String POINT_KIND_3_VALUE="03";
	/**사용취소 */
	public final static String POINT_KIND_4_VALUE="04";
	/**기타 */
	public final static String POINT_KIND_5_VALUE="05";
	
	/**적립 이미지*/
	public int POINT_KIND_1=R.drawable.icon_save;
	/**사용 이미지 */
	public int POINT_KIND_2=R.drawable.icon_use;
	/**적립취소 이미지*/
	public int POINT_KIND_3=R.drawable.icon_savecancel;
	/**사용취소 이미지 */
	public int POINT_KIND_4=R.drawable.icon_usecancel;
	/**기타 이미지*/
	public int POINT_KIND_5=R.drawable.icon_etc;
	
	/**서버접속 장애 */
	public final static String COMMON_MSG_1 = "네트워크 접속이 원활하지 않습니다.\n잠시 후에 다시 시도해 주십시오.";
	/**데이타가 없습니다 */
	public final static String COMMON_MSG_2 = "모든 데이터가 조회 되었습니다.";
	/*lhr add*/
	public final static String NOT_FOUND_RESULT = "요청하신 데이터가 존재하지 않습니다.";
	public final static String COMPLETE_FOUND_RESULT = "모든데이터가 조회 되었습니다.";
	/*lhr end*/
	
	/**서버장애 */
	public final static String COMMON_MSG_3 = "서버처리 알림:";
	/**처리장애 */
	public final static String COMMON_MSG_4 = "단말 APP 처리장애 입니다";
	public final static String SUCCESS = "1";
	public final static String FAIL = "0";
	public final static String MOBILE_CONTRACT_AGREE="Y";
	public final static String OPINION_Y="y";
	public final static String CALL_NUMBER = "15445151";
	
	//public final static String DATA_CONNECT ="http://121.254.215.91/ServerStart";
	//public final static String LOGIN_URL = "http://m.gsnpoint.com/phone/login.jsp" ;
	//public final static String LOGIN_URL = "http://203.245.106.146:8029/renew/phone/login.jsp";
	//public final static String DATA_CONNECT ="http://m.gsnpoint.com/ServerStart";
	//public final static String DATA_CONNECT = "http://203.245.106.146:8240/renewal/ServerStart"; //개발용ㅇ
	public final static String DATA_CONNECT_HTTPS = "http://192.168.10.51:8240/renewal/ServerStart";
//	public final static String DATA_CONNECT = "http://121.254.215.91:8240/renewal/ServerStart"; //테스트 제출용
//	public final static String DATA_CONNECT = "http://m.gsnpoint.com:8240/renewal/ServerStart"; //실제 운영 서버 쪽
//	public final static String DATA_CONNECT_HTTPS = "https://m.gsnpoint.com:8443/renewal/ServerStart"; //실제 운영 서버 쪽
	public final static String DATA_CONNECT = "http://192.168.10.51:8240/renewal/ServerStart";
//	public final static String DATA_CONNECT = "http://m.gsnpoint.com:8240/renewal/ServerStart";

	//public final static String DATA_CONNECT = "http://203.245.106.98:8240/renewal/ServerStart";
	//public final static String DATA_CONNECT_CARDTAB = "http://m.gsmpp.com/ServiceGSC/MainProduct"; //테스트 제출용 이벤트, 쇼핑, 
//	public final static String DATA_CONNECT_CARDTAB = "http://m.gsmpp.com/ServiceGSC/MainProduct"; //테스트 제출용 이벤트, 쇼핑, 
	public final static String DATA_CONNECT_CARDTAB = "http://192.168.10.51:8240/renewal/ServerStart?process_code=mainProductInfo"; //테스트 제출용 이벤트, 쇼핑, 
	
//	public final static String DATA_CONNECT = "http://192.168.135.1:8240/renewal/ServerStart";
//	public final static String DATA_CONNECT = "http://203.245.106.146:8240/renewal/ServerStart";
	//public final static String DATA_CONNECT = "http://192.168.171.1:9010/renew/ServerStart";
	//public final static String DATA_CONNECT ="http://121.254.215.107/ServerStart";
	public final static String CARD_MORE ="http://www.kixx.co.kr/GSnPoint/GSnPoint_CreditCard.aspx?GSProId=GSnPoint_CreditCard";
	public final static String FIRST_MAP_VRN="10002";
	//public final static String STORE_DETAIL_URL="http://m.gsnpoint.com/phone/store/store_detail.jsp" ;
	//public final static String CARD_MANAGE_URL="http://m.gsnpoint.com/phone/mobilecard/cardManage.jsp" ;

		
	/**셀프 */
	public final static String BUSI_CD_1 = "20000";
	/**주유/충전 */
	public final static String BUSI_CD_2 = "10000";
	/** GS25 */
	public final static String BUSI_CD_3 = "30000";
	/**기타 */
	public final static String BUSI_CD_4 = "90000";
	/**전부 검색 */
	public final static String BUSI_CD_ALL = "5";
	
	
	/**제휴신용카드 */
	public final static String CARD_KIND_1 = "03";
	/**GS칼텍스 */
	public final static String CARD_KIND_2 = "04";
	/**GS SHOP */
	public final static String CARD_KIND_3 = "05";
	/**GS 넥스트 스테이션 */
	public final static String CARD_KIND_4 = "06";
	
	/**회원가입-MEMBER */
	public final static String FAQ_MEMBER="J";
	/**포인트-POINT*/
	public final static String FAQ_POINT="P";
	/**카드-CARD */
	public final static String FAQ_CARD="C";
	/**모바일-MOBILE */
	public final static String FAQ_MOBILE="M";
	
	public final static String[] imgsStr = {
		"1004",
		"1200",
		"1600",
		"2800",		
		"2900",
		"3000",
		"3100",
		"3200",
		"3300",
		"3400",
		"3500",
		"5100",
		"5110",
		"5160",
		"5200",
		"5260",
		"5261",
		"5263",
		"5264",
		"5300",
		"5310",
		"5400",
		"5500",
		"5510",
		"5600",
		"5660",
		"5700",
		"5800",
		"5810",
		"5900",
		"6200",
		"6300",
		"6400",
		"7100",
		"7110",
		"7120",
		"8100",
		"8110",
		"9100",
		"9110",
		"9150",
		"9300",
		"9999"
	};
/*
	public final static Integer[] imgs = {
		R.drawable.card_1004,
		R.drawable.card_1200,
		R.drawable.card_partner,
		R.drawable.card_bonus,
		0,
		R.drawable.card_bonus,
		R.drawable.card_3100,
		R.drawable.card_3200,
		R.drawable.card_3300,
		R.drawable.card_3400,
		R.drawable.card_partner,
		R.drawable.card_partner,
		R.drawable.card_partner,
		R.drawable.card_partner,
		R.drawable.card_partner,
		R.drawable.card_partner,
		R.drawable.card_partner,
		R.drawable.card_partner,
		R.drawable.card_partner,
		R.drawable.card_partner,
		R.drawable.card_partner,
		R.drawable.card_partner,
		R.drawable.card_partner,
		R.drawable.card_partner,
		R.drawable.card_partner,
		R.drawable.card_partner,
		R.drawable.card_partner,
		R.drawable.card_partner,
		R.drawable.card_partner,
		R.drawable.card_partner,
		R.drawable.card_partner,
		R.drawable.card_partner,
		R.drawable.card_partner,
		R.drawable.card_7100,
		0,
		R.drawable.card_partner,
		0,
		R.drawable.card_8110,
		0,
		R.drawable.card_9110,
		R.drawable.card_partner,
		R.drawable.card_bonus,
		0
	};
	
	public final static Integer[] imgs_back = {
		R.drawable.card_1004_back,
		R.drawable.card_1200_back,
		R.drawable.card_partner_back,
		R.drawable.card_bonus_back,
		0,
		R.drawable.card_bonus_back,
		R.drawable.card_3100_back,
		R.drawable.card_3200_back,
		R.drawable.card_3300_back,
		R.drawable.card_3400_back,
		R.drawable.card_partner_back,
		R.drawable.card_partner_back,
		R.drawable.card_partner_back,
		R.drawable.card_partner_back,
		R.drawable.card_partner_back,
		R.drawable.card_partner_back,
		R.drawable.card_partner_back,
		R.drawable.card_partner_back,
		R.drawable.card_partner_back,
		R.drawable.card_partner_back,
		R.drawable.card_partner_back,
		R.drawable.card_partner_back,
		R.drawable.card_partner_back,
		R.drawable.card_partner_back,
		R.drawable.card_partner_back,
		R.drawable.card_partner_back,
		R.drawable.card_partner_back,
		R.drawable.card_partner_back,
		R.drawable.card_partner_back,
		R.drawable.card_partner_back,
		R.drawable.card_partner_back,
		R.drawable.card_partner_back,
		R.drawable.card_partner_back,
		R.drawable.card_7100_back,
		0,
		R.drawable.card_partner_back,
		0,
		R.drawable.card_8110_back,
		0,
		R.drawable.card_9110_back,
		R.drawable.card_partner_back,
		R.drawable.card_bonus_back,
		0
	};
*/
	public static void programExit(Activity activity){
		int sdkVersion = Integer.parseInt(android.os.Build.VERSION.SDK);
		try{
			/*if( sdkVersion < 8 ){
				//android 2.1일경우
				android.app.ActivityManager am = 
					(android.app.ActivityManager) activity.getSystemService(android.content.Context.ACTIVITY_SERVICE);
				am.restartPackage(activity.getPackageName());
			}else{*/
				DefaultApplication app = (DefaultApplication)activity.getApplication();
				app.init();
				GSActivityManager.getActivityManager().finishAllActivity(activity);
			//}
		}catch(Exception ex){
			ex.printStackTrace();
		}
	}
	
	public static String getValidString(String str){
		if( str == null || str.length() == 0 ){
			return "정보없음";
		}
		
		return new String(str);
	}
}