package com.entropykorea.gas.gum.activity.ui;

import android.content.Context;
import android.util.AttributeSet;
import android.widget.Adapter;
import android.widget.Spinner;


public class NoAdapterSpinner extends Spinner {

	public NoAdapterSpinner(Context context, AttributeSet attrs, int defStyle,
			int mode) {
		super(context, attrs, defStyle, mode);
	}

	public NoAdapterSpinner(Context context, AttributeSet attrs, int defStyle) {
		super(context, attrs, defStyle);
	}

	public NoAdapterSpinner(Context context, int mode) {
		super(context, mode);
	}

	public NoAdapterSpinner(Context context) {
		super(context);
	}

	public NoAdapterSpinner(Context context, AttributeSet attrs) {
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
		
		if( OnPerformClickListener != null ) {
			Adapter adapter = getAdapter();
			if( adapter == null ){
				return OnPerformClickListener.performCick();
			}
		}
		return super.performClick();
	}

}
