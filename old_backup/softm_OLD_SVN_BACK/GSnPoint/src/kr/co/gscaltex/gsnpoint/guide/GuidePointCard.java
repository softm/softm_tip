package kr.co.gscaltex.gsnpoint.guide;

import java.io.ByteArrayInputStream;
import java.io.FilterInputStream;
import java.io.IOException;
import java.io.InputStream;
import java.net.URL;
import java.util.ArrayList;
import java.util.List;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;

import kr.co.gscaltex.gsnpoint.BaseActivity;
import kr.co.gscaltex.gsnpoint.NewMainMenu;
import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.TitleView;
import kr.co.gscaltex.gsnpoint.card.ui.CoverFlow;
import kr.co.gscaltex.gsnpoint.card.ui.ImageAdapter;
import kr.co.gscaltex.gsnpoint.dao.PointCardInfoModel;
import kr.co.gscaltex.gsnpoint.util.Util;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;

import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.drawable.Drawable;
import android.os.Bundle;
import android.os.Handler;
import android.view.MotionEvent;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.View.OnTouchListener;
import android.webkit.WebView;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.ScrollView;
import android.widget.TextView;
import android.widget.Toast;

public class GuidePointCard extends BaseActivity implements OnClickListener,OnTouchListener {
	
	String TAG = "GuidePointCard";
	
	private boolean m_bLogin = false;
	private Handler handler = new Handler();
	
	private PointCardInfoModel info = new PointCardInfoModel();
	
	private LinearLayout LinearPage = null;
	private CoverFlow mCoverflow;
	private TextView mTxtName = null;
	private WebView mTarget, mBenefit, mHelpdesk= null;
	private ImageView mCardImage, mTitle1, mTitle2, mTitle3 = null;
	
	private ImageView[] mButtons ;
	
	private ScrollView mScroll = null;
	ArrayList<Bitmap> imgs = new ArrayList<Bitmap>();
	ArrayList<PointCardInfoModel> list = new ArrayList<PointCardInfoModel>();
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.guidepointcardview);
		
		Bundle extras = getIntent().getExtras();
		if(extras!=null)
		m_bLogin = extras.getBoolean("login");
		
		new TitleView(this,true,true,R.string.TITLE_TYPE_GUIDE_POINT_CARD,m_bLogin); 
		new NewMainMenu(this);
		
		LinearPage = (LinearLayout)findViewById(R.id.linearpage);
		mScroll = (ScrollView)findViewById(R.id.guide_pointcard);
		
		mCoverflow = (CoverFlow)findViewById(R.id.bottom_tab_coverflow);
		mCoverflow.setOnTouchListener(this);
		mCoverflow.setOnItemSelectedListener(mCoverFlowItemSelected);
			
		mTxtName = (TextView)findViewById(R.id.txt_cardname);
		mTarget = (WebView)findViewById(R.id.txt_content01);
		mTarget.setOnTouchListener(this);
		mBenefit = (WebView)findViewById(R.id.txt_content2);
		mBenefit.setOnTouchListener(this);
		mHelpdesk = (WebView)findViewById(R.id.txt_content3);
		mHelpdesk.setOnTouchListener(this);
		//mIssuproc = (TextView)findViewById(R.id.txt_content04);
		mCardImage = (ImageView)findViewById(R.id.card_img);
		mTitle1 = (ImageView)findViewById(R.id.img_title1);
		mTitle2 = (ImageView)findViewById(R.id.img_title2);
		mTitle3 = (ImageView)findViewById(R.id.img_title3);
		
		
		getPointCardInformation();
	}

	private void getPointCardInformation() {
		
		showCenterProgress();
		
			Thread r = new Thread(new Runnable() {
				public void run() {
					List<NameValuePair> params = new ArrayList<NameValuePair>(2);
					params.add(new BasicNameValuePair("process_code", "pointCardList"));
								
					setParams(params);
					loadUrl(R.string.TITLE_TYPE_GUIDE_POINT_CARD, Util.DATA_CONNECT,"") ;
				}
			});
			r.start();
	}
	
	private OnItemSelectedListener mCoverFlowItemSelected = new OnItemSelectedListener() {
		public void onItemSelected(AdapterView<?> arg0, View arg1, int arg2,
				long arg3) {
			// TODO Auto-generated method stub
			int position = mCoverflow.getSelectedItemPosition();		
			setLayout(position);	
		}
		
		public void onNothingSelected(AdapterView<?> arg0) {
			// TODO Auto-generated method stub		
		}
	};
	
	
	@Override
	protected void onDestroy() { 
		super.onDestroy(); 
		imgs.clear();
	}

	@Override
	protected void httpResult(int what, boolean result, String kind) {
		// TODO Auto-generated method stub
		switch(what) {
		case R.string.TITLE_TYPE_GUIDE_POINT_CARD :
		
			String str = getString();
			//Debug.trace("TEXT",str);
			str = str.trim();

			try {
					DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
					DocumentBuilder builder = factory.newDocumentBuilder();
					InputStream istream = new ByteArrayInputStream(str.getBytes("utf-8"));
					Document doc = builder.parse(istream);
		
					Element order = doc.getDocumentElement();
					NodeList result_items = order.getElementsByTagName("result");
					Node result_item = result_items.item(0);
					Node result_text = result_item.getFirstChild();
					
					NodeList error_items = order.getElementsByTagName("err");
					Node error_item;
					Node error_text=null;
			
					result_tag = result_text.getNodeValue();
					if(result_tag.equals("0")){
						error_item = error_items.item(0);
						error_text = error_item.getFirstChild();
						String msg;
					
						if( error_text.getNodeValue() == null ){
							msg = Util.NOT_FOUND_RESULT;
							Toast.makeText(this, msg, Toast.LENGTH_SHORT).show();
						}else{
							msg = error_text.getNodeValue();
							Toast.makeText(this, msg, Toast.LENGTH_SHORT).show();
						}															
					}else if(result_tag.equals("1")){	
						
						NodeList name_items = order.getElementsByTagName("name");
						NodeList imgurl_items = order.getElementsByTagName("imgurl");
						NodeList target_items = order.getElementsByTagName("target");	
						NodeList benefit_items = order.getElementsByTagName("benefit");	
						NodeList helpdesk_items = order.getElementsByTagName("helpdesk");					
						NodeList preurl_items = order.getElementsByTagName("preurl");	
						//NodeList issproc_items = order.getElementsByTagName("issproc");	
						
						
						for(int i = 0; i < name_items.getLength();i++ )
						{	
							info = new PointCardInfoModel();
							
							Node name_item = name_items.item(i);
							Node imgurl_item = imgurl_items.item(i);
							Node target_item = target_items.item(i);
							Node benefit_item = benefit_items.item(i);
							Node helpdesk_item = helpdesk_items.item(i);
							//Node issproc_item = issproc_items.item(i);
							Node preurl_item = preurl_items.item(i);
								
							if(name_item!=null && name_item.getFirstChild()!=null)
								info.setCardName(name_item.getFirstChild().getNodeValue());	
							if(target_item!=null && target_item.getFirstChild()!=null){
								info.setCardTarget(target_item.getFirstChild().getNodeValue());	
							}
							else{
								info.setCardTarget("");	
							}							
							if(benefit_item!=null && benefit_item.getFirstChild()!=null){
								info.setCardBenefit(benefit_item.getFirstChild().getNodeValue());
							}
							else{
								info.setCardBenefit("");
							}
							if(helpdesk_item!=null && helpdesk_item.getFirstChild()!=null){
								info.setCardHelpdesk(helpdesk_item.getFirstChild().getNodeValue());	
							}
							else{
								info.setCardHelpdesk("");
							}
							//if(issproc_item!=null && issproc_item.getFirstChild()!=null)
								//info.setCardIssProc(issproc_item.getFirstChild().getNodeValue());	
												
							info.setCardUrl(preurl_item.getFirstChild().getNodeValue()+imgurl_item.getFirstChild().getNodeValue());
							
							list.add(info);
							
							getBitmapFromUrl(preurl_item.getFirstChild().getNodeValue()+imgurl_item.getFirstChild().getNodeValue(), i);
						}
						
						for (int i = 0; i < name_items.getLength(); i++) {
							ImageView pageImg = new ImageView(this);
							pageImg.setImageResource(R.drawable.paging_dot_off);
							LinearPage.addView(pageImg,i);
						}
					}
			}
			catch (Exception e) {
				e.printStackTrace();
			}			
		
			handler.post(setCoverFlow);
			break ;		
		}
		hideCenterProgress();	
	}

	private Runnable setCoverFlow = new Runnable(){
		public void run() {
			setCoverflow();
			setLayout(0);
			setPageImage();
		}		
	};
	
	private void setLayout(int position){
		
	//	if(list.get(position).getCardName().equals("")){
	//		mTxtName.setVisibility(View.GONE);
	//	}else
		
		for (int i = 0; i < LinearPage.getChildCount(); i++) {
			((ImageView)LinearPage.getChildAt(i)).setImageResource(R.drawable.paging_dot_off);
		}
		((ImageView)LinearPage.getChildAt(position)).setImageResource(R.drawable.paging_dot_on);
		
		
			mTxtName.setText(list.get(position).getCardName()); 
		
		if(list.get(position).getCardTarget().equals("")){
			mTarget.setVisibility(View.GONE);
			mTitle1.setVisibility(View.GONE);
		}else{
			mTarget.setVisibility(View.VISIBLE);
			mTitle1.setVisibility(View.VISIBLE);
			//mTarget.setText(list.get(position).getCardTarget());
			mTarget.loadDataWithBaseURL(null, list.get(position).getCardTarget(), 
					"text/html", "utf-8", null);
		}

		if(list.get(position).getCardBenefit().equals("")){
			mBenefit.setVisibility(View.GONE);
			mTitle2.setVisibility(View.GONE);
		}else{
			mBenefit.setVisibility(View.VISIBLE);
			mTitle2.setVisibility(View.VISIBLE);
			//mBenefit.setText(list.get(position).getCardBenefit());
			mBenefit.loadDataWithBaseURL(null, list.get(position).getCardBenefit(), 
					"text/html", "utf-8", null);
		}
		
		if(list.get(position).getCardHelpdesk().equals("")){
			mHelpdesk.setVisibility(View.GONE);
			mTitle3.setVisibility(View.GONE);
		}else{
			mHelpdesk.setVisibility(View.VISIBLE);
			mTitle3.setVisibility(View.VISIBLE);
			//mHelpdesk.setText(list.get(position).getCardHelpdesk());
			mHelpdesk.loadDataWithBaseURL(null, list.get(position).getCardHelpdesk(), 
					"text/html", "utf-8", null);
		}
		
		mCardImage.setImageBitmap(imgs.get(position));
		
	}
	
	private void setPageImage(){
		/*
		mButtons= 
		for (int i = 0; i < TAB_BUTTON_COUNT; i++) {
			mButtons[i] = (ImageButton)activity.findViewById(R.id.cardTab01+i);
			mButtons[i].setId(i);
			mButtons[i].setOnClickListener(this);
		}
		
		for (int i = 0; i < TAB_BUTTON_COUNT; i++) {
			mButtons[i].setBackgroundResource(TAB_BUTTON_OFF_RESOURCE_IDS[i]);
		}
		
		mButtons[nSelectTab].setBackgroundResource(TAB_BUTTON_ON_RESOURCE_IDS[nSelectTab]);
		*/
	}
	
	private void setCoverflow(){
		mCoverflow.clearAll();
		
		ImageAdapter coverImageAdapter = new ImageAdapter(this,imgs);
		
		mCoverflow.setAdapter(coverImageAdapter);
		mCoverflow.setSpacing(-65);
		//mCoverflow.setSelection(nCoverflowLastPosition, true);
		mCoverflow.setSelection(0, true);
		mCoverflow.setAnimationDuration(1000);
		
		ImageView iv = (ImageView)coverImageAdapter.getItem(0);		
		Drawable d = iv.getDrawable();
		
		RelativeLayout.LayoutParams lp = (RelativeLayout.LayoutParams)mCoverflow.getLayoutParams();
		lp.height = d.getIntrinsicHeight();
		mCoverflow.setLayoutParams(lp);		
	}
	
	protected void getBitmapFromUrl(String url, int position){	
		try{
				InputStream is = new URL(url).openStream();
				imgs.add(BitmapFactory.decodeStream(new FlushedInputStream(is)));		
				is.close();			
			}catch (IOException e){
				;
			}	
	}
	

	static class FlushedInputStream extends FilterInputStream{

		protected FlushedInputStream(InputStream in) {
			super(in);
			// TODO Auto-generated constructor stub
		}
		
		public long skip(long n) throws IOException {
			long totalByteSkipped = 0L;
			while (totalByteSkipped<n){
				long bytesSkipped = in.skip(n-totalByteSkipped);
				if(bytesSkipped == 0L){
					int b = read();
					if (b<0){
						break;
					}else {
						bytesSkipped = 1;
					}
				}
				totalByteSkipped += bytesSkipped;
			}
			return totalByteSkipped;
		}
	}

	public void onClick(View arg0) {
		// TODO Auto-generated method stub
		
	}
	
	public boolean onTouch(View v, MotionEvent event) {
		// TODO Auto-generated method stub
		mScroll.requestDisallowInterceptTouchEvent(true);
		return false;
	}

}

