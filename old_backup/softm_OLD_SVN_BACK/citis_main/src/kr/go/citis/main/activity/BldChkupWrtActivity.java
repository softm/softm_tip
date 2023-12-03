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
import kr.go.citis.main.adapter.BldChkupWrtAdapter;
import kr.go.citis.main.common.LinearLayoutManager;
import kr.go.citis.main.common.WConstant;
import kr.go.citis.main.common.WUtil;
import kr.go.citis.main.dto.BldChkupWrtDtlDTO;
import kr.go.citis.main.dto.BldChkupWrtDtlSaveDTO;
import kr.go.citis.main.dto.BldChkupWrtDupChkDTO;
import kr.go.citis.main.dto.BldChkupWrtItemListDTO;
import kr.go.citis.main.dto.BldChkupWrtItemSaveDTO;
import kr.go.citis.main.dto.in.BldChkupWrtDtlDTOIn;
import kr.go.citis.main.dto.in.BldChkupWrtDupChkDTOIn;
import kr.go.citis.main.dto.in.BldChkupWrtItemListDTOIn;
import kr.go.citis.main.dto.in.BldChkupWrtSaveDTOIn;
import kr.go.citis.main.dto.out.BldChkupWrtDtlDTOOut;
import kr.go.citis.main.dto.out.BldChkupWrtDupChkDTOOut;
import kr.go.citis.main.dto.out.BldChkupWrtItemListDTOOut;

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
 * BldChkupWrtActivity
 * 시공사점검 작성
 */
@SuppressLint({ "HandlerLeak", "ClickableViewAccessibility" })
public class BldChkupWrtActivity extends BasicActivity implements OnTopClickListner {
    public static final String TAG = Constant.LOG_TAG;

    @Bind(R.id.spn_cnsttypecd   ) SpinnerCd spnCnsttypecd   ; // 공종
    @Bind(R.id.spn_dtlcnsttypecd) SpinnerCd spnDtlcnsttypecd; // 세부공종
    @Bind(R.id.tv_cnsttypecd    ) TextView  tvCnsttypecd    ; // 공종 CODE NO.
    @Bind(R.id.et_chk_dt        ) EditText  etChkDt         ; // 점검일자
    @Bind(R.id.et_plc_prt       ) EditText  etPlcPrt        ; // 위치 및 부위
    @Bind(R.id.et_wrk_amnt      ) EditText  etWrkAmnt       ; // 공사량
    
    @Bind(R.id.listView1        ) RecyclerView lv1;
    
    @Bind(R.id.btn_save         ) Button btnSave;
    @Bind(R.id.btn_end          ) Button btnEnd;
	@Bind(R.id.block            ) public LinearLayout mBlock; // adapter에서 참조.

	public String pSiteNo        ; // 담당현장
	public String pIspnChkMgntSeq; // 검측마스터번호
	public String pIspnChkSeq    ; // 검측체크번호
	public String wMode          ; // 작성/재작성 [W/RW]
	
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
		wMode           = StringUtils.defaultString(i.getStringExtra("w_mode"           )); // W/RW 작성/재작성
		pSiteNo         = StringUtils.defaultString(i.getStringExtra("site_no"          )); // 담당현장
		pIspnChkMgntSeq = StringUtils.defaultString(i.getStringExtra("ispn_chk_mgnt_seq")); // 검측마스터번호
		pIspnChkSeq     = StringUtils.defaultString(i.getStringExtra("ispn_chk_seq"     )); // 검측체크번호
	    if ( 
	    		( wMode.equals(WConstant.WRITE_MODE_FISRT ) && StringUtils.isNotEmpty(pIspnChkMgntSeq + pIspnChkSeq) ) // 작성이면서 parameter있음
	    	||  ( wMode.equals(WConstant.WRITE_MODE_SECOND) && StringUtils.isEmpty(pIspnChkMgntSeq + pIspnChkSeq) )    // 재작성이면서 parameter없음
	    	||  ( ( wMode.equals(WConstant.WRITE_MODE_UPDATE) ) && StringUtils.isEmpty(pIspnChkMgntSeq + pIspnChkSeq) ) // 수정이면서  parameter 없음
	    ) {
	        alert(R.string.msg_not_exec_alert
	                , new DialogInterface.OnClickListener() {
	                    public void onClick(DialogInterface dialog, int whichButton) {
	                        finish();
	                    }
	                }
	        );
	    }
	    loast("wMode / pIspnChkMgntSeq / pIspnChkSeq: " + wMode + " / " + pIspnChkMgntSeq + " / " + pIspnChkSeq);
	    Util.d("wMode / pIspnChkMgntSeq / pIspnChkSeq: " + wMode + " / " + pIspnChkMgntSeq + " / " + pIspnChkSeq);
	    setLayout(R.layout.activity_bld_chkup_wrt);
	    setTopTitle(R.string.title_bld_chkup_wrt);	    

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
        	if ( wMode.equals(WConstant.WRITE_MODE_UPDATE) ) {
            	setDisabled(spnCnsttypecd);                        	
            	setDisabled(spnDtlcnsttypecd);                        	
        	}
        }
    }

    @SuppressLint("NewApi")
    private void list() {
        String inParams = "";
        BldChkupWrtItemListDTOIn in = new BldChkupWrtItemListDTOIn();
            BldChkupWrtItemListDTO data = new BldChkupWrtItemListDTO();
            data.setwMode(wMode);            
            data.setpIspnChkMgntSeq(pIspnChkMgntSeq);            
            data.setpIspnChkSeq(pIspnChkSeq);
            data.setpDtlcnsttypecd(spnDtlcnsttypecd.getValue()); // 세부공종
            data.setpSiteNo(pSiteNo); // 담당현장
        in.setData(data);
        Gson gson = new Gson();
        inParams = gson.toJson(in);
        String servcie = "bldChkupWrtItemList";
        Util.i(" list[" +servcie+"] in param json : " + inParams);
        new AsyncHttp<BldChkupWrtItemListDTOOut,BldChkupWrtItemListDTOOut>(this) {
//            private BldChkupWrtItemListDTOOut result;
            @Override
            public void complete(BldChkupWrtItemListDTOOut result) {
                Util.i(result.getClass().getName() +" result : " + result);
                try {
                    lv1.setLayoutManager(new LinearLayoutManager(BldChkupWrtActivity.this));
                    lv1.setHasFixedSize(true);
                    lv1.setNestedScrollingEnabled(true);
                    ArrayList<BldChkupWrtItemListDTO> data = result.getData();
                    BldChkupWrtAdapter adapter = new BldChkupWrtAdapter(BldChkupWrtActivity.this, getLayoutInflater(),data);
                    if ( !lv1.isEnabled() ) {
                    	getView(R.id.block).setVisibility(View.VISIBLE);
                    	adapter.setEnable(lv1.isEnabled());
                    }
                    lv1.setAdapter(adapter);
                    BldChkupWrtActivity.this.stopProgressBar();
                    ScrollView sv = (ScrollView)findViewById(R.id.scrollView1);
                    sv.setScrollY(0);
                } catch (Exception e) {
                    e.printStackTrace();
                }
            }
            @Override
            public void callback(BldChkupWrtItemListDTOOut result) {
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
    	data.setwMode(wMode);            
    	data.setpIspnChkMgntSeq(pIspnChkMgntSeq);            
    	data.setpIspnChkSeq(pIspnChkSeq);            
    	in.setData(data);
    	Gson gson = new Gson();
    	inParams = gson.toJson(in);
    	String servcie = "bldChkupWrtDtl"; // bld_chkup_wrt_dtl
    	Util.i(" list[" +servcie+"] in param json : " + inParams);
    	new AsyncHttp<BldChkupWrtDtlDTOOut,BldChkupWrtItemListDTOOut>(this) {
//    		private BldChkupWrtDtlDTOOut result;
    		@Override
    		public void complete(BldChkupWrtDtlDTOOut result) {
    			Util.i(result.getClass().getName() +" result : " + result);
    			try {
    				BldChkupWrtActivity.this.stopProgressBar();
    				BldChkupWrtDtlDTO data = result.getData();
    				tvCnsttypecd.setText(data.getDtlcnsttypecd());    				
    				spnCnsttypecd.setValue(data.getCnsttypecd());
    				spnDtlcnsttypecd.setValue(data.getDtlcnsttypecd());
    			    etChkDt.setText(WUtil.toDateFormat(data.getChkDt())); // 점검일자
    			    etPlcPrt.setText(data.getPlcPrt()); // 위치 및 부위
    			    etWrkAmnt.setText(data.getWrkAmnt()); // 공사량
    			    if ( SiteType.SIGONG == var.SITE_TYPE ) { // 시공사
	    			    if ( WConstant.WRITE_MODE_SECOND.equals(wMode) ) { // 재작성
	    			    	etChkDt.setText("");
				    		setDisabled(spnCnsttypecd);
				    		setDisabled(spnDtlcnsttypecd);
				    		setDisabled(etPlcPrt);
				    		setDisabled(etWrkAmnt);
	//			    		setDisabled(lv1);
	                		btnSave.setVisibility(View.VISIBLE);
	                		btnEnd.setVisibility(View.VISIBLE);
	    			    } else if ( WConstant.WRITE_MODE_UPDATE.equals(wMode) ) { // 수정
	    			    	if ( StringUtils.isNotEmpty(data.getChkDt()) ) {
	    			    		setDisabled(spnCnsttypecd);
	    			    		setDisabled(spnDtlcnsttypecd);
	    			    		setDisabled(etPlcPrt);
	    			    		setDisabled(etWrkAmnt);
	    			    		setDisabled(lv1);
	    			    	} else {
	    			    		btnSave.setVisibility(View.VISIBLE);
	    			    		btnEnd.setVisibility(View.VISIBLE);
	    			    	}
	    			    } else { // 작성
	                        btnSave.setVisibility(View.VISIBLE);
	                        btnEnd.setVisibility(View.VISIBLE);
	    			    }
    			    } else if ( SiteType.GAMRI == var.SITE_TYPE ) { // 감리사
			    		setDisabled(spnCnsttypecd);
			    		setDisabled(spnDtlcnsttypecd);
			    		setDisabled(etPlcPrt);
			    		setDisabled(etWrkAmnt);
			    		setDisabled(lv1);
    			    }
    			} catch (Exception e) {
    				e.printStackTrace();
    			}
    		}
    		@Override
    		public void callback(BldChkupWrtDtlDTOOut result) {
//    			this.result = result;
//              TestChkMainActivity.this.alert("끝나면 실행한다.");
    		}
    	}.sync(new AsyncHttpParam(Constant.SERVER_CHECK_URL,inParams,servcie));
    }
    
    private boolean isDuplicate() {
    	String inParams = "";
    	BldChkupWrtDupChkDTOIn in = new BldChkupWrtDupChkDTOIn();
		in.setSysRegId(var.USER_ID); // 작성자ID
		BldChkupWrtDupChkDTO  data = new BldChkupWrtDupChkDTO();
		data.setpDtlcnsttypecd(getValue(spnDtlcnsttypecd));
		data.setpSiteNo(pSiteNo);
    	in.setData(data);
    	
    	Gson gson = new Gson();
    	inParams = gson.toJson(in);
    	String servcie = "bldChkupWrtDupChk"; // bld_chkup_wrt_dup_chk
    	Util.i(" list[" +servcie+"] in param json : " + inParams);
    	
    	BldChkupWrtDupChkDTOOut result;
    	result = new AsyncHttp<BldChkupWrtDupChkDTOOut,BldChkupWrtDupChkDTOOut>(this) {
    		@Override
    		public void complete(BldChkupWrtDupChkDTOOut result) {
    		}
    		@Override
    		public void callback(BldChkupWrtDupChkDTOOut result) {
    		}
    	}.syncAs(new AsyncHttpParam(Constant.SERVER_CHECK_URL,
    			new FormEncodingBuilder().add("p", inParams),servcie));
		Util.i(result.getClass().getName() +" result : " + result);
		BldChkupWrtActivity.this.stopProgressBar();
		BldChkupWrtDupChkDTO rtnData = result.getData();
		if ( "-1".equals(rtnData.getIspnChkSeq()) ) { // 중복없음.
			return false;
		} else { // 중복.
			return true;
		}
    }
    
	@OnClick({R.id.btn_save, R.id.btn_end})
    protected void onClick(View v) {
        final int viewID = v.getId();
        if ( viewID == R.id.btn_save || viewID == R.id.btn_end ) {
        	if ( viewID == R.id.btn_end  ) { // 확정
        		if ( isDuplicate() ) {
        			alert(R.string.msg_duplicate_bld_chkup);
        			return;
        		}
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
	
	private void execSave(int viewID) {
    	String inParams = "";
    	BldChkupWrtSaveDTOIn in = new BldChkupWrtSaveDTOIn();
		in.setSysRegId(var.USER_ID); // 작성자ID
    	BldChkupWrtAdapter adapter = (BldChkupWrtAdapter) lv1.getAdapter();
    	ArrayList<BldChkupWrtItemListDTO> listData = adapter.getItems();
    	ArrayList<BldChkupWrtItemSaveDTO> itemData = new ArrayList<BldChkupWrtItemSaveDTO>();        	
    	BldChkupWrtDtlSaveDTO  dtlData = new BldChkupWrtDtlSaveDTO();
		for (BldChkupWrtItemListDTO srcItem : listData) {
			BldChkupWrtItemSaveDTO tgtItem = new BldChkupWrtItemSaveDTO();
			tgtItem.setIspnChkSeq    (pIspnChkSeq                ); // 검측체크번호
			tgtItem.setIspnChkItemSeq(srcItem.getIspnChkItemSeq()); // 검측체크항목번호
			tgtItem.setSiteChkSeq    (srcItem.getSiteChkSeq    ()); // 현장검측체크번호
			tgtItem.setCntrChk       (StringUtils.isNotEmpty(srcItem.getCntrChk())?srcItem.getCntrChk():RsltStatus.FALSE.getTypeCd()); // 시공사점검
		    if ( wMode.equals(WConstant.WRITE_MODE_FISRT ) || wMode.equals(WConstant.WRITE_MODE_SECOND)) { // 작성/재작성
				tgtItem.setMode(WConstant.LIST_DATA_MODE_INSERT);			    	
        	} else if ( wMode.equals(WConstant.WRITE_MODE_UPDATE) ) { // 수정이면서  parameter 없음
				tgtItem.setMode(WConstant.LIST_DATA_MODE_UPDATE);
		    }				
			tgtItem.setwMode(wMode);
			itemData.add(tgtItem);
		}
	    if ( wMode.equals(WConstant.WRITE_MODE_FISRT ) || wMode.equals(WConstant.WRITE_MODE_SECOND)) { // 작성/재작성
	    	dtlData.setMode(WConstant.LIST_DATA_MODE_INSERT);
    	} else if ( wMode.equals(WConstant.WRITE_MODE_UPDATE) ) { // 수정이면서  parameter 없음
    		dtlData.setMode(WConstant.LIST_DATA_MODE_UPDATE);
	    }
	    dtlData.setwMode(wMode);
	    dtlData.setIspnChkMgntSeq(pIspnChkMgntSeq); // 검측마스터번호
	    dtlData.setIspnChkSeq(pIspnChkSeq); // 검측체크번호		    
        dtlData.setCnsttypecd(getValue(spnCnsttypecd)); // 공종코드
        dtlData.setDtlcnsttypecd(getValue(spnDtlcnsttypecd)); // 세부공종코드
//        dtlData.setChkDt(); // 점검일자    
        dtlData.setPlcPrt(getString(etPlcPrt)); // 위치 및 부위
        dtlData.setWrkAmnt(getString(etWrkAmnt)); // 공사량
        dtlData.setSiteNo(pSiteNo); // 현장번호[담당,관할]
        dtlData.setSaveType(viewID == R.id.btn_save?SaveType.SAVE.getTypeCd():SaveType.END.getTypeCd());
        
    	in.setItemData(itemData);
    	in.setDtlData(dtlData);
    	
    	Gson gson = new Gson();
    	inParams = gson.toJson(in);
    	String servcie = "bldChkupWrtSave"; // bld_chkup_wrt_save
    	Util.i(" list[" +servcie+"] in param json : " + inParams);
    	new AsyncHttp<BldChkupWrtDtlDTOOut,BldChkupWrtItemListDTOOut>(this) {
//    		private BldChkupWrtDtlDTOOut result;
    		@Override
    		public void complete(BldChkupWrtDtlDTOOut result) {
    			
    			Util.i(result.getClass().getName() +" result : " + result);
    			try {
    				BldChkupWrtActivity.this.stopProgressBar();
//    				BldChkupWrtDtlDTO data = result.getData();
    				if ( Constant.ERR_CODE_SUCCESS.equals(result.getMsgCode())) {
    					throw new Exception(getString(R.string.msg_saved));        					
    				} else {
    					throw new Exception(result.getMsg());
    				}
    			} catch (Exception e) {
//    				e.printStackTrace();
					alert(e.getMessage(),new DialogInterface.OnClickListener() {
						@Override
						public void onClick(DialogInterface arg0, int arg1) {
							Intent i = BldChkupWrtActivity.this.getIntent();
							BldChkupWrtActivity.this.setResult(WConstant.WRITE_MODE_FISRT.equals(wMode)?WConstant.PROC_ID_BLD_CHKUP_WRT_FIRST:WConstant.PROC_ID_BLD_CHKUP_WRT_SECOND, i);
							finish();
						}
					});        				
    			}
    		}
    		@Override
    		public void callback(BldChkupWrtDtlDTOOut result) {
//    			this.result = result;
//              TestChkMainActivity.this.alert("끝나면 실행한다.");
    		}
    	}.execute(new AsyncHttpParam(Constant.SERVER_CHECK_URL,inParams,servcie));
	}
    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
//      if ( requestCode == Constant.ZBAR_SCANNER_REQUEST ) {
//          if (resultCode == RESULT_OK) {
//              String bfGmNo = WUtil.toDefault(data.getStringExtra(ZBarConstants.SCAN_RESULT));
//              WUtil.goMterChg(BldgListActivity.this, bfGmNo);
////                    Toast.makeText(this, "Scan Result = " + data.getStringExtra(ZBarConstants.SCAN_RESULT), Toast.LENGTH_SHORT).show();
//          } else if(resultCode == RESULT_CANCELED && data != null) {
//              String error = data.getStringExtra(ZBarConstants.ERROR_INFO);
//              if(!TextUtils.isEmpty(error)) {
//                  Toast.makeText(this, error, Toast.LENGTH_SHORT).show();
//              }
//          }
//      } else if ( requestCode == Constant.ZBAR_QR_SCANNER_REQUEST ) {
//
//      }
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
