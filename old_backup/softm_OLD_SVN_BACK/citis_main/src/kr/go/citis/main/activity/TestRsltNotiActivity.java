package kr.go.citis.main.activity;

import kr.go.citis.lib.Constant;
import kr.go.citis.lib.TitleView.OnTopClickListner;
import kr.go.citis.lib.Util;
import kr.go.citis.lib.common.AsyncHttp;
import kr.go.citis.lib.common.AsyncHttpParam;
import kr.go.citis.lib.common.CallBack;
import kr.go.citis.lib.type.RsltStatus;
import kr.go.citis.lib.type.SaveType;
import kr.go.citis.lib.type.SiteType;
import kr.go.citis.main.BasicActivity;
import kr.go.citis.main.R;
import kr.go.citis.main.common.WConstant;
import kr.go.citis.main.common.WUtil;
import kr.go.citis.main.dto.TestRsltNotiDtlDTO;
import kr.go.citis.main.dto.TestRsltNotiSaveDTO;
import kr.go.citis.main.dto.in.TestRsltNotiDtlDTOIn;
import kr.go.citis.main.dto.in.TestRsltNotiSaveDTOIn;
import kr.go.citis.main.dto.out.TestRsltNotiDtlDTOOut;

import org.apache.commons.lang3.StringUtils;

import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.CompoundButton.OnCheckedChangeListener;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.TextView;
import butterknife.Bind;
import butterknife.OnClick;

import com.google.gson.Gson;

/**
 * @author softm
 * TestRsltNotiActivity
 * 검측결과통보
 */
public class TestRsltNotiActivity extends BasicActivity implements OnTopClickListner {
    public static final String TAG = Constant.LOG_TAG;

    @Bind(R.id.tv_ispn_rqsts_no ) TextView tvIspnRqstsNo ; // 검측요청서번호    
    @Bind(R.id.tv_cusr          ) TextView tvCusr        ; // 받음         
    @Bind(R.id.chk_rslt_status_t) CheckBox chkRsltStatusT; // 검측결과상태     
    @Bind(R.id.chk_rslt_status_f) CheckBox chkRsltStatusF; // 검측결과상태     
    @Bind(R.id.et_rslt_dtls     ) EditText etRsltDtls    ; // 검측결과내용     
    @Bind(R.id.et_rslt_instr    ) EditText etRsltInstr   ; // 지시사항       
    @Bind(R.id.tv_eng_nm1       ) TextView tvEngNm1      ; // 검측건설사업관리기술자
    @Bind(R.id.tv_eng_nm2       ) TextView tvEngNm2      ; // 책임건설사업관리기술자

    @Bind(R.id.btn_save         )    Button btnSave;
    @Bind(R.id.btn_end          )    Button btnEnd ;

    public String pIspnChkMgntSeq; // 검측마스터번호
	public String pIspnChkSeq    ; // 검측체크번호

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
        pIspnChkSeq     = StringUtils.defaultString(i.getStringExtra("ispn_chk_seq")); // 검측마스터번호
//        
//      var.SITE_TYPE = SiteType.GAMRI;
//      var.USER_ID   = "student02";
//      pIspnChkMgntSeq = "35"; // 담당현장
//      pIspnChkSeq     = "36"; // 담당현장
      
        if (
                StringUtils.isEmpty(pIspnChkMgntSeq) || StringUtils.isEmpty(pIspnChkSeq) // 작성이면서 parameter있음
        ) {
            alert(R.string.msg_not_exec_alert
                    , new DialogInterface.OnClickListener() {
                        public void onClick(DialogInterface dialog, int whichButton) {
                            finish();
                        }
                    }
            );
        }
        loast("pIspnChkMgntSeq / pIspnChkSeq : " + pIspnChkMgntSeq + " / " + pIspnChkSeq );
        Util.d("pIspnChkMgntSeq / pIspnChkSeq : " + pIspnChkMgntSeq + " / " + pIspnChkSeq );
        
	    setLayout(R.layout.activity_test_rslt_noti);
	    setTopTitle(R.string.title_test_rslt_noti);
		
	    if ( SiteType.SIGONG == var.SITE_TYPE ) { // 시공사
			setDisabled(etRsltDtls  ); // 검측결과내용
			setDisabled(etRsltInstr ); // 지시사항  
			setDisabled(chkRsltStatusT ); // 검측결과상태-적합 
			setDisabled(chkRsltStatusF ); // 검측결과상태-부적합
	    } else {
	    	chkRsltStatusT.setOnCheckedChangeListener(new OnCheckedChangeListener() {
                @Override
                public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
            		if ( isChecked )
            			chkRsltStatusF.setChecked(Boolean.FALSE);          	
                }
            });
	    	chkRsltStatusF.setOnCheckedChangeListener(new OnCheckedChangeListener() {
        		@Override
        		public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
            		if ( isChecked )    			
            			chkRsltStatusT.setChecked(Boolean.FALSE);          	
        		}
        	});
	    }

        try {
            cb.complete(null);
        } catch (Exception e) {
            e.printStackTrace();
        } 
    }

    private void detail() {
        String inParams = "";
        TestRsltNotiDtlDTOIn in = new TestRsltNotiDtlDTOIn();
	        TestRsltNotiDtlDTO data = new TestRsltNotiDtlDTO();
	        data.setpIspnChkMgntSeq(pIspnChkMgntSeq);
	        data.setpIspnChkSeq(pIspnChkSeq);
        in.setData(data);
        Gson gson = new Gson();
        inParams = gson.toJson(in);
        String servcie = "testRsltNotiDtl"; // test_rslt_noti_dtl

        Util.i(" list[" +servcie+"] in param json : " + inParams);
        new AsyncHttp<TestRsltNotiDtlDTOOut,TestRsltNotiDtlDTOOut>(this) {
//            private TestRsltNotiDtlDTOOut result;
            @Override
            public void complete(TestRsltNotiDtlDTOOut result) {
                Util.i(result.getClass().getName() +" result : " + result);
                try {
                    TestRsltNotiActivity.this.stopProgressBar();
                    TestRsltNotiDtlDTO data = result.getData();
                    if ( data != null ) {
                    	setText(tvIspnRqstsNo , data.getIspnRqstsNo ()); // 검측요청서번호    
                    	setText(tvCusr        , data.getCusr        ()); // 받음         
//                    	setText(chkRsltStatusT, data.getRsltStatus ()); // 검측결과상태-적합     
//                    	setText(chkRsltStatusF, data.getRsltStatus ()); // 검측결과상태-부적합
                    	if ( RsltStatus.TRUE.getTypeCd().equals(data.getRsltStatus ()) ) {
                    		chkRsltStatusT.setChecked(Boolean.TRUE);
                    	} else if ( RsltStatus.FALSE.getTypeCd().equals(data.getRsltStatus ()) ) {
                    		chkRsltStatusF.setChecked(Boolean.TRUE);                    		
                    	}
                    	setText(etRsltDtls    , data.getRsltDtls    ()); // 검측결과내용     
                    	setText(etRsltInstr   , data.getRsltInstr   ()); // 지시사항       
                    	setText(tvEngNm1      , data.getEngNm1      ()); // 검측건설사업관리기술자
                    	setText(tvEngNm2      , data.getEngNm2      ()); // 책임건설사업관리기술자
                    }
                    if ( SiteType.GAMRI == var.SITE_TYPE ) { // 감리사
    			    	if ( StringUtils.isNotEmpty(data.getRsltNotiDt())
    			    		&& !"99991231".equals(data.getRsltNotiDt())
    			    			) {
    			    		setDisabled(etRsltDtls  ); // 검측결과내용
    			    		setDisabled(etRsltInstr ); // 지시사항  
    			    		setDisabled(chkRsltStatusT ); // 검측결과상태-적합 
    			    		setDisabled(chkRsltStatusF ); // 검측결과상태-부적합
    			    	} else {
    			    		btnSave.setVisibility(View.VISIBLE);
    			    		btnEnd.setVisibility(View.VISIBLE);
    			    	}
    			    }
                } catch (Exception e) {
                    e.printStackTrace();
                }
            }
            @Override
            public void callback(TestRsltNotiDtlDTOOut result) {
//                this.result = result;
//              TestChkMainActivity.this.alert("끝나면 실행한다.");
            }
        }.sync(new AsyncHttpParam(Constant.SERVER_CHECK_URL,inParams,servcie));
    }

	@OnClick({R.id.btn_save, R.id.btn_end})
	protected void onClick(View v) {
	    final int viewID = v.getId();
	    if ( viewID == R.id.btn_save || viewID == R.id.btn_end ) {
        	if ( !chkRsltStatusT.isChecked() && !chkRsltStatusF.isChecked() ) { 
        		alert(R.string.msg_do_check_rslt_status,new DialogInterface.OnClickListener() {
					@Override
					public void onClick(DialogInterface dialog, int which) {
						setFocus(chkRsltStatusT);
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
	    }
	}

	private void execSave(final int viewID) {
        String inParams = "";
        TestRsltNotiSaveDTOIn in = new TestRsltNotiSaveDTOIn();
            in.setSysRegId(var.USER_ID);
            TestRsltNotiSaveDTO data = new TestRsltNotiSaveDTO();
            data.setIspnChkMgntSeq(pIspnChkMgntSeq); // 검측마스터번호
	        data.setIspnChkSeq(pIspnChkSeq);
            data.setRsltDtls   (getString(etRsltDtls   )); // 검측결과내용    
            data.setRsltInstr  (getString(etRsltInstr  )); // 지시사항      
        	if ( chkRsltStatusT.isChecked() ) {
        		data.setRsltStatus (RsltStatus.TRUE.getTypeCd()); // 검측결과상태-적합
        	} else if ( chkRsltStatusF.isChecked() ) {
        		data.setRsltStatus (RsltStatus.FALSE.getTypeCd()); // 검측결과상태-부적합 		
        	}
            data.setSaveType(viewID == R.id.btn_save?SaveType.SAVE.getTypeCd():SaveType.END.getTypeCd());
        in.setData(data);
        Gson gson = new Gson();
        inParams = gson.toJson(in);
        String servcie = "testRsltNotiSave"; // test_rslt_noti_save
        Util.i(" list[" +servcie+"] in param json : " + inParams);
        new AsyncHttp<TestRsltNotiDtlDTOOut,TestRsltNotiDtlDTOOut>(this) {
//            private TestRsltNotiDtlDTOOut result;
            @Override
            public void complete(TestRsltNotiDtlDTOOut result) {
                Util.i(result.getClass().getName() +" result : " + result);
                try {
                    TestRsltNotiActivity.this.stopProgressBar();
//                    TestRsltNotiDtlDTO data = result.getData();
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
//                            if ( viewID == R.id.btn_end ) { // 확정.
//                            } else {
//                            }
                            WUtil.retrunTestChkList(TestRsltNotiActivity.this,pIspnChkMgntSeq,viewID == R.id.btn_save?WConstant.PROC_ID_TEST_RSLT_NOTI_DTL_TYPE_SAVE:WConstant.PROC_ID_TEST_RSLT_NOTI_DTL_TYPE_COMPLETE);                            
                        }
                    });
                }
            }
            @Override
            public void callback(TestRsltNotiDtlDTOOut result) {
//                this.result = result;
//              TestChkMainActivity.this.alert("끝나면 실행한다.");
            }
        }.execute(new AsyncHttpParam(Constant.SERVER_CHECK_URL,inParams,servcie));
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
