package kr.go.citis.main.activity;

import java.util.ArrayList;

import kr.go.citis.lib.Constant;
import kr.go.citis.lib.TitleView.OnTopClickListner;
import kr.go.citis.lib.Util;
import kr.go.citis.lib.common.AsyncHttp;
import kr.go.citis.lib.common.AsyncHttpParam;
import kr.go.citis.main.BasicActivity;
import kr.go.citis.main.R;
import kr.go.citis.main.adapter.TestChkListAdapter;
import kr.go.citis.main.common.LinearLayoutManager;
import kr.go.citis.main.common.WConstant;
import kr.go.citis.main.common.WUtil;
import kr.go.citis.main.dto.TestChkListDTO;
import kr.go.citis.main.dto.in.TestChkListDTOIn;
import kr.go.citis.main.dto.out.TestChkListDTOOut;

import org.apache.commons.lang3.StringUtils;

import android.annotation.SuppressLint;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.support.v7.widget.RecyclerView;
import android.view.View;
import android.widget.ScrollView;
import butterknife.Bind;

import com.google.gson.Gson;
import com.squareup.okhttp.FormEncodingBuilder;

/**
 * @author softm
 * TestChkListActivity
 * 검측체크 목록
 */
@SuppressLint({ "HandlerLeak", "ClickableViewAccessibility" })
public class TestChkListActivity extends BasicActivity implements OnTopClickListner {
	public static final String TAG = Constant.LOG_TAG;
	
	@Bind(R.id.listView1) RecyclerView lv1;
	
	public String pIspnChkMgntSeq; // 검측마스터번호
	
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		init();
		retrieve();
	}
	
	private void init() {
		Intent i = this.getIntent();
		pIspnChkMgntSeq = i.getStringExtra("ispn_chk_mgnt_seq");
		
	    if (StringUtils.isEmpty(pIspnChkMgntSeq)) {
	        alert(R.string.msg_not_exec_alert
	                , new DialogInterface.OnClickListener() {
	                    public void onClick(DialogInterface dialog, int whichButton) {
	                        finish();
	                    }
	                }
	        );
	    }
	    loast("pIspnChkMgntSeq : " + pIspnChkMgntSeq);
    
	    setLayout(R.layout.activity_test_chk_list);
	    setTopTitle(R.string.title_test_chk_list);
	}

    private void retrieve() {
        runOnUiThread(new Runnable() {
            public void run() {
          	  startProgressBar();
          	  list();
            }
        });    	
    }
    
	@SuppressLint("NewApi")
	private void list() {
		String inParams = ""; 
		TestChkListDTOIn in = new TestChkListDTOIn();
			TestChkListDTO data = new TestChkListDTO();
	    	data.setpIspnChkMgntSeq(pIspnChkMgntSeq); // 검측마스터번호
	    	in.setData(data);
		Gson gson = new Gson();
		inParams = gson.toJson(in);
		Util.i("in json : " + inParams);		
		new AsyncHttp<TestChkListDTOOut,TestChkListDTOOut>(this) {
//			private TestChkListDTOOut result;
			@Override
			public void complete(TestChkListDTOOut result) {
					Util.i(result.getClass().getName() +" result : " + result);		
//					JSONObject result;
//					JSONArray  data;
					try {
				        lv1.setLayoutManager(new LinearLayoutManager(TestChkListActivity.this));
				        lv1.setHasFixedSize(true);
				        lv1.setNestedScrollingEnabled(true);				        
				        ArrayList<TestChkListDTO> data = result.getData();
						lv1.setAdapter(new TestChkListAdapter(TestChkListActivity.this, getLayoutInflater(),data));
				        TestChkListActivity.this.stopProgressBar();
				        ScrollView sv = (ScrollView)findViewById(R.id.scrollView1);
				        sv.setScrollY(0);
				        
//				        lv1.addOnItemTouchListener(  
//				        	    new RecyclerItemClickListener(TestChkListActivity.this, new RecyclerItemClickListener.OnItemClickListener() {
//				        	        @Override public void onItemClick(View view, int position) {
//				        	        	alert("position : " + position);
//				        	        }
//				        	      })
//				        	  );
				        
					} catch (Exception e) {
						e.printStackTrace();
					}
			}
			@Override
			public void callback(TestChkListDTOOut result) {
//		    	this.result = result;
//				TestChkListActivity.this.alert("끝나면 실행한다.");
			}			
	 	}.execute(new AsyncHttpParam(Constant.SERVER_CHECK_URL,
				new FormEncodingBuilder().add("p", inParams)
										 ,"testChkList"
										 ));
	}
	
//	@OnClick({R.id.ib_cal})
//	public void onClick(View v) {
//	}
	private boolean changed = false;
	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		if ( resultCode == WConstant.PROC_ID_BLD_CHKUP_WRT_SECOND ) {
			retrieve();		
		} else if ( resultCode == WConstant.PROC_ID_TEST_REQ_DOC_SAVE_TYPE_SAVE || resultCode == WConstant.PROC_ID_TEST_REQ_DOC_SAVE_TYPE_COMPLETE ) {
			retrieve();
			changed = true;			
		} else if ( resultCode == WConstant.PROC_ID_TEST_RSLT_WRT_SAVE_TYPE_COMPLETE) {
			retrieve();
			changed = true;
        } else {
			retrieve();
        }
	}

	@Override
	public void onBackPressed() {
    	if ( changed ) {
	        Intent i = this.getIntent();
	        this.setResult(WConstant.PROC_ID_TEST_RSLT_WRT_SAVE_TYPE_COMPLETE, i);
    	}		
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
