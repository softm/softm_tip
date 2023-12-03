package com.entropykorea.ewire;


import java.io.*;
import java.lang.reflect.*;
/*
 */
import java.util.*;

public class eWirePacketStruct {

	private static final String ENCODING = "KSC5601";
	
	public byte[] PacketData;		// 전체패킷

	// 패킷클래스 기본 구조
	protected byte[] Stx; 				// STX 1 0x20
	protected byte[] Length; 			// Length = Command + Instruction + UserID + TotPkNum + CurPkNum + Data : 8
	protected byte[] Command; 			// Command 1
	protected byte[] Instruction; 		// Instruction 30
	protected byte[] UserId; 			// UserID 30
	protected byte[] TotalPacket; 		// TotalPacket 5
	protected byte[] CurrentPacket; 	// CurrentPacket 5
	protected byte[] Data; 				// Data ?
	protected byte[] Crc; 				// CRC 2
	protected byte[] Etx; 				// ETX 1 0x30
	// 패킷클래스 기본 구조 끝
	
	public eWirePacketStruct() {
		this.Stx = new byte[1];
		this.Length = new byte[8];
		this.Command = new byte[1];
		this.Instruction = new byte[30];
		this.UserId = new byte[30];
		this.TotalPacket = new byte[5];
		this.CurrentPacket = new byte[5];
		// this.Data = ?
		this.Crc = new byte[2];
		this.Etx = new byte[1];
	}
	
	// PacketData
	public byte[] getPacketData() {
		return this.PacketData;
	}
	
	public void setPacketData( byte[] PacketData ) {
		this.PacketData = PacketData;
	}
	
	// Length
	public Integer getLength() {
		try {
			return Integer.parseInt(  new String( this.Length, ENCODING ).trim() );
		} catch (Exception e) {
			return 0;
		}
	}
	
	public Integer getDataLength() {
		int length = 0;
		try {
			length = Integer.parseInt(  new String( this.Length, ENCODING ).trim() );
		} catch (Exception e) {
			return 0;
		}
		
		return length - 71;
	}
	
	public void setLength( String Length ) {
		string2byte(Length, this.Length);
	}

	public void setLength( int Length ) {
		String temp = Integer.toString(Length);
		string2byte(temp, this.Length);
	}
	
	// Command
	public String getCommand() {
		String str;
		try {
			str = new String( this.Command, ENCODING ).trim();
		} catch (UnsupportedEncodingException e) {
			str = new String();
		}
		return str;
	}

	public void setCommand( String Command ) {
		string2byte(Command, this.Command);
	}

	// Instruction
	public String getInstruction() {
		String str;
		try {
			str = new String( this.Instruction, ENCODING ).trim();
		} catch (UnsupportedEncodingException e) {
			str = new String();
		}
		return str;
	}

	public void setInstruction( String Instruction ) {
		string2byte(Instruction, this.Instruction);
	}

	// UserId
	public String getUserId() {
		String str;
		try {
			str = new String( this.UserId, ENCODING ).trim();
		} catch (UnsupportedEncodingException e) {
			str = new String();
		}
		return str;
	}

	public void setUserId( String UserId ) {
		string2byte(UserId, this.UserId);
	}

	// TotalPacket
	public Integer getTotalPacket() {
		try {
			return Integer.parseInt(  new String( this.TotalPacket, ENCODING ).trim() );
		} catch (Exception e) {
			return 0;
		}	
	}

	public void setTotalPacket( Integer TotalPacket ) {
		String temp = Integer.toString(TotalPacket);
		string2byte(temp, this.TotalPacket);
	}

	// CurrentPacket
	public Integer getCurrentPacket() {
		try {
			return Integer.parseInt(  new String( this.CurrentPacket, ENCODING ).trim() );
		} catch (Exception e) {
			return 0;
		}	
	}

	public void setCurrentPacket( Integer CurrentPacket ) {
		String temp = Integer.toString(CurrentPacket);
		string2byte(temp, this.CurrentPacket);
	}
	
	// Data
	public byte[] getData() {
		return this.Data;
	}
	
	public String getDataString() {
		String str;
		try {
			str = new String( this.Data, ENCODING ).trim();
		} catch (UnsupportedEncodingException e) {
			str = new String();
		}
		return str;
	}

	public void setData( byte[] Data ) {
		this.Data = new byte[Data.length];
		System.arraycopy(Data, 0, this.Data, 0, Data.length);
	}
	
	public void setData( String Data ) {
		int len = Data.getBytes().length;
		this.Data = new byte[len];
		string2byte(Data, this.Data);
	}
		
	// crc
	private byte[] getCrc() {
		int crclength = this.PacketData.length - 4; // this.Stx.length + this.Crc.length + this.Etx.length
		byte[] crc_target = new byte[crclength];
		System.arraycopy(this.PacketData, 1, crc_target, 0, crc_target.length);
		byte[] crc_result = Crc16.CRC16_BigEndian(crc_target); // CRC16_MAKE(crc_target);

		return crc_result;
	}
	
	// for send
	private void setCrc() {
		byte[] crc_result = getCrc();
		
		this.Crc[0] = crc_result[0];
		this.Crc[1] = crc_result[1];
	}
	
	// for recv
	private boolean checkCrc() {
		byte[] crc_result = getCrc();
		
		if( this.Crc[0] != crc_result[0] || this.Crc[1] != crc_result[1] )
			return false;

		return true;
	}

	// value -> packetdata
	private int copyPacketData( byte[] value, int position ) {
		int len = value.length;
		System.arraycopy(value, 0, this.PacketData, position, len);
		return len;
	}
	
	// packetdata -> value
	private int copyValue( byte[] value, int position ) {
		int len = value.length;
		System.arraycopy(this.PacketData, position, value, 0, len);
		return len;
	}
	
	// byte -> packetdata
	public void makePacket(){
		int offset = 0;
		// Length 에 들어가는 길이 
//		int length = this.Command.length +
//					 this.Instruction.length +
//					 this.UserId.length +
//					 this.TotalPacket.length +
//					 this.CurrentPacket.length +
//					 this.Data.length ;
		int length = 71 + this.Data.length;
		setLength( length );
		// 패킷 전체 길이  
//		int packetlength = length + 
//				     this.Stx.length +
//				     this.Length.length +
//				     this.Crc.length +
//				     this.Etx.length ;
		int packetlength = 83 + this.Data.length;
		// Crc 체크 길이 
		//int crclength = length + this.Length.length;
		
		this.PacketData = new byte[packetlength];
		
		// Stx
		this.Stx[0] = 0x02;
		offset += copyPacketData( this.Stx, offset );
		// Length
		offset += copyPacketData( this.Length, offset );
		// Command
		offset += copyPacketData( this.Command, offset );
		// Instruction
		offset += copyPacketData( this.Instruction, offset );
		// UserId
		offset += copyPacketData( this.UserId, offset );
		// TotalPacket
		offset += copyPacketData( this.TotalPacket, offset );
		// CurrentPacket
		offset += copyPacketData( this.CurrentPacket, offset );
		// Data
		offset += copyPacketData( this.Data, offset );
		// Crc
		setCrc(); // crc16 
		offset += copyPacketData( this.Crc, offset );
		// Etx
		this.Etx[0] = 0x03;
		offset += copyPacketData( this.Etx, offset );
	}
	
	// packetdata -> byte
	public void parsePacket() {
		int offset = 0;
		int datalength = 0;
		// Stx
		offset += copyValue( this.Stx, offset );
		// Length
		offset += copyValue( this.Length, offset );
		// Command
		offset += copyValue( this.Command, offset );
		// Instruction
		offset += copyValue( this.Instruction, offset );
		// UserId
		offset += copyValue( this.UserId, offset );
		// TotalPacket
		offset += copyValue( this.TotalPacket, offset );
		// CurrentPacket
		offset += copyValue( this.CurrentPacket, offset );
		// Data
		datalength = getDataLength();
		this.Data = new byte[datalength];
		offset += copyValue( this.Data, offset );
		// Crc
		offset += copyValue( this.Crc, offset );
		// Etx
		offset += copyValue( this.Etx, offset );
	}
	
	public int checkPacket() {
		// check Stx
		if( this.Stx[0] != 0x02 )
			return 1;
		
		// check Etx
		if( this.Etx[0] != 0x03 )
			return 2;
		
		// check Crc
		if( !checkCrc() )
			return 3;
		
		// check Command 
		if( this.Command[0] == 'E' )
			return 4;
		
		return 0;
	}
	
	// string -> byte and space
	public void string2byte( String src, byte[] tar ) {
		byte[] temp;
		try {
			temp = src.getBytes(ENCODING);
		} catch (UnsupportedEncodingException e) {
			temp = new byte[0];
		}
		int temp_len = temp.length;
		int len = tar.length;
		
		for( int i=0 ; i<len ; i++ ) {
			if( temp_len > i )
				tar[i] = temp[i];
			else
				tar[i] = 0x20; // space
		}
	}
	
	
}
