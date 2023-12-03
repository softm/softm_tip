package kr.co.gscaltex.gsnpoint.card;

import kr.co.gscaltex.gsnpoint.R;
import android.content.Context;
import android.view.LayoutInflater;
import android.webkit.WebView;
import android.widget.LinearLayout;
import android.widget.TextView;

public class CardCouponListView extends LinearLayout{
	
	private WebView mImage;
	private TextView mName;
	private TextView mPrice;
	
	CardProductTextItem aItem;
	
	public CardCouponListView(Context context, CardProductTextItem aItem) {
	
		super(context);

		// Layout Inflation
		LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);		
		inflater.inflate(R.layout.cardcouponlistitem, this, true);
			
		mImage = (WebView)findViewById(R.id.coupon_img);
		mImage.setFocusable(false);
		
		StringBuilder htmlUrl= new StringBuilder("<html><body marginwidth=0 marginheight=0 leftmargin=0 topmargin=0>\n")
									     .append("<div style='width:60px;height:55px'><img src=\"")
					                     .append(aItem.getImgUrl())
					                     .append("\" width=\"100%\" />\n")
					                     .append("</div></body></html>\n");
		
		//String htmlUrl = "<html><head><style type=\"text/css\">"+
		//			"hr{width:100%!important}"+
		//			"</style></head><body>"+
		//			"<img src="+aItem.getImgUrl()+"/>"+"</body></html>";
		
		mImage.loadDataWithBaseURL("", htmlUrl.toString(), "text/html", "utf-8",null);
		mImage.getSettings().setUseWideViewPort(true);
		
		// Set Text 02
		mName = (TextView) findViewById(R.id.prod_name);
		mName.setText(aItem.getmData()[0]);
		
		// Set Text 03
		mPrice = (TextView) findViewById(R.id.prod_price) ;
		mPrice.setText(aItem.getmData()[1]);
		this.aItem = aItem ;
	}
	
	public void setText(int index, String data) {
		if (index == 0) {
			mName.setText(data);
		} else if (index == 1) {
			mPrice.setText(data);
		} else {
			//throw new IllegalArgumentException();
		}
	}
	
	public void setImage(String url){
		StringBuilder htmlUrl= new StringBuilder("<html><body marginwidth=0 marginheight=0 leftmargin=0 topmargin=0>\n")
	     .append("<div style='width:60px;height:55px'><img src=\"")
        .append(url)
        .append("\" width=\"100%\" />\n")
        .append("</div></body></html>\n");
		mImage.loadDataWithBaseURL("", htmlUrl.toString(), "text/html", "utf-8",null);
	}
}
