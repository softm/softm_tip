package com.entropykorea.gas.as.common.util;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.StringWriter;
import java.io.UnsupportedEncodingException;
import java.text.DecimalFormat;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Enumeration;
import java.util.Locale;
import java.util.Properties;
import java.util.TimeZone;
import java.util.zip.ZipEntry;
import java.util.zip.ZipFile;
import java.util.zip.ZipOutputStream;

import javax.xml.transform.OutputKeys;
import javax.xml.transform.Transformer;
import javax.xml.transform.TransformerFactory;
import javax.xml.transform.dom.DOMSource;
import javax.xml.transform.stream.StreamResult;

import org.w3c.dom.Document;

import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.Matrix;
import android.media.ExifInterface;
import android.widget.Toast;

import com.entropykorea.ewire.dialog.LongTimeDialog;
import com.entropykorea.gas.as.common.object.MLog;
import com.entropykorea.gas.as.constants.Constant;

public class Util {
  
  long seekTime;
  long readTime;
  long setFieldTime;
  long addListTime;
  long allTime;
  long seekAllTime;
  long readAllTime;
  long setFieldAllTime;
  long setCompareTime;
  long setCompareAllTime;
  long setArrayCopyTime;
  long setArrayCopyAllTime;
  long createStringTime = 0;
  long createStringAllTime = 0;
  long createBufferTime = 0;
  long createBufferAllTime = 0;
  long getPrevIdxAllTime = 0;
  long getNextIdxAllTime = 0;
  
  long start_time = 0;
  long end_time = 0;
  
  public static boolean creatDir(String full_path) {
    
    boolean rtn = false;
    
    try {
      // MLog.d.info("creatDir full_path==>" + full_path);
      File dirs = new File(full_path);
      if (!dirs.exists()) {
        // MLog.d.info("creatDir !dirs.exists()");
        dirs.mkdirs();
      }
      
      rtn = true;
    } catch (Exception e) {
      // TODO Auto-generated catch block
      e.printStackTrace();
    }
    
    return rtn;
  }
  
  public static boolean creatFile(String full_path) {
    
    boolean rtn = false;
    
    // MLog.d.info("creatFile full_path==>" + full_path);
    try {
      File file = new File(full_path);
      if (!file.exists()) {
        // MLog.d.info("creatFile !file.exists()");
        try {
          file.createNewFile();
        } catch (Exception e) {
          e.printStackTrace();
          // MLog.d.error("creatFile fail E:"+e);
        }
      }
      
      rtn = true;
    } catch (Exception e) {
      // TODO Auto-generated catch block
      e.printStackTrace();
    }
    
    return rtn;
  }
  
  public static void deleteFile(String full_path) {
    // MLog.d.info("deleteFile full_path==>" + full_path);
    File file = new File(full_path);
    if (file.exists()) {
      // MLog.d.info("deleteFile file.exists()");
      try {
        file.delete();
      } catch (Exception e) {
        e.printStackTrace();
        // MLog.d.error("deleteFile fail E:"+e);
      }
    }
  }
  
  public static void moveFile(String full_path, File destFile) {
    // MLog.d.info("deleteFile full_path==>" + full_path);
    File file = new File(full_path);
    if (file.exists()) {
      // MLog.d.info("deleteFile file.exists()");
      try {
        file.renameTo(destFile);
      } catch (Exception e) {
        e.printStackTrace();
        // MLog.d.error("moveFile fail E:"+e);
      }
    }
  }
  
  public static boolean Zip(File[] sourceFileArr, String targetZipFileFullPath) {
    
    // System.getProperty("os.name");
    // System.getProperty("file.separator");
    // System.getProperty("user.dir");
    
    boolean rtn = false;
    try {
      
      MLog.d("Zip targetZipFileFullPath==>" + targetZipFileFullPath);
      
      final int DATA_BLOCK_SIZE = 2048;
      int byteCount = 0;
      
      Util.creatDir(targetZipFileFullPath.substring(0, targetZipFileFullPath.lastIndexOf("/")));
      FileOutputStream fos = new FileOutputStream(targetZipFileFullPath);
      ZipOutputStream zos = new ZipOutputStream(fos);
      // zos.setEncoding("euc-kr");
      // zos.setLevel(3);
      
      for (int i = 0; i < sourceFileArr.length; i++) {
        MLog.d("Zip sourceFileArr[" + i + "]==>" + sourceFileArr[i]);
        if (sourceFileArr[i].exists()) {
          
          FileInputStream fis = new FileInputStream(sourceFileArr[i]);
          // MLog.d("Zip sourceFileArr["+i+"].getName()==>" + sourceFileArr[i].getName());
          ZipEntry cpZipEntry = new ZipEntry(sourceFileArr[i].getName());
          // MLog.d("Zip cpZipEntry==>" + cpZipEntry);
          zos.putNextEntry(cpZipEntry);
          // MLog.d("Zip zos==>" + zos);
          byte[] b = new byte[DATA_BLOCK_SIZE];
          // MLog.d("Zip b==>" + b);
          while ((byteCount = fis.read(b, 0, DATA_BLOCK_SIZE)) != -1) {
            // MLog.d("Zip byteCount==>"+byteCount);
            zos.write(b, 0, byteCount);
          }
          zos.closeEntry();
          fis.close();
        }
      }
      // zos.finish(); // 사용하면 압축 깨짐..
      zos.close();
      fos.close();
      
      rtn = true; // "2000";
      
    } catch (Exception e) {
      MLog.d("Zip e==>" + e);
      // return "7700"; // 파일 압축 오류
    }
    
    return rtn;
  }
  
  public static boolean unZip(File sourceZipFile, String unzip_path) {
    
    boolean rtn = false;
    MLog.d("unZip sourceZipFile==>" + sourceZipFile);
    MLog.d("unZip unzip_path==>" + unzip_path);
    
    try {
      
      if (!unzip_path.substring(unzip_path.length() - 1, unzip_path.length()).equals("/")) {
        unzip_path += "/";
      }
      MLog.d("unZip unzip_path==>" + unzip_path);
      
      byte[] bytes = new byte[4096];
      
      ZipFile zipFile = new ZipFile(sourceZipFile);
      
      MLog.d("unZip zipFile==>" + zipFile);
      
      Enumeration enu = zipFile.entries();
      MLog.d("unZip enu==>" + enu);
      
      while (enu.hasMoreElements()) {
        MLog.d("unZip enu.hasMoreElements()==>" + enu.hasMoreElements());
        String currentEntry = ((ZipEntry) enu.nextElement()).getName();
        
        MLog.d("unZip currentEntry==>" + currentEntry);
        MLog.d("unZip unzip_path + currentEntry==>" + unzip_path + currentEntry);
        
        // byte[] bytes = new byte[4096];
        
        InputStream is = zipFile.getInputStream(zipFile.getEntry(currentEntry));
        int len = 0;
        
        // FileOutputStream fos = new FileOutputStream(currentEntry);
        FileOutputStream fos = new FileOutputStream(unzip_path + currentEntry);
        while ((len = is.read(bytes)) > 0) {
          fos.write(bytes, 0, len);
        }
        fos.close();
        is.close();
      }
      zipFile.close();
      
      rtn = true;
      
    } catch (Exception e) {
      MLog.d("unZip e==>" + e);
      
    }
    
    return rtn;
  }
  
  public static byte[] toByteSpace(String srcStr, int byteLength, int flag) {
    // flag
    // 1: 값이 있는 경우에만 스페이스를 채운다. 값이 없는 경우는 null 로 리턴 (검색)
    // 2: 무조건 길이만큼 스페이스를 채운다. (파일저장 또는 송신)
    byte[] tgtByte = null;
    
    if (flag == 1 && (srcStr == null || srcStr.equals(""))) {
      
    } else {
      
      tgtByte = new byte[byteLength];
      
      int i = 0;
      if (srcStr != null) {
        try {
          for (i = 0; i < srcStr.getBytes(Constant.ENCODING).length; i++) {
            tgtByte[i] = srcStr.getBytes(Constant.ENCODING)[i];
          }
        } catch (UnsupportedEncodingException e) {
          // TODO Auto-generated catch block
          e.printStackTrace();
        } catch (Exception e) {
          // TODO Auto-generated catch block
          e.printStackTrace();
        }
      } else {
        
      }
      for (i = i; i < byteLength; i++) {
        tgtByte[i] = 0x20;
      }
      
    }
    
    return tgtByte;
  }
  
  /**
   * 현재 날짜와시간
   * 
   * @return "yyyyMMddHHmmss"
   */
  public static String getDateSecTime() {
    SimpleDateFormat simpleFormat = new SimpleDateFormat("yyyyMMddHHmmss");
    TimeZone tz = TimeZone.getTimeZone("GMT+9");
    Calendar cal = Calendar.getInstance(tz, Locale.KOREAN);
    
    simpleFormat.setTimeZone(tz);
    return simpleFormat.format(cal.getTime());
  }
  
  public static String getBillDate() {
    String date = "";
    String t = getDateSecTime();
    date = t.substring(0, 4) + "-" + t.substring(4, 6) + "-" + t.substring(6, 8) + "  " + t.subSequence(8, 10) + ":" + t.subSequence(10, 12) + ":" + t.substring(12, 14);
    return date;
  }
  
  public static String getProcDate() {
    String date = "";
    String t = getDateSecTime();
    date = t.substring(0, 4) + "." + t.substring(4, 6) + "." + t.substring(6, 8);
    return date;
  }
  
  // --------------------------------
  
  public static String substring(String str, int s, int e) {
    
    if (str == null) {
      return "";
    } else {
      if (str.length() < s || s > e) {
        return "";
      } else {
        if (str.length() < e) {
          return str.substring(s);
        } else {
          return str.substring(s, e);
        }
      }
    }
  }
  
  public static String makeDateString(String str) {
    String reDate = new String();
    int len = str.length();
    
    if (len >= 4) {
      reDate += substring(str.trim(), 0, 4) + "년";
    }
    
    if (len >= 6) {
      reDate += substring(str.trim(), 4, 6) + "월";
    }
    
    if (len >= 8) {
      reDate += substring(str.trim(), 6, 8) + "일";
    }
    
    return reDate;
  }
  
  public static String getCommaString(String s) {
    String result = new String();
    Integer num = 0;
    
    try {
      num = Integer.parseInt(s);
      DecimalFormat df = new DecimalFormat("###,###");
      result = df.format(num);
    } catch (NumberFormatException e) {
      result = "";
    }
    
    return result;
  }
  
  public static String maskingString(String str) {
    String reStr = "";
    int length = str.length();
    int masklength = length > 4 ? length - 4 : length;
    
    for (int i = 0; i < length; i++) {
      if (i < masklength) {
        reStr += "*";
      } else {
        reStr += str.charAt(i);
      }
    }
    
    return reStr;
  }
  
  public static int length(String str) {
    if (str == null) return 0;
    
    int length = str.length();
    
    for (int i = 0; i < str.length(); i++) {
      if (str.charAt(i) > 256) length++;
    }
    
    return length;
  }
  
  public static String makeFrontSpaceSting(String str, int len) {
    String result = new String();
    int strlen = length(str);
    
    if (strlen >= len) return str;
    
    for (int i = 0; i < (len - strlen); i++) {
      result += " ";
    }
    
    if (str != null) result += str;
    
    // Log.d("SKGACS", "SPACE:" + strlen );
    
    return result;
  }
  
  /**
   * 2.1 에서는 정상작동하지 않음 Since: API Level 8
   * 
   * @param doc
   * @return
   */
  public static String documentToString(Document doc) {
    
    TransformerFactory trf = TransformerFactory.newInstance();
    String xmlStr = "";
    
    try {
      StringWriter sw = new StringWriter();
      Properties output = new Properties();
      
      output.setProperty(OutputKeys.INDENT, "yes");
      output.setProperty(OutputKeys.ENCODING, "UTF-8");
      
      Transformer transformer = trf.newTransformer();
      transformer.setOutputProperties(output);
      transformer.transform(new DOMSource(doc), new StreamResult(sw));
      xmlStr = sw.getBuffer().toString();
    } catch (Exception e) {
    }
    return xmlStr;
  }
  
  public static void testRun(Context ctx, String message) {
    
    new LongTimeDialog(ctx, message, true, ctx) {
      @Override
      public Boolean doBackground(Object obj) {
        try {
          Thread.sleep(2000);
        } catch (InterruptedException e) {
          e.printStackTrace();
          return false;
        }
        return true;
      }
      
      @Override
      public void doEndExecute(Object obj, Boolean result) {
        Toast.makeText((Context) obj, "DONE", Toast.LENGTH_LONG).show();
      }
    }.show();
  }
  
  public static void createDir() {
    String[] dirPath = { Constant.SD_DIR, Constant.PIC_PATH, Constant.SIGN_PATH };
    for (String str : dirPath) {
      File file = new File(str);
      if (!file.exists()) // 원하는 경로에 폴더가 있는지 확인
      file.mkdirs();
    }
  }
  
  public static void forceRename(File source, File target) throws IOException {
    if (target.exists()) target.delete();
    source.renameTo(target);
  }
  
  public static void deleteFilesWithExtension(final String directoryName, final String extension) {
    
    final File dir = new File(directoryName);
    final String[] allFiles = dir.list();
    for (final String file : allFiles) {
      if (file.endsWith(extension)) {
        new File(directoryName + "/" + file).delete();
      }
    }
  }
  
  public static void deleteFilesWithPrefix(final String directoryName, final String prefix) {
    
    final File dir = new File(directoryName);
    final String[] allFiles = dir.list();
    for (final String file : allFiles) {
      if (file.startsWith(prefix)) {
        new File(directoryName + "/" + file).delete();
      }
    }
  }
  
  /**
   * EXIF정보를 회전각도로 변환하는 메서드
   * 
   * @param exifOrientation
   *            EXIF 회전각
   * @return 실제 각도
   */
  public static int exifOrientationToDegrees(int exifOrientation) {
    if (exifOrientation == ExifInterface.ORIENTATION_ROTATE_90) {
      return 90;
    } else if (exifOrientation == ExifInterface.ORIENTATION_ROTATE_180) {
      return 180;
    } else if (exifOrientation == ExifInterface.ORIENTATION_ROTATE_270) {
      return 270;
    }
    return 0;
  }

  /**
   * 이미지를 회전시킵니다.
   * 
   * @param bitmap
   *            비트맵 이미지
   * @param degrees
   *            회전 각도
   * @return 회전된 이미지
   */
  public static Bitmap rotate(Bitmap bitmap, int degrees) {
    if (degrees != 0 && bitmap != null) {
      Matrix m = new Matrix();
      m.setRotate(degrees, (float) bitmap.getWidth() / 2,
          (float) bitmap.getHeight() / 2);

      try {
        Bitmap converted = Bitmap.createBitmap(bitmap, 0, 0,
            bitmap.getWidth(), bitmap.getHeight(), m, true);
        if (bitmap != converted) {
          bitmap.recycle();
          bitmap = converted;
        }
      } catch (OutOfMemoryError ex) {
        // 메모리가 부족하여 회전을 시키지 못할 경우 그냥 원본을 반환합니다.
      }
    }
    return bitmap;
  }
}
