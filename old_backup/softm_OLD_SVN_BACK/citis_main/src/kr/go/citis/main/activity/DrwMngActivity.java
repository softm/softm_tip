package kr.go.citis.main.activity;

import java.io.File;
import java.util.ArrayList;

import kr.go.citis.lib.Constant;
import kr.go.citis.lib.SpinnerCd;
import kr.go.citis.lib.TitleView.OnTopClickListner;
import kr.go.citis.lib.Util;
import kr.go.citis.lib.common.AsyncHttp;
import kr.go.citis.lib.common.AsyncHttpParam;
import kr.go.citis.lib.common.CallBack;
import kr.go.citis.lib.type.SiteType;
import kr.go.citis.main.BasicActivity;
import kr.go.citis.main.R;
import kr.go.citis.main.adapter.DrwMngAdapter;
import kr.go.citis.main.common.LinearLayoutManager;
import kr.go.citis.main.common.WUtil;
import kr.go.citis.main.dto.DrwListDTO;
import kr.go.citis.main.dto.in.DrwListDTOIn;
import kr.go.citis.main.dto.out.DrwListDTOOut;

import org.apache.commons.lang3.StringUtils;

import android.annotation.SuppressLint;
import android.app.DownloadManager;
import android.app.DownloadManager.Query;
import android.content.ActivityNotFoundException;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.database.Cursor;
import android.net.Uri;
import android.os.Bundle;
import android.support.v7.widget.RecyclerView;
import android.view.KeyEvent;
import android.view.View;
import android.view.inputmethod.EditorInfo;
import android.webkit.MimeTypeMap;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.EditText;
import android.widget.ScrollView;
import android.widget.TextView;
import butterknife.Bind;
import butterknife.OnClick;
import butterknife.OnEditorAction;

import com.google.gson.Gson;
import com.squareup.okhttp.FormEncodingBuilder;

/**
 * @author softm
 * DrwMngActivity
 * 도면관리
 */
//TODO 수정[서비스로직연동].
@SuppressLint({ "HandlerLeak", "ClickableViewAccessibility" })
public class DrwMngActivity extends BasicActivity implements OnTopClickListner {
    public static final String TAG = Constant.LOG_TAG;

    @Bind(R.id.spn_pln_cls_seq1) SpinnerCd spnPlnClsSeq1; // 대분류
    @Bind(R.id.spn_pln_cls_seq2) SpinnerCd spnPlnClsSeq2; // 중분류
    @Bind(R.id.et_pln_nm       ) EditText  etPlnNm      ; // 도면명

    @Bind(R.id.listView1       ) RecyclerView lv1;

	private DownloadManager downloadManager;
	private DownloadManager.Request request;
	private Uri urlToDownload;
	private long latestId = -1;
	private String mFileName;
	
	@Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        init();
        downloadManager = (DownloadManager)getSystemService(Context.DOWNLOAD_SERVICE);        
    }

    private void retrieve() {
        runOnUiThread(new Runnable() {
            public void run() {
          	  startProgressBar();
          	  list();
            }
        });    	
    }

    private void init() {
	    setLayout(R.layout.activity_drw_mng);
	    setTopTitle(R.string.title_drw_mng);
	  //TODO 수정[서비스로직연동]-스피너데이터연동..
        try {
            // 대분류
            spnPlnClsSeq1.setPrompt("대분류");
            spnPlnClsSeq1.getDataCode("drwListCode","", "",Constant.SERVER_DATA_URL,new CallBack() {
                @Override
                public void complete(Object object) {
//                    spnPlnClsSeq1.setSelection(0, false);
                    spnPlnClsSeq1.setOnItemSelectedListener(new OnItemSelectedListener() {
                        public void onItemSelected(AdapterView<?> parent, View view,    int position, long id) {
                        	Util.d("spnPlnClsSeq1 onItemSelected position / id : " + position + " / " + id);
                            // 중분류
                            spnPlnClsSeq2.setPrompt("중분류");
                            spnPlnClsSeq2.getDataCode("drwListCode",spnPlnClsSeq1.getValue(), "",Constant.SERVER_DATA_URL,new CallBack() {
                                @Override
                                public void complete(Object object) {
                                	spnPlnClsSeq2.setSelection(0, false);
                                	spnPlnClsSeq2.setOnItemSelectedListener(new OnItemSelectedListener() {
                                        public void onItemSelected(AdapterView<?> parent, View view,    int position, long id) {
                                            Util.d("spnPlnClsSeq2 onItemSelected position / id : " + position + " / " + id);
                                            if (spnPlnClsSeq2.loaded ) {                                    
                                                Util.i("spnChargeSiteNo list execute!");
                                                retrieve();
                                            }
                                        }
                                        @Override
                                        public void onNothingSelected(AdapterView<?> arg0) {
                                        }
                                    });
                                	spnPlnClsSeq2.loaded = true;
                                	retrieve();
                                }
                            });
                        }
                        @Override
                        public void onNothingSelected(AdapterView<?> arg0) {
                        }
                    });
                    spnPlnClsSeq1.loaded = true;
                    Util.d("spnPlnClsSeq1.getValue() : " + spnPlnClsSeq1.getValue());
                }
            });
        } catch (Exception e) {
            e.printStackTrace();
        } finally {
        }
    }

    @SuppressLint("NewApi")
    private void list() {
        String inParams = "";
        DrwListDTOIn in = new DrwListDTOIn();
            DrwListDTO data = new DrwListDTO();
            data.setpPlnClsSeq(getValue(spnPlnClsSeq2)); // 중분류.
            data.setpPlnNm(getValue(etPlnNm  )); // 도면명        
        in.setData(data);
        Gson gson = new Gson();
        inParams = gson.toJson(in);
        String servcie = "drwList"; // drw_list	drwList

        Util.i(" list[" +servcie+"] in param json : " + inParams);
        new AsyncHttp<DrwListDTOOut,DrwListDTOOut>(this) {
//            private DrwListDTOOut result;
            @Override
            public void complete(DrwListDTOOut result) {
                    Util.i(result.getClass().getName() +" result : " + result);
//                  JSONObject result;
//                  JSONArray  data;
                    try {
                        lv1.setLayoutManager(new LinearLayoutManager(DrwMngActivity.this));
                        lv1.setHasFixedSize(true);
                        lv1.setNestedScrollingEnabled(true);
                        ArrayList<DrwListDTO> data = result.getData();
                        lv1.setAdapter(new DrwMngAdapter(DrwMngActivity.this, getLayoutInflater(),data)); 
                        DrwMngActivity.this.stopProgressBar();
                        ScrollView sv = (ScrollView)findViewById(R.id.scrollView1);
                        sv.setScrollY(0);
                    } catch (Exception e) {
                        e.printStackTrace();
                    }
            }
            @Override
            public void callback(DrwListDTOOut result) {
//                this.result = result;
//              CsrBslActivity.this.alert("끝나면 실행한다.");
            }
        }.execute(new AsyncHttpParam(Constant.SERVER_DATA_URL,
        							 new FormEncodingBuilder().add("p", inParams),servcie));
    }

    @OnClick({R.id.btn_search})
    public void onClick(View v) {
        int viewID = v.getId();
        if ( viewID == R.id.btn_search ) {
        	retrieve();
        }
    }

	@OnEditorAction({R.id.et_pln_nm})
    public boolean onEditorAction(TextView v, int actionId, KeyEvent event) {
        if ((actionId == EditorInfo.IME_ACTION_DONE) ||
                (event != null && event.getKeyCode() == KeyEvent.KEYCODE_ENTER)) {
        	retrieve();
        }
        return false;
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
