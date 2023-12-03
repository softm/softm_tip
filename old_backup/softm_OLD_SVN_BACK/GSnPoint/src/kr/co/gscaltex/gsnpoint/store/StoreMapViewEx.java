package kr.co.gscaltex.gsnpoint.store;

import java.util.Timer;
import java.util.TimerTask;
 
import android.content.Context;
import android.util.AttributeSet;
import android.view.MotionEvent;
 
import com.google.android.maps.GeoPoint;
import com.google.android.maps.MapView;

 
public class StoreMapViewEx extends MapView
{
    // ------------------------------------------------------------------------
    // LISTENER DEFINITIONS
    // ------------------------------------------------------------------------
 
    // Change listener
    public interface OnChangeListener
    {
        public void onChange(MapView view, GeoPoint newCenter, GeoPoint oldCenter, int newZoom, int oldZoom);
    }
 
    // ------------------------------------------------------------------------
    // MEMBERS
    // ------------------------------------------------------------------------
 
    private StoreMapViewEx mThis;
    private long mEventsTimeout = 150L;     // Set this variable to your preferred timeout
    private boolean mIsTouched = false;
    private GeoPoint mLastCenterPosition;
    private int mLastZoomLevel;
    private Timer mChangeDelayTimer = new Timer();
    private StoreMapViewEx.OnChangeListener mChangeListener = null;
 
    // ------------------------------------------------------------------------
    // CONSTRUCTORS
    // ------------------------------------------------------------------------
 
    public StoreMapViewEx(Context context, String apiKey)
    {
        super(context, apiKey);
        init();
    }
 
    public StoreMapViewEx(Context context, AttributeSet attrs)
    {
        super(context, attrs);
        init();
    }
 
    public StoreMapViewEx(Context context, AttributeSet attrs, int defStyle)
    {
        super(context, attrs, defStyle);
        init();
    }
 
    private void init()
    {
        mThis = this;
        mLastCenterPosition = this.getMapCenter();
        mLastZoomLevel = this.getZoomLevel();
    }
 
    // ------------------------------------------------------------------------
    // GETTERS / SETTERS
    // ------------------------------------------------------------------------
 
    public void setOnChangeListener(StoreMapViewEx.OnChangeListener l)
    {
        mChangeListener = l;
    }
 
    // ------------------------------------------------------------------------
    // EVENT HANDLERS
    // ------------------------------------------------------------------------
 
    @Override
    public boolean onTouchEvent(MotionEvent ev)
    {
        // Set touch internal
        mIsTouched = (ev.getAction() != MotionEvent.ACTION_UP);
 
        return super.onTouchEvent(ev);
    }
 
    @Override
    public void computeScroll()
    {
        super.computeScroll();
 
        // Check for change
        if (isSpanChange() || isZoomChange())
        {
            // If computeScroll called before timer counts down we should drop it and
            // start counter over again
            resetMapChangeTimer();
        }
    }
 
    // ------------------------------------------------------------------------
    // TIMER RESETS
    // ------------------------------------------------------------------------
 
    private void resetMapChangeTimer()
    {
        mChangeDelayTimer.cancel();
        mChangeDelayTimer = new Timer();
        mChangeDelayTimer.schedule(new TimerTask()
        {
            @Override
            public void run()
            {
                if (mChangeListener != null) mChangeListener.onChange(mThis, getMapCenter(), mLastCenterPosition, getZoomLevel(), mLastZoomLevel);
                mLastCenterPosition = getMapCenter();
                mLastZoomLevel = getZoomLevel();
            }
        }, mEventsTimeout);
    }
 
    // ------------------------------------------------------------------------
    // CHANGE FUNCTIONS
    // ------------------------------------------------------------------------
 
    public boolean isSpanChange()
    {
        return !mIsTouched && !getMapCenter().equals(mLastCenterPosition);
    }
 
    private boolean isZoomChange()
    {
        return (getZoomLevel() != mLastZoomLevel);
    }
 
}
