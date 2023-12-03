package com.entropykorea.ewire;



/*
 * eWire
 */

public class eWire extends eWireSocket {

	// Environment.getExternalStorageDirectory().getAbsolutePath()+"/mpgas";
	// // /mnt/sdcard/mpgas
	// trans.zip

	private eWirePacket sendpacket = null; // send
	private eWirePacket recvpacket = null; // recv
	private eWirePacket senddatapacket = null; // send data
	private eWirePacket recvdatapacket = null; // recv data

	private eWireFile ewirefile = null;

	public static final int MODENONE = 0;
	public static final int MODEDOWN = 1;
	public static final int MODEUP = 2;
	private int currentmode = 0; // MODENONE,MODEDOWN,MODEUP
	
	private eWireError ewireerror = eWireError.NONE_ERROR;

	private String filename;

	public interface OnPublishProgress {
		void OnPublishProgress(Integer current, Integer total);
	}

	private OnPublishProgress callbackOnPublishProgress = null;

	public void setOnPublishProgress(OnPublishProgress callback) {
		callbackOnPublishProgress = callback;
	}

	public eWire(String ip, String port) {
		super(ip, Integer.parseInt(port)); // eWireSocket
	}

	public eWire(String ip, int port) {
		super(ip, port); // eWireSocket
	}

	public void setFilename(String filename) {
		this.filename = filename;
	}

	public String getFilename() {
		return this.filename;
	}

	public String getErrorMessage() {
		return this.ewireerror.getDesc();
	}
	
	public String getErrorMessageDetail() {
		return this.ewireerror.getDetail();
	}
	
	public String getErrorCode() {
		return this.ewireerror.getCode();
	}
	
	public String getParam() {
		if (recvpacket == null)
			return "";
		return recvpacket.getDataString();
	}
	
	public String getDataParam() {
		if( recvdatapacket == null)
			return "";
		return recvdatapacket.getDataString();
	}
	
	// send, recv, check
	private boolean trans( eWirePacket sendpacket, eWirePacket recvpacket, boolean checkresult ) {
		
		eWireParam ep_result = null;
		
		if (!send(sendpacket)) {
			ewireerror = eWireError.SEND_ERROR;
			return false;
		}

		if (!recv(recvpacket)) {
			ewireerror = eWireError.RECV_ERROR;
			return false;
		}

		// check packet 
		switch( recvpacket.checkPacket() ) {
		case 1: // stx
			ewireerror = eWireError.RECV2_ERROR;
			ewireerror.setDetail( "STX not match!");
			return false;
		case 2: // etx
			ewireerror = eWireError.RECV2_ERROR;
			ewireerror.setDetail( "ETX not match!");
			return false;
		case 3: // crc
			ewireerror = eWireError.CRC_ERROR;
			return false;
		case 4: // command "E"
			ep_result = new eWireParam( recvpacket.getDataString() );
			ewireerror.setCode( ep_result.get(0) );
			ewireerror.setDesc( ep_result.get(1) );
			ewireerror.setDetail( "" );
			return false;
		}
		
		// check result
		if( checkresult ) {
			ep_result = new eWireParam( recvpacket.getDataString() );
			if( ep_result.get(0).compareTo("2000") != 0 ) {
				// server error
				ewireerror.setCode( ep_result.get(0) );
				ewireerror.setDesc( ep_result.get(1) );
				ewireerror.setDetail( "" );
				return false;
			}
		}
		
		return true;
	}
	
	public boolean transNone(String userid, String command, String instruction, String param) {
		return trans(userid, command, instruction, param.getBytes(), this.MODENONE );
	}

	public boolean transNone(String userid, String command, String instruction, byte[] param) {
		return trans(userid, command, instruction, param, this.MODENONE );
	}
	
	public boolean transDown(String userid, String command, String instruction, String param, String filename) {
		setFilename(filename);
		return trans(userid, command, instruction, param.getBytes(), this.MODEDOWN );
	}

	public boolean transDown(String userid, String command, String instruction, byte[] param, String filename) {
		setFilename(filename);
		return trans(userid, command, instruction, param, this.MODEDOWN );
	}

	public boolean transUp(String userid, String command, String instruction, String param, String filename) {
		setFilename(filename);
		return trans(userid, command, instruction, param.getBytes(), this.MODEUP );
	}

	public boolean transUp(String userid, String command, String instruction, byte[] param, String filename) {
		setFilename(filename);
		return trans(userid, command, instruction, param, this.MODEUP );
	}

	public boolean trans(String userid, String command, String instruction,	byte[] param, int mode, String filename) {
		setFilename(filename);
		return trans(userid, command, instruction, param, mode );
	}

	public boolean trans(String userid, String command, String instruction,	byte[] param, int mode) {

		int currentpacket = 0;
		int totalpacket = 0;
		byte[] readbuf = null; // if read mode 

		if (connect() != 0) {
			ewireerror = eWireError.CONNECT_ERROR;
			return false;
		}

		this.currentmode = mode;
		sendpacket = new eWirePacket(userid, command, instruction, param);
		recvpacket = new eWirePacket();
		senddatapacket = new eWirePacket(userid, "D", instruction, param); // data send
		recvdatapacket = new eWirePacket();

		// command trans
		if( !trans( sendpacket, recvpacket, true ) ) {
			disconnect();
			return false;
		}
			
		// if C command is file send or recv
		if ( mode != this.MODENONE ) {

			// replace command
			//senddatapacket.setCommand("D");
			//senddatapacket.makePacket();
			eWireLog.d("eWireData : Start" );

			// send or read
			ewirefile = new eWireFile(this.filename);

			
			// DOWNLOAD
			if( !ewirefile.open(mode == this.MODEDOWN ? eWireFile.MODEWRITE : eWireFile.MODEREAD ) ) {
				ewireerror = eWireError.FILE_OPEN_ERROR;
				disconnect();
				return false;
			}
			if( mode == this.MODEUP ) {	
				currentpacket = 0;
				totalpacket = ewirefile.getTotalReadBlock();
			}

			// file read send
			do {
				
				if( mode == this.MODEUP ) {
					try {
						senddatapacket.setData( ewirefile.read() );
					} catch (Exception e) {
						e.printStackTrace();
						ewirefile.close();
						ewireerror = eWireError.FILE_READ_ERROR;
						disconnect();
						return false;
					}
					
					currentpacket += 1;
					
					senddatapacket.setCurrentPacket( currentpacket );
					senddatapacket.setTotalPacket( totalpacket );
					senddatapacket.makePacket();
				}
		
				// file trans
				if( !trans( senddatapacket, recvdatapacket, mode == this.MODEUP ? true : false ) ) {
					ewirefile.close();
					disconnect();
					return false;
				}
				
				if( mode == this.MODEDOWN ) {
					try {
						ewirefile.write(recvdatapacket.getData());
					} catch (Exception e) {
						e.printStackTrace();
						ewirefile.close();
						ewireerror = eWireError.FILE_WRITE_ERROR;
						disconnect();
						return false;
					}

					currentpacket = recvdatapacket.getCurrentPacket();
					totalpacket = recvdatapacket.getTotalPacket();

					senddatapacket.setCurrentPacket(currentpacket+1);
					senddatapacket.setTotalPacket(totalpacket);
					senddatapacket.makePacket();
				}

                if( callbackOnPublishProgress != null ) {
                	//eWireLog.d( "eWire OnPublicshProgress( " + currentpacket + " , " + totalpacket + " )" );
                	callbackOnPublishProgress.OnPublishProgress( currentpacket, totalpacket );
                }
				
				//eWireLog.d( "eWireData " + ( mode == this.MODEDOWN ? "Down" : "Up" ) + " Packet : " + currentpacket + "/" + totalpacket);

			} while (currentpacket < totalpacket);

			ewirefile.close();
			
			eWireLog.d("eWireData : End");
		}

		disconnect();

		return true;
	}

}
