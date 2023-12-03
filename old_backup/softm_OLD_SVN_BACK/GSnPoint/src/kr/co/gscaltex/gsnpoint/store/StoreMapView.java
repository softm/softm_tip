package kr.co.gscaltex.gsnpoint.store;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.util.ArrayList;
import java.util.Collections;
import java.util.Comparator;
import java.util.List;
import java.util.Locale;

import kr.co.gscaltex.gsnpoint.BaseMapActivity;
import kr.co.gscaltex.gsnpoint.DefaultApplication;
import kr.co.gscaltex.gsnpoint.GSAppHelper;
import kr.co.gscaltex.gsnpoint.NewMainMenu;
import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.SpinnerGS;
import kr.co.gscaltex.gsnpoint.TitleView;
import kr.co.gscaltex.gsnpoint.dao.DatabaseAdapter;
import kr.co.gscaltex.gsnpoint.dao.StoreInfoModel;
import kr.co.gscaltex.gsnpoint.util.Util;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.res.AssetManager;
import android.graphics.Color;
import android.graphics.Paint;
import android.graphics.Point;
import android.graphics.drawable.Drawable;
import android.hardware.Sensor;
import android.hardware.SensorEvent;
import android.hardware.SensorEventListener;
import android.hardware.SensorManager;
import android.location.Address;
import android.location.Criteria;
import android.location.Geocoder;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.Bundle;
import android.os.Handler;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.view.animation.AlphaAnimation;
import android.view.animation.Animation;
import android.view.animation.AnimationSet;
import android.view.animation.TranslateAnimation;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.FrameLayout;
import android.widget.ImageButton;
import android.widget.Toast;

import com.google.android.maps.GeoPoint;
import com.google.android.maps.MapController;
import com.google.android.maps.MapView;
import com.google.android.maps.Projection;

public class StoreMapView extends BaseMapActivity implements OnClickListener, SensorEventListener,LocationListener{
	String TAG = "yksong";
	
	DefaultApplication mApp ;	
	private Handler handler = new Handler();
		
	private boolean m_bLogin = false;
	private String lati ;  
	private String longi ;
	
	private Double latiValue ;
	private Double longiValue ;
	
	/*shake sensor*/
	private long lastTime;
	private float speed;
	private float lastX;
	private float lastY;
	private float lastZ;
	
	private float x, y, z;
	private static final int SHAKE_THRESHOLD = 800;
	private static final int DATA_X = SensorManager.DATA_X;
	private static final int DATA_Y = SensorManager.DATA_Y;
	private static final int DATA_Z = SensorManager.DATA_Z;
	
	private SensorManager sensorManager;
	private Sensor accelerormeterSensor;
	
	private StoreMapViewEx   mapView      ;
	private MapController mapController;
	
	//private int searchType = Util.BUSI_CD_ALL;
	private String searchType = Util.BUSI_CD_ALL;
	
	private int mTabSelect = 0; 
	private int mKmSelect  = 0; 	
	public static final int TAB_BUTTON_COUNT = 5;
	public static final int KM_BUTTON_COUNT = 3; 
	private final double DISTANCE_1 = 1;
	private final double DISTANCE_2 = 2;
	private final double DISTANCE_3 = 6;
	
	private Criteria criteria;
	private LocationManager locM ;
	private Geocoder geocoder;
	
	private ArrayList<String> cities = new ArrayList<String>();
	private ArrayList<String> towns = new ArrayList<String>();
	private String[] sidoItems = {" 도/시", "서울","부산","대구","인천","광주","대전","울산","강원",
			"경기","경남","경북","전남","전북","제주","충남","충북"};
	private String[] categoryItems = {" 카테고리", " 주유소"," 셀프주유소"," GS25"," 기타"};
	
	private ProgressDialog mProgressDialog;
	
	public static final String DATABASE_DIR = "/data/data/kr.co.gscaltex.gsnpoint/databases";
	//public static final String DATABASE_DIR = Environment.getExternalStorageDirectory().getAbsolutePath() + "/";
	public static final String DATABASE_NAME = "npoint.db";
	//public static final String DATABASE_NAME = "npoint.mp3";
	
	private DatabaseAdapter mDatabaseAdapter;
	//private DatabaseAdapter mDatabaseAdapter;
	private ArrayList<StoreInfoModel> stores = null;
	private Location location;
	private Location mCurrentLocation;
	
	private ViewGroup mMContainer; 
	private ViewGroup mSContainer; 
	private ImageButton[] mTabButtons = new ImageButton[TAB_BUTTON_COUNT];
	private ImageButton[] mKmButtons  = new ImageButton[KM_BUTTON_COUNT];
	private ImageButton mSearchButton = null;
	private EditText mSearchEdit = null;
	
	private FrameLayout mSearch =null;
	
	private SpinnerGS mSpnSido , mSpngugun, mSpndong, mSpnCategory = null;
	private GeoPoint newCentPoint;  //sbhong@truemobile.com 

	private Boolean bGuide = false;
	
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.storemapmain);

		appHelper = new GSAppHelper(this, R.string.TITLE_TYPE_STORE, R.id.help_button);
		
		appHelper.add(findViewById(R.id.tab_store01          ),R.drawable.guide_guide04_ex01,GSAppHelper.POSITION_LEFT_TOP,-40,-20,20,9);
		appHelper.add(findViewById(R.id.tab_store02          ),R.drawable.guide_guide04_ex02,GSAppHelper.POSITION_LEFT_TOP,-40,-20,20,9);
		appHelper.add(findViewById(R.id.tab_store03          ),R.drawable.guide_guide04_ex03,GSAppHelper.POSITION_LEFT_TOP,-40,-20,20,9);
		appHelper.add(findViewById(R.id.tab_store04          ),R.drawable.guide_guide04_ex04,GSAppHelper.POSITION_LEFT_TOP,-40,-20,20,9);
		appHelper.add(findViewById(R.id.tab_store05          ),R.drawable.guide_guide04_ex05,GSAppHelper.POSITION_LEFT_TOP,-40,-20,20,9);
		appHelper.add(findViewById(R.id.img_btn_searcher_open),R.drawable.guide_guide04_ex06,GSAppHelper.POSITION_RIGHT_TOP);
	
		Bundle extras = getIntent().getExtras();
		if(extras!=null){
			m_bLogin = extras.getBoolean("login");
			lati = extras.getString("Latitude"); //sbhong@truemobile.com 
			longi = extras.getString("Longitude");
			}

		if((lati!=null)&&(longi!=null)){
			bGuide= true;
			latiValue = Double.valueOf(lati);
			longiValue = Double.valueOf(longi);
		}
			
		new TitleView(this, true, true, true, R.string.TITLE_TYPE_STORE,m_bLogin);
		new NewMainMenu(this);

		init();
		
		mapController.setZoom(getDistanceZoom());
		
			
		if(!bGuide){
			File file=  new File(getDatabasePath(DATABASE_NAME).getAbsolutePath());
			if (file.exists()) {			
				prcessingInit(PRC_REFRESH_DISPLAY, null);
			} 		else {			
				prcessingInit(PRC_COPY_DB, null);
			}
		}

		mapView.setOnChangeListener(new MapViewChangeListener());

	}

	 private class MapViewChangeListener implements StoreMapViewEx.OnChangeListener
    {
        @Override
        public void onChange(MapView view, GeoPoint newCenter, GeoPoint oldCenter, int newZoom, int oldZoom)
        {           
            if (!newCenter.equals(oldCenter) && mSearchEdit.getText().toString().length() == 0 && !bGuide)
            {
                // Map Pan Detected
                // TODO: Add special action here
            	if(mapView.isSpanChange())
	    		{
					newCentPoint = newCenter;
					handler.post(getStoresRunnable2);
	    		} 
            }
        }
    }
	
	private FranchisesOverlay getFranchiseItemOverlay(){
		return (FranchisesOverlay)mapView.getOverlays().get(0);
	}

	private FranchiseTooltipOverlay getFranchiseTooltipOverlay(){
		return (FranchiseTooltipOverlay)mapView.getOverlays().get(1);
	}
	
	private Location getLastLocation(){
		LocationManager loc = (LocationManager) getSystemService(Context.LOCATION_SERVICE);
		String bestProvider = loc.getBestProvider(new Criteria(), true);
		Location locat = loc.getLastKnownLocation(bestProvider);
		if( locat == null ){
			locat = new Location(bestProvider);
			locat.setLatitude(37.380615);
			locat.setLongitude(127.115875);
		}
		return locat;
	}
	
	private void setMarkerImage(int drawable){
		mapView.getOverlays().clear();
		Drawable itemDrawable = getResources().getDrawable(drawable);
		final FranchisesOverlay itemOverlay = new FranchisesOverlay( itemDrawable);
		itemOverlay.setOnSelectedItemListener(mFranchiseSelectListener);
		
		
		Drawable drawableTooltip = getResources().getDrawable(R.drawable.img_mapinfol);
		final FranchiseTooltipOverlay tooltipOverlay = new FranchiseTooltipOverlay(drawableTooltip);
		tooltipOverlay.setOnSelectedItemListener(mFranchiseToolTipSelectListener);
		tooltipOverlay.setOffset(0, (itemDrawable.getBounds().height()-5) * -1);
		
		mapView.getOverlays().add(itemOverlay);
		mapView.getOverlays().add(tooltipOverlay);
	}
	private void init(){
		
		mapView = (StoreMapViewEx)findViewById(R.id.mapView);		
		mapController = mapView.getController();
		
		setMarkerImage(R.drawable.icon_store02);
		
		setEventListener(); // ?�벤???�들???�록
		
		mMContainer = (ViewGroup) findViewById(R.id.map_container      ); 
		mSContainer = (ViewGroup) findViewById(R.id.searcher_container ); 
		mMContainer.setVisibility(View.VISIBLE );
		mSContainer.setVisibility(View.GONE    );

		mSearchButton = (ImageButton)findViewById(R.id.img_btn_search);
		mSearchButton.setOnClickListener(this);
		
		mSearchEdit = (EditText)findViewById(R.id.edt_search_name);
		
		Paint paint1 = new Paint(); 
		paint1.setColor(Color.BLACK);
		paint1.setAlpha(50);        
		findViewById(R.id.map_preventer).setBackgroundColor(paint1.getColor());

		mSearch = (FrameLayout)findViewById(R.id.layout_search);
		mSearch.setBackgroundColor(paint1.getColor());
		
		initSpinner();
		
		sensorManager = (SensorManager)getSystemService(SENSOR_SERVICE);
		accelerormeterSensor = sensorManager.getDefaultSensor(Sensor.TYPE_ACCELEROMETER);
		
		mapView.setBuiltInZoomControls(false);
	}
	
	private void initSpinner() {
		
		mSpnSido = (SpinnerGS)findViewById(R.id.spn_sido);
		mSpngugun = (SpinnerGS)findViewById(R.id.spn_gugun);
		mSpndong = (SpinnerGS)findViewById(R.id.spn_dong);
		mSpnCategory = (SpinnerGS)findViewById(R.id.spn_category);
		
		mSpnSido.addItems(sidoItems);
		mSpnCategory.addItems(categoryItems);
		
		mSpnSido.setOnItemSelectedListener(new OnItemSelectedListener() {
			public void onItemSelected(AdapterView<?> parent, View v, int position, long id) {

				if (mDatabaseAdapter == null || position == 0) {
					//mSpngugun.addItem(getString(R.string.addr_gugun));
					//mSpndong.addItem(getString(R.string.addr_dong));
					
					towns.clear();
					towns.add(getString(R.string.addr_dong));
					dongRefresh(towns);
										
					cities.clear();
					cities.add(getString(R.string.addr_gugun));
					guRefresh(cities);
					
				}
				else {
					String text = (String)mSpnSido.getSelectedItem();
					
					towns.clear();
					dongRefresh(towns);
										
					cities.clear();
					cities = mDatabaseAdapter.selectAddressByCity(parent.getContext(),
							text);
					guRefresh(cities);
				}
			}
			public void onNothingSelected(AdapterView<?> parent) {
			}
		});

		mSpngugun.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
			public void onItemSelected(AdapterView<?> parent, View v, int position, long id) {
				if (mDatabaseAdapter == null && position == 0) {
					mSpngugun.addItem(getString(R.string.addr_gugun));
					mSpndong.addItem(getString(R.string.addr_dong));
				}
				else {
					String text = (String)mSpngugun.getSelectedItem();

					towns = new ArrayList<String>();
					towns = mDatabaseAdapter.selectAddressByTown(parent.getContext(),
							text);
					dongRefresh(towns);
				}
			}
			public void onNothingSelected(AdapterView<?> parent) {
			}
		});

		mSpndong.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener(){
			public void onItemSelected(AdapterView<?> parent, View v, int position, long id) {
				
				if (mDatabaseAdapter == null && position == 0) {
					mSpndong.addItem(getString(R.string.addr_dong));
				}else {
					
				}
			}
			public void onNothingSelected(AdapterView<?> parent) {
			}
		});
		
		mSpnCategory.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener(){
			public void onItemSelected(AdapterView<?> parent, View v, int position, long id) {
				
				if (mDatabaseAdapter == null && position == 0) {
				}else if(position == 0){				
				}
				else {
					if(mSpndong.getSelectedItemPosition()!=0){
						
						mTabSelect = mSpnCategory.getSelectedItemPosition();
						setTabpageIndex();
						
					}
				}
			}
			public void onNothingSelected(AdapterView<?> parent) {
			}
		});
		
	}

	private void initSpinnerValue() {	

			mSearchEdit.setText("");
			mSpnSido.setSelection(0);
			mSpngugun.setSelection(0);
			mSpndong.setSelection(0);
			mSpnCategory.setSelection(0);		

		}
	
	private Location getGeoPosition(String address){
		List<Address> listAddress;
		Address AddrAddress;
		Location location = new Location(mCurrentLocation);
		
		geocoder = new Geocoder(this, Locale.KOREAN);
		
		try{
			listAddress = geocoder.getFromLocationName(address, 5);
			
			if(listAddress.size()>0){
				AddrAddress = listAddress.get(0);
				location.setLatitude(AddrAddress.getLatitude());
				location.setLongitude(AddrAddress.getLongitude());
				
			}
		}catch(IOException e){
			e.printStackTrace();
		}
		return location;
	}
	public void onClick(View v) {
		// TODO Auto-generated method stub
		
		ImageButton imgBtnHelp  = (ImageButton)findViewById(R.id.help_button);

		switch (v.getId()) {

		case R.id.map_preventer:
			break;
		case R.id.img_btn_searcher_open: // ?�기 : ?�단 pi ?�릭???�시조회 창이 보여지�
			mSContainer.setVisibility(View.VISIBLE );
			setLayoutAnim_slidedown(mSContainer, this);		
			imgBtnHelp.setVisibility(View.GONE);
			break;

		case R.id.img_btn_searcher_close: // ?�기 : ?�단 pi ?�릭???�시조회 창이 보여지�
			setLayoutAnim_slideup(mSContainer, this);			
			mSContainer.setVisibility(View.GONE );
			imgBtnHelp.setVisibility(View.VISIBLE);
			break;

		case R.id.img_btn_store:      // ?�?��?맹점보기	
			Intent intent = new Intent(this, kr.co.gscaltex.gsnpoint.store.StoreRepresentView.class);
			intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
			startActivity(intent);		
			break;

		case R.id.img_btn_search:
			if(mSpnSido.getSelectedItemPosition()<=0){
				AlertDialogMsg(R.string.si_gun_gu_alert1);
			}else if(mSpngugun.getSelectedItemPosition()<=0){
				AlertDialogMsg(R.string.si_gun_gu_alert2);
			}else{
				searchByKeyword();
			}
				
			
		default:
			break;
		}
		
	}
	
	private void prcessingInit(int proc_what, Object obj){
		android.os.Message msg = mInitHandler.obtainMessage(proc_what, obj);
		mInitHandler.sendMessage(msg);
	}
	
	private void guRefresh(ArrayList<String> cities){
		ArrayAdapter<String> adapter = new ArrayAdapter<String>(this,
				android.R.layout.simple_spinner_item, cities);
		adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
		mSpngugun.setAdapter(adapter);
	}
	
	private void dongRefresh(ArrayList<String> towns){
		if (towns == null || towns.size() == 0) {			
		}
		else {
			ArrayAdapter<String> adapter = new ArrayAdapter<String>(this,
					android.R.layout.simple_spinner_item, towns);
			adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
			mSpndong.setAdapter(adapter);
		}		
	}
	

	private final int PRC_COPY_DB = 1;
	private final int PRC_REFRESH_DISPLAY = 3;
	private final int PRC_ALERT_SUCCESS = 6;
	private final int PRC_ALERT_FAIL = 7;
	
	private Handler mInitHandler = new Handler(){
		public void handleMessage(android.os.Message msg) {
			Thread thread = null;
			switch(msg.what){
		
			case PRC_COPY_DB:
				thread = new Thread(mCopyDatabaseRunnable);
				thread.start();
				break;
			
			case PRC_REFRESH_DISPLAY:
				//openDatabase();
				if(mCurrentLocation == null){
					mCurrentLocation = getLastLocation();
					location = mCurrentLocation;	
				}
				
				hideProgress();
				updateAndLocationInit();
				break;
				
			case PRC_ALERT_SUCCESS:
				hideProgress();
				AlertDialogMsg(R.string.download_complete);
				break;
			case PRC_ALERT_FAIL:
				hideProgress();
				AlertDialogMsg(R.string.update_fail);
				break;
			}
		};
	};
	
	private void initLocationManager(){
		locM = (LocationManager)getSystemService(Context.LOCATION_SERVICE);
		
		criteria = new Criteria();
		criteria.setAccuracy(Criteria.ACCURACY_FINE);		
		criteria.setPowerRequirement(Criteria.POWER_LOW);	
		criteria.setAltitudeRequired(false);				
		criteria.setBearingRequired(false);					
		criteria.setSpeedRequired(false);					
		criteria.setCostAllowed(true);						
		
		String provider = locM.getBestProvider(criteria, true);		

		locM.requestLocationUpdates(LocationManager.GPS_PROVIDER, 1000L, 0, mLocationListener);
		locM.requestLocationUpdates(LocationManager.NETWORK_PROVIDER, 1000L, 0, mLocationListener);	
		mCurrentLocation = locM.getLastKnownLocation(provider);
		
		if(mCurrentLocation != null) {
			long evtTime = mCurrentLocation.getTime() ;
			if (evtTime > (System.currentTimeMillis() - (2 * 60 * 60 * 1000))) {
				mCurrentLocation = locM.getLastKnownLocation( LocationManager.NETWORK_PROVIDER );
			}
			else {
			}			
		} else {
			mCurrentLocation = locM.getLastKnownLocation( LocationManager.NETWORK_PROVIDER );
  		} 
		location = mCurrentLocation;
		
		if(!bGuide){
			mTabSelect=0;
			mKmSelect =0;
		}else{
			mTabSelect=5;
			mKmSelect =3;
		}
	
		setTabpageIndex();
		setKmTabpageIndex();
		
		if(bGuide)
			handler.post(getStoresRunnable);
	}
	
	private void removeLocationManager(){
		if( locM != null )
			locM.removeUpdates(mLocationListener);
	}
	
	
	private Runnable mCopyDatabaseRunnable = new Runnable() {
		
		public void run() {			
			AssetManager am = getAssets();
			InputStream is = null;
			FileOutputStream fos = null;
			
			File file = new File(DATABASE_DIR);
			file.mkdir();

			file = new File(getDatabasePath(DATABASE_NAME).getAbsolutePath());
			
			try {
				byte[] buffer = new byte[1024*16];
				int length = 0;
				int totalLength = 0;

				file.createNewFile();
				fos = new FileOutputStream(file);

				String[] list = getAssetFileList("database");
				
				if( list == null ){
					return;
				}
				
				
				for (int i = 0; i < list.length; i++) {
					if( list[i].contains("npoint.") == false )
						continue;
					
					is = am.open("database/"+list[i], AssetManager.ACCESS_BUFFER);
					
					while( (length = is.read(buffer)) > 0) {
						fos.write(buffer, 0, length);
						totalLength += length;
						Thread.sleep(0);
					}
					
					is.close();
				}
			}
			catch (Exception ioe) {
				file.delete();
			}
			finally {
				try {fos.close();} catch (Exception e) {}
				prcessingInit(PRC_REFRESH_DISPLAY, null);
			}
		}
	};
	
	private void updateAndLocationInit() {
		if (mCurrentLocation != null) {
			location = mCurrentLocation;
			handler.post(getStoresRunnable);
		}
	}
	
	private GeoPoint getGeoPoint(Location location){
		if(location==null){
			return null;
		}else{
			Double lat = location.getLatitude()*1E6;
			Double lng = location.getLongitude()*1E6;
			return new GeoPoint(lat.intValue(),lng.intValue());
		}
	}
	
	private Runnable getStoresRunnable= new Runnable(){
		public void run() {
			searchByMap();
		}		
	};
	private Runnable getStoresRunnable2= new Runnable(){
		public void run() {
			searchByMap2(newCentPoint);
		}		
	};


	private void clearScreen(){
		final FranchisesOverlay overlay = getFranchiseItemOverlay();
		if( overlay != null ){
			overlay.clearItems();
		}
		
		final FranchiseTooltipOverlay tooltip = getFranchiseTooltipOverlay();
		if( tooltip != null ){
			tooltip.clearItems();
		}
	}
	private void searchByKeyword(){
		
		String[] args;
		String adress;
		//String temp = gugun.getText().toString();
		String temp =mSpngugun.getSelectedItem().toString();
		int length = temp.length();
		int index = temp.indexOf(' ');
		int count = 0;

		ArrayList<StoreInfoModel> franchise= null;
		
		if (index == -1) {
			args = new String[4];
			args[count++] = mSpnSido.getSelectedItem().toString();
			args[count++] = temp.substring(0, length-1);
		}
		else {
			args = new String[5];
			args[count++] = mSpnSido.getSelectedItem().toString();
			args[count++] = temp.substring(0, index-1);
			args[count++] = temp.substring(index+1, length-1);
		}

		if (mSpndong.getSelectedItemPosition() <= 0) {
			args[count++] = "";
		}
		else {
			temp = mSpndong.getSelectedItem().toString();
			length = temp.length();
			if (length > 0)
				args[count++] = temp.substring(0, length-1);
			else
				args[count++] = "";
		}

		args[count++] = mSearchEdit.getText().toString();

		if( mDatabaseAdapter == null ){
			mDatabaseAdapter = new DatabaseAdapter(this);
			mDatabaseAdapter.open();
		}
		
		if (mDatabaseAdapter != null) {
			setSpinnerSearchType();
			franchise = mDatabaseAdapter.selectStoreInfo(this, args,searchType);
		}else{
			
		}
	
		if (franchise == null || franchise.size() == 0) {
			Toast.makeText(this, Util.NOT_FOUND_RESULT,
					Toast.LENGTH_SHORT).show();
		}
		else {	
		
			clearScreen();

			drawLayers(franchise);
			
			int currentZoom = mapView.getZoomLevel();
			int nextZoom = getDistanceZoom();
			if (nextZoom > currentZoom) {
				for (int i = currentZoom; i < nextZoom; i ++)
					mapController.zoomIn();
			}
			else if (nextZoom < currentZoom) {
				for (int i = currentZoom; i > nextZoom; i --)
					mapController.zoomOut();
			}
					
			Location fran_loc = new Location(mCurrentLocation);
			
			fran_loc.setLatitude(Double.valueOf(franchise.get(0).getLat()));
			fran_loc.setLongitude(Double.valueOf(franchise.get(0).getLongi()));
							
			GeoPoint geoPoint = getGeoPoint(fran_loc);
			mapView.getController().animateTo(geoPoint);
			mapView.postInvalidate();
			
			mSContainer.setVisibility(View.GONE );
			
		}
	}
	private void searchByMap() {	
		double minx = 0;
		double maxy = 0;
		double maxx = 0;
		double miny = 0;

		if(bGuide){
			int id = R.drawable.icon_mappoint_01;
			
			clearScreen();
			setMarkerImage(id);
			
			FranchisesOverlay itemOverlay = getFranchiseItemOverlay();
			if( itemOverlay == null )
				return;
			
			Double lat = latiValue*1E6;
			Double lng = longiValue*1E6;
			
			
			Drawable itemDrawable1 = getResources().getDrawable(R.drawable.icon_mappoint);
			//itemOverlay.
			itemOverlay.addItems2(itemDrawable1, new GeoPoint(lat.intValue(),lng.intValue()));
				
			mapView.getController().animateTo(new GeoPoint(lat.intValue(),lng.intValue()));
			mapView.postInvalidate();

		}else{
			if( mDatabaseAdapter == null ){
				mDatabaseAdapter = new DatabaseAdapter(this);
				mDatabaseAdapter.open();
			}
					
			if (mDatabaseAdapter != null) {
				final double distance = getCurrentDistance();
				double addLat = 0.004 * distance;
				double addLng = 0.005 * distance;

				minx = location.getLatitude() - addLat;  
				maxx = location.getLatitude() + addLat;  
				miny = location.getLongitude() - addLng; 
				maxy = location.getLongitude() + addLng; 

				stores = new ArrayList<StoreInfoModel>();
				stores = mDatabaseAdapter.selectStoreInfoWhereIam(this,
						String.valueOf(minx),
						String.valueOf(miny),
						String.valueOf(maxx),
						String.valueOf(maxy),
						searchType);
				clearScreen();

				drawLayers(stores);
			}
			else {
			}

			int currentZoom = mapView.getZoomLevel();
			int nextZoom = getDistanceZoom();
			if (nextZoom > currentZoom) {
				for (int i = currentZoom; i < nextZoom; i ++)
					mapController.zoomIn();
			}
			else if (nextZoom < currentZoom) {
				for (int i = currentZoom; i > nextZoom; i --)
					mapController.zoomOut();
			}

	//		mapController.setZoom(getDistanceZoom());
			GeoPoint geoPoint = getGeoPoint(location);
			mapView.getController().animateTo(geoPoint);
			mapView.postInvalidate();
		}
	}
		
	private void searchByMap2(GeoPoint ceterValue) {	
		double minx = 0;
		double maxy = 0;
		double maxx = 0;
		double miny = 0;
		
		if( mDatabaseAdapter == null ){
			mDatabaseAdapter = new DatabaseAdapter(this);
			mDatabaseAdapter.open();
		}
		
		if (mDatabaseAdapter != null) {
			final double distance = getCurrentDistance();
			double addLat = 0.004 * distance;
			double addLng = 0.005 * distance;
			
			minx = ceterValue.getLatitudeE6() /1E6 - addLat;  
			maxx = ceterValue.getLatitudeE6() /1E6 + addLat;  
			miny = ceterValue.getLongitudeE6() /1E6 - addLng; 
			maxy = ceterValue.getLongitudeE6() /1E6 + addLng; 

			stores = new ArrayList<StoreInfoModel>();
			stores = mDatabaseAdapter.selectStoreInfoWhereIam(this,
					String.valueOf(minx),
					String.valueOf(miny),
					String.valueOf(maxx),
					String.valueOf(maxy),
					searchType);
			clearScreen();
			drawLayers(stores);
		}
		else {
		}
		mapView.getController().animateTo(ceterValue);
		mapView.postInvalidate();
	}

	private void drawLayers(ArrayList<StoreInfoModel> data){
		
		
		int id = R.drawable.icon_store02;
		
		if(mTabSelect==1){
			id = R.drawable.icon_store04;
		}else if(mTabSelect==2){
			id = R.drawable.icon_store01;
		}else if(mTabSelect==4)
			id = R.drawable.icon_store03;
		
		Drawable itemDrawable1 = getResources().getDrawable(R.drawable.icon_store04);
		Drawable itemDrawable2 = getResources().getDrawable(R.drawable.icon_store01);
		Drawable itemDrawable3 = getResources().getDrawable(R.drawable.icon_store02);
		Drawable itemDrawable4 = getResources().getDrawable(R.drawable.icon_store03);

		clearScreen();
		setMarkerImage(id);
		FranchisesOverlay itemOverlay = getFranchiseItemOverlay();
		if( itemOverlay == null )
			return;
		
		//itemOverlay.
		itemOverlay.addItems(data , itemDrawable1, itemDrawable2, itemDrawable3, itemDrawable4);

	}
	
	private void openDatabase(){
		if( mDatabaseAdapter == null ){
			mDatabaseAdapter = new DatabaseAdapter(getBaseContext());
			mDatabaseAdapter.open();
		}
	}
	
	private final LocationListener mLocationListener = new LocationListener() {
		public void onLocationChanged(Location loc) {
			mCurrentLocation = loc; 
			
		}
		public void onProviderDisabled(String provider) {
			
		}
		public void onProviderEnabled(String provider) {
			
		}
		public void onStatusChanged(String provider, int status, Bundle extras) {
			
		}
	};
	
	private class StringListCompare implements Comparator<String>{
		public int compare(String object1, String object2) {
			return object1.compareTo(object2);
		};
	}
	
	private String[] getAssetFileList(String dir_name){
		try{
			AssetManager am = getAssets();
			String list[] = am.list(dir_name);
			
			if( list == null )
				return null;
			
			ArrayList<String> names = new ArrayList<String>();
			
			for( int i = 0; i < list.length; i++ ){
				names.add(list[i]);
			}
			Comparator comp = new StringListCompare();
			Collections.sort(names, comp);
			return names.toArray(new String[0]);
		}catch(Exception ex){
			return null;
		}
	}

	protected void onDestroy() {
		if( mDatabaseAdapter != null )
			mDatabaseAdapter.close();
		super.onDestroy();
	}
	
//	private String provider = LocationManager.GPS_PROVIDER;
//	private long minTime = 0L;
//	private float minDistance = 0.0f;
	
	protected void onStart(){
		super.onStart();
		
		initLocationManager();
		if(accelerormeterSensor != null)
			sensorManager.registerListener(this, accelerormeterSensor,
					SensorManager.SENSOR_DELAY_GAME);
	/*	
		locTest = (LocationManager)getSystemService(Context.LOCATION_SERVICE);
		Location location = locTest.getLastKnownLocation(provider);
		
		if(location !=null){
			onLocationChanged(location);
		}
		locTest.requestLocationUpdates(provider, minTime, minDistance, this);
*/
	}
	protected void onResume() {
		super.onResume();
	}
	
	
	protected void onStop() {
		removeLocationManager();
		
		if(sensorManager != null)
			sensorManager.unregisterListener(this);
		
		super.onStop();
	}
	
	private double getCurrentDistance(){
		if( mKmButtons[1].isSelected() )
			return DISTANCE_2;
		
		if( mKmButtons[2].isSelected() )
			return DISTANCE_3;
		
		return DISTANCE_1;
	}
	
	private int getDistanceZoom(){
		if( mKmButtons[1].isSelected() )
			return 17;
		
		if( mKmButtons[2].isSelected() )
			return 15;
		
		return 18;
	}
	
	/**
	 * ?�단 ??- ?�벤??처리
	 */
	private OnClickListener mTabMenuClick = new OnClickListener() {
		public void onClick(View v) {
			mTabSelect = v.getId();
			setTabpageIndex();
			bGuide= false;
			handler.post(getStoresRunnable);
		}
	};

	/**
	
	 * Km 버튼 - ?�벤??처리
	 */
	private OnClickListener mKmClick = new OnClickListener() {
		public void onClick(View v) {
			mKmSelect = v.getId();
			setKmTabpageIndex();
			bGuide= false;
			handler.post(getStoresRunnable);
		}
	};
	
	private void setSpinnerSearchType(){
		int select=0;
		select = mSpnCategory.getSelectedItemPosition();
		searchType= Util.BUSI_CD_ALL;
		
		switch (select) {
		case 1:
			searchType = Util.BUSI_CD_2;
			break;
		case 2:
			searchType = Util.BUSI_CD_1;
			break;
		case 3:
			searchType = Util.BUSI_CD_3;
			break;
		case 4:
			searchType = Util.BUSI_CD_4;
			break;
		}
	}
	/**
	 * ?�단 ??�� ?�택???�태�?만듭?�다.
	 */
	private void setTabpageIndex() {
		for (int i = 0; i < TAB_BUTTON_COUNT; i++) {
			mTabButtons[i].setSelected(false);
		}
		
		if(mTabSelect==5)
			return;
		
		mTabButtons[mTabSelect].setSelected(true);
		switch (mTabSelect) {
		case 0:
			searchType = Util.BUSI_CD_ALL;
			break;
		case 1:
			searchType = Util.BUSI_CD_2;
			break;
		case 2:
			searchType = Util.BUSI_CD_1;
			break;
		case 3:
			searchType = Util.BUSI_CD_3;
			break;
		case 4:
			searchType = Util.BUSI_CD_4;
			break;
		}
	//	handler.post(getStoresRunnable);
		
	}

	/**
	 * Km 버튼???�택???�태�?만듭?�다.
	 */
	private void setKmTabpageIndex() {
		for (int i = 0; i < KM_BUTTON_COUNT; i++) {
			mKmButtons[i].setSelected(false);
		}
		
		if(mKmSelect==3)
			return;
		
		mKmButtons[mKmSelect].setSelected(true);
	}

	/**
	 * ?�벤??리스?��? ?�정?�니??
	 */
	private void setEventListener() {
		// ?�단??메뉴
		for (int i = 0; i < TAB_BUTTON_COUNT; i++) {
			String uri = "tab_store0";
			int imageResource = getResources().getIdentifier(uri+(i+1), "id", getPackageName());		
			mTabButtons[i] = (ImageButton)findViewById(imageResource);
			mTabButtons[i].setId(i);
			mTabButtons[i].setOnClickListener(mTabMenuClick);
		}
		setTabpageIndex();

		// Km 버튼
		for (int i = 0; i < KM_BUTTON_COUNT; i++) {
			String uri = "img_btn_km";
			int imageResource = getResources().getIdentifier(uri+(i+1), "id", getPackageName());
			mKmButtons[i] = (ImageButton)findViewById(imageResource);
			mKmButtons[i].setId(i);
			mKmButtons[i].setOnClickListener(mKmClick);
		}
		setKmTabpageIndex();

		// ?�단 ?�이 모양 ?��?지 - 검???�기 
		ImageButton imgBtnPiOpen = (ImageButton)findViewById(R.id.img_btn_searcher_open );
		imgBtnPiOpen.setOnClickListener(this);

		// ?�단 ?�이 모양 ?��?지 - 검???�기 
		ImageButton imgBtnPiClose = (ImageButton)findViewById(R.id.img_btn_searcher_close );
		imgBtnPiClose.setOnClickListener(this);

		// 좌측 ?�?��?맹점보기 ?��?지
		ImageButton imgBtnStore = (ImageButton)findViewById(R.id.img_btn_store );
		imgBtnStore.setOnClickListener(this);

		ViewGroup LnMapPreventer = (ViewGroup) findViewById(R.id.map_preventer); 		
		LnMapPreventer.setOnClickListener(this);
		//LnMapPreventer.setClickable(false);
	}
	
	public static void setLayoutAnim_slidedown(ViewGroup panel, Context ctx){
		AnimationSet set = new AnimationSet(true);
		Animation animation	= new AlphaAnimation(0.0f, 1.0f);
		animation.setDuration(1000);
		//set.addAnimation(animation);
		animation = new TranslateAnimation(
				Animation.RELATIVE_TO_SELF, 0.0f, Animation.RELATIVE_TO_SELF, 0.0f,
				Animation.RELATIVE_TO_SELF, -1.0f, Animation.RELATIVE_TO_SELF, 0.0f
				);
		animation.setDuration(500);
		set.addAnimation(animation);
		panel.startAnimation(set);
	}

	public static void setLayoutAnim_slideup(ViewGroup panel, Context ctx){
		AnimationSet set = new AnimationSet(true);
		Animation animation	= new AlphaAnimation(0.0f, 1.0f);
		animation.setDuration(1000);
		//set.addAnimation(animation);
		animation = new TranslateAnimation(
				Animation.RELATIVE_TO_SELF, 0.0f, Animation.RELATIVE_TO_SELF, 0.0f,
				Animation.RELATIVE_TO_SELF, 0.0f, Animation.RELATIVE_TO_SELF, -1.0f
				);

		animation.setDuration(500);
		set.addAnimation(animation);
		panel.startAnimation(set);
		//		  LayoutAnimationController controller =
		//	      new LayoutAnimationController(set, 0.0f);
		//		  panel.setLayoutAnimation(controller);    	
	}  
	
	private FranchisesOverlay.IFranchiseSelect mFranchiseSelectListener = new FranchisesOverlay.IFranchiseSelect() {
		
		public void onFranchiseSelect(FranchisesOverlay overlay,
				FranchiseOverlayItem item) {
			final FranchiseTooltipOverlay tooltip = getFranchiseTooltipOverlay();
			if( tooltip != null && item != null && tooltip.size() == 0 && !bGuide){
				tooltip.clearItems();
				final Projection proj = mapView.getProjection();
				Point pt = new Point();
				GeoPoint gp = item.getPoint();
				proj.toPixels(gp, pt);
				pt.offset(tooltip.getOffset().x, tooltip.getOffset().y);
				final GeoPoint tooltipGP = proj.fromPixels(pt.x, pt.y);
				tooltip.addItem(item.getModel().copy(), tooltipGP, true);
			}
		}
	};
	
	private FranchiseTooltipOverlay.IFranchiseTooltipSelect mFranchiseToolTipSelectListener = new FranchiseTooltipOverlay.IFranchiseTooltipSelect() {
		
		public void onFranchiseTooltipSelect(FranchiseTooltipOverlay overlay,
				FranchiseTooltipOverlayItem item) {
			final FranchiseTooltipOverlay tooltip = getFranchiseTooltipOverlay();
			if( tooltip != null ){
				if( item == null ){
					tooltip.clearItems();
					return;
				}else{
					goDetail(item.getModel().getFrch_cd(), item.getModel().getCco_cd());
				}
			}		
		}
	};
	
	private void goDetail(String frch_cd, String cco_cd) {
		Intent intent = new Intent(StoreMapView.this, StoreMapDetail.class);
		intent.putExtra("Frch_cd", frch_cd);
		intent.putExtra("Cco_cd", cco_cd);
		intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
		startActivity(intent);
	}
	
	private void showProgress( String title, String message){
		if( mProgressDialog == null ){
			mProgressDialog = ProgressDialog.show(StoreMapView.this,
					title, message, true, false);
		}else{
			mProgressDialog.setTitle(title);
			mProgressDialog.setMessage(message);
		}
	}
	
	private void hideProgress(){
		if( mProgressDialog != null ){
			mProgressDialog.dismiss();
			mProgressDialog = null;
		}
	}
	
	private void AlertDialogMsg(int msg){
		AlertDialog.Builder alt_bld = new AlertDialog.Builder(this);  
		alt_bld.setMessage(msg)  
		.setCancelable(false)  
		.setPositiveButton("확인", new DialogInterface.OnClickListener() {
			
			public void onClick(DialogInterface dialog, int which) {
				prcessingInit(PRC_REFRESH_DISPLAY, null);
			}
		});  

		AlertDialog alert = alt_bld.create();  
		alert.setTitle(R.string.alert_str);
		alert.show(); 
	}

	@Override
	public void onAccuracyChanged(Sensor arg0, int arg1) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onSensorChanged(SensorEvent event) {
		// TODO Auto-generated method stub
		
		if(event.sensor.getType() == Sensor.TYPE_ACCELEROMETER){
			long currentTime = System.currentTimeMillis();
			long gabOfTime = (currentTime - lastTime);
			
			if(gabOfTime >100) {
				lastTime = currentTime;
				
				x = event.values[SensorManager.DATA_X];
				y = event.values[SensorManager.DATA_Y];
				z = event.values[SensorManager.DATA_Z];
				
				speed = Math.abs(x+y+z-lastX-lastY-lastZ)/
						gabOfTime * 10000;
				
				if(speed > SHAKE_THRESHOLD){
					//?�벤??발생!!
					
					bGuide=false;
					initLocationManager();	
					
				//sbhong@truemobile.com		
					initSpinnerValue();
					handler.post(getStoresRunnable);
				}
				
				lastX = event.values[DATA_X];
				lastY = event.values[DATA_Y];
				lastZ = event.values[DATA_Z];
			}
		}
	}

	@Override
	public void onLocationChanged(Location location) {
		// TODO Auto-generated method stub
	}

	@Override
	public void onProviderDisabled(String provider) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onProviderEnabled(String provider) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onStatusChanged(String provider, int status, Bundle extras) {
		// TODO Auto-generated method stub
		
	}
}

