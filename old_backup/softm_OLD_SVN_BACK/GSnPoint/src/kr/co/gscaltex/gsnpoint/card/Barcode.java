package kr.co.gscaltex.gsnpoint.card;

import android.content.Context;
import android.graphics.Canvas;
import android.graphics.Color;
import android.graphics.Paint;
import android.graphics.Paint.Style;
import android.util.AttributeSet;
import android.view.View;

public class Barcode extends View {
	public static final int STYLE_POTRAIT = 0;
	public static final int STYLE_LANDSCAPE = 1;

	public static final int PORTRAIT_WIDTH = 3;
	public static final int PORTRAIT_HEIGHT = 58;//76;

	public static final int LANDSCAPE_WIDTH = 4;
	public static final int LANDSCAPE_HEIGHT = 143;

	private String szBarcode;
	private int width;
	private int height;
	private Paint paint;

	public Barcode(Context context) {
		super(context);
		init(context);
	}

	public Barcode(Context context, AttributeSet attrs) {
		super(context, attrs);
		init(context);
	}

	public Barcode(Context context, AttributeSet attrs, int defStyle) {
		super(context, attrs, defStyle);
		init(context);
	}

	private void init(Context context) {
		width = PORTRAIT_WIDTH;
		height = PORTRAIT_HEIGHT;

		paint = new Paint();
		paint.setStyle(Style.STROKE);
		paint.setStrokeWidth(4);

	}

	public void setStyle(int style) {
		if (style == STYLE_POTRAIT) {
			width = PORTRAIT_WIDTH;
			height = PORTRAIT_HEIGHT;
		}
		else {
			width = LANDSCAPE_WIDTH;
			height = LANDSCAPE_HEIGHT;
		}
	}

	public void set16Digit(String digit) {
		szBarcode = digit;
		postInvalidate();
	}
	
	public String get16Digit() {
		return szBarcode;
	}

	@Override
	protected void onDraw(Canvas canvas) {
		super.onDraw(canvas);

		if (szBarcode == null)
			return;

		byte[] barcode = szBarcode.getBytes();
		int dx = (getMeasuredWidth() - barcode.length * width) / 2;
		int dy = (getMeasuredHeight() - height) / 2;

		for (int i = 0; i < barcode.length; i += 1) {
			if (barcode[i] == 0x31)
				paint.setColor(Color.BLACK);
			else
				paint.setColor(Color.WHITE);
			canvas.drawLine(dx, dy, dx, dy+height, paint);
			dx += width;
		}
	}
}