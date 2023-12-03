package kr.co.gscaltex.gsnpoint.util;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;

import android.content.Context;
import android.util.Log;

public class FileInfo {
	/*어플리케이션 무결성 검사 유무*/
	public final static String SHA1_CHECK ="sha1_check";
	/**카드 리소스 목록 */
	public static final String CARD_PATTERN_LIST = "card.pattern.list";
	
	/**카드 번호 목록 */
	public static final String CARD_NO_LIST = "card.no.list";
	
	/**카드 CVC 목록 */
	public static final String CARD_CVC_LIST = "card.cvc.list";
	 
	/**고객 번호1 */
	public static final String CUSKEY_1 = "cuskey1";
	
	/**고객 번호2 */
	public static final String CUSKEY_2 = "cuskey2";
	
	/**고객 이름 **/
	public static final String USER_NAME = "userName";
	
	/**OPEN_URL */
	public static final String OPEN_URL = "open.url";
	
	/**POINT_URL */
	public static final String POINT_URL = "point.url";
	
	/**아이디 */
	public static final String ID = "id";
	
	/**SEED 키 */
	public static final String SEED = "seed.key";
	
	/**비번 */
	public static final String PWD = "pwd";
	
	/**자동로그인여부 */
	public static final String AUTO_SAVE = "auto_save";
	
	/**맵버전 */
	public static final String MAP_VER = "map.version";
	
	/**WIFI 체크 */
	public static final String WIFI_CHECK = "wifi.check";
	
	/**로그인 URL */
	public static final String LOGIN_URL = "login.url";
	
	///**모바일카드 등록 URL */
	// public static final String CARD_REG_URL = "card.reg.url";
	
	/**WIFI 체크 두번 다시 보지 않기 */
	public final static String IDONWANTSEEAGAIN = "1";
	
	/**이전에 검색한 시 */
	public final static String BEFORE_CITY = "before.city";
	
	/**이전에 검색한 군구*/
	public final static String BEFORE_COUNTY = "before.county";
	
	/**대표 가맹점 URL*/
	public final static String STORE_URL = "store";
	
	/**가맹점 상세 URL*/
	public final static String STORE_DETAIL_URL = "store.detail";
	
	/**guide URL*/
	public final static String GUIDE_URL = "guide";
	
	/**약관동의 URL*/
	public final static String AGREEMENT_URL = "agreementUrl";
	
	/**사용자 앱 업데이트 URL*/
	public final static String MEMBER_UPDATE_URL = "memberUpdateUrl";
	
	/** 앱 비밀번호 설정 유무*/
	public final static String PASSWORD_SET= "set_pwd";
	
	/** 설정된 앱 비밀번호 (숫자 4자리)*/
	public final static String PASSWORD_MYAPP= "myapp_pwd";
	
	/** 내 이미지 설정 유무*/
	public final static String MYPHOTO_SET = "set_myphoto";
	
	/** 내 이미지 파일 경로*/
	public final static String MYPHOTO_URL = "myphoto.url";
	
	/** 이벤트, 쇼핑, 쿠폰 처리 완료 유무 **/	
	public final static String TABPAGE_COMPLETE = "tabpage_complete";
	
	public static final String DEBUG_TAG = "FileInfo";
	
	public final static String COVERFLOW_LAST_POSITION = "coverflow_last_position" ;
		
	public final static String CARD_NUMBERS = "card_numbers";
	
	public final static String CAN_USE_POINT ="can_use_point";
	public final static String VANISH_POINT ="vanish_point";
	public final static String CAN_GIVE_POINT ="can_give_point";
	public final static String LAST_USE_POINT ="last_use_point";
	public final static String LAST_USE_POINT_ISPLUS ="last_use_point_isplus";
	public final static String LAST_FRANCHSE ="last_franchse";
	public final static String INTEREST_CATEGORY ="interest_category";
	public final static String INTEREST_AREA ="interest_area";
	
	
	
	
	public String getSettingInfo(Context context, String target){
		String tmp = "";
		File file = context.getFileStreamPath(target);
		if(file.exists()){
			try {
				FileInputStream fis = new FileInputStream(file);
				InputStreamReader isReaderEUCKR = new InputStreamReader(fis);
				BufferedReader br = new BufferedReader(isReaderEUCKR);
				String readLine = "";
				 while(((readLine = br.readLine()) != null)) {
					 tmp=readLine.trim();
				 }
			}catch(IOException e){
				Log.e("IOException", e.getMessage(),e);
			}
		}else{
			tmp = "";
		}
		return tmp;
	}
	
	public void setSettingInfo(Context context, String value, String target){
		try {
			FileOutputStream fo =context.openFileOutput(target,Context.MODE_WORLD_WRITEABLE);				
			OutputStreamWriter osw = new OutputStreamWriter(fo);
			osw.write(value);	
			osw.close();
		}catch(IOException e){
			
		}
	}
}
