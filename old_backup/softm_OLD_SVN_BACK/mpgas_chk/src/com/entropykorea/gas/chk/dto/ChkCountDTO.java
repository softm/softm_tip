package com.entropykorea.gas.chk.dto;
/**
 * ChkCountDTO
 * @author softm 
 */
public class ChkCountDTO {
	private int completeCount;
	private int notCompleteCount;
	private int notSendCount;
	private int notChkSendCount;
	
	public int getCompleteCount() {
		return completeCount;
	}
	
	public int getNotCompleteCount() {
		return notCompleteCount;
	}
	
	public int getNotSendCount() {
		return notSendCount;
	}
	public int getNotChkSendCount() {
		return notChkSendCount;
	}
	
	public void setCompleteCount(int completeCount) {
		this.completeCount = completeCount;
	}
	public void setNotCompleteCount(int notCompleteCount) {
		this.notCompleteCount = notCompleteCount;
	}
	public void setNotSendCount(int notSendCount) {
		this.notSendCount = notSendCount;
	}
	public void setNotChkSendCount(int notChkSendCount) {
		this.notChkSendCount = notChkSendCount;
	}
	
}
