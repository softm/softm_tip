package kr.go.citis.main.activity;

import java.io.File;
import java.io.IOException;
import java.util.Calendar;

import kr.go.citis.lib.Constant;
import kr.go.citis.lib.dialog.DatePickerYearMonthDialog;
import kr.go.citis.main.BasicActivity;
import kr.go.citis.main.R;
import kr.go.citis.main.common.WUtil;
import android.annotation.SuppressLint;
import android.app.DatePickerDialog.OnDateSetListener;
import android.content.ActivityNotFoundException;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.os.Environment;
import android.os.StrictMode;
import android.view.MenuItem;
import android.view.View;
import android.webkit.MimeTypeMap;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.PopupMenu.OnMenuItemClickListener;
import butterknife.Bind;
import butterknife.OnClick;

import com.squareup.okhttp.Callback;
import com.squareup.okhttp.MediaType;
import com.squareup.okhttp.MultipartBuilder;
import com.squareup.okhttp.OkHttpClient;
import com.squareup.okhttp.Request;
import com.squareup.okhttp.RequestBody;
import com.squareup.okhttp.Response;

/**
 * @author softm
 * TestingActivity
 */
@SuppressLint({ "HandlerLeak", "ClickableViewAccessibility" })
public class TestingActivity extends BasicActivity implements OnMenuItemClickListener {
	public static final String TAG = Constant.LOG_TAG;

	@Bind(R.id.btn_get_dpi)	Button btnGetDpi;
    @Bind(R.id.et_chk_dt_yyyymm  ) EditText  etChkDtYyyymm; // 년월
    @Bind(R.id.btn_progress)	Button btnProgress;
    
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		init();
	}
	
	private void init() {
		setLayout(R.layout.activity_testing);
		setTopTitle(R.string.title_testing);
	}

    int chkDtMm;
	int chkDtYyyy;
	
	@OnClick({R.id.btn_get_dpi,R.id.ib_cal,R.id.btn_progress,R.id.btn_file_open,R.id.btn_file_upload})
	public void onClick(View v) {
		int viewID = v.getId();
		if ( viewID == R.id.btn_get_dpi ) {
			toast(String.valueOf(getResources().getDisplayMetrics().density));
		}
		else if ( viewID == R.id.btn_file_upload ) {
			toast(Constant.PIC_DIR + File.separator + "P_1_13.jpg");
			if (android.os.Build.VERSION.SDK_INT > 9) {
				   StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
				   StrictMode.setThreadPolicy(policy);
				}	
			try {
				run();
			} catch (Exception e) {
				e.printStackTrace();
			}
//	        runOnUiThread(new Runnable() {
//	            public void run() {
////	          	  WUtil.HttpFileUpload(Constant.SERVER_DATA_URL,"service=picMngItemSave&cnstrphtSeq=1&siteNo=1",Constant.PIC_DIR + File.separator + "P_1_13.jpg");
//	            	
//	            }
//	        }); 			
		} 
		else if ( viewID == R.id.btn_progress ) {
			startProgressBar();
		}
		else if ( viewID == R.id.btn_file_open ) {
			String mFileName = "한글.jpg";
			String localUrl = Constant.TMP_DIR+File.separator+mFileName;
			File file = new File(localUrl);
           	Uri destinationUri = Uri.fromFile(file);
			String extension = MimeTypeMap.getFileExtensionFromUrl(destinationUri.toString());
			String mimeType = MimeTypeMap.getSingleton().getMimeTypeFromExtension(extension);
				
		    Intent intent1 = new Intent(Intent.ACTION_VIEW); 		    
	        intent1.setDataAndType(destinationUri, mimeType);
	        
	        toast(file.toString() + " / " + mimeType);
	        try {
	            startActivity(intent1);
	        } catch (ActivityNotFoundException e) {
	            toast("Not found. Cannot open file.");
	            e.printStackTrace();
	        }
		}
		else if ( viewID == R.id.ib_cal ) {
            Calendar cal = Calendar.getInstance();
            DatePickerYearMonthDialog datePicker = new DatePickerYearMonthDialog(this, new OnDateSetListener() {
                @Override
                public void onDateSet(DatePicker view, int year, int monthOfYear,
                        int dayOfMonth) {
                	if (view.isShown()) {                	
	                    if (chkDtYyyy != year  || chkDtMm != monthOfYear ) {
	                    	if ( year != -1 ) {
		                        chkDtYyyy = year;
		                        chkDtMm   = monthOfYear;
		                        etChkDtYyyymm.setText(String.format("%04d-%02d", chkDtYyyy,chkDtMm+1));
	                    	}
	                    }
                	}
                }
            },chkDtYyyy==-1?cal.get(Calendar.YEAR):chkDtYyyy,chkDtMm==-1?cal.get(Calendar.MONTH):chkDtMm, 1);
            datePicker.show();
		}
	}
	
	
	private static final String IMGUR_CLIENT_ID = "...";
	private static final MediaType MEDIA_TYPE_PNG = MediaType.parse("image/png");

	private final OkHttpClient client = new OkHttpClient();

	public void run() throws Exception {
	    try {
	        File file = new File(Constant.PIC_DIR + File.separator + "P_1_13.jpg");
	        String contentType = file.toURL().openConnection().getContentType();
	        RequestBody fileBody = RequestBody.create(MediaType.parse(contentType), file);

	        RequestBody requestBody = new MultipartBuilder()
	                .type(MultipartBuilder.FORM)
	                .addFormDataPart("fileUploadType","1")
	                .addFormDataPart("miniType",contentType)
	                .addFormDataPart("ext",file.getAbsolutePath().substring(file.getAbsolutePath().lastIndexOf(".")))
	                .addFormDataPart("fileTypeName","img")
	                .addFormDataPart("uploadedfile","P_1_13.jpg",fileBody)
	                .build();
	        Request request = new Request.Builder()
	                .url(Constant.SERVER_DATA_URL + "?" + "service=picMngItemSave&cnstrphtSeq=1&siteNo=1")
	                .post(requestBody)
	                .build();
	        client.newCall(request).enqueue(new Callback() {
	            @Override
	            public void onFailure(Request request, IOException e) {
	                runOnUiThread(new Runnable() {
	                    @Override
	                    public void run() {
	                    }
	                });
	            }

	            @Override
	            public void onResponse(Response response) throws IOException {
	                runOnUiThread(new Runnable() {
	                    @Override
	                    public void run() {
	                        alert("upload success");
	                    }
	                });
	            }
	        });
	    } catch (IOException e) {
	        e.printStackTrace();
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
//       	showMenu(v, R.menu.main);
    }
    
    @Override  
	public boolean onMenuItemClick(MenuItem item) {
		switch( item.getItemId() ) {
		case R.id.menu_action_1:
			if( isInstalledApplication("com.entropykorea.gas.main") ) {
				Intent intent = new Intent();
				intent.setClassName("com.entropykorea.gas.main", "com.entropykorea.gas.main.activity.AboutActivity");
				startActivity( intent );
			} else {
				alert( getString(R.string.app_name) + " ver. " + getString(R.string.app_version) );
			}
			
			break;
		}
		return false;
	}
    
    @Override
    protected void onPause() {
    	super.onPause();
//    	AppContext.putValue("et_search", getValue(R.id.et_search));
    }
 
	@Override
	protected void onResume() {
		super.onResume();
//    	setText(R.id.et_search,AppContext.getValue("et_search").toString());    	
	}
}
