package com.entropykorea.gas.main.activity.ui;

import android.content.Context;
import android.util.AttributeSet;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ImageButton;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.entropykorea.gas.main.R;

public class TitleBar extends LinearLayout implements OnClickListener {

    public final static int BUTTON_BACK = 0;
    public final static int BUTTON_ONE = 1;
    public final static int BUTTON_TWO = 2;

	private OnTopClickListner l = null;

	private ImageButton btnBack, btnOne, btnTwo;
	private TextView title;

	public TitleBar(Context context) {
		super(context);
		init(context);
	}

	public TitleBar(Context context, AttributeSet attrs) {
		super(context, attrs);
		init(context);
	}

	private void init(final Context context) {
		setOrientation(HORIZONTAL);
		LayoutInflater.from(context).inflate(R.layout.activity_titlebar, this, true);

		btnBack = (ImageButton) findViewById(R.id.btn_back);
		btnBack.setOnClickListener(this);
		btnOne = (ImageButton) findViewById(R.id.btn_one);
		btnOne.setOnClickListener(this);
		btnTwo = (ImageButton) findViewById(R.id.btn_two);
		btnTwo.setOnClickListener(this);
		title = (TextView) findViewById(R.id.title);
	}

	public void setOnTopClickListner(OnTopClickListner l) {
		this.l = l;
	}

	protected void setTopBarBackground(int resId1, int resId2, int resId3) {
		btnBack.setBackground(getResources().getDrawable(resId1));
		btnOne.setBackground(getResources().getDrawable(resId2));
		btnTwo.setBackground(getResources().getDrawable(resId3));
	}

	protected ImageButton getOneBtn() {
		return btnOne;
	}

	public void setTitle(String str) {
		title.setText(str);
	}

	public void setButtonVisibility(int buttonType, int visibility) {
		switch( buttonType ) {
		case BUTTON_BACK: // back
			btnBack.setVisibility(visibility);
			break;
		case BUTTON_ONE: // one
			btnOne.setVisibility(visibility);
			break;
		case BUTTON_TWO: // tow
			btnTwo.setVisibility(visibility);
			break;
		}
	}

	public void setButtonEnable(int buttonType, boolean value) {
		switch( buttonType ) {
		case BUTTON_BACK: // back
			btnBack.setEnabled(value);
			btnBack.setClickable(value);		
			break;
		case BUTTON_ONE: // one
			btnOne.setEnabled(value);
			btnOne.setClickable(value);		
			break;
		case BUTTON_TWO: // two
			btnTwo.setEnabled(value);
			btnTwo.setClickable(value);		
			break;
		}
	}
	
	public void setButtonBackgroundResource(int buttonType, int resId) {
		switch( buttonType ) {
		case BUTTON_BACK: // back
			btnBack.setBackgroundResource(resId);
			break;
		case BUTTON_ONE: // one
			btnOne.setBackgroundResource(resId);
			break;
		case BUTTON_TWO: // two
			btnTwo.setBackgroundResource(resId);
			break;
		}
	}

	public interface OnTopClickListner {
		public void onClickBackButton(View v);
		public void onClickOneButton(View v);
		public void onClickTwoButton(View v);
	}

    // interface
	public interface OnClickTitleText {
		void OnClickTitleText(View v);
	}

	private OnClickTitleText callbackOnClickTitleText = null;

	public void setOnClickTitleText(OnClickTitleText callback) {
		title.setOnClickListener(this);
		callbackOnClickTitleText = callback;
	}
	
	@Override
	public void onClick(View v) {
		int viewID = v.getId();
		switch (viewID) {
		case R.id.btn_back:
			if( l != null ) {
				l.onClickBackButton(v);
			}
			break;
		case R.id.btn_one:
			if( l != null ) {
				l.onClickOneButton(v);
			}
			break;
		case R.id.btn_two:
			if( l != null ) {
				l.onClickTwoButton(v);
			}
			break;
		case R.id.title:
			if( callbackOnClickTitleText != null ) {
				callbackOnClickTitleText.OnClickTitleText(v);
			}
			break;
		}
	}
}
