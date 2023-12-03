package com.entropykorea.gas.chg.activity;

import org.apache.commons.lang3.StringUtils;

import android.annotation.SuppressLint;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.text.TextUtils;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.Toast;

import com.dm.zbar.android.scanner.ZBarConstants;
import com.entropykorea.gas.chg.R;
import com.entropykorea.gas.chg.WApplication;
import com.entropykorea.gas.chg.common.DUtil;
import com.entropykorea.gas.chg.common.WConstant;
import com.entropykorea.gas.chg.common.WUtil;
import com.entropykorea.gas.chg.dto.ChgDTO;
import com.entropykorea.gas.lib.BaseActivity;
import com.entropykorea.gas.lib.Constant;
import com.entropykorea.gas.lib.PicCamera;
import com.entropykorea.gas.lib.SpinnerCd;
import com.entropykorea.gas.lib.TitleView;
import com.entropykorea.gas.lib.TitleView.OnTopClickListner;
import com.entropykorea.gas.lib.Util;
import com.entropykorea.gas.lib.activity.PicViewerActivity;
import com.mypidion.BI300.BI300Bluetooth;

/**
 * @author softm
 * MeterChgActivity
 * 계량기교체
 */
@SuppressLint({ "ClickableViewAccessibility", "HandlerLeak" })
public class MeterChgActivity extends BaseActivity implements OnClickListener, OnTopClickListner, OnMenuItemClickListener {
    public static final String TAG = "MPGAS";

    private String bldg_cd = null;
    private String gm_chg_ym = null;
    private String house_no = null;
    private String cust_no = null;

    private String bf_gm_no            = null;
    private String bf_model            = null;
    private String bf_kind_cd          = null;
    private String bf_type_cd          = null;
    private String bf_maker_cd         = null;
    private String bf_install_loc_gb_cd= null;
    private String bf_make_yy          = null;
    private String bf_union_cnt        = null;
    private String bf_seal_no          = null;
    private String bf_repair_cd        = null;
    private String bf_seal_cd          = null;
    private String af_gm_no            = null;
    private String af_model            = null;
    private String af_kind_cd          = null;
    private String af_type_cd          = null;
    private String af_maker_cd         = null;
    private String af_install_loc_cd   = null;
    private String af_make_yy          = null;
    private String af_union_cnt        = null;
    private String af_seal_no          = null;
    private String af_repair_cd        = null;
    private String af_seal_cd          = null;
    private String chg_remove_meter    = null;
    private String chg_install_meter   = null;
    private String chg_dt              = null;
    private String bf_chg_dt           = null;
    private String photo_file_nm       = null;
    private String room_no             = null;
    
    private String end_yn              = null;
    private String send_yn             = null;

    int SELECT_TYPE = 0; // 1 : KEY값을 이용한 조회 , 2 : 교체전계량기번호를 통한 조회(bf_gm_no)
    final int SELECT_TYPE_KEY      = 1; // 1 : KEY값을 이용한 조회 
    final int SELECT_TYPE_BF_GM_NO = 2; // 2 : 교체전계량기번호를 통한 조회(bf_gm_no)
    
    int SAVE_TYPE   = 0; // 1 : 저장, 2 : 완료
    final int SAVE_TYPE_SAVE     = 1;
    final int SAVE_TYPE_COMPLETE = 2;
    
    private PicCamera pc = null;
    
    private BI300Bluetooth bi300 = null;
    
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        Intent intent = getIntent();
        // 복귀값으로 이용 가능성 있음... 없는경우가 대부분
        bldg_cd = WUtil.toDefault(intent.getStringExtra("bldg_cd"));
        // key
        gm_chg_ym = WUtil.toDefault(intent.getStringExtra("gm_chg_ym"));
        house_no = WUtil.toDefault(intent.getStringExtra("house_no"));
        cust_no = WUtil.toDefault(intent.getStringExtra("cust_no"));

        // 교체전 계량기번호.
        bf_gm_no = WUtil.toDefault(intent.getStringExtra("bf_gm_no"));

        if ( !"".equals(gm_chg_ym) && !"".equals(house_no) && !"".equals(cust_no) ) {
        	setContentView(R.layout.activity_meter_chg);
            SELECT_TYPE = 1;
            init();
            retrive();
        } else {
            if ( !"".equals(bf_gm_no) ) {
            	setContentView(R.layout.activity_meter_chg);
                SELECT_TYPE = 2;
                init();
                retrive();
            } else {
                alert(R.string.msg_not_exec_alert
                    , new DialogInterface.OnClickListener() {
                        public void onClick(DialogInterface dialog, int whichButton) {
                            finish();
                        }
                    }
                );
            }
        }

    }

	@SuppressLint("ClickableViewAccessibility")
	private void init() {
        TitleView tv = new TitleView(this, R.string.title_meter_change);
        tv.setOnTopClickListner(this);

//        ((SpinnerCd)findViewById(R.id.spn_af_install_loc_cd     )).getCode("GM130").setDialogVisible(Boolean.FALSE).setPrompt("설치장소");
        ((SpinnerCd)findViewById(R.id.spn_af_install_loc_cd     )).getCode("GM060").setPrompt("설치장소");
        
//        ((SpinnerCd)findViewById(R.id.spn_af_install_loc_cd     )).setOnTouchListener(new View.OnTouchListener() {
//            @Override
//            public boolean onTouch(View v, MotionEvent event) {
//				if ( event.getAction() == MotionEvent.ACTION_UP ) {            	
//	                SpinnerCd spnAfInstallLocCd= (SpinnerCd)findViewById(R.id.spn_af_install_loc_cd); // 설치장소
//	                int idx = spnAfInstallLocCd.getSelected();
//					spnAfInstallLocCd.setSelected(idx^1);
//				}
//                return false;
//            }
//        });
        ((SpinnerCd)findViewById(R.id.spn_af_model     )).getCode("GM040",R.string.label_spn_non_select).setPrompt("모델(등급)");
        ((SpinnerCd)findViewById(R.id.spn_af_type_cd   )).getCode("GM050",R.string.label_spn_non_select).setPrompt("타입");
        ((SpinnerCd)findViewById(R.id.spn_af_maker_cd  )).getCode("GM070",R.string.label_spn_non_select).setPrompt("제조사");
        ((SpinnerCd)findViewById(R.id.spn_af_kind_cd   )).getCode("GM030",R.string.label_spn_non_select).setPrompt("형식");
        
        ((SpinnerCd)findViewById(R.id.spn_af_repair_cd )).getCode("GM110",R.string.label_spn_non_select).setPrompt("검정");
        ((SpinnerCd)findViewById(R.id.spn_af_union_cnt )).getArrange(0,4).setPrompt("유니온 교테수");
        ((SpinnerCd)findViewById(R.id.spn_af_seal_cd   )).getCode("MA220",R.string.label_spn_non_select).setPrompt("봉인처리");
//        ((SpinnerCd)findViewById(R.id.spn_af_seal_cd   )).setOnItemSelectedListener(new OnItemSelectedListener() {
//            @Override
//            public void onItemSelected(AdapterView<?> parentView, View selectedItemView, int position, long id) {
//            }
//
//            @Override
//            public void onNothingSelected(AdapterView<?> parentView) {
//            }
//
//        });
        findViewById(R.id.ib_b_barcode).setOnClickListener(this);
        findViewById(R.id.ib_close    ).setOnClickListener(this);
        findViewById(R.id.ib_save     ).setOnClickListener(this);
        findViewById(R.id.ib_finish   ).setOnClickListener(this);
        findViewById(R.id.ib_camera   ).setOnClickListener(this);
        findViewById(R.id.ib_photoview).setOnClickListener(this);
//        ((EditText)findViewById(R.id.et_af_gm_no)).addTextChangedListener(new TextWatcher(){
//            public void afterTextChanged(Editable s) {
//            }
//            public void beforeTextChanged(CharSequence s, int start, int count, int after){}
//            public void onTextChanged(CharSequence s, int start, int before, int count){
//               	alert("et~ : " + s + " : " + count);	
//            }
//        });             
    }

    private void retrive() {
    	ChgDTO v = new ChgDTO();
    	if( SELECT_TYPE == SELECT_TYPE_KEY ) {
	        v = DUtil.getDataByWhere(getApplicationContext(), " WHERE GM_CHG_YM   = '" + gm_chg_ym   + "'"
	                + "   AND HOUSE_NO = '" + house_no + "'"
	                + "   AND CUST_NO  = '" + cust_no  + "'"
	        );
    	} else if( SELECT_TYPE == SELECT_TYPE_BF_GM_NO ) {
	        v = DUtil.getDataByWhere(getApplicationContext(), " WHERE BF_GM_NO   = '" + bf_gm_no + "'");
    	}
        gm_chg_ym   = v.getJobYm();
        house_no = v.getHouseNo();
        cust_no  = v.getCustNo();
        if ( "".equals(gm_chg_ym) || "".equals(house_no) || "".equals(cust_no) ) {
              alert(R.string.msg_not_exec_alert
	              , new DialogInterface.OnClickListener() {
	                  public void onClick(DialogInterface dialog, int whichButton) {
	                      finish();
	                  }
	              }
              );			  
        } else {
            bf_gm_no             = v.getBfGmNo()            ; // 교체전계량기번호
            bf_model             = v.getBfModel()           ; // 교체전모델
            bf_kind_cd           = v.getBfKindCd()          ; // 교체전종류코드
            bf_type_cd           = v.getBfTypeCd()          ; // 교체전타입코드
            bf_maker_cd          = v.getBfMakerCd()         ; // 교체전제조사코드
            bf_install_loc_gb_cd = v.getBfInstallLocGbCd()  ; // 교체전설치위치구분
            bf_make_yy           = v.getBfMakeYy()          ; // 교체전제조년도
            bf_union_cnt         = v.getBfUnionCnt()        ; // 교체전유니온갯수
            bf_seal_no           = v.getBfSealNo()          ; // 교체전유니온키퍼번호
            bf_repair_cd         = v.getBfRepairCd()        ; // 교체전검정품구분코드
            bf_seal_cd           = v.getBfSealCd()          ; // 교체전봉인방법
            af_gm_no             = v.getAfGmNo()            ; // 교체후계량기번호
            af_model             = v.getAfModel()           ; // 교체후모델명
            af_kind_cd           = v.getAfKindCd()          ; // 교체후종류코드
            af_type_cd           = v.getAfTypeCd()          ; // 교체후타입코드
            af_maker_cd          = v.getAfMakerCd()         ; // 교체후제조사코드
            af_install_loc_cd    = v.getAfInstallLocCd()    ; // 교체후설치위치코드
            af_make_yy           = v.getAfMakeYy()          ; // 교체후제조년도
            af_union_cnt         = v.getAfUnionCnt()        ; // 교체후유니온갯수
            af_seal_no           = v.getAfSealNo()          ; // 교체후유니온키퍼번호
            af_repair_cd         = v.getAfRepairCd()        ; // 교체후검정품구분코드
            af_seal_cd           = v.getAfSealCd()          ; // 교체후봉인방법
            chg_remove_meter     = v.getChgRemoveMeter()    ; // 교체철거지침
            chg_install_meter    = v.getChgInstallMeter()   ; // 교체설치지침
            chg_dt               = v.getChgDt()             ; // 교체일자
            bf_chg_dt            = v.getBfInstallDt()       ; // 이전교체일자
            photo_file_nm        = v.getPhotoFileNm()       ; // 철거계량기사진파일명
            bldg_cd              = v.getBldgCd()            ; //
            room_no              = v.getRoomNo()            ; // room_no
            
            end_yn               = v.getEndYn()             ; // end_yn
            send_yn              = v.getSendYn()            ; // send_yn
            
            setText(R.id.tv_bf_gm_no            ,  bf_gm_no            );
            setText(R.id.et_chg_remove_meter    ,  chg_remove_meter    );
//            setText(R.id.tv_bf_install_loc_gb_cd,  DUtil.getCodeNm(this.getApplicationContext(),"GM130", bf_install_loc_gb_cd)); // 설치장소
            setText(R.id.tv_bf_install_loc_gb_cd,  DUtil.getCodeNm(this.getApplicationContext(),"GM060", bf_install_loc_gb_cd)); // 설치장소
            setText(R.id.tv_bf_model            ,  DUtil.getCodeNm(this.getApplicationContext(),"GM040", bf_model    )); // 모델(등급)
            setText(R.id.tv_bf_type_cd          ,  DUtil.getCodeNm(this.getApplicationContext(),"GM050", bf_type_cd  )); // 타입
            setText(R.id.tv_bf_maker_cd         ,  DUtil.getCodeNm(this.getApplicationContext(),"GM070", bf_maker_cd )); // 제조사
            setText(R.id.tv_bf_kind_cd          ,  DUtil.getCodeNm(this.getApplicationContext(),"GM030", bf_kind_cd  )); // 형식
            setText(R.id.tv_bf_repair_cd        ,  DUtil.getCodeNm(this.getApplicationContext(),"GM110", bf_repair_cd)); // 검정
            setText(R.id.tv_bf_chg_dt           ,  StringUtils.left(bf_chg_dt,10));
            setText(R.id.tv_bf_union_cnt        ,  bf_union_cnt        ); // 유니온 교테수
            setText(R.id.tv_bf_seal_no          ,  bf_seal_no          );
            setText(R.id.tv_bf_seal_cd          ,  DUtil.getCodeNm(this.getApplicationContext(),"MA220", bf_seal_cd  )); // 봉인처리

            setText(R.id.et_af_gm_no            ,  af_gm_no            );
            setText(R.id.et_chg_install_meter   ,  StringUtils.isEmpty(chg_install_meter)?"0":chg_install_meter   );
            setText(R.id.spn_af_install_loc_cd  ,  af_install_loc_cd   );
            setText(R.id.spn_af_model           ,  af_model            );
            setText(R.id.spn_af_type_cd         ,  af_type_cd          );
            setText(R.id.spn_af_maker_cd        ,  af_maker_cd         );
            setText(R.id.spn_af_kind_cd         ,  af_kind_cd          );
            setText(R.id.spn_af_repair_cd       ,  af_repair_cd        );
//            setText(R.id.tv_chg_dt              ,  chg_dt              );
//            setText(R.id.tv_chg_dt              ,  "".equals(chg_dt)?Util.getSysYYYYMMDDFormat():chg_dt);
//            setText(R.id.tv_chg_dt              ,  "".equals(chg_dt)?Util.getSysYYYYMMDDHHMMSSFormat():chg_dt);
            setText(R.id.tv_chg_dt              ,  Util.getSysYYYYMMDDFormat());
            setText(R.id.spn_af_union_cnt       ,  af_union_cnt        );
            setText(R.id.et_af_seal_no          ,  af_seal_no          );
            setText(R.id.spn_af_seal_cd         ,  af_seal_cd          );

            setText(R.id.tv_room_no             ,  room_no             );
            
            if ( "".equals(af_install_loc_cd) && !"".equals(bf_install_loc_gb_cd) ) { // default
            	setText(R.id.spn_af_install_loc_cd,bf_install_loc_gb_cd);
            }
            
            if ( send_yn.equals(Constant.CODE_SEND_Y) ) { // 송신완료.
            	setVisibility(R.id.ib_save,View.INVISIBLE);
            	setVisibility(R.id.ib_b_barcode,View.INVISIBLE);
            	setVisibility(R.id.ib_camera   ,View.INVISIBLE);            	
//            	setEnabled(R.id.ib_save,Boolean.FALSE);
            } else {
            	
            }
        	pc = new PicCamera(this, Constant.PIC_DIR,PicCamera.MODE_PICTURE,gm_chg_ym + house_no + cust_no,".jpg");
    		if ( pc.fileCount() > 0 ) {
    			setVisibility(R.id.ib_photoview,View.VISIBLE);
    		} else {
    			setVisibility(R.id.ib_photoview,View.GONE);			
    		}
        }
    }
    
    private String updateSql;
    /**
     * 저장
     * @param gb 1 : 저장, 2 : 완료
     */
    private boolean fSaveInfo(int saveType) {
    	SAVE_TYPE = saveType;
    	String afGmNo           = WUtil.toDefault(getValue(R.id.et_af_gm_no          ));
        String chgRemoveMeter   = WUtil.toDefault(getValue(R.id.et_chg_remove_meter  ));
        String chgInstallMeter  = WUtil.toDefault(getValue(R.id.et_chg_install_meter ));
        String afSealNo         = WUtil.toDefault(getValue(R.id.et_af_seal_no        ));
        
        String afInstallLocCd   = WUtil.toDefault(getValue(R.id.spn_af_install_loc_cd));
        String afModel          = WUtil.toDefault(getValue(R.id.spn_af_model         ));
        String afTypeCd         = WUtil.toDefault(getValue(R.id.spn_af_type_cd       ));
        String afMakerCd        = WUtil.toDefault(getValue(R.id.spn_af_maker_cd      ));
        String afKindCd         = WUtil.toDefault(getValue(R.id.spn_af_kind_cd       ));
        String afRepairCd       = WUtil.toDefault(getValue(R.id.spn_af_repair_cd     ));
//        String chgDt            = WUtil.toDefault(getValue(R.id.tv_chg_dt            ));
        String afUnionCnt       = WUtil.toDefault(getValue(R.id.spn_af_union_cnt     ));
        String afSealCd         = WUtil.toDefault(getValue(R.id.spn_af_seal_cd       ));

        boolean exec = true;
        if ( "".equals(afGmNo) ) {
        	alert(R.string.msg_do_input_af_gm_no
  	              , new DialogInterface.OnClickListener() {
        			public void onClick(DialogInterface dialog, int whichButton) {
        				setFocus(R.id.et_af_gm_no);
        			}}); // 설치계량기번호를 입력하세요.
        	exec = false;
        } else if ( afGmNo.length() != 12 ) {
        	alert(R.string.msg_do_input_12_af_gm_no // 설치계량기번호를 12자리로 입력하세요.
    	              , new DialogInterface.OnClickListener() {
          			public void onClick(DialogInterface dialog, int whichButton) {
          				setFocus(R.id.et_af_gm_no);
          			}});
        	exec = false;        	
        } else if ( "".equals(chgRemoveMeter) ) {
        	alert(R.string.msg_do_input_chg_remove_meter
	              , new DialogInterface.OnClickListener() {
      			    public void onClick(DialogInterface dialog, int whichButton) {
      			    	setFocus(R.id.et_chg_remove_meter);        	
      			    }}); // 철거계량기 지침을 입력하세요.
        	exec = false;
        } else if ( "".equals(chgInstallMeter) ) {
        	alert(R.string.msg_do_input_chg_install_meter  // 설치계량기 지침을 입력하세요.
  	              , new DialogInterface.OnClickListener() {
        			    public void onClick(DialogInterface dialog, int whichButton) {
        			    	setFocus(R.id.et_chg_install_meter);        	
        			    }});
        	exec = false;
        } else if ( "".equals(afInstallLocCd) ) {
        	alert(R.string.msg_select_af_install_loc_cd  // 설치장소를 선택하세요.
    	              , new DialogInterface.OnClickListener() {
          			    public void onClick(DialogInterface dialog, int whichButton) {
          			    	setFocus(R.id.spn_af_install_loc_cd);        	
          			    }});
        	exec = false;
        } else if ( "".equals(afModel) ) {
        	alert(R.string.msg_select_af_model  // 설치장소를 선택하세요.
  	              , new DialogInterface.OnClickListener() {
        			    public void onClick(DialogInterface dialog, int whichButton) {
        			    	setFocus(R.id.spn_af_model);        	
        			    }});        	
        	exec = false;
        } else if ( "".equals(afTypeCd) ) {
        	alert(R.string.msg_select_af_type_cd  // 타입를 선택하세요.
    	              , new DialogInterface.OnClickListener() {
          			    public void onClick(DialogInterface dialog, int whichButton) {
          			    	setFocus(R.id.spn_af_type_cd);        	
          			    }});
        	exec = false;
        } else if ( "".equals(afMakerCd) ) {
        	alert(R.string.msg_select_af_maker_cd  // 제조사를 선택하세요.
  	              , new DialogInterface.OnClickListener() {
        			    public void onClick(DialogInterface dialog, int whichButton) {
        			    	setFocus(R.id.spn_af_maker_cd);        	
        			    }});
        	exec = false;
        } else if ( "".equals(afKindCd) ) {
        	alert(R.string.msg_select_af_kind_cd  // 형식을 선택하세요.
    	              , new DialogInterface.OnClickListener() {
          			    public void onClick(DialogInterface dialog, int whichButton) {
          			    	setFocus(R.id.spn_af_kind_cd);        	
          			    }});
        	exec = false;
        } else if ( pc.fileCount() == 0 ) {
        	alert(R.string.msg_take_picture);
        	exec = false;        	
        }
        updateSql = "UPDATE " + WConstant.TBL_CHG
			        + " SET CHG_REMOVE_METER  = '" + chgRemoveMeter + "'" // 교체철거지침
			        + "   , CHG_INSTALL_METER = '" + chgInstallMeter+ "'" // 교체설치지침
			        + "   , AF_SEAL_NO        = '" + afSealNo       + "'" // 교체후유니온키퍼번호
			        + "   , AF_GM_NO           = '" + afGmNo               + "'" // 계량기번호
			        + "   , AF_INSTALL_LOC_CD  = '" + afInstallLocCd       + "'" // 설치장소
			        + "   , AF_MODEL           = '" + afModel              + "'" // 모델(등급)
			        + "   , AF_TYPE_CD         = '" + afTypeCd             + "'" // 타입
			        + "   , AF_MAKER_CD        = '" + afMakerCd            + "'" // 제조사
			        + "   , AF_KIND_CD         = '" + afKindCd             + "'" // 형식
			        + "   , AF_REPAIR_CD       = '" + afRepairCd           + "'" // 검정
			        + "   , CHG_DT             = '" + Util.getSysYYYYMMDDHHMMSSFormat() + "'" // 교체일자
                    + "   , CHG_USER_CD        = '" + ((WApplication)mApp).getUserId() + "'" // 교체작업자		        
			        + "   , AF_UNION_CNT       = '" + afUnionCnt           + "'" // 교체후유니온교체수
			        + "   , AF_SEAL_NO         = '" + afSealNo             + "'" // 교체후유니온키퍼번호
			        + "   , AF_SEAL_CD         = '" + afSealCd             + "'" // 봉인처리
			        + " WHERE GM_CHG_YM   = '" + gm_chg_ym   + "'"
			        + "   AND HOUSE_NO = '" + house_no + "'"
			        + "   AND CUST_NO  = '" + cust_no  + "'"
        ;
        return exec;
    }

    @Override
	public void onClick(View v) {
	    int viewID = v.getId();
	    if ( viewID == R.id.ib_save ) { // 저장
	        if ( fSaveInfo(SAVE_TYPE_SAVE) ) {
	        	confirm(R.string.msg_save_confirm, // 저장하시겠습니까?
                new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int whichButton) {
                        db.execSQL(updateSql);
                        Intent sIntent = new Intent(MeterChgActivity.this,HouseListActivity.class); // 수용가목록
                        sIntent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                        sIntent.putExtra("bldg_cd"   , bldg_cd); // 작업년월(PK)
                        startActivity(sIntent);
                        finish();
                    }
                }, new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int whichButton) {
                        // alert("취소");
                    }
                });
	        }
	    } else if ( viewID == R.id.ib_finish ) { // 완료
	    	if ( Constant.CODE_SEND_Y.equals(send_yn) ) {
            	Intent sIntent = new Intent(MeterChgActivity.this,SignActivity.class); // 서명
            	sIntent.putExtra("gm_chg_ym"   , gm_chg_ym); // 작업년월(PK)  
            	sIntent.putExtra("house_no" , house_no); // 수용가번호(PK)
            	sIntent.putExtra("cust_no"  , cust_no); // 고객번호(PK)
            	startActivity(sIntent);
	    	} else {
		        if ( fSaveInfo(SAVE_TYPE_COMPLETE) ) {
		        	confirm(R.string.msg_save_confirm, // 저장하시겠습니까?
		                new DialogInterface.OnClickListener() {
		                    public void onClick(DialogInterface dialog, int whichButton) {
		                        db.execSQL(updateSql);
	                        	Intent sIntent = new Intent(MeterChgActivity.this,SignActivity.class); // 서명
	                        	sIntent.putExtra("gm_chg_ym"   , gm_chg_ym); // 작업년월(PK)  
	                        	sIntent.putExtra("house_no" , house_no); // 수용가번호(PK)
	                        	sIntent.putExtra("cust_no"  , cust_no); // 고객번호(PK)
	                        	startActivity(sIntent);
//	                        	finish();
		                    }
		                }, new DialogInterface.OnClickListener() {
		                    public void onClick(DialogInterface dialog, int whichButton) {
		                        // alert("취소");
		                    }
		                });
		        }
	    	}
	    } else if ( viewID == R.id.ib_close ) { // 닫기
	        finish();
	    } else if ( viewID == R.id.ib_b_barcode ) { // barcode
	    	String barCodeType = ((WApplication)mApp).getBarCodeType();
	    	if ( Constant.CODE_BARCODE_SELF.equals(barCodeType) ) {
	    		launchScanner(v);
	    	} else {
	    		try {
	    			//바코드 블루투스 리더기 연동 
	    			bi300 = new BI300Bluetooth(this,  new Handler() {
	    				@Override
	    				public void handleMessage(android.os.Message msg) {
	    					String message = (String) msg.obj;
	    					switch (msg.what) {
	    					case 1:
	    	                    String afGmNo = WUtil.toDefault(message).trim();
	    	                    fSetAfGmInfo(afGmNo);
	    						break;
	    					}
	    				};
	    			});
	    			bi300.startBI300();
				} catch (Exception e) {
//					alert("바코드스캐너 블루투스 연결하세요.");
				}
	    	}
	    } else if ( viewID == R.id.ib_camera ) { // camera
	    	pc.start();
	    } else if ( viewID == R.id.ib_photoview ) { // picture        	
			Intent intentPic = new Intent(MeterChgActivity.this, PicViewerActivity.class);
			intentPic.putExtra("imgRoot", Constant.PIC_DIR);
			intentPic.putExtra("mode"  , PicCamera.MODE_PICTURE);
			intentPic.putExtra("prefix" , gm_chg_ym + house_no + cust_no);
			intentPic.putExtra("suffix" , ".jpg");
	    	if ( send_yn.equals(Constant.CODE_SEND_Y) ) { // 송신완료.
	    		intentPic.putExtra("delAble" , false);
	    	}
			startActivityForResult(intentPic, Constant.PROC_ID_PIC_VIWER);
	    }
	}

	@Override
    public void onBackPressed() {
        finish();
//      confirm(R.string.msg_finish_confirm
//              , new DialogInterface.OnClickListener() {
//                  public void onClick(DialogInterface dialog, int whichButton) {
//                      finish();
//                  }
//              }
//              , new DialogInterface.OnClickListener() {
//                  public void onClick(DialogInterface dialog, int whichButton) {
////                        alert("취소");
//                  }
//              }
//      );
    }

    /**
     * Top상단 백 버튼 클릭
     * @param v
     */
    @Override
    public void onClickBackButton(View v) {
        onBackPressed();
    }

    /**
     * Top상단 첫번째 버튼 클릭
     */
    @Override
    public void onClickOneButton(View v) {
    }


    /**
     * Top상단 두번째 버튼 클릭
     */
    @Override
    public void onClickTwoButton(View v) {
       	showMenu(v, R.menu.main);     	
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
	
    private void fSetAfGmInfo(String afGmNo) {
        if (afGmNo.length() != 12) {
            alert(R.string.msg_invalid_barcode);
        } else {
        	//    	String yy        = StringUtils.left(afGmNo,2);
        	String afMakerCd = StringUtils.mid(afGmNo, 2, 1); // 제조사
        	String afModel   = StringUtils.mid(afGmNo, 3, 1); // 모델(등급)
        	String afTypeCd  = StringUtils.mid(afGmNo, 4, 1); // 타입
        	setText(R.id.et_af_gm_no    ,afGmNo   );
        	setText(R.id.spn_af_maker_cd,afMakerCd);
        	setText(R.id.spn_af_model   ,afModel  );
        	setText(R.id.spn_af_type_cd ,afTypeCd );
        }
    }
    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        if ( requestCode == Constant.ZBAR_SCANNER_REQUEST ) {
            if (resultCode == RESULT_OK) {
                String afGmNo = WUtil.toDefault(data.getStringExtra(ZBarConstants.SCAN_RESULT));
                fSetAfGmInfo(afGmNo);
            } else if(resultCode == RESULT_CANCELED && data != null) {
                String error = data.getStringExtra(ZBarConstants.ERROR_INFO);
                if(!TextUtils.isEmpty(error)) {
                    Toast.makeText(this, error, Toast.LENGTH_SHORT).show();
                }
            }
        } else if ( requestCode == Constant.ZBAR_QR_SCANNER_REQUEST ) {
        } else if ( requestCode == Constant.PROC_ID_TAKE_CAMERA ) {
    		if ( resultCode != 0 ) {
    			pc.save();
    			if ( pc.fileCount() > 0 ) {
    				String[] files = pc.getFiles();
    				if ( files.length > 0 ) {
	                    try {
	                    	String sql = "UPDATE " + WConstant.TBL_CHG
	                                + " SET PHOTO_FILE_NM = '" + files[0] + "'"
	                                + " WHERE GM_CHG_YM   = '" + gm_chg_ym   + "'"
	            			        + "   AND HOUSE_NO = '" + house_no + "'"
	            			        + "   AND CUST_NO  = '" + cust_no  + "'"
	                        ;
	                        db.execSQL(sql);
	                    } catch( Exception ex ) {
	                        alert(R.string.msg_db_error); // 저장중 오류가 발생하였습니다.
	                    } finally {
	                    }    							
    				}
    				setVisibility(R.id.ib_photoview,View.VISIBLE);
    			}
    		}
        } else if ( requestCode == Constant.PROC_ID_PIC_VIWER ) {
        	boolean rtn = data.getBooleanExtra("FILE_DELETED",false);
        	if ( rtn ) {
    			if ( pc.fileCount() > 0 ) {
    				setVisibility(R.id.ib_photoview,View.VISIBLE);
    			} else {
    				setVisibility(R.id.ib_photoview,View.INVISIBLE);
    			}
        	}     	
        }
    }
}
