package com.entropykorea.ewire;


public class eWirePacket extends eWirePacketStruct {

	public eWirePacket(){
		super();
	}
	
	public eWirePacket( String userid, String command, String instruction, byte[] param ){
		super();
		setPacket( userid, command, instruction, param );
	}
	
	public void setPacket( String userid, String command, String instruction, byte[] param ){
		super.setUserId( userid );
		super.setCommand( command );
		super.setInstruction( instruction );
		setParam( param, 1, 1 );
		makePacket();
	}
	
	public void setParam( byte[] param, int start, int end ){
		super.setData( param );
		super.setTotalPacket( start );
		super.setCurrentPacket( end );
		makePacket();
	}

}
