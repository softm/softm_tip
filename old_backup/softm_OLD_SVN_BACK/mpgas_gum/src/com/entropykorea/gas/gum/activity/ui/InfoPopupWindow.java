package com.entropykorea.gas.gum.activity.ui;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.entropykorea.gas.gum.R;

public class InfoPopupWindow extends BetterPopupWindow {

	public String mMessage;

	public InfoPopupWindow(View anchor, String message) {
		super(anchor);
		this.mMessage = message;
		init();
	}

	public void init() {
		// inflate layout
		LayoutInflater inflater = (LayoutInflater) this.anchor.getContext()
				.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

		ViewGroup root = (ViewGroup) inflater.inflate(
				R.layout.layout_info_popup_window, null);

		TextView tv = (TextView) root.findViewById(R.id.text1);
		tv.setText(this.mMessage);

		// set the inflated view as what we want to display
		this.setContentView(root);
	}

	@Override
	protected void onCreate() {

	}

}
