package com.entropykorea.gas.gum.activity.ui;

import android.content.Context;
import android.util.AttributeSet;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.Spinner;


public class ClickSpinner extends Spinner {

	public ClickSpinner(Context context, AttributeSet attrs, int defStyle,
			int mode) {
		super(context, attrs, defStyle, mode);
	}

	public ClickSpinner(Context context, AttributeSet attrs, int defStyle) {
		super(context, attrs, defStyle);
	}

	public ClickSpinner(Context context, int mode) {
		super(context, mode);
	}

	public ClickSpinner(Context context) {
		super(context);
	}

	public ClickSpinner(Context context, AttributeSet attrs) {
		super(context, attrs);
	}

	// interface
	public interface OnPerformClick {
		boolean performCick();
	}
	
	private OnPerformClick OnPerformClickListener = null;
	
	public void setOnPerformClickListener(OnPerformClick listener) {
		OnPerformClickListener = listener;
	}
	
	@Override
	public boolean performClick() {

		int position = getSelectedItemPosition();
		position ++;
		if( position > getCount() - 1 )
			position = 0;

		setSelection( position );

		if( OnPerformClickListener != null ) {
			return OnPerformClickListener.performCick();
		}

		return false;
	}

}
