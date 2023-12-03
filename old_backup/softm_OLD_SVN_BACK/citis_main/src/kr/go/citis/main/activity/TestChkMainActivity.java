package kr.go.citis.main.activity;

import java.util.ArrayList;
import java.util.Calendar;

import kr.go.citis.lib.Constant;
import kr.go.citis.lib.SpinnerCd;
import kr.go.citis.lib.TitleView.OnTopClickListner;
import kr.go.citis.lib.Util;
import kr.go.citis.lib.common.AsyncHttp;
import kr.go.citis.lib.common.AsyncHttpParam;
import kr.go.citis.lib.common.CallBack;
import kr.go.citis.lib.dialog.DatePickerYearMonthDialog;
import kr.go.citis.lib.type.SiteType;
import kr.go.citis.main.BasicActivity;
import kr.go.citis.main.R;
import kr.go.citis.main.adapter.TestChkMainAdapter;
import kr.go.citis.main.common.LinearLayoutManager;
import kr.go.citis.main.common.WConstant;
import kr.go.citis.main.common.WUtil;
import kr.go.citis.main.dto.TestChkMainDTO;
import kr.go.citis.main.dto.in.TestChkMainDTOIn;
import kr.go.citis.main.dto.out.TestChkMainDTOOut;
import android.annotation.SuppressLint;
import android.app.DatePickerDialog.OnDateSetListener;
import android.content.Intent;
import android.graphics.drawable.Drawable;
import android.os.Bundle;
import android.support.v7.widget.RecyclerView;
import android.view.KeyEvent;
import android.view.MenuItem;
import android.view.MotionEvent;
import android.view.View;
import android.view.inputmethod.EditorInfo;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.ScrollView;
import android.widget.TextView;
import butterknife.Bind;
import butterknife.OnClick;
import butterknife.OnEditorAction;

import com.google.gson.Gson;
import com.squareup.okhttp.FormEncodingBuilder;

/**
 * @author softm
 * TestChkMainActivity
 * 검측체크 메인
 */
@SuppressLint({ "HandlerLeak", "ClickableViewAccessibility" })
public class TestChkMainActivity extends BasicActivity implements OnTopClickListner, OnMenuItemClickListener {
    public static final String TAG = Constant.LOG_TAG;

    @Bind(R.id.spn_site_no       ) SpinnerCd spnSiteNo      ; // 담당현장번호
    @Bind(R.id.spn_charge_site_no) SpinnerCd spnChargeSiteNo; // 관할현장번호
    @Bind(R.id.spn_cnsttypecd    ) SpinnerCd spnCnsttypecd  ; // 공종
    @Bind(R.id.spn_ispn_prgrs    ) SpinnerCd spnIspnPrgrs   ; // 진행상태
    @Bind(R.id.et_chk_dt_yyyymm  ) EditText  etChkDtYyyymm  ; // 년월

    @Bind(R.id.listView1         ) RecyclerView lv1       ;
    @Bind(R.id.ib_cal            ) ImageButton  mBtnCal   ;
    @Bind(R.id.btn_new_reg       ) Button       btnNewReg ;
    
    int chkDtMm;
	int chkDtYyyy;

	@Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        
        init();
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
	    setLayout(R.layout.activity_test_chk_main);
	    setTopTitle(R.string.title_test_chk_main);
		
        Calendar cal = Calendar.getInstance();
        chkDtYyyy = cal.get(Calendar.YEAR);
        chkDtMm   = cal.get(Calendar.MONTH);
//
        if ( SiteType.GAMRI == var.SITE_TYPE) { // 감리사
            setVisibility(R.id.tv_charge_site_no);
            setVisibility(R.id.spn_charge_site_no);
            setInVisibility(btnNewReg,View.GONE);
        } else {
            setInVisibility(R.id.tv_charge_site_no);
            setInVisibility(R.id.spn_charge_site_no);
        }

//      Util.i(var.SITE_TYPE.getTypeCd() + " / " + var.SITE_TYPE.getTypeNm());
        etChkDtYyyymm.setText(String.format("%04d-%02d", chkDtYyyy,chkDtMm+1));
//        etChkDtYyyymm.setImeOptions(EditorInfo.IME_ACTION_DONE);
        etChkDtYyyymm.setInputType(0);
        final Drawable x = getResources().getDrawable(android.R.drawable.ic_menu_close_clear_cancel);
//        Drawable x = getResources().getDrawable(android.R.drawable.ic_input_delete);
        x.setBounds(0, 0, x.getIntrinsicWidth(), x.getIntrinsicHeight());
        etChkDtYyyymm.setCompoundDrawables(null, null, x, null);
        etChkDtYyyymm.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View view, MotionEvent motionEvent) {
                if (motionEvent.getAction() == MotionEvent.ACTION_UP){
//                    if (motionEvent.getX()>(view.getWidth()-view.getPaddingRight())){
                    if (motionEvent.getX()>(view.getWidth()-x.getIntrinsicWidth()-view.getPaddingRight())){
                        ((EditText)view).setText("");
                        chkDtYyyy = -1;
                        chkDtMm   = -1;
                        retrieve();
                    }
                }
                return false;
            }
        });
        try {
            // 담당현장
            spnSiteNo.setPrompt("담당현장");
            spnSiteNo.getSysCode("codeChargeSite",var.USER_ID, "",new CallBack() {
                @Override
                public void complete(Object object) {
                    spnSiteNo.setSelection(0, false);
                    spnSiteNo.setOnItemSelectedListener(new OnItemSelectedListener() {
                        public void onItemSelected(AdapterView<?> parent, View view,    int position, long id) {
                            Util.d("onItemSelected position / id : " + position + " / " + id);
                            runOnUiThread(new Runnable() {
                                public void run() {
                                    if (spnSiteNo.loaded ) {
                                        Util.i("spnSiteNo list execute!");
                                        retrieve();
//                                      spnChargeSiteNo.loaded = false;
                                    }
                                }
                            });
                        }
                        @Override
                        public void onNothingSelected(AdapterView<?> arg0) {
                        }
                    });
                    spnSiteNo.loaded = true;
                    Util.d("spnSiteNo.getValue() : " + spnSiteNo.getValue());
                    if ( SiteType.GAMRI == var.SITE_TYPE) { // 감리사
                        // 관할현장 code_control_site
                        spnChargeSiteNo.setPrompt("관할현장");
                        spnChargeSiteNo.getSysCode("codeControlSite",spnSiteNo.getValue(), "",new CallBack() {
                            @Override
                            public void complete(Object object) {
                                spnChargeSiteNo.setSelection(0, false);
                                spnChargeSiteNo.setOnItemSelectedListener(new OnItemSelectedListener() {
                                    public void onItemSelected(AdapterView<?> parent, View view,    int position, long id) {
                                        Util.d("spnChargeSiteNo onItemSelected position / id : " + position + " / " + id);
//                                              if ( spnChargeSiteNo.loaded ) {
                                                    Util.i("spnChargeSiteNo list execute!");
                                                    retrieve();
//                                              }
                                    }
                                    @Override
                                    public void onNothingSelected(AdapterView<?> arg0) {
                                    }
                                });
                                spnChargeSiteNo.loaded = true;
                            }
                        });
                    }
                }
            });

            // 공종
            spnCnsttypecd.setPrompt("공종");
            spnCnsttypecd.getSysCode("codeCnsttypecd",var.USER_ID, R.string.label_all,new CallBack() {
                @Override
                public void complete(Object object) {
                    spnCnsttypecd.setSelection(0, false);
                    spnCnsttypecd.setOnItemSelectedListener(new OnItemSelectedListener() {
                        public void onItemSelected(AdapterView<?> parent, View view,    int position, long id) {
                            if ( spnCnsttypecd.loaded ) {
                                Util.i("spnCnsttypecd list execute!");
                                retrieve();
                            }
                        }
                        @Override
                        public void onNothingSelected(AdapterView<?> arg0) {
                        }
                    });
                    spnCnsttypecd.loaded = true;
                }
            });

            // 진행상태
            spnIspnPrgrs.setPrompt("진행상태");
            spnIspnPrgrs.getCode("IS01",R.string.label_all, new CallBack() {
                @Override
                public void complete(Object object) {
                    spnIspnPrgrs.setSelection(0, false);
                    spnIspnPrgrs.setOnItemSelectedListener(new OnItemSelectedListener() {
                        public void onItemSelected(AdapterView<?> parent, View view,    int position, long id) {
                            if ( spnIspnPrgrs.loaded ) {
                                Util.i("spnIspnPrgrs list execute!");
                                retrieve();
                            }
                        }
                        @Override
                        public void onNothingSelected(AdapterView<?> arg0) {
                        }
                    });
                    spnIspnPrgrs.loaded = true;
                }
            });
       	    retrieve();
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    @SuppressLint("NewApi")
    private void list() {
        String inParams = "";
        TestChkMainDTOIn in = new TestChkMainDTOIn();
            TestChkMainDTO data = new TestChkMainDTO();
            if ( SiteType.SIGONG == var.SITE_TYPE) { // 시공사
                data.setpSiteNo(getValue(spnSiteNo)); // 현장번호[담당]
            } else if ( SiteType.GAMRI == var.SITE_TYPE) { // 감리사
                data.setpSiteNo(getValue(spnChargeSiteNo)); // 현장번호[관할]
            }
            data.setpCnsttypecd(getValue(spnCnsttypecd)); // 공종
            data.setpChkDtYyyymm(getValue(etChkDtYyyymm).replaceAll("-", "")); // 년월
            data.setpIspnPrgrs(getValue(spnIspnPrgrs)); // 진행상태
        in.setData(data);
        Gson gson = new Gson();
        inParams = gson.toJson(in);
        String servcie = "testChkMain";
        Util.i(" list[" +servcie+"] in param json : " + inParams);
        new AsyncHttp<TestChkMainDTOOut,TestChkMainDTOOut>(this) {
//            private TestChkMainDTOOut result;
            @Override
            public void complete(TestChkMainDTOOut result) {
                    Util.i(result.getClass().getName() +" result : " + result);
//                  JSONObject result;
//                  JSONArray  data;
                    try {
                        lv1.setLayoutManager(new LinearLayoutManager(TestChkMainActivity.this));
                        lv1.setHasFixedSize(true);
                        lv1.setNestedScrollingEnabled(true);
                        ArrayList<TestChkMainDTO> data = result.getData();
                        lv1.setAdapter(new TestChkMainAdapter(TestChkMainActivity.this, getLayoutInflater(),data));
                        TestChkMainActivity.this.stopProgressBar();
                        ScrollView sv = (ScrollView)findViewById(R.id.scrollView1);
                        sv.setScrollY(0);
                    } catch (Exception e) {
                        e.printStackTrace();
                    }
            }
            @Override
            public void callback(TestChkMainDTOOut result) {
//                this.result = result;
//              TestChkMainActivity.this.alert("끝나면 실행한다.");
            }
        }.execute(new AsyncHttpParam(Constant.SERVER_CHECK_URL,
        							 new FormEncodingBuilder().add("p", inParams),servcie));
    }

    @OnClick({R.id.ib_cal,R.id.btn_new_reg})
    public void onClick(View v) {
        int viewID = v.getId();
        if ( viewID == R.id.ib_cal ) {
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
		                        retrieve();
	                    	}
	                    }
                	}
                }
            },chkDtYyyy==-1?cal.get(Calendar.YEAR):chkDtYyyy,chkDtMm==-1?cal.get(Calendar.MONTH):chkDtMm, 1);
            datePicker.show();
        } else if ( viewID == R.id.btn_new_reg ) { // 신규작성.
			WUtil.goBldChkupWrt(this, WConstant.WRITE_MODE_FISRT,spnSiteNo.getValue());
        }
    }

    @Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
	  if ( resultCode == WConstant.PROC_ID_BLD_CHKUP_WRT_FIRST ) {
		  retrieve();
	  } else if ( resultCode == WConstant.PROC_ID_TEST_REQ_DOC_SAVE_TYPE_SAVE || resultCode == WConstant.PROC_ID_TEST_REQ_DOC_SAVE_TYPE_COMPLETE ) {
		  retrieve();
	  } else if ( resultCode == WConstant.PROC_ID_TEST_RSLT_WRT_SAVE_TYPE_COMPLETE ) {
		  retrieve();
	  }
	}

	@OnEditorAction({R.id.et_chk_dt_yyyymm})
    public boolean onEditorAction(TextView v, int actionId, KeyEvent event) {
        if ((actionId == EditorInfo.IME_ACTION_DONE) ||
                (event != null && event.getKeyCode() == KeyEvent.KEYCODE_ENTER)) {
            onClick(getView( R.id.ib_cal));
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
//      AppContext.putValue("et_search", getValue(R.id.et_search));
    }

    @Override
    protected void onResume() {
        super.onResume();
//      setText(R.id.et_search,AppContext.getValue("et_search").toString());
    }
}
