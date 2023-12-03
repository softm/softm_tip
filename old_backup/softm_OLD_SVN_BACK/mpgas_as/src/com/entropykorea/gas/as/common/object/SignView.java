package com.entropykorea.gas.as.common.object;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;

import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Canvas;
import android.graphics.Color;
import android.graphics.Paint;
import android.graphics.Path;
import android.util.AttributeSet;
import android.view.MotionEvent;
import android.view.View;

public class SignView extends View {
  
  private Bitmap mBitmap = null;
  private Canvas mCanvas = null;
  private Path mPath;
  private Paint mBitmapPaint;
  private Paint mPaint;
  
  private boolean bEdited = false;
  private boolean bLock = false;
  private boolean bFileExist = false;
  private String mFileName = new String();
  
  public void init() {
    mPath = new Path();
    
    mPaint = new Paint();
    // mPaint.setAntiAlias(true); // 파일 저장 시 이미지 틀려짐
    mPaint.setDither(true);
    mPaint.setColor(Color.BLACK); // line color
    mPaint.setStyle(Paint.Style.STROKE);
    mPaint.setStrokeJoin(Paint.Join.ROUND);
    mPaint.setStrokeCap(Paint.Cap.ROUND);
    mPaint.setStrokeWidth(3);
    
    mBitmapPaint = new Paint(Paint.DITHER_FLAG);
  }
  
  public SignView(Context c) {
    super(c);
    init();
  }
  
  public SignView(Context context, AttributeSet attrs) {
    super(context, attrs);
    init();
  }
  
  public SignView(Context context, AttributeSet attrs, int defStyle) {
    super(context, attrs, defStyle);
    init();
  }
  
  public void setLock(boolean bLock) {
    this.bLock = bLock;
  }
  
  public boolean isLock() {
    return this.bLock;
  }
  
  public boolean isFileExist() {
    return this.bFileExist;
  }
  
  public boolean isEdited() {
    boolean rtn = false;
    
    if (bFileExist) rtn = true;
    if (bEdited) rtn = true;
    
    return rtn;
  }
  
  public boolean isbEdited(){
    return bEdited;
  }
  
  public boolean Clear() {
    if (bLock) return true;
    
    bEdited = false;
    mBitmap.eraseColor(Color.WHITE);
    this.invalidate();
    
    return Delete(this.mFileName);
  }
  
  public boolean Delete(String fn) {
    boolean rtn = false;
    
    if (bLock) return true;
    
    try {
      File f = new File(fn);
      f.delete();
      
      this.bFileExist = false;
      
      rtn = true;
      
    } catch (Exception e) {
      
    } finally {
      
    }
    
    return rtn;
  }
  
  public boolean Save(String fn) {
    boolean rtn = false;
    FileOutputStream out = null;
    
    if (bLock) return true;
    
    try {
      
      out = new FileOutputStream(fn);
      out.write(BMPGenerator.encodeBMP_1(mBitmap));
      out.close();
      
      this.bFileExist = true;
      this.mFileName = fn;
      
      rtn = true;
      
    } catch (Exception e) {
      
    } finally {
      try {
        out.close();
      } catch (IOException e) {
        e.printStackTrace();
      }
    }
    
    return rtn;
  }
  
  public boolean Load(String fn) {
    boolean rtn = false;
    
    try {
      File f = new File(fn);
      
      // 파일 존재 여부 판단
      if (!f.isFile()) {
        this.bFileExist = false;
        return rtn;
      }
      
      this.bFileExist = true;
      this.mFileName = fn;
      
      if (mBitmap != null) {
        int w = this.getWidth();
        int h = this.getHeight();
        
        Bitmap bitmap1 = BitmapFactory.decodeFile(fn);
        int w1 = bitmap1.getHeight();
        int h1 = bitmap1.getWidth();
        
        // 원본 사이즈와 틀리면 변경
        if (w != w1 || h != h1) {
          Bitmap bitmap2 = Bitmap.createScaledBitmap(bitmap1, w, h, true);
          mBitmap = bitmap2.copy(Bitmap.Config.ARGB_8888, true);
        } else {
          mBitmap = bitmap1.copy(Bitmap.Config.ARGB_8888, true);
        }
        mCanvas = new Canvas(mBitmap);
        
        this.invalidate();
      }
      rtn = true;
      
    } catch (Exception e) {
      
    } finally {
      
    }
    
    return rtn;
  }
  
  /**
   * 이미지 파일 사이즈를 변경 한다.
   * 
   * @param src
   * @param tar
   * @param w
   * @param h
   * @return
   */
  public static boolean ChangeSize(String src, String tar, int w) {
    return ChangeSize(src, tar, w, 0);
  }
  
  public static boolean ChangeSize(String src, String tar, int w, int h) {
    boolean rtn = false;
    FileOutputStream out = null;
    
    if (w == 0) return rtn;
    
    try {
      File f = new File(src);
      
      // 파일 존재 여부 판단
      if (!f.isFile()) {
        return rtn;
      }
      
      Bitmap bitmap1 = BitmapFactory.decodeFile(src);
      if (h == 0) {
        int w1 = bitmap1.getWidth();
        int h1 = bitmap1.getHeight();
        
        h = (int) ((float) h1 / w1 * w);
      }
      Bitmap bitmap2 = Bitmap.createScaledBitmap(bitmap1, w, h, true);
      
      out = new FileOutputStream(tar);
      out.write(BMPGenerator.encodeBMP_1(bitmap2));
      out.close();
      
      rtn = true;
      
    } catch (IOException e) {
    } catch (Exception e) {
      
    } finally {
      try {
        out.close();
      } catch (IOException e) {
        e.printStackTrace();
      }
    }
    
    return rtn;
  }
  
  @Override
  protected void onSizeChanged(int w, int h, int oldw, int oldh) {
    super.onSizeChanged(w, h, oldw, oldh);
    
    if (mBitmap == null) {
      mBitmap = Bitmap.createBitmap(w, h, Bitmap.Config.ARGB_8888);
      mCanvas = new Canvas(mBitmap);
      
      if (bFileExist) {
        Load(this.mFileName);
      }
    }
  }
  
  @Override
  protected void onDraw(Canvas canvas) {
    // canvas.drawColor(Color.WHITE); // background color
    canvas.drawBitmap(mBitmap, 0, 0, mBitmapPaint);
    canvas.drawPath(mPath, mPaint);
  }
  
  private float mX, mY;
  private static final float TOUCH_TOLERANCE = 4;
  
  private void touch_start(float x, float y) {
    mPath.reset();
    mPath.moveTo(x, y);
    mX = x;
    mY = y;
  }
  
  private void touch_move(float x, float y) {
    float dx = Math.abs(x - mX);
    float dy = Math.abs(y - mY);
    if (dx >= TOUCH_TOLERANCE || dy >= TOUCH_TOLERANCE) {
      mPath.quadTo(mX, mY, (x + mX) / 2, (y + mY) / 2);
      mX = x;
      mY = y;
    }
  }
  
  private void touch_up() {
    mPath.lineTo(mX, mY);
    // commit the path to our offscreen
    mCanvas.drawPath(mPath, mPaint);
    // kill this so we don't double draw
    mPath.reset();
  }
  
  @Override
  public boolean onTouchEvent(MotionEvent event) {
    float x = event.getX();
    float y = event.getY();
    
    if (bLock) return true;
    
    switch (event.getAction()) {
      case MotionEvent.ACTION_DOWN:
        touch_start(x, y);
        invalidate();
        // bEdited = true;
        break;
      case MotionEvent.ACTION_MOVE:
        touch_move(x, y);
        invalidate();
        // bEdited = true;
        break;
      case MotionEvent.ACTION_UP:
        touch_up();
        invalidate();
        bEdited = true;
        break;
    }
    return true;
  }
  
}
