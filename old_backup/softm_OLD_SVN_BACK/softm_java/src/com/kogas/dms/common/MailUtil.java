package com.kogas.dms.common;

import java.io.File;
import java.util.ArrayList;
import java.util.Date; 
import java.util.Properties; 

import javax.activation.DataHandler;
import javax.activation.FileDataSource;
import javax.mail.Message; 
import javax.mail.Session; 
import javax.mail.Transport; 
import javax.mail.internet.InternetAddress; 
import javax.mail.internet.MimeBodyPart; 
import javax.mail.internet.MimeMessage; 
import javax.mail.internet.MimeMultipart; 
import javax.mail.internet.MimeUtility;

public class MailUtil {
    private String mailHost   	= "172.19.5.20";							// Smtp 호스트 주소 (메일 보내려는 Host 주소) 
	//private String sendMailAdd 	= "sucktolha@hanmail.net";		// 보내는 메일 주소(지원팀 김상인차장) 

   /** 
     * @param mailTo 보낼 사용자 
     * @param mailSubject 제목 
     * @param mailContent 내용. 
     * @param addFileNm 첨부 파일 list (없을 경우 null) 
     */ 
    public void send(String mailFrom, String mailTo, String mailSubject, String mailContent){ 

        //Properties props = new Properties(); 
        Properties props = System.getProperties();
        props.put("mail.smtp.host", mailHost); 
        props.put("mail.debug", "true");
        //props.put("mail.smtp.auth", "false"); 
        props.put("mail.smtp.port", "25"); 
        props.put("type", "javax.mail.Session");
        props.put("auth", "Application"); 
        
        
        props.put("mail.smtp.stattls.enable", "true");
        props.put("mail.transport.protocol", "smtp"); 
        
        //props.put("mail.smtp.socketFactory.class", "javax.net.ssl.SSLSocketFactory"); 

        // smtp 서버 인증해야 할 경우 
        //Authenticator auth = new MailAuth(mailAccId, mailAccPwd); 

        Session session = Session.getInstance(props, null); // 인증 

        // 필요할 경우 true로 설정 debug 
        session.setDebug(false);    // 기본 false 

        // 메세지 만들기.. 
        try { 
            // 메세지 생성.
            MimeMessage msg = new MimeMessage(session); 

            // 보내는 사용
            msg.setFrom(new InternetAddress(mailFrom, mailFrom)); 

            //msg.setHeader("content-type", "text/html;charset=utf-8"); 
            msg.setHeader("content-type", "text/html;charset=utf-8"); 

            // 받는 사람 구분은 < 구분 자는 , >
            InternetAddress[] toAddress = InternetAddress.parse(mailTo); 
            msg.setRecipients(Message.RecipientType.TO, toAddress); 
            msg.setSubject(mailSubject, "UTF-8"); 
            msg.setSentDate(new Date()); 

            MimeMultipart mp = new MimeMultipart(); 

            // 내용 
            MimeBodyPart mbp1 = new MimeBodyPart(); 
            mbp1.setContent(mailContent, "text/html; charset=utf-8"); 
            
            //첨부파일
//            MimeBodyPart mbp = new MimeBodyPart();
//            FileDataSource fds = new FileDataSource("yongjin.zip");
//            mbp.setDataHandler(new DataHandler(fds));
//            mbp.setDisposition("attachment; filename=\"" + fds.getName() + "\"");
            
            mp.addBodyPart(mbp1); 
            msg.setContent(mp); 

            Transport transport = session.getTransport("smtp"); 
            Transport.send(msg);          // 메일 전송 

            transport.close(); 
        } catch (Exception e) { 
            e.printStackTrace(); 
        } 
        return; 
    }
    
    /** 
     * @param mailTo 보낼 사용자 
     * @param mailSubject 제목 
     * @param mailContent 내용. 
     * @param addFileNm 첨부 파일 list (없을 경우 null) 
     */ 
    public void send(String mailFrom, String mailTo, String mailSubject, String mailContent, ArrayList<File> addFile, ArrayList<String> addFileNm){ 

        //Properties props = new Properties(); 
        Properties props = System.getProperties();
        props.put("mail.smtp.host", mailHost); 
        props.put("mail.debug", "true");
        //props.put("mail.smtp.auth", "false"); 
        props.put("mail.smtp.port", "25"); 
        props.put("type", "javax.mail.Session");
        props.put("auth", "Application"); 
        
        
        props.put("mail.smtp.stattls.enable", "true");
        props.put("mail.transport.protocol", "smtp"); 
        
        //props.put("mail.smtp.socketFactory.class", "javax.net.ssl.SSLSocketFactory"); 

        // smtp 서버 인증해야 할 경우 
        //Authenticator auth = new MailAuth(mailAccId, mailAccPwd); 

        Session session = Session.getInstance(props, null); // 인증 

        // 필요할 경우 true로 설정 debug 
        session.setDebug(false);    // 기본 false 

        // 메세지 만들기.. 
        try { 
            // 메세지 생성.
            MimeMessage msg = new MimeMessage(session); 

            // 보내는 사용
            msg.setFrom(new InternetAddress(mailFrom, mailFrom)); 

            //msg.setHeader("content-type", "text/html;charset=utf-8"); 
            msg.setHeader("content-type", "text/html;charset=utf-8"); 

            // 받는 사람 구분은 < 구분 자는 , >
            InternetAddress[] toAddress = InternetAddress.parse(mailTo); 
            msg.setRecipients(Message.RecipientType.TO, toAddress); 
            msg.setSubject(mailSubject, "UTF-8"); 
            msg.setSentDate(new Date()); 

            MimeMultipart mp = new MimeMultipart(); 

            // 내용 
            MimeBodyPart mbp1 = new MimeBodyPart(); 
            mbp1.setContent(mailContent, "text/html; charset=utf-8"); 
            
            //첨부파일
            
            for(int i=0; i<addFile.size(); i++){
            	MimeBodyPart mbp = new MimeBodyPart();
            	FileDataSource fds = new FileDataSource(addFile.get(i));
            	mbp.setDataHandler(new DataHandler(fds));
            	mbp.setDisposition("attachment; filename=\"" + MimeUtility.encodeText(addFileNm.get(i)) + "\"");
            	mp.addBodyPart(mbp);
            }
            
            mp.addBodyPart(mbp1);
            
            msg.setContent(mp); 

            Transport transport = session.getTransport("smtp"); 
            Transport.send(msg);          // 메일 전송 

            transport.close(); 
        } catch (Exception e) { 
            e.printStackTrace(); 
        } 
        return; 
    }
}