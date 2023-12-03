package kr.go.citis.main.activity;

import java.io.File;
import java.util.ArrayList;

import kr.go.citis.lib.Constant;
import kr.go.citis.lib.TitleView.OnTopClickListner;
import kr.go.citis.lib.Util;
import kr.go.citis.lib.common.AsyncHttp;
import kr.go.citis.lib.common.AsyncHttpParam;
import kr.go.citis.lib.common.CallBack;
import kr.go.citis.lib.type.FileAsrtType;
import kr.go.citis.lib.type.RprtType;
import kr.go.citis.lib.type.RsltStatus;
import kr.go.citis.main.BasicActivity;
import kr.go.citis.main.R;
import kr.go.citis.main.adapter.CarRprtAdapter;
import kr.go.citis.main.common.LinearLayoutManager;
import kr.go.citis.main.common.WUtil;
import kr.go.citis.main.dto.CarRprtDtlDTO;
import kr.go.citis.main.dto.CarRprtFileItemListDTO;
import kr.go.citis.main.dto.in.CarRprtDtlDTOIn;
import kr.go.citis.main.dto.in.CarRprtFileItemListDTOIn;
import kr.go.citis.main.dto.out.CarRprtDtlDTOOut;
import kr.go.citis.main.dto.out.CarRprtFileItemListDTOOut;

import org.apache.commons.lang3.StringUtils;

import android.annotation.SuppressLint;
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
import android.support.v7.widget.RecyclerView;
import android.view.View;
import android.webkit.MimeTypeMap;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.ScrollView;
import android.widget.TextView;
import butterknife.Bind;

import com.google.gson.Gson;
import com.squareup.okhttp.FormEncodingBuilder;

/**
 * @author softm
 * CarRprtActivity
 * 시정조치요구서
 */
public class CarRprtActivity extends BasicActivity implements OnTopClickListner {
    public static final String TAG = Constant.LOG_TAG;

    @Bind(R.id.et_ispn_rqsts_no    ) EditText  etIspnRqstsNo   ; // 검측요청서번호                            
    @Bind(R.id.et_rprt_no          ) EditText  etRprtNo        ; // 보고서번호                              
    @Bind(R.id.et_dtlcnsttype_nm   ) EditText  etDtlcnsttypeNm ; // 전체공종명-세부공종명[공종]                    
    @Bind(R.id.et_iss_dt           ) EditText  etIssDt         ; // 발행일자                               
    @Bind(R.id.et_title            ) EditText  etTitle         ; // 제목                                 
    @Bind(R.id.et_act_dl           ) EditText  etActDl         ; // 조치기한
    
    @Bind(R.id.et_qlfc_dtls        ) EditText  etQlfcDtls      ; // 자격사항            
    @Bind(R.id.et_ncr_dtls         ) EditText  etNcrDtls       ; // 조치요구사항          
    @Bind(R.id.et_act_dtls         ) EditText  etActDtls       ; // 조치사항
    
    @Bind(R.id.chk_act_rslt_chk_t  ) CheckBox  chkActRsltChkT  ; // 조치결과확인 : 적합(T)
    @Bind(R.id.chk_act_rslt_chk_f  ) CheckBox  chkActRsltChkF  ; // 조치결과확인 : 부적합(F) 
    
    @Bind(R.id.tv_chrg_sprv        ) TextView  tvChrgSprv      ; // 담당감리원                              
    @Bind(R.id.tv_rspn_sprv        ) TextView  tvRspnSprv      ; // 책임감리원                              
    
    @Bind(R.id.btn_save            ) Button    btnSave;
    @Bind(R.id.btn_end             ) Button    btnEnd ;

    public String pRprtSeq ; // 보고서 일련번호
    public String pRprtType; // 보고서 구분

    @Bind(R.id.listView1           ) RecyclerView lv1;
    @Bind(R.id.listView2           ) RecyclerView lv2;
    
	private DownloadManager downloadManager;
	private DownloadManager.Request request;
	private Uri urlToDownload;
	private long latestId = -1;
	private String mFileName;
	
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        init(new CallBack() {
            @Override
            public void complete(Object object) {
                detail();
                list();
                list2();
            }
        });
        downloadManager = (DownloadManager)getSystemService(Context.DOWNLOAD_SERVICE);        
    }

    private void init(final CallBack cb) {
        Intent i = this.getIntent();
        pRprtSeq = StringUtils.defaultString(i.getStringExtra("rprt_seq" )); // 보고서 일련번호
        pRprtType= StringUtils.defaultString(i.getStringExtra("rprt_type")); // 보고서 구분
//        pRprtSeq = "1"; // 보고서 일련번호
//        pRprtType= RprtType.CAR.getTypeCd(); // 보고서 구분

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
        
	    setLayout(R.layout.activity_car_rprt);
	    setTopTitle(R.string.title_car_rprt);

		setDisabled(etIspnRqstsNo  );
		setDisabled(etRprtNo       );
		setDisabled(etDtlcnsttypeNm);
		setDisabled(etIssDt        );
		setDisabled(etTitle        );
		setDisabled(etActDl        );
		
		setDisabled(etQlfcDtls     );
		setDisabled(etNcrDtls      );
		setDisabled(etActDtls      );
		
		setDisabled(chkActRsltChkT ); // 조치결과확인 : 적합(T) 
		setDisabled(chkActRsltChkF ); // 조치결과확인 : 부적합(F)
        try {
            cb.complete(null);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    private void detail() {
        String inParams = "";
        CarRprtDtlDTOIn in = new CarRprtDtlDTOIn();
	        CarRprtDtlDTO data = new CarRprtDtlDTO();
	        data.setpRprtSeq (pRprtSeq );
	        data.setpRprtType(pRprtType);
        in.setData(data);
        Gson gson = new Gson();
        inParams = gson.toJson(in);
        String servcie = "carRprtDtl"; // carRprtDtl	car_rprt_dtl

        Util.i(" detail[" +servcie+"] in param json : " + inParams);
        new AsyncHttp<CarRprtDtlDTOOut,CarRprtDtlDTOOut>(this) {
            @Override
            public void complete(CarRprtDtlDTOOut result) {
                Util.i(result.getClass().getName() +" result : " + result);
                try {
                    CarRprtActivity.this.stopProgressBar();
                    CarRprtDtlDTO data = result.getData();
                    if ( data != null ) {
                    	setText(etIspnRqstsNo  , data.getIspnRqstsNo  ()); // 검측요청서번호                                                 
                    	setText(etRprtNo       , data.getRprtNo       ()); // 보고서번호                                                   
                    	setText(etDtlcnsttypeNm, data.getDtlcnsttypeNm()); // 전체공종명-세부공종명[공종]                                         
                    	setText(etIssDt        , WUtil.toDateFormat(data.getIssDt        ())); // 발행일자                                                    
                    	setText(etTitle        , data.getTitle        ()); // 제목                                                      
                    	setText(etActDl        , WUtil.toDateFormat(data.getActDl        ())); // 조치기한                                                    
                    	setText(etQlfcDtls     , data.getQlfcDtls      ()); // 자격사항     
                    	setText(etNcrDtls      , data.getNcrDtls       ()); // 조치요구사항   
                    	setText(etActDtls      , data.getActDtls       ()); // 조치사항     

                    	if ( RsltStatus.TRUE.getTypeCd().equals(data.getActRsltChk ()) ) { // 조치결과확인
                    		chkActRsltChkT.setChecked(Boolean.TRUE);
                    	} else if ( RsltStatus.FALSE.getTypeCd().equals(data.getActRsltChk ()) ) {
                    		chkActRsltChkF.setChecked(Boolean.TRUE);                    		
                    	}
                    	setText(tvChrgSprv     , data.getChrgSprv     ()); // 담당감리원                                                   
                    	setText(tvRspnSprv     , data.getRspnSprv     ()); // 책임감리원
                    }
                } catch (Exception e) {
                    e.printStackTrace();
                }
            }
            @Override
            public void callback(CarRprtDtlDTOOut result) {
//                this.result = result;
//              TestChkMainActivity.this.alert("끝나면 실행한다.");
            }
        }.sync(new AsyncHttpParam(Constant.SERVER_CHECK_URL,inParams,servcie));
    }
    
    @SuppressLint("NewApi")
    private void list() {
        String inParams = "";
        CarRprtFileItemListDTOIn in = new CarRprtFileItemListDTOIn();
            CarRprtFileItemListDTO data = new CarRprtFileItemListDTO();
            data.setpRprtSeq(pRprtSeq); // 보고서 일련번호
            data.setpFileAsrt(FileAsrtType.RQSTS.getTypeCd()); // 파일구분[조치요구:RQSTS,조치결과:RSLT]
        in.setData(data);
        Gson gson = new Gson();
        inParams = gson.toJson(in);
      String servcie = "carRprtFileItemList"; // carRprtFileItemList	car_rprt_file_item_list        
//        String servcie = "csrBslList"; // csrBslList	csr_bsl_list

        Util.i(" list[" +servcie+"] in param json : " + inParams);
        new AsyncHttp<CarRprtFileItemListDTOOut,CarRprtFileItemListDTOOut>(this) {
            @Override
            public void complete(CarRprtFileItemListDTOOut result) {
                    Util.i(result.getClass().getName() +" result : " + result);
//                  JSONObject result;
//                  JSONArray  data;
                    try {
                        lv1.setLayoutManager(new LinearLayoutManager(CarRprtActivity.this));
                        lv1.setHasFixedSize(true);
                        lv1.setNestedScrollingEnabled(true);
                        ArrayList<CarRprtFileItemListDTO> data = result.getData();
                        lv1.setAdapter(new CarRprtAdapter(CarRprtActivity.this, getLayoutInflater(),data));
                        CarRprtActivity.this.stopProgressBar();
                        ScrollView sv = (ScrollView)findViewById(R.id.scrollView1);
                        sv.setScrollY(0);
                    } catch (Exception e) {
                        e.printStackTrace();
                    }
            }
            @Override
            public void callback(CarRprtFileItemListDTOOut result) {
//                this.result = result;
//              CarRprtActivity.this.alert("끝나면 실행한다.");
            }
        }.execute(new AsyncHttpParam(Constant.SERVER_CHECK_URL,
        							 new FormEncodingBuilder().add("p", inParams),servcie));
    }
    
    
    @SuppressLint("NewApi")
    private void list2() {
        String inParams = "";
        CarRprtFileItemListDTOIn in = new CarRprtFileItemListDTOIn();
            CarRprtFileItemListDTO data = new CarRprtFileItemListDTO();
            data.setpRprtSeq(pRprtSeq); // 보고서 일련번호
            data.setpFileAsrt(FileAsrtType.RSLT.getTypeCd()); // 파일구분[조치요구:RQSTS,조치결과:RSLT]            
        in.setData(data);
        Gson gson = new Gson();
        inParams = gson.toJson(in);
        String servcie = "carRprtFileItemList"; // carRprtFileItemList	car_rprt_file_item_list
//        String servcie = "csrBslList"; // csrBslList	csr_bsl_list

        Util.i(" list[" +servcie+"] in param json : " + inParams);
        new AsyncHttp<CarRprtFileItemListDTOOut,CarRprtFileItemListDTOOut>(this) {
            @Override
            public void complete(CarRprtFileItemListDTOOut result) {
                    Util.i(result.getClass().getName() +" result : " + result);
//                  JSONObject result;
//                  JSONArray  data;
                    try {
                        lv2.setLayoutManager(new LinearLayoutManager(CarRprtActivity.this));
                        lv2.setHasFixedSize(true);
                        lv2.setNestedScrollingEnabled(true);
                        ArrayList<CarRprtFileItemListDTO> data = result.getData();
                        lv2.setAdapter(new CarRprtAdapter(CarRprtActivity.this, getLayoutInflater(),data));
                        CarRprtActivity.this.stopProgressBar();
                        ScrollView sv = (ScrollView)findViewById(R.id.scrollView1);
                        sv.setScrollY(0);
                    } catch (Exception e) {
                        e.printStackTrace();
                    }
            }
            @Override
            public void callback(CarRprtFileItemListDTOOut result) {
//                this.result = result;
//              CarRprtActivity.this.alert("끝나면 실행한다.");
            }
        }.execute(new AsyncHttpParam(Constant.SERVER_CHECK_URL,
        							 new FormEncodingBuilder().add("p", inParams),servcie));
    }
    
//    @OnClick({R.id.img_ncr_img_url, R.id.img_act_rslt_img_url})
    protected void onClick(View v) {
        final int viewID = v.getId();
        if ( viewID == R.id.img_ncr_img_url ) {
        } else if ( viewID == R.id.img_act_rslt_img_url ) {
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
		unregisterReceiver(completeReceiver);          
    }

    @Override
    protected void onResume() {
        super.onResume();
		IntentFilter completeFilter1 = new IntentFilter(DownloadManager.ACTION_DOWNLOAD_COMPLETE);
		registerReceiver(completeReceiver, completeFilter1);   
    }
    
    public void viewDownloadFile(final String fileUrl, final String fileName, final String title, final String description) {
    	startProgressBar();
        runOnUiThread(new Runnable() {
            public void run() {
          	  try {
         		mFileName = fileName;
         		WUtil.deleteFiles(Constant.TMP_DIR, mFileName);
              	urlToDownload = Uri.parse(fileUrl);
            	request = new DownloadManager.Request(urlToDownload);
            	request.setVisibleInDownloadsUi(false);
            	request.setTitle(StringUtils.isNotEmpty(title)?title:"Download");
            	request.setDescription(StringUtils.isNotEmpty(description)?description:"Download");
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

	private BroadcastReceiver completeReceiver = new BroadcastReceiver(){
		@Override
		public void onReceive(Context context, Intent intent) {
			
            String action = intent.getAction();
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
}


