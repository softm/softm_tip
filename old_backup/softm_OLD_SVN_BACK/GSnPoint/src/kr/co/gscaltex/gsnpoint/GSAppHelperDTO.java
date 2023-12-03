package kr.co.gscaltex.gsnpoint;

import android.view.View;

/**
 * @author KMS개발팀
 * App 이용가이드 UI - 도움말 표시정보
 */
public class GSAppHelperDTO {
	private View resView ; // 헬프가 표시될 버튼의 리소스 View
	private int  position; // lefttop : 1, rightBotom : 2
	private int  txtResId; // 설명 이미지
	private int  addWidth ; // 더해질 넓이  ( + , - )
	private int  addHeight; // 더해질 넓이  ( + , - )
	private int  addTop   ; // 더해질 Top  ( + , - )
	private int  addLeft  ; // 더해질 Left ( + , - )	
	
	public GSAppHelperDTO (View  resView, int position, int txtResId) {
		this(resView, position, txtResId,0);
	}
	
	public GSAppHelperDTO (View  resView, int position, int txtResId, int addWidth) {
		this(resView, position, txtResId,addWidth,0);		
	}
	
	public GSAppHelperDTO (View  resView, int position, int txtResId, int addWidth, int addHeight) {
		this.resView  = resView;
		this.position = position;
		this.txtResId = txtResId;
		this.addWidth = addWidth;
		this.addHeight = addHeight;
		this.addTop    = 0;
		this.addLeft   = 0;
	}
	
	public View getResId () {
		return this.resView;
	}
	public int getPosition () {
		return this.position;
	}
	public int getTxtResId () {
		return this.txtResId;
	}
	public int getAddWidth () {
		return this.addWidth;
	}
	public int getAddHeight () {
		return this.addHeight;
	}
	public int getAddTop () {
		return this.addTop;
	}
	public int getAddLeft () {
		return this.addLeft;
	}
	
	public void setAddTop(int addTop) {
		this.addTop = addTop;
	}

	public void setAddLeft(int addLeft) {
		this.addLeft = addLeft;
	}
	
}