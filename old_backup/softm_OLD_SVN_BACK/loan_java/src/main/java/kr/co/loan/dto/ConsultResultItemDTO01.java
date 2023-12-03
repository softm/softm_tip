package kr.co.loan.dto;

import kr.co.loan.lib.dto.BaseDTO;

/**
 * ConsultResultItemDTO01
 * @author softm 
 */
public class ConsultResultItemDTO01 extends BaseDTO {
		private String LOAN_REASON_NM;	
		private String LOAN_COMPANY_NAME;	
		private String LOAN_BRANCH_NAME;	
		private String LOAN_BEGIN_DT;	
		private String LOAN_UPDATE_DT;	
		private String LOAN_AMOUNT;	
		private String LOAN_MORT_YN;
		public String getLOAN_REASON_NM() {
			return LOAN_REASON_NM;
		}
		public void setLOAN_REASON_NM(String lOAN_REASON_NM) {
			LOAN_REASON_NM = lOAN_REASON_NM;
		}
		public String getLOAN_COMPANY_NAME() {
			return LOAN_COMPANY_NAME;
		}
		public void setLOAN_COMPANY_NAME(String lOAN_COMPANY_NAME) {
			LOAN_COMPANY_NAME = lOAN_COMPANY_NAME;
		}
		public String getLOAN_BRANCH_NAME() {
			return LOAN_BRANCH_NAME;
		}
		public void setLOAN_BRANCH_NAME(String lOAN_BRANCH_NAME) {
			LOAN_BRANCH_NAME = lOAN_BRANCH_NAME;
		}
		public String getLOAN_BEGIN_DT() {
			return LOAN_BEGIN_DT;
		}
		public void setLOAN_BEGIN_DT(String lOAN_BEGIN_DT) {
			LOAN_BEGIN_DT = lOAN_BEGIN_DT;
		}
		public String getLOAN_UPDATE_DT() {
			return LOAN_UPDATE_DT;
		}
		public void setLOAN_UPDATE_DT(String lOAN_UPDATE_DT) {
			LOAN_UPDATE_DT = lOAN_UPDATE_DT;
		}
		public String getLOAN_AMOUNT() {
			return LOAN_AMOUNT;
		}
		public void setLOAN_AMOUNT(String lOAN_AMOUNT) {
			LOAN_AMOUNT = lOAN_AMOUNT;
		}
		public String getLOAN_MORT_YN() {
			return LOAN_MORT_YN;
		}
		public void setLOAN_MORT_YN(String lOAN_MORT_YN) {
			LOAN_MORT_YN = lOAN_MORT_YN;
		}	
		
		
		
}
