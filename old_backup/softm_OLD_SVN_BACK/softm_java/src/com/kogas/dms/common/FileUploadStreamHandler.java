/**
 * 
 * Filename        : FileUploadStreamHandler.java
 * Fuction         : FileUpload에대한 스트림을 처리하는 클래스
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
import java.util.*;
import javax.servlet.*;
import javax.servlet.http.*;
/**
 * <pre>
 * Class FileUploadStreamHandler.
 * Mutil Part Form data를 올리기위한 Stream을 간직합니다.
 * Write  Date    : 2002/10/02
 * Update Date    : 2002/10/05
 * </pre>
 * @version  text : V1.0
 * @author   text : 김지훈
*/
@SuppressWarnings("unused")
public class FileUploadStreamHandler {

    ServletInputStream in =  null;
    int totalExpected;
    int totalRead = 0;
    byte[] buf = new byte[8 * 1024];

    public FileUploadStreamHandler ( ServletInputStream in,
                                   int totalExpected) {
        System.out.println ( " ==================== FileUploadStreamHandler 생성자호출 ==================== \n<BR>");
        this.in = in;
        this.totalExpected = totalExpected;
    }

  // Reads the next line of input.  Returns null to indicate the end
  // of stream.
  //
    public String readLine () throws IOException {
        StringBuffer sbuf = new StringBuffer();
        int result;
        String line;

        do {
          result = this.readLine(buf, 0, buf.length);  // this.readLine() does +=
          if (result != -1) {
            sbuf.append(new String(buf, 0, result, "UTF-8"));
          }
        } while (result == buf.length);  // loop only if the buffer was filled

        if (sbuf.length() == 0) {
          return null;  // nothing read, must be at the end of stream
        }

        sbuf.setLength(sbuf.length() - 2);  // cut off the trailing \r\n
        return sbuf.toString();
    }

  // A pass-through to ServletInputStream.readLine() that keeps track
  // of how many bytes have been read and stops reading when the 
  // Content-Length limit has been reached.
  //
    public int readLine(byte b[], int off, int len) throws IOException {
        if (totalRead >= totalExpected) {
            return -1;
        }
        else {
            int result = in.readLine(b, off, len);
            if (result > 0) {   // 제대로 읽었으면..
                totalRead += result;
            }
            return result;
        }
    }
////////////////////////////////////////////////////////////////////////////////

}


