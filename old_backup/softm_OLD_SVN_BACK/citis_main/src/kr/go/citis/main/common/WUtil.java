package kr.go.citis.main.common;

import java.io.File;
import java.io.FileFilter;
import java.io.IOException;
import java.text.DecimalFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import kr.go.citis.lib.BaseActivity;
import kr.go.citis.lib.Constant;
import kr.go.citis.lib.Util;
import kr.go.citis.lib.common.Pref;
import kr.go.citis.lib.type.RprtType;
import kr.go.citis.main.activity.BldChkupWrtActivity;
import kr.go.citis.main.activity.LoginActivity;
import kr.go.citis.main.activity.MainActivity;
import kr.go.citis.main.activity.NcrRprtActivity;
import kr.go.citis.main.activity.PhotoMngDtlActivity;
import kr.go.citis.main.activity.TestChkListActivity;
import kr.go.citis.main.activity.TestChkMainActivity;
import kr.go.citis.main.activity.TestReqDocActivity;
import kr.go.citis.main.activity.TestRsltNotiActivity;
import kr.go.citis.main.activity.TestRsltRegActivity;

import org.apache.commons.io.filefilter.WildcardFileFilter;
import org.apache.commons.lang3.StringUtils;

import android.annotation.SuppressLint;
import android.content.Context;
import android.content.Intent;
import android.net.Uri;
import android.webkit.MimeTypeMap;

import com.squareup.okhttp.Callback;
import com.squareup.okhttp.MediaType;
import com.squareup.okhttp.MultipartBuilder;
import com.squareup.okhttp.OkHttpClient;
import com.squareup.okhttp.Request;
import com.squareup.okhttp.RequestBody;
import com.squareup.okhttp.Response;

/**
 * WUtil
 * @author softm
 */
public class WUtil {
	public static void goMain(Context context) {
	    Intent i = new Intent(context,MainActivity.class); // 메인
	    i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP|Intent.FLAG_ACTIVITY_SINGLE_TOP);                            	    
	    context.startActivity(i);
	}
	
	/**
	 * 검측체크 메인
	 * @param context
	 * @param saveType
	 */
	public static void goTestChkMain(Context context, int saveType) {
		BaseActivity activity = (BaseActivity)context;
		Intent i = new Intent(activity,TestChkMainActivity.class); // 검측체크 메인
	    i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP|Intent.FLAG_ACTIVITY_SINGLE_TOP);		
		activity.setResult(saveType, i);
		activity.finish();
	}
	
	/**
	 * 시공사점검 작성
	 * @param context
	 * @param wMode
	 * @param pSiteNo
	 */
	public static void goBldChkupWrt(Context context, String wMode, String pSiteNo) {
		goBldChkupWrt(context,wMode,pSiteNo,"","");
	}

	/**
	 * 시공사점검 작성 - 상세보기
	 * @param context
	 * @param wMode
	 * @param pSiteNo
	 * @param pIspnChkMgntSeq
	 * @param ispnChkSeq
	 */
	public static void goBldChkupWrt(Context context, String wMode, String pSiteNo, String pIspnChkMgntSeq,String ispnChkSeq) {
		BaseActivity activity = (BaseActivity)context;
		Intent i = new Intent(activity,BldChkupWrtActivity.class); // 시공사점검 작성
		i.putExtra("w_mode", wMode); // W/RW 작상/재작성    			
		i.putExtra("site_no"          , pSiteNo        ); // 담당현장
		i.putExtra("ispn_chk_mgnt_seq", pIspnChkMgntSeq); // 검측마스터번호
		i.putExtra("ispn_chk_seq"     , ispnChkSeq     ); // 검측체크번호
		
		int proc = -1;
		if ( WConstant.WRITE_MODE_FISRT.equals(wMode) ) {
			proc = WConstant.PROC_ID_BLD_CHKUP_WRT_FIRST;
		} else if ( WConstant.WRITE_MODE_SECOND.equals(wMode) ) {
			proc = WConstant.PROC_ID_BLD_CHKUP_WRT_SECOND;
		} else if ( WConstant.WRITE_MODE_UPDATE.equals(wMode) ) {
			proc = WConstant.PROC_ID_BLD_CHKUP_WRT_VIEW;
		}
		activity.startActivityForResult(i,proc);
	}

	/**
	 * 검측체크 목록
	 * @param context
	 * @param pIspnChkMgntSeq 검측마스터번호
	 */
	public static void goTestChkList(Context context, String pIspnChkMgntSeq) {
		BaseActivity activity = (BaseActivity)context;
		Intent i = new Intent(activity,TestChkListActivity.class); // 검측체크 목록
		i.putExtra("ispn_chk_mgnt_seq", pIspnChkMgntSeq); // 검측마스터번호
		activity.startActivityForResult(i,WConstant.PROC_ID_TEST_CHK_LIST);
	}
	
	/**
	 * 검측체크 목록 [복귀]
	 * @param context
	 * @param pIspnChkMgntSeq 검측마스터번호
	 */
	public static void retrunTestChkList(Context context, String pIspnChkMgntSeq,int saveType) {
		BaseActivity activity = (BaseActivity)context;
		Intent i = new Intent(activity,TestChkListActivity.class); // 검측체크 목록		
	    i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP|Intent.FLAG_ACTIVITY_SINGLE_TOP);		
		activity.setResult(saveType, i);
		activity.finish();
	}
	
	/**
	 * 검측요청서
	 * @param context
	 * @param pIspnChkMgntSeq 검측마스터번호
	 */
	public static void goTestReqDoc(Context context, String pIspnChkMgntSeq) {
		BaseActivity activity = (BaseActivity)context;
		Intent i = new Intent(activity,TestReqDocActivity.class); // 검측요청서
		i.putExtra("ispn_chk_mgnt_seq", pIspnChkMgntSeq); // 검측마스터번호
		activity.startActivityForResult(i,WConstant.PROC_ID_TEST_REQ_DOC_DTL);
	}

	/**
	 * 검측 결과 등록
	 * @param context
	 * @param pSiteNo
	 * @param pIspnChkMgntSeq
	 * @param ispnChkSeq
	 */
	public static void goTestRsltReg(Context context, String pSiteNo, String pIspnChkMgntSeq,String ispnChkSeq) {
		BaseActivity activity = (BaseActivity)context;
		Intent i = new Intent(activity,TestRsltRegActivity.class); // 검측결과등록.
		i.putExtra("site_no"          , pSiteNo        ); // 담당현장
		i.putExtra("ispn_chk_mgnt_seq", pIspnChkMgntSeq); // 검측마스터번호
		i.putExtra("ispn_chk_seq"     , ispnChkSeq     ); // 검측체크번호
		activity.startActivityForResult(i,WConstant.PROC_ID_TEST_RSLT_WRT_LIST);
	}

	/**
	 * 검측 결과 통보
	 * @param context
	 * @param pIspnChkMgntSeq
	 * @param ispnChkSeq
	 */
	public static void goTestRsltNoti(Context context, String pIspnChkMgntSeq,String ispnChkSeq) {
		BaseActivity activity = (BaseActivity)context;
		Intent i = new Intent(activity,TestRsltNotiActivity.class); // 검측결과통보.
		i.putExtra("ispn_chk_mgnt_seq", pIspnChkMgntSeq); // 검측마스터번호
		i.putExtra("ispn_chk_seq"     , ispnChkSeq     ); // 검측체크번호
		activity.startActivityForResult(i,WConstant.PROC_ID_TEST_RSLT_NOTI_DTL);
	}
	/**
	 * 부적합 보고서
	 * @param context
	 * @param pRprtSeq
	 * @param pRprtType
	 */
	public static void goNcrRprt(Context context, String pRprtSeq) {
		BaseActivity activity = (BaseActivity)context;
		Intent i = new Intent(activity,NcrRprtActivity.class); // 부적합 보고서.
		i.putExtra("rprt_seq" , pRprtSeq ); // 보고서 일련번호
		i.putExtra("rprt_type", RprtType.NCR.getTypeCd()); // 보고서 구분
		activity.startActivityForResult(i,WConstant.PROC_ID_NCR_RPRT);
	}

	/**
	 * 시정조치 보고서
	 * @param context
	 * @param pRprtSeq
	 * @param pRprtType
	 */
	public static void goCarRprt(Context context, String pRprtSeq) {
		BaseActivity activity = (BaseActivity)context;
		Intent i = new Intent(activity,NcrRprtActivity.class); // 시정조치 보고서.
		i.putExtra("rprt_seq" , pRprtSeq ); // 보고서 일련번호
		i.putExtra("rprt_type", RprtType.CAR.getTypeCd()); // 보고서 구분
		activity.startActivityForResult(i,WConstant.PROC_ID_CAR_RPRT);
	}
	
	/**
	 * 사진관리 - 사진촬영.(사진상세)
	 * @param context
	 * @param wMode
	 * @param pSiteNo
	 * @param pCnstrphtSeq
	 */
	public static void goPhotoMngDtl(Context context, String wMode, String pSiteNo, String pCnstrphtSeq) {
		BaseActivity activity = (BaseActivity)context;
		Intent i = new Intent(activity,PhotoMngDtlActivity.class); // 사진관리
		i.putExtra("w_mode"       , wMode); // W/U 작성/수정
		i.putExtra("site_no"      , pSiteNo      ); // 담당현장
		i.putExtra("cnstrpht_seq" , pCnstrphtSeq ); // 공사사진일련번호
		
		int proc = -1;
		if ( WConstant.WRITE_MODE_FISRT.equals(wMode) ) {
			proc = WConstant.PROC_ID_PHOTO_MNG_WRT_FIRST;
		} else if ( WConstant.WRITE_MODE_UPDATE.equals(wMode) ) {
			proc = WConstant.PROC_ID_PHOTO_MNG_WRT_UPDATE;
		}
		activity.startActivityForResult(i,proc);
		
	}
/// /// /// /// /// /// /// /// /// /// /// /// /// /// /// /// /// /// /// /// /// ///  
	public static String numberFormat(String pattern, String value) {
		int v = Integer.parseInt(StringUtils.defaultString(value, "0"), 10);
		return numberFormat(pattern, v);
	}
	
	@SuppressLint("SimpleDateFormat")
	public static String toDateFormat(String v) {
		String rtn = "";
		if ( StringUtils.isNotEmpty(v) ) {
			v = v.replaceAll("[^0-9]", "");
//			System.out.println(v);
			SimpleDateFormat pm = new SimpleDateFormat("yyyyMMdd");
			SimpleDateFormat sm = new SimpleDateFormat("yyyy-MM-dd");
			try {
				Date vd = pm.parse(v);
				rtn = sm.format(vd);			
			} catch (ParseException e) {
				e.printStackTrace();
			}
//			System.out.println(rtn);
		} else {
		}
		return rtn;
	}
	
	public static String numberFormat(String pattern, int value) {
		DecimalFormat myFormatter = new DecimalFormat(pattern);
		String output = myFormatter.format(value);
		return output;
	}

	public static boolean isValidPhoneNumber(String phoneNumber) {
		boolean returnValue = false;
		String regex = "^\\s*(02|031|032|033|041|042|043|051|052|053|054|055|061|062|063|064|070)?(-|\\)|\\s)*(\\d{3,4})(-|\\s)*(\\d{4})\\s*$";
		Pattern p = Pattern.compile(regex);
		Matcher m = p.matcher(phoneNumber);
		if (m.matches()) {
			returnValue = true;
		}
		return returnValue;
	}

	public static boolean isValidCellPhoneNumber(String cellphoneNumber) {
		boolean returnValue = false;
		String regex = "^\\s*(010|011|012|013|014|015|016|017|018|019)(-|\\)|\\s)*(\\d{3,4})(-|\\s)*(\\d{4})\\s*$";
		Pattern p = Pattern.compile(regex);
		Matcher m = p.matcher(cellphoneNumber);
		if (m.matches()) {
			returnValue = true;
		}
		return returnValue;

	}

	public static String toDefault(String v) {
		return StringUtils.isEmpty(v)?"":v;
	}
	
	public static String toDefault(String v,String dv) {
		return StringUtils.isEmpty(v)?dv:v;
	}
	
	public static void deleteFiles(final String directoryName, final String wildCard) {
		 File dir = new File(directoryName);
//		 FileFilter fileFilter = new WildcardFileFilter("*test*.java~*~");
		 FileFilter fileFilter = new WildcardFileFilter(wildCard);
		 File[] files = dir.listFiles(fileFilter);
		 if ( files != null ) {
			 for (int i = 0; i < files.length; i++) {
				new File(""+files[i]).delete();		   
			 }
		 }
	}
	
	public static void setEnvironMent(Context context) {
//		if ( Pref.read(context,"isServer", false) ) {
		String server = Pref.read(context,"Server","3");
		if ( "1".equals(server) ) { // 운영
			Constant.SERVER_COMMON_URL= "http://www.citis.go.kr/citis.inspection.MobileCommonCMD.cals"; // 공통 
			Constant.SERVER_CHECK_URL = "http://www.citis.go.kr/citis.inspection.MobileCheckCMD.cals" ; // 검측 
			Constant.SERVER_DATA_URL  = "http://www.citis.go.kr/citis.inspection.MobileDataCMD.cals"  ; // 자료실
//			Constant.SERVER_COMMON_URL= "http://116.67.75.80/common.ReloadCMD.cals"; // 공통 
//			Constant.SERVER_COMMON_URL= "http://116.67.75.80/citis.inspection.MobileCommonCMD.cals"; // 공통 
//			Constant.SERVER_CHECK_URL = "http://116.67.75.80/citis.inspection.MobileCheckCMD.cals" ; // 검측 
//			Constant.SERVER_DATA_URL  = "http://116.67.75.80/citis.inspection.MobileDataCMD.cals"  ; // 자료실
		} else if ( "2".equals(server) ) { // 개발
			Constant.SERVER_COMMON_URL= "http://118.220.189.69:8011/citis/citis.inspection.MobileCommonCMD.cals"; // 공통 
			Constant.SERVER_CHECK_URL = "http://118.220.189.69:8011/citis/citis.inspection.MobileCheckCMD.cals" ; // 검측 
			Constant.SERVER_DATA_URL  = "http://118.220.189.69:8011/citis/citis.inspection.MobileDataCMD.cals"  ; // 자료실
//			Constant.SERVER_COMMON_URL= "http://192.168.0.35:8011/citis/citis.inspection.MobileCommonCMD.cals"; // 공통 
//			Constant.SERVER_CHECK_URL = "http://192.168.0.35:8011/citis/citis.inspection.MobileCheckCMD.cals" ; // 검측 
//			Constant.SERVER_DATA_URL  = "http://192.168.0.35:8011/citis/citis.inspection.MobileDataCMD.cals"  ; // 자료실			
		} else if ( "3".equals(server) ) { // 로컬			
			Constant.SERVER_COMMON_URL= "http://118.220.189.89:8080/rest/test"; // 공통 
			Constant.SERVER_CHECK_URL = "http://118.220.189.89:8080/rest/test"; // 검측 
			Constant.SERVER_DATA_URL  = "http://118.220.189.89:8080/rest/test"; // 자료실
		}
	}

    public static String HttpFileUpload(String urlString, String params, String fileName, final Callback  cb) {
	    try {
	    	OkHttpClient client = new OkHttpClient();	    	
	        File file = new File(Constant.PIC_DIR + File.separator + fileName);
	        
//	        String contentType = file.toURL().openConnection().getContentType();
//	        RequestBody fileBody = RequestBody.create(MediaType.parse(contentType), file);

            Uri destinationUri = Uri.fromFile(file);
            String extension = MimeTypeMap.getFileExtensionFromUrl(destinationUri.toString());
	        String contentType = MimeTypeMap.getSingleton().getMimeTypeFromExtension(extension);
	        RequestBody fileBody = RequestBody.create(MediaType.parse(contentType), file);
	        
	        RequestBody requestBody = new MultipartBuilder()
	                .type(MultipartBuilder.FORM)
	                .addFormDataPart("uploadtype","1")
	                .addFormDataPart("miniType",contentType)
	                .addFormDataPart("ext",file.getAbsolutePath().substring(file.getAbsolutePath().lastIndexOf(".")))
	                .addFormDataPart("typeName","img")
	                .addFormDataPart("uploadfile",fileName,fileBody)
	                .build();
	        final Request request = new Request.Builder()
	                .url(urlString+ "?" + params)
	                .post(requestBody)
	                .build();
			Response response;
//			String str = null;
			try {
//				response = client.newCall(request).execute();
				
		        client.newCall(request).enqueue(new Callback() {
		            @Override
		            public void onResponse(Response response) throws IOException {
						String str = response.body().string();		            	
						Util.i("HttpFileUpload return : " + str);
		                if (!response.isSuccessful()) {
		                    cb.onFailure(request, null);
		                    return;
		                }
		                cb.onResponse(response);
		            }

					@Override
					public void onFailure(Request arg0, IOException arg1) {
	                    cb.onFailure(arg0, arg1);
					}
		        });
		        
//				str = response.body().string();
//				Util.i("HttpFileUpload return : " + str);
			} catch (Exception e) {
				e.printStackTrace();
			}
//			return str;
	    } catch (Exception e) {
	        e.printStackTrace();
	    }
		return null;
    }
    
//TODO 확인[로그아웃]
	public static void logout(Context context) {
	    Intent i = new Intent(context,LoginActivity.class); // 로그인
	    i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP|Intent.FLAG_ACTIVITY_SINGLE_TOP);                            	    
	    context.startActivity(i);
	}
//---------------------------------	
}