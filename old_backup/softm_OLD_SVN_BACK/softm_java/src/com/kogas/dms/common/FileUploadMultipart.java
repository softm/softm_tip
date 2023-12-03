/**
 *
 * Filename        : FileUploadMultipart.java
 * Fuction         : FileUpload Multipart
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
 * 파일 업로드의 주역.
 * A utility class to handle <tt>multipart/form-data</tt> requests,
 * the kind of requests that support file uploads.  This class can
 * receive arbitrarily large files (up to an artificial limit you can set),
 * and fairly efficiently too.
 * It cannot handle nested data (multipart content within multipart content)
 * or internationalized content (such as non Latin-1 filenames).

 * <blockquote><pre>
 * MultipartRequest multi = new MultipartRequest(req, ".");
 * &nbsp;
 * out.println("Params:");
 * Enumeration params = multi.getParameterNames();
 * while (params.hasMoreElements()) {
 *   String name = (String)params.nextElement();
 *   String value = multi.getParameter(name);
 *   out.println(name + " = " + value);
 * }
 * out.println();
 * &nbsp;
 * out.println("Files:");
 * Enumeration files = multi.getFileNames();
 * while (files.hasMoreElements()) {
 *   String name = (String)files.nextElement();
 *   String filename = multi.getFilesystemName(name);
 *   String type = multi.getContentType(name);
 *   File f = multi.getFile(name);
 *   out.println("name: " + name);
 *   out.println("filename: " + filename);
 *   out.println("type: " + type);
 *   if (f != null) {
 *     out.println("f.toString(): " + f.toString());
 *     out.println("f.getName(): " + f.getName());
 *     out.println("f.exists(): " + f.exists());
 *     out.println("f.length(): " + f.length());
 *     out.println();
 *   }
 * }
 * </pre></blockquote>
 *
 * A client can upload files using an HTML form with the following structure.
 * Note that not all browsers support file uploads.
 * <blockquote><pre>
 * &lt;FORM ACTION="/zzook/servlet/Handler" METHOD=POST
 *          ENCTYPE="multipart/form-data"&gt;
 * What is your name? &lt;INPUT TYPE=TEXT NAME=submitter&gt; &lt;BR&gt;
 * Which file to upload? &lt;INPUT TYPE=FILE NAME=file&gt; &lt;BR&gt;
 * &lt;INPUT TYPE=SUBMIT&GT;
 * &lt;/FORM&gt;
 * </pre></blockquote>
 * <p>
 * The full file upload specification is contained in experimental RFC 1867,
 * available at <a href="http://www.ietf.org/rfc/rfc1867.txt">
 * http://www.ietf.org/rfc/rfc1867.txt</a>.

*<PRE>
*   Multi-part Stream 분석
* ===============================================
* &lt;html&gt;&lt;body&gt;
 *
* &lt;form method="post" action="FileUpload2.jsp" enctype=multipart/form-data&gt;
* &lt;!-- enctype=multipart/form-data--&gt;
* &lt;input type="text" name=testparam1 value='VALUE1'&gt;&lt;br&gt;
* &lt;input type="text" name=testparam2 value='VALUE2'&gt;&lt;br&gt;
* &lt;input type="text" name=testparam3 value='VALUE3'&gt;&lt;br&gt;
*
* &lt;input type="file" name=binary1&gt;&lt;br&gt;
*
* &lt;input type=submit value=업로드&gt;
*
* &lt;/form&gt;
*
*<&lt;/body&gt;&lt;/html&gt;
* ===============================================
* testparam1,testparam2 이라는 이름을 갖는 text     타입의 Form Element,
* testparam3            이라는 이름을 갖는 textarea 타입의 Form Element,
**binary1               이라는 이름을 갖는 file     타입의 Form Element 가 존재할때
* 전송되는 Stream 값은 다음과 같습니다.
*
* <B>======================================================</B>                   ============= 전송 정보 =============
* -----------------------------7d03be1c503e4                                      1 line : boundary 값
* Content-Disposition: form-data; name="testparam1"                               2 line : disposition , parameter Name
*                                                                                 3 line : 한칸 띄움
* VALUE1                                                                          4 line : Parameter의 내용
* -----------------------------7d03be1c503e4                                      1 line : boundary 값
* Content-Disposition: form-data; name="testparam2"                               2 line : disposition , parameter Name
*                                                                                 3 line : 한칸 띄움
* VALUE2                                                                          4 line : Parameter의 내용
* -----------------------------7d03be1c503e4                                      1 line : boundary 값
*<Content-Disposition: form-data; name="testparam3"                               2 line : disposition , parameter Name
*                                                                                 3 line : 한칸 띄움
* TEXTAREA 1                                                                      4 line : Parameter의 내용
* TEXTAREA 2                                                                      5 line : Parameter의 내용
* TEXTAREA 3                                                                      6 line : Parameter의 내용
*
* -----------------------------7d03be1c503e4                                      1 line : boundary 값
* Content-Disposition: form-data; name="binary1"; filename="C:\TestFile1.txt"     2 line : disposition , parameter Name, file path
* Content-Type: text/plain                                                        3 line : Content Type
*                                                                                 4 line : 한칸 띄움
* 1                                                                               5 line : 내용
* 12                                                                              6 line : 내용
* 123                                                                             7 line : 내용
* 1234                                                                            8 line : 내용
* 12345                                                                           9 line : 내용
* 123456                                                                         10 line : 내용
* -----------------------------7d03be1c503e4--                                    last line : boundary 값
*<
* <B>======================================================</B>
* 순서적인 배열인것을 알 수 있습니다.
* text, textarea Element 를 통해전송된 내용
**    ( boundary 값, ( diposition, Parameter명              ), 한칸 띄우고, 내용 의 순서로 배열되어 있습니다.
* file           Element 를 통해전송된 내용
*     ( boundary 값, ( diposition, Parameter명 , file의경로 ), 한칸 띄우고, 내용 의 순서로 배열되어 있습니다.
* </PRE>
* -----------------------------7d063e14044a--
 *
 * @author <b>Jason Hunter</b>, Copyright &#169; 1998-1999
 * @version 1.4, 00/01/05, added getParameterValues(),
 *                         WebSphere 2.x getContentType() workaround,
 *                         stopped writing empty "unknown" file
 * @version 1.3, 99/12/28, IE4 on Win98 lastIndexOf("boundary=") workaround
 * @version 1.2, 99/12/20, IE4 on Mac readNextPart() workaround
 * @version 1.1, 99/01/15, JSDK readLine() bug workaround
 * @version 1.0, 98/09/18

 * <p>
 * It's used like this:
 * Write  Date    : 2002/10/02
 * Update Date    : 2002/10/05
 * </pre>
*/


@SuppressWarnings("unchecked")
public class FileUploadMultipart {

    private static final int DEFAULT_MAX_POST_SIZE = 1024 * 1024;  // 1 Meg

    private HttpServletRequest req;                                // HttpServletRequest 의 인스턴스.

    private String saveDirectory = null;                           // 파일의 저장위치

    private File dir;                                              // 파일이 저장될 위치에 대한 File 인스턴스.

    private int maxSize;                                           // 파일의 최대 크기.

    private static final String NO_FILE = "unknown";

    @SuppressWarnings("rawtypes")
	private Hashtable parameters = new Hashtable();                // name - Vector of values // 파라메터 보관을 위한 Hash영역.

    @SuppressWarnings("rawtypes")
	private Hashtable files      = new Hashtable();                    // name - UploadedFile     // upload 파일 정보를 보관하기 위한 Hash영역

    private PrintWriter oout     = null;

    private char   logPrintY     = 'N';


    /** Directory를 생성합니다.
    * @param path the String
    * @return boolean true or false
    * @see
    */
    public static boolean makeDir(String path) {
        File mkdir = new File ( path );
        if ( !mkdir.isDirectory() ) {
            if ( mkdir.mkdir() ) {
                System.out.println ( " directory Create Success : " + path + "\n");
                return true;
            } else {
                System.out.println ( " directory Create fail " );
                return false;
            }
        } else {
            return false;
        }
    }

    /**
    * 저장 디렉토리를 지정합니다.
    * @param gubun 'Y'/ 'N' : 브라우저로 출력 여부.
    */
    public void setSaveDirectory ( String saveDirectory )
    throws java.io.IOException
        {
        if ( saveDirectory != null && !saveDirectory.equals("") ) {
            this.saveDirectory = saveDirectory;
            dir     = new File( this.saveDirectory );
            // Check saveDirectory is truly a directory
            if ( !dir.isDirectory() ) {
                dir.mkdir();
            } else {
                // Check saveDirectory is writable
                if (!dir.canWrite())
                    throw new IllegalArgumentException("Not writable: " + saveDirectory);
            }
        } else {
            this.saveDirectory = saveDirectory;
        }
        File fo_isdir = new File ( saveDirectory );
        if ( !fo_isdir.isDirectory() ) {
            //String delimiter = System.getProperty("file.separator");
            //String makeDir   = saveDirectory.substring ( saveDirectory.lastIndexOf ( delimiter ) + 1 );
            File fo_mkdir = new File ( saveDirectory );
            fo_mkdir.mkdir();
        }
    }

    /**
    * 저장 디렉토리를 String 형태로 반환합니다.
    * @return java.lang.String
    */

    public String getSaveDirectory () {
        return this.saveDirectory;
    }

    /**
    * 출력 여부 설정, PrinterWriter값 설정
    * @param gubun 'Y'/ 'N' : 브라우저로 출력 여부.
    */
    public void setLogdispaly ( char gubun, PrintWriter out ) {
        this.logPrintY = gubun;
        if ( gubun == 'Y' )
        {
            this.oout = out;
        } else {
            this.oout = null;
        }
    }
    /**
    * 출력 여부 설정.
    * @param gubun 'Y'/ 'N' : 브라우저로 출력 여부.
    */
    public void setLogdispaly ( char gubun ) {
        this.logPrintY = gubun;
    }

    /**
    * 브라우저로 출력 여부 값 반환.
    * @param gubun 'Y'/ 'N' : 브라우저로 출력 여부.
    * @return character
    */
    public char getLogdispaly ( ) {
        return logPrintY;
    }

    public void Log ( String msg ) {
        if ( logPrintY == 'Y' ) {
            if ( oout != null ) {
                this.oout.println ( msg );
            }
            System.out.println ( msg );
        }
    }

    /**
    * FileUploadMultipart 생성자
    * @param request the servlet request
    * @param saveDirectory Upload 파일이 저장될 디렉토리
    * @exception IOException if the uploaded content is larger than 1 Megabyte
    * or there's a problem reading or parsing the request
    */
    public FileUploadMultipart ( HttpServletRequest request,
                               String saveDirectory) throws IOException {

        this(request, saveDirectory, DEFAULT_MAX_POST_SIZE);
    }

    /**
    * FileUploadMultipart 생성자
    * @param request the servlet request
    * @param 실행결과 화면 표시 여부
    * @exception IOException if the uploaded content is larger than 1 Megabyte
    * or there's a problem reading or parsing the request
    */
    public FileUploadMultipart ( HttpServletRequest request,
                               char displayYN) throws IOException {
        this(request, "", DEFAULT_MAX_POST_SIZE);
        setLogdispaly ( displayYN );
    }

    /**
    * FileUploadMultipart 생성자
    * @param request the servlet request
    * @param saveDirectory Upload 파일이 저장될 디렉토리
    * @param 실행결과 화면 표시 여부
    * @param PrintWriter
    * @exception IOException if the uploaded content is larger than 1 Megabyte
    * or there's a problem reading or parsing the request
    */
    public FileUploadMultipart ( HttpServletRequest request,
                               String saveDirectory, char displayYN, PrintWriter out ) throws IOException {
        this(request, saveDirectory, DEFAULT_MAX_POST_SIZE);
        setLogdispaly ( displayYN , out );
    }


    public FileUploadMultipart ( HttpServletRequest request,String saveDirectory, int maxPostSize, char displayYN, PrintWriter out ) throws IOException {
        this(request, saveDirectory, maxPostSize);
        setLogdispaly ( displayYN , out );
    }

    /**
    * FileUploadMultipart 생성자
    * @param request the servlet request
    * @param saveDirectory Upload 파일이 저장될 디렉토리
    * @param 실행결과 화면 표시 여부
    * @exception IOException if the uploaded content is larger than 1 Megabyte
    * or there's a problem reading or parsing the request
    */
    public FileUploadMultipart ( HttpServletRequest request,
                               String saveDirectory, char displayYN) throws IOException {
        this(request, saveDirectory, DEFAULT_MAX_POST_SIZE);
        setLogdispaly ( displayYN );
    }

    /**
    * FileUploadMultipart 생성자
    * 저장 디렉토를 지정하지 않고 FileUploadMultipart 객체를 생성할경우에는 반드시
    * SaveDirecotry를 Parameter를 맨 처음에 위치 시켜 파라메터를 넘겨 주어야 합니다.
    * parameter name : saveDirectory
    * ex ) <input type='hidden' name='SaveDirecotry' value='c:\저장디렉토리'>
    * @param request the servlet request
    * @exception IOException if the uploaded content is larger than 1 Megabyte
    * or there's a problem reading or parsing the request
    */
    public FileUploadMultipart ( HttpServletRequest request, char displayYN, PrintWriter out ) throws IOException {
        this(request, null, DEFAULT_MAX_POST_SIZE);
        setLogdispaly ( displayYN , out );
    }

    /**
    * FileUploadMultipart 생성자
    * @param request the servlet request
    * @param saveDirectory Upload 파일이 저장될 디렉토리
    * @param maxPostSize Upload 파일의 최대 크기
    * @exception IOException if the uploaded content is larger than value of maxPostSize Megabyte
    * or there's a problem reading or parsing the request
    */

    public FileUploadMultipart(HttpServletRequest request,
                          String saveDirectory,
                          int maxPostSize) throws IOException {
        // Sanity check values
        if (request == null)
          throw new IllegalArgumentException("request cannot be null");

        setSaveDirectory ( saveDirectory );

        if (maxPostSize <= 0) {
          throw new IllegalArgumentException("maxPostSize must be positive");
        }

        // Save the request, and max size
        req     = request;
        maxSize = maxPostSize;

        Log ( " \n<B>******************** 생성자로 부터 readRequest () 호출 ********************</B> \n<BR>");
//      readRequest();
    }


    /**
    * FileUploadMultipart 생성자
    * javax.servlet.ServletRequest
    */
    public FileUploadMultipart(ServletRequest request,
                          String saveDirectory) throws IOException {
        this((HttpServletRequest)request, saveDirectory);
    }

    /**
    * FileUploadMultipart 생성자
    * javax.servlet.ServletRequest
    */
    public FileUploadMultipart(ServletRequest request,
                          String saveDirectory,
                          int maxPostSize) throws IOException {
//        this((HttpServletRequest)request, saveDirectory, maxPostSize);
    }

    /**
    * multipart/form-data 에 대한 정보를 읽어 옵니다.
    *
    * @exception IOException if the uploaded content is larger than
    * <tt>maxSize</tt> or there's a problem parsing the request
    */
    public void readRequest() throws IOException {
        // Check the content type to make sure it's "multipart/form-data"
        // Access header directly to work around WebSphere 2.x oddity
        // 헤더 정보를 통해 multipart 폼 데이터인지를 확인합니다.
        String type = req.getHeader("Content-Type");
        if (type == null ||
            !type.toLowerCase().startsWith("multipart/form-data")) {
            throw new IOException("Posted content type isn't multipart/form-data");
        }
        Log ( " <B> ==== Start == 헤더로 부터 얻어 지는 정보 =============== </B> \n<BR>");
        Log ( " type 체크 : req.getHeader(\"Content-Type\")<B><font color='red'>:</font></B> " + type + "\n<BR>");
        // Check the content length to prevent denial of service attacks
        // 전송된 정보의 크기가 최대 크기 이상인지 확인 합니다.
        int length = req.getContentLength();
        if (length > maxSize) {
            throw new IOException("Posted content length of " + length +
                                " exceeds limit of " + maxSize);
        }
        Log ( " content길이 : req.getContentLength()<B><font color='red'>:</font></B> \n<BR>");

// 비교 //
// enctype 을 default 로 넘겼을경우의 값.
//      request.getContentLength() : 53
//      request.getHeader("Content-Type") : application/x-www-form-urlencoded
// enctype 을 multipart/form-data 으로 넘겼을경우의 값.
//      request.getContentLength() : 260
//      request.getHeader("Content-Type") : multipart/form-data; boundary=---------------------------7d03bd1e14044a

        // boundary 값을 읽어 옵니다.
        // boundary 값에 대한 올바른 형식 아래와 같습니다.
        // "------------------------12012133613061"

        String boundary = extractBoundary(type);
        if (boundary == null) {
            throw new IOException("Separation boundary was not specified");
        }
        Log ( " <B>Header</B>로 부터 <B>boundary</B> 값 체크<B><font color='red'>:</font></B> " + boundary + "\n<BR>");
        Log ( " <B> ==== End == 헤더로 부터 얻어 지는 정보 =============== </B> " + type + "\n<BR>");

        // Construct the special input stream we'll read from
        // FileUploadStreamHandler in 인스턴스는
        // ServletInputStream 멤버 변수를 포함하고 있다.
        // 이 클래스를 이용해서 ServletInputStream 에 접근한다고 생각하면 됩니다.
        FileUploadStreamHandler in = new FileUploadStreamHandler ( req.getInputStream(), length );

        // ServletInputStream을 이용해 첫 라인을 읽어들입니다.
        // 첫라인은 boundary 값이 있습니다.
        // 읽어라.
        // Read the first line, should be the first boundary
        String line = in.readLine();
        if ( line == null ) {
            throw new IOException("Corrupt form data: premature ending");
        }
        Log ( " <B>ServletInputStream 첫번째</B> 줄 읽기<B><font color='red'>:</font></B> " + line + "\n<BR>");

        // Verify that the line is the boundary
        // boundary 값이 있는지 검사 합니다.
        if ( !line.startsWith(boundary) ) {
          throw new IOException("Corrupt form data: no leading boundary");
        }
        Log ( " 바로 위에서 읽은 데이터에 boundary 값 == : Header로 부터 boundary 값 비교<B><font color='red'>:</font></B> " + line.startsWith(boundary) + "\n<BR>");

        Log ( " <H2>여기까지는 한번만 수행되고 아래 항목 부터는 반복되는 수행을 하면서 Stream에 존재하는 값들을 저장합니다.</H2> \n");

        // Now that we're just beyond the first boundary, loop over each part
        // 다음 그 다음 계속 파라메터가 존재할 동안 루프를 돌면서.
        //
        boolean done = false;
        while (!done) {
          Log ( " \n<BR><B>******************** readNextPart === readRequest ()로 부터 호출 됨 ******************** </B> \n<BR>");
          done = readNextPart(in, boundary);
          Log ( " \n<B>******************** ********************************************** **************** </B> \n<BR>");
        }
    }



    /**
    * A utility method that reads an individual part.  Dispatches to
    * readParameter() and readAndSaveFile() to do the actual work.  A
    * subclass can override this method for a better optimized or
    * differently behaved implementation.
    *
    * @param in the stream from which to read the part
    * @param boundary the boundary separating parts
    * @return a flag indicating whether this is the last part
    * @exception IOException if there's a problem reading or parsing the
    * request
    *
    * @see readParameter
    * @see readAndSaveFile
    */
    @SuppressWarnings("rawtypes")
	protected boolean readNextPart(FileUploadStreamHandler in,
                         String boundary) throws IOException {
/* -- Start -- 두번째줄 일기 --------------------------------------------------*/
        // Read the first line, should look like this:
        // content-disposition: form-data; name="field1"; filename="file1.txt"
        String line = in.readLine();
        if ( line != null ) {
            Log ( " <B>ServletInputStream 두번째</B> 줄 읽기 <B><font color='red'>:</font></B> " + line + "\n<BR>");
            Log ( " <B>ServletInputStream 두번째</B> 줄 의 길이 <B><font color='red'>:</font></B> " + line.length() + "\n<BR>");
        }

        if (line == null) {
        // No parts left, we're done
            Log ( " 위에서 읽은 line == null 이면 여기서 끝 \n<BR>");
            return true;
        }
        else if (line.length() == 0) {
        // IE4 on Mac sends an empty line at the end; treat that as the end.
        // Thanks to Daniel Lemire and Henri Tourigny for this fix.
            Log ( " 위에서 읽은 line.length() == 0 이면 여기서 끝 \n<BR>");
            return true;
        }

        // Parse the content-disposition line
        String [] dispInfo     = extractDispositionInfo(line);
        String    disposition  = dispInfo[0];
        String    name         = dispInfo[1];
        String    filename     = dispInfo[2];

        Log ( " <B>두번째</B> 줄 정보로 부터 얻어진 disposition <B><font color='red'>:</font></B> " + disposition + "\n<BR>");
        Log ( " <B>두번째</B> 줄 정보로 부터 얻어진 name        <B><font color='red'>:</font></B> " + name        + "\n<BR>");
        Log ( " <B>두번째</B> 줄 정보로 부터 얻어진 filename    <B><font color='red'>:</font></B> " + filename    + "\n<BR>");

/* -- Start -- 세번째줄 읽기 --------------------------------------------------*/
        // Now onto the next line.  This will either be empty
        // or contain a Content-Type and then an empty line.
        // 세번째 라인을 읽어 들어 Content-Type을 얻어 냅니다.
        line = in.readLine();
        Log ( " <B>ServletInputStream 세번째</B> 줄 읽기 <B><font color='red'>:</font></B> " + line + "\n<BR>");
        if (line == null) {
            // No parts left, we're done
            return true;
        }

        // Content-Type을 추출 합니다.
        String contentType = extractContentType(line);
        Log ( " <B>세번째</B> 줄 정보로 부터 얻어진 contentType    <B><font color='red'>:</font></B> " + contentType + "\n<BR>");
        if (contentType != null) {
            // Eat the empty line
            line = in.readLine();
            if (line == null || line.length() > 0) {  // line should be empty
            throw new
                IOException("Malformed line after content type: " + line);
            }
        }
        else {
            // Assume a default content type
            contentType = "application/octet-stream";
        }

        int excuteCnt = 0;
        // Now, finally, we read the content (end after reading the boundary)
        /*-------  일반 파라메터의 경우  ----------- */
        if (filename == null) {
            // This is a parameter, add it to the vector of values
            Log ( " \n<B>====== <font color='blue'>readParameter</font> === readNextPart ()로 부터 호출 됨 ========== </B> \n<BR>");
            Log ( " \n<B>====== 일반적인 form Element의 경우 ========== </B> \n<BR>");
            String value = readParameter ( in, boundary );

            if (value.equals("")) {
                value = null;  // treat empty strings like nulls
            }
            
			Vector existingValues = (Vector)parameters.get(name);
            if (existingValues == null) {
                existingValues = new Vector();
                parameters.put(name, existingValues);
            }
            if( value != null ) {
                String aa =  new String(value.getBytes("UTF-8"),"UTF-8");
                System.out.println(" param add : " + name + " / " + aa);
                existingValues.addElement(aa);
            } else {
                existingValues.addElement(value);
            }
        }
        /*-------  file Upload의 경우    ----------- */
        else {
            /* This is a file */
            Log ( " \n<B>====== <font color='red'>readAndSaveFile</font> === readNextPart ()로 부터 호출 됨 ========== </B> \n<BR>");
            Log ( " \n<B>====== file Element의 경우 ========== </B> \n<BR>");
            String[] rtn = readAndSaveFile ( in, boundary, filename , name );

            Log ( " \n<B> change_filename+====== "  + rtn[1] + " ========== </B> \n<BR>");

            if (filename.equals(NO_FILE)) {
                files.put(name, new UploadedFile(null, null, null));
            }
            else {
                  files.put(name,new UploadedFile(dir.toString(), filename, Integer.parseInt(rtn[0]), contentType, rtn[1] ));
                //files.put(name,new UploadedFile(dir.toString(), filename, contentType));
            }
        }
        excuteCnt++;

       if ( dir == null && excuteCnt == 1 ) {
            if ( getParameter("p_savedir") == null || getParameter("p_savedir").equals("") ) {
                throw new IllegalArgumentException("저장할 경로가 명확하지 않습니다.");
            } else {
                setSaveDirectory ( getParameter("p_savedir") );
            }
        }
        return false;  // there's more to read
    }

    /** FileUploadMultipart of objects
    *  multipart/form-data의 boundary 값을 읽어 옵니다.
    * @param line the String
    * @return java.lang.String
    */
//    private String extractBoundary(String line) {
    public String extractBoundary(String line) {
        // Use lastIndexOf() because IE 4.01 on Win98 has been known to send the
        // "boundary=" string multiple times.  Thanks to David Wall for this fix.
        int index = line.lastIndexOf("boundary=");
        if (index == -1) {
          return null;
        }
        String boundary = line.substring(index + 9);  // 9 for "boundary="

        // The real boundary is always preceeded by an extra "--"
        boundary = "--" + boundary;

        return boundary;
    }

    private String[] extractDispositionInfo(String line) throws IOException {
        // Return the line's data as an array: disposition, name, filename
        String[] retval = new String[3];

        // Convert the line to a lowercase string without the ending \r\n
        // Keep the original line for error messages and for variable names.
        String origline = line;
        line = origline.toLowerCase();

        // Get the content disposition, should be "form-data"
        int start = line.indexOf("content-disposition: ");
        int end = line.indexOf(";");
        if (start == -1 || end == -1) {
          throw new IOException("Content disposition corrupt: " + origline);
        }
        String disposition = line.substring(start + 21, end);
        if (!disposition.equals("form-data")) {
          throw new IOException("Invalid content disposition: " + disposition);
        }

        // Get the field name
        start = line.indexOf("name=\"", end);  // start at last semicolon
        end = line.indexOf("\"", start + 7);   // skip name=\"
        if (start == -1 || end == -1) {
          throw new IOException("Content disposition corrupt: " + origline);
        }
        String name = origline.substring(start + 6, end);

        // Get the filename, if given
        String filename = null;
        start = line.indexOf("filename=\"", end + 2);  // start after name
        end = line.indexOf("\"", start + 10);          // skip filename=\"
        if (start != -1 && end != -1) {                // note the !=
            filename = origline.substring(start + 10, end);
            // The filename may contain a full path.  Cut to just the filename.
            int slash =
            Math.max(filename.lastIndexOf('/'), filename.lastIndexOf('\\'));
            if (slash > -1) {
            filename = filename.substring(slash + 1);  // past last slash
            }
            if (filename.equals("")) filename = NO_FILE; // sanity check
        }

        // Return a String array: disposition, name, filename
        retval[0] = disposition;
        retval[1] = name;
        retval[2] = filename;
        return retval;
    }

    // Extracts and returns the content type from a line, or null if the
    // line was empty.  Throws an IOException if the line is malformatted.
    //
    private String extractContentType(String line) throws IOException {
        String contentType = null;

        // Convert the line to a lowercase string
        String origline = line;
        line = origline.toLowerCase();

        // Get the content type, if any
        if (line.startsWith("content-type")) {
            int start = line.indexOf(" ");
            if (start == -1) {
                throw new IOException("Content type corrupt: " + origline);
            }
          contentType = line.substring(start + 1);
        }
        else if (line.length() != 0) {  // no content type, so should be empty
            throw new IOException("Malformed line after disposition: " + origline);
        }
        return contentType;
    }

    /**
    * A utility method that reads a single part of the multipart request
    * that represents a parameter.  A subclass can override this method
    * for a better optimized or differently behaved implementation.
    *
    * @param in the stream from which to read the parameter information
    * @param boundary the boundary signifying the end of this part
    * @return the parameter value
    * @exception IOException if there's a problem reading or parsing the
    * request
    */
    protected String readParameter( FileUploadStreamHandler in,
                                    String boundary ) throws IOException {

        StringBuffer sbuf = new StringBuffer();
        String line;
        // 한 라인 씩 읽어 들입니다.
        // 이것은 파라메터 값입니다.
        Log ( " <B>ServletInputStream 으로 부터 한 라인 씩</B> 읽기 <BR>");
        while ((line = in.readLine()) != null) {
            if (line.startsWith(boundary)) break;       // boundary 값을 만나면 루프를 종료 합니다.
            sbuf.append(line + "\r\n");  // add the \r\n in case there are many lines
            Log ( "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
            Log ( "<font color='red'>:</font></B> " + line + "\n<BR>");
        }

        if (sbuf.length() == 0) {
            return null;  // nothing read
        }

        sbuf.setLength(sbuf.length() - 2);  // cut off the last line's \r\n

        Log ( " <font color='blue'>readParameter</font> 에서 반환 되는 값 <B><font color='red'>:</font></B> " + sbuf.toString() + "\n<BR>");
        return sbuf.toString();             // no URL decoding needed
    }

    /**
    * A utility method that reads a single part of the multipart request
    * that represents a file, and saves the file to the given directory.
    * A subclass can override this method for a better optimized or
    * differently behaved implementation.
    *
    * @param in the stream from which to read the file
    * @param boundary the boundary signifying the end of this part
    * @param dir the directory in which to save the uploaded file
    * @param filename the name under which to save the uploaded file
    * @param name parameterName
    * @exception IOException if there's a problem reading or parsing the
    * request
    */
    protected String[] readAndSaveFile(FileUploadStreamHandler in,
                                 String boundary,
                                 String filename,
                                 String name ) throws IOException {
        String[] retval = new String[2];

        OutputStream os = null;     // Writing을 위한 준비 단계입니다.
                                    // OutputStream 계열에서 최상위 오브젝트인 OutputStream의 인스턴스를 선언

        // A filename of NO_FILE means no file was sent, so just read to the
        // next boundary and ignore the empty contents
        // 파일이 올바르 지 않을 경우
        if (filename.equals(NO_FILE)) {
            os = new ByteArrayOutputStream();  // write to nowhere
            Log ( " 파일명이 올바르지 않을 습니다.. \n<BR>");
        }

        // A real file's contents are written to disk
        else {
            Log ( " 파일명이 올바릅니다.. \n<BR>");
            Log ( " os에 지정된 경로에대해 FileOutStream을 할당합니다... \n<BR>");
            String extra = ( getParameter ( name + "_extra" ) == null ) ? "" : getParameter ( name + "_extra" );
            String change = ( getParameter ( name + "_change" ) == null ) ? "" : getParameter ( name + "_change" );

            if ( !change.equals("") ) {
                filename = getParameter ( name + "_change" );
                Log ( " <FONT color='yellow'>" + getParameter ( name + "_change" ) + "</FONT>\n<BR>");
                if ( !extra.equals("") ) {
                    filename = change + "." + extra;
                } else {
                    filename = change;
                }
            }

            String formatting = ( getParameter ( name + "_format" ) == null ) ? "" : getParameter ( name + "_format" );
            String prefix     = ( getParameter ( name + "_prefix" ) == null ) ? "" : getParameter ( name + "_prefix" );
            Log ( " formatting1_name : " + name + "_format<BR>");
            Log ( " formatting1 : " + formatting + "<BR>");
            Log ( " prefix : " + prefix + "<BR>");

            if ( !formatting.equals("") ) {
                    System.out.println ( " formatting1 : " + formatting );
                if ( formatting.indexOf ("date-format:") == 0 ) {
                    formatting = formatting.substring(12);

                    java.text.SimpleDateFormat formatter = new java.text.SimpleDateFormat (formatting, java.util.Locale.KOREA);

                    formatting = formatter.format(new java.util.Date());
                }
                if ( !extra.equals("") ) {
                    filename = prefix + formatting + "." + extra;
                } else {
                    String temExtraNm= "";
                    if ( filename.lastIndexOf( "." ) > 0 ) {
                        temExtraNm= filename.substring( filename.lastIndexOf( "." ) + 1 );
                        filename = prefix + Util.rPadding (formatting,17,"0")+ "." + temExtraNm;
                    } else {
                        filename = prefix + Util.rPadding (formatting,17,"0");
                    }
                }
            } else {
                filename = prefix + filename;
            }


            File f = new File(dir + File.separator + filename);
            //File f = new File(dir + File.separator + toKo(filename));
            os     = new FileOutputStream(f);
            Log ( " full file name : " + dir + File.separator + filename + "<BR>");

        }
        // 파일 Write를 위해 BufferedOutputStream를 이용하기위한 준비
        BufferedOutputStream out = new BufferedOutputStream(os, 8 * 1024); // 8K

        byte[] bbuf = new byte[100 * 1024];  // 100K 만큼의 byte Array 를 잡습니다.
        int result;
        int totSize = 0;

        String line;

        // ServletInputStream.readLine() has the annoying habit of
        // adding a \r\n to the end of the last line.
        // Since we want a byte-for-byte transfer, we have to cut those chars.

        // ServletInputStream 의 readLine()은 line의 맨끝에 \r\n의 값이 더해져있습니다.
        // '1' 이라는 글자 하나로 이루어진 line을 읽어 들인 byte는 3byte입니다.
        // 여기서 반환되는 int 값은 읽어들인 바이트의 크기 입니다.
        // 한줄씩 일어서 100K의 byte Array 할당합니다.

        boolean rnflag = false; // 개행문자 플래그

        while ((result = in.readLine(bbuf, 0, bbuf.length)) != -1) {

          // Check for boundary
          // reault가 2보다 커야 하는 이유는 각 line마다 \r\n(LF,CR)값이 존재하기
          // CR : \r : carriage return  : 줄의 맨 앞으로 위치.: ASC ::> 13
          // LF : \n : line feed        : 개행 문자열         : ASC ::> 10

            if ( result > 2 && bbuf[0] == '-' && bbuf[1] == '-' ) { // quick pre-check
                line = new String(bbuf, 0, result, "UTF-8");
                if (line.startsWith(boundary)) break;   // boundary 값을 만나면 수행을 종료 합니다.
            }

            Log ( " line data Reading -- \n<BR>");
            Log ( " in.readLine(bbuf, 0, bbuf.length) <B><font color='red'>:</font></B> " + result + " byte를 읽어 들입니다.\n<BR>");
            // Are we supposed to write \r\n for the last iteration?
            totSize += result;
            if ( rnflag ) {
                out.write('\r'); out.write('\n');
                rnflag = false;
            }
            // Write the buffer, postpone any ending \r\n
            if (result >= 2 &&
                bbuf[result - 2] == '\r' &&
                bbuf[result - 1] == '\n') {
                out.write(bbuf, 0, result - 2);  // skip the last 2 chars
                rnflag = true;  // make a note to write them on the next iteration
            }
            else {
                out.write(bbuf, 0, result);
            }
        }
        out.flush();
        out.close();
        os.close();
        Log ( " \n<B>====== <font color='red'>file Upload 완료.</font> ============= </B> \n<BR>");
        retval[0] = "" + totSize;
        retval[1] = filename;
        return retval;
    }

    //한글 입력을 위한 메소드를 구현합니다.
    public static String toKo(String str){
        try{
            if(str == null) return null;
                return new String (str.getBytes("8859_1"),"KSC5601");
            }//try 닫기
        catch(UnsupportedEncodingException ex){
            ex.printStackTrace();
            return "";
        }//chatch 닫기
    }//toKo닫기

///////////////////////////////// 정보 추출을 위한 클래스  /////////////////////////////////

    /**
    * Returns the names of all the parameters as an Enumeration of
    * Strings.  It returns an empty Enumeration if there are no parameters.
    *
    * @return the names of all the parameters as an Enumeration of Strings
    */
    @SuppressWarnings("rawtypes")
	public Enumeration getParameterNames() {
    return parameters.keys();
    }

    /**
    * Returns the names of all the uploaded files as an Enumeration of
    * Strings.  It returns an empty Enumeration if there are no uploaded
    * files.  Each file name is the name specified by the form, not by
    * the user.
    *
    * @return the names of all the uploaded files as an Enumeration of Strings
    */
    @SuppressWarnings("rawtypes")	
    public Enumeration getFileNames() {
    return files.keys();
    }

    /**
    * Returns the value of the named parameter as a String, or null if
    * the parameter was not sent or was sent without a value.  The value
    * is guaranteed to be in its normal, decoded form.  If the parameter
    * has multiple values, only the last one is returned (for backward
    * compatibility).  For parameters with multiple values, it's possible
    * the last "value" may be null.
    *
    * @param name the parameter name
    * @return the parameter value
    */
    @SuppressWarnings("rawtypes")
    public String getParameter(String name) {
        try {
          Vector values = (Vector)parameters.get(name);
          if (values == null || values.size() == 0) {
            return null;
          }
          String value = (String)values.elementAt(values.size() - 1);
          return value;
        }
        catch (Exception e) {
          return null;
        }
    }

    // 새로 생성
    @SuppressWarnings("rawtypes")
    public void setParameter(String name, String value) {
        try {
          if (name != null) {
            Vector existingValues = (Vector)parameters.get(name);
            if (existingValues == null) {
                existingValues = new Vector();
                parameters.put(name, existingValues);
            }
            existingValues.addElement(value);              
          }
        } catch (Exception e) {

        }
    }
    @SuppressWarnings("rawtypes")
    public String getFileName(String name) {
        try {
          Vector values = (Vector)parameters.get(name);
          if (values == null || values.size() == 0) {
            return null;
          }
          String value = (String)values.elementAt(values.size() - 1);
          return value;
        }
        catch (Exception e) {
          return null;
        }
    }

    /**
    * Returns the values of the named parameter as a String array, or null if
    * the parameter was not sent.  The array has one entry for each parameter
    * field sent.  If any field was sent without a value that entry is stored
    * in the array as a null.  The values are guaranteed to be in their
    * normal, decoded form.  A single value is returned as a one-element array.
    *
    * @param name the parameter name
    * @return the parameter values
    */
    public String[] getParameterValues(String name) {
    try {
      @SuppressWarnings("rawtypes")
	Vector values = (Vector)parameters.get(name);
      if (values == null || values.size() == 0) {
        return null;
      }
      String[] valuesArray = new String[values.size()];
      values.copyInto(valuesArray);
      return valuesArray;
    }
    catch (Exception e) {
      return null;
    }
    }

    /**
    * Returns the filesystem name of the specified file, or null if the
    * file was not included in the upload.  A filesystem name is the name
    * specified by the user.  It is also the name under which the file is
    * actually saved.
    *
    * @param name the file name
    * @return the filesystem name of the file
    */
    public String getFilesystemName( String name ) {
        try {
          UploadedFile file = (UploadedFile)files.get(name);
          return file.getFilesystemName();  // may be null
        }
        catch (Exception e) {
          return null;
        }
    }

    public UploadedFile getUploadFile ( String name ) {
        try {
          UploadedFile file = (UploadedFile)files.get(name);
          return file;
        }
        catch (Exception e) {
          return null;
        }
    }

    /**
    *
    * @param name the file name
    * @return the ChangeFileName chFileName of the file
    */
    public String getChangeFileName( String name ) {
        try {
          UploadedFile file = (UploadedFile)files.get(name);
          return file.getChangeFileName();  // may be null
        }
        catch (Exception e) {
          return null;
        }
    }

    /**
    *
    * @param name the file name
    * @return the ChangeFileName chFileName of the file
    */
    public int getFileSize( String name ) {
        try {
          UploadedFile file = (UploadedFile)files.get(name);
          return file.getFileSize();  // may be null
        }
        catch (Exception e) {
          return 0;
        }
    }

    /**
    * Returns the content type of the specified file (as supplied by the
    * client browser), or null if the file was not included in the upload.
    *
    * @param name the file name
    * @return the content type of the file
    */
    public String getContentType(String name) {
    try {
      UploadedFile file = (UploadedFile)files.get(name);
      return file.getContentType();  // may be null
    }
    catch (Exception e) {
      return null;
    }
    }

    /**
    * Returns a File object for the specified file saved on the server's
    * filesystem, or null if the file was not included in the upload.
    *
    * @param name the file name
    * @return a File object for the named file
    */
    public File getFile(String name) {
    try {
      UploadedFile file = (UploadedFile)files.get(name);
      return file.getFile();  // may be null
    }
    catch (Exception e) {
      return null;
    }
    }
}
