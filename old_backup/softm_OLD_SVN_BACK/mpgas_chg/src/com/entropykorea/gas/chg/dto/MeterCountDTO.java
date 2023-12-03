package com.entropykorea.gas.chg.dto;
/**
 * MeterCountDTO
 * @author softm 
 */
public class MeterCountDTO {
	private int completeCount;
	private int notCompleteCount;
	private int notSendCount;
	
	public int getCompleteCount() {
		return completeCount;
	}
	
	public int getNotCompleteCount() {
		return notCompleteCount;
	}
	
	public int getNotSendCount() {
		return notSendCount;
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
	
}
