package com.entropykorea.gas.chk.activity;

import java.io.File;
import java.util.HashMap;

import android.annotation.SuppressLint;
import android.content.DialogInterface;
import android.content.Intent;
import android.database.Cursor;
import android.os.Bundle;
import android.text.TextUtils;
import android.view.MenuItem;
import android.view.MotionEvent;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup.LayoutParams;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.Toast;

import com.dm.zbar.android.scanner.ZBarConstants;
import com.entropykorea.ewire.database.Sqlite;
import com.entropykorea.gas.chk.R;
import com.entropykorea.gas.chk.WApplication;
import com.entropykorea.gas.chk.adapter.ChkCplAdapter;
import com.entropykorea.gas.chk.common.DUtil;
import com.entropykorea.gas.chk.common.WConstant;
import com.entropykorea.gas.chk.common.WUtil;
import com.entropykorea.gas.chk.dto.ChkDTO;
import com.entropykorea.gas.lib.BaseActivity;
import com.entropykorea.gas.lib.Constant;
import com.entropykorea.gas.lib.ListViewMP;
import com.entropykorea.gas.lib.PicCamera;
import com.entropykorea.gas.lib.TitleView;
import com.entropykorea.gas.lib.TitleView.OnTopClickListner;
import com.entropykorea.gas.lib.sign.SignView;

/**
 * @author softm
 * ChkCplActivity
 * 점검완료
 */
@SuppressLint("ClickableViewAccessibility")
public class ChkCplActivity extends BaseActivity implements OnClickListener, OnTopClickListner, OnMenuItemClickListener {
    public static final String TAG = "MPGAS";

	private String bldg_cd;
	private String checkup_ym;
	private String checkup_cd;
	private String house_no;
	private String fake_house_no;
    private ChkDTO v = new ChkDTO(); // 현재값
    
    private String room_no             = null;
    private String end_yn              = null;
    private String send_yn             = null;
    private String sign_file_nm        = null;
    
    Cursor c = null;
    PicCamera pc = null;
    SignView signView;
    
	HashMap<String,String> fileInformap = new HashMap<String, String>();
	
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        Intent intent = getIntent();

        // key
        bldg_cd       = WUtil.toDefault(intent.getStringExtra("bldg_cd"));
        
        checkup_ym        = WUtil.toDefault(intent.getStringExtra("checkup_ym"));
        checkup_cd        = WUtil.toDefault(intent.getStringExtra("checkup_cd"));
        house_no      = WUtil.toDefault(intent.getStringExtra("house_no"));
        fake_house_no = WUtil.toDefault(intent.getStringExtra("fake_house_no"));

        if ( !"".equals(checkup_ym) && !"".equals(checkup_cd) && !"".equals(house_no) ) {
            setContentView(R.layout.activity_chk_cpl);
            init();
            if ( "".equals(v.getCheckupIdx()) ) {
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

    @SuppressLint("ClickableViewAccessibility")
    private void init() {
        TitleView tv = new TitleView(this, R.string.title_chk_cpl,false);
        tv.setOnTopClickListner(this);
        findViewById(R.id.ib_eraser   ).setOnClickListener(this);
        findViewById(R.id.ib_close    ).setOnClickListener(this);
        findViewById(R.id.ib_delete   ).setOnClickListener(this);
        findViewById(R.id.ib_finish   ).setOnClickListener(this);
        retrive();
    }

    private void retrive() {
    	v = DUtil.getDataByWhere(getApplicationContext()," WHERE CHECKUP_YM = '" + checkup_ym + "'"
    			+ " AND CHECKUP_CD   = '" + checkup_cd + "'"
    			+ " AND HOUSE_NO = '" + house_no + "'"
    			+ " AND IFNULL(FAKE_HOUSE_NO,'') = '" + fake_house_no + "'"
    			+ " LIMIT 1");
        checkup_ym        = WUtil.toDefault( v.getCheckupYm());
        checkup_cd        = WUtil.toDefault( v.getCheckupCd());
        house_no      = WUtil.toDefault( v.getHouseNo());
        fake_house_no = WUtil.toDefault( v.getFakeHouseNo());
        
        if ( "".equals(checkup_ym) || "".equals(checkup_cd) || "".equals(house_no) ) {            	
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
			setText(R.id.tv_info,room_no);
			setText(R.id.tv_checkup_result_cd, "점검결과 : "+DUtil.getCodeNm(this.getApplicationContext(), "FA040", fGetCheckupResultCd()));
			signView = (SignView) findViewById(R.id.sign_view);
			
			if ( "".equals(sign_file_nm) ) {
			    sign_file_nm = "S_" + checkup_ym + checkup_cd + house_no + fake_house_no + ".bmp";
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
			//          setEnabled(R.id.ib_delete,Boolean.FALSE); // 삭제
			//          setEnabled(R.id.ib_finish,Boolean.FALSE); // 완료
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
			
            String sql = "SELECT "
                    + "     JUM_NOCFM._rowid_ as _id "
                    + "   , JUM_NOCFM.FA_CD             AS FA_CD            "
                    + "   , JUM_NOCFM.CHECKUP_REMARK_CD AS CHECKUP_REMARK_CD"
                    + "   , CM.CD_NM                    AS FA_NM            "
                    + "   , CD.CD_NM                    AS CHECKUP_REMARK_NM"
                    + " FROM " + WConstant.TBL_JUM_NOCFM + " "
                    + " LEFT JOIN " + WConstant.TBL_CODE + " CM "
                    + "   ON CM.TYPE_CD = 'FA010' "
                    + "  AND CM.CD = JUM_NOCFM.FA_CD "
                    + " LEFT JOIN " + WConstant.TBL_CODE + " CD "
                    + "   ON CD.TYPE_CD = 'FA030' "
                    + "  AND CD.CD = JUM_NOCFM.CHECKUP_REMARK_CD "
                    + " WHERE JUM_NOCFM.CHECKUP_IDX   = '" + v.getCheckupIdx()   + "'"
//                    + " UNION "
//                    + " SELECT   "
//                    + " 1 as _id "
//                    + " , '01' AS FA_CD "
//                    + " , '010101' AS CHECKUP_REMARK_CD "
//                    + " , '가스차단기' AS FA_NM "
//                    + " , '가스검지기미설치' AS CHECKUP_REMARK_NM "
            ;
            if ( c!= null ) c.close();
            c = db.rawQuery(sql, null);
            ListViewMP lv1 = (ListViewMP)findViewById(R.id.listView1);
            ChkCplAdapter adapter = new ChkCplAdapter(getApplicationContext(), c, 0);
            int height = (getResources().getDimensionPixelSize(R.dimen.listHeight)+1)*adapter.getCount();
            LayoutParams lp = lv1.getLayoutParams();
            lp.height = height;
            lv1.setLayoutParams(lp);
            lv1.setAdapter(adapter);
//            WUtil.setListViewHeightBasedOnChildren(lv1);
            lv1.requestChildFocus(null,findViewById(R.id.scrollView1));			
        }
    }
    private String fGetCheckupResultCd(){
    	String checkupResultCd = null;
//    	
		if (WConstant.CODE_CHECKUP_RESULT_CD_3.equals(v.getCheckupResultCd())) { // 거부 
			checkupResultCd = WConstant.CODE_CHECKUP_RESULT_CD_3; // 거부. 
		} else if (WConstant.CODE_CHECK_OK_Y.equals(v.getBoilerOkYn())
				&& WConstant.CODE_CHECK_OK_Y.equals(v.getBurnerOkYn())
				&& WConstant.CODE_CHECK_OK_Y.equals(v.getPipeOkYn())
				&& WConstant.CODE_CHECK_OK_Y.equals(v.getGmOkYn())
				&& WConstant.CODE_CHECK_OK_Y.equals(v.getBreakerOkYn())) { // 적합
			checkupResultCd = WConstant.CODE_CHECKUP_RESULT_CD_1;
		} else if (WConstant.CODE_CHECK_OK_N.equals(v.getBoilerOkYn())
				|| WConstant.CODE_CHECK_OK_N.equals(v.getBurnerOkYn())
				|| WConstant.CODE_CHECK_OK_N.equals(v.getPipeOkYn())
				|| WConstant.CODE_CHECK_OK_N.equals(v.getGmOkYn())
				|| WConstant.CODE_CHECK_OK_N.equals(v.getBreakerOkYn())) { // 부적합
			checkupResultCd = WConstant.CODE_CHECKUP_RESULT_CD_2;				
		}
		return checkupResultCd;
    }

    /**
     * 완료
     */
    private boolean fComplete() {
    	boolean rtn = true;
        try {
        	String checkupResultCd = fGetCheckupResultCd();
            String sql = "UPDATE " + WConstant.TBL_JUM
                    + " SET END_YN = '" + Constant.CODE_END_Y + "'"                    
                    + "   , CHECKUP_RESULT_CD = '" + checkupResultCd + "'"
                    + "   , SIGN_FILE_NM = '" + sign_file_nm + "'"
                    + "   , CHECKUP_USER_CD = '" + ((WApplication)mApp).getUserId() + "'" // 점검작업자
//                    + "   , CHECKUP_END_DT = time()" // 점검종료시간
                    + "   , CHECKUP_END_DT = strftime('%H%M%S','now','localtime')" //  점검종료시간
    	            + " WHERE CHECKUP_YM   = '" + checkup_ym   + "'"
    	            + "   AND CHECKUP_CD   = '" + checkup_cd   + "'"
    	            + "   AND HOUSE_NO = '" + house_no + "'"
    	            + "   AND IFNULL(FAKE_HOUSE_NO,'')  = '" + fake_house_no  + "'"
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

    @Override
    public void onClick(View v) {
        int viewID = v.getId();
        if ( viewID == R.id.ib_finish ) { // 완료
        	boolean exec = true;
        	if ( !Constant.CODE_Y.equals(ChkCplActivity.this.v.getQrReadYn()) ) { // QR인식 N
    	        if ( !signView.isEdited() ) {
    	            alert(R.string.msg_do_sign); // 서명해주세요.
    	        } else {
    	        	exec = signView.Save(Constant.SIGN_DIR + File.separator + sign_file_nm);
    	        }
        	} else { // QR인식한 Y
        		exec = true;
        	}
        	if (exec) {
	            confirm(R.string.msg_sign_complete_confirm, // 저장하고 완료하시겠습니까?
	                new DialogInterface.OnClickListener() {
	                    public void onClick(DialogInterface dialog, int whichButton) {
	                    	boolean exec = true;
	                    	if( "0".equals(fake_house_no) &&
	                    			"".equals(ChkCplActivity.this.v.getCheckupMeter())
	                    			) { // 가수용가번호가 없는세대이고 점검계량기지침이 없을경우.
	                    		alert(R.string.msg_check_input_checkup_meter); // 점검계량기지침이 입력되지 않았습니다.
	                    	} else {
	                        	if ( fComplete() ) {
	                                alert(R.string.msg_do_sign_complete, // 완료되었습니다
	                                    	new DialogInterface.OnClickListener() {
	                                        	public void onClick(DialogInterface dialog, int whichButton) {
	                                        		if (WConstant.CODE_CHECKUP_RESULT_CD_3.equals(ChkCplActivity.this.fGetCheckupResultCd())) { // 거부 
	                                	                Intent sIntent = new Intent(ChkCplActivity.this,HouseListActivity.class); // 수용가목록
	                                        			sIntent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);	                                    	                
	                                	                sIntent.putExtra("bldg_cd", bldg_cd);
	                                	                startActivity(sIntent);
	                                	                finish();
	                                        		} else {
	                                	                Intent sIntent = new Intent(ChkCplActivity.this,HouseListActivity.class); // 수용가목록
	                                        			sIntent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);	                                    	                
	                                	                sIntent.putExtra("bldg_cd", bldg_cd);
	                                	                startActivity(sIntent);
	                                	                finish();
	//	                                            			Intent sIntent = new Intent(ChkCplActivity.this,ChkRegMainActivity.class); // 점검등록메인				
	//	                                            			sIntent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);		                                            	   
	//	                                            			sIntent.putExtra("bldg_cd"       , bldg_cd); // 건물그룹번호  
	//	                                            			sIntent.putExtra("checkup_ym"        , checkup_ym ); // 작업년월(PK)  
	//	                                            			sIntent.putExtra("checkup_cd"        , checkup_cd ); // 업무코드(PK)
	//	                                            			sIntent.putExtra("house_no"      , house_no ); // 수용가번호(PK)
	//	                                            			sIntent.putExtra("fake_house_no" , fake_house_no ); // 가수용가번호(PK)
	//	                                            			startActivity(sIntent);           
	                                        		}
	                                        }
									});
	                            } else {
	                            	alert(R.string.msg_exec_error);
	                            }
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
                            }
                            try {
                                String sql = "UPDATE " + WConstant.TBL_JUM
                                        + " SET END_YN = '" + Constant.CODE_END_N + "'"
                                        + "   , SIGN_FILE_NM = ''"
                        	            + " WHERE CHECKUP_YM   = '" + checkup_ym   + "'"
                        	            + "   AND CHECKUP_CD   = '" + checkup_cd   + "'"
                        	            + "   AND HOUSE_NO = '" + house_no + "'"
                        	            + "   AND IFNULL(FAKE_HOUSE_NO,'')  = '" + fake_house_no  + "'"
                                ;
                                Sqlite sqlite = new Sqlite(db);
                                sqlite.execSql(sql);
                            } catch( Exception ex ) {
                                alert(R.string.msg_db_error); // 저장중 오류가 발생하였습니다.
                            } finally {
                            	alert(R.string.msg_deleted // 삭제되었습니다. 
                            			, new DialogInterface.OnClickListener() {
                            		public void onClick(DialogInterface dialog, int whichButton) {
					                    Intent sIntent = new Intent(ChkCplActivity.this,ChkRegMainActivity.class); // 점검등록메인				
					                    sIntent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);		                                            	   
					                    sIntent.putExtra("bldg_cd"       , bldg_cd); // 건물그룹번호  
					                    sIntent.putExtra("checkup_ym"        , checkup_ym ); // 작업년월(PK)  
					                    sIntent.putExtra("checkup_cd"        , checkup_cd ); // 업무코드(PK)
					                    sIntent.putExtra("house_no"      , house_no ); // 수용가번호(PK)
					                    sIntent.putExtra("fake_house_no" , fake_house_no ); // 가수용가번호(PK)
					    				startActivity(sIntent);           
                            			finish();	    
                            		}
                            	});
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
				try {
					Intent intent = new Intent();
					intent.setClassName("com.entropykorea.gas.main", "com.entropykorea.gas.main.activity.AboutActivity");
					startActivity( intent );
				} catch (Exception e) {
					e.printStackTrace();
				}
			} else {
				alert( getString(R.string.app_name) + " ver. " + getString(R.string.app_version) );
			}
			
			break;
		case R.id.menu_action_2:
			if( isInstalledApplication("com.entropykorea.gas.main") ) {
				try {
					Intent intent = new Intent();
					intent.setClassName("com.entropykorea.gas.main", "com.entropykorea.gas.main.activity.SettingActivity");
					startActivityForResult(intent, 100);
				} catch (Exception e) {
					e.printStackTrace();
				}
			} else {
				//alert( "메인화면에서 지원하지 않습니다." );
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
                }
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
