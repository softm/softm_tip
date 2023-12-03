package kr.co.gscaltex.gsnpoint;

import java.util.ArrayList;
import java.util.List;

import kr.co.gscaltex.gsnpoint.util.Debug;
import android.app.Activity;
import android.graphics.Color;
import android.graphics.Paint;
import android.graphics.Rect;
import android.util.DisplayMetrics;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.FrameLayout;
import android.widget.FrameLayout.LayoutParams;
import android.widget.ImageView;
/**
 * @author KMSLAB 개발팀
 * App 이용가이드 UI
 */
public class GSAppHelper {
	public static final int POSITION_LEFT_TOP     = 1;
	public static final int POSITION_LEFT_BOTTOM  = 2;
	public static final int POSITION_RIGHT_TOP    = 3;
	public static final int POSITION_RIGHT_BOTTOM = 4;
	
	private List<GSAppHelperDTO> lstHelper = new ArrayList<GSAppHelperDTO>();
	private Activity activity;
	String TAG = "GS" ;
	
	/**
	 * 최상위 ViewGroup
	 */
	private ViewGroup vGTop;
	/**
	 * helper ViewGroup ( help_view.xml )
	 */
	private ViewGroup vgHelper;
	
	/**
	 * @var titleType
	 * @see TitleView
	 */
	private int mType;
	
	/**
	 * @var 닫기버튼이 위치될 기반 Resource Id
	 */
	private int mCloseBtnBase;
	
	/**
	 * @var mAlpha int 배경영역의 투명도.
	 */
	private int mAlpha;
	
	/**
	 * Base 크기에 더해질 크기 - > 헬프아이콘 테두리에 추가됨.
	 */
	private int mAddThick = 10;

	/**
	 * 헬프아이콘을 쌓고있는 FrameLayout에 더해질 수치
	 */
	private int mAddArea  = 10 ;
	private int mTopOffset;
	
	/**
	 * @param activity		Activity
	 * @param nType			titleType
	 * @param closeBaseBtn 닫기버튼이 위치될 기반 Resource Id
	 * @see Activity
	 * @see TitleView
	 */
	public GSAppHelper(Activity activity,int nType, int closeBtnBase) {
		this.activity = activity;
		this.mType    = nType;
		this.mCloseBtnBase = closeBtnBase;
		this.lstHelper = new ArrayList<GSAppHelperDTO>();
		this.vGTop = (ViewGroup) ((ViewGroup) activity.findViewById(android.R.id.content)).getChildAt(0);
		this.mAlpha = 150;
	}

	/**
	 * @param resView		Heler icon이 보여질 Resource View
	 * @param txtResId     Help의 내용 ( Image Resource : ex : R.drawable.guide_guide01_ex02)
	 * @param btnPosition  	{@link GSAppHelperDTO}.POSITION_LEFT_TOP = 1, .POSITION_RIGHT_BOTTOM = 2
	 * 
	 * Heler Marker를 등록의 기준 resource를 셋팅합니다. - GSAppHelperDTO
	 * 
	 * Ex) add(R.id.set_button,GSAppHelperDTO.POSITION_RIGHT_BOTTOM,R.drawable.guide_guide01_ex01);
	 */
	public void add(View resView, int txtResId, int btnPosition) {
		this.add(resView,txtResId,btnPosition,0,0,0,0);
	}
	
	public void add(View resView, int txtResId, int btnPosition, int addWidth) {
		this.add(resView,txtResId,btnPosition,addWidth,0,0,0);
	}
	
	public void add(View resView, int txtResId, int btnPosition, int addWidth, int addHeight) {
		this.add(resView,txtResId,btnPosition,addWidth,addHeight,0,0);
	}
	
	public void add(View resView, int txtResId, int btnPosition, int addWidth, int addHeight, int addLeft) {
		this.add(resView,txtResId,btnPosition,addWidth,addHeight,addLeft,0);
	}
	
	public void add(View  resView, int txtResId, int btnPosition, int addWidth, int addHeight, int addLeft, int addTop) {
		if ( resView != null ) {	
			GSAppHelperDTO v = new GSAppHelperDTO(resView,btnPosition,txtResId,addWidth,addHeight);
			v.setAddLeft(addLeft);
			v.setAddTop(addTop);
			int idx = 0;
			int sIdx = -1;
			for (GSAppHelperDTO helper : lstHelper) {
				if ( helper.getResId() != null ) 	
					if ( helper.getResId().equals(resView) ) { sIdx=idx; break; }
				idx++;
			}
			if ( sIdx == -1) {
				lstHelper.add(v);
			}
		}	
	}

	public void remove(View resView) {
		int idx = 0;
		for (GSAppHelperDTO helper : lstHelper) {
			if ( helper.getResId() != null ) 
				if ( helper.getResId().equals(resView) ) { lstHelper.remove(idx); break; }
			idx++;
		}
	}	

	/**
	 * @param type
	 * @return {@link View}
	 * 기본 레이아웃 화면에 추가하고, 반환합니다.
	 */
	private View setContentView() {
		View vHelper = null;
		if ( vgHelper == null ) {
			LayoutInflater layout = activity.getLayoutInflater();
			if        ( mType == R.string.TITLE_TYPE_CARD ) {	
				vHelper = layout.inflate(R.layout.help_card_view, null);	
			} else if ( mType == R.string.TITLE_TYPE_POINT ) {	
				vHelper = layout.inflate(R.layout.help_point_view, null);	
			} else if ( mType == R.string.TITLE_TYPE_STORE ) {	
				vHelper = layout.inflate(R.layout.help_store_view, null);	
			} else {
			}		
			//		Debug.trace(TAG,"vGTop.toString() :" + vGTop.toString() + " / " + vGTop.getId());
			vGTop.addView(vHelper,new LayoutParams(LayoutParams.FILL_PARENT, LayoutParams.FILL_PARENT));
			vgHelper = (ViewGroup) activity.findViewById(R.id.gs_helper);
			
			Paint paint1 = new Paint();
			paint1.setColor(Color.BLACK);
			paint1.setAlpha( getAlpha() );
			vHelper.setBackgroundColor(paint1.getColor());
			vHelper.setOnClickListener(new OnClickListener() {
				public void onClick(View v) {
	//				vGTop.removeView(v);
	//				v.setVisibility(View.GONE);					
				}
			});
		}
		return vHelper;
	}
	
	/**
	 * @return {@link View}
	 * 닫기 버튼을 추가합니다.
	 */
	private View addCloseButton() {
		ImageView ivCloseBtnBase = (ImageView) activity.findViewById(mCloseBtnBase);
		if ( ivCloseBtnBase != null ) {
			int[] location = new int[2];
			ivCloseBtnBase.getLocationOnScreen(location);
			int   baseLeft = location[0];
			int   baseTop  = location[1];
			
			LayoutParams iClp = new LayoutParams(LayoutParams.WRAP_CONTENT, LayoutParams.WRAP_CONTENT, Gravity.LEFT);	
			ImageView ivClose = new ImageView(activity);
			if ( mType == R.string.TITLE_TYPE_CARD ) {	
				ivClose.setBackgroundResource(R.drawable.guide_btn_close_green);
			} else if ( mType == R.string.TITLE_TYPE_POINT ) {	
				ivClose.setBackgroundResource(R.drawable.guide_btn_close_orange);
			} else if ( mType == R.string.TITLE_TYPE_STORE ) {	
				ivClose.setBackgroundResource(R.drawable.guide_btn_close_blue);
			} else {
				
			}
			ivClose.setPadding(0, 0, 0, 0);
			iClp.leftMargin = baseLeft;			
			iClp.topMargin  = baseTop - mTopOffset;
			ivClose.setLayoutParams(iClp);	
			
			ivClose.setOnClickListener(new View.OnClickListener() {
				public void onClick(View v) {
					ViewGroup vGTop = (ViewGroup) ((ViewGroup) activity.findViewById(android.R.id.content))
							.getChildAt(0);
//			        applyRotation(1, 0, 90);
					vGTop.removeView(vgHelper);
					vgHelper = null;
				}
			});
			vgHelper.addView(ivClose);
		}
		return ivCloseBtnBase;
	}
	
	public void addImageBorder(ImageView ivBorder,int w, int h, FrameLayout flMain) {
		if ( mType == R.string.TITLE_TYPE_CARD ) {	
			ivBorder.setBackgroundResource(R.drawable.card_help_border);
		} else if ( mType == R.string.TITLE_TYPE_POINT ) {	
			ivBorder.setBackgroundResource(R.drawable.point_help_border);
		} else if ( mType == R.string.TITLE_TYPE_STORE ) {	
			ivBorder.setBackgroundResource(R.drawable.store_help_border);
		} else {
			
		}
		ivBorder.setPadding(0, 0, 0, 0);	
		LayoutParams iBlp = new LayoutParams(w, h,Gravity.CENTER_VERTICAL|Gravity.CENTER_HORIZONTAL);	
		iBlp.gravity = Gravity.CENTER_VERTICAL|Gravity.CENTER_HORIZONTAL;
		ivBorder.setLayoutParams(iBlp);
		
		flMain.addView(ivBorder);		
	}
	
	public void addImageQmark(ImageView ivQmark,int w, int h, int position, FrameLayout flMain) {
		if ( mType == R.string.TITLE_TYPE_CARD ) {	
			ivQmark.setBackgroundResource(R.drawable.card_help_qmark);
		} else if ( mType == R.string.TITLE_TYPE_POINT ) {	
			ivQmark.setBackgroundResource(R.drawable.point_help_qmark);
		} else if ( mType == R.string.TITLE_TYPE_STORE ) {	
			ivQmark.setBackgroundResource(R.drawable.store_help_qmark);
		} else {
		}
		
		ivQmark.setPadding(0, 0, 0, 0);
		LayoutParams iQlp = new LayoutParams(LayoutParams.WRAP_CONTENT, LayoutParams.WRAP_CONTENT, Gravity.LEFT);	

		if ( position == POSITION_LEFT_TOP ) {
			iQlp.gravity = Gravity.LEFT;
		} else if ( position == POSITION_LEFT_BOTTOM ) {
			iQlp.gravity = Gravity.LEFT | Gravity.BOTTOM ;
		} else if ( position == POSITION_RIGHT_TOP ) {
			iQlp.gravity = Gravity.RIGHT;
		} else if ( position == POSITION_RIGHT_BOTTOM ) {
			iQlp.gravity = Gravity.RIGHT | Gravity.BOTTOM ;
		}
		ivQmark.setLayoutParams(iQlp);	
		flMain.addView(ivQmark);
	}
	
	/**
	 * App 사용 가이드 화면을 보여지게 합니다.
	 */
	public void showHelp() {
		View vHelper = setContentView(); // 기본 View 추가
		DisplayMetrics dm = new DisplayMetrics();
		activity.getWindowManager().getDefaultDisplay().getMetrics(dm);
		mTopOffset = dm.heightPixels - vGTop.getMeasuredHeight();		
		if ( vHelper != null ) {
			// 닫기 버튼 생성
			addCloseButton();
			for (final GSAppHelperDTO helper : lstHelper) {
/* 기본 위치및 크기 계산 --------------------------------------------------- */
				int[] location = new int[2];
				Rect  r = new Rect();
				View vBase = (View)helper.getResId();
				if ( vBase == null ) { 
					continue;
				} else {
					vBase.getLocalVisibleRect(r);
					vBase.getLocationOnScreen(location);					
				}

				int   baseWidth = r.width ();
				int   baseHeight= r.height();
				int   baseLeft = location[0];
				int   baseTop  = location[1];
				int ivBorderWidth = baseWidth  + mAddThick + helper.getAddWidth ();
				int ivBorderHeight= baseHeight + mAddThick + helper.getAddHeight();
/* --------------------------------------------------- 기본 위치및 크기 계산 */				
				// 테두리, ?마크가 들어갈 ViewGroup
				FrameLayout flMain = new FrameLayout(vgHelper.getContext());
				// 테두리 이미지 셋팅
				ImageView ivBorder = new ImageView(activity);
				addImageBorder(ivBorder,ivBorderWidth, ivBorderHeight,flMain); 
				
				// ?마크 이미지 셋팅
				ImageView ivQmark = new ImageView(activity);
				addImageQmark(ivQmark,ivBorderWidth, ivBorderHeight,helper.getPosition(),flMain); 	

//	 			flMain.setBackgroundColor(Color.RED);
				LayoutParams flp = new LayoutParams(ivBorderWidth+mAddArea, ivBorderHeight+mAddArea, Gravity.LEFT );	
				flp.leftMargin = baseLeft - (mAddThick+mAddArea)/2 + (helper.getAddLeft());			
				flp.topMargin  = baseTop  - mTopOffset - (mAddThick+mAddArea)/2 + (helper.getAddTop());
				flp.gravity = Gravity.LEFT;
				flMain.setLayoutParams(flp);
				
				if ( vBase.getVisibility() != View.VISIBLE || ( baseWidth == 0 || baseHeight == 0 ) || ( flp.topMargin < 0 ) ) {
	            //	Debug.trace(TAG,"위치나 크기가 < 0 " + " baseWidth : " + baseWidth + " / "
	            //									   + " baseHeight : " + baseHeight + " / "
	            //									   + " flp.topMargin : " + flp.topMargin
	            //			) ;
					flMain.setVisibility(View.INVISIBLE);				
				}
				vgHelper.addView(flMain);
				
				View.OnClickListener helpClick = new View.OnClickListener() {
		            public void onClick(View v) {
		            	View vHelperContent = (View) activity.findViewById(R.id.helper_content);	            	
		            	ImageView ivHelperContent = (ImageView) vHelperContent;	            	
		            	ivHelperContent.setImageResource(helper.getTxtResId());	            	
		            //	Debug.trace(TAG,"Agreement Ok - onClick - "  + v) ;
		            }
		        };
		        ivBorder.setOnClickListener(helpClick); 
		        ivQmark.setOnClickListener(helpClick); 
			}
//	        applyRotation(-1, 180, 90);
	    }
	}
	private int getRelativeLeft(View myView){
	    if(myView.getParent()==myView.getRootView())
	        return myView.getLeft();
	    else
	        return myView.getLeft() + getRelativeLeft((View)myView.getParent());
	}


	private int getRelativeTop(View myView){
	    if(myView.getParent()==myView.getRootView())
	        return myView.getTop();
	    else
	        return myView.getTop() + getRelativeTop((View)myView.getParent());
	}

	public int getAlpha() {
		return mAlpha;
	}

	public void setAlpha(int mAlpha) {
		this.mAlpha = mAlpha;
	}
	
//    /**
//     * Setup a new 3D rotation on the container view.
//     *
//     * @param position the item that was clicked to show a picture, or -1 to show the list
//     * @param start the start angle at which the rotation must begin
//     * @param end the end angle of the rotation
//     */
//    private void applyRotation(int position, float start, float end) {
//        // Find the center of the container
//        final float centerX = vGTop.getWidth() / 2.0f;
//        final float centerY = vGTop.getHeight() / 2.0f;
//
//        // Create a new 3D rotation with the supplied parameter
//        // The animation listener is used to trigger the next animation
//        final Rotate3dAnimation rotation =
//                new Rotate3dAnimation(start, end, centerX, centerY, 310.0f, true);
//        rotation.setDuration(500);
//        rotation.setFillAfter(true);
//        rotation.setInterpolator(new AccelerateInterpolator());
//        rotation.setAnimationListener(new DisplayNextView(position));
//
//        vgHelper.startAnimation(rotation);
//    }
//    /**
//     * This class listens for the end of the first half of the animation.
//     * It then posts a new action that effectively swaps the views when the container
//     * is rotated 90 degrees and thus invisible.
//     */
//    private final class DisplayNextView implements Animation.AnimationListener {
//        private final int mPosition;
//
//        private DisplayNextView(int position) {
//            mPosition = position;
//        }
//
//        public void onAnimationStart(Animation animation) {
//        }
//
//        public void onAnimationEnd(Animation animation) {
//        	vGTop.post(new SwapViews(mPosition));
//        }
//
//        public void onAnimationRepeat(Animation animation) {
//        }
//    }
//
//    /**
//     * This class is responsible for swapping the views and start the second
//     * half of the animation.
//     */
//    private final class SwapViews implements Runnable {
//        private final int mPosition;
//
//        public SwapViews(int position) {
//            mPosition = position;
//        }
//
//        public void run() {
//            final float centerX = vGTop.getWidth() / 2.0f;
//            final float centerY = vGTop.getHeight() / 2.0f;
//            Rotate3dAnimation rotation;
//            
//            if (mPosition > -1) {
//            	//vGTop.setVisibility(View.GONE);
//                vgHelper.setVisibility(View.VISIBLE);
//                vgHelper.requestFocus();
//
//                rotation = new Rotate3dAnimation(90, 180, centerX, centerY, 310.0f, false);
//            } else {
//                vgHelper.setVisibility(View.GONE);
//                vGTop.setVisibility(View.VISIBLE);
//                vGTop.requestFocus();
//                rotation = new Rotate3dAnimation(90, 0, centerX, centerY, 310.0f, false);
//            }
//
//            rotation.setDuration(500);
//            rotation.setFillAfter(true);
//            rotation.setInterpolator(new DecelerateInterpolator());
//
//            vgHelper.startAnimation(rotation);
//        }
//    }
}