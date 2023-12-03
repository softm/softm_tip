package kr.go.citis.main.dto;

import kr.go.citis.main.common.WConstant;

/**
 * SampleListDTOData
 * @author softm 
 */
public class SampleListDTO {
	private String mode = WConstant.LIST_DATA_MODE_READ;
	private String sample_1;
	private String sample_2;
	public SampleListDTO() {
		super();
	}
	
	public SampleListDTO(String sample_1, String sample_2) {
		this(WConstant.LIST_DATA_MODE_READ,sample_1,sample_2);
	}
	public SampleListDTO(String mode, String sample_1, String sample_2) {
		this.mode     = mode    ;
		this.sample_1 = sample_1;
		this.sample_2 = sample_2;
	}
	
	public String getMode() {
		return mode;
	}

	public void setMode(String mode) {
		this.mode = mode;
	}

	public String getSample_1() {
		return sample_1;
	}
	
	public void setSample_1(String sample_1) {
		this.sample_1 = sample_1;
	}
	
	public String getSample_2() {
		return sample_2;
	}
	
	public void setSample_2(String sample_2) {
		this.sample_2 = sample_2;
	}
}