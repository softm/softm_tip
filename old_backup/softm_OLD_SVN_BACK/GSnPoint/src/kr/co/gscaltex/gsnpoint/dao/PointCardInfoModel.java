package kr.co.gscaltex.gsnpoint.dao;

public class PointCardInfoModel {
	private String cardName;
	private String cardTarget;
	private String cardBenefit;
	private String cardHelpdesk;
	private String cardIssProc;
	
	
	public String getCardIssProc() {
		return cardIssProc;
	}
	public void setCardIssProc(String cardIssProc) {
		this.cardIssProc = cardIssProc;
	}
	private String cardUrl;
	
	
	public String getCardName() {
		return cardName;
	}
	public void setCardName(String cardName) {
		this.cardName = cardName;
	}
	public String getCardTarget() {
		return cardTarget;
	}
	public void setCardTarget(String cardTarget) {
		this.cardTarget = cardTarget;
	}
	public String getCardBenefit() {
		return cardBenefit;
	}
	public void setCardBenefit(String cardBenefit) {
		this.cardBenefit = cardBenefit;
	}
	public String getCardHelpdesk() {
		return cardHelpdesk;
	}
	public void setCardHelpdesk(String cardHelpdesk) {
		this.cardHelpdesk = cardHelpdesk;
	}
	public String getCardUrl() {
		return cardUrl;
	}
	public void setCardUrl(String cardUrl) {
		this.cardUrl = cardUrl;
	}
	
}
