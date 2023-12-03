package com.entropykorea.gas.chg.activity;

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
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.PopupMenu;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.TextView;
import android.widget.Toast;

import com.dm.zbar.android.scanner.ZBarConstants;
import com.entropykorea.ewire.eWireData;
import com.entropykorea.ewire.eWireTrans;
import com.entropykorea.ewire.database.Sqlite;
import com.entropykorea.ewire.database.SqliteManager;
import com.entropykorea.gas.chg.R;
import com.entropykorea.gas.chg.WApplication;
import com.entropykorea.gas.chg.common.DUtil;
import com.entropykorea.gas.chg.common.WConstant;
import com.entropykorea.gas.chg.common.WUtil;
import com.entropykorea.gas.chg.dto.MeterCountDTO;
import com.entropykorea.gas.chg.spec.ChgCustSpec;
import com.entropykorea.gas.chg.spec.ChgResultSpec;
import com.entropykorea.gas.lib.BaseActivity;
import com.entropykorea.gas.lib.Constant;
import com.entropykorea.gas.lib.TitleView;
import com.entropykorea.gas.lib.TitleView.OnTopClickListner;
import com.entropykorea.gas.lib.Util;
import com.entropykorea.gas.lib.dialog.LongTimeDialog;
import com.mypidion.BI300.BI300Bluetooth;

/**
 * @author softm
 * MeterChgMainActivity
 * 계량기교체메인
 */
@SuppressLint("HandlerLeak")
public class MeterChgMainActivity extends BaseActivity implements OnClickListener, OnTopClickListner, OnMenuItemClickListener {
    public static final String TAG = "MPGAS";
    ImageView mImagePicView;
    ImageButton mBtnSend;
    ImageButton mBtnReceive;
    ImageButton mBtnGauge;
    private BI300Bluetooth bi300 = null;
	HashMap<String,String> fileInformap = new HashMap<String, String>();
	
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_meter_chg_main);
        init();
        // check database & upgrade
        databaseUpgrade();
    }

    private void init() {
        TitleView tv = new TitleView(this, R.string.title_meter_change_main,true,true);
        tv.setOnTopClickListner(this);
        mBtnSend = (ImageButton) findViewById(R.id.btn_send);
        mBtnSend.setOnClickListener(this);
        mBtnReceive = (ImageButton) findViewById(R.id.btn_receive);
        mBtnReceive.setOnClickListener(this);
        mBtnGauge = (ImageButton) findViewById(R.id.btn_gauge);
        mBtnGauge.setOnClickListener(this);
    }

    public void retrive() {
        TextView tvTCnt = (TextView) findViewById(R.id.t_cnt);
        TextView tvCCnt = (TextView) findViewById(R.id.c_cnt);
        TextView tvNCCnt = (TextView) findViewById(R.id.nc_cnt);
        TextView tvNSCnt = (TextView) findViewById(R.id.ns_cnt);

        MeterCountDTO v = DUtil.getMeterCount(this.getApplicationContext());

        int cCnt = v.getCompleteCount();
        int ncCnt = v.getNotCompleteCount();
        int nsCnt = v.getNotSendCount();
        int tCnt = cCnt + ncCnt + nsCnt;
        tvTCnt.setText(WUtil.numberFormat("#,###",tCnt));
        tvCCnt.setText(WUtil.numberFormat("#,###",cCnt));
        tvNCCnt.setText(WUtil.numberFormat("#,###",ncCnt));
        tvNSCnt.setText(WUtil.numberFormat("#,###",nsCnt));

        String yyyyMm = DUtil.getCurrentChgYYYYMM(getApplicationContext());
        if ( "".equals(yyyyMm) ) {
            setVisibility(R.id.ll_yyyymm,View.INVISIBLE);
            setEnabled(R.id.btn_send,Boolean.FALSE);
            setEnabled(R.id.btn_gauge,Boolean.FALSE);
        } else {
            setText(R.id.tv_yyyy,StringUtils.left(yyyyMm, 4));
            setText(R.id.tv_mm, StringUtils.right(yyyyMm, 2));
            setVisibility(R.id.ll_yyyymm,View.VISIBLE);
            setEnabled(R.id.btn_send,Boolean.TRUE);
            setEnabled(R.id.btn_gauge,Boolean.TRUE);
        }
    }
    /**
     * 송신
     */
    protected void fSend() {
        callExport();
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

    public void callExport() {
    	boolean exec = true;
    	String sql = "SELECT "
    			   + " GM_CHG_YM "
    			   + ",HOUSE_NO "
    			   + ",CUST_NO "
    			   + ",IFNULL(AF_SEAL_CD,'') AS AF_SEAL_CD "
    			   + " FROM " + WConstant.TBL_CHG
                   + " WHERE END_YN   = '" + Constant.CODE_END_Y + "'"	                            			   
                   + "   AND SEND_YN  = '" + Constant.CODE_SEND_N + "'"	                            			   
        ;
    	Sqlite sqlite = new Sqlite(db);
    	sqlite.rawQuery(sql);
        int i = -1;
        sqlite.moveToFirst();
		do {
			i++;
			String jobYm   = sqlite.getValue("GM_CHG_YM"  ,i);
			String houseNo = sqlite.getValue("HOUSE_NO",i);
			String custNo  = sqlite.getValue("CUST_NO" ,i);
        	String toSignFile = "S_" + jobYm + houseNo + custNo + ".bmp";
        	fileInformap.put(toSignFile, Constant.SIGN_DIR + File.separator + toSignFile);
		} while (sqlite.moveToNext());
		
	        String zipfilename = Constant.WORK_DIR + File.separator + "up.zip";
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
	        ewireData.setZipfilename( zipfilename );
	        ewireData.setOutputFolder( Constant.WORK_DIR );
	        ChgResultSpec chgResultSpec = new ChgResultSpec();
	        ChgCustSpec   chgCustSpec   = new ChgCustSpec()  ;
	        chgResultSpec.whereClause = "WHERE END_YN = 'Y' AND SEND_YN = 'N'";
	        chgCustSpec.whereClause   = " WHERE                                     "
	                                  + "  EXISTS (                                 "
	                                  + "   SELECT * FROM CHG                       "
	                                  + "   WHERE CHG.END_YN  = 'Y'                  "
	                                  + "   AND   CHG.SEND_YN = 'N'                 "
	                                  + "   AND   CHG.GM_CHG_YM = CHG_CUST.GM_CHG_YM      "
	                                  + "   AND   CHG.HOUSE_NO = CHG_CUST.HOUSE_NO  "
	                                  + "   AND   CHG.CUST_NO = CHG_CUST.CUST_NO    "
	                                  + "  )                                        "
	        ;
	        Object[] databasespecication = {
	                  chgResultSpec
	                , chgCustSpec
	        };
	        ewireData.setDatabaseSpecication(databasespecication);
	
	        if ( fileInformap.size() > 0 ){
	        	ewireData.setAddFiles( fileInformap ); // 추가 파일
	        }
			
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

	public void callTrans() {
	            String yyyyMm = Util.getSysYYYYMM();
	//          String yyyyMm = getValue(R.id.et_yyyy) + getValue(R.id.et_mm);
	            String userid = ((WApplication)mApp).getUserId();
	            String machineId = ((WApplication)mApp).getMachineId();
	            String command = "C";
	            String instruction = "chg_up";
	    //      String param = "DOWN|/DATA/CHG/DN/20141030/DN_CHG_01_144203.ZIP|201411|01";
	//          UP|/DATA/CHG/UP/(YYYYMMDD)/UP_CHG_(기기번호)_hhmmss.ZIP|작업년월|기기번호
	            String param = "UP|/DATA/CHG/UP/"+ Util.getSysYYYYMMDD() +"/UP_CHG_"+machineId+"_"+Util.getSysHHMMSS()+".ZIP|"+ yyyyMm +"|" + machineId;
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
	                                        String sql = "UPDATE " + WConstant.TBL_CHG
	                                                + " SET SEND_YN = '" + Constant.CODE_SEND_Y + "'"
	                                                + " WHERE END_YN = 'Y' AND SEND_YN = 'N'"
	                                        ;
	                                        Sqlite sqlite = new Sqlite(db);
	                                        sqlite.execSql(sql);
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
	                        Toast.makeText(MeterChgMainActivity.this, db.getErrorMessage(), Toast.LENGTH_SHORT).show();
	                    }
	
	                }
	            }.show();
	        }
	    }

	@Override
    public void onClick(View v) {
        int viewID = v.getId();
        switch (viewID) {
        case R.id.btn_gauge: // 교체
            int tot = DUtil.getDataCount(this.getApplicationContext());
            if ( tot == 0 ) {
                alert(R.string.msg_receive_meter_chg_data); // 계량기교체자료를 수신하세요.
            } else {
                Intent i = new Intent(this,BldgListActivity.class); // 건물목록
                startActivity(i);
            }
            break;
        case R.id.btn_send: // 송신
            int sendableCnt = DUtil.getSendableCount(this.getApplicationContext());
            if ( sendableCnt == 0 ) { // 송신가능수
                alert(R.string.msg_send_no_data); // 송신할 자료가 없습니다. 확인바랍니다.
            } else {
                // 계량기교체기간이 지나 송신에 실패한 경우 (제외)
                confirm(R.string.msg_send_confirm // 송신하시겠습니까?
                        , new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int whichButton) {
                                fSend();
                            }
                        }
                        , new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int whichButton) {
                            }
                        }
                );
            }
            break;
        case R.id.btn_receive: // 교체대상 수신
            Intent ii = new Intent(this,ChgTargetRcvActivity.class); // 교체대상 수신
            startActivity(ii);
            break;
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
    	                    WUtil.goMterChg(MeterChgMainActivity.this, bfGmNo);
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
	        		WUtil.goMterChg(MeterChgMainActivity.this, bfGmNo);
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
}
