package com.entropykorea.ewire;

import java.io.*;


public class eWireFile {
	
	private int FILEDATA_LEN = 16384; // 8109; 
	private String filename;
	
	private File file = null;
	private FileInputStream fis = null;
	private FileOutputStream fos = null;
	
	public static final int MODEREAD = 0;
	public static final int MODEWRITE = 1;
	
	private byte[] filebuf = null;
	private int filereadwritelength = 0;
	private long filelength = 0;
	
	public eWireFile(){
	}

	public eWireFile( String filename ){
		this.filename = filename;
	}
	
	public void setFileName( String filename ) {
		this.filename = filename;
	}
	
	// set FILEDATA_LEN
	public void setFileReadLen( int len ) {
		this.FILEDATA_LEN = len;
	}
	
	// get FILEDATA_LEN
	public int getFileReadLen() {
		return this.FILEDATA_LEN;
	}
	
	public long getFileLength() {
		return this.filelength;
	}
	
	// for read 
	public int getTotalReadBlock() {
		int total = 0;
		
		if( this.filelength == 0 )
			return 0;
		
		total = (int) (this.filelength / this.FILEDATA_LEN );
		if( this.filelength % this.FILEDATA_LEN != 0 )
			total += 1;
		
		return total;
	}
	
	// open read/write mode
	public boolean open( int mode ) {
		
		this.filereadwritelength = 0;
		close();
		
		try {
			this.file = new File( filename );
			if( mode == this.MODEREAD ) {
				// read
				this.fis = new FileInputStream( this.file.getPath() );
				this.filelength = this.file.length();
			} else {
				// write
				this.fos = new FileOutputStream( this.file.getPath() );
			}
		} catch (Exception e) {
			e.printStackTrace();
			return false;
		}
		
		return true;
	}
	
	// close
	public boolean close() {
		boolean rtn = true;
		
		if( this.fis != null ) {
			try {
				this.fis.close();
			} catch (IOException e) {
				e.printStackTrace();
				rtn = false;
			}
		}
		if( this.fos != null ) {
			try {
				this.fos.close();
			} catch (IOException e) {
				e.printStackTrace();
				rtn = false;
			}
		}
		
		return rtn;
	}
	
	// read FILEDATA_LEN
	public byte[] read() throws Exception {
		int len = 0;
		byte[] readbuf = new byte[FILEDATA_LEN];
		
		if( fis != null ) {
			len = fis.read( readbuf );
		}
		
		this.filereadwritelength += len;
		this.filebuf = new byte[len];
		System.arraycopy(readbuf, 0, this.filebuf, 0, len);
		
		return filebuf;
	}
	
	// write buf.length
	public int write( byte[] buf ) throws Exception {
		int len = 0;
		
		fos.write( buf );
		fos.flush();
		len = buf.length;
		
		this.filereadwritelength += len;
		
		return len;
	}

}
