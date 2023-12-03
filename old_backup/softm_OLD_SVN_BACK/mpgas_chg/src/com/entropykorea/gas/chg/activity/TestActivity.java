package com.entropykorea.gas.chg.activity;

import java.io.File;
import java.io.IOException;
import android.annotation.SuppressLint;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.ActivityInfo;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteException;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.media.ExifInterface;
import android.net.Uri;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.provider.MediaStore;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.view.Window;
import android.widget.Button;
import android.widget.CursorAdapter;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;
import com.dm.zbar.android.scanner.ZBarConstants;
import com.entropykorea.gas.chg.R;
import com.entropykorea.gas.chg.adapter.TestAdapter;
import com.entropykorea.gas.chg.common.DUtil;
import com.entropykorea.gas.chg.common.WUtil;
import com.entropykorea.gas.lib.BaseActivity;
import com.entropykorea.gas.lib.Constant;
import com.entropykorea.gas.lib.DBHelper;
import com.entropykorea.gas.lib.ListViewMP;
import com.entropykorea.gas.lib.SpinnerCd;
import com.entropykorea.gas.lib.TitleView;
import com.entropykorea.gas.lib.TitleView.OnTopClickListner;
import com.entropykorea.gas.lib.Util;
import com.entropykorea.gas.lib.activity.PicViewerActivity;

/**
 * @author softm
 * TestActivity
 */
public class TestActivity extends BaseActivity implements OnClickListener, OnTopClickListner {
	public static final String TAG = "MPGAS";
	ImageView mImagePicView;
	Button mBtn1;
	ImageButton mBtnCamera; 
	Button mBtnPicLoad;
	Button mBtnPicDel;
	Button mBtnDBDrop;
	Button mBtnSpnSelected;
	String mFileName       = null  ;
	final String mFileNamePrefix = "TEST";
	final String mFileNameSuffix = ".jpg";
	private String mTmpImgPath = null;
	
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_PORTRAIT);
	    int current = getRequestedOrientation();
	    // only switch the orientation if not in portrait
	    if ( current != ActivityInfo.SCREEN_ORIENTATION_PORTRAIT ) {
	        setRequestedOrientation( ActivityInfo.SCREEN_ORIENTATION_PORTRAIT );
	    }
		requestWindowFeature(Window.FEATURE_NO_TITLE);
		setContentView(R.layout.activity_test_main);		
		init();
		setPic();
		list();
	}
	
	private void init() {
		TitleView tv = new TitleView(this, R.string.title_test,true,true);
		tv.setOnTopClickListner(this);
		mFileName = mFileNamePrefix + mFileNameSuffix;
		mBtn1 = (Button) findViewById(R.id.button1);
		mBtn1.setOnClickListener(this);
		mBtnCamera = (ImageButton) findViewById(R.id.btn_camera);
		mBtnCamera.setOnClickListener(this);
		mBtnPicLoad = (Button) findViewById(R.id.btn_pic_load);
		mBtnPicLoad.setOnClickListener(this);
		mBtnPicDel = (Button) findViewById(R.id.btn_pic_del);
		mBtnPicDel.setOnClickListener(this);
		
		mBtnDBDrop = (Button) findViewById(R.id.btn_db_drop);
		mBtnDBDrop.setOnClickListener(this);
		mImagePicView = (ImageView) findViewById(R.id.img_pic);
		mImagePicView.setOnClickListener(this);
		
		mBtnSpnSelected= (Button) findViewById(R.id.btn_spn_selected);
		mBtnSpnSelected.setOnClickListener(this);
		
		startProgressBar();
		db = mApp.getDatabase();
        Spinner spnCd1 = (Spinner)findViewById(R.id.spn_cd1);
        Cursor c = db.rawQuery("Select _rowid_ as _id, * " +
                "From CODE " +
                "" , null);       		
        c.moveToFirst();
        CursorAdapter adapter1 = new CursorAdapter(getApplicationContext(), c) {
			@Override
			public View newView(Context context, Cursor cursor, ViewGroup parent) {
				LayoutInflater inflater = LayoutInflater.from(context);
				View view = null; 					
				if ( view == null ) { 
					view = inflater.inflate(android.R.layout.simple_list_item_1, parent, false);
				}
				return view;
			}

			@Override
			public void bindView(View view, Context context, Cursor cursor) {
				TextView txtmean = (TextView) view.findViewById(android.R.id.text1);
				txtmean.setText(cursor.getString(0));
			}

//			@Override
//			public View getDropDownView(int position, View convertView,
//					ViewGroup parent) {
//		        TextView text = new TextView(getApplicationContext());
//		        text.setTextColor(Color.BLACK);
//		        text.setText(cursor.getString(0));
//		        return text;
//			}
		};   
        spnCd1.setAdapter(adapter1); //�대뙌���깅줉			
		new Thread(new Runnable() {
			public void run() {
 
//			        while (c.moveToNext()) {
//			            String typeCd = c.getString(c.getColumnIndex("TYPE_CD"));
//			            String cd     = c.getString(c.getColumnIndex("CD"     ));
//			            String cdNm   = c.getString(c.getColumnIndex("CD_NM"  ));
//			            Log.i(TAG, "typeCd: " + typeCd + ", cd : " + cd + ", cdNm : " + cdNm);
//			       }
		        SpinnerCd spnCd2 = (SpinnerCd)findViewById(R.id.spn_cd2);					
		        spnCd2.getCode("11");						
				sendMessage(Constant.PROC_ID_LOAD_COMMON_CODE, "1", true, "USER_DATA");
			}
		}).start();		
	}
	
	@SuppressLint("NewApi")
	@Override
	public void onClick(View v) {
		if ( v == mBtn1 ) {
			startProgressBar();
			new Thread(new Runnable() {
				public void run() {
					try {
						Thread.sleep(2000);
					} catch (InterruptedException e) {
						e.printStackTrace();
					}					
					sendMessage(Constant.PROC_ID_TEST, "1", true, "DAT");
				}
			}).start();
		} else {
			int viewID = v.getId();
			switch (viewID) {
			case R.id.btn_spn_selected:
		        SpinnerCd spnCd2 = (SpinnerCd)findViewById(R.id.spn_cd2);	  				
		        alert(spnCd2.getSelectedValue().getCd() + " / " + spnCd2.getSelectedValue().getCdNm() + " / "  + spnCd2.getCount());
				break;
			case R.id.btn_db_drop:
				SQLiteDatabase.deleteDatabase(new File(DBHelper.DBPath + DBHelper.DBName));
				alert("삭제되었습니다.");
				break;
			case R.id.img_pic:
				Intent intentPic = new Intent(TestActivity.this, PicViewerActivity.class);
				intentPic.putExtra("fileName", mFileName );
				startActivityForResult(intentPic, Constant.PROC_ID_PIC_VIWER); 
				break;
			case R.id.btn_pic_load:
				setPic();
				break;
			case R.id.btn_pic_del:
				Util.deleteFilesWithExtension(Constant.PIC_DIR, "jpg");				
				break;
			case R.id.btn_camera:
				Util.createWorkDir();
				Intent intent = new Intent();
	            File imgDir = new File(Constant.PIC_DIR); // directory
	            intent.setAction(MediaStore.ACTION_IMAGE_CAPTURE);
	            intent.putExtra(MediaStore.EXTRA_SCREEN_ORIENTATION, ActivityInfo.SCREEN_ORIENTATION_PORTRAIT); 
	            
	            File image = null;
				try {
					image = File.createTempFile(
							mFileNameSuffix,			// prefix
							mFileNamePrefix,		// suffix
							imgDir
					);
				} catch (IOException e) {
					e.printStackTrace();
				}
				mTmpImgPath = image.getAbsolutePath();
				Util.d(TAG, "1 : " + mTmpImgPath);
	            Uri outputFileUri = Uri.fromFile(image);
	            intent.putExtra( MediaStore.EXTRA_OUTPUT, outputFileUri );
//	            startActivityForResult(intent, Constant.PROC_TAKE_CAMERA);
	            startActivityFromChild(getParent(), intent, Constant.PROC_ID_TAKE_CAMERA);
				break;
			}
		}
	}

	private void sendMessage(int procId, String procCode, boolean successChk, String dataString) {
		int what = 1;
		Message msg = handler.obtainMessage(successChk?what:what,dataString);
		Bundle bundle = new Bundle() ;
		bundle.putInt   ("proc_id"  , procId  );
		bundle.putString("proc_code", procCode);
		msg.setData(bundle);
		handler.sendMessage(msg);
	}
	
	final Handler handler = new Handler() {
		public void handleMessage(Message msg) {
			int procId      = msg.getData().getInt("proc_id") ;
			String procCode = msg.getData().getString("proc_code") ;
			int successChk = msg.what;
			String dataString = (String)msg.obj;
			Util.d(LOG_TAG,"BaseActivity handler message" + "[" + procId + " / " + procCode + " / " + successChk + "] dataString:" + dataString) ;
//			httpResult(proc_type, proc_code, successChk, dataString);
			stopProgressBar();			
		}
	} ;
	

	private SQLiteDatabase db;
	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
	    switch (requestCode) {
	        case Constant.PROC_ID_TAKE_CAMERA:
	        	try {
	        		Util.d(TAG, "2 : " + mTmpImgPath + " / " + resultCode);						
	        		if ( resultCode != 0 ) {
	    				Util.deleteFilesWithExtension(Constant.PIC_DIR, "jpg");	            		
	            		Util.forceRename(new File(mTmpImgPath),new File(Constant.PIC_DIR + File.separator + mFileName));
	        		}
	        		setPic();
	        	} catch (IOException e) {
	        		e.printStackTrace();
	        	} 
	        	break;
	        case Constant.PROC_ID_PIC_VIWER:
	        	boolean rtn = data.getBooleanExtra("FILE_DELETED",false);
	        	Util.d(TAG,"rtn : " + rtn);
	        	if ( rtn ) {
					setPic();
	        	}
	        	break;
	        case Constant.ZBAR_SCANNER_REQUEST:
	        case Constant.ZBAR_QR_SCANNER_REQUEST:
                if (resultCode == RESULT_OK) {
	                String bfGmNo = WUtil.toDefault(data.getStringExtra(ZBarConstants.SCAN_RESULT));
	                if (bfGmNo.length() != 12) {
	                    alert(R.string.msg_invalid_barcode);
	                } else {
            			String houseNo = DUtil.getHouseNoByBfGmNo(this.getApplicationContext(),bfGmNo);
            			if ( "".equals(houseNo)) {
            				alert(R.string.msg_invalid_house); // 인식된 세대가 없습니다.\n확인 바랍니다.
	                    } else {
                            Intent sIntent = new Intent(this,MeterChgActivity.class); // 계량기교체
                            sIntent.putExtra("bf_gm_no", bfGmNo);
                            startActivity(sIntent);
                        }
                    }
    //	                Toast.makeText(this, "Scan Result = " + data.getStringExtra(ZBarConstants.SCAN_RESULT), Toast.LENGTH_SHORT).show();
                } else if(resultCode == RESULT_CANCELED && data != null) {
                    String error = data.getStringExtra(ZBarConstants.ERROR_INFO);
                    if(!TextUtils.isEmpty(error)) {
                        Toast.makeText(this, error, Toast.LENGTH_SHORT).show();
                    }
                }
	            break;
	    }
	}

	private void setPic(){
		int targetW = mImagePicView.getWidth(); // ImageView 의 가로 사이즈 구하기
		int targetH = mImagePicView.getHeight(); // ImageView 의 세로 사이즈 구하기
		if ( targetW == 0 ) targetW = 70;
		if ( targetH == 0 ) targetH = 70;
		
		// Bitmap 정보를 가져온다.
		BitmapFactory.Options bmOptions = new BitmapFactory.Options(); 
		bmOptions.inJustDecodeBounds = true;
		BitmapFactory.decodeFile( Constant.PIC_DIR + File.separator + mFileName, bmOptions);
		int photoW = bmOptions.outWidth; // 사진의 가로 사이즈 구하기
		int photoH = bmOptions.outHeight; // 사진의 세로 사이즈 구하기
	
		// 사진을 줄이기 위한 비율 구하기
		int scaleFactor = Math.min( photoW/targetW, photoH/targetH);
		bmOptions.inJustDecodeBounds = false;
		bmOptions.inSampleSize = scaleFactor;
		bmOptions.inPurgeable = true;
		ExifInterface exif = null;
		try {
			exif = new ExifInterface(Constant.PIC_DIR + File.separator + mFileName);
		} catch (IOException e) {
			e.printStackTrace();
		}
		int exifOrientation = exif.getAttributeInt(ExifInterface.TAG_ORIENTATION, ExifInterface.ORIENTATION_NORMAL);
		int exofDegree = Util.exifOrientationToDegrees(exifOrientation);
		Bitmap bitmap = BitmapFactory.decodeFile( Constant.PIC_DIR + File.separator + mFileName, bmOptions);
		bitmap = Util.rotate(bitmap, exofDegree);
		mImagePicView.setImageBitmap( bitmap);
	}

	private void list() {
		try {
			startProgressBar();			
    		new Thread(new Runnable() {
    			public void run() {
    				ListViewMP lv1 = (ListViewMP)findViewById(R.id.listView1);
					Cursor c = db.rawQuery("SELECT _rowid_ as _id, CD,CD_NM FROM code "
					        + " WHERE TYPE_CD = '11'", null);
					TestAdapter adapter = new TestAdapter(getApplicationContext(), c, 0);    					
					lv1.setAdapter(adapter);					
    				sendMessage(Constant.PROC_ID_SELECT_SQLITE, "1", true, "USER_DATA");
    			}
    		}).start();	
    		
		} catch (SQLiteException se ) {
	    	Log.e(getClass().getSimpleName(), se.toString());
	    } finally {
	    }
	}

	@Override
	public void onBackPressed() {
		confirm(R.string.msg_finish_confirm
				, new DialogInterface.OnClickListener() {
					public void onClick(DialogInterface dialog, int whichButton) {
                    	finish();
					}
				}
				, new DialogInterface.OnClickListener() {
					public void onClick(DialogInterface dialog, int whichButton) {
//						showAlert("취소");						
					}
				}
		);
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
	 * Top상단 두번째 버튼 클릭
	 */
    @Override
    public void onClickTwoButton(View v) {
    	alert("onClickTwoButton");
    }
    
	/**
	 * Top상단 첫번째 버튼 클릭
	 */
    @Override
    public void onClickOneButton(View v) {
		launchScanner(v);    	
    }	
    
//	@Override
//	public boolean onKeyDown(int keyCode, KeyEvent event) {
//		if ((keyCode == KeyEvent.KEYCODE_BACK) && mWebView.canGoBack()) {
////			mWebView.goBack();
//			return true;
//		}
//		return super.onKeyDown(keyCode, event);
//	}
//	
//	@Override
//	public void onConfigurationChanged(Configuration newConfig) {
//		super.onConfigurationChanged(newConfig);
//	}
    
}
