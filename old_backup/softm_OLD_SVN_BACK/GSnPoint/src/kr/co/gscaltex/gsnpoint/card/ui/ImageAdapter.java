package kr.co.gscaltex.gsnpoint.card.ui;

import java.util.ArrayList;

import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.util.FileInfo;
import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.Bitmap.Config;
import android.graphics.Canvas;
import android.graphics.LinearGradient;
import android.graphics.Matrix;
import android.graphics.Paint;
import android.graphics.PorterDuff.Mode;
import android.graphics.PorterDuffXfermode;
import android.graphics.Shader.TileMode;
import android.graphics.drawable.BitmapDrawable;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;

public class ImageAdapter extends BaseAdapter {
	int mGalleryItemBackground;
	private Context mContext;
	//private Integer[] mImageIds;
	//private Bitmap[] mImageBitmap;
	ArrayList<Bitmap> mImageBitmap = new ArrayList<Bitmap>();
	FileInfo fi = new FileInfo() ;
	
	/*lhr add*/
	private ArrayList<String> mCadeNums = new ArrayList<String>();
	/*lhr end*/

	private ImageView[] mImages;

	public ImageAdapter(Context c, ArrayList<Bitmap> imgs) {
		mContext = c;
		//mImageBitmap = new Bitmap[imgs.length];
		mImageBitmap=imgs;
    	mImages = new ImageView[imgs.size()];
		
		createReflectedImages();
	}
	
  
	public boolean createReflectedImages() {
		//The gap we want between the reflection and the original image
		int reflectionGap = 1;
		int startY;
		
		int index = 0;
		
		for(int i = 0; i < mImageBitmap.size();i++ ){
			Bitmap originalImg= mImageBitmap.get(i);
			
			if( originalImg == null ){
				BitmapDrawable drawable = (BitmapDrawable) mContext.getResources().getDrawable(R.drawable.guide_pointcard01_card);
				originalImg = drawable.getBitmap().copy(Config.ARGB_8888, true);
			}
			
			int width = originalImg.getWidth();
			int height = originalImg.getHeight();
			int reflectionHeight = height / 2;
		
			startY = reflectionHeight / 2;
	
			//This will not scale but will flip on the Y axis
			Matrix matrix = new Matrix();
			matrix.postScale(1, -1);
			 
			//Create a Bitmap with the flip matrix applied to it.
			//We only want the bottom half of the image
			Bitmap reflectionImage = Bitmap.createBitmap(originalImg,
					0, height-reflectionHeight,
					width, reflectionHeight, matrix, false);
			
			if( reflectionImage == null ){
			}
	
			//Create a new bitmap with same width but taller to fit reflection
			Bitmap bitmapWithReflection = Bitmap.createBitmap(width,
					height+reflectionHeight, Config.ARGB_8888);
			
			if( bitmapWithReflection == null ){
			}
			//Create a new Canvas with the bitmap that's big enough for
			//the image plus gap plus reflection
			Canvas canvas = new Canvas(bitmapWithReflection);
			//Draw in the original image
			 canvas.drawBitmap(originalImg, 0, startY, null);
			
			//Draw in the gap
			/*Paint defaultPaint = new Paint();
			defaultPaint.setColor(Color.BLACK);
			canvas.drawRect(0, height+reflectionGap,
					width, bitmapWithReflection.getHeight(), defaultPaint);*/
			//Draw in the reflection
			canvas.drawBitmap(reflectionImage,
					0, startY+height+reflectionGap, null);

			//Create a shader that is a linear gradient that covers the reflection
			Paint paint = new Paint();
			LinearGradient shader = new LinearGradient(0,
					startY+height+reflectionGap,
					0, bitmapWithReflection.getHeight(),
					0x80000000, 0x00000000, TileMode.CLAMP);
			//Set the paint to use this shader (linear gradient)
			paint.setShader(shader);
			//Set the Transfer mode to be porter duff and destination in
			paint.setXfermode(new PorterDuffXfermode(Mode.DST_ATOP));
			//Draw a rectangle using the paint with our linear gradient
			canvas.drawRect(0, startY+height+reflectionGap, width,
				bitmapWithReflection.getHeight(), paint);

			ImageView imageView = new ImageView(mContext);
			imageView.setImageBitmap(bitmapWithReflection);
			imageView.setLayoutParams(new CoverFlow.LayoutParams(width,
					height+reflectionHeight));
			//imageView.setScaleType(ImageView.ScaleType.FIT_CENTER);
			imageView.setScaleType(ImageView.ScaleType.MATRIX);			
			
			if(mImages.length==0){
				mImages[index] = imageView;
			}else{				
				/*lhr modify*/
				mImages[index++] = imageView;
			}	
		}
		return true;
	}

	public int getCount() {
		 return mImageBitmap.size();
	}

	public Object getItem(int position) {
		 return mImages[position];
	}

	public long getItemId(int position) {
		 return position;
	}

	public View getView(int position, View convertView, ViewGroup parent) {
		//Use this code if you want to load from resources
		/*ImageView i = new ImageView(mContext);
		i.setImageResource(mImageIds[position]);
		i.setLayoutParams(new CoverFlow.LayoutParams(246, 144));
		i.setScaleType(ImageView.ScaleType.CENTER_INSIDE); 

		//Make sure we set anti-aliasing otherwise we get jaggies
		BitmapDrawable drawable = (BitmapDrawable)i.getDrawable();
		drawable.setAntiAlias(true);
		return i;*/
		 
		if(mImages.length==0){
			return mImages[0];
		}else{
			if(position>=mImages.length){
				return mImages[mImages.length-1];
			}else{
				return mImages[position];
			}
		}
	}

	/** Returns the size (0.0f to 1.0f) of the views
	 * depending on the 'offset' to the center. */
	public float getScale(boolean focused, int offset) {
		/* Formula: 1 / (2 ^ offset) */
		return Math.max(0, 1.0f/(float)Math.pow(2, Math.abs(offset)));
	}
	
	public void clearImage(){
		if( mImages != null ){
			final int size = mImages.length;
			for( int i = 0; i < size; i++ ){
				((BitmapDrawable)mImages[i].getDrawable()).getBitmap().recycle();
				mImages[i] = null;
			}
			
			mImages = new ImageView[0];
			
			mCadeNums.clear();
			
			mImageBitmap.clear();
		}
	}
	
}

