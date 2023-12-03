package com.entropykorea.gas.lib.activity;

import java.io.File;
import java.io.IOException;

import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.ActivityInfo;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.media.ExifInterface;
import android.net.Uri;
import android.os.Bundle;
import android.provider.MediaStore;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.Window;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.Toast;

import com.dm.zbar.android.scanner.ZBarConstants;
import com.entropykorea.gas.lib.BaseActivity;
import com.entropykorea.gas.lib.Constant;
import com.entropykorea.gas.lib.DefaultApplication;
import com.entropykorea.gas.lib.ListViewMP;
import com.entropykorea.gas.lib.R;
import com.entropykorea.gas.lib.SpinnerCd;
import com.entropykorea.gas.lib.TitleView;
import com.entropykorea.gas.lib.TitleView.OnTopClickListner;
import com.entropykorea.gas.lib.Util;
import com.entropykorea.gas.lib.adapter.SampleAdapter;

/**
 * @author softm
 * SampleActivity
 */
public class SampleActivity extends BaseActivity implements OnClickListener, OnTopClickListner {
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
	    if ( current != ActivityInfo.SCREEN_ORIENTATION_PORTRAIT ) {
	        setRequestedOrientation( ActivityInfo.SCREEN_ORIENTATION_PORTRAIT );
	    }
		requestWindowFeature(Window.FEATURE_NO_TITLE);
		setContentView(R.layout.activity_sample);		
		init();
        SpinnerCd spnCd = (SpinnerCd)findViewById(R.id.spn_cd);					
        spnCd.getCode("BC047");					
		list();
	}
	
	private void init() {
		TitleView tv = new TitleView(this, R.string.title_sample,true,true);
		tv.setOnTopClickListner(this);
		mFileName = mFileNamePrefix + mFileNameSuffix;
		mBtnCamera = (ImageButton) findViewById(R.id.btn_camera);
		mBtnCamera.setOnClickListener(this);
		mBtnPicLoad = (Button) findViewById(R.id.btn_pic_load);
		mBtnPicLoad.setOnClickListener(this);
		mBtnPicDel = (Button) findViewById(R.id.btn_pic_del);
		mBtnPicDel.setOnClickListener(this);
		mImagePicView = (ImageView) findViewById(R.id.img_pic);
		mImagePicView.setOnClickListener(this);
		mBtnSpnSelected= (Button) findViewById(R.id.btn_spn_selected);
		mBtnSpnSelected.setOnClickListener(this);
		setPic();		
	}
	
	@Override
	public void onClick(View v) {
		int viewID = v.getId();
		if ( viewID == R.id.btn_spn_selected ) {
	        SpinnerCd spnCd = (SpinnerCd)findViewById(R.id.spn_cd);	  				
	        alert(spnCd.getSelectedValue().getCd() + " / " + spnCd.getSelectedValue().getCdNm() + " / 갯수 : "  + spnCd.getCount());
		} else if ( viewID == R.id.img_pic ) {
			Intent intentPic = new Intent(SampleActivity.this, PicViewerActivity.class);
			intentPic.putExtra("fileName", mFileName );
			startActivityForResult(intentPic, Constant.PROC_ID_PIC_VIWER); 
		} else if ( viewID == R.id.btn_pic_load ) {
			setPic();
		} else if ( viewID == R.id.btn_pic_del ) {			
			Util.deleteFilesWithExtension(Constant.PIC_DIR, "jpg");				
		} else if ( viewID == R.id.btn_camera ) {
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
			Log.d(TAG, "1 : " + mTmpImgPath);
            Uri outputFileUri = Uri.fromFile(image);
            intent.putExtra( MediaStore.EXTRA_OUTPUT, outputFileUri );
	        startActivityForResult(intent, Constant.PROC_ID_TAKE_CAMERA);
//            startActivityFromChild(getParent(), intent, Constant.PROC_ID_TAKE_CAMERA);
		}
	}

	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		if ( requestCode == Constant.PROC_ID_TAKE_CAMERA ) {	    
        	try {
        		Log.d(TAG, "2 : " + mTmpImgPath + " / " + resultCode);						
        		if ( resultCode != 0 ) {
    				Util.deleteFilesWithExtension(Constant.PIC_DIR, "jpg");	            		
            		Util.forceRename(new File(mTmpImgPath),new File(Constant.PIC_DIR + File.separator + mFileName));
        		}
        		setPic();
        	} catch (IOException e) {
        		e.printStackTrace();
        	} 
		} else if ( requestCode == Constant.PROC_ID_PIC_VIWER ) {
        	boolean rtn = data.getBooleanExtra("FILE_DELETED",false);
        	Log.d(TAG,"rtn : " + rtn);
        	if ( rtn ) {
				setPic();
        	}
		} else if ( requestCode == Constant.ZBAR_SCANNER_REQUEST ) {
		} else if ( requestCode == Constant.ZBAR_QR_SCANNER_REQUEST ) {			
            if (resultCode == RESULT_OK) {
                Toast.makeText(this, "Scan Result = " + data.getStringExtra(ZBarConstants.SCAN_RESULT), Toast.LENGTH_SHORT).show();
            } else if(resultCode == RESULT_CANCELED && data != null) {
                String error = data.getStringExtra(ZBarConstants.ERROR_INFO);
                if(!TextUtils.isEmpty(error)) {
                    Toast.makeText(this, error, Toast.LENGTH_SHORT).show();
                }
            }
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
		ListViewMP lv1 = (ListViewMP)findViewById(R.id.listView1);
		Cursor c = db.rawQuery("SELECT _rowid_ as _id, CD,CD_NM FROM CODE "
		        + " WHERE TYPE_CD = 'BC047'", null);
		SampleAdapter adapter = new SampleAdapter(getApplicationContext(), c, 0);    					
		lv1.setAdapter(adapter);					
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
