package kr.go.citis.main.activity;

import java.util.Date;

import kr.go.citis.lib.Constant;
import kr.go.citis.lib.TitleView.OnTopClickListner;
import kr.go.citis.lib.Util;
import kr.go.citis.lib.common.AsyncHttp;
import kr.go.citis.lib.common.AsyncHttpParam;
import kr.go.citis.lib.common.CallBack;
import kr.go.citis.lib.dialog.CalendarDialogBuilder;
import kr.go.citis.lib.type.SaveType;
import kr.go.citis.lib.type.SiteType;
import kr.go.citis.main.BasicActivity;
import kr.go.citis.main.R;
import kr.go.citis.main.common.WConstant;
import kr.go.citis.main.common.WUtil;
import kr.go.citis.main.dto.TestReqDocDtlDTO;
import kr.go.citis.main.dto.TestReqDocSaveDTO;
import kr.go.citis.main.dto.in.TestReqDocDtlDTOIn;
import kr.go.citis.main.dto.in.TestReqDocSaveDTOIn;
import kr.go.citis.main.dto.out.TestReqDocDtlDTOOut;

import org.apache.commons.lang3.StringUtils;

import android.annotation.SuppressLint;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.drawable.Drawable;
import android.os.Bundle;
import android.view.MotionEvent;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.TextView;
import butterknife.Bind;
import butterknife.OnClick;

import com.google.gson.Gson;

/**
 * @author softm
 * TestReqDocActivity
 * 검측요청문서 작성
 */
public class TestReqDocActivity extends BasicActivity implements OnTopClickListner {
    public static final String TAG = Constant.LOG_TAG;

    @Bind(R.id.et_ispn_rqsts_no) EditText etIspnRqstsNo  ; // 검측요청서번호
    @Bind(R.id.tv_rqsts_dt     ) TextView tvRqstsDt      ; // 검측요청일
    
    @Bind(R.id.tv_cusr         ) TextView tvCusr         ; // 받음          
    @Bind(R.id.tv_cnsttypenm   ) TextView tvCnsttypenm   ; // 공종          
    @Bind(R.id.tv_dtlcnsttypenm) TextView tvDtlcnsttypenm; // 세부공종      
    @Bind(R.id.tv_plc_prt      ) TextView tvPlcPrt       ; // 위치          
    @Bind(R.id.et_ispn_prt     ) EditText etIspnPrt      ; // 검측부위      
    @Bind(R.id.et_ispn_call_tm ) EditText etIspnCallTm   ; // 검측요구일시  
    @Bind(R.id.et_ispn_dtls    ) EditText etIspnDtls     ; // 검측사항      
    @Bind(R.id.tv_chk_user_nm  ) TextView tvChkUserNm    ; // 점검직원      
    @Bind(R.id.tv_susr         ) TextView tvSusr         ; // 현장대리인    

    @Bind(R.id.btn_save        ) Button btnSave;
    @Bind(R.id.btn_end         ) Button btnEnd ;

    public String pIspnChkMgntSeq; // 검측마스터번호

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        init(new CallBack() {
            @Override
            public void complete(Object object) {
                detail();
            }
        });
    }

    private void init(final CallBack cb) {
        Intent i = this.getIntent();
        pIspnChkMgntSeq = StringUtils.defaultString(i.getStringExtra("ispn_chk_mgnt_seq")); // 검측마스터번호
        if (
                StringUtils.isEmpty(pIspnChkMgntSeq) // 작성이면서 parameter있음
        ) {
            alert(R.string.msg_not_exec_alert
                    , new DialogInterface.OnClickListener() {
                        public void onClick(DialogInterface dialog, int whichButton) {
                            finish();
                        }
                    }
            );
        }
        loast("pIspnChkMgntSeq : " + pIspnChkMgntSeq );
        Util.d("pIspnChkMgntSeq : " + pIspnChkMgntSeq );
        
	    setLayout(R.layout.activity_test_req_doc);
	    setTopTitle(R.string.title_test_req_doc);
		
        etIspnCallTm.setInputType(0);
        etIspnCallTm.setFocusable(Boolean.FALSE);
        final Drawable x = getResources().getDrawable(android.R.drawable.ic_menu_close_clear_cancel);
//        Drawable x = getResources().getDrawable(android.R.drawable.ic_input_delete);
        x.setBounds(0, 0, x.getIntrinsicWidth(), x.getIntrinsicHeight());
        etIspnCallTm.setCompoundDrawables(null, null, x, null);
        etIspnCallTm.setOnTouchListener(new View.OnTouchListener() {
            @SuppressLint("ClickableViewAccessibility")
			@Override
            public boolean onTouch(View view, MotionEvent motionEvent) {
                if (motionEvent.getAction() == MotionEvent.ACTION_UP){
//                    if (motionEvent.getX()>(view.getWidth()-view.getPaddingRight())){
                    if (motionEvent.getX()>(view.getWidth()-x.getIntrinsicWidth()-view.getPaddingRight())){
                        ((EditText)view).setText("");
                        etIspnCallTm.setText("");
                    }
                }
                return false;
            }
        });
        
        try {
            cb.complete(null);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    private void detail() {
        String inParams = "";
        TestReqDocDtlDTOIn in = new TestReqDocDtlDTOIn();
	        TestReqDocDtlDTO data = new TestReqDocDtlDTO();
	        data.setpIspnChkMgntSeq(pIspnChkMgntSeq);
        in.setData(data);
        Gson gson = new Gson();
        inParams = gson.toJson(in);
        String servcie = "testReqDocDtl"; // test_req_doc_dtl

        Util.i(" list[" +servcie+"] in param json : " + inParams);
        new AsyncHttp<TestReqDocDtlDTOOut,TestReqDocDtlDTOOut>(this) {
//            private TestReqDocDtlDTOOut result;
            @Override
            public void complete(TestReqDocDtlDTOOut result) {
                Util.i(result.getClass().getName() +" result : " + result);
                try {
                    TestReqDocActivity.this.stopProgressBar();
                    TestReqDocDtlDTO data = result.getData();
                    if ( data != null ) {
                    	setText(etIspnRqstsNo  , data.getIspnRqstsNo  ()); // 검측요청서번호    
                    	setText(tvRqstsDt      , WUtil.toDateFormat(data.getRqstsDt      ())); // 검측요청일      
                    	setText(tvCusr         , data.getCusr         ()); // 받음         
                    	setText(tvCnsttypenm   , data.getCnsttypenm   ()); // 공종         
                    	setText(tvDtlcnsttypenm, data.getDtlcnsttypenm()); // 세부공종       
                    	setText(tvPlcPrt       , data.getPlcPrt       ()); // 위치         
                    	setText(etIspnPrt      , data.getIspnPrt      ()); // 검측부위       
                    	setText(etIspnCallTm   , data.getIspnCallTm   ()); // 검측요구일시     
                    	setText(etIspnDtls     , data.getIspnDtls     ()); // 검측사항       
                    	setText(tvChkUserNm    , data.getChkUserNm    ()); // 점검직원       
                    	setText(tvSusr         , data.getSusr         ()); // 현장대리인                         
                    }
    			    if ( SiteType.SIGONG == var.SITE_TYPE ) { // 시공사
    			    	if ( StringUtils.isNotEmpty(data.getRqstsDt()) ) {
    			    		setDisabled(etIspnRqstsNo  ); // 검측요청서번호    
    			    		setDisabled(etIspnPrt      ); // 검측부위       
    			    		setDisabled(etIspnCallTm   ); // 검측요구일시     
    			    		setDisabled(etIspnDtls     ); // 검측사항
    			    		etIspnCallTm.setCompoundDrawables(null, null, null, null);
    			    		setInVisibility(R.id.ib_cal); // 검측요구일시  버튼  
    			    	} else {
    			    		btnSave.setVisibility(View.VISIBLE);
    			    		btnEnd.setVisibility(View.VISIBLE);
    			    	}
    			    } else if ( SiteType.GAMRI == var.SITE_TYPE ) { // 감리사
			    		setDisabled(etIspnRqstsNo  ); // 검측요청서번호    
			    		setDisabled(etIspnPrt      ); // 검측부위       
			    		setDisabled(etIspnCallTm   ); // 검측요구일시     
			    		setDisabled(etIspnDtls     ); // 검측사항
			    		etIspnCallTm.setCompoundDrawables(null, null, null, null);
			    		setInVisibility(R.id.ib_cal); // 검측요구일시  버튼  
    			    }
                } catch (Exception e) {
                    e.printStackTrace();
                }
            }
            @Override
            public void callback(TestReqDocDtlDTOOut result) {
//                this.result = result;
//              TestChkMainActivity.this.alert("끝나면 실행한다.");
            }
        }.sync(new AsyncHttpParam(Constant.SERVER_CHECK_URL,inParams,servcie));
    }
    
	private void execSave(final int viewID) {
        String inParams = "";
        TestReqDocSaveDTOIn in = new TestReqDocSaveDTOIn();
            in.setSysRegId(var.USER_ID);
            TestReqDocSaveDTO data = new TestReqDocSaveDTO();
            data.setpIspnChkMgntSeq(pIspnChkMgntSeq); // 검측마스터번호
            data.setIspnRqstsNo(getString(etIspnRqstsNo)); // 검측요청서번호
//            data.setRqstsDt(); // 검측요청일
            data.setIspnRqstsNo(getString(etIspnRqstsNo)); // 검측요청서번호                      
            data.setIspnPrt    (getString(etIspnPrt    )); // 검측부위                         
            data.setIspnCalltm (getString(etIspnCallTm )); // 검측요구일시                       
            data.setIspnDtls   (getString(etIspnDtls   )); // 검측사항                         
            data.setSaveType(viewID == R.id.btn_save?SaveType.SAVE.getTypeCd():SaveType.END.getTypeCd());
        in.setData(data);
        Gson gson = new Gson();
        inParams = gson.toJson(in);
        String servcie = "testReqDocSave"; // test_req_doc_save
        Util.i(" list[" +servcie+"] in param json : " + inParams);
        new AsyncHttp<TestReqDocDtlDTOOut,TestReqDocDtlDTOOut>(this) {
//            private TestReqDocDtlDTOOut result;
            @Override
            public void complete(TestReqDocDtlDTOOut result) {
                Util.i(result.getClass().getName() +" result : " + result);
                try {
                    TestReqDocActivity.this.stopProgressBar();
//                    TestReqDocDtlDTO data = result.getData();
                    if ( Constant.ERR_CODE_SUCCESS.equals(result.getMsgCode())) {
                        throw new Exception(getString(R.string.msg_saved));
                    } else {
                        throw new Exception(result.getMsg());
                    }
                } catch (Exception e) {
//                  e.printStackTrace();
                    alert(e.getMessage(),new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface arg0, int arg1) {
//                            Intent i = TestReqDocActivity.this.getIntent();
//                            TestReqDocActivity.this.setResult(viewID == R.id.btn_save?WConstant.PROC_ID_TEST_REQ_DOC_SAVE_TYPE_SAVE:WConstant.PROC_ID_TEST_REQ_DOC_SAVE_TYPE_COMPLETE, i);
//                            finish();
                        	WUtil.goTestChkMain(TestReqDocActivity.this,viewID == R.id.btn_save?WConstant.PROC_ID_TEST_REQ_DOC_SAVE_TYPE_SAVE:WConstant.PROC_ID_TEST_REQ_DOC_SAVE_TYPE_COMPLETE);
                        }
                    });
                }
            }
            @Override
            public void callback(TestReqDocDtlDTOOut result) {
//                this.result = result;
//              TestChkMainActivity.this.alert("끝나면 실행한다.");
            }
        }.execute(new AsyncHttpParam(Constant.SERVER_CHECK_URL,inParams,servcie));
	}
	
    @OnClick({R.id.btn_save, R.id.btn_end, R.id.ib_cal})
    protected void onClick(View v) {
        final int viewID = v.getId();
        if ( viewID == R.id.btn_save || viewID == R.id.btn_end ) {
        	String ispnRqstsNo = getString(etIspnRqstsNo);
        	if (StringUtils.isEmpty(ispnRqstsNo))  {
        		alert(R.string.msg_do_input_ispnrqstsno,new DialogInterface.OnClickListener() {
					@Override
					public void onClick(DialogInterface dialog, int which) {
						setFocus(etIspnRqstsNo);
					}
				});
        		return;
        	}
        	if ( viewID == R.id.btn_end ) {
        		confirm(R.string.msg_complete_confirm, new DialogInterface.OnClickListener() {
					@Override
					public void onClick(DialogInterface dialog, int which) {
						execSave(viewID);
					}
				});
        	} else {
        		execSave(viewID);
        	}
        } else if ( viewID == R.id.ib_cal ) { // 검측요구일시 달력
	        CalendarDialogBuilder calendar = null;
	        Date initialDate = new Date();
//	        private Date startDate = new Date();
//	        private Date endDate = new Date();
//	        if(initialDate != null)
//	        {
	            calendar = new CalendarDialogBuilder(this, new kr.go.citis.lib.dialog.CalendarDialogBuilder.OnDateSetListener(){
					@SuppressLint("DefaultLocale")
					@Override
					public void onDateSet(int year, int monthOfYear,int dayOfMonth) {
//				        alert((monthOfYear+1) + "/" + year + "/" + dayOfMonth);	
						String ispnCallTm = String.format("%04d-%02d-%02d", year,monthOfYear+1,dayOfMonth);
						if (!"0000-01-00".equals(ispnCallTm)) {
							etIspnCallTm.setText(String.format("%04d-%02d-%02d", year,monthOfYear+1,dayOfMonth));
						} else {
//							etIspnCallTm.setText("");
						}
					}
	            }, initialDate.getTime()); 
//	        } else {
//	            calendar = new CalendarDialogBuilder(this, new kr.go.citis.lib.dialog.CalendarDialogBuilder.OnDateSetListener(){
//					@Override
//					public void onDateSet(int year, int monthOfYear,int dayOfMonth) {
//				        alert((monthOfYear+1) + "/" + year + "/" + dayOfMonth);						
//					}
//	            });
//	        }
//	        calendar.setStartDate(startDate.getTime());
//	        calendar.setEndDate(endDate.getTime());
	        calendar.showCalendar();
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
    }

    @Override
    protected void onResume() {
        super.onResume();
//      setText(R.id.et_search,AppContext.getValue("et_search").toString());
    }
}


