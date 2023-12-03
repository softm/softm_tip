package kr.co.gscaltex.gsnpoint.store;

import java.util.ArrayList;
import java.util.List;
import java.util.StringTokenizer;

import kr.co.gscaltex.gsnpoint.dao.StoreInfoModel;
import kr.co.gscaltex.gsnpoint.util.Util;
import android.graphics.Canvas;
import android.graphics.Paint;
import android.graphics.Point;
import android.graphics.Rect;
import android.graphics.Typeface;
import android.graphics.drawable.Drawable;

import com.google.android.maps.GeoPoint;
import com.google.android.maps.ItemizedOverlay;
import com.google.android.maps.MapView;
import com.google.android.maps.OverlayItem;
import com.google.android.maps.Projection;

public class FranchiseTooltipOverlay extends ItemizedOverlay<FranchiseTooltipOverlayItem> implements ItemizedOverlay.OnFocusChangeListener{
	private final String TAG="FranchiseTooltipOverlay";
	protected List<FranchiseTooltipOverlayItem> mItems = new ArrayList<FranchiseTooltipOverlayItem>();
	
	private Rect mDrawRect = new Rect(); 
	
	public FranchiseTooltipOverlay(Drawable defaultMarker) {
		super( boundCenterBottom(defaultMarker) );
		Drawable drawRect = boundCenterBottom(defaultMarker);
		
		Rect rect = new Rect(drawRect.getBounds());
		mDrawRect = new Rect(rect.left, rect.top, rect.right, rect.bottom  );
		//mDrawRect.set(drawRect.getBounds());
		
    	this.setOnFocusChangeListener(this);
        this.populate();//�������� ������� ��ġ�ϸ� ������ �߻��ϹǷ� �ѹ� ȣ���Ѵ�.
    }
	
	
	
	private Point mOffsetPoint = new Point(0,0);
	
	public void setOffset(int x, int y){
		mOffsetPoint = new Point(x, y);
	}
	
	public Point getOffset(){
		return mOffsetPoint;
	}
	
	
    protected FranchiseTooltipOverlayItem createItem(int i) {
    	return mItems.get(i);
    }
    
    
    public int size() {
    	return mItems.size();
    }
    
    public List<FranchiseTooltipOverlayItem> getOveryItemArray(){
    	return mItems;
    }
    
    public void clearItems(){
    	mCurrentSelectItem = null;
		mItems.clear();
		setLastFocusedIndex(-1);
    	this.populate();
    }
    
    
    public void addItem(StoreInfoModel item){
		GeoPoint gp = null;
		gp = new GeoPoint(
					(int)(Double.valueOf(item.getLat())*1E6), 
					(int)(Double.valueOf(item.getLongi())*1E6));
		mItems.add(new FranchiseTooltipOverlayItem(gp, item));
    	populate();
    }
    
    public void addItem(StoreInfoModel item, boolean bFocussed){
		GeoPoint gp = null;
		gp = new GeoPoint(
					(int)(Double.valueOf(item.getLat())*1E6), 
					(int)(Double.valueOf(item.getLongi())*1E6));
		FranchiseTooltipOverlayItem overItem = new FranchiseTooltipOverlayItem(gp, item);
		mItems.add(overItem);
    	populate();
    	this.setFocus(overItem);
    }
    
    public void addItem(StoreInfoModel item, GeoPoint gp, boolean bFocussed){
		FranchiseTooltipOverlayItem overItem = new FranchiseTooltipOverlayItem(gp, item);
		mItems.add(overItem);
    	populate();
    	this.setFocus(overItem);
    }

    private FranchiseTooltipOverlayItem mCurrentSelectItem = null;
    
    
    public void onFocusChanged(ItemizedOverlay overlay, OverlayItem newFocus) {
    	if( overlay != null && overlay instanceof FranchiseTooltipOverlay){
	    	if( newFocus!= null && newFocus instanceof FranchiseTooltipOverlayItem ){
	    		mCurrentSelectItem = (FranchiseTooltipOverlayItem)newFocus;
	    		
	    	}else{
	    		mCurrentSelectItem = null;
	    		
	    		if( mOnSelectedListener != null ){
	    			mOnSelectedListener.onFranchiseTooltipSelect((FranchiseTooltipOverlay)overlay, mCurrentSelectItem);
	    		}
	    	}
    	}else{
    		
    	}
    }
    
    private IFranchiseTooltipSelect mOnSelectedListener = null;
    public void setOnSelectedItemListener(IFranchiseTooltipSelect listener){
    	mOnSelectedListener = listener;
    }
    
    interface IFranchiseTooltipSelect {
    	void onFranchiseTooltipSelect(FranchiseTooltipOverlay overlay, FranchiseTooltipOverlayItem item);
    }
    
    
    protected boolean onTap(int index) {
    	if( mOnSelectedListener != null ){
    		mOnSelectedListener.onFranchiseTooltipSelect(this, mItems.get(index));
    	}
    	return super.onTap(index);
    }
    
    
    public void draw(Canvas canvas, MapView mapView, boolean shadow) {
    	shadow = false;
    	super.draw(canvas, mapView, shadow);
    }
    
    public FranchiseTooltipOverlayItem getCurrentFocussed(){
    	return mCurrentSelectItem;
    }
    
    
    public boolean draw(Canvas canvas, MapView mapView, boolean shadow,
    		long when) {
    	boolean bResult = super.draw(canvas, mapView, shadow, when);
    	Paint titlePaint = new Paint();
		 titlePaint.setTypeface(Typeface.DEFAULT_BOLD);
		 titlePaint.setColor(0xFF009797);
		 titlePaint.setTextAlign(Paint.Align.LEFT); 
		 titlePaint.setTextSize(22); 
		 titlePaint.setAntiAlias(true);	
		 
		 Paint detailPaint = new Paint();
		 detailPaint.setColor(0xFF6e6e6e);
		 detailPaint.setTextAlign(Paint.Align.LEFT); 
		 detailPaint.setTextSize(18); 
		 detailPaint.setAntiAlias(true);		
		
		 StoreInfoModel model;
		 String title;
		 ArrayList<String> detail;
		 GeoPoint gp = null;
		 Point pt = new Point();
		 final Projection proj = mapView.getProjection();
		 int offsetX = 0;
		 int offsetY = 0;
		 Rect titleBound = new Rect();
		 Rect detailBound = new Rect();
		 Rect detailoneBound = new Rect();
		 for( FranchiseTooltipOverlayItem item : mItems ){
			 gp = item.getPoint();
			 proj.toPixels(gp, pt);
			 
			 model = item.getModel();
			 offsetX = pt.x - mDrawRect.width()/2 + 20;//ȭ��ǥ �̹�������(40��)
			 offsetY = pt.y - mDrawRect.height() + 10;//���� ����
			 
			 //title
			 title = Util.getValidString(model.getFrch_nm());
			 titlePaint.getTextBounds(title, 0, title.length(), titleBound);
			 detail = getDetailBounds(detailPaint, getDetailString(model), detailBound, mDrawRect.width() - 100);
			 
			 //40 = 30�� ���� �κ� ���� + ���κ� ���� 10
			 offsetY += ((mDrawRect.height() - 10) - (detailBound.height() + titleBound.height() + LINE_SPACE))/2;
			 
			 canvas.drawText(title, offsetX, offsetY, titlePaint);
			 offsetY += titleBound.height() + LINE_SPACE;
			 
			 detailPaint.getTextBounds(detail.get(0), 0, detail.get(0).length(), detailoneBound);
			 
			 for( String str: detail ){
				 canvas.drawText(str, offsetX, offsetY, detailPaint);
				 offsetY += detailoneBound.height() + LINE_SPACE;
			 }
		 }
		 
    	return bResult;
    }
    
    private final int LINE_SPACE = 5;
    private ArrayList<String> getDetailBounds(Paint paint, String str, Rect bound, int maxWidth){
    	str = str.trim();
    	str = str.replaceAll("\u3000", "\u0020");
    	ArrayList<String> array = new ArrayList<String>();
    	Rect rect = new Rect();
    	paint.getTextBounds(str, 0, str.length(), rect);
    	
    	if( str.indexOf(" " ) < 0 && rect.width() > maxWidth){
    		final int iSingWidth = rect.width() / str.length();
    		final int iSize = maxWidth/iSingWidth;
    		array.add(str.substring(0, iSize));
    		array.add(str.substring(iSize, str.length()));
    		final int size = array.size(); 
    		bound.set(new Rect(0, 0, maxWidth, rect.height() * size + (size-1)*LINE_SPACE));
    		return array;
    	}
    	
    	if( maxWidth < rect.width() ){
    		StringTokenizer token = new StringTokenizer(str, " ");
    		String tempStr = null;
    		int length = 0;
    		Rect tokenBounds = new Rect();
    		String line = new String("");
    		while( token.hasMoreElements() ){
    			//2�ٱ����� ������.
    			tempStr = token.nextToken() + " ";
    			paint.getTextBounds(tempStr, 0, tempStr.length(), tokenBounds);
    			if( length + tokenBounds.width() > maxWidth ){
    				break;
    			}
    			length += tokenBounds.width();
    			line += tempStr;
    		}
    		array.add(line.trim());
    		
    		if( tempStr != null && tempStr.length() > 0){
    			line = tempStr;
    		}else
    			line = new String("");
    		
    		while( token.hasMoreElements() ){
    			line += token.nextToken();
    		}
    		
    		if( line.length() > 0 ){
    			array.add(line.trim());
    		}
    		
    		final int size = array.size(); 
    		bound.set(new Rect(0, 0, maxWidth, rect.height() * size + (size-1)*LINE_SPACE));
    	}else{
    		bound.set(rect);
    		array.add(str);
    	}
    	
    	return array;
    }
    
    private String getDetailString(StoreInfoModel model){
    	String zip = model.getZip_addr();
    	String detail = model.getDtl_addr();
    	
    	if( zip != null && detail != null ){
    		return String.format( "%s %s", zip, detail );
    	}
    	
    	if( zip == null ){
    		return "��������";
    	}
    	
    	return zip;
    }
    
}
