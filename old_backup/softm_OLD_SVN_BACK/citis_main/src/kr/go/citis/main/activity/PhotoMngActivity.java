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
import kr.go.citis.main.adapter.PhotoMngAdapter;
import kr.go.citis.main.common.LinearLayoutManager;
import kr.go.citis.main.common.WConstant;
import kr.go.citis.main.common.WUtil;
import kr.go.citis.main.dto.PicMngListDTO;
import kr.go.citis.main.dto.in.PicMngListDTOIn;
import kr.go.citis.main.dto.out.PicMngListDTOOut;
import android.annotation.SuppressLint;
import android.app.DatePickerDialog.OnDateSetListener;
import android.content.Intent;
import android.graphics.drawable.Drawable;
import android.os.Bundle;
import android.support.v7.widget.RecyclerView;
import android.view.KeyEvent;
import android.view.MotionEvent;
import android.view.View;
import android.view.inputmethod.EditorInfo;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ScrollView;
import android.widget.TextView;
import butterknife.Bind;
import butterknife.OnClick;
import butterknife.OnEditorAction;

import com.google.gson.Gson;
import com.squareup.okhttp.FormEncodingBuilder;

/**
 * @author softm
 * PhotoMngActivity
 * 검측체크 메인
 */
@SuppressLint({ "HandlerLeak", "ClickableViewAccessibility" })
public class PhotoMngActivity extends BasicActivity implements OnTopClickListner {
    public static final String TAG = Constant.LOG_TAG;

    @Bind(R.id.spn_site_no       ) public SpinnerCd spnSiteNo; // 담당현장번호
    @Bind(R.id.spn_charge_site_no) SpinnerCd spnChargeSiteNo ; // 관할현장번호
    @Bind(R.id.spn_cnsttypecd    ) SpinnerCd spnCnsttypecd   ; // 공종
    @Bind(R.id.et_yyyymm         ) EditText  etYyyymm        ; // 년월

    @Bind(R.id.listView1         ) RecyclerView lv1       ;
    @Bind(R.id.ib_cal            ) ImageButton  mBtnCal   ;
    @Bind(R.id.btn_new_reg       ) Button       btnNewReg ;
    
    int mm;
	int yyyy;

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
	    setLayout(R.layout.activity_photo_mng);
	    setTopTitle(R.string.title_photo_mng);
		
        Calendar cal = Calendar.getInstance();
        yyyy = cal.get(Calendar.YEAR);
        mm   = cal.get(Calendar.MONTH);
        if ( SiteType.GAMRI == var.SITE_TYPE) { // 감리사
            setVisibility(R.id.tv_charge_site_no);
            setVisibility(R.id.spn_charge_site_no);
//            setInVisibility(btnNewReg,View.GONE);
        } else {
            setInVisibility(R.id.tv_charge_site_no);
            setInVisibility(R.id.spn_charge_site_no);
        }
        etYyyymm.setText(String.format("%04d-%02d", yyyy,mm+1));
        etYyyymm.setInputType(0);
        final Drawable x = getResources().getDrawable(android.R.drawable.ic_menu_close_clear_cancel);
//        Drawable x = getResources().getDrawable(android.R.drawable.ic_input_delete);
        x.setBounds(0, 0, x.getIntrinsicWidth(), x.getIntrinsicHeight());
        etYyyymm.setCompoundDrawables(null, null, x, null);
        etYyyymm.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View view, MotionEvent motionEvent) {
                if (motionEvent.getAction() == MotionEvent.ACTION_UP){
//                    if (motionEvent.getX()>(view.getWidth()-view.getPaddingRight())){
                    if (motionEvent.getX()>(view.getWidth()-x.getIntrinsicWidth()-view.getPaddingRight())){
                        ((EditText)view).setText("");
                        yyyy = -1;
                        mm   = -1;
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

       	    retrieve();
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    @SuppressLint("NewApi")
    private void list() {
        String inParams = "";
        PicMngListDTOIn in = new PicMngListDTOIn();
            PicMngListDTO data = new PicMngListDTO();
            if ( SiteType.SIGONG == var.SITE_TYPE) { // 시공사
                data.setpSiteNo(getValue(spnSiteNo)); // 현장번호[담당]
            } else if ( SiteType.GAMRI == var.SITE_TYPE) { // 감리사
                data.setpSiteNo(getValue(spnChargeSiteNo)); // 현장번호[관할]
            }
            data.setpCnsttypecd(getValue(spnCnsttypecd)); // 공종
            data.setpYyyymm(getValue(etYyyymm).replaceAll("-", "")); // 년월
        in.setData(data);
        Gson gson = new Gson();
        inParams = gson.toJson(in);
        String servcie = "picMngList"; // picMngList	pic_mng_list

        Util.i(" list[" +servcie+"] in param json : " + inParams);
        new AsyncHttp<PicMngListDTOOut,PicMngListDTOOut>(this) {
//            private PicMngListDTOOut result;
            @Override
            public void complete(PicMngListDTOOut result) {
                    Util.i(result.getClass().getName() +" result : " + result);
//                  JSONObject result;
//                  JSONArray  data;
                    try {
                        lv1.setLayoutManager(new LinearLayoutManager(PhotoMngActivity.this));
                        lv1.setHasFixedSize(true);
                        lv1.setNestedScrollingEnabled(true);
                        ArrayList<PicMngListDTO> data = result.getData();
                        lv1.setAdapter(new PhotoMngAdapter(PhotoMngActivity.this, getLayoutInflater(),data));
                        PhotoMngActivity.this.stopProgressBar();
                        ScrollView sv = (ScrollView)findViewById(R.id.scrollView1);
                        sv.setScrollY(0);
                    } catch (Exception e) {
                        e.printStackTrace();
                    }
            }
            @Override
            public void callback(PicMngListDTOOut result) {
//                this.result = result;
//              PhotoMngActivity.this.alert("끝나면 실행한다.");
            }
        }.execute(new AsyncHttpParam(Constant.SERVER_DATA_URL,
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
	                    if (yyyy != year  || mm != monthOfYear ) {
	                    	if ( year != -1 ) {
		                        yyyy = year;
		                        mm   = monthOfYear;
		                        etYyyymm.setText(String.format("%04d-%02d", yyyy,mm+1));
		                        retrieve();
	                    	}
	                    }
                	}
                }
            },yyyy==-1?cal.get(Calendar.YEAR):yyyy,mm==-1?cal.get(Calendar.MONTH):mm, 1);
            datePicker.show();
        } else if ( viewID == R.id.btn_new_reg ) { // 작성.
            if ( SiteType.SIGONG == var.SITE_TYPE) { // 시공사
                WUtil.goPhotoMngDtl(this, WConstant.WRITE_MODE_FISRT,spnSiteNo.getValue(),""); // 현장번호[담당]
            } else if ( SiteType.GAMRI == var.SITE_TYPE) { // 감리사
                WUtil.goPhotoMngDtl(this, WConstant.WRITE_MODE_FISRT,spnChargeSiteNo.getValue(),""); // 현장번호[관할]            	
            }
        }
    }

    @Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
	  if ( resultCode == WConstant.PROC_ID_PHOTO_MNG_WRT_FIRST ) {
		  retrieve();
	  } else if ( resultCode == WConstant.PROC_ID_PHOTO_MNG_WRT_UPDATE) {
		  retrieve();
	  } else if ( resultCode == WConstant.PROC_ID_PHOTO_MNG_DTL_DELETE) {
		  retrieve();
	  }
	}

	@OnEditorAction({R.id.et_yyyymm})
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
