package kr.co.gscaltex.gsnpoint.setting;

import java.io.File;
import java.io.FileOutputStream;

import kr.co.gscaltex.gsnpoint.BaseActivity;
import kr.co.gscaltex.gsnpoint.NewMainMenu;
import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.TitleView;
import kr.co.gscaltex.gsnpoint.util.Debug;
import kr.co.gscaltex.gsnpoint.util.FileInfo;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.Bitmap.CompressFormat;
import android.graphics.BitmapFactory;
import android.net.Uri;
import android.os.Bundle;
import android.provider.MediaStore;
import android.provider.MediaStore.Images;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ImageButton;
import android.widget.ImageView;

public class SettingMainImageView extends BaseActivity implements OnClickListener {
	private String TAG = "GS";
	
	private FileInfo fi = new FileInfo();
	private boolean m_bLogin = false;
	
	private ImageView	mTextImage = null;
	private ImageView	mMyPhoto = null;
	private ImageButton mMyPhotoSetBtn = null;
	private ImageButton mPhotoBtn = null;
	private ImageButton mPhotoAlbumBtn = null;
		
	private Bitmap Myphoto= null;
	private Uri mImageCaptureUri;
	//private static String outFilePath = Environment.getExternalStorageDirectory().getAbsolutePath() + "/" + Util.DIR + "/"+ "myphoto.jpg"; 
	private static String outFilePath = "/data/data/kr.co.gscaltex.gsnpoint/files" + "/"+ "myphoto.jpg"; 
	//private static String mImageName =  "myphoto.jpg";  
	
	private final int PICK_FROM_CAMERA= 100;
	private final int PICK_FROM_ALBUM= 200;
	
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.settingmainimg);
		Bundle extras = getIntent().getExtras();
		if(extras!=null)
			m_bLogin = extras.getBoolean("login");
		
		new TitleView(this,true,false,R.string.TITLE_TYPE_SETTING_MAIN_IMAGE,m_bLogin); 
		new NewMainMenu(this);

		mTextImage = (ImageView)findViewById(R.id.imageView1);
		
		mMyPhoto = (ImageView)findViewById(R.id.imageView2);
		
		mMyPhotoSetBtn = (ImageButton)findViewById(R.id.myphoto_set_btn);
		mMyPhotoSetBtn.setId(0);
		mMyPhotoSetBtn.setOnClickListener(this);
		
		mPhotoBtn = (ImageButton)findViewById(R.id.photo_btn);
		mPhotoBtn.setId(1);
		mPhotoBtn.setOnClickListener(this);
		
		mPhotoAlbumBtn = (ImageButton)findViewById(R.id.photo_album_btn);
		mPhotoAlbumBtn.setId(2);
		mPhotoAlbumBtn.setOnClickListener(this);
	
		String myphoto_set = this.fi.getSettingInfo(this, FileInfo.MYPHOTO_SET);
		if(m_bLogin){
			if(myphoto_set==null||myphoto_set.equals("")){
				
			}else{
				mTextImage.setImageDrawable(null);
				Bitmap bm = BitmapFactory.decodeFile(outFilePath);
				//Bitmap bm = BitmapFactory.decodeFile(temp);
				mMyPhoto.setImageBitmap(bm);
			}
		}
	
	}
	
	
	public void onClick(View v) {
		Intent intent;
		
		switch (v.getId()) {
		case 0 : 	
			if(Myphoto !=null){
				try{
					FileOutputStream fos = new FileOutputStream(outFilePath);
					Myphoto.compress(CompressFormat.JPEG, 100, fos);
					fos.flush();
					fos.close();
				}catch(Exception e){
				}
				fi.setSettingInfo(getBaseContext(), "TRUE", FileInfo.MYPHOTO_SET);
				mTextImage.setImageDrawable(null);
				
				showAlert(R.string.setting_mainimage_set);
			}else{
				return;
			}
			
			break;
		
		case 1 : 
			Intent cameraIntent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
			cameraIntent.setFlags(cameraIntent.FLAG_ACTIVITY_NO_USER_ACTION);
			startActivityForResult(cameraIntent,PICK_FROM_CAMERA);
			break;
		
		case 2 : 
			intent = new Intent(Intent.ACTION_PICK);
			intent.setType(android.provider.MediaStore.Images.Media.CONTENT_TYPE);
			intent.setData(android.provider.MediaStore.Images.Media.EXTERNAL_CONTENT_URI);
			intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
			startActivityForResult(intent,PICK_FROM_ALBUM);
			break;
		
		}
	}
	
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
	
		if(resultCode != RESULT_OK){
			if(data !=null){
			}
			return;
		}
		
		switch(requestCode){
		case PICK_FROM_CAMERA:
				
			Bundle extras = data.getExtras();
			Myphoto = extras.getParcelable("data");
			
			mMyPhoto.setImageBitmap(Myphoto);
			
			break;
			
		case PICK_FROM_ALBUM:
			mImageCaptureUri= data.getData();
			try{
				Myphoto=Images.Media.getBitmap(getContentResolver(), mImageCaptureUri);
				mMyPhoto.setImageBitmap(Myphoto);
				
			}catch(Exception e){
			}			
		}
	   
	}

	
	@Override
	protected void httpResult(int what, boolean result, String kind) {
		// TODO Auto-generated method stub
		//Debug.trace(TAG, "httpResult" + "[" + what + "](" + result + ")") ;
		
	}
}
