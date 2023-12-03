package kr.go.citis.main;

import kr.go.citis.lib.TitleView;
import android.app.Activity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageButton;
import android.widget.RelativeLayout;
import android.widget.TextView;
/**
 * TopTitleView
 * @author softm 
 */ 
public class TopTitleView extends TitleView {
	public TopTitleView(Activity activity, int resId, boolean b, boolean c) {
		super(activity, resId,b,c);
	}

	@SuppressWarnings("unused")
	private void initLayout(BasicActivity activity, String title, ViewGroup group,boolean button1, boolean button2) {
		if ( this.activity == null ) {
			group.setId(R.id.body);
			activity.setBody(group);
			LayoutInflater layout = activity.getLayoutInflater();
			View view = layout.inflate(R.layout.layout_title_basic, null);
			TextView textView = (TextView)view.findViewById(R.id.title_text);
			ImageButton imgBtnTop0 = (ImageButton)view.findViewById(R.id.btn_top0);
			ImageButton imgBtnTop1 = (ImageButton)view.findViewById(R.id.btn_top1);
			ImageButton imgBtnTop2 = (ImageButton)view.findViewById(R.id.btn_top2);
			textView.setText(title);
			//textView.setPaintFlags(textView.getPaintFlags()|Paint.FAKE_BOLD_TEXT_FLAG) ;
//		imgBtnTop0.setOnClickListener(new View.OnClickListener() {
//			public void onClick(View v) {
//				TitleView.this.activity.finish();
//			}
//		});
			imgBtnTop0.setOnClickListener(this);
			if ( !button1 ) {
				imgBtnTop1.setVisibility(View.GONE);
			} else {
				imgBtnTop1.setOnClickListener(this);
			}
			
			if ( !button2 ) {
				imgBtnTop2.setVisibility(View.GONE);
				RelativeLayout.LayoutParams params = (RelativeLayout.LayoutParams)imgBtnTop1.getLayoutParams();
				params.addRule(RelativeLayout.CENTER_IN_PARENT);
				params.addRule(RelativeLayout.ALIGN_PARENT_RIGHT);
				params.addRule(RelativeLayout.LEFT_OF, R.id.btn_top2);
				imgBtnTop1.setLayoutParams(params);
			} else {
				imgBtnTop2.setOnClickListener(this);
			}
			group.addView(view, 0);
		}
	}
}


