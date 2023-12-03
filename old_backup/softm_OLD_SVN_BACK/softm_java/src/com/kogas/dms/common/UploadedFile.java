/**
 * 
 * Filename        : UploadedFile.java
 * Fuction         : 파일 업로드시 파일 정보 클래스
 * Comment         :
 * 시작 일자       : 2005/07/23,
 * 수정 일자       : 2005/07/23, Kim. JiHoon v1.0 first
 * 작 성 자        : 김 지 훈
 * 수 정 자        :
 * @version        : 1.0
 * @author         : Copyright (c) Taeul C & C. All Rights Reserved.
*/

package com.kogas.dms.common;

import java.io.*;

/**
 * <pre>
 * Class UploadedFile
 * 업로드 파일의 정보를 가지고 있습니다.
 * Write  Date    : 2002/10/02
 * Update Date    : 2002/10/05
 * </pre>
 * @version  text : V1.0
 * @author   text : 김지훈
*/
public class UploadedFile {

  private String dir;
  private String filename;
  private String type;
  private String chFileName;
  private int size;

  UploadedFile(String dir, String filename, String type) {
    this.dir = dir;
    this.filename = filename;
    this.type = type;
  }

  UploadedFile(String dir, String filename, int size,String type, String chFileName ) {
    this.dir = dir;
    this.filename = filename;
    this.size     = size;
    this.type = type;
    this.chFileName = chFileName ;
  }

  public String getContentType() {
    return type;
  }

  public String getFilesystemName() {
    return filename;
  }

  public String getExtraName() {
    return filename.substring( filename.lastIndexOf( "." ) + 1 );
  }

    
  public String getFileNameOnly() {
    return filename.substring( 0, filename.lastIndexOf( "." ) );
  }

  public int getFileSize() {
    return size;
  }

  public String getChangeFileName() {
    return chFileName;
  }

  public String getChangeFileNameOnly() {
    return chFileName.substring( 0, chFileName.lastIndexOf( "." ) );
  }

  public File getFile() {
    if (dir == null || filename == null) {
      return null;
    }
    else {
      return new File(dir + File.separator + filename);
    }
  }
}