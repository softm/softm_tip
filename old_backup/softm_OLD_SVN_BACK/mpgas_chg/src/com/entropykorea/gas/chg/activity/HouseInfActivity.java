package com.entropykorea.gas.chg.activity;

import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.telephony.PhoneNumberFormattingTextWatcher;
import android.telephony.PhoneNumberUtils;
import android.text.TextUtils;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.CompoundButton.OnCheckedChangeListener;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.Toast;

import com.dm.zbar.android.scanner.ZBarConstants;
import com.dm.zbar.android.scanner.ZBarScannerActivity;
import com.entropykorea.ewire.eWireParam;
import com.entropykorea.ewire.eWireTrans;
import com.entropykorea.ewire.database.Sqlite;
import com.entropykorea.gas.chg.R;
import com.entropykorea.gas.chg.WApplication;
import com.entropykorea.gas.chg.common.DUtil;
import com.entropykorea.gas.chg.common.WConstant;
import com.entropykorea.gas.chg.common.WUtil;
import com.entropykorea.gas.lib.BaseActivity;
import com.entropykorea.gas.lib.Constant;
import com.entropykorea.gas.lib.TitleView;
import com.entropykorea.gas.lib.TitleView.OnTopClickListner;
import com.entropykorea.gas.lib.Util;
import com.mypidion.BI300.BI300Bluetooth;

/**
 * @author softm
 * HouseInfActivity
 * 수용가정보
 */
public class HouseInfActivity extends BaseActivity implements OnClickListener, OnTopClickListner, OnCheckedChangeListener, OnMenuItemClickListener  {
    public static final String TAG = "MPGAS";
    private ImageButton mBtnCustomerInfoSave; // ib_customer_info_save
    
    private ImageButton mBtnReConfirm; // ib_reconfirm    
    private ImageButton mBtnStart; // ib_start
    private ImageButton mBtnCancel; // ib_cancel
    private ImageButton mBtnSave; // ib_save
    
    private EditText mEtTelNo; // et_tel_no
    private EditText mEtHpNo; // et_hp_no
    private EditText mEtWorkTelNo; // et_work_tel_no
    private EditText mEtCustNm; // 

    
    private CheckBox mRdTelNo; // rd_tel_no
    private CheckBox mRdHpNo; // rd_hp_no
    private CheckBox mRdWorkTelNo; // rd_work_tel_no
    
    private String bldg_cd = null;
    private String gm_chg_ym = null;
    private String house_no = null;
    private String cust_no = null;

    private String bf_gm_no        = null;
    private String claim_cust_yn   = null;
    private String claim_content   = null;
//    private String house_no        = null;
    private String house_status_cd = null;
    private String che_month_cnt   = null;
    private String che_price_sum   = null;
    private String gm_error_yn     = null;
//    private String cust_no         = null;
    private String cust_nm         = null;
    private String tel_no          = null;
    private String hp_no           = null;
    private String work_tel_no     = null;
    private String tel_cd          = null;
    private String end_yn          = null;
    private String send_yn         = null;
    private String room_no         = null;

    private BI300Bluetooth bi300 = null;
    
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        Intent intent = getIntent();
        bldg_cd = WUtil.toDefault(intent.getStringExtra("bldg_cd"));
        gm_chg_ym = WUtil.toDefault(intent.getStringExtra("gm_chg_ym"));
        house_no = WUtil.toDefault(intent.getStringExtra("house_no"));
        cust_no = WUtil.toDefault(intent.getStringExtra("cust_no"));
        
        //TODO 테스트 param 삭제
//        gm_chg_ym   = "201412";
//        house_no = "2";
//        cust_no  = "22";

        if ( !"".equals(gm_chg_ym) && !"".equals(house_no) && !"".equals(cust_no) ) {
            setContentView(R.layout.activity_house_inf);
            init();
            retrive();
            if ( "".equals(bf_gm_no) ) {
                alert(R.string.msg_dosenot_exist
                        , new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int whichButton) {
                                finish();
                            }
                        }
                );
            }
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

    private void init() {
        TitleView tv = new TitleView(this, R.string.title_house_info,true);
        tv.setOnTopClickListner(this);
        mBtnCustomerInfoSave = (ImageButton) findViewById(R.id.ib_customer_info_save);
        mBtnCustomerInfoSave.setOnClickListener(this);
        mBtnReConfirm = (ImageButton) findViewById(R.id.ib_reconfirm);
        mBtnReConfirm.setOnClickListener(this);
        mBtnStart = (ImageButton) findViewById(R.id.ib_start);
        mBtnStart.setOnClickListener(this);
        mBtnCancel = (ImageButton) findViewById(R.id.ib_cancel);
        mBtnCancel.setOnClickListener(this);
        mBtnSave = (ImageButton) findViewById(R.id.ib_save);
        mBtnSave.setOnClickListener(this);
        
        mEtCustNm = (EditText) findViewById(R.id.et_cust_nm);
        mEtTelNo = (EditText) findViewById(R.id.et_tel_no);
        mEtTelNo.setInputType(android.text.InputType.TYPE_CLASS_PHONE);
        mEtTelNo.addTextChangedListener(new PhoneNumberFormattingTextWatcher());
        mEtHpNo = (EditText) findViewById(R.id.et_hp_no);
        mEtHpNo.setInputType(android.text.InputType.TYPE_CLASS_PHONE);
        mEtHpNo.addTextChangedListener(new PhoneNumberFormattingTextWatcher());
        mEtWorkTelNo = (EditText) findViewById(R.id.et_work_tel_no);
        mEtWorkTelNo.setInputType(android.text.InputType.TYPE_CLASS_PHONE);
        mEtWorkTelNo.addTextChangedListener(new PhoneNumberFormattingTextWatcher());
        
        mRdTelNo = (CheckBox) findViewById(R.id.rd_tel_no);
        mRdHpNo = (CheckBox) findViewById(R.id.rd_hp_no);
        mRdWorkTelNo = (CheckBox) findViewById(R.id.rd_work_tel_no);
        mRdTelNo.setOnCheckedChangeListener(this);
        mRdHpNo.setOnCheckedChangeListener(this);
        mRdWorkTelNo.setOnCheckedChangeListener(this);
    }
    private void retrive() {
        String sql = "SELECT "
                + "   CHG._rowid_         as _id            "
                + " , CHG.HOUSE_NO        as HOUSE_NO       " //
                + " , CHG.CUST_NO         as CUST_NO        " //
                + " , CHG.BF_GM_NO        as BF_GM_NO       " // 계량기번호
                + " , CHG.CLAIM_CUST_YN   as CLAIM_CUST_YN  " // 클레임고객여부
                + " , CHG.CLAIM_CONTENT   as CLAIM_CONTENT  " // 클레임내용
                + " , CHG.HOUSE_NO        as HOUSE_NO       " // 수용가번호
                + " , CHG.STATUS_CD       as STATUS_CD" // 수용가상태
                + " , CODE.CD_NM          as HOUSE_STATUS_NM" // 수용가상태 명
                + " , CHG.CHE_MONTH_CNT   as CHE_MONTH_CNT  " // 체납개월
                + " , CHG.CHE_PRICE_SUM   as CHE_PRICE_SUM  " // 체납금액
                + " , CHG.GM_ERROR_YN     as GM_ERROR_YN    " // 불회확인여부
                + " , CHG.CUST_NO         as CUST_NO        " // 고객번호
                + " , CHG.CUST_NM         as CUST_NM        " // 고객명
                + " , CHG.TEL_NO          as TEL_NO         " // 고객전화번호
                + " , CHG.HP_NO           as HP_NO          " // 고객핸드폰번호
                + " , CHG.WORK_TEL_NO     as WORK_TEL_NO    " // 직장전화번호
                + " , CHG.TEL_CD          as TEL_CD         " // 주전화번호구분코드
                + " , CASE CHG.END_YN  WHEN 'Y' THEN '" + Constant.CODE_END_YN.get("Y")  + "' ELSE '" + Constant.CODE_END_YN.get("N")  + "' END as END_YN_NM  " // 완료여부
                + " , CASE CHG.SEND_YN WHEN 'Y' THEN '" + Constant.CODE_SEND_YN.get("Y") + "' ELSE '" + Constant.CODE_SEND_YN.get("N") + "' END as SEND_YN_NM " // 송신여부                
                + " , CHG.SEND_YN         as SEND_YN        " // 송신여부
                + " , CHG.END_YN          as END_YN         " // 완료여부
                + " , CHG.SEND_YN         as SEND_YN        " // 송신여부
                + " , CHG.ROOM_NO         as ROOM_NO        " // 동호수
                + "  FROM " + WConstant.TBL_CHG + " CHG "
                + "  LEFT JOIN " + WConstant.TBL_CODE + " CODE "
                + "         ON CODE.TYPE_CD = 'MA090' "
                + "        AND CODE.CD = CHG.STATUS_CD"
                + " WHERE GM_CHG_YM   = '" + gm_chg_ym   + "'"
                + "   AND HOUSE_NO = '" + house_no + "'"
                + "   AND CUST_NO  = '" + cust_no  + "'"
        ;
		Sqlite sqlite = new Sqlite(db);
		sqlite.rawQuery(sql);
		
        if ( sqlite.getCount() > 0 ) {
            sqlite.moveToFirst();
            if ( "".equals(gm_chg_ym) || "".equals(house_no) || "".equals(cust_no) ) {
                alert(R.string.msg_not_exec_alert
    	              , new DialogInterface.OnClickListener() {
    	                  public void onClick(DialogInterface dialog, int whichButton) {
    	                      finish();
    	                  }
    	              }
                );			  
            }
            
            bf_gm_no        = WUtil.toDefault(sqlite.getValue("BF_GM_NO"       )        ); // 계량기번호        
            claim_cust_yn   = WUtil.toDefault(sqlite.getValue("CLAIM_CUST_YN"  )        ); // 클레임고객여부    
            claim_content   = WUtil.toDefault(sqlite.getValue("CLAIM_CONTENT"  )        ); // 클레임내용        
            house_no        = WUtil.toDefault(sqlite.getValue("HOUSE_NO"       )        ); // 수용가번호        
            house_status_cd = WUtil.toDefault(sqlite.getValue("STATUS_CD"      )        ); // 수용가상태        
            che_month_cnt   = WUtil.toDefault(sqlite.getValue("CHE_MONTH_CNT"  ),"0"    ); // 체납개월          
            che_price_sum   = WUtil.toDefault(sqlite.getValue("CHE_PRICE_SUM"  ),"0"    ); // 체납금액          
            gm_error_yn     = WUtil.toDefault(sqlite.getValue("GM_ERROR_YN"    )        ); // 불회확인여부      
            cust_no         = WUtil.toDefault(sqlite.getValue("CUST_NO"        )        ); // 고객번호          
            cust_nm         = WUtil.toDefault(sqlite.getValue("CUST_NM"        )        ); // 고객명            
            tel_no          = WUtil.toDefault(sqlite.getValue("TEL_NO"         )        ); // 고객전화번호      
            hp_no           = WUtil.toDefault(sqlite.getValue("HP_NO"          )        ); // 고객핸드폰번호    
            work_tel_no     = WUtil.toDefault(sqlite.getValue("WORK_TEL_NO"    )        ); // 직장전화번호      
            tel_cd          = WUtil.toDefault(sqlite.getValue("TEL_CD"         )        ); // 주전화번호구분코드
            end_yn          = WUtil.toDefault(sqlite.getValue("END_YN"         )        ); // 완료여부          
            send_yn         = WUtil.toDefault(sqlite.getValue("SEND_YN"        )        ); // 송신여부          
            room_no         = WUtil.toDefault(sqlite.getValue("ROOM_NO"        )        ); // 동호수

            String houseStatusNm= WUtil.toDefault(sqlite.getValue("HOUSE_STATUS_NM")); // 수용가상태명
            String endYnNm      = WUtil.toDefault(sqlite.getValue("END_YN_NM"      )); // 완료여부명  
            String sendYnNm     = WUtil.toDefault(sqlite.getValue("SEND_YN_NM"     )); // 송신여부명  

            if ( Constant.CODE_TEL_CD_HOME.equals(tel_cd) ) { // 자택
                mRdTelNo.setChecked(Boolean.TRUE);
            } else if ( Constant.CODE_TEL_CD_HP.equals(tel_cd) ) { // 이동
            	mRdHpNo.setChecked(Boolean.TRUE);
            } else if ( Constant.CODE_TEL_CD_WORK.equals(tel_cd) ) { // 회사
            	mRdWorkTelNo.setChecked(Boolean.TRUE);
            }
            
            setText(R.id.tv_house_no,  house_no); // 수용가번호
            setText(R.id.tv_cust_no ,  cust_no);
            setText(R.id.tv_house_status_nm,  houseStatusNm);
            setText(R.id.et_cust_nm,  cust_nm);
            setText(R.id.tv_che_month_cnt,  che_month_cnt);
            setText(R.id.tv_che_price_sum,  WUtil.numberFormat("#,###", che_price_sum));
            
            setText(R.id.et_tel_no,  PhoneNumberUtils.formatNumber(tel_no));
            setText(R.id.et_hp_no ,  PhoneNumberUtils.formatNumber(hp_no));
            setText(R.id.et_work_tel_no,  PhoneNumberUtils.formatNumber(work_tel_no));
            
            setText(R.id.tv_room_no,  room_no);
            setText(R.id.tv_state_info,  endYnNm + "/" + sendYnNm);
            
            // 불회확인
        	setVisibility(R.id.tv_gm_error_yn,gm_error_yn.equals(Constant.CODE_GM_ERROR_N)?View.VISIBLE:View.INVISIBLE);
        	
            if ( !"".equals(cust_nm)) { // 한번 입력이 발생하면 수정 불가.
            	mEtCustNm.setEnabled(Boolean.FALSE);
            	mEtCustNm.setClickable(Boolean.FALSE);
            	mEtCustNm.setFocusable(Boolean.FALSE);
            }

            if ( DUtil.isInputAfGmNo(this.getApplicationContext(),gm_chg_ym,house_no,cust_no) ) { // 교제정보 입력됨
            	mBtnStart.setVisibility(View.GONE);
            	mBtnCancel.setVisibility(View.VISIBLE);
            	mBtnSave.setVisibility(View.VISIBLE);
            	if ( send_yn.equals(Constant.CODE_SEND_Y) ) { // 송신완료이면 선택 불가.
//            		mBtnCancel.setEnabled(Boolean.FALSE);
//                	mBtnSave.setEnabled(Boolean.FALSE);        		
            		mBtnCancel.setVisibility(View.GONE);
            		setVisibility(R.id.ib_reconfirm,View.INVISIBLE);
            		setVisibility(R.id.ib_customer_info_save,View.GONE);
            	}
            } else { // 교체정보 입력전 : 교체시작 버튼 표시
            	mBtnStart.setVisibility(View.VISIBLE);
            	mBtnCancel.setVisibility(View.GONE);
            	mBtnSave.setVisibility(View.GONE);
            }
        }
    }
    
    /**
     * 고객정보 저장
     */
    private void fSaveCustInfo() {
	    String custNm    = mEtCustNm.getText().toString().trim();
	    String telNo     = mEtTelNo.getText().toString().trim();
	    String hpNo      = mEtHpNo.getText().toString().trim();
	    String workTelNo = mEtWorkTelNo.getText().toString().trim();
        setError(mEtCustNm,null);        
        setError(mEtTelNo,null);        
        setError(mEtHpNo,null);        
        setError(mEtWorkTelNo,null);
	    if (custNm.equals("")) {
//	    	alert(R.string.msg_do_input_cust_nm); // 고객명을 입력해주세요
	        setError(mEtCustNm,R.string.msg_do_input_cust_nm); // 고객명을 입력해주세요        
	    	setFocus(mEtCustNm);
	    } else if ( !"".equals(telNo) && !WUtil.isValidPhoneNumber(telNo)) {
//	    	alert(R.string.msg_incorrect_tel_no); // 자택전화번호가 올바르지 않습니다.
	        setError(mEtTelNo,R.string.msg_incorrect_tel_no); // 자택전화번호가 올바르지 않습니다.	    	
	    	setFocus(mEtTelNo);	    	
	    } else if ( !"".equals(hpNo) && !WUtil.isValidCellPhoneNumber(hpNo)) {
//	    	alert(R.string.msg_incorrect_hp_no); // 이동전화번호가 올바르지 않습니다.
	        setError(mEtHpNo,R.string.msg_incorrect_hp_no); // 이동전화번호가 올바르지 않습니다.	    	
	    	setFocus(mEtHpNo);	    	
	    } else if ( !"".equals(workTelNo) && !WUtil.isValidPhoneNumber(workTelNo)) {
//	    	alert(R.string.msg_incorrect_work_tel_no); // 직장전화번호가 올바르지 않습니다.
	        setError(mEtWorkTelNo,R.string.msg_incorrect_work_tel_no); // 직장전화번호가 올바르지 않습니다.	    	
	    	setFocus(mEtWorkTelNo);	    	
	    } else if ( !mRdTelNo.isChecked() 
	    	  && !mRdHpNo.isChecked()
	    	  && !mRdWorkTelNo.isChecked()
	    ) {
	    	alert(R.string.msg_must_selected_one_tel_no); // 주사용 전화번호를 하나 선택하세요.
	    } else {
	    	boolean exec = true;
	    	if ( mRdTelNo.isChecked() ) {
	    		if ( "".equals(telNo) ) {
//	    			alert(R.string.msg_do_input_tel_no); // 자택전화번호를 입력해주세요.
	    	        setError(mEtTelNo,R.string.msg_do_input_tel_no); // 자택전화번호를 입력해주세요.	    			
	    			setFocus(mEtTelNo);	    			
	    			exec = false;
	    		}
	    	} else if ( mRdHpNo.isChecked() ) {
	    		if ( "".equals(hpNo) ) {
//	    			alert(R.string.msg_do_input_hp_no); // 이동전화번호를 입력해주세요.
	    	        setError(mEtHpNo,R.string.msg_do_input_hp_no); // 이동전화번호를 입력해주세요.	    			
	    			setFocus(mEtHpNo);
	    			exec = false;
	    		}
	    	} else if ( mRdWorkTelNo.isChecked() ) {
	    		if ( "".equals(workTelNo) ) {
//	    			alert(R.string.msg_do_input_work_tel_no); // 직장전화번호를 입력해주세요.
	    	        setError(mEtWorkTelNo,R.string.msg_do_input_work_tel_no); // 직장전화번호를 입력해주세요.	    			
	    			setFocus(mEtWorkTelNo);
	    			exec = false;
	    		}	    		
	    	}
	    	
	    	if ( exec ) {
				confirm(R.string.msg_update_confirm, // 수정하시겠습니까?
					new DialogInterface.OnClickListener() {
						public void onClick(DialogInterface dialog, int whichButton) {
						    String custNm    = mEtCustNm.getText().toString().trim();
						    String telNo     = mEtTelNo.getText().toString().trim();
						    String hpNo      = mEtHpNo.getText().toString().trim();
						    String workTelNo = mEtWorkTelNo.getText().toString().trim();
						    String telCd = "";
					    	if ( mRdTelNo.isChecked() ) {
					    		telCd = Constant.CODE_TEL_CD_HOME;
					    	} else if ( mRdHpNo.isChecked() ) {
					    		telCd = Constant.CODE_TEL_CD_HP;
					    	} else if ( mRdWorkTelNo.isChecked() ) {
					    		telCd = Constant.CODE_TEL_CD_WORK;
					    	}
							db.execSQL("UPDATE " + WConstant.TBL_CHG
									+ " SET CUST_NM    = '" + custNm    + "'"
									+ "   , TEL_NO     = '" + telNo     + "'"
									+ "   , HP_NO      = '" + hpNo      + "'"
									+ "   , WORK_TEL_NO= '" + workTelNo + "'"
									+ "   , TEL_CD     = '" + telCd     + "'"
									+ " WHERE GM_CHG_YM   = '" + gm_chg_ym   + "'"
									+ "   AND HOUSE_NO = '" + house_no + "'"
									+ "   AND CUST_NO  = '" + cust_no  + "'"
									);

							db.execSQL("INSERT OR REPLACE INTO " + WConstant.TBL_CHG_CUST
									+ " (   GM_CHG_YM ,HOUSE_NO ,CUST_NO ,CUST_NM ,TEL_NO ,WORK_TEL_NO ,HP_NO ,TEL_CD ) VALUES "
									+ " ( " 
									+ " '" + gm_chg_ym    + "'"
									+ ",'" + house_no  + "'"
									+ ",'" + cust_no   + "'"
									+ ",'" + custNm    + "'"
									+ ",'" + telNo     + "'"
									+ ",'" + workTelNo + "'"
									+ ",'" + hpNo      + "'"
									+ ",'" + telCd     + "'"
									+ " ) " 									
							);
                            hideKeyboard();							
							retrive();
							toast(R.string.msg_updated);
					}
					}, new DialogInterface.OnClickListener() {
						public void onClick(DialogInterface dialog, int whichButton) {
							// alert("취소");
						}
					});    	
	    	}
	    }
	}

    /**
     * 계량기 교체화면이동.
     * @param bf_gm_no
     */
	private void fGoMeterChgByKey(String gm_chg_ym,String house_no,String cust_no) {
	    Intent sIntent = new Intent(this,MeterChgActivity.class); // 계량기교체
	    sIntent.putExtra("gm_chg_ym", gm_chg_ym);
	    sIntent.putExtra("house_no", house_no);
	    sIntent.putExtra("cust_no", cust_no);
	    startActivity(sIntent);
	}

	private void fUpdateCheInfo() {
		String server_ip = var.EWIRE_SERVER_IP;
		String server_port = var.EWIRE_SERVER_PORT;
		String userid = ((WApplication)mApp).getUserId();
//		String machineId = ((WApplication)mApp).getMachineId();
		String command = "I";
		String instruction = "chg_price_down";
		//              DOWN||작업년월|수용가번호|고객번호
		String param = "DOWN||"+gm_chg_ym+"|"+house_no+"|"+cust_no;
		
		eWireTrans ewireTrans; 
		// eWire
		ewireTrans = new eWireTrans( this ){
			@Override
			public void onFinished(boolean result, String resultMessage) {
				if( result ) {
					eWireParam ep = new eWireParam(resultMessage);
					int m = Integer.parseInt(ep.get(1),10); // tv_che_month_cnt
					int c = Integer.parseInt(ep.get(2),10); // tv_che_price_sum
					setText(R.id.tv_che_month_cnt,""+m);
					setText(R.id.tv_che_price_sum,WUtil.numberFormat("#,###",c));
					DUtil.updateChe(HouseInfActivity.this.getApplicationContext(),gm_chg_ym,house_no,cust_no,m,c);
//					Toast.makeText(HouseInfActivity.this, resultMessage, Toast.LENGTH_SHORT).show();
				} else {
//					Toast.makeText(HouseInfActivity.this, resultMessage, Toast.LENGTH_SHORT).show();
				}
			}
		};
		ewireTrans.setServerIp(server_ip);
		ewireTrans.setServerPort(server_port);
		ewireTrans.setUserId(userid);
		ewireTrans.setCommand(command);
		ewireTrans.setInstruction(instruction);
		ewireTrans.setParam(param);
		
		// option
		ewireTrans.setDialogType(eWireTrans.DIALOGTYPE_WAIT_PROGRESS); 
		ewireTrans.setDisplayMessage(eWireTrans.DEFAULT_DISPLAYMESSAGE);
		ewireTrans.setShowError(false);
		ewireTrans.setSoundPlay(false);
		
		ewireTrans.setDelayTime(1000);
		
		// eWire Thread
		ewireTrans.excuteTrans();
	}
	
	public void goMterChg(String bfGmNo, String houseNo) {
		if ( "".equals(houseNo)) {
			alert(R.string.msg_invalid_house,new DialogInterface.OnClickListener() {
				public void onClick( DialogInterface dialog, int whichButton) {
					Intent sIntent = new Intent(HouseInfActivity.this,MeterChgActivity.class); // 계량기교체
					sIntent.putExtra("gm_chg_ym"  , gm_chg_ym);
					sIntent.putExtra("house_no", house_no);
					sIntent.putExtra("cust_no" , cust_no);
					startActivity(sIntent);
				}
			}); // 인식된 세대가 없습니다.\n확인 바랍니다.
		} else {
			if ( houseNo.equals(house_no) ) { // 바코드 인식수용가번호와 현재 수용가 번호가 동일하면. 
				Intent sIntent = new Intent(HouseInfActivity.this,MeterChgActivity.class); // 계량기교체
				sIntent.putExtra("bf_gm_no"  , bfGmNo);
				startActivity(sIntent);
			} else {
				confirm(R.string.msg_meter_code_not_corrent_confirm, // 계량기 번호가 맞지 않습니다. 교체를 시작하시겠습니까?
						new DialogInterface.OnClickListener() {
					public void onClick(DialogInterface dialog,int whichButton) {
						Intent sIntent = new Intent(HouseInfActivity.this,MeterChgActivity.class); // 계량기교체
						sIntent.putExtra("gm_chg_ym"  , gm_chg_ym);
						sIntent.putExtra("house_no", house_no);
						sIntent.putExtra("cust_no" , cust_no);
						startActivity(sIntent);
					}
				}, new DialogInterface.OnClickListener() {
					public void onClick( DialogInterface dialog, int whichButton) {
					}
				});
			}
		}
	}
	
	@Override
	public void onClick(View v) {
	    int viewID = v.getId();
	    if ( viewID == R.id.ib_customer_info_save ) { // 고객정보 저장
	    	fSaveCustInfo();
	    } else if ( viewID == R.id.ib_start ) { // 교체시작
	    	confirm(R.string.msg_meter_barcode_confirm // 계량기 바코드를 인식하시겠습니까?
	    			, R.string.alert_yes_str
	    			, new DialogInterface.OnClickListener() { // 예
						public void onClick(DialogInterface dialog,int whichButton) {
					    	String barCodeType = ((WApplication)mApp).getBarCodeType();						
					    	if ( Constant.CODE_BARCODE_SELF.equals(barCodeType) ) {
					            if (isCameraAvailable()) {
					                Intent intent = new Intent(HouseInfActivity.this, ZBarScannerActivity.class);
					                startActivityForResult(intent, WConstant.ZBAR_SCANNER_REQUEST2);
					            } else {
					                Toast.makeText(HouseInfActivity.this, "Rear Facing Camera Unavailable", Toast.LENGTH_SHORT).show();
					            }				    		
					    	} else {
					    		try {
					    			//바코드 블루투스 리더기 연동 
					    			bi300 = new BI300Bluetooth(HouseInfActivity.this,  new Handler() {
					    				@Override
					    				public void handleMessage(android.os.Message msg) {
					    					String message = (String) msg.obj;
					    					switch (msg.what) {
					    					case 1:
					    	                    String bfGmNo = WUtil.toDefault(message).trim();
					    	    	    		String houseNo = DUtil.getHouseNoByBfGmNo(HouseInfActivity.this.getApplicationContext(),bfGmNo);					    	                    
					    	    	    		goMterChg(bfGmNo,houseNo);
					    						break;
					    					}
					    				};
					    			});
					    			bi300.startBI300();
								} catch (Exception e) {
//									alert("바코드스캐너 블루투스 연결하세요.");
								}
					    	}						
						}
					} 
	    			, R.string.alert_no_str
	    			, new DialogInterface.OnClickListener() { // 아니오
						public void onClick(DialogInterface dialog,int whichButton) {
		                    Intent sIntent = new Intent(HouseInfActivity.this,MeterChgActivity.class); // 계량기교체
		                    sIntent.putExtra("bf_gm_no", "");
		                	sIntent.putExtra("gm_chg_ym"   , gm_chg_ym  ); // 작업년월(PK)  
		                	sIntent.putExtra("house_no" , house_no); // 수용가번호(PK)
		                	sIntent.putExtra("cust_no"  , cust_no ); // 고객번호(PK)
		                    startActivity(sIntent);						
						}
					}  
	                , R.string.alert_cancel_str
	                , new DialogInterface.OnClickListener() { // 취소
						public void onClick(DialogInterface dialog,int whichButton) {
						}
	                }
	    	);
	    		
	    } else if ( viewID == R.id.ib_cancel ) { // 교체취소
			confirm(R.string.msg_chg_data_cancel_confirm, // 교체내용을 취소하시겠습니까?
					R.string.alert_yes_str,
				new DialogInterface.OnClickListener() { // 예
					public void onClick(DialogInterface dialog,int whichButton) {
						// 교체취소 : 교체후관련 정보및 지침 정보 클리어.
				        DUtil.clearChgDataByKey(HouseInfActivity.this.getApplicationContext(),gm_chg_ym,house_no,cust_no);
				        try { // 사진 삭제
				        	Util.deleteFilesWithPrefix(Constant.PIC_DIR, "P_"+gm_chg_ym+house_no+cust_no);
				        } catch ( Exception ex ) {}
				        try { // 서명삭제
				        	Util.deleteFilesWithPrefix(Constant.SIGN_DIR, "S_"+gm_chg_ym+house_no+cust_no);
				        } catch ( Exception ex ) {}
				        retrive();
					}
				},
				R.string.alert_no_str,				
				new DialogInterface.OnClickListener() { // 아니오
					public void onClick(DialogInterface dialog,int whichButton) {
					}
			});
	    } else if ( viewID == R.id.ib_save ) { // 수정
	        fGoMeterChgByKey(gm_chg_ym,house_no,cust_no);
	    } else if ( viewID == R.id.ib_reconfirm ) { // 재확인
	    	fUpdateCheInfo();
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
    	                    String bfGmNo = WUtil.toDefault(message).trim();
    	                    WUtil.goMterChg(HouseInfActivity.this, bfGmNo);
    						break;
    					}
    				};
    			});
    			bi300.startBI300();
			} catch (Exception e) {
//				alert("바코드스캐너 블루투스 연결하세요.");
			}
    	}
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

	@Override
	public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
		if ( isChecked ) {
		    mRdTelNo.setChecked(Boolean.FALSE); // rd_tel_no
		    mRdHpNo.setChecked(Boolean.FALSE); // rd_hp_no
		    mRdWorkTelNo.setChecked(Boolean.FALSE); // rd_work_tel_no
			if(buttonView.getId() == R.id.rd_tel_no ) {
			    mRdTelNo.setChecked(Boolean.TRUE); // rd_tel_no
			} else if(buttonView.getId() == R.id.rd_hp_no ) {
				mRdHpNo.setChecked(Boolean.TRUE); // rd_hp_no
			} else if(buttonView.getId() == R.id.rd_work_tel_no ) {
				mRdWorkTelNo.setChecked(Boolean.TRUE); // rd_work_tel_no
			}
		}
	}

//  @Override
//  public boolean onKeyDown(int keyCode, KeyEvent event) {
//      if ((keyCode == KeyEvent.KEYCODE_BACK) && mWebView.canGoBack()) {
////            mWebView.goBack();
//          return true;
//      }
//      return super.onKeyDown(keyCode, event);
//  }
//
//  @Override
//  public void onConfigurationChanged(Configuration newConfig) {
//      super.onConfigurationChanged(newConfig);
//  }

	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
	    if ( requestCode == Constant.ZBAR_SCANNER_REQUEST ) {
	    	if (resultCode == RESULT_OK) {
	    		String bfGmNo = WUtil.toDefault(data.getStringExtra(ZBarConstants.SCAN_RESULT));
	    		WUtil.goMterChg(HouseInfActivity.this, bfGmNo);
//	    		Toast.makeText(this, "Scan Result = " + data.getStringExtra(ZBarConstants.SCAN_RESULT), Toast.LENGTH_SHORT).show();
	    	} else if(resultCode == RESULT_CANCELED && data != null) {
	    		String error = data.getStringExtra(ZBarConstants.ERROR_INFO);
	    		if(!TextUtils.isEmpty(error)) {
	    			Toast.makeText(this, error, Toast.LENGTH_SHORT).show();
	    		}
	    	}
	    } else if ( requestCode == Constant.ZBAR_QR_SCANNER_REQUEST ) {
	    } else if ( requestCode == WConstant.ZBAR_SCANNER_REQUEST2 ) {
	    	if ( data != null ) {
	    		String bfGmNo = WUtil.toDefault(data.getStringExtra(ZBarConstants.SCAN_RESULT));	    	
	    		String houseNo = DUtil.getHouseNoByBfGmNo(this.getApplicationContext(),bfGmNo);
	    		goMterChg(bfGmNo,houseNo);
	    	}
	    }
	}

	@Override
	protected void onResume() {
		super.onResume();
		retrive();
	}
	
    @Override
    protected void onPause() {
    	super.onPause();
    	if ( bi300 != null ) {
    		bi300.stopBI300();
    	}
    }	
}
