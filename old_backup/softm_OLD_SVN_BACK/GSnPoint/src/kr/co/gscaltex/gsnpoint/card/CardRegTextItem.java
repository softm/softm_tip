package kr.co.gscaltex.gsnpoint.card;

public class CardRegTextItem {

	private boolean mSelectable = true;
	private int    seq     ;
	private String cardName;
	private String cardNo  ;
	private String cvc     ;
	private String stopYn  ;

	/**
	 * @param seq
	 * @param pk
	 * @param cardName
	 * @param cardNo
	 * @param cvc
	 * @param stopYn
	 */
	public CardRegTextItem(int seq, String pk,String cardName,String cardNo,String cvc,String stopYn) {
		this.seq      = seq     ;
		this.cardName = cardName;
		this.cardNo   = cardNo  ;
		this.cvc      = cvc     ;
		this.stopYn   = stopYn  ;
	}

	public int    getSeq     () { return seq     ; }
	public String getCardName() { return cardName; }
	public String getCardNo  () { 
		String rtnCardNo = cardNo;
		// 1019150000001537
		if ( rtnCardNo.length() == 16 ) {
			rtnCardNo = rtnCardNo.substring(0, 4) + "-" + rtnCardNo.substring(4, 8) + "-" + rtnCardNo.substring(8, 12) + "-" + rtnCardNo.substring(12, 16);
		}
		return rtnCardNo; 
	}
	public String getCvc     () { return cvc     ; }
	public String getStopYn  () { return stopYn  ; }
	
	public void setSeq     (int    seq     ) { this.seq      = seq     ; }
	public void setCardName(String cardName) { this.cardName = cardName; }
	public void setCardNo  (String cardNo  ) { this.cardNo   = cardNo  ; }
	public void setCvc     (String cvc     ) { this.cvc      = cvc     ; }
	public void setStopYn  (String stopYn  ) { this.stopYn   = stopYn  ; }

	public boolean ismSelectable() {
		return mSelectable;
	}

	public void setmSelectable(boolean mSelectable) {
		this.mSelectable = mSelectable;
	}
}
