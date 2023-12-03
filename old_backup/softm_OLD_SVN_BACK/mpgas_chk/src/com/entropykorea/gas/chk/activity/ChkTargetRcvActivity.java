package com.entropykorea.gas.chk.activity;

import java.io.File;
import java.io.IOException;

import org.apache.commons.io.FileUtils;

import android.annotation.SuppressLint;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.text.TextUtils;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.Toast;

import com.dm.zbar.android.scanner.ZBarConstants;
import com.entropykorea.ewire.eWireData;
import com.entropykorea.ewire.eWireTrans;
import com.entropykorea.ewire.eWireUpdate;
import com.entropykorea.gas.chk.R;
import com.entropykorea.gas.chk.WApplication;
import com.entropykorea.gas.chk.common.DUtil;
import com.entropykorea.gas.chk.common.WConstant;
import com.entropykorea.gas.chk.common.WUtil;
import com.entropykorea.gas.chk.spec.AreaCenterSpec;
import com.entropykorea.gas.chk.spec.CodeSpec;
import com.entropykorea.gas.chk.spec.JumBoilerSpec;
import com.entropykorea.gas.chk.spec.JumNocfmDnSpec;
import com.entropykorea.gas.chk.spec.JumNoimpSpec;
import com.entropykorea.gas.chk.spec.JumSpec;
import com.entropykorea.gas.chk.spec.JumVisitDnSpec;
import com.entropykorea.gas.chk.spec.ProviderSpec;
import com.entropykorea.gas.lib.BaseActivity;
import com.entropykorea.gas.lib.Constant;
import com.entropykorea.gas.lib.SpinnerCd;
import com.entropykorea.gas.lib.TitleView;
import com.entropykorea.gas.lib.TitleView.OnTopClickListner;
import com.entropykorea.gas.lib.Util;
import com.mypidion.BI300.BI300Bluetooth;

/**
 * @author softm
 * ChkTargetRcvActivity
 * 점검대상 수신
 */
public class ChkTargetRcvActivity extends BaseActivity implements OnClickListener, OnTopClickListner, OnMenuItemClickListener {
	public static final String TAG = "MPGAS";
	ImageView mImagePicView;
	ImageButton mBtnReceive; 
    private BI300Bluetooth bi300 = null;
    
    private String checkup_cd = ""; 
    SpinnerCd spnCd;
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		checkup_cd = WConstant.CODE_CHECKUP_CD_1;
		if ( !"".equals(checkup_cd) ) {
			setContentView(R.layout.activity_chk_target_rcv);
			init();
			spnCd = ((SpinnerCd)findViewById(R.id.spn_cd)).getCode(WConstant.CODE_CHECKUP_CD);
			spnCd.setValue(checkup_cd);
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
		TitleView tv = new TitleView(this, R.string.title_chk_target_rcv,true);
		tv.setOnTopClickListner(this);
		EditText mEtYYYY = (EditText) findViewById(R.id.et_yyyy);
		mEtYYYY.setText(Util.getSysYYYY());		
		EditText mEtMM = (EditText) findViewById(R.id.et_mm);
		mEtMM.setText(Util.getSysMM());

		mBtnReceive = (ImageButton) findViewById(R.id.ib_receive);
		mBtnReceive.setOnClickListener(this);
		findViewById(R.id.iv_yyyy_up).setOnClickListener(this);
		findViewById(R.id.iv_mm_up  ).setOnClickListener(this);
		findViewById(R.id.iv_yyyy_dn).setOnClickListener(this);
		findViewById(R.id.iv_mm_dn  ).setOnClickListener(this);
	}
	/**
	 * 수신
	 */
	private void fReceive() {
		// 수신처리 전 계량기교체 프로그램이 최신 버전이 아닌 경우 알림
//		 - 메시지 : 버전업그레이드를 한 후에 수신할 수 있습니다. 지금 버전업그레이드를 실행하시겠습니까?
//				 - 확인 : 버전 업그레이드 실행(계량기교체프로그램 종료)
//				 - 취소 : 알림창 닫음
//				 - 버전 업그레이드가 성공하면 수신작업을 바로 진행함
//		callTrans();
		checkVersion();
		
//		startProgressBar();
//		new Thread(new Runnable() {
//			public void run() {
//				try {
//					Thread.sleep(2000);
//				} catch (InterruptedException e) {
//					e.printStackTrace();
//				}
//				// 실제적인 수신성공여부를 통하여 성공여부를 설정해야함.
//				sendMessage(ConstantChg.PROC_ID_RECEIVE_DATA, "1", false, "DAT");
//			}
//		}).start();
	}
	
	// version check & install
	private void checkVersion() {
		
		String updateUrl = var.UPDATE_SERVER_URL;
		String packageName = "mpgas_chk";
		String versionNumber = getString(R.string.app_version);
		
		// test
//		versionNumber = "0.1";
		
		eWireUpdate ewireUpdate = new eWireUpdate( this ) {

			@Override
			public void onFinished(boolean result, String resultMessage) {
				
				if( result ) {
					confirm("안정적인 서비스를 위하여 업데이트 프로그램을 설치합니다", "installApk" );
				} else {
					if( resultMessage.length() > 0 ) {
						// 데이타 다운로드
//						runGumDown();
						callTrans();						
					} else {
						alert("잠시후에 다시 시도하십시요");
					}
				}
			}
			
		};
		
		ewireUpdate.checkVersion( updateUrl, packageName, versionNumber );
		
	}
	
	private void installApk() {
		String updateUrl = var.UPDATE_SERVER_URL;
		String packageName = "mpgas_chk";
		//String versionNumber = context.getString(R.string.app_version);
//		String downloadPath = Constants.main_path;
		String downloadPath = Constant.WORK_DIR;
		
		eWireUpdate ewireUpdate = new eWireUpdate( this ) {

			@Override
			public void onFinished(boolean result, String resultMessage) {
				
				if( result ) {
					this.installApk(resultMessage);
					//finish();
					//System.exit(0);
				} else {
					alert( "내려받기 실패입니다. 잠시후에 다시 시도하십시요." );
				}
				
			}
		};
		
		ewireUpdate.downloadApk(updateUrl, packageName, downloadPath);
	}
	private void callTrans() {
//			String yyyyMm = Util.getSysYYYYMM();
		String yyyyMm = getValue(R.id.et_yyyy) + getValue(R.id.et_mm);
		String userid = ((WApplication)mApp).getUserId();
		String machineId = ((WApplication)mApp).getMachineId();
		String command = "C";
		String instruction = "jum_down";
//		String param = "DOWN|/DATA/CHG/DN/20141030/DN_CHG_01_144203.ZIP|201411|01";
//			DOWN|/DATA/JUM/DN/(YYYYMMDD)/DN_JUM_(기기번호)_hhmmss.ZIP|작업년월|점검구분|기기번호 
		String param = "DOWN|/DATA/JUM/DN/"+ Util.getSysYYYYMMDD() +"/DN_JUM_" + machineId + "_"+ Util.getSysHHMMSS() + ".ZIP|"+ yyyyMm +"|" + checkup_cd+"|" + machineId;
		String zipfilename = Constant.WORK_DIR + File.separator + "down.zip";			
		eWireTrans ewireTrans; 
		// eWire
		ewireTrans = new eWireTrans( this ){
			@Override
			public void onFinished(boolean result, String resultMessage) {
				if( result ) {
//						Toast.makeText(ChkTargetRcvActivity.this, resultMessage, Toast.LENGTH_SHORT).show();
					callImport();
				} else {
					Toast.makeText(ChkTargetRcvActivity.this, resultMessage, Toast.LENGTH_SHORT).show();
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
		ewireTrans.setShowError(false);
		ewireTrans.setSoundPlay(false);
		ewireTrans.setDelayTime(1000);
		
		// eWire Thread
		ewireTrans.excuteTrans();
	}

	private void callImport() {
		
		String zipfilename = Constant.WORK_DIR + File.separator + "down.zip";
		String path = Constant.WORK_DIR;
//		createTable();
		
		// create directory
		try {
			File f = new File( path );
			if( !f.isDirectory() )
				f.mkdirs();
		} catch (Exception e) {
			e.printStackTrace();
			return;
		}		
		
		// set ewiredata
		eWireData ewireData = new eWireData( this ) {
			@Override
			public void onFinished(boolean result, String resultMessage) {
				if( result ) {
					alert(R.string.msg_receive_complete  // 수신이 완료되었습니다.
							, new DialogInterface.OnClickListener() {
							public void onClick(DialogInterface dialog, int whichButton) {
								finish();								
							}
							}
					);
//						Toast.makeText(ChkTargetRcvActivity.this, resultMessage, Toast.LENGTH_SHORT).show();
				} else {
					File f = new File(WConstant.WORK_DIR + File.separator + System.currentTimeMillis() + ".txt");
			        try {
						FileUtils.write(f,resultMessage);
					} catch (IOException e) {
						e.printStackTrace();
					}
			        
					confirm(R.string.msg_receive_fail_confirm  // 수신이 실패하였습니다. 다시 시도하시겠습니까
					, new DialogInterface.OnClickListener() {
						public void onClick(DialogInterface dialog, int whichButton) {
							fReceive();								
						}
					}
					, new DialogInterface.OnClickListener() {
						public void onClick(DialogInterface dialog, int whichButton) {
						}
					}
					);
//						Toast.makeText(ChkTargetRcvActivity.this, resultMessage, Toast.LENGTH_SHORT).show();
				}
			}

			@Override
			public void preExcute() {
//		    	db.rawQuery("PRAGMA journal_mode = MEMORY",null);				
//		    	db.rawQuery("PRAGMA count_change = OFF",null);				
//		    	db.rawQuery("PRAGMA cache_size = 10000",null);
				int tot = DUtil.getDataCount(getApplicationContext(),spnCd.getValue());
				if ( tot > 0 ) { 
					if ( !DUtil.deleteData(getApplicationContext(),spnCd.getValue()) ) {
						toast(R.string.msg_db_error); // 저장중 오류가 발생하였습니다.
					}
				}
			}

			@Override
			public void postExcute() {
				
			}
			
		};

//    	db.execSQL("PRAGMA locking_mode=EXCLUSIVE;");
//		db.execSQL( "PRAGMA synchornous = OFF" );
//		db.execSQL( "PRAGMA auto_vacuum = 0" );		
		ewireData.setDatabase( db );
		ewireData.setZipfilename( zipfilename );
		ewireData.setDeleteAfterImport(false);
		ewireData.setOutputFolder( path );
		
		Object[] databasespecication = {
				 new CodeSpec()
				,new ProviderSpec()
				,new AreaCenterSpec()
				,new JumSpec()
				,new JumNoimpSpec()
				,new JumVisitDnSpec()
				,new JumNocfmDnSpec()
				,new JumBoilerSpec()						 
		};
		ewireData.setDatabaseSpecication(databasespecication);
		
		// option
		//ewireData.setDialogType(eWireData.DIALOGTYPE_NONE);
		ewireData.setDialogType(eWireData.DIALOGTYPE_PROGRESS);
		ewireData.setDisplayMessage(eWireData.DEFAULT_DISPLAYMESSAGE);
		ewireData.setShowError(false);
		ewireData.setSoundPlay(true);
		
		ewireData.setDelayTime(1000);

		// onFinished callback
//		ewireData.setOnFinished(new eWireData.onFinished() {
//			@Override
//			public void onFinished(boolean result, String resultMessage) {
//				if( result ) {
//					Toast.makeText(MainActivity.this, resultMessage, Toast.LENGTH_SHORT).show();
//				} else {
//					Toast.makeText(MainActivity.this, resultMessage, Toast.LENGTH_SHORT).show();
//				}
//			}
//		});
		
		// do thread
		ewireData.excuteImport();
		
	}

	@Override
	public void onClick(View v) {
		int viewID = v.getId();
//		int sysYyyy = Integer.parseInt(Util.getSysYYYY(),10);
		int yyyy    = Integer.parseInt(getValue(R.id.et_yyyy),10);
		int mm    = Integer.parseInt(getValue(R.id.et_mm),10);
		switch (viewID) {
		case R.id.iv_yyyy_up:
//			if ( sysYyyy > yyyy) {
				yyyy++;
				setText(R.id.et_yyyy, String.format("%04d", yyyy));
//			}
			break;			
		case R.id.iv_yyyy_dn:
			if ( 1 < yyyy) {
				yyyy--;
				setText(R.id.et_yyyy, String.format("%04d", yyyy));
			}
			break;			
		case R.id.iv_mm_up:
			if ( mm < 12) {
				mm++;
				setText(R.id.et_mm, String.format("%02d", mm));
			} else {
				getView(R.id.iv_yyyy_up).performClick();
				if ( yyyy != Integer.parseInt(getValue(R.id.et_yyyy),10) ) {
					setText(R.id.et_mm, "01");					
				}
			}
			break;					
		case R.id.iv_mm_dn:
			if ( 1 < mm ) {
				mm--;
				setText(R.id.et_mm, String.format("%02d", mm));
			} else {
				getView(R.id.iv_yyyy_dn).performClick();
				if ( yyyy != Integer.parseInt(getValue(R.id.et_yyyy),10) ) {
					setText(R.id.et_mm, "12");					
				}
			}
			break;
		case R.id.ib_receive: // 수신
			int tot = DUtil.getDataCount(this.getApplicationContext(),spnCd.getValue());
			confirm(tot > 0?R.string.msg_bf_meter_chk_data_delete_confirm // 기존 점검자료는 삭제됩니다. 점검자료를 수신하시겠습니까?
					       :R.string.msg_chk_data_receive_confirm // 점검자료를 수신하시겠습니까?
					, new DialogInterface.OnClickListener() {
						public void onClick(DialogInterface dialog, int whichButton) {
								fReceive();
						}
					}
					, new DialogInterface.OnClickListener() {
						public void onClick(DialogInterface dialog, int whichButton) {
						}
					}
			);
			break;
		}
	}

	@Override
	public void onBackPressed() {
		finish();		
//		confirm(R.string.msg_finish_confirm
//				, new DialogInterface.OnClickListener() {
//					public void onClick(DialogInterface dialog, int whichButton) {
//                    	finish();
//					}
//				}
//				, new DialogInterface.OnClickListener() {
//					public void onClick(DialogInterface dialog, int whichButton) {
////						alert("취소");						
//					}
//				}
//		);
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
    @SuppressLint("HandlerLeak")
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
    	                    WUtil.goHouseInf(ChkTargetRcvActivity.this, bfGmNo);
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
    
    @Override
    protected void onPause() {
    	super.onPause();
    	if ( bi300 != null ) {
    		bi300.stopBI300();
    	}
    }

	@Override
		protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		    switch (requestCode) {
		        case Constant.ZBAR_SCANNER_REQUEST:
		        	if (resultCode == RESULT_OK) {
		        		String bfGmNo = WUtil.toDefault(data.getStringExtra(ZBarConstants.SCAN_RESULT));
	//	                Toast.makeText(this, "Scan Result = " + data.getStringExtra(ZBarConstants.SCAN_RESULT), Toast.LENGTH_SHORT).show();
		        		WUtil.goHouseInf(ChkTargetRcvActivity.this, bfGmNo);                    
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
}
