package com.entropykorea.gas.chk.activity;

import java.io.File;
import java.util.HashMap;

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
import android.widget.ImageView;
import android.widget.PopupMenu;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.Toast;

import com.dm.zbar.android.scanner.ZBarConstants;
import com.entropykorea.ewire.eWireData;
import com.entropykorea.ewire.eWireTrans;
import com.entropykorea.ewire.database.Sqlite;
import com.entropykorea.ewire.database.SqliteManager;
import com.entropykorea.gas.chk.R;
import com.entropykorea.gas.chk.WApplication;
import com.entropykorea.gas.chk.common.DUtil;
import com.entropykorea.gas.chk.common.WConstant;
import com.entropykorea.gas.chk.common.WUtil;
import com.entropykorea.gas.chk.dto.ChkCountDTO;
import com.entropykorea.gas.chk.spec.JumCustSpec;
import com.entropykorea.gas.chk.spec.JumExceptionSpec;
import com.entropykorea.gas.chk.spec.JumNocfmPhotoSpec;
import com.entropykorea.gas.chk.spec.JumNocfmUpSpec;
import com.entropykorea.gas.chk.spec.JumResultSpec;
import com.entropykorea.gas.chk.spec.JumVisitUpSpec;
import com.entropykorea.gas.lib.BaseActivity;
import com.entropykorea.gas.lib.Constant;
import com.entropykorea.gas.lib.TitleView;
import com.entropykorea.gas.lib.TitleView.OnTopClickListner;
import com.entropykorea.gas.lib.Util;
import com.entropykorea.gas.lib.dialog.LongTimeDialog;
import com.mypidion.BI300.BI300Bluetooth;

/**
 * @author softm
 * ChkMainActivity
 * 점검메인
 */
@SuppressLint("HandlerLeak")
public class ChkMainActivity extends BaseActivity implements OnClickListener, OnTopClickListner, OnMenuItemClickListener {
    public static final String TAG = "MPGAS";
    ImageView mImagePicView;
    private BI300Bluetooth bi300 = null;
	HashMap<String,String> fileInformap = new HashMap<String, String>();
    String tmpJobCd = "";
	Sqlite mSqlite = null;
	
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_chk_main);
        mSqlite = new Sqlite(db);
        init();
        // check database & upgrade
        databaseUpgrade();
    }

    private void init() {
        TitleView tv = new TitleView(this, R.string.title_chk_main,false,true);
        tv.setOnTopClickListner(this);
        findViewById(R.id.ib_chkstart1).setOnClickListener(this);
        findViewById(R.id.ib_send1    ).setOnClickListener(this);
        findViewById(R.id.ib_delete1  ).setOnClickListener(this);

        findViewById(R.id.ib_chkstart2).setOnClickListener(this);
        findViewById(R.id.ib_send2    ).setOnClickListener(this);
        findViewById(R.id.ib_delete2  ).setOnClickListener(this);

        findViewById(R.id.ib_chkstart3).setOnClickListener(this);
        findViewById(R.id.ib_send3    ).setOnClickListener(this);
        findViewById(R.id.ib_delete3  ).setOnClickListener(this);

        findViewById(R.id.ib_receive  ).setOnClickListener(this);
    }

    private void retrive() {
        ChkCountDTO v1 = DUtil.getChkCount(this.getApplicationContext(),WConstant.CODE_CHECKUP_CD_1);
        int cCnt1 = v1.getCompleteCount();
        int ncCnt1 = v1.getNotCompleteCount();
        int nsCnt1 = v1.getNotSendCount();
        int tCnt1 = cCnt1 + ncCnt1 + nsCnt1;
        setText(R.id.t_cnt1,WUtil.numberFormat("#,###",tCnt1));
        setText(R.id.c_cnt1,WUtil.numberFormat("#,###",cCnt1));
        setText(R.id.nc_cnt1,WUtil.numberFormat("#,###",ncCnt1));
        setText(R.id.ns_cnt1,WUtil.numberFormat("#,###",nsCnt1));
        if ( tCnt1 == 0 ) {
            setVisibility(R.id.tv_colron1, View.GONE);
            setVisibility(R.id.tv_checkup_cd1_yyyymm, View.GONE);
//          setVisibility(R.id.ll_job_cd1_bottom, View.GONE);
        } else {
            setVisibility(R.id.tv_colron1, View.VISIBLE);
            setVisibility(R.id.tv_checkup_cd1_yyyymm, View.VISIBLE);
            String yyyymm = DUtil.getCurrentChkYYYYMM(getApplicationContext(),WConstant.CODE_CHECKUP_CD_1);
            setText(R.id.tv_checkup_cd1_yyyymm, StringUtils.left(yyyymm, 4) + "/" + StringUtils.right(yyyymm, 2));
            int vnsCnt1 = DUtil.getVisitDataCountByWhere(getApplicationContext()," WHERE JUM.CHECKUP_YM   = '" + yyyymm   + "'"
                    + "   AND JUM.CHECKUP_CD   = '" + WConstant.CODE_CHECKUP_CD_1   + "'"
                    + "   AND JUM.SEND_YN  = '" + Constant.CODE_SEND_N+ "'"
                    + "   AND JUM_VISIT.SEND_YN  = '" + Constant.CODE_SEND_N+ "'"                    
                    );
            setText(R.id.vns_cnt1,WUtil.numberFormat("#,###",vnsCnt1));
        }

        ChkCountDTO v2 = DUtil.getChkCount(this.getApplicationContext(),WConstant.CODE_CHECKUP_CD_2);
        int cCnt2 = v2.getCompleteCount();
        int ncCnt2 = v2.getNotCompleteCount();
        int nsCnt2 = v2.getNotSendCount();
        int tCnt2 = cCnt2 + ncCnt2 + nsCnt2;
        setText(R.id.t_cnt2,WUtil.numberFormat("#,###",tCnt2));
        setText(R.id.c_cnt2,WUtil.numberFormat("#,###",cCnt2));
        setText(R.id.nc_cnt2,WUtil.numberFormat("#,###",ncCnt2));
        setText(R.id.ns_cnt2,WUtil.numberFormat("#,###",nsCnt2));
        if ( tCnt2 == 0 ) {
            setVisibility(R.id.tv_colron2, View.GONE);
            setVisibility(R.id.tv_checkup_cd2_yyyymm, View.GONE);
//          setVisibility(R.id.ll_job_cd2_bottom, View.GONE);
        } else {
            setVisibility(R.id.tv_colron2, View.VISIBLE);
            setVisibility(R.id.tv_checkup_cd2_yyyymm, View.VISIBLE);
            String yyyymm = DUtil.getCurrentChkYYYYMM(getApplicationContext(),WConstant.CODE_CHECKUP_CD_2);
            setText(R.id.tv_checkup_cd2_yyyymm, StringUtils.left(yyyymm, 4) + "/" + StringUtils.right(yyyymm, 2));
            int vnsCnt2 = DUtil.getVisitDataCountByWhere(getApplicationContext()," WHERE JUM.CHECKUP_YM   = '" + yyyymm   + "'"
                    + "   AND JUM.CHECKUP_CD   = '" + WConstant.CODE_CHECKUP_CD_2   + "'"
                    + "   AND JUM.SEND_YN  = '" + Constant.CODE_SEND_N+ "'");
            setText(R.id.vns_cnt2,WUtil.numberFormat("#,###",vnsCnt2));
        }
        ChkCountDTO v3 = DUtil.getChkCount(this.getApplicationContext(),WConstant.CODE_CHECKUP_CD_3);
        int cCnt3 = v3.getCompleteCount();
        int ncCnt3 = v3.getNotCompleteCount();
        int nsCnt3 = v3.getNotSendCount();
        int tCnt3 = cCnt3 + ncCnt3 + nsCnt3;
        setText(R.id.t_cnt3,WUtil.numberFormat("#,###",tCnt3));
        setText(R.id.c_cnt3,WUtil.numberFormat("#,###",cCnt3));
        setText(R.id.nc_cnt3,WUtil.numberFormat("#,###",ncCnt3));
        setText(R.id.ns_cnt3,WUtil.numberFormat("#,###",nsCnt3));
        if ( tCnt3 == 0 ) {
            setVisibility(R.id.tv_colron3, View.GONE);
            setVisibility(R.id.tv_checkup_cd3_yyyymm, View.GONE);
//          setVisibility(R.id.ll_job_cd3_bottom, View.GONE);
        } else {
            setVisibility(R.id.tv_colron3, View.VISIBLE);
            setVisibility(R.id.tv_checkup_cd3_yyyymm, View.VISIBLE);
            String yyyymm = DUtil.getCurrentChkYYYYMM(getApplicationContext(),WConstant.CODE_CHECKUP_CD_3);
            setText(R.id.tv_checkup_cd3_yyyymm, StringUtils.left(yyyymm, 4) + "/" + StringUtils.right(yyyymm, 2));
            int vnsCnt3 = DUtil.getVisitDataCountByWhere(getApplicationContext()," WHERE JUM.CHECKUP_YM   = '" + yyyymm   + "'"
                    + "   AND JUM.CHECKUP_CD   = '" + WConstant.CODE_CHECKUP_CD_3   + "'"
                    + "   AND JUM.SEND_YN  = '" + Constant.CODE_SEND_N+ "'");
            setText(R.id.vns_cnt3,WUtil.numberFormat("#,###",vnsCnt3));
        }
    }
    
    /**
     * 송신
     */
    protected void fSend(String checkupCd) {
        callExport(checkupCd);
//      startProgressBar();
//      new Thread(new Runnable() {
//          public void run() {
//              try {
//                  Thread.sleep(2000);
//              } catch (InterruptedException e) {
//                  e.printStackTrace();
//              }
//              sendMessage(ConstantChg.PROC_ID_SEND_DATA, "1", false, "DAT");
//          }
//      }).start();
    }

    private void callExport(final String checkupCd) {
    	// 서명 & 방문 파일 ADD -----------------------------------------------------------------
			String sql = "SELECT " 
					+ " CHECKUP_YM " 
					+ ",CHECKUP_CD " 
					+ ",HOUSE_NO "
					+ ",FAKE_HOUSE_NO " 
					+ " FROM " + WConstant.TBL_JUM
					+ " WHERE END_YN   = '" + Constant.CODE_END_Y  + "'"
					+ "   AND SEND_YN  = '" + Constant.CODE_SEND_N + "'"
			        + "   AND CHECKUP_CD   = '" + checkupCd + "'"
			;
			mSqlite.rawQuery(sql);
			int i = -1;
			mSqlite.moveToFirst();
			do {
				i++;
				String checkupYm = mSqlite.getValue("CHECKUP_YM", i);
				String houseNo = mSqlite.getValue("HOUSE_NO", i);
				String fakeHouseNo = mSqlite.getValue("FAKE_HOUSE_NO", i);
				String toSignFile = "S_" + checkupYm + checkupCd + houseNo + fakeHouseNo + ".bmp";
				String toVisitPicFile = "P_" + checkupYm + checkupCd + houseNo + fakeHouseNo +"_VISIT" + ".jpg";
				
				if ( new File(Constant.SIGN_DIR + File.separator + toSignFile).exists() ) {
					fileInformap.put(toSignFile, Constant.SIGN_DIR + File.separator + toSignFile);
				}
				if ( new File(Constant.PIC_DIR + File.separator + toVisitPicFile).exists() ) {
					fileInformap.put(toVisitPicFile, Constant.PIC_DIR + File.separator + toVisitPicFile);
				}			
				
			} while (mSqlite.moveToNext());
			
	    // 중계점검부적합사진파일 ADD -----------------------------------------------------------------
			String sql2 = "SELECT " 
					+ " JUM.CHECKUP_YM        AS CHECKUP_YM" 
					+ ",JUM.CHECKUP_CD        AS CHECKUP_CD" 
					+ ",JUM.HOUSE_NO          AS HOUSE_NO"
					+ ",JUM.FAKE_HOUSE_NO     AS FAKE_HOUSE_NO" 
					+ ",JUM_NOCFM_PHOTO.FA_CD         AS FA_CD" 
					+ ",JUM_NOCFM_PHOTO.PHOTO_FILE_NM AS PHOTO_FILE_NM" 
					+ " FROM " + WConstant.TBL_JUM
					+ " JOIN " + WConstant.TBL_JUM_NOCFM_PHOTO
					+ "   ON JUM.CHECKUP_IDX        = JUM_NOCFM_PHOTO.CHECKUP_IDX " 
					+ " WHERE JUM.END_YN   = '" + Constant.CODE_END_Y  + "'"
					+ "   AND JUM.SEND_YN  = '" + Constant.CODE_SEND_N + "'"
	                + "   AND JUM.CHECKUP_CD   = '" + checkupCd + "'"
	        ;
			mSqlite.rawQuery(sql2);
			int i2 = -1;
			mSqlite.moveToFirst();
			do {
				i2++;
//				String checkupYm = sqlite.getValue("CHECKUP_YM", i2);
//				String checkupCd = sqlite.getValue("CHECKUP_CD", i2);
//				String houseNo = sqlite.getValue("HOUSE_NO", i2);
//				String fakeHouseNo = sqlite.getValue("FAKE_HOUSE_NO", i2);
				String photoFileNm = mSqlite.getValue("PHOTO_FILE_NM", i2);
				if ( !"".equals(photoFileNm) && new File(Constant.PIC_DIR + File.separator + photoFileNm).exists() ) {
					fileInformap.put(photoFileNm, Constant.PIC_DIR + File.separator + photoFileNm);
				}
				
			} while (mSqlite.moveToNext());
			
            String zipfilename = Constant.WORK_DIR + File.separator + "up.zip";
            // set ewiredata
            eWireData ewireData = new eWireData( this ) {

                @Override
                public void onFinished(boolean result, String resultMessage) {
                    if( result ) {
                        callTrans(checkupCd);
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
            ewireData.setZipfilename( zipfilename );
            ewireData.setOutputFolder( Constant.WORK_DIR );
/*
            jum_result.dat
            jum_visit_up.dat
            jum_exception.dat
            jum_nocfm_up.dat
            jum_nocfm_photo.dat
            jum_cust.dat
*/

            JumResultSpec jumResultSpec = new JumResultSpec();
            jumResultSpec.whereClause = "WHERE END_YN = '" + Constant.CODE_END_Y  + "' "
            		                  + "  AND SEND_YN= '" + Constant.CODE_SEND_N + "' "
            		                  + "  AND CHECKUP_CD = '" + checkupCd                + "' "
            		                  ;
            JumVisitUpSpec jumVisitSpec = new JumVisitUpSpec();
            jumVisitSpec.whereClause  =" WHERE CHECKUP_IDX IN ("
				                    + "    SELECT "
				                    + "        CHECKUP_IDX "
				                    + "    FROM " + WConstant.TBL_JUM
				                    + "    WHERE SEND_YN    = '" + Constant.CODE_SEND_N + "' "
				                    + "      AND CHECKUP_CD = '" + checkupCd            + "' "
				                    + " )"    		
            ;

            JumExceptionSpec  jumExceptionSpec  = new JumExceptionSpec ();
            JumNocfmUpSpec    jumNocfmUpSpec    = new JumNocfmUpSpec   ();
            JumNocfmPhotoSpec jumNocfmPhotoSpec = new JumNocfmPhotoSpec();

            JumCustSpec   jumCustSpec   = new JumCustSpec()  ;
            jumCustSpec.whereClause   = " WHERE "
                                      + "  EXISTS ( "
                                      + "   SELECT * FROM " + WConstant.TBL_JUM + " JUM "
                                      + "   WHERE JUM.END_YN  = '" + Constant.CODE_END_Y  + "' "
                                      + "   AND   JUM.SEND_YN = '" + Constant.CODE_SEND_N + "' "
                                      + "   AND   JUM.CHECKUP_IDX = JUM_CUST.CHECKUP_IDX "
                                      + "  ) "
            ;

            Object[] databasespecication = {
                      jumResultSpec         // jum_result.dat
                    , jumVisitSpec          // jum_visit_up.dat
                    , jumExceptionSpec      // jum_exception.dat
                    , jumNocfmUpSpec        // jum_nocfm_up.dat
                    , jumNocfmPhotoSpec     // jum_nocfm_photo.dat
                    , jumCustSpec           // jum_cust.dat
            };
            ewireData.setDatabaseSpecication(databasespecication);

    		ewireData.setAddFiles( fileInformap ); // 추가 파일
    		
            // file name only
    //      String[] files = FileUtils.getFiles(path, ".bmp");
    //      ewireData.setAddFiles( path, files ); // 추가 파일

            // file name with path
    //      String[] filesWithDirectory = FileUtils.getFilesWithDirectory(path, ".bmp");
    //      String[] filesWithDirectory = {
    //              "/sdcard/mpgas/sign.bmp",
    //              "/sdcard/mpgas/test.bmp"
    //      };
    //      ewireData.setAddFiles( filesWithDirectory ); // 추가 파일

            // option
            ewireData.setDialogType(eWireData.DIALOGTYPE_WAIT);
            ewireData.setDisplayMessage(eWireData.DEFAULT_DISPLAYMESSAGE);
            ewireData.setShowError(true);
            ewireData.setSoundPlay(false);

            ewireData.setDelayTime(1000);

            // do
            ewireData.excuteExport();
        }

    private void callTrans(final String checkupCd) {
        String yyyyMm = Util.getSysYYYYMM();
//          String yyyyMm = getValue(R.id.et_yyyy) + getValue(R.id.et_mm);
        String userid = ((WApplication)mApp).getUserId();
        String machineId = ((WApplication)mApp).getMachineId();
        String command = "C";
        String instruction = "jum_up";
//      String param = "DOWN|/DATA/CHG/DN/20141030/DN_CHG_01_144203.ZIP|201411|01";
//              UP|/DATA/JUM/UP/(YYYYMMDD)/UP_JUM_(기기번호)_hhmmss.ZIP|작업년월|점검구분|기기번호
        
        String param = "UP|/DATA/JUM/UP/"+ Util.getSysYYYYMMDD() +"/UP_JUM_"+machineId+"_"+Util.getSysHHMMSS()+".ZIP|"+ yyyyMm +"|" + checkupCd +"|"+machineId;
        String zipfilename = Constant.WORK_DIR + File.separator + "up.zip";

        eWireTrans ewireTrans;
        // eWire
        ewireTrans = new eWireTrans( this ){
            @Override
            public void onFinished(boolean result, String resultMessage) {
                if( result ) {
                    alert(R.string.msg_do_sign_complete, // 완료되었습니다
                            new DialogInterface.OnClickListener() {
                                public void onClick(DialogInterface dialog, int whichButton) {
                                    String sql = "UPDATE " + WConstant.TBL_JUM
                                            + " SET SEND_YN = '" + Constant.CODE_SEND_Y + "'"
                                            + " WHERE END_YN = '" + Constant.CODE_END_Y + "'" 
                                            + "   AND SEND_YN= '" + Constant.CODE_SEND_N + "' "
                                            + "   AND CHECKUP_CD = '" + checkupCd + "'"
                                    ;
                                    mSqlite.execSql(sql);
                                    
                                    String sql2 = "UPDATE " + WConstant.TBL_JUM_VISIT
                                            + " SET SEND_YN = '" + Constant.CODE_SEND_Y + "'"
                                            + " WHERE CHECKUP_IDX IN ("
                                            + "    SELECT "
                                            + "        CHECKUP_IDX "
                                            + "    FROM " + WConstant.TBL_JUM
                                            + "    WHERE SEND_YN    = '" + Constant.CODE_SEND_N + "' "
                                            + "      AND CHECKUP_CD = '" + checkupCd            + "' "
                                            + " )"
                                    ;
                                    mSqlite.execSql(sql2);      
                                    
                                    retrive();
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
        ewireTrans.setFileName(zipfilename);

        // option
        ewireTrans.setDialogType(eWireTrans.DIALOGTYPE_PROGRESS);
        ewireTrans.setDisplayMessage(eWireTrans.DEFAULT_DISPLAYMESSAGE);
        ewireTrans.setShowError(true);
        ewireTrans.setSoundPlay(true);

        ewireTrans.setDelayTime(1000);

        // eWire Thread
        ewireTrans.excuteTrans();
    }

    // data upgrade
    public void databaseUpgrade() {
        SqliteManager sqliteManager = new SqliteManager( this, mApp.getDatabase() );
//      SqliteManager sqliteManager = AppContext.getSqliteManager();

        if( sqliteManager.isVersionDiff( getString( R.string.db_user_version )) ) {
            new LongTimeDialog( this, "안정적인 서비스를 위하여\n데이타베이스를 업그레이드 중입니다.\n\n잠시만 기다리십시요...", true, sqliteManager ) {
                @Override
                public Boolean doBackground( Object obj ) {

                    SqliteManager db = (SqliteManager)obj;

                    try {
                        Thread.sleep(3000);
                    } catch (InterruptedException e) {
                        e.printStackTrace();
                    }

                    // upgrade
                    if( !db.upgradeTables( R.raw.createtable ) ) {
                        return false;
                    }
                    return true;
                }

                @Override
                public void doEndExecute( Object obj, Boolean result) {

                    SqliteManager db = (SqliteManager)obj;

                    if( result ) {
                        //Toast.makeText(MainActivity.this, "완료되었습니다.", Toast.LENGTH_SHORT).show();
                    } else {
                        Toast.makeText(ChkMainActivity.this, db.getErrorMessage(), Toast.LENGTH_SHORT).show();
                    }

                }
            }.show();
        }
    }

    @Override
    public void onClick(View v) {
        int viewID = v.getId();
        if ( viewID == R.id.ib_chkstart1 || viewID == R.id.ib_chkstart2 || viewID == R.id.ib_chkstart3 ) { // 점검
            String checkupCd = "";
            if ( viewID == R.id.ib_chkstart1 ) {
                checkupCd = WConstant.CODE_CHECKUP_CD_1;
            } else if ( viewID == R.id.ib_chkstart2 ) {
                checkupCd = WConstant.CODE_CHECKUP_CD_2;
            } else if ( viewID == R.id.ib_chkstart3 ) {
                checkupCd = WConstant.CODE_CHECKUP_CD_3;
            }
            int tot = DUtil.getDataCount(this.getApplicationContext(),checkupCd);
            if ( tot == 0 ) {
                alert(R.string.msg_receive_meter_chk_data); // 점검자료를 수신하세요.
            } else {
                Intent i = new Intent(this,BldgListActivity.class); // 건물목록
                i.putExtra("checkup_cd", checkupCd);
                startActivity(i);
            }
        } else if ( viewID == R.id.ib_send1 || viewID == R.id.ib_send2 || viewID == R.id.ib_send3 ) { // 송신
            String checkupCd = "";
            if ( viewID == R.id.ib_send1 ) {
                checkupCd = WConstant.CODE_CHECKUP_CD_1;
            } else if ( viewID == R.id.ib_send2 ) {
                checkupCd = WConstant.CODE_CHECKUP_CD_2;
            } else if ( viewID == R.id.ib_send3 ) {
                checkupCd = WConstant.CODE_CHECKUP_CD_3;
            }
            int sendableCnt = DUtil.getSendableCount(this.getApplicationContext(),checkupCd);
            final String tmpJobCd = checkupCd;
            
            int sendableVisitCnt = DUtil.getSendableVisitDataCount(this.getApplicationContext(),checkupCd);
            
            if ( sendableCnt == 0 && sendableVisitCnt == 0 ) { // 송신가능수
                alert(R.string.msg_send_no_data); // 송신할 자료가 없습니다. 확인바랍니다.
            } else {
                confirm(R.string.msg_send_confirm // 송신하시겠습니까?
                        , new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int whichButton) {
                                fSend(tmpJobCd);
                            }
                        }
                        , new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int whichButton) {
                            }
                        }
                );
            }
        } else if ( viewID == R.id.ib_delete1 || viewID == R.id.ib_delete2 || viewID == R.id.ib_delete3 ) { // 삭제
            if ( viewID == R.id.ib_delete1 ) {
                tmpJobCd = WConstant.CODE_CHECKUP_CD_1;
            } else if ( viewID == R.id.ib_delete2 ) {
                tmpJobCd = WConstant.CODE_CHECKUP_CD_2;
            } else if ( viewID == R.id.ib_delete3 ) {
                tmpJobCd = WConstant.CODE_CHECKUP_CD_3;
            }
            int tot = DUtil.getDataCount(this.getApplicationContext(),tmpJobCd);
            int sendableVisitCnt = DUtil.getSendableVisitDataCount(this.getApplicationContext(),tmpJobCd);
            
            if ( tot > 0 || sendableVisitCnt > 0 ) {            
                confirm(R.string.msg_del_confirm
                        , new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int whichButton) {
                                DUtil.deleteData(ChkMainActivity.this.getApplicationContext(),tmpJobCd);
                                retrive();
                            }
                        }
                        , new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int whichButton) {
                            }
                        }
                );
            } else {
            }
        } else if ( viewID == R.id.ib_receive ) { // 점검대상 수신
           Intent ii = new Intent(this,ChkTargetRcvActivity.class); // 점검대상 수신
           startActivity(ii);
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
                            WUtil.goHouseInf(ChkMainActivity.this, bfGmNo);
                            break;
                        }
                    };
                });
                bi300.startBI300();
            } catch (Exception e) {
//              alert("바코드스캐너 블루투스 연결하세요.");
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
    /**
     * Top상단 백 버튼 클릭
     * @param v
     */
    @Override
    public void onClickBackButton(View v) {
        onBackPressed();
    }

    public void showMenu(View anchor, int menuRes) {
        //Context wrapper = new ContextThemeWrapper(getBaseContext(), R.style.PopupMenu);
        PopupMenu popup = new PopupMenu(this, anchor);
        popup.setOnMenuItemClickListener((OnMenuItemClickListener) this);
        popup.inflate(menuRes);
        popup.show();
    }

    public void showMenu() {
//      View anchor = (View) findViewById( R.id.btn_one );
//      showMenu(anchor, R.menu.main);
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        switch (requestCode) {
            case Constant.ZBAR_SCANNER_REQUEST:
                if (resultCode == RESULT_OK) {
                    String bfGmNo = WUtil.toDefault(data.getStringExtra(ZBarConstants.SCAN_RESULT));
                    WUtil.goHouseInf(ChkMainActivity.this, bfGmNo);
                    //                  Toast.makeText(this, "Scan Result = " + data.getStringExtra(ZBarConstants.SCAN_RESULT), Toast.LENGTH_SHORT).show();
                } else if(resultCode == RESULT_CANCELED && data != null) {
                    String error = data.getStringExtra(ZBarConstants.ERROR_INFO);
                    if(!TextUtils.isEmpty(error)) {
                        Toast.makeText(this, error, Toast.LENGTH_SHORT).show();
                    }
                }
                break;
            case Constant.ZBAR_QR_SCANNER_REQUEST:
                break;
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
}
