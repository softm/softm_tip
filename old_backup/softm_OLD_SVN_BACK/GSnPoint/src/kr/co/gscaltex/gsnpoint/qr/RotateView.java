package kr.co.gscaltex.gsnpoint.qr;

import android.content.Context;
import android.graphics.Canvas;
import android.graphics.Matrix;
import android.util.AttributeSet;
import android.view.MotionEvent;
import android.view.View;
import android.view.ViewGroup;

public class RotateView extends ViewGroup {
	//private static final float SQ2 = 1.414213562373095f;

	public RotateView(Context context) {
		super(context);
	}

	public RotateView(Context context, AttributeSet attrs) {
		super(context, attrs);
	}

	@Override
	protected void dispatchDraw(Canvas canvas) {
		canvas.save(Canvas.MATRIX_SAVE_FLAG);
		canvas.rotate(-90, getWidth()*0.5f, getHeight()*0.5f);
		super.dispatchDraw(canvas);
		canvas.restore();
	}

	@Override
	protected void onLayout(boolean changed, int l, int t, int r, int b) {
		final int width = getWidth();
		final int height = getHeight();
		final int count = getChildCount();
		for (int i = 0; i < count; i++) {
			final View view = getChildAt(i);
			final int childWidth = view.getMeasuredWidth();
			final int childHeight = view.getMeasuredHeight();
			final int childLeft = (width - childWidth) / 2;
			final int childTop = (height - childHeight) / 2;
			view.layout(childLeft, childTop, childLeft+childWidth, childTop+childHeight);
		}
	}

	@Override
	protected void onMeasure(int widthMeasureSpec, int heightMeasureSpec) {
		/*int w = getDefaultSize(getSuggestedMinimumWidth(), widthMeasureSpec);
		int h = getDefaultSize(getSuggestedMinimumHeight(), heightMeasureSpec);
		int sizeSpec;
		if (w > h) {
			sizeSpec = MeasureSpec.makeMeasureSpec((int) (w * SQ2), MeasureSpec.EXACTLY);
		} else {
			sizeSpec = MeasureSpec.makeMeasureSpec((int) (h * SQ2), MeasureSpec.EXACTLY);
		}*/
		final int count = getChildCount();
		for (int i = 0; i < count; i++) {
			getChildAt(i).measure(heightMeasureSpec, widthMeasureSpec);
			//getChildAt(i).measure(sizeSpec, sizeSpec);
		}
		super.onMeasure(widthMeasureSpec, heightMeasureSpec);
	}

	@Override
	public boolean dispatchTouchEvent(MotionEvent ev) {
		final float[] pts = {ev.getX(), ev.getY()};
		final float w_2 = getWidth() * 0.5f;
		final float h_2 = getHeight() * 0.5f;
		final Matrix m = new Matrix();
		m.setRotate(90, w_2, h_2);
		m.mapPoints(pts);
		ev.setLocation(pts[0], pts[1]);

		return super.dispatchTouchEvent(ev);
	}

	/*protected void dispatchSetPressed(boolean pressed) {
		super.dispatchSetPressed(pressed);
	}*/
}
