package com.entropykorea.gas.chg.activity;

import java.io.File;
import java.util.HashMap;

import org.apache.commons.lang3.StringUtils;

import android.annotation.SuppressLint;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.text.TextUtils;
import android.view.MenuItem;
import android.view.MotionEvent;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.Toast;

import com.dm.zbar.android.scanner.ZBarConstants;
import com.entropykorea.ewire.eWireData;
import com.entropykorea.ewire.eWireTrans;
import com.entropykorea.ewire.database.Sqlite;
import com.entropykorea.gas.chg.R;
import com.entropykorea.gas.chg.WApplication;
import com.entropykorea.gas.chg.common.DUtil;
import com.entropykorea.gas.chg.common.WConstant;
import com.entropykorea.gas.chg.common.WUtil;
import com.entropykorea.gas.chg.dto.ChgDTO;
import com.entropykorea.gas.chg.spec.ChgCustSpec;
import com.entropykorea.gas.chg.spec.ChgResultSpec;
import com.entropykorea.gas.lib.BaseActivity;
import com.entropykorea.gas.lib.Constant;
import com.entropykorea.gas.lib.PicCamera;
import com.entropykorea.gas.lib.TitleView;
import com.entropykorea.gas.lib.TitleView.OnTopClickListner;
import com.entropykorea.gas.lib.Util;
import com.entropykorea.gas.lib.sign.SignView;

/**
 * @author softm
 * SignActivity
 * 서명
 */
@SuppressLint("ClickableViewAccessibility")
public class SignActivity extends BaseActivity implements OnClickListener, OnTopClickListner, OnMenuItemClickListener {
    public static final String TAG = "MPGAS";

    private String bldg_cd = null;
    private String gm_chg_ym = null;
    private String house_no = null;
    private String cust_no = null;

    private String room_no             = null;
    private String end_yn              = null;
    private String send_yn             = null;
    private String sign_file_nm        = null;
    private String af_seal_cd          = null;

    PicCamera pc = null;
    SignView signView;
    
	HashMap<String,String> fileInformap = new HashMap<String, String>();
	
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        Intent intent = getIntent();

        // key
        gm_chg_ym = WUtil.toDefault(intent.getStringExtra("gm_chg_ym"));
        house_no = WUtil.toDefault(intent.getStringExtra("house_no"));
        cust_no = WUtil.toDefault(intent.getStringExtra("cust_no"));

        if ( !"".equals(gm_chg_ym) && !"".equals(house_no) && !"".equals(cust_no) ) {
            setContentView(R.layout.activity_sign);
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

    @SuppressLint("ClickableViewAccessibility")
    private void init() {
        TitleView tv = new TitleView(this, R.string.title_sign);
        tv.setOnTopClickListner(this);
        findViewById(R.id.ib_eraser   ).setOnClickListener(this);
        findViewById(R.id.ib_close    ).setOnClickListener(this);
        findViewById(R.id.ib_delete   ).setOnClickListener(this);
        findViewById(R.id.ib_finish   ).setOnClickListener(this);
    }

    private void retrive() {
        ChgDTO v = new ChgDTO();
        v = DUtil.getDataByWhere(getApplicationContext(), " WHERE GM_CHG_YM   = '" + gm_chg_ym   + "'"
                + "   AND HOUSE_NO = '" + house_no + "'"
                + "   AND CUST_NO  = '" + cust_no  + "'"
        );
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
            bldg_cd              = v.getBldgCd()            ; // bldg_cd
            room_no              = v.getRoomNo()            ; // room_no
            end_yn               = v.getEndYn()             ; // end_yn
            send_yn              = v.getSendYn()            ; // send_yn
            sign_file_nm         = v.getSignFileNm()        ; // sign_file_nm
            af_seal_cd           = v.getAfSealCd()          ; // 봉인
            setText(R.id.tv_info,room_no);

            signView = (SignView) findViewById(R.id.sign_view);

            if ( "".equals(sign_file_nm) ) {
                sign_file_nm = "S_" + gm_chg_ym + house_no + cust_no + ".bmp";
            } else {
                signView.Load(Constant.SIGN_DIR + File.separator + sign_file_nm);
            }

            if ( end_yn.equals(Constant.CODE_END_Y) ) { // 완료여부
                setVisibility(R.id.ib_delete, View.VISIBLE  ); // 삭제
            } else {
                setVisibility(R.id.ib_delete, View.INVISIBLE); // 삭제
            }
            if ( send_yn.equals(Constant.CODE_SEND_Y) ) { // 송신완료.
                setEnabled(R.id.ib_eraser,Boolean.FALSE); // 지우기
//              setEnabled(R.id.ib_delete,Boolean.FALSE); // 삭제
//              setEnabled(R.id.ib_finish,Boolean.FALSE); // 완료
                setVisibility(R.id.ib_delete,View.GONE);// 삭제
                setVisibility(R.id.ib_finish,View.GONE);// 완료
                setVisibility(R.id.ib_eraser,View.GONE);// 지우기
                signView.setLock(Boolean.TRUE);
            } else {
                signView.setOnTouchListener(new View.OnTouchListener() {
                    @Override
                    public boolean onTouch(View v, MotionEvent event) {
                        setText(R.id.tv_placeholder,"");
                        return false;
                    }
                });
            }
        }
    }

    /**
     * 완료
     */
    private boolean fComplete() {
    	boolean rtn = true;
        try {
            String sql = "UPDATE " + WConstant.TBL_CHG
                    + " SET END_YN = '" + Constant.CODE_END_Y + "'"
                    + "   , SIGN_FILE_NM = '" + sign_file_nm + "'"
                    + " WHERE GM_CHG_YM   = '" + gm_chg_ym   + "'"
                    + "   AND HOUSE_NO = '" + house_no + "'"
                    + "   AND CUST_NO  = '" + cust_no  + "'"
            ;
            Sqlite sqlite =  new Sqlite(db);
            sqlite.execSql(sql);
        } catch( Exception ex ) {
        	rtn = false;
            alert(R.string.msg_db_error); // 저장중 오류가 발생하였습니다.
        } finally {
    		fileInformap.put(sign_file_nm, Constant.SIGN_DIR + File.separator + sign_file_nm);       	
        }
        return rtn;
    }

    private final String transZipfileName = Constant.WORK_DIR + File.separator + "up.zip";
    
    private void callExport() {
        // set ewiredata
        eWireData ewireData = new eWireData( this ) {

            @Override
            public void onFinished(boolean result, String resultMessage) {
                if( result ) {
                    callTrans();
//                  Toast.makeText(MeterChgMainActivity.this, resultMessage, Toast.LENGTH_SHORT).show();
                } else {
//                  Toast.makeText(MeterChgMainActivity.this, resultMessage, Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void preExcute() {

            }

            @Override
            public void postExcute() {

            }

        };
        ewireData.setDatabase( db );
        ewireData.setZipfilename( transZipfileName );
        ewireData.setOutputFolder( Constant.WORK_DIR );
        ChgResultSpec chgResultSpec = new ChgResultSpec();
        ChgCustSpec   chgCustSpec   = new ChgCustSpec()  ;
        chgResultSpec.whereClause = " WHERE END_YN = 'Y' "
                                    + " AND SEND_YN = 'N' "
                                    + " AND GM_CHG_YM   = '" + gm_chg_ym   + "'"
                                    + " AND HOUSE_NO = '" + house_no + "'"
                                    + " AND CUST_NO  = '" + cust_no  + "'"
                                    + " AND IFNULL(AF_SEAL_CD,'') IS NOT NULL"
        ;
        chgCustSpec.whereClause   = " WHERE"
                                  + "  EXISTS ("
                                  + "   SELECT * FROM CHG"
                                  + "   WHERE CHG.END_YN   = 'Y'"
                                  + "   AND   CHG.SEND_YN  = 'N'"
                                  + "   AND   CHG.GM_CHG_YM       = '" + gm_chg_ym   + "'"
                                  + "   AND   CHG.HOUSE_NO     = '" + house_no + "'"
                                  + "   AND   CHG.CUST_NO      = '" + cust_no  + "'"
                                  + "   AND   IFNULL(CHG.AF_SEAL_CD,'') IS NOT NULL"                                  
                                  + "   AND   CHG.GM_CHG_YM   = CHG_CUST.GM_CHG_YM      "
                                  + "   AND   CHG.HOUSE_NO = CHG_CUST.HOUSE_NO  "
                                  + "   AND   CHG.CUST_NO  = CHG_CUST.CUST_NO    "
                                  + "  )"
        ;
        Object[] databasespecication = {
                  chgResultSpec
                , chgCustSpec
        };
        ewireData.setDatabaseSpecication(databasespecication);

        // file name only
		ewireData.setAddFiles( fileInformap ); // 추가 파일 

        // option
        ewireData.setDialogType(eWireData.DIALOGTYPE_WAIT);
        ewireData.setDisplayMessage(eWireData.DEFAULT_DISPLAYMESSAGE);
        ewireData.setShowError(true);
        ewireData.setSoundPlay(false);

        ewireData.setDelayTime(1000);

        // do
        ewireData.excuteExport();
    }

    private void callTrans() {
        String yyyyMm = Util.getSysYYYYMM();
//          String yyyyMm = getValue(R.id.et_yyyy) + getValue(R.id.et_mm);
//        String server_port = "4000";
        String userid = ((WApplication)mApp).getUserId();
        String machineId = ((WApplication)mApp).getMachineId();
        String command = "C";
        String instruction = "chg_up";
//      String param = "DOWN|/DATA/CHG/DN/20141030/DN_CHG_01_144203.ZIP|201411|01";
//          UP|/DATA/CHG/UP/(YYYYMMDD)/UP_CHG_(기기번호)_hhmmss.ZIP|작업년월|기기번호
        String param = "UP|/DATA/CHG/UP/"+ Util.getSysYYYYMMDD() +"/UP_CHG_"+machineId+"_"+Util.getSysHHMMSS()+".ZIP|"+ yyyyMm +"|" + machineId;

        eWireTrans ewireTrans;
        // eWire
        ewireTrans = new eWireTrans( this ){
            @Override
            public void onFinished(boolean result, String resultMessage) {
                if( result ) {
                    alert(R.string.msg_do_sign_complete, // 완료되었습니다
                        	new DialogInterface.OnClickListener() {
                            	public void onClick(DialogInterface dialog, int whichButton) {
                                    String sql = "UPDATE " + WConstant.TBL_CHG
                                            + " SET SEND_YN = '" + Constant.CODE_SEND_Y + "'"
                                            + " WHERE GM_CHG_YM   = '" + gm_chg_ym   + "'"
                                            + "   AND HOUSE_NO = '" + house_no + "'"
                                            + "   AND CUST_NO  = '" + cust_no  + "'"
                                    ;
                                    Sqlite sqlite = new Sqlite(db);
                                    sqlite.execSql(sql);
                                    
                            	    Intent sIntent = new Intent(SignActivity.this,HouseListActivity.class); // 수용가목록
                                    sIntent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);                            	    
						            sIntent.putExtra("bldg_cd"  , bldg_cd);
						            startActivity(sIntent);
						            finish();	    	                                            	
                            }
					});                	
//                      Toast.makeText(ChgTargetRcvActivity.this, resultMessage, Toast.LENGTH_SHORT).show();
                } else {
//                      Toast.makeText(MeterChgMainActivity.this, resultMessage, Toast.LENGTH_SHORT).show();
                }
            }
        };
        ewireTrans.setServerIp(var.EWIRE_SERVER_IP);
        ewireTrans.setServerPort(var.EWIRE_SERVER_PORT);
        ewireTrans.setUserId(userid);
        ewireTrans.setCommand(command);
        ewireTrans.setInstruction(instruction);
        ewireTrans.setParam(param);
        ewireTrans.setFileName(transZipfileName);

        // option
        ewireTrans.setDialogType(eWireTrans.DIALOGTYPE_PROGRESS);
        ewireTrans.setDisplayMessage(eWireTrans.DEFAULT_DISPLAYMESSAGE);
        ewireTrans.setShowError(true);
        ewireTrans.setSoundPlay(true);

        ewireTrans.setDelayTime(1000);

        // eWire Thread
        ewireTrans.excuteTrans();
    }
    @Override
    public void onClick(View v) {
        int viewID = v.getId();
        if ( viewID == R.id.ib_finish ) { // 완료
	        if ( !signView.isEdited() ) {
	            alert(R.string.msg_do_sign); // 서명해주세요.
	        } else {
	            confirm(R.string.msg_sign_complete_confirm, // 저장하고 완료하시겠습니까?
	                    new DialogInterface.OnClickListener() {
	                        public void onClick(DialogInterface dialog, int whichButton) {
	                            if ( signView.Save(Constant.SIGN_DIR + File.separator + sign_file_nm) ) {
	                                if ( StringUtils.isNotEmpty(af_seal_cd) ) { // 봉인시 즉시 송신.
	                                   alert(R.string.msg_locked_send, // 봉인처리가 되었습니다. 지금 송신하겟습니다.
	                                        new DialogInterface.OnClickListener() {
	                                            public void onClick(DialogInterface dialog, int whichButton) {
	                                                if ( fComplete() ) {
	                                                	callExport();
	                                                }
	                                            }
	                                   });
	                                } else {
	                                    if ( fComplete() ) {
	                                        alert(R.string.msg_do_sign_complete, // 완료되었습니다
	                                            	new DialogInterface.OnClickListener() {
		                                            	public void onClick(DialogInterface dialog, int whichButton) {
		                                            	   Intent sIntent = new Intent(SignActivity.this,HouseListActivity.class); // 수용가목록
		                                                   sIntent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);		                                            	   
												            sIntent.putExtra("bldg_cd"  , bldg_cd);
												            startActivity(sIntent);
												            finish();	    	                                            	
		                                            }
											});
	                                    }
	                                }
	                            } else {
	                                alert(R.string.msg_db_error); // 저장중 오류가 발생하였습니다.
	                            }
	                        }
	                    }, new DialogInterface.OnClickListener() {
	                        public void onClick(DialogInterface dialog, int whichButton) {
	                        }
	                    });
	        }
        } else if ( viewID == R.id.ib_eraser ) { // 지우기
            signView.Clear();
        } else if ( viewID == R.id.ib_close ) { // 닫기
            finish();
        } else if ( viewID == R.id.ib_delete ) { // 삭제
            confirm(R.string.msg_del_confirm, // 삭제하시겠습니까?
                    new DialogInterface.OnClickListener() {
                        public void onClick(DialogInterface dialog, int whichButton) {
                            if ( signView.isFileExist() ) {
                                signView.Clear(); // 서명파일 삭제
                                try {
                                    String sql = "UPDATE " + WConstant.TBL_CHG
                                            + " SET END_YN = '" + Constant.CODE_END_N + "'"
                                            + "   , SIGN_FILE_NM = ''"
                                            + " WHERE GM_CHG_YM   = '" + gm_chg_ym   + "'"
                                            + "   AND HOUSE_NO = '" + house_no + "'"
                                            + "   AND CUST_NO  = '" + cust_no  + "'"
                                    ;
                                    Sqlite sqlite = new Sqlite(db);
                                    sqlite.execSql(sql);
                                } catch( Exception ex ) {
                                    alert(R.string.msg_db_error); // 저장중 오류가 발생하였습니다.
                                } finally {
                                	alert(R.string.msg_deleted // 삭제되었습니다. 
                                			, new DialogInterface.OnClickListener() {
                                		public void onClick(DialogInterface dialog, int whichButton) {
                                			Intent sIntent = new Intent(SignActivity.this,HouseListActivity.class); // 수용가목록
                                			sIntent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);                            	    
                                			sIntent.putExtra("bldg_cd"  , bldg_cd);
                                			startActivity(sIntent);
                                			finish();	    
                                		}
                                	});
                                }
                            }
                        }

                    }, new DialogInterface.OnClickListener() {
                        public void onClick(DialogInterface dialog, int whichButton) {
                        }
                    });            
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
        launchScanner(v);
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
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        if ( requestCode == Constant.ZBAR_SCANNER_REQUEST ) {
            if (resultCode == RESULT_OK) {
                String afGmNo = WUtil.toDefault(data.getStringExtra(ZBarConstants.SCAN_RESULT));
                if (afGmNo.length() != 12) {
                    alert(R.string.msg_invalid_barcode);
                } else {
//                      String yy        = StringUtils.left(afGmNo,2);
                    String afMakerCd = StringUtils.mid(afGmNo, 2, 1); // 제조사
                    String afModel   = StringUtils.mid(afGmNo, 3, 1); // 모델(등급)
                    String afTypeCd  = StringUtils.mid(afGmNo, 4, 1); // 타입
                    setText(R.id.et_af_gm_no    ,afGmNo   );
                    setText(R.id.spn_af_maker_cd,afMakerCd);
                    setText(R.id.spn_af_model   ,afModel  );
                    setText(R.id.spn_af_type_cd ,afTypeCd );
                }
//                    Toast.makeText(this, "Scan Result = " + data.getStringExtra(ZBarConstants.SCAN_RESULT), Toast.LENGTH_SHORT).show();
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

    @Override
    protected void onResume() {
        super.onResume();
        retrive();
    }

}
