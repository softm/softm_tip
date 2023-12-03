package com.kogas.dms.common;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.File;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;
import java.util.Calendar;
import java.util.StringTokenizer;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import javax.servlet.http.HttpServletRequest;

import org.apache.log4j.Logger;

public class Util {

	public  static Logger logger;
    static {
        logger = Logger.getLogger("kogas_logger");
    }
    
    // softm 2010년 10월 6일 수요일오후 1:16:55
    public static String stringJoin(String glue, String array[]) {
      String result = "";

      for (int i = 0; i < array.length; i++) {
        result += array[i];
        if (i < array.length - 1) result += glue;
        //System.out.print("glue : " + glue + "\n");
      }
      return result;
    }

    public static String[] stringSlice(int s, int e, String array[]) {
        String result = "";
        String[] a = new String[e-s];
        int ii = 0;
        //System.out.print("s , e , ss : " + s + " / " + e + " / " + array.length + "\n");
        //System.out.print("e-s+1 : "  + (e-s+1));
        for (int i = s; i < e; i++) {
        //for (int i = 0; i < 2; i++) {
            //System.out.print("I : " + i + "\n");
            //System.out.print("ARR1 : " + array[ii]+ " / " + i + " / " + ii + "\n");
        	a[ii] = array[i];
        	++ii;
        }
        //System.out.print("A sIZE : " + a.length+ "\n");
          
        return a;
      }
 

    /**
     * 일반 문자열을 16진수 문자열로 변경
     *
     * @param str
     * @return
     */
    public static String toHexString(String str) {
        StringBuffer sbuf = new StringBuffer();

        for(int i=0; i<str.length(); i++)
            sbuf.append( "0x" + Integer.toHexString(str.charAt(i)) );

        return sbuf.toString();
    }

    /**
     * 16진수 문자열을 일반 문자열로 변경
     * 
     * @param hexString
     * @return
     */
    public static String hexToString(String hexString) {
        Pattern p = Pattern.compile("(0x([a-fA-F0-9]{2}([a-fA-F0-9]{2})?))");
        Matcher m = p.matcher(hexString);

        StringBuffer buf = new StringBuffer();
        int hashCode = 0;
        while( m.find() ) {
            hashCode = Integer.decode("0x" + m.group(2));
            m.appendReplacement( buf, new String( Character.toChars( hashCode ) ) );
        }

        m.appendTail(buf);

        return buf.toString();
    }
    
/**
 * NL 을 BR 태그로 변환
 * @param  text 대상 문자
 * @return  대상 문자
 */
    public static String nl2br(String text) {
        return Util.replace("\r\n", "<br/>",text);
    }

/**
 * 문자열 치환
 * @param  patternStr 적용정규표현식
 * @param  replaceStr 치환
 * @param  text 적용문자
 * @return  치환된문자
 */
    public static String replace(String patternStr, String replaceStr, String text) {
        java.util.regex.Pattern pattern = java.util.regex.Pattern.compile(patternStr);
        java.util.regex.Matcher matcher = pattern.matcher(text);
        return matcher.replaceAll(replaceStr);
    }

    // TextArea에서 입력받은 < or > 를 특수문자로 변환
    public String html2spec(String comment)
    {
        if(comment == null){
            return "";
        }
        int length = comment.length();
        StringBuffer buffer = new StringBuffer();
        for (int i = 0; i < length; ++i)
        {
            String comp = comment.substring(i, i+1);
            if ("<".compareTo(comp) == 0)
                buffer.append("&lt;");
            else if (">".compareTo(comp) == 0)
                buffer.append("&gt;");
            else
                buffer.append(comp);
        }
        return buffer.toString();
    }

    // 스페이스를 &nbsp;로 변환
    public String spaceadd(String addstr)
    {
        if(addstr == null){
            return "";
        }
        int length = addstr.length();
        StringBuffer buffer = new StringBuffer();
        for (int k = 0; k < length; ++k){
            String comp = addstr.substring(k, k+1);
            if (" ".compareTo(comp) == 0){
                buffer.append("&nbsp;");
            }
            buffer.append(comp);
        }
        return buffer.toString();
    }

    // 날짜모양 변환
    public String dateformat(String date, String format )
    {
        String yyyy  = date.substring(0,4);
        String mm   = date.substring(4,6);
        String dd    = date.substring(6,8);
        String ret_date = null;

        if (format.equals("-")) {
           ret_date = yyyy + "-" + mm + "-" + dd;
        }
        else if (format.equals("/")) {
           ret_date = yyyy + "/" + mm + "/" + dd;
        }
        else if (format.equals(":")) {
           ret_date = yyyy + ":" + mm + ":" + dd;
        }
        return ret_date;
    }

///////////////////////// softm 추가 /////////////////////////////////
    public static boolean isNumber(String numValue) {
        String baseNum = "1234567890.";
        int ii=0;
        String ch1 = "";
        String _numValue = "";

        if ( numValue != null && !numValue.equals("") )
        {
            if ( numValue.substring(0,1).equals("-") || numValue.substring(0,1).equals("+") )
            {
                _numValue = numValue.substring( 1 );
            } else {
                _numValue = numValue;
            }
            int L = _numValue.length();
            for ( int i=0; i < L; i++) {
                ch1 = _numValue.substring(i,i+1);
                if ( baseNum.indexOf(ch1) < 0 ) { ii = 0; break; }
                else { ii=10; }
            }
        }
        if ( ii == 10 ) { return true; } else { return false; }
    }

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

    /** Directory의 존재 여부를 확인 합니다.
    * @param path the String
    * @return boolean true or false
    * @see
    */
    public static boolean isDirectory(String path) {
        File f = new File ( path );
        if ( f.isDirectory() ) {
            return true;
        } else {
            return false;
        }
    }

    /** 파일의 존재 여부를 확인 합니다.
    * @param path the String
    * @return boolean true or false
    * @see
    */
    public static boolean isFileExists (String path) {
        File f = new File ( path );
        if ( f.exists() && f.isFile() ) {
            return true;
        } else {
            return false;
        }
    }

    /** 파일을 생성합니다.
    * @param path the String    파일 경로
    * @param content the String 내용
    * @see
    */
    public static void fileWrite ( String path, String content ) {
        try
        {
            BufferedWriter fff = new BufferedWriter( new FileWriter( path ) );
            content = get8859ToKSC5601 ( content );
            fff.write(content, 0, content.length());
            fff.flush();
            fff.close();
        }
        catch ( IOException e){
            e.printStackTrace();
        }
    }

    /** 파일 내용을 읽어 옵니다.
    * @param path the String  파일 경로
    * @return content the String 파일 내용
    * @see
    */
    public static String fileRead ( String path ) {
        String _rtV = "";
        try {
            BufferedReader fff = new BufferedReader( new FileReader( path ) );
            String tmp;
            while ( ( tmp = fff.readLine() ) != null ) {
                _rtV += ( tmp + "\n" ) ;
            }
            fff.close();
        }
        catch ( IOException e){
            e.printStackTrace();
        }
        return _rtV;
    }

    /** 파일을 Copy 합니다.
    * @param fromPath the String 원본 파일 경로
    * @param toPath   the String 사본 파일 경로
    * @return Copy 성공 여부
    * @see
    */
    public static boolean fileCopy ( String fromPath, String toPath ) {
        boolean _rtV = false;
        String fromData = "";
        try {
            BufferedReader fromFile = new BufferedReader( new FileReader( fromPath ) );
            BufferedWriter toFile   = new BufferedWriter( new FileWriter( toPath   ) );
            String tmp;
            while ( ( tmp = fromFile.readLine() ) != null ) {
                fromData += ( tmp + "\n" ) ;
            }
            fromFile.close();

            toFile.write(fromData, 0, fromData.length());
            toFile.flush();
            toFile.close();
            _rtV = true;
        }
        catch ( IOException e){
            e.printStackTrace();
        }
        return _rtV;
    }

    /** 파일을 삭제 합니다.
    * @param path the String
    * @return boolean true or false
    * @see
    */
    public static boolean fileDelete (String path) {
        boolean _rtV = false;
        File f = new File ( path );
        if ( f.exists() ) {
            f.delete();
            _rtV = true;
        } else {
            _rtV = false;
        }
        return _rtV;
    }

    /** JavaScript Alert Message를 출력합니다.
    * @param str the Information String
    * @return String Information Message
    * @see
    */
    public static String Msg ( String str ) {
        String  _rtn = "";
        if ( str != null && !str.equals("") ) {
            _rtn = ( "alert ( '" + str + "');\n" );
        }
        return _rtn;
    }

    /** 한글 입력을 위한 메소드를 구현합니다.
    * 8859_1 ::> KSC5601
    * @param str the String
    * @return java.lang.String
    * @exception UnsupportedEncodingException
    */
    public static String toKo(String str){
        try{
            if(str == null) return null;
                return new String (str.getBytes("KSC5601"));
            }//try 닫기
        catch(UnsupportedEncodingException ex){
            ex.printStackTrace();
            return "";
        }//chatch 닫기
    }//toKo닫기

    /** 한글 입력을 위한 메소드를 구현합니다.
    * Euc-kr로 변환
    * @param str the String
    * @return java.lang.String
    * @exception UnsupportedEncodingException
    */
    public static String toEucKr(String data)   {
        try {
            return new String(data.getBytes("euc-kr"));
        }catch(Exception e) {
            e.printStackTrace();
            return data;
        }
    }
    public static String to8859(String data)   {
        try {
            return new String(data.getBytes("ISO-8859-1"));
        }catch(Exception e) {
            e.printStackTrace();
            return data;
        }
    }

    /**
     * EUC-KR encoding을 8859_1 encoding으로 바꿀 때 사용.
     */
    public static String getEucKrTo8859(String str) {
        byte[] b;
        String estr;

        if (str == null) return null;

        try {
            b = str.getBytes("euc-kr");
            estr = new String(b, "8859_1");
        } catch (IOException e) {
            return str;
        }
            return estr;
    }

    /**
     * KSC5601 encoding을 8859_1 encoding으로 바꿀 때 사용.
     */
    public static String getKSC5601To8859(String str) {
        byte[] b;
        String estr;

        if (str == null) return null;

        try {
            b = str.getBytes("KSC5601");
            estr = new String(b, "8859_1");
        } catch (IOException e) {
            return str;
        }
            return estr;
    }

    /** 한글 입력을 위한 메소드를 구현합니다.
    * 8859_1 ::> KSC5601
    * @param str the String
    * @return java.lang.String
    * @exception UnsupportedEncodingException
    */
    public static String get8859ToKSC5601(String str){
        byte[] b;
        String estr;

        if (str == null) return null;

        try {
            b = str.getBytes("8859_1");
            estr = new String(b, "KSC5601");
        } catch (IOException e) {
            return str;
        }
            return estr;
//            return str;

    }//toKo닫기

    /** 한글 입력을 위한 메소드를 구현합니다.
    * 8859_1 ::> KSC5601
    * @param str the String
    * @return java.lang.String
    * @exception UnsupportedEncodingException
    */
    public static String get8859ToEucKr(String str){
        byte[] b;
        String estr;

        if (str == null) return null;

        try {
            b = str.getBytes("8859_1");
            estr = new String(b, "EUC_KR");
        } catch (IOException e) {
            return str;
        }
            return estr;

    }//toKo닫기

    public static String strTranslate(String s) {
        if ( s == null ) return null;
        StringBuffer buf = new StringBuffer();
        char[] c = s.toCharArray();
        int len = c.length;
        for ( int i=0; i < len; i++) {
//            if      ( c[i] == '&' ) buf.append("&amp;");
            //if      ( c[i] == '<' ) buf.append("&lt;");
            //else if ( c[i] == '>' ) buf.append("&gt;");
            if      ( c[i] == '\"') buf.append("&quot;");
            else if ( c[i] == '"' ) buf.append("&quot;");
            else if ( c[i] == '\'') buf.append("&#039;");
            //else if ( c[i] == ' ' ) buf.append("&nbsp; ");
            //else if ( c[i] == '\n') buf.append("\n<BR>");
            //else if ( c[i] == '\t') buf.append("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
            else buf.append(c[i]);
        }
        return buf.toString();
    }

    public static String strToHtmlStr(String s) {
        if (s == null) s = "";
        s = s.replace("\'","&#39;").replace("\"","&quot;");
        return s;
    }

    /**
    * 문자열을 교체합니다.
    *
    * @param src the String 소스 String
    * @param delim the String 찾을   String
    * @param br the String    교제될 String
    * @return String
    */

    public static String strReplace(String src, String delim, String br) {
        if (src == null || delim == null || br == null) {
            return null;
        }

        if (src.trim().length() == 0 || delim.length() == 0 || br.trim().length() == 0) {
            return null;
        }

        StringBuffer buffer = new StringBuffer();
        java.util.StringTokenizer st = new java.util.StringTokenizer(src, delim);
        while (st.hasMoreTokens()) {
            buffer.append(st.nextToken()).append(br);
        }
        return buffer.toString();
    }

    /**
    * Method Summary 부분(설명 여기다 쓰면된다.)
    *
    * @param s the String
    * @return byte []
    * @exception UnsupportedEncodingException if String is null
    */
    public static byte [] getBytesArray(String s) {
        byte _rtV[] = null;
        try {
            _rtV = get8859ToKSC5601(s).getBytes("ksc5601");
        }
        catch (UnsupportedEncodingException e){ }

        return _rtV;
    }

    public static String[] split ( String str, String delim )
    {
        StringTokenizer token = new StringTokenizer(str, delim);
        String [] rtn = new String[token.countTokens()];
        int i=0;
        while(token.hasMoreTokens()) {
            String t = token.nextToken();
            rtn[i] = t;
            i++;
        }
        return rtn;
    }

    /**
     *
     * For example, String time = Utility.getDateFormatString("yyyy-MM-dd HH:mm:ss");
     *
     * @param java.lang.String pattern  "yyyy, MM, dd, HH, mm, ss and more"
     * @return formatted string representation of current day and time with  your pattern.
     */
    public static String getDateFormatString(String pattern) {
        java.text.SimpleDateFormat formatter = new java.text.SimpleDateFormat (pattern, java.util.Locale.KOREA);
        String dateString = formatter.format(new java.util.Date());
        return dateString;
    }

    /**
    * Method Summary 날짜에 특정 필드를 더한 String을 반환
    * Utility.getDateAdd("20020317231415", "DATE" , 15)
    * @param datetimestamps the String 년 월 일 시 분 초 ( 20020317231415 )
    * @param field :  "YEAR"  ,"MONTH" ,"DATE"  ,"HOUR"  ,"MINUTE","SECOND"
    * @param addValue 더하거나 뺄값.
    * @return String
    */
    public static String getDateAdd(String datetimestamps, String field, int addValue ) {
        String _rtV = "";
        Calendar day = Calendar.getInstance();
        int year    =   Integer.parseInt ( datetimestamps.substring (0 , 4) );
        int month   =   Integer.parseInt ( datetimestamps.substring (4 , 6) );
        int date    =   Integer.parseInt ( datetimestamps.substring (6 , 8) );
        int hour    =   Integer.parseInt ( datetimestamps.substring (8 ,10) );
        int minute  =   Integer.parseInt ( datetimestamps.substring (10,12) );
        int second  =   Integer.parseInt ( datetimestamps.substring (12,14) );
        day.set( year, month - 1, date, hour, minute, second );
        //fromDay.add( 2000, 12 - 1, 10, 11, 22, 23 );
        if ( field != null && !field.equals ("") ) {
            if ( field.equals ( "YEAR"  ) ) { day.add(Calendar.YEAR,        addValue) ; }
            else if ( field.equals ( "MONTH" ) ) { day.add(Calendar.MONTH,       addValue) ; }
            else if ( field.equals ( "DATE"  ) ) { day.add(Calendar.DATE,        addValue) ; }
            else if ( field.equals ( "HOUR"  ) ) { day.add(Calendar.HOUR_OF_DAY, addValue) ; }
            else if ( field.equals ( "MINUTE") ) { day.add(Calendar.MINUTE,      addValue) ; }
            else if ( field.equals ( "SECOND") ) { day.add(Calendar.SECOND,      addValue) ; }
            String tmp_year   = "" + day.get(Calendar.YEAR        )   ;
            String tmp_month  = "" + ( day.get(Calendar.MONTH       ) + 1 );
            String tmp_date   = "" + day.get(Calendar.DATE        )   ;
            String tmp_hour   = "" + day.get(Calendar.HOUR_OF_DAY )   ;
            String tmp_minute = "" + day.get(Calendar.MINUTE      )   ;
            String tmp_second = "" + day.get(Calendar.SECOND      )   ;
            _rtV   += ( tmp_year.length  () < 4 ) ? "0" + tmp_year   : tmp_year  ;
            _rtV   += ( tmp_month.length () < 2 ) ? "0" + tmp_month  : tmp_month ;
            _rtV   += ( tmp_date.length  () < 2 ) ? "0" + tmp_date   : tmp_date  ;
            _rtV   += ( tmp_hour.length  () < 2 ) ? "0" + tmp_hour   : tmp_hour  ;
            _rtV   += ( tmp_minute.length() < 2 ) ? "0" + tmp_minute : tmp_minute;
            _rtV   += ( tmp_second.length() < 2 ) ? "0" + tmp_second : tmp_second;
        } else {
            _rtV = datetimestamps;
        }
        return _rtV;
    }

    /**
    * Method Summary 시작일과 종료일의 차이를 '일'로 반환합니다.
    * Utility.getDateAdd("20020317231415", "DATE" , 15)
    * @param curDate the String 년 월 일 시 분 초 ( 20020317231415 ) : 시작일
    * @param targetDate the String 년 월 일 시 분 초 ( 20020317231415 ) :  종료일
    * @return String
    */
    @SuppressWarnings("unused")
	public static String getDateBetween( String curDate, String targetDate ) {

        String pCurrent   = curDate;
        String pTarget    = targetDate;
        String _rtV       = "";
        int curYear   = 0;
        int curMonth  = 0;
        int curDay    = 0;
        int curHour   = 0;
        int curMinute = 0;
        int tarYear   = 0;
        int tarMonth  = 0;
        int tarDay    = 0;
        int tarHour   = 0;
        int tarMinute = 0;

        if ((pCurrent != null && !("").equals(pCurrent)) && (pTarget != null && !("").equals(pTarget))) {
            curYear    = new Integer(pCurrent.substring(0,4)).intValue();
            curMonth   = new Integer(pCurrent.substring(4,6)).intValue();
            curDay     = new Integer(pCurrent.substring(6,8)).intValue();
            curHour    = new Integer(pCurrent.substring(8,10)).intValue();
            curMinute  = new Integer(pCurrent.substring(10,12)).intValue();

            tarYear    = new Integer(pTarget.substring(0,4)).intValue();
            tarMonth   = new Integer(pTarget.substring(4,6)).intValue();
            tarDay     = new Integer(pTarget.substring(6,8)).intValue();
            tarHour    = new Integer(pTarget.substring(8,10)).intValue();
            tarMinute  = new Integer(pTarget.substring(10,12)).intValue();

            Calendar cal1 = Calendar.getInstance();
            cal1.set(curYear, curMonth-1, curDay,curHour,curMinute);
            long date1InMsecs = cal1.getTime().getTime();

            Calendar cal2 = Calendar.getInstance();
            cal2.set(tarYear, tarMonth-1,tarDay,tarHour,curMinute);
            long date2InMsecs = cal2.getTime().getTime(); // milisecond 1/1000초를 리턴 (1000*60*60*24)

//타겟이 몇일 남은 것으로 표시하기 위해 (양수표시:타겟이 큰수이다).
            Long LV = new Long ( (date2InMsecs-date1InMsecs)/(1000*60*60*24) ) ;
            _rtV = LV.toString ();
        } else _rtV = "0";

        return _rtV;
    }

    /**
    * Method Summary 메일을 발송합니다.
    * @param curDate the String 년 월 일 시 분 초 ( 20020317231415 ) : 시작일
    * @param targetDate the String 년 월 일 시 분 초 ( 20020317231415 ) :  종료일
    * @return String
    */
/*
    public static void sendMail(String from, String fromName, String to, String toName, String content, String subject) {

System.out.println ( " from     : " + from    );
System.out.println ( " fromName : " + fromName);
System.out.println ( " to       : " + to      );
System.out.println ( " toName   : " + toName  );
//System.out.println ( " content  : " + content );
System.out.println ( " subject  : " + subject );
//        String from     = request.getParameter("from");
//        String fromName = request.getParameter("fromName");
//        String to       = request.getParameter("to");
        if( from != null && fromName != null && to != null && content != null && subject != null ){

            PrintWriter pout   = null;
            PrintStream ps     = null;
            SmtpClient  mailer = null;
            String host        = "mail.bomul.com";
             try {
                String s_content  = content;//new String( content.getBytes("KSC5601"), "8859_1" );
                String s_subject  = subject;//new String( subject.getBytes("KSC5601"), "8859_1" );
//                response.setContentType("text/html");
//                pout = new PrintWriter(new OutputStreamWriter(response.getOutputStream()));

                // 메일 전송을 위한 SmtpClient() 생성 ()안에는  메일서버의 호스트명이 들어감.
                mailer = new SmtpClient (host);

                // SmtpClient의 객체에 보내는 사람의 메일 주소지정
                mailer.from(from);
                // SmtpClient의 객체에 받는 사람의 메일 주소지정
                mailer.to(to);

                // PrintStream()는 행분리 문자를 스트림에 쓸때 모든 출력 바이트열을 자동적으로 플러쉬하는 기능이 있다.
                // PrintStream()대신에 PrintWriter()을 사용하면 PrintWriter()보다 유니코드문자를 더 잘 지원함.
                //PrintWriter ps = mailer.startMessage();           //대체사용가능

                ps = mailer.startMessage();

                String fromstr = "\"보물섬\" <webmaster@bomul.com>";
                if(  fromName != null && !fromName.equals("") ){
                    fromstr = "\"" + fromName + "\"<" + from + ">";
                }

                String tostr = "\"\" <" + to+ ">";
                if(  toName != null && !toName.equals("") ){
                    tostr = "\"" + toName + "\"<" + to + ">";
                }

//From: "롱다리" <qking@netian.com>
//To: "홍길동" <s_noking@hanbat.chungnam.ac.kr>
//Subject: 메일 테스트
//Date: Wed, 23 Sep 1998 14:52:10 +0900
//MIME-Version: 1.0
//Content-Transfer-Encoding: 8bit
//X-Priority: 3
//X-MSMail-Priority: Normal
//X-Mailer: Microsoft Outlook Express 4.72.3155.0
//X-MimeOLE: Produced By Microsoft MimeOLE V4.72.3155.0
//Content-Type: text/plain; charset="euc-kr"

                //메일헤더에 출력
                ps.println("From: "     + fromstr       );
                ps.println("To: "       + tostr         );
                ps.println("Subject: "  + s_subject     );
                ps.println("Content-Type:text/html charset=\"euc-kr\"");
                ps.print("\r\n");
                ps.println(s_content);

                ps.close();
                mailer.closeServer();
                System.out.println( from + " 님이 " + to  + "에게 메일을 발송했습니다." );
             } catch (Exception e) {
                    System.out.println(e);
                   // response.sendError(response.SC_ACCEPTED,"Problem querying the database.");
             }
             finally
             {
                    if (ps != null) ps.close();
                    if (mailer != null) mailer = null;
             }
        }
    }
*/
    /**
    *<pre>
    * Null값을 Null String ("") 형태로 변환 합니다.
    *</pre>
    * @param data the String
    * @return java.lang.String
    */
    public static String fixNull(String data){
        if (data == null)
            return "";
        else
            return data;
    }
    /**
    *<pre>
    * Null값을 Null String val로 설정 합니다.
    *</pre>
    * @param data the String
    * @param val the String
    * @return java.lang.String
    */
    public static String fixNullToValue(String data, String val){
        if (data == null || (data!=null && data.equals("")) )
            return val;
        else
            return data;
    }
    /**
    *<pre>
    * White Character를 &nbsp로 변환 합니다.
    *</pre>
    * @param data the String
    * @return java.lang.String
    */
    public static String fixblank(String data){
        if (data == null || data.equals("") )
            return "&nbsp;";
        else
            return data;
    }

    /**
    *<pre>
    * White Character를 &nbsp로 변환 합니다.
    *</pre>
    * @param data 전체 문자열
    * @param limited 문자열을 잘라낼 끝 위치
    * @param etc 잘라낸 문자열 뒤에 붙일 문자열
    * @return java.lang.String
    */
    public static String truncate (String data,int limited, String etc ){
        if(data == null || data.equals("")) {
            data = "";
        } else {
            if(data.length() >= limited) {
                data = data.substring(0,limited) + etc;
            }
        }
        return data;
    }

    /**
    *<pre>
    * data : 1 , cipher : 4  값이 넘어오면
    * 0001을 반환합니다.
    *</pre>
    * @param data 숫자 코드 데이터
    * @param cipher 자리수
    * @return java.lang.String
    */
    public static String numCodeToStr (String data,int cipher){
        String  zeroStr ="";
        if(data == null) { data = ""; }

        for( int i=0; i<cipher-data.length();i++){
            zeroStr += "0";
        }
        data = zeroStr + data;
        return data;
    }

    public static String numCodeToStr (int intData,int cipher){
        String  zeroStr ="";
        String data = "" + intData;
        for( int i=0; i<cipher-data.length();i++){
            zeroStr += "0";
        }
        data = zeroStr + data;
        return data;
    }

    /**
    *<pre>
    *</pre>
    * @param num 숫자 코드 데이터
    * @param limit 자리수
    * @param chr  채울 문자
    * @return java.lang.String
    */
    public static String rPadding(String num, int limit, String chr) {
        String val = num;
        int to = 0;
        if ( val.length() < limit ) {
            to = limit - val.length();
        }
        for ( int t=0; t<to; t++) { val = (val + chr); }
        return val;
    }

    public static String lPadding(String num, int limit, String chr) {
        String val = num;
        int to = 0;
        if ( val.length() < limit ) {
            to = limit - val.length();
        }
        for ( int t=0; t<to; t++) { val = (chr + val); }
        return val;
    }

    public static String fileSize(String size) {
        String rtn;
        if ( Integer.parseInt(size) >= 1073741824 ) {
            rtn = Math.round ( Integer.parseInt(size) / 1073741824) + " GB";
        } else if ( Integer.parseInt(size) >= 1048576 ) {
            rtn = Math.round ( Integer.parseInt(size) / 1048576 ) + " MB";
        } else if ( Integer.parseInt(size) >= 1024 ) {
            rtn = Math.round ( Integer.parseInt(size) / 1024 ) + " KB";
        } else {
            rtn = size + " byte";
        }
        return rtn;
    }

    public static String cutString(String str, int limit, String conStr) {
        if (str == null || limit < 4) return str;

        int len = str.length();
        int cnt=0, index=0;

        while (index < len && cnt < limit) {
            if (str.charAt(index++) < 256) // 1바이트 문자라면...
                cnt++;     // 길이 1 증가
            else {
                cnt += 2;  // 길이 2 증가
            }
        }

        if (index < len && limit >= cnt )
        str = str.substring(0, index);
        else if(index < len && limit < cnt )
        str = str.substring(0, index-1);
        if ( len > limit ) str += conStr;
        return str;
    }

    public static String decoding(String str) throws Exception {
        if(str == null)
            return null;
        else {
            String inputString = str.trim();
            String decodingString = null;
            decodingString = new String(inputString.getBytes("8859_1"),"utf-8");
            return decodingString;
        }
    }

    public static String encoding(String str) throws Exception {
        if(str == null)
            return null;
        else {
            String inputString = str.trim();
            String decodingString = null;
            decodingString = new String(inputString.getBytes("utf-8"),"8859_1");
            return decodingString;
        }
    }

/**
 * 슬래쉬 넣기
 * @param  str 대상 문자
 * @return  대상 문자
 */
    public static String addslashes_mssql(String str) {
        return str.replace("'", "＇");
    }

    public static String stripslashes_mssql(String str) {
        return str.replace("＇", "'");
    }

    public String numberFormat(Object data) {
        return java.text.NumberFormat.getInstance().format(data);
    }


/**
 * 숫자에 , 넣기
 * @param  mn 숫자
 * @return  , 숫자
 */
    public static String getNumberFormat(Float mn) {
        //if (mn <= 0) return "-";
        //else
            return java.text.NumberFormat.getInstance().format(mn);
    }

/**
 * 숫자에 , 넣기
 * @param  mn 숫자
 * @return  , 숫자
 */
    public static String getNumberFormat(String ar) {
        Float f_nm = new Float(0.0);
        try {
            f_nm = new Float( Float.parseFloat(ar));
        }catch (Exception e){ }
        return getNumberFormat(f_nm);
    }

/**
 * 숫자에 , 넣기
 * @param  mn 숫자
 * @return  , 숫자
 */
    public static String getNumberFormat(int mn) {
        return java.text.NumberFormat.getInstance().format(mn);
    }

/**
 * 숫자에 , 넣기
 * @param  mn 숫자
 * @return  , 숫자
 */
    public static String filterFloat(String ar) {
        Float f_nm = new Float(0.0);
        try {
            f_nm = new Float( Float.parseFloat(ar));
        }catch (Exception e){ }
        return ""+f_nm.floatValue();
    }

    public static String filterInt(String ar) {
        Float f_nm = new Float(0.0);
        try {
            f_nm = new Float( Float.parseFloat(ar));
        }catch (Exception e){ }
        return ""+f_nm.intValue();
    }


/**
 * 문자열을 숫자로 강제 변환(변환오류시 0 이 반환됨)
 * @param  str 문자열
 * @return  변환된 숫자
 */
    public static int string2Int(String str) {
        try {
            return Integer.parseInt(str);
        } catch (Exception e) {
            return 0;
        }
    }

static final String EX = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_.!~*'()";


public static String encodeURIComponent(String input) throws Exception {

         int l = input.length();

         StringBuilder o = new StringBuilder(l * 3);

         for(int i=0; i < l; i++) {

             String e = input.substring(i,i+1);

             if(EX.indexOf(e)==-1) {

                 byte[] b = e.getBytes("utf-8");

                 o.append(getHex(b));

                 continue;

             }

             o.append(e);

         }

         return o.toString();

     }

public static String getHex(byte buf[]) {

         StringBuilder o = new StringBuilder(buf.length * 3);

         for(int i=0; i< buf.length; i++)

         {

             int n = (int) buf[i] & 0xff;

             o.append("%");

             if(n < 0x10)

                 o.append("0");

             o.append(Long.toString(n, 16).toUpperCase());

         }

         return o.toString();

     }



////////////////////////////////////////////////////////////////////////////////////////////////

	public static String getExtraName(String filename) {
	    return filename.substring( filename.lastIndexOf( "." ) + 1 );
	  }

	/**
	 * 브라우저 종류
	 * @param request
	 * @return
	 */
	public static String getBrowser(HttpServletRequest request) {
		String header = request.getHeader("User-Agent");
		if (header.indexOf("MSIE") > -1) {
			return "MSIE";
		} else if (header.indexOf("Chrome") > -1) {
			return "Chrome";
		} else if (header.indexOf("Opera") > -1) {
			return "Opera";
		}
		return "Firefox";
	}

	/**
	 * 다국어 파일명 처리
	 * @param filename
	 * @param browser
	 * @return
	 * @throws UnsupportedEncodingException
	 */
	public static String getFileNameByBrowser(String filename, String browser) throws UnsupportedEncodingException {
		String dispositionPrefix = "";
		String encodedFilename = null;
		if (browser.equals("MSIE")) {
			encodedFilename = URLEncoder.encode(filename, "UTF-8").replaceAll("\\+", "%20");
		} else if (browser.equals("Firefox")) {
			encodedFilename = "\"" + new String(filename.getBytes("UTF-8"), "8859_1") + "\"";
		} else if (browser.equals("Opera")) {
			encodedFilename = "\"" + new String(filename.getBytes("UTF-8"), "8859_1") + "\"";
		} else if (browser.equals("Chrome")) {
			StringBuffer sb = new StringBuffer();
			for (int i = 0; i < filename.length(); i++) {
				char c = filename.charAt(i);
				if (c > '~') {
					sb.append(URLEncoder.encode("" + c, "UTF-8"));
				} else {
					sb.append(c);
				}
			}
			encodedFilename = sb.toString();
		} else {
			throw new RuntimeException("Not supported browser");
		}
		return dispositionPrefix + encodedFilename;
	}	
}