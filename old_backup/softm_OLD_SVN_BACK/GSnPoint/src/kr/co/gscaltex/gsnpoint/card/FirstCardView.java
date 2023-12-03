package kr.co.gscaltex.gsnpoint.card;

import kr.co.gscaltex.gsnpoint.Login;
import kr.co.gscaltex.gsnpoint.R;
import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.util.AttributeSet;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.ImageButton;
import android.widget.LinearLayout;

public class FirstCardView extends LinearLayout {
	String TAG = "GS" ;
		
	private ImageButton mNewCard = null;
	private Context mContext = null;

	private Activity activity;
	private Boolean mlogin=false;
	
	public FirstCardView(Context context, Boolean login) {
		super(context);
		init(context);
		mlogin= login;
	}

	public FirstCardView(Context context, AttributeSet attrs) {
		super(context,attrs);
		init(context);
	}

	private void init(Context context) {
		mContext = context;
		activity= (Activity)context;
		
		String infService = Context.LAYOUT_INFLATER_SERVICE;
        LayoutInflater li = (LayoutInflater) getContext().getSystemService(infService);
        View v = (View)li.inflate(R.layout.firstcard, null);
        addView(v); 
		
        mNewCard=(ImageButton)findViewById(R.id.newcard_button);
        mNewCard.setOnClickListener(new View.OnClickListener() {
			public void onClick(View v) {
				Intent intent;
				//NewCardView.this.activity.finish();
				if(mlogin){
					 intent = new Intent(FirstCardView.this.activity, CardRegView.class);
					 intent.putExtra("login", mlogin);
					 intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
					FirstCardView.this.activity.startActivity(intent);
				}else{
					 intent = new Intent(FirstCardView.this.activity, Login.class);
					 intent.putExtra("login", mlogin);
					 intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
					FirstCardView.this.activity.startActivity(intent);
				}
			}
		});

	}
}
