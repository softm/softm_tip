package kr.go.citis.main.activity;

import java.util.ArrayList;

import kr.go.citis.lib.Constant;
import kr.go.citis.lib.SpinnerCd;
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
import kr.go.citis.main.adapter.TestRsltRegAdapter;
import kr.go.citis.main.common.LinearLayoutManager;
import kr.go.citis.main.common.WConstant;
import kr.go.citis.main.common.WUtil;
import kr.go.citis.main.dto.BldChkupWrtDtlDTO;
import kr.go.citis.main.dto.BldChkupWrtDtlSaveDTO;
import kr.go.citis.main.dto.TestRsltWrtItemSaveDTO;
import kr.go.citis.main.dto.TestRsltWrtListDTO;
import kr.go.citis.main.dto.in.BldChkupWrtDtlDTOIn;
import kr.go.citis.main.dto.in.TestRsltWrtListDTOIn;
import kr.go.citis.main.dto.in.TestRsltWrtSaveDTOIn;
import kr.go.citis.main.dto.out.BldChkupWrtDtlDTOOut;
import kr.go.citis.main.dto.out.TestRsltWrtListDTOOut;

import org.apache.commons.lang3.StringUtils;

import android.annotation.SuppressLint;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.support.v7.widget.RecyclerView;
import android.view.View;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.ScrollView;
import android.widget.TextView;
import butterknife.Bind;
import butterknife.OnClick;

import com.google.gson.Gson;
import com.squareup.okhttp.FormEncodingBuilder;

/**
 * @author softm
 * TestRsltRegActivity
 * 검측결과등록
 */
@SuppressLint({ "HandlerLeak", "ClickableViewAccessibility" })
public class TestRsltRegActivity extends BasicActivity implements OnTopClickListner {
    public static final String TAG = Constant.LOG_TAG;

    @Bind(R.id.spn_cnsttypecd   ) SpinnerCd spnCnsttypecd   ; // 공종
    @Bind(R.id.spn_dtlcnsttypecd) SpinnerCd spnDtlcnsttypecd; // 세부공종
    @Bind(R.id.tv_cnsttypecd    ) TextView tvCnsttypecd     ; // 공종 CODE NO.
    @Bind(R.id.et_ispn_dt       ) EditText etIspnDt         ; // 검측일자

    @Bind(R.id.et_plc_prt       ) EditText etPlcPrt         ; // 위치 및 부위
    @Bind(R.id.et_wrk_amnt      ) EditText etWrkAmnt        ; // 공사량

    @Bind(R.id.listView1        ) public RecyclerView lv1;
    @Bind(R.id.btn_save         ) Button btnSave;
    @Bind(R.id.btn_end          ) Button btnEnd;
    @Bind(R.id.block            ) public LinearLayout mBlock; // adapter에서 참조.

    public String pSiteNo        ; // 담당현장
    public String pIspnChkMgntSeq; // 검측마스터번호
    public String pIspnChkSeq    ; // 검측체크번호

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        init(new CallBack() {
            @Override
            public void complete(Object object) {
                detail();
                retrieve();
            }
        });
    }

    private void retrieve() {
        runOnUiThread(new Runnable() {
            public void run() {
              startProgressBar();
              list();
            }
        });
    }

    private void init(final CallBack cb) {
        Intent i = this.getIntent();
        pSiteNo         = StringUtils.defaultString(i.getStringExtra("site_no"          )); // 담당현장
        pIspnChkMgntSeq = StringUtils.defaultString(i.getStringExtra("ispn_chk_mgnt_seq")); // 검측마스터번호
        pIspnChkSeq     = StringUtils.defaultString(i.getStringExtra("ispn_chk_seq"     )); // 검측체크번호
        
////        var.SITE_TYPE = SiteType.SIGONG;
//        var.SITE_TYPE = SiteType.GAMRI;
//        var.USER_ID   = "student02";
//        pSiteNo         = "C2013901"; // 담당현장
//        pIspnChkMgntSeq = "35"; // 담당현장
//        pIspnChkSeq     = "36"; // 담당현장
        if (
            StringUtils.isEmpty(pIspnChkMgntSeq + pIspnChkSeq) // 수정이면서  parameter 없음
        ) {
            alert(R.string.msg_not_exec_alert
                    , new DialogInterface.OnClickListener() {
                        public void onClick(DialogInterface dialog, int whichButton) {
                            finish();
                        }
                    }
            );
        }
        loast("wMode / pIspnChkMgntSeq / pIspnChkSeq: " + pIspnChkMgntSeq + " / " + pIspnChkSeq);
        Util.d("wMode / pIspnChkMgntSeq / pIspnChkSeq: " + pIspnChkMgntSeq + " / " + pIspnChkSeq);
        
	    setLayout(R.layout.activity_test_rslt_reg);
	    setTopTitle(R.string.title_test_rslt_reg);
		
        try {
            // 공종
            spnCnsttypecd.setPrompt("공종");
            spnCnsttypecd.getSysCode("codeCnsttypecd",var.USER_ID, "",new CallBack() {
                @Override
                public void complete(Object object) {
//                    spnCnsttypecd.setSelection(0, false);
                    spnCnsttypecd.setOnItemSelectedListener(new OnItemSelectedListener() {
                        public void onItemSelected(AdapterView<?> parent, View view,    int position, long id) {
                            Util.d("spnCnsttypecd onItemSelected position / id : " + position + " / " + id);
                            // 세부공정 code_dtlcnsttypecd
                            spnDtlcnsttypecd.setPrompt("세부공종");
                            spnDtlcnsttypecd.getSysCode("codeDtlcnsttypecd",spnCnsttypecd.getValue(), "",new CallBack() {
                                @Override
                                public void complete(Object object) {
                                    tvCnsttypecd.setText(spnDtlcnsttypecd.getValue());
                                    spnDtlcnsttypecd.setSelection(0, false);
                                    spnDtlcnsttypecd.setOnItemSelectedListener(new OnItemSelectedListener() {
                                        public void onItemSelected(AdapterView<?> parent, View view,    int position, long id) {
                                            Util.d("spnDtlcnsttypecd onItemSelected position / id : " + position + " / " + id);
                                            if (spnDtlcnsttypecd.loaded ) {
                                                Util.i("spnChargeSiteNo list execute!");
                                                retrieve();
                                            }
                                        }
                                        @Override
                                        public void onNothingSelected(AdapterView<?> arg0) {
                                        }
                                    });
                                    spnDtlcnsttypecd.loaded = true;
                                    cb.complete(null);
                                }
                            });
                        }
                        @Override
                        public void onNothingSelected(AdapterView<?> arg0) {
                        }
                    });
                    spnCnsttypecd.loaded = true;
                    Util.d("spnCnsttypecd.getValue() : " + spnCnsttypecd.getValue());
                }
            });
        } catch (Exception e) {
            e.printStackTrace();
        } finally {
            setDisabled(spnCnsttypecd);
            setDisabled(spnDtlcnsttypecd);
            setDisabled(etIspnDt);
            setDisabled(etPlcPrt);
            setDisabled(etWrkAmnt);
            if ( SiteType.SIGONG == var.SITE_TYPE ) { // 시공사
                setDisabled(lv1);
            }
        }
    }

    @SuppressLint("NewApi")
    private void list() {
        String inParams = "";
        TestRsltWrtListDTOIn in = new TestRsltWrtListDTOIn();
            TestRsltWrtListDTO data = new TestRsltWrtListDTO();
            data.setpIspnChkMgntSeq(pIspnChkMgntSeq);
            data.setpIspnChkSeq(pIspnChkSeq);
        in.setData(data);
        Gson gson = new Gson();
        inParams = gson.toJson(in);
        
        String servcie = "testRsltWrtList"; // test_rslt_wrt_list
        Util.i(" list[" +servcie+"] in param json : " + inParams);
        new AsyncHttp<TestRsltWrtListDTOOut,TestRsltWrtListDTOOut>(this) {
//            private TestRsltWrtListDTOOut result;
            @Override
            public void complete(TestRsltWrtListDTOOut result) {
                Util.i(result.getClass().getName() +" result : " + result);
                try {
                    lv1.setLayoutManager(new LinearLayoutManager(TestRsltRegActivity.this));
                    lv1.setHasFixedSize(true);
                    lv1.setNestedScrollingEnabled(true);
                    ArrayList<TestRsltWrtListDTO> data = result.getData();
                    final TestRsltRegAdapter adapter = new TestRsltRegAdapter(TestRsltRegActivity.this, getLayoutInflater(),data);
                    if ( !lv1.isEnabled() ) {
                        getView(R.id.block).setVisibility(View.VISIBLE);
                        adapter.setEnable(lv1.isEnabled());
                    }
//            		lv1.addOnItemTouchListener(
//            			    new RecyclerItemClickListener(TestRsltRegActivity.this, new RecyclerItemClickListener.OnItemClickListener() {
//            			      @Override public void onItemClick(View view, int position) {
//            			    	  adapter.selectedRow(position);
//            			      }
//            			    })
//            		);                    
                    lv1.setAdapter(adapter);
                    TestRsltRegActivity.this.stopProgressBar();
                    ScrollView sv = (ScrollView)findViewById(R.id.scrollView1);
                    sv.setScrollY(0);
                } catch (Exception e) {
                    e.printStackTrace();
                }
            }
            @Override
            public void callback(TestRsltWrtListDTOOut result) {
//                this.result = result;
//              TestChkMainActivity.this.alert("끝나면 실행한다.");
            }
        }.execute(new AsyncHttpParam(Constant.SERVER_CHECK_URL,
                                     new FormEncodingBuilder().add("p", inParams),servcie));
    }

    private void detail() {
        String inParams = "";
        BldChkupWrtDtlDTOIn in = new BldChkupWrtDtlDTOIn();
        BldChkupWrtDtlDTO data = new BldChkupWrtDtlDTO();
        data.setpIspnChkMgntSeq(pIspnChkMgntSeq);
        data.setpIspnChkSeq(pIspnChkSeq);
        in.setData(data);
        Gson gson = new Gson();
        inParams = gson.toJson(in);
        String servcie = "bldChkupWrtDtl"; // bld_chkup_wrt_dtl
        Util.i(" list[" +servcie+"] in param json : " + inParams);
        new AsyncHttp<BldChkupWrtDtlDTOOut,TestRsltWrtListDTOOut>(this) {
//            private BldChkupWrtDtlDTOOut result;
            @Override
            public void complete(BldChkupWrtDtlDTOOut result) {
                Util.i(result.getClass().getName() +" result : " + result);
                try {
                    TestRsltRegActivity.this.stopProgressBar();
                    BldChkupWrtDtlDTO data = result.getData();
                    spnCnsttypecd.setValue(data.getCnsttypecd());
                    spnDtlcnsttypecd.setValue(data.getDtlcnsttypecd());
                    etIspnDt.setText(WUtil.toDateFormat(data.getIspnDt())); // 검측일자
                    etPlcPrt.setText(data.getPlcPrt()); // 위치 및 부위
                    etWrkAmnt.setText(data.getWrkAmnt()); // 공사량
                    if ( SiteType.GAMRI == var.SITE_TYPE ) { // 감리사
                        if ( StringUtils.isNotEmpty(data.getIspnDt()) ) {
                            setDisabled(lv1);
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
            public void callback(BldChkupWrtDtlDTOOut result) {
//                this.result = result;
//              TestChkMainActivity.this.alert("끝나면 실행한다.");
            }
        }.sync(new AsyncHttpParam(Constant.SERVER_CHECK_URL,inParams,servcie));
    }

    @OnClick({R.id.btn_save, R.id.btn_end})
    protected void onClick(View v) {
        final int viewID = v.getId();
        if ( viewID == R.id.btn_save || viewID == R.id.btn_end ) {
            TestRsltRegAdapter adpater = (TestRsltRegAdapter) lv1.getAdapter();
            adpater.acceptData(adpater.getSelectedItem());
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
    private boolean changed = false; 
    private void execSave(final int viewID) {
        String inParams = "";
        TestRsltWrtSaveDTOIn in = new TestRsltWrtSaveDTOIn();
        in.setSysRegId(var.USER_ID); // 작성자ID
        TestRsltRegAdapter adapter = (TestRsltRegAdapter) lv1.getAdapter();
        ArrayList<TestRsltWrtListDTO> listData = adapter.getItems();
        ArrayList<TestRsltWrtItemSaveDTO> itemData = new ArrayList<TestRsltWrtItemSaveDTO>();
        BldChkupWrtDtlSaveDTO  dtlData = new BldChkupWrtDtlSaveDTO();
        for (TestRsltWrtListDTO srcItem : listData) {
        	TestRsltWrtItemSaveDTO tgtItem = new TestRsltWrtItemSaveDTO();
            tgtItem.setIspnChkSeq    (pIspnChkSeq                ); // 검측체크번호
            tgtItem.setIspnChkItemSeq(srcItem.getIspnChkItemSeq()); // 검측체크항목번호
            tgtItem.setCntrChk       (StringUtils.isNotEmpty(srcItem.getCntrChk())?srcItem.getCntrChk():RsltStatus.FALSE.getTypeCd()); // 시공사점검
            tgtItem.setIspnRslt      (StringUtils.isNotEmpty(srcItem.getIspnRslt())?srcItem.getIspnRslt():RsltStatus.FALSE.getTypeCd()); // 검사결과
            tgtItem.setMsrDtls       (srcItem.getMsrDtls()); // 조치사항
                tgtItem.setMode(WConstant.LIST_DATA_MODE_UPDATE);
            itemData.add(tgtItem);
        }
        dtlData.setMode(WConstant.LIST_DATA_MODE_UPDATE);
        dtlData.setIspnChkMgntSeq(pIspnChkMgntSeq); // 검측마스터번호
        dtlData.setIspnChkSeq(pIspnChkSeq); // 검측체크번호
        dtlData.setSaveType(viewID == R.id.btn_save?SaveType.SAVE.getTypeCd():SaveType.END.getTypeCd());

        in.setItemData(itemData);
        in.setDtlData(dtlData);

        Gson gson = new Gson();
        inParams = gson.toJson(in);
        String servcie = "testRsltWrtSave"; // test_rslt_wrt_save
        Util.i(" list[" +servcie+"] in param json : " + inParams);
        new AsyncHttp<BldChkupWrtDtlDTOOut,TestRsltWrtListDTOOut>(this) {
//            private BldChkupWrtDtlDTOOut result;
            @Override
            public void complete(BldChkupWrtDtlDTOOut result) {

                Util.i(result.getClass().getName() +" result : " + result);
                try {
                    TestRsltRegActivity.this.stopProgressBar();
//                    BldChkupWrtDtlDTO data = result.getData();
                    if ( Constant.ERR_CODE_SUCCESS.equals(result.getMsgCode())) {
                    	changed = true;                    	
                        throw new Exception(getString(R.string.msg_saved));
                    } else {
                        throw new Exception(result.getMsg());
                    }
                } catch (Exception e) {
//                  e.printStackTrace();
                    alert(e.getMessage(),new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface arg0, int arg1) {
                            if ( viewID == R.id.btn_end ) { // 확정.
	                            Intent i = TestRsltRegActivity.this.getIntent();
	                            TestRsltRegActivity.this.setResult(viewID==R.id.btn_save?WConstant.PROC_ID_TEST_RSLT_WRT_SAVE_TYPE_SAVE:WConstant.PROC_ID_TEST_RSLT_WRT_SAVE_TYPE_COMPLETE, i);
	                            WUtil.goTestRsltNoti(TestRsltRegActivity.this, pIspnChkMgntSeq,pIspnChkSeq);
	                            finish();
                            } else {
                            	retrieve();
                            }
                        }
                    });
                }
            }
            @Override
            public void callback(BldChkupWrtDtlDTOOut result) {
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
