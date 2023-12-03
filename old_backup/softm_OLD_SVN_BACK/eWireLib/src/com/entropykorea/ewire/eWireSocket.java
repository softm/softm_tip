package com.entropykorea.ewire;

import java.io.*;
import java.net.*;

public class eWireSocket {

	private Socket socket = null;
	private BufferedOutputStream bos = null;
	private BufferedInputStream bis = null;
	
	private String server_ip;
	private int server_port;

	private int SOCKET_TIMEOUT 	= 60000;	// 60 sec // 서버접속 타임아웃 millisecond
	private int RECEIVE_TIMEOUT	= 300000;	// 5 min // 패킷수신 타임아웃 millisecond
	
	private eWireError ewireerror = eWireError.NONE_ERROR;
	
	public eWireSocket( String ip, int port ){
		this.server_ip = ip;
		this.server_port = port;
	}
		
	public int connect(){
		int rtn = 0;
		
		socket = new Socket();
		SocketAddress socketAddress = new InetSocketAddress(server_ip, server_port);
		
		try {
			eWireLog.d("eWireSocket Connect...");
			socket.setSoTimeout(RECEIVE_TIMEOUT);			// InputStream에서 데이터읽을때의 timeout
			socket.connect(socketAddress, SOCKET_TIMEOUT);	// socket연결 자체에대한 timeout
			bis = new BufferedInputStream(socket.getInputStream());
			bos = new BufferedOutputStream(socket.getOutputStream());
		} catch (Exception e) {
			eWireLog.e("eWireSocket Can't connect to server!");
			rtn = 1;
			e.printStackTrace();
		}
		
		return rtn;
	}
		
	public int disconnect(){
		int rtn = 0;
		
		try {
			bis.close();
			bos.close();
			socket.close();
			eWireLog.d("eWireSocket Disconnect...");
		} catch (Exception e) {
			eWireLog.e("eWireSocket Can't disconnect to server!");
			rtn = 1;
			e.printStackTrace();
		} finally {
		}
		return rtn;
	}
	
	public boolean send( byte[] buf ){
		boolean rtn = true;
		int length = buf.length;
		
		eWireLog.d("eWireSocket Send...");
		
		try {
			bos.write(buf, 0, length);
			bos.flush();
		} catch (IOException e) {
			e.printStackTrace();
			eWireLog.e("eWireSocket Send failed!");
			rtn = false;
		}
		
		eWireLog.d("Send Length : "+length);
		return rtn;
	}
	
	public boolean send( eWirePacket ewirepacket ) {
		return send( ewirepacket.getPacketData() );
	}
	
	public boolean recv( byte[] buf, int length ) {
		
		eWireLog.d("eWireSocket Recv...");
		
		int read_size = 0;
		
		try {
			read_size = bis.read( buf );
		} catch (IOException e) {
			e.printStackTrace();
			eWireLog.e("eWireSocket Recv Failed!");
			read_size = -1;
			return false;
		}
		
		return true;
	}

	/*
	 * length 만큼 읽어옴 
	 */
	public boolean recvn( byte[] buf, int length ) {
		return recvn( buf, length, 0 );
	}

	public boolean recvn( byte[] buf, int length, int buf_start ) {
		
		eWireLog.d("eWireSocket RecvN...");
		
		int total_received = buf_start;
		int read_size = 0;
		int buffer_size = length;
		
		do {
			try {
				read_size = bis.read( buf, total_received, buffer_size );
			} catch (Exception e) {
				eWireLog.e("eWireSocket RecvN failed!");
				e.printStackTrace();
				read_size = -1;
			}
			if( read_size < 0 )
			{
				return false;
			}
			if( read_size > 0 )
			{
				total_received += read_size;
				buffer_size -= read_size;
			}
		}while( read_size > 0 && buffer_size > 0 );
		
		eWireLog.d("Recv Length : "+total_received);
		
		return true;
	}
	
	public boolean recv( eWirePacket ewirepacket ) {
		
		byte[] buf = new byte[9];
		byte[] buf_length = new byte[8];
		int length = 0;
		int length_recv = 0;
		
		// Stx(1) Length(8) 
		if( !recvn( buf, 9 ) ) {
			return false;
		}
		
		// length
		System.arraycopy(buf, 1, buf_length, 0, 8);
		try {
			String str_length = new String( buf_length ).trim();
			length = Integer.parseInt(str_length);
		} catch (NumberFormatException e) {
			length = 0;
			return false;
		}
		
		length_recv = length + 3;
		// Stx(1)+Length(8)+ length +Crc(2)+Etx(1)
		ewirepacket.PacketData = new byte[ length + 12 ];
		System.arraycopy(buf, 0, ewirepacket.PacketData, 0, 9); // Stx(1)+Length(8)
		
		if( !recvn( ewirepacket.PacketData, length_recv, 9 ) ) {
			return false;
		}
		
		// ewirepacket packetdata -> byte
		ewirepacket.parsePacket();
		
		return true;
	}
	
	public void setTimeout( int recv_timeout, int conn_timeout ){
		this.RECEIVE_TIMEOUT = recv_timeout;
		this.SOCKET_TIMEOUT = conn_timeout;
	}
		
}
