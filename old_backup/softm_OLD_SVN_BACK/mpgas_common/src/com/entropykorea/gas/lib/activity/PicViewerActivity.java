package com.entropykorea.gas.lib.activity;

import java.io.File;
import java.io.IOException;

import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.media.ExifInterface;
import android.os.Bundle;
import android.view.MotionEvent;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.animation.AnimationUtils;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ViewFlipper;

import com.entropykorea.gas.lib.BaseActivity;
import com.entropykorea.gas.lib.Constant;
import com.entropykorea.gas.lib.PicCamera;
import com.entropykorea.gas.lib.R;
import com.entropykorea.gas.lib.TitleView.OnTopClickListner;
import com.entropykorea.gas.lib.Util;

/**
 * @author softm
 * PicViewerActivity
 */
public class PicViewerActivity extends BaseActivity implements OnClickListener , OnTopClickListner {
	public static final String TAG = "PV_MPGAS";
	ImageView mImagePicViewer;
	Button mBtnPicDel;
    private String mode = null  ;
    private String imgRoot = null;
    private String prefix = null;
    private String suffix = null;
    private boolean delAble = true;
	private boolean mStatDel = false;
	private String mDelFileName = "";
	private ViewFlipper m_viewFlipper;
	
	private int m_nPreTouchPosX = 0;
	
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_pic_viewer);		
		findViewById(R.id.btn_pic_del).setOnClickListener(this);
		init();
        m_viewFlipper = (ViewFlipper)findViewById(R.id.viewFlipper);
        m_viewFlipper.setOnTouchListener(MyTouchListener);
		File dir = new File(imgRoot);
		Util.i(TAG,imgRoot);
		
		final String[] allFiles = dir.list();
		for (final String file : allFiles) {
			Util.i("test",mode + "_" + prefix);
			if (file.startsWith(mode + "_" + prefix )) {
				Util.i("test",imgRoot + File.separator + file);
				ImageView iv = setPic(imgRoot + File.separator + file);
				iv.setTag(file);
		        m_viewFlipper.addView(iv);
			}
		}
	}

	private void init() {
		Intent intent = getIntent();
		Bundle bundle = intent.getExtras();
		if ( bundle != null ) {
			imgRoot = bundle.getString("imgRoot")!=null?bundle.getString("imgRoot"):null;
			mode = bundle.getString("mode")!=null?bundle.getString("mode"):null;
			prefix = bundle.getString("prefix")!=null?bundle.getString("prefix"):null;
			suffix = bundle.getString("suffix")!=null?bundle.getString("suffix"):null;
			delAble = bundle.getBoolean("delAble",true); // default true
		}
		
		if ( !delAble ) {
			setVisibility(R.id.btn_pic_del, View.INVISIBLE);
		}
	}

	@Override
	public void onClick(View v) {
		int viewID = v.getId();
		if ( R.id.btn_pic_del == viewID ) {
			confirm(R.string.msg_del_confirm
					, new DialogInterface.OnClickListener() {
						public void onClick(DialogInterface dialog, int whichButton) {
							String fileName = m_viewFlipper.getCurrentView().getTag().toString();
	                    	Util.deleteFilesWithExtension(imgRoot,fileName);
	                    	mStatDel = true;
	                    	mDelFileName = fileName;
	                    	PicCamera pc = new PicCamera(PicViewerActivity.this, imgRoot,mode,prefix,suffix);
	                    	if ( pc.fileCount() == 0 ) {
	                    		onBackPressed();
	                    	} else {
	                    		m_viewFlipper.removeView(m_viewFlipper.getCurrentView());
	                    	}
						}
					}
					, new DialogInterface.OnClickListener() {
						public void onClick(DialogInterface dialog, int whichButton) {
//							showAlert("취소");						
						}
					}
				);
		}
	}

	private ImageView setPic(String fileName){
        ImageView iv = new ImageView(this);
//		int targetW = mImagePicViewer.getWidth(); // ImageView 의 가로 사이즈 구하기
//		int targetH = mImagePicViewer.getHeight(); // ImageView 의 세로 사이즈 구하기
//		if ( targetW == 0 ) targetW = 70;
//		if ( targetH == 0 ) targetH = 70;
        // ImageView 객체 생성
        iv.setAdjustViewBounds(true);
        iv.setLayoutParams(new LinearLayout.LayoutParams(LinearLayout.LayoutParams.MATCH_PARENT, LinearLayout.LayoutParams.MATCH_PARENT));
        iv.setScaleType(ImageView.ScaleType.FIT_XY); // 레이아웃 크기에 이미지를 맞춘다
//        
//		RelativeLayout.LayoutParams params = (RelativeLayout.LayoutParams)imgBtnTop1.getLayoutParams();
//		params.addRule(RelativeLayout.CENTER_IN_PARENT);
//		params.addRule(RelativeLayout.ALIGN_PARENT_RIGHT);
//		params.addRule(RelativeLayout.LEFT_OF, R.id.btn_top2);

		
		// Bitmap 정보를 가져온다.
		BitmapFactory.Options bmOptions = new BitmapFactory.Options(); 
//		bmOptions.inJustDecodeBounds = true;
//		BitmapFactory.decodeFile( Constant.PIC_DIR + File.separator + mFileName, bmOptions);
//		int photoW = bmOptions.outWidth; // 사진의 가로 사이즈 구하기
//		int photoH = bmOptions.outHeight; // 사진의 세로 사이즈 구하기
//
//		// 사진을 줄이기 위한 비율 구하기
//		int scaleFactor = Math.min( photoW/targetW, photoH/targetH);
//		bmOptions.inJustDecodeBounds = false;
//		bmOptions.inSampleSize = scaleFactor;
//		bmOptions.inPurgeable = true;
//		
		ExifInterface exif = null;
		try {
			exif = new ExifInterface(fileName);
		} catch (IOException e) {
			e.printStackTrace();
		}
		Util.i("test","fileName : " + fileName);
		
		int exifOrientation = exif.getAttributeInt(ExifInterface.TAG_ORIENTATION, ExifInterface.ORIENTATION_NORMAL);
		int exofDegree = Util.exifOrientationToDegrees(exifOrientation);
		Bitmap bitmap = BitmapFactory.decodeFile(fileName, bmOptions);
		bitmap = Util.rotate(bitmap, exofDegree);
		iv.setImageBitmap( bitmap);
		return iv;
	}

	@Override
	public void onBackPressed() {
		Intent intent = new Intent();
		intent.putExtra("FILE_DELETED", mStatDel);
		intent.putExtra("FILE_DELETED_NAME", mDelFileName);
		this.setResult(Constant.PROC_ID_PIC_VIWER, intent);
		finish();		
	}    

    @Override
    public void onClickBackButton(View v) {
//		finish();
    }

	/**
	 * Top상단 두번째 버튼 클릭
	 */
    @Override
    public void onClickTwoButton(View v) {
    }

	/**
	 * Top상단 첫번째 버튼 클릭
	 */
    @Override
    public void onClickOneButton(View v) {
    }
    
    private void MoveNextView()
    {
    	if( m_viewFlipper.getChildCount() > 1 ) { 
	    	m_viewFlipper.setInAnimation(AnimationUtils.loadAnimation(this,	R.anim.appear_from_right));
			m_viewFlipper.setOutAnimation(AnimationUtils.loadAnimation(this, R.anim.disappear_to_left));
			m_viewFlipper.showNext();
//		setText(R.id.tv_infor, ""+m_viewFlipper.getCurrentView().getTag().toString());
    	}
    }
    
    private void MovewPreviousView()
    {
    	if( m_viewFlipper.getChildCount() > 1 ) {    	
	    	m_viewFlipper.setInAnimation(AnimationUtils.loadAnimation(this,	R.anim.appear_from_left));
			m_viewFlipper.setOutAnimation(AnimationUtils.loadAnimation(this, R.anim.disappear_to_right));
	    	m_viewFlipper.showPrevious();
	//		setText(R.id.tv_infor, ""+m_viewFlipper.getCurrentView().getTag().toString());
    	}
    }
    
    View.OnTouchListener MyTouchListener = new View.OnTouchListener()
    {
    	public boolean onTouch(View v, MotionEvent event) 
    	{
    		if (event.getAction() == MotionEvent.ACTION_DOWN)
    		{
    			m_nPreTouchPosX = (int)event.getX();
    		}
    		
    		if (event.getAction() == MotionEvent.ACTION_UP)
    		{
    			int nTouchPosX = (int)event.getX();
    			
    			if (nTouchPosX < m_nPreTouchPosX)
    			{
    				MoveNextView();
    			}
    			else if (nTouchPosX > m_nPreTouchPosX)
    			{
    				MovewPreviousView();
    			}
    			
    			m_nPreTouchPosX = nTouchPosX;
    		}
    		
            return true;
        }
    };
    

}