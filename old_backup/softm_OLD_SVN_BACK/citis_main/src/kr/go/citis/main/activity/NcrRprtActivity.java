package kr.go.citis.main.activity;

import java.io.File;

import kr.go.citis.lib.Constant;
import kr.go.citis.lib.TitleView.OnTopClickListner;
import kr.go.citis.lib.Util;
import kr.go.citis.lib.common.AsyncHttp;
import kr.go.citis.lib.common.AsyncHttpParam;
import kr.go.citis.lib.common.CallBack;
import kr.go.citis.lib.type.ActRsltType;
import kr.go.citis.lib.type.RsltStatus;
import kr.go.citis.main.BasicActivity;
import kr.go.citis.main.R;
import kr.go.citis.main.common.WUtil;
import kr.go.citis.main.dto.NcrRprtDtlDTO;
import kr.go.citis.main.dto.in.NcrRprtDtlDTOIn;
import kr.go.citis.main.dto.out.NcrRprtDtlDTOOut;

import org.apache.commons.lang3.StringUtils;

import android.app.DownloadManager;
import android.app.DownloadManager.Query;
import android.content.ActivityNotFoundException;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.IntentFilter;
import android.database.Cursor;
import android.net.Uri;
import android.os.Bundle;
import android.view.View;
import android.webkit.MimeTypeMap;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import butterknife.Bind;
import butterknife.OnClick;

import com.bumptech.glide.Glide;
import com.google.gson.Gson;

/**
 * @author softm
 * NcrRprtActivity
 * 부적합 보고서
 */
public class NcrRprtActivity extends BasicActivity implements OnTopClickListner {
    public static final String TAG = Constant.LOG_TAG;

    @Bind(R.id.et_ispn_rqsts_no    ) EditText  etIspnRqstsNo   ; // 검측요청서번호                            
    @Bind(R.id.et_rprt_no          ) EditText  etRprtNo        ; // 보고서번호                              
    @Bind(R.id.et_dtlcnsttype_nm   ) EditText  etDtlcnsttypeNm ; // 전체공종명-세부공종명[공종]                    
    @Bind(R.id.et_iss_dt           ) EditText  etIssDt         ; // 발행일자                               
    @Bind(R.id.et_title            ) EditText  etTitle         ; // 제목                                 
    @Bind(R.id.et_act_dl           ) EditText  etActDl         ; // 조치기한                               
    @Bind(R.id.et_ncr_dtls         ) EditText  etNcrDtls       ; // 부적합내용                              
    @Bind(R.id.img_ncr_img_url     ) ImageView imgNcrImgUrl    ; // 부적합내용 이미지                          
    @Bind(R.id.tv_chrg_sprv        ) TextView  tvChrgSprv      ; // 담당감리원                              
    @Bind(R.id.tv_rspn_sprv        ) TextView  tvRspnSprv      ; // 책임감리원                              
    @Bind(R.id.chk_act_rslt_1      ) CheckBox  chkActRslt1     ; // 조치결과 :재작업(1)                               
    @Bind(R.id.chk_act_rslt_2      ) CheckBox  chkActRslt2     ; // 조치결과 :폐기(2)
    @Bind(R.id.chk_act_rslt_3      ) CheckBox  chkActRslt3     ; // 조치결과 :수리(3)
    @Bind(R.id.chk_act_rslt_4      ) CheckBox  chkActRslt4     ; // 조치결과 :특채(4)
    @Bind(R.id.chk_act_rslt_5      ) CheckBox  chkActRslt5     ; // 조치결과 :기타(5)
    @Bind(R.id.img_act_rslt_img_url) ImageView imgActRsltImgUrl; // 조치결과 이미지                           
    @Bind(R.id.et_act_dtls         ) TextView  etActDtls       ; // 조치결과 내용                            
    @Bind(R.id.tv_act_rspn         ) TextView  tvActRspn       ; // 조치책임자                              
    @Bind(R.id.tv_site_mngr        ) TextView  tvSiteMngr      ; // 현장소장                               

    @Bind(R.id.chk_act_rslt_chk_t  ) CheckBox  chkActRsltChkT  ; // 조치결과확인 : 적합(T)
    @Bind(R.id.chk_act_rslt_chk_f  ) CheckBox  chkActRsltChkF  ; // 조치결과확인 : 부적합(F) 
    
    @Bind(R.id.btn_save)    Button btnSave;
    @Bind(R.id.btn_end )    Button btnEnd ;

    public String pRprtSeq ; // 보고서 일련번호
    public String pRprtType; // 보고서 구분

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        init(new CallBack() {
            @Override
            public void complete(Object object) {
                detail();
                downloadManager = (DownloadManager)getSystemService(Context.DOWNLOAD_SERVICE);        
            }
        });
    }

    private void init(final CallBack cb) {
        Intent i = this.getIntent();
        pRprtSeq = StringUtils.defaultString(i.getStringExtra("rprt_seq" )); // 보고서 일련번호
        pRprtType= StringUtils.defaultString(i.getStringExtra("rprt_type")); // 보고서 구분
//        pRprtSeq = "1"; // 보고서 일련번호
//        pRprtType= RprtType.NCR.getTypeCd(); // 보고서 구분        
        if (
                StringUtils.isEmpty(pRprtSeq) && StringUtils.isEmpty(pRprtType) 
        ) {
            alert(R.string.msg_not_exec_alert
                    , new DialogInterface.OnClickListener() {
                        public void onClick(DialogInterface dialog, int whichButton) {
                            finish();
                        }
                    }
            );
        }
        loast("pRprtSeq / pRprtType : " + pRprtSeq + " / " + pRprtType);
        Util.d("pRprtSeq / pRprtType : " + pRprtSeq + " / " + pRprtType);
        
	    setLayout(R.layout.activity_ncr_rprt);
	    setTopTitle(R.string.title_ncr_rprt);
	    
		setDisabled(etIspnRqstsNo  );
		setDisabled(etRprtNo       );
		setDisabled(etDtlcnsttypeNm);
		setDisabled(etIssDt        );
		setDisabled(etTitle        );
		setDisabled(etActDl        );
		setDisabled(etNcrDtls      );
		setDisabled(etActDtls      );
		
		setDisabled(chkActRslt1);
		setDisabled(chkActRslt2);
		setDisabled(chkActRslt3);
		setDisabled(chkActRslt4);
		setDisabled(chkActRslt5);
		
		setDisabled(chkActRsltChkT ); // 조치결과확인 : 적합(T) 
		setDisabled(chkActRsltChkF ); // 조치결과확인 : 부적합(F)
        try {
            cb.complete(null);
        } catch (Exception e) {
            e.printStackTrace();
        }
//    	Glide.with(NcrRprtActivity.this).load("http://118.220.189.69:8011/citis/citis.inspection.MobileCheckCMD.cals?service=ncrRprtFileDownload&pRprtSeq=1&pFileAsr=RQSTS").into(imgNcrImgUrl); 
//    	Glide.with(NcrRprtActivity.this).load("http://www.citis.go.kr/data/inspection/rprtncr/C2013901/20160121/Hydrangeas.jpg").into(imgNcrImgUrl); 
//    	Glide.with(NcrRprtActivity.this).load("http://www.selphone.co.kr/homepage/img/team/3.jpg").into(imgActRsltImgUrl);                     	
    }

    private void detail() {
        String inParams = "";
        NcrRprtDtlDTOIn in = new NcrRprtDtlDTOIn();
	        NcrRprtDtlDTO data = new NcrRprtDtlDTO();
	        data.setpRprtSeq (pRprtSeq );
	        data.setpRprtType(pRprtType);
        in.setData(data);
        Gson gson = new Gson();
        inParams = gson.toJson(in);
        String servcie = "ncrRprtDtl"; // ncrRprtDtl	ncr_rprt_dtl

        Util.i(" detail[" +servcie+"] in param json : " + inParams);
        new AsyncHttp<NcrRprtDtlDTOOut,NcrRprtDtlDTOOut>(this) {
//            private NcrRprtDtlDTOOut result;
            @Override
            public void complete(NcrRprtDtlDTOOut result) {
                Util.i(result.getClass().getName() +" result : " + result);
                try {
                    NcrRprtActivity.this.stopProgressBar();
                    NcrRprtDtlDTO data = result.getData();
                    if ( data != null ) {
                    	setText(etIspnRqstsNo  , data.getIspnRqstsNo  ()); // 검측요청서번호                                                 
                    	setText(etRprtNo       , data.getRprtNo       ()); // 보고서번호                                                   
                    	setText(etDtlcnsttypeNm, data.getDtlcnsttypeNm()); // 전체공종명-세부공종명[공종]                                         
                    	setText(etIssDt        , WUtil.toDateFormat(data.getIssDt        ())); // 발행일자                                                    
                    	setText(etTitle        , data.getTitle        ()); // 제목                                                      
                    	setText(etActDl        , WUtil.toDateFormat(data.getActDl        ())); // 조치기한                                                    
                    	setText(etNcrDtls      , data.getNcrDtls      ()); // 부적합내용
//                    	http://118.220.189.69:8011/citis/citis.inspection.MobileCheckCMD.cals?service=ncrRprtFileDownload&pRprtSeq=1&pFileAsr=RQSTS
                    	data.setNcrImgUrl(java.net.URLDecoder.decode(data.getNcrImgUrl(),"UTF-8"));
                    	Glide.with(NcrRprtActivity.this).load(data.getNcrImgUrl()).into(imgNcrImgUrl); // 부적합내용 이미지
                    	setText(tvChrgSprv     , data.getChrgSprv     ()); // 담당감리원                                                   
                    	setText(tvRspnSprv     , data.getRspnSprv     ()); // 책임감리원
                    	
                    	// 조치결과     :     재작업 :1,폐기:2,수리:,특채:4,기타:5
                    	if ( ActRsltType.TYPE1.getTypeCd().equals(data.getActRslt()) ) {
                    		chkActRslt1.setChecked(Boolean.TRUE);
                    	} else if ( ActRsltType.TYPE2.getTypeCd().equals(data.getActRslt ()) ) {
                    		chkActRslt2.setChecked(Boolean.TRUE);                    		
                    	} else if ( ActRsltType.TYPE3.getTypeCd().equals(data.getActRslt ()) ) {
                    		chkActRslt3.setChecked(Boolean.TRUE);                    		
                    	} else if ( ActRsltType.TYPE4.getTypeCd().equals(data.getActRslt ()) ) {
                    		chkActRslt4.setChecked(Boolean.TRUE);                    		
                    	} else if ( ActRsltType.TYPE5.getTypeCd().equals(data.getActRslt ()) ) {
                    		chkActRslt5.setChecked(Boolean.TRUE);                    		
                    	}
                    	data.setActRsltImgUrl(java.net.URLDecoder.decode(data.getActRsltImgUrl(),"UTF-8"));
                    	Glide.with(NcrRprtActivity.this).load(data.getActRsltImgUrl()).into(imgActRsltImgUrl); // 조치결과 이미지
                    	setText(etActDtls       , data.getActDtls      ()); // 조치결과 내용
                    	setText(tvActRspn       , data.getActRspn      ()); // 조치책임자
                    	setText(tvSiteMngr      , data.getSiteMngr     ()); // 현장소장
                    	if ( RsltStatus.TRUE.getTypeCd().equals(data.getActRsltChk ()) ) { // 조치결과확인
                    		chkActRsltChkT.setChecked(Boolean.TRUE);
                    	} else if ( RsltStatus.FALSE.getTypeCd().equals(data.getActRsltChk ()) ) {
                    		chkActRsltChkF.setChecked(Boolean.TRUE);                    		
                    	}
                    	mData = data;
                    }
                } catch (Exception e) {
                    e.printStackTrace();
                }
            }
            @Override
            public void callback(NcrRprtDtlDTOOut result) {
//                this.result = result;
//              TestChkMainActivity.this.alert("끝나면 실행한다.");
            }
        }.sync(new AsyncHttpParam(Constant.SERVER_CHECK_URL,inParams,servcie));
    }
	private DownloadManager downloadManager;
	private DownloadManager.Request request;
	NcrRprtDtlDTO mData = new NcrRprtDtlDTO(); 	
	private Uri urlToDownload;
	private long latestId = -1;
	String mFileName;
	private BroadcastReceiver completeReceiver = new BroadcastReceiver(){
		@Override
		public void onReceive(Context context, Intent intent) {
			
            String action = intent.getAction();
            
            if (DownloadManager.ACTION_NOTIFICATION_CLICKED.equals(action)) {

//                long downloadId = intent.getLongExtra(DownloadManager.EXTRA_DOWNLOAD_ID, 0);
//                DownloadManager dm =(DownloadManager)context.getSystemService(Context.DOWNLOAD_SERVICE);             
//                dm.remove(downloadId);
            }
            
            if (DownloadManager.ACTION_DOWNLOAD_COMPLETE.equals(action)) {
//    	        startActivity(new Intent(DownloadManager.ACTION_VIEW_DOWNLOADS));
                Query query = new Query();
                query.setFilterById(latestId);
                Cursor c = downloadManager.query(query);
                if (c.moveToFirst()) {
                    int columnIndex = c
                            .getColumnIndex(DownloadManager.COLUMN_STATUS);
                    if (DownloadManager.STATUS_SUCCESSFUL == c.getInt(columnIndex)) {

//                        ImageView view = (ImageView) findViewById(R.id.imageView1);
                        String uriString = c
                                .getString(c
                                        .getColumnIndex(DownloadManager.COLUMN_LOCAL_URI));
//                        view.setImageURI(Uri.parse(uriString));
                        String localUrl = Constant.TMP_DIR+File.separator+mFileName;
                        File file = new File(localUrl);
                        Uri destinationUri = Uri.fromFile(file);
                        String extension = MimeTypeMap.getFileExtensionFromUrl(destinationUri.toString());
                        String mimeType = MimeTypeMap.getSingleton().getMimeTypeFromExtension(extension);
                        
                        Intent intent1 = new Intent(Intent.ACTION_VIEW); 		    
                        intent1.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                        intent1.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
//    		        intent1.setDataAndType(destinationUri, mimeType);
                        intent1.setDataAndType(Uri.parse(uriString), mimeType);
                        
//    		        loast(file.toString() + " / " + mimeType);
                        try {
                        	startActivity(intent1);
                        } catch (ActivityNotFoundException e) {
                        	toast("Not found. Cannot open file.");
                        	e.printStackTrace();
                        }
                    }
    	            stopProgressBar();                    
                }
            }

		}

	};	
    @OnClick({R.id.img_ncr_img_url, R.id.img_act_rslt_img_url})
    protected void onClick(View v) {
        final int viewID = v.getId();
//        mData.setActRsltImgUrl("http://118.220.189.69:8011/citis/citis.inspection.MobileCheckCMD.cals?service=ncrRprtFileDownload&pRprtSeq=1&pFileAsr=RQSTS");
        if ( viewID == R.id.img_ncr_img_url ) { // 부적합내용 이미지
        	if ( StringUtils.isNotEmpty(mData.getNcrImgFileName()) ) {        	
	        	startProgressBar();
	                runOnUiThread(new Runnable() {
	                    public void run() {
	                  	  try {
	//                 		  mFileName = java.net.URLEncoder.encode("한글.jpg","UTF-8");
//	                 		  mFileName = "한글.jpg";
//----------------------------------------------
	                 		  mFileName = mData.getNcrImgFileName();   
	                  		  WUtil.deleteFiles(Constant.TMP_DIR, mFileName);
	                      	urlToDownload = Uri.parse(mData.getNcrImgUrl());
	//                    	List<String> pathSegments = urlToDownload.getPathSegments();
	                    	request = new DownloadManager.Request(urlToDownload);
	//                    	request.setNotificationVisibility(DownloadManager.Request.VISIBILITY_VISIBLE_NOTIFY_COMPLETED);
//	                    	request.setNotificationVisibility(DownloadManager.Request.VISIBILITY_VISIBLE_NOTIFY_ONLY_COMPLETION);
	                    	request.setVisibleInDownloadsUi(false);
	//                		request.setVisibleInDownloadsUi(true);
	                    	request.setTitle(StringUtils.isNotEmpty(mData.getTitle())?mData.getTitle():"Download");
	                    	request.setDescription(StringUtils.isNotEmpty(mData.getTitle())?mData.getTitle():"Download");
	                    	 File file = new File(Constant.TMP_DIR+File.separator+mFileName);
	                    	 Uri destinationUri = Uri.fromFile(file);
	                        request.setDestinationUri(destinationUri);
	                    	latestId = downloadManager.enqueue(request); 
	                  	  } catch (Exception e) {
	                  		  e.printStackTrace();
	                  	  }	            		
	                    }
	                }); 
        	}
        } else if ( viewID == R.id.img_act_rslt_img_url ) {
        	if ( StringUtils.isNotEmpty(mData.getActRsltImgFileName()) ) {
	        	startProgressBar();
	            runOnUiThread(new Runnable() {
	                public void run() {
	              	  try {
	//             		  mFileName = java.net.URLEncoder.encode("한글.jpg","UTF-8");
	//             		  mFileName = "한글.jpg";
	             		  mFileName = mData.getActRsltImgFileName();
	              		  WUtil.deleteFiles(Constant.TMP_DIR, mFileName);
	                  	urlToDownload = Uri.parse(mData.getActRsltImgUrl());
//	                	List<String> pathSegments = urlToDownload.getPathSegments();
	                	request = new DownloadManager.Request(urlToDownload);
	//                	request.setNotificationVisibility(DownloadManager.Request.VISIBILITY_VISIBLE_NOTIFY_COMPLETED);
	                	request.setNotificationVisibility(DownloadManager.Request.VISIBILITY_VISIBLE_NOTIFY_ONLY_COMPLETION);
	//                	request.setVisibleInDownloadsUi(false);
	//            		request.setVisibleInDownloadsUi(true);
	                	request.setTitle(StringUtils.isNotEmpty(mData.getTitle())?mData.getTitle():"Download");
	                	request.setDescription(StringUtils.isNotEmpty(mData.getTitle())?mData.getTitle():"Download");
	                	 File file = new File(Constant.TMP_DIR+File.separator+mFileName);
	                	 Uri destinationUri = Uri.fromFile(file);
	                    request.setDestinationUri(destinationUri);
	                	latestId = downloadManager.enqueue(request); 
	              	  } catch (Exception e) {
	              		  e.printStackTrace();
	              	  }	            		
	                }
	            });          	
        	}
        }
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
    }

    @Override
    public void onBackPressed() {
        finish();
    }

    /**
     * Top상단 메인 버튼 클릭
     * @param v
     */
    @Override
    public void onClickMainButton(View v) {
        WUtil.goMain(this);
    }

    /**
     * Top상단 첫번째 버튼 클릭
     */
    @Override
    public void onClickOneButton(View v) {
        onBackPressed();
    }

    /**
     * Top상단 두번째 버튼 클릭
     */
    @Override
    public void onClickTwoButton(View v) {
        View anchor = (View) findViewById( R.id.et_search );
        showMenu(anchor, R.menu.main);
//          showMenu(v, R.menu.main);
    }

    @Override
    protected void onPause() {
        super.onPause();
//      AppContext.putValue("et_search", getValue(R.id.et_search));
		unregisterReceiver(completeReceiver);        
        
    }

    @Override
    protected void onResume() {
        super.onResume();
//      setText(R.id.et_search,AppContext.getValue("et_search").toString());
		IntentFilter completeFilter1 = new IntentFilter(DownloadManager.ACTION_DOWNLOAD_COMPLETE);
		registerReceiver(completeReceiver, completeFilter1);   
		IntentFilter completeFilter2 = new IntentFilter(DownloadManager.ACTION_NOTIFICATION_CLICKED);
		registerReceiver(completeReceiver, completeFilter2);
    }
}


