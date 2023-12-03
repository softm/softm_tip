package kr.co.gscaltex.gsnpoint.card;

import kr.co.gscaltex.gsnpoint.R;
import android.content.Context;
import android.view.LayoutInflater;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.LinearLayout;
import android.widget.TextView;

public class CardShopListView extends LinearLayout{
	
	//private ImageView mImage;
	private WebView mImage;
	private TextView mName;
	private TextView mFieldPrice;
	private TextView mMPrice;
	
	CardProductTextItem aItem;
	
	public CardShopListView(Context context, CardProductTextItem aItem) {
	
		super(context);

		// Layout Inflation
		LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);		
		inflater.inflate(R.layout.cardshoplistitem, this, true);
			
		mImage = (WebView)findViewById(R.id.prod_img);
		mImage.setFocusable(false);
		
		StringBuilder htmlUrl= new StringBuilder("<html><body marginwidth=0 marginheight=0 leftmargin=0 topmargin=0>\n")
	     .append("<div style='width:60px;height:55px'><img src=\"")
        .append(aItem.getImgUrl())
        .append("\" width=\"100%\" />\n")
        .append("</div></body></html>\n");

		mImage.loadDataWithBaseURL("", htmlUrl.toString(), "text/html", "utf-8",null);
		
		mImage.getSettings().setUseWideViewPort(true);
		
		
		// Set Text 02
		mName = (TextView) findViewById(R.id.prod_name);
		mName.setText(aItem.getmData()[0]);
		
		// Set Text 03
		mFieldPrice = (TextView) findViewById(R.id.prod_fieldprice) ;
		mFieldPrice.setText(aItem.getmData()[1]);
		
		mMPrice = (TextView) findViewById(R.id.prod_mprice) ;
		mMPrice.setText(aItem.getmData()[2]);
		
		this.aItem = aItem ;
	}
	
	public void setText(int index, String data) {
		if (index == 0) {
			mName.setText(data);
		} else if (index == 1) {
			mFieldPrice.setText(data);
		} else if (index == 2) {
			mMPrice.setText(data);
		}else {
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
	
	class MyWebClient extends WebViewClient{

		@Override
		public boolean shouldOverrideUrlLoading(WebView view, String url) {
			// TODO Auto-generated method stub
			view.loadUrl(url);
			return true;
		}
		
		
	}
	
}
