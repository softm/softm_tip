package kr.co.gscaltex.gsnpoint.qr;

import java.io.IOException;
import java.util.HashSet;
import java.util.List;
import java.util.Set;
import java.util.Vector;

import kr.co.gscaltex.gsnpoint.BaseActivity;
import kr.co.gscaltex.gsnpoint.NewMainMenu;
import kr.co.gscaltex.gsnpoint.R;
//import kr.co.gscaltex.gsnpoint.TabMenuView;
import kr.co.gscaltex.gsnpoint.TitleView;
import kr.co.gscaltex.gsnpoint.qr.camera.CameraManager;
import kr.co.gscaltex.gsnpoint.qr.history.HistoryManager;
import kr.co.gscaltex.gsnpoint.qr.result.ResultHandlerFactory;
import android.app.AlertDialog;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.res.AssetFileDescriptor;
import android.content.res.Configuration;
import android.graphics.Bitmap;
import android.graphics.Canvas;
import android.graphics.Paint;
import android.graphics.Rect;
import android.media.AudioManager;
import android.media.MediaPlayer;
import android.media.MediaPlayer.OnCompletionListener;
import android.net.Uri;
import android.os.Bundle;
import android.os.Handler;
import android.os.Vibrator;
import android.preference.PreferenceManager;
import android.text.ClipboardManager;
import android.util.Log;
import android.view.KeyEvent;
import android.view.SurfaceHolder;
import android.view.SurfaceView;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.widget.ImageButton;
import android.widget.LinearLayout;
import android.widget.Toast;

import com.google.zxing.BarcodeFormat;
import com.google.zxing.Result;
import com.google.zxing.ResultMetadataType;
import com.google.zxing.ResultPoint;
import com.google.zxing.client.result.ParsedResult;
import com.google.zxing.client.result.ParsedResultType;

public class CaptureActivity extends BaseActivity implements SurfaceHolder.Callback {
	private static final long BULK_MODE_SCAN_DELAY_MS = 1000L;
	private static final float BEEP_VOLUME = 0.10f;
	private static final long VIBRATE_DURATION = 200L;

	private static final String PRODUCT_SEARCH_URL_PREFIX = "http://www.google";
	private static final String PRODUCT_SEARCH_URL_SUFFIX = "/m/products/scan";
	private static final String ZXING_URL = "http://zxing.appspot.com/scan";
	private static final String RETURN_URL_PARAM = "ret";
	private boolean m_bLogin = false;
	
	private static final Set<ResultMetadataType> DISPLAYABLE_METADATA_TYPES;
	static {
		DISPLAYABLE_METADATA_TYPES = new HashSet<ResultMetadataType>(5);
		DISPLAYABLE_METADATA_TYPES.add(ResultMetadataType.ISSUE_NUMBER);
		DISPLAYABLE_METADATA_TYPES.add(ResultMetadataType.SUGGESTED_PRICE);
		DISPLAYABLE_METADATA_TYPES.add(ResultMetadataType.ERROR_CORRECTION_LEVEL);
		DISPLAYABLE_METADATA_TYPES.add(ResultMetadataType.POSSIBLE_COUNTRY);
	}

	private enum Source {
		NATIVE_APP_INTENT,
		PRODUCT_SEARCH_LINK,
		ZXING_LINK,
		NONE
	}

	private CaptureActivityHandler handler;

	private ViewfinderView viewfinderView;
	//private TextView statusView;
	//private View resultView;
	private MediaPlayer mediaPlayer;
	private boolean hasSurface;
	private boolean playBeep;
	private boolean vibrate;
	private boolean copyToClipboard;
	private Source source;
	private String sourceUrl;
	private String returnUrlTemplate;
	private Vector<BarcodeFormat> decodeFormats;
	private String characterSet;
	//private String versionName;
	private HistoryManager historyManager;
	private InactivityTimer inactivityTimer;

	public static LinearLayout mRotateView;
	private ImageButton mHistoryButton;

	protected void httpResult(int what, boolean result, String kind) {
		// TODO Auto-generated method stub
		
	}
	
	/**
	 * When the beep has finished playing, rewind to queue up another one.
	 */
	private final OnCompletionListener beepListener = new OnCompletionListener() {
		public void onCompletion(MediaPlayer mediaPlayer) {
			mediaPlayer.seekTo(0);
		}
	};

	ViewfinderView getViewfinderView() {
		return viewfinderView;
	}

	public Handler getHandler() {
		return handler;
	}

	
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);

		Window window = getWindow();
		window.requestFeature(Window.FEATURE_NO_TITLE);
		setContentView(R.layout.qrcode_main);

		CameraManager.init(getApplication());
		viewfinderView = (ViewfinderView)findViewById(R.id.viewfinder_view);
		mRotateView = (LinearLayout)findViewById(R.id.rotate_view);
		mHistoryButton = (ImageButton)findViewById(R.id.qrcode_history);

//		new TitleView(this, R.string.title_qrcode, mRotateView);
//		new TabMenuView(this);
		Bundle extras = getIntent().getExtras();
		if(extras!=null)
			m_bLogin = extras.getBoolean("login");
		
		new TitleView(this, true, false, R.string.TITLE_TYPE_QRSCAN_ROTATE,m_bLogin);
		new NewMainMenu(this);
		

		mHistoryButton.setOnClickListener(new View.OnClickListener() {
			public void onClick(View v) {
				
				List<Result> items = historyManager.getHistoryItems();
				if((items.size() <= 0)) {
					Intent intent = new Intent(CaptureActivity.this,
							QRCodeListActivity.class);
					intent.putExtra("login", m_bLogin);
					intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
					startActivity(intent);
				} else {
				Intent intent = new Intent(CaptureActivity.this,
						QRCodeGroupActivity.class);
				intent.putExtra("login", m_bLogin);
				intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
				startActivity(intent);
				}
			}
		});

		handler = null;
		hasSurface = false;
		historyManager = new HistoryManager(this);
		historyManager.trimHistory();
		inactivityTimer = new InactivityTimer(this);
	}

	private void logContentView(View parent, String indent) {
		//Debug.trace(Log.INFO, indent + parent.getClass().getName());
		if (parent instanceof ViewGroup) {
			ViewGroup group = (ViewGroup)parent;
			for (int i = 0; i < group.getChildCount(); i++)
				logContentView(group.getChildAt(i), indent + "  ");
		}
	}

	
	protected void onResume() {
		super.onResume();

		SurfaceView surfaceView = (SurfaceView)findViewById(R.id.preview_view);
		SurfaceHolder surfaceHolder = surfaceView.getHolder();
		if (hasSurface) {
			// The activity was paused but not stopped, so the surface still exists. Therefore
			// surfaceCreated() won't be called, so init the camera here.
			initCamera(surfaceHolder);
		}
		else {
			// Install the callback and wait for surfaceCreated() to init the camera.
			surfaceHolder.addCallback(this);
			surfaceHolder.setType(SurfaceHolder.SURFACE_TYPE_PUSH_BUFFERS);
		}

		Intent intent = getIntent();
		String action = intent == null ? null : intent.getAction();
		String dataString = intent == null ? null : intent.getDataString();
		if (intent != null && action != null) {
			if (action.equals(Intents.Scan.ACTION)) {
				// Scan the formats the intent requested, and return the result to the calling activity.
				source = Source.NATIVE_APP_INTENT;
				decodeFormats = DecodeFormatManager.parseDecodeFormats(intent);
			}
			else if (dataString != null &&
					dataString.contains(PRODUCT_SEARCH_URL_PREFIX) &&
					dataString.contains(PRODUCT_SEARCH_URL_SUFFIX)) {
				// Scan only products and send the result to mobile Product Search.
				source = Source.PRODUCT_SEARCH_LINK;
				sourceUrl = dataString;
				decodeFormats = DecodeFormatManager.PRODUCT_FORMATS;
			}
			else if (dataString != null && dataString.startsWith(ZXING_URL)) {
				// Scan formats requested in query string (all formats if none specified).
				// If a return URL is specified, send the results there. Otherwise, handle it ourselves.
				source = Source.ZXING_LINK;
				sourceUrl = dataString;
				Uri inputUri = Uri.parse(sourceUrl);
				returnUrlTemplate = inputUri.getQueryParameter(RETURN_URL_PARAM);
				decodeFormats = DecodeFormatManager.parseDecodeFormats(inputUri);
			}
			else {
				// Scan all formats and handle the results ourselves (launched from Home).
				source = Source.NONE;
				decodeFormats = null;
			}
			characterSet = intent.getStringExtra(Intents.Scan.CHARACTER_SET);
		}
		else {
			source = Source.NONE;
			decodeFormats = null;
			characterSet = null;
		}

		SharedPreferences prefs = PreferenceManager.getDefaultSharedPreferences(this);
		playBeep = prefs.getBoolean(PreferencesActivity.KEY_PLAY_BEEP, true);
		if (playBeep) {
			// See if sound settings overrides this
			AudioManager audioService = (AudioManager)getSystemService(AUDIO_SERVICE);
			if (audioService.getRingerMode() != AudioManager.RINGER_MODE_NORMAL) {
				playBeep = false;
			}
		}
		vibrate = prefs.getBoolean(PreferencesActivity.KEY_VIBRATE, false);
		copyToClipboard = prefs.getBoolean(PreferencesActivity.KEY_COPY_TO_CLIPBOARD, true);
		initBeepSound();
		inactivityTimer.onActivity();
	}

	
	protected void onPause() {
		super.onPause();
		inactivityTimer.cancel();
		if (handler != null) {
			handler.quitSynchronously();
			handler = null;
		}
		CameraManager.get().closeDriver();
	}

	
	protected void onDestroy() {
		inactivityTimer.shutdown();
		super.onDestroy();
	}

	
	public boolean onKeyDown(int keyCode, KeyEvent event) {
		if (keyCode == KeyEvent.KEYCODE_BACK &&
			event.getRepeatCount() == 0) {
			// �����?���α׷� ���� �ڵ带 ��������.
			return true;
		}

		return super.onKeyDown(keyCode, event);
	}

	
	public void onConfigurationChanged(Configuration config) {
		// Do nothing, this is to prevent the activity from being restarted when the keyboard opens.
		super.onConfigurationChanged(config);
	}

	public void surfaceCreated(SurfaceHolder holder) {
		if (!hasSurface) {
			hasSurface = true;
			initCamera(holder);
		}
	}

	public void surfaceDestroyed(SurfaceHolder holder) {
		hasSurface = false;
	}

	public void surfaceChanged(SurfaceHolder holder, int format, int width, int height) {

	}

	/**
	 * A valid barcode has been found, so give an indication of success and show the results.
	 *
	 * @param rawResult The contents of the barcode.
	 * @param barcode	 A greyscale bitmap of the camera data which was decoded.
	 */
	public void handleDecode(Result rawResult, Bitmap barcode) {
		//inactivityTimer.onActivity();
		inactivityTimer.cancel();
		historyManager.addHistoryItem(rawResult);
		if (barcode == null) {
			// This is from history -- no saved barcode
			handleDecodeInternally(rawResult, null);
		}
		else {
			playBeepSoundAndVibrate();
			drawResultPoints(barcode, rawResult);
			switch (source) {
				case NATIVE_APP_INTENT:
				case PRODUCT_SEARCH_LINK:
					handleDecodeExternally(rawResult, barcode);
					break;
				case ZXING_LINK:
					if (returnUrlTemplate == null) {
						handleDecodeInternally(rawResult, barcode);
					}
					else {
						handleDecodeExternally(rawResult, barcode);
					}
					break;
				case NONE:
					SharedPreferences prefs = PreferenceManager.getDefaultSharedPreferences(this);
					if (prefs.getBoolean(PreferencesActivity.KEY_BULK_MODE, false)) {
						Toast.makeText(this, R.string.msg_bulk_mode_scanned, Toast.LENGTH_SHORT).show();
						// Wait a moment or else it will scan the same barcode continuously about 3 times
						if (handler != null) {
							handler.sendEmptyMessageDelayed(R.id.restart_preview, BULK_MODE_SCAN_DELAY_MS);
						}
					}
					else {
						handleDecodeInternally(rawResult, barcode);
					}
					break;
			}
		}
	}

	/**
	 * Superimpose a line for 1D or dots for 2D to highlight the key features of the barcode.
	 *
	 * @param barcode	 A bitmap of the captured image.
	 * @param rawResult The decoded results which contains the points to draw.
	 */
	private void drawResultPoints(Bitmap barcode, Result rawResult) {
		ResultPoint[] points = rawResult.getResultPoints();
		if (points != null && points.length > 0) {
			Canvas canvas = new Canvas(barcode);
			Paint paint = new Paint();
			paint.setColor(getResources().getColor(R.color.result_image_border));
			paint.setStrokeWidth(3.0f);
			paint.setStyle(Paint.Style.STROKE);
			Rect border = new Rect(2, 2, barcode.getWidth() - 2, barcode.getHeight() - 2);
			canvas.drawRect(border, paint);

			paint.setColor(getResources().getColor(R.color.result_points));
			if (points.length == 2) {
				paint.setStrokeWidth(4.0f);
				drawLine(canvas, paint, points[0], points[1]);
			}
			else if (points.length == 4 &&
				 (rawResult.getBarcodeFormat().equals(BarcodeFormat.UPC_A)) ||
				 (rawResult.getBarcodeFormat().equals(BarcodeFormat.EAN_13))) {
				// Hacky special case -- draw two lines, for the barcode and metadata
				drawLine(canvas, paint, points[0], points[1]);
				drawLine(canvas, paint, points[2], points[3]);
			}
			else {
				paint.setStrokeWidth(10.0f);
				for (ResultPoint point : points) {
					canvas.drawPoint(point.getX(), point.getY(), paint);
				}
			}
		}
	}

	private static void drawLine(Canvas canvas, Paint paint, ResultPoint a, ResultPoint b) {
		canvas.drawLine(a.getX(), a.getY(), b.getX(), b.getY(), paint);
	}

	// Put up our own UI for how to handle the decoded contents.
	private void handleDecodeInternally(Result rawResult, Bitmap barcode) {
		ParsedResult result = ResultHandlerFactory.parseResult(rawResult);
		CharSequence displayContents = result.toString();
		if (copyToClipboard) {
			ClipboardManager clipboard = (ClipboardManager)getSystemService(CLIPBOARD_SERVICE);
			clipboard.setText(displayContents);
		}
		//Debug.trace(Log.DEBUG,"hongma test"+result.toString() );

/*
		if (result.getType().equals(ParsedResultType.URI)) {
			Intent intent = new Intent(Intent.ACTION_VIEW,
					Uri.parse(displayContents.toString()));
			intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_WHEN_TASK_RESET);
			intent.putExtra("login", m_bLogin);
			intent.addFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
			startActivity(intent);
*/
		if (result.getType().equals(ParsedResultType.URI)) {  //sbhong@truemobile.com
			if(checktype(result.toString()))
			{
				Intent intent = new Intent(this, QRCodeResultActivity.class);
				intent.putExtra("displayContents", result.getType().toString());
				intent.putExtra("result", displayContents.toString());
				intent.putExtra("login", m_bLogin);
				intent.addFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
				startActivity(intent);
				
			}else{
				Intent intent = new Intent(Intent.ACTION_VIEW,
						Uri.parse(displayContents.toString()));
				intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_WHEN_TASK_RESET);
				intent.putExtra("login", m_bLogin);
				intent.addFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
				startActivity(intent);
			}
		}
		else {
			Intent intent = new Intent(this, QRCodeResultActivity.class);
			intent.putExtra("displayContents", result.getType().toString());
			intent.putExtra("result", displayContents.toString());
			intent.putExtra("login", m_bLogin);
			intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
			startActivity(intent);
		}
	}
//sbhong@truemobile.com  email check code	
	public boolean checktype (String string)
	{		
		if(string.length() > 5){
			if (string.substring(0,6).equals("email:"))
			{
				return true;
			}
		}		
		return false;
	}
	// Briefly show the contents of the barcode, then handle the result outside Barcode Scanner.
	private void handleDecodeExternally(Result rawResult, Bitmap barcode) {
		viewfinderView.drawResultBitmap(barcode);

		ParsedResult result = ResultHandlerFactory.parseResult(rawResult);
		CharSequence displayContents = result.toString();
		if (copyToClipboard) {
			ClipboardManager clipboard = (ClipboardManager)getSystemService(CLIPBOARD_SERVICE);
			clipboard.setText(displayContents);
		}
	}

	/**
	 * Creates the beep MediaPlayer in advance so that the sound can be triggered with the least
	 * latency possible.
	 */
	private void initBeepSound() {
		if (playBeep && mediaPlayer == null) {
			// The volume on STREAM_SYSTEM is not adjustable, and users found it too loud,
			// so we now play on the music stream.
			setVolumeControlStream(AudioManager.STREAM_MUSIC);
			mediaPlayer = new MediaPlayer();
			mediaPlayer.setAudioStreamType(AudioManager.STREAM_MUSIC);
			mediaPlayer.setOnCompletionListener(beepListener);

			AssetFileDescriptor file = getResources().openRawResourceFd(R.raw.beep);
			try {
				mediaPlayer.setDataSource(file.getFileDescriptor(), file.getStartOffset(),
						file.getLength());
				file.close();
				mediaPlayer.setVolume(BEEP_VOLUME, BEEP_VOLUME);
				mediaPlayer.prepare();
			}
			catch (IOException e) {
				mediaPlayer = null;
			}
		}
	}

	private void playBeepSoundAndVibrate() {
		if (playBeep && mediaPlayer != null) {
			mediaPlayer.start();
		}
		if (vibrate) {
			Vibrator vibrator = (Vibrator)getSystemService(VIBRATOR_SERVICE);
			vibrator.vibrate(VIBRATE_DURATION);
		}
	}

	private void initCamera(SurfaceHolder surfaceHolder) {
		try {
			CameraManager.get().openDriver(surfaceHolder);
		}
		catch (IOException ioe) {
			//Debug.trace(Log.WARN, ioe.toString());
			displayFrameworkBugMessageAndExit();
			return;
		}
		catch (RuntimeException e) {
			// Barcode Scanner has seen crashes in the wild of this variety:
			// java.?lang.?RuntimeException: Fail to connect to camera service
			//Debug.trace(Log.WARN, "Unexpected error initializating camera");
			displayFrameworkBugMessageAndExit();
			return;
		}
		if (handler == null) {
			handler = new CaptureActivityHandler(this, decodeFormats, characterSet);
		}
	}

	private void displayFrameworkBugMessageAndExit() {
		AlertDialog.Builder builder = new AlertDialog.Builder(this);
		builder.setTitle(getString(R.string.alert_str));
		builder.setMessage(getString(R.string.msg_camera_framework_bug));
		builder.setPositiveButton(R.string.button_ok, new FinishListener(this));
		builder.setOnCancelListener(new FinishListener(this));
		builder.show();
	}

	public void drawViewfinder() {
		viewfinderView.drawViewfinder();
	}
}
