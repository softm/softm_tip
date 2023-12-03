package kr.go.citis.main.activity;

import java.io.File;
import java.io.IOException;
import java.util.ArrayList;

import kr.go.citis.lib.Constant;
import kr.go.citis.lib.PicCamera;
import kr.go.citis.lib.SpinnerCd;
import kr.go.citis.lib.TitleView.OnTopClickListner;
import kr.go.citis.lib.Util;
import kr.go.citis.lib.common.AsyncHttp;
import kr.go.citis.lib.common.AsyncHttpParam;
import kr.go.citis.lib.common.CallBack;
import kr.go.citis.main.BasicActivity;
import kr.go.citis.main.R;
import kr.go.citis.main.common.WConstant;
import kr.go.citis.main.common.WUtil;
import kr.go.citis.main.dto.PicMngDtlDTO;
import kr.go.citis.main.dto.PicMngItemDeleteDTO;
import kr.go.citis.main.dto.PicMngItemListDTO;
import kr.go.citis.main.dto.PicMngSaveDTO;
import kr.go.citis.main.dto.in.PicMngDtlDTOIn;
import kr.go.citis.main.dto.in.PicMngItemDeleteDTOIn;
import kr.go.citis.main.dto.in.PicMngItemListDTOIn;
import kr.go.citis.main.dto.in.PicMngSaveDTOIn;
import kr.go.citis.main.dto.out.PicMngDtlDTOOut;
import kr.go.citis.main.dto.out.PicMngItemDeleteDTOOut;
import kr.go.citis.main.dto.out.PicMngItemListDTOOut;
import kr.go.citis.main.dto.out.PicMngSaveDTOOut;

import org.apache.commons.lang3.StringUtils;

import android.annotation.SuppressLint;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.media.ExifInterface;
import android.os.Bundle;
import android.view.GestureDetector;
import android.view.GestureDetector.SimpleOnGestureListener;
import android.view.MotionEvent;
import android.view.View;
import android.view.View.OnTouchListener;
import android.view.animation.AnimationUtils;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ViewFlipper;
import butterknife.Bind;
import butterknife.OnClick;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.resource.drawable.GlideDrawable;
import com.bumptech.glide.request.RequestListener;
import com.bumptech.glide.request.target.Target;
import com.google.gson.Gson;
import com.squareup.okhttp.Callback;
import com.squareup.okhttp.FormEncodingBuilder;
import com.squareup.okhttp.Request;
import com.squareup.okhttp.Response;

/**
 * @author softm
 * PhotoMngDtlActivity
 * 사진관리상세
 */
@SuppressLint({ "HandlerLeak", "ClickableViewAccessibility" })
public class PhotoMngDtlActivity extends BasicActivity implements OnTopClickListner {
    public static final String TAG = Constant.LOG_TAG;

    @Bind(R.id.spn_cnsttypecd   ) SpinnerCd spnCnsttypecd   ; // 공종
    @Bind(R.id.spn_dtlcnsttypecd) SpinnerCd spnDtlcnsttypecd; // 세부공종
    @Bind(R.id.et_prt           ) EditText  etPrt           ; // 위치
    @Bind(R.id.et_cnts          ) EditText  etCnts          ; // 내용
    
    @Bind(R.id.btn_save         ) Button btnSave;
    @Bind(R.id.btn_del          ) Button btnDel;
    @Bind(R.id.btn_camera       ) ImageButton btnCamera;

	@Bind(R.id.viewFlipper      ) ViewFlipper mViewFlipper;
	private GestureDetector mGestureDetector;
	
	public String pSiteNo        ; // 담당현장
	public String pCnstrphtSeq   ; // 공사사진일련번호
	public String cnstrphtSeq    ; // 공사사진일련번호 기본정보 저장되면 키값이 생성된후 사진 촬영이 가능함.
	public String wMode          ; // 작성/수정 [W/U]
	
    PicCamera pc;
    
	@Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        init(new CallBack() {
			@Override
			public void complete(Object object) {
				detail();
		        retrieve();				
			}
		});
    }
	private void init(final CallBack cb) {
		Intent i = this.getIntent();
		wMode           = StringUtils.defaultString(i.getStringExtra("w_mode"           )); // W/RW 작성/재작성
		pSiteNo         = StringUtils.defaultString(i.getStringExtra("site_no"          )); // 담당현장
		pCnstrphtSeq    = StringUtils.defaultString(i.getStringExtra("cnstrpht_seq"     )); // 공사사진일련번호
		cnstrphtSeq     = StringUtils.defaultString(i.getStringExtra("cnstrpht_seq"     )); // 공사사진일련번호
		
		wMode = StringUtils.isEmpty(wMode)?WConstant.WRITE_MODE_FISRT:wMode;
		
//		wMode           = "W";
//		pSiteNo         = "1";
//		pCnstrphtSeq    = "" ;
//		cnstrphtSeq     = "1";

	    if ( 
	    		( wMode.equals(WConstant.WRITE_MODE_FISRT ) && StringUtils.isNotEmpty(pCnstrphtSeq) ) // 작성이면서 parameter있음
	    	||  ( ( wMode.equals(WConstant.WRITE_MODE_UPDATE) ) && StringUtils.isEmpty(pCnstrphtSeq) ) // 수정이면서  parameter 없음
	    ) {
	        alert(R.string.msg_not_exec_alert
	                , new DialogInterface.OnClickListener() {
	                    public void onClick(DialogInterface dialog, int whichButton) {
	                        finish();
	                    }
	                }
	        );
	    }
	    loast("wMode / pCnstrphtSeq : " + wMode + " / " + pSiteNo +  " / " + pCnstrphtSeq);
	    Util.d("wMode / pCnstrphtSeq : " + wMode + " / " + pSiteNo +  " / " + pCnstrphtSeq);
	    setLayout(R.layout.activity_photo_mng_dtl);
	    setTopTitle(R.string.title_photo_mng_dtl);	    
	    if ( wMode.equals(WConstant.WRITE_MODE_FISRT ) ) {
	    	btnSave.setText("촬영시작");
	    	setInVisibility(btnDel,View.GONE);
	    	setInVisibility(btnCamera);
	    }
        try {
            // 공종
            spnCnsttypecd.setPrompt("공종");
            spnCnsttypecd.getSysCode("codeCnsttypecd",var.USER_ID, "",new CallBack() {
                @Override
                public void complete(Object object) {
//                    spnCnsttypecd.setSelection(0, false);
                    spnCnsttypecd.setOnItemSelectedListener(new OnItemSelectedListener() {
                        public void onItemSelected(AdapterView<?> parent, View view,    int position, long id) {
                        	Util.d("spnCnsttypecd onItemSelected position / id : " + position + " / " + id);
                            // 세부공정 code_dtlcnsttypecd
                            spnDtlcnsttypecd.setPrompt("세부공종");
                            spnDtlcnsttypecd.getSysCode("codeDtlcnsttypecd",spnCnsttypecd.getValue(), "",new CallBack() {
                                @Override
                                public void complete(Object object) {
                                	spnDtlcnsttypecd.setSelection(0, false);
                                	spnDtlcnsttypecd.setOnItemSelectedListener(new OnItemSelectedListener() {
                                        public void onItemSelected(AdapterView<?> parent, View view,    int position, long id) {
                                            Util.d("spnDtlcnsttypecd onItemSelected position / id : " + position + " / " + id);
                                            if (spnDtlcnsttypecd.loaded ) {                                    
                                                Util.i("spnChargeSiteNo list execute!");
                                            	loast("spnCnsttypecd.getValue() : " + spnCnsttypecd.getValue() + " / " + spnDtlcnsttypecd.getValue() + "[" + spnDtlcnsttypecd.getText() + "]");
                                            	cb.complete(null); // retrieve, detail
                                            }
                                        }
                                        @Override
                                        public void onNothingSelected(AdapterView<?> arg0) {
                                        }
                                    });
                                	spnDtlcnsttypecd.loaded = true;
                                	loast("spnCnsttypecd.getValue() : " + spnCnsttypecd.getValue() + " / " + spnDtlcnsttypecd.getValue() + "[" + spnDtlcnsttypecd.getText() + "]");
                            	    if ( wMode.equals(WConstant.WRITE_MODE_UPDATE ) ) {                                	
                            	    	cb.complete(null); // retrieve, detail
                            	    }
                                }
                            });
                        }
                        @Override
                        public void onNothingSelected(AdapterView<?> arg0) {
                        }
                    });
                    spnCnsttypecd.loaded = true;
                    loast("spnCnsttypecd.getValue() : " + spnCnsttypecd.getValue());
                    Util.d("spnCnsttypecd.getValue() : " + spnCnsttypecd.getValue());
                }
            });
        } catch (Exception e) {
            e.printStackTrace();
        } finally {
        	if ( wMode.equals(WConstant.WRITE_MODE_UPDATE) ) {
            	setDisabled(spnCnsttypecd);                        	
            	setDisabled(spnDtlcnsttypecd);                        	
        	}
        }
    }
	
	private void retrieve() {
        runOnUiThread(new Runnable() {
            public void run() {
              startProgressBar();
          	  list();
            }
        });
    }
	
    @SuppressLint("NewApi")
    private void list() {
        String inParams = "";
        PicMngItemListDTOIn in = new PicMngItemListDTOIn();
            PicMngItemListDTO data = new PicMngItemListDTO();
            data.setpCnstrphtSeq(pCnstrphtSeq);            
        in.setData(data);
        Gson gson = new Gson();
        inParams = gson.toJson(in);
        String servcie = "picMngItemList"; // pic_mng_item_list	picMngItemList

        Util.i(" list[" +servcie+"] in param json : " + inParams);
        new AsyncHttp<PicMngItemListDTOOut,PicMngItemListDTOOut>(this) {
//            private PicMngItemListDTOOut result;
            @Override
            public void complete(PicMngItemListDTOOut result) {
                Util.i(result.getClass().getName() +" result : " + result);
                try {
                	ArrayList<PicMngItemListDTO> data = result.getData();
                	loadImage(data);                	
                } catch (Exception e) {
                    e.printStackTrace();
                }
            }
            @Override
            public void callback(PicMngItemListDTOOut result) {
//                this.result = result;
//              TestChkMainActivity.this.alert("끝나면 실행한다.");
            }
        }.execute(new AsyncHttpParam(Constant.SERVER_DATA_URL,
        							 new FormEncodingBuilder().add("p", inParams),servcie));
    }
    class ImageFileInfo {
    	String fileName;
    	String fileUrl;
    	File resource;
		public ImageFileInfo(String file, File resource) {
			this.fileName = file;
			this.resource = resource;
		}
		public ImageFileInfo(String file, String fileUrl) {
			this.fileName = file;
			this.fileUrl = fileUrl;
		}
		public String getFileName() {
			return fileName;
		}
		public File getResource() {
			return resource;
		}
		public void setFileName(String fileName) {
			this.fileName = fileName;
		}
		public void setResource(File resource) {
			this.resource = resource;
		}
		public String getFileUrl() {
			return fileUrl;
		}
		public void setFileUrl(String fileUrl) {
			this.fileUrl = fileUrl;
		}
		
    	
    }
    ArrayList<ImageFileInfo> finfo = new ArrayList<ImageFileInfo>();
    
    private void loadImage(ArrayList<PicMngItemListDTO> data) {
    	finfo.clear();
		mViewFlipper.removeAllViews();		
		if ( StringUtils.isNotEmpty(cnstrphtSeq)) {
			int seq = 0;			
			for (final PicMngItemListDTO file : data) {
				file.getFileUrl();
				Util.i("test",Constant.PIC_DIR + File.separator + file);
//				ImageView iv = setPic(Constant.PIC_DIR + File.separator + file);
				ImageView iv = new ImageView(PhotoMngDtlActivity.this);
				if ( seq == 0) {
//					Glide.with(PhotoMngDtlActivity.this).load("http://118.220.189.69:8011/citis/citis.inspection.MobileCheckCMD.cals?service=ncrRprtFileDownload&pRprtSeq=1&pFileAsr=RQSTS").into(iv);
//					Glide.with(PhotoMngDtlActivity.this).load("http://www.selphone.co.kr/homepage/img/team/" + (seq+1) + ".jpg").into(iv);
				}
				finfo.add(new ImageFileInfo(file.getFileName(),file.getFileUrl()));				
				mViewFlipper.addView(iv);
				seq++;
			}
			if ( mViewFlipper.getChildCount() > 0 ) {
				ImageView iv = (ImageView) mViewFlipper.getCurrentView();
				ImageFileInfo imgInfo = finfo.get(mViewFlipper.getDisplayedChild());
				seq = mViewFlipper.getDisplayedChild() + 1;
				loast(seq + " / " + imgInfo.getFileName());
				Glide.with(PhotoMngDtlActivity.this).load(imgInfo.getFileUrl()).into(iv);
			}	
	        mGestureDetector = new GestureDetector(this, customGestureDetector);
	        mViewFlipper.setOnTouchListener(new OnTouchListener() {
				@Override
				public boolean onTouch(View paramView, MotionEvent paramMotionEvent) {
					mGestureDetector.onTouchEvent(paramMotionEvent);
					return true;
				}
			});			
		}
    }
   	@SuppressWarnings("unused")
	private void loadImage() {
	  		File dir = new File(Constant.PIC_DIR);
			String prefix = cnstrphtSeq;
			if ( StringUtils.isNotEmpty(cnstrphtSeq)) {
				final String[] allFiles = dir.list();
				mViewFlipper.removeAllViews();
				int seq = 0;
				for (final String file : allFiles) {
					Util.i("test",PicCamera.MODE_PICTURE + "_" + prefix);
					if (file.startsWith(PicCamera.MODE_PICTURE + "_" + prefix ) ) {
//					if (file.startsWith(PicCamera.MODE_PICTURE + "_" + prefix ) && file.length() == 11) {
						finfo.add(new ImageFileInfo(file,new File("")));
						Util.i("test",Constant.PIC_DIR + File.separator + file);
//						ImageView iv = setPic(Constant.PIC_DIR + File.separator + file);
						ImageView iv = new ImageView(PhotoMngDtlActivity.this);
						if ( seq == 0) {
//							Glide.with(PhotoMngDtlActivity.this).load("http://118.220.189.69:8011/citis/citis.inspection.MobileCheckCMD.cals?service=ncrRprtFileDownload&pRprtSeq=1&pFileAsr=RQSTS").into(iv);
//							Glide.with(PhotoMngDtlActivity.this).load("http://www.selphone.co.kr/homepage/img/team/" + (seq+1) + ".jpg").into(iv);
						}
						mViewFlipper.addView(iv);
//						final int tmpSeq = new Integer(seq);
//						seq++;
//						Glide.with(PhotoMngDtlActivity.this).load("http://192.168.0.71/" + seq + ".jpg").into(iv);						
//						Glide.with(PhotoMngDtlActivity.this).load("http://192.168.0.71/" + seq + ".jpg").downloadOnly(new SimpleTarget<File>() {
//							@Override
//							public void onResourceReady(File resource,
//									GlideAnimation<? super File> glideAnimation) {
//								// file url 저장
//								URI uri = resource.toURI();
//								finfo.set(tmpSeq,new ImageFileInfo(file,resource));
////				              	urlToDownload = Uri.parse(fileUrl);
////				            	request = new DownloadManager.Request(urlToDownload);
////				            	request.setVisibleInDownloadsUi(false);
////				            	request.setTitle(StringUtils.isNotEmpty(title)?title:"Download");
////				            	request.setDescription(StringUtils.isNotEmpty(description)?description:"Download");
////				            	 File file = new File(Constant.TMP_DIR+File.separator+mFileName);
////				            	 Uri destinationUri = Uri.fromFile(file);
//// 				            	 if ( tmpSeq == 1 ) {
//// 				    				ImageView iv = (ImageView) mViewFlipper.getCurrentView(); 				            		 
//// 				    				iv.setImageURI(Uri.fromFile(resource));
////				            	 }
//// 				            	 toast(tmpSeq + " downloaded! : " + resource.getAbsolutePath());
// 				            	 Util.i((tmpSeq) + " downloaded! : " + resource.getAbsolutePath());
//							}
//						});			
//						iv.setTag(file);
					}
				}
// 파일 다운로드시 참고.
//				Glide.with(PhotoMngDtlActivity.this)
//				.load("http://192.168.0.71/" + seq + ".jpg")
//				.downloadOnly(new SimpleTarget<File>() {
//					@Override
//					public void onResourceReady(File resource,
//							GlideAnimation<? super File> glideAnimation) {
//						// file url 저장
//					}
//				});
				if ( mViewFlipper.getChildCount() > 0 ) {
					ImageView iv = (ImageView) mViewFlipper.getCurrentView();
					ImageFileInfo imgInfo = finfo.get(mViewFlipper.getDisplayedChild());
					seq = mViewFlipper.getDisplayedChild() + 1;
					loast(seq + " / " + imgInfo.getFileName() + " / " + imgInfo.getFileUrl() );
	//				Glide.with(PhotoMngDtlActivity.this).load("http://118.220.189.69:8011/citis/citis.inspection.MobileCheckCMD.cals?service=ncrRprtFileDownload&pRprtSeq=1&pFileAsr=RQSTS").into(iv);
	//				Glide.with(PhotoMngDtlActivity.this).load("http://www.selphone.co.kr/homepage/img/team/" + seq + ".jpg").into(iv);
//					Glide.with(PhotoMngDtlActivity.this).load("http://192.168.0.71/" + seq + ".jpg").into(iv);
					Glide.with(PhotoMngDtlActivity.this).load(imgInfo.getFileUrl()).into(iv);
				}
			}
	
	        mGestureDetector = new GestureDetector(this, customGestureDetector);
	        mViewFlipper.setOnTouchListener(new OnTouchListener() {
				@Override
				public boolean onTouch(View paramView, MotionEvent paramMotionEvent) {
					mGestureDetector.onTouchEvent(paramMotionEvent);
					return true;
				}
			});
		}

	private void detail() {
    	String inParams = "";
    	PicMngDtlDTOIn in = new PicMngDtlDTOIn();
    	PicMngDtlDTO data = new PicMngDtlDTO();
    	data.setwMode(wMode);            
    	data.setpCnstrphtSeq(pCnstrphtSeq);
    	
    	in.setData(data);
    	Gson gson = new Gson();
    	inParams = gson.toJson(in);
    	String servcie = "picMngDtl"; // pic_mng_dtl	picMngDtl

    	loast(" detail[" +servcie+"] in param json : " + inParams);
    	Util.i(" detail[" +servcie+"] in param json : " + inParams);
    	new AsyncHttp<PicMngDtlDTOOut,PicMngItemListDTOOut>(this) {
//    		private PicMngDtlDTOOut result;
    		@Override
    		public void complete(PicMngDtlDTOOut result) {
    			Util.i(result.getClass().getName() +" result : " + result);
    			try {
    				PhotoMngDtlActivity.this.stopProgressBar();
    				PicMngDtlDTO data = result.getData();
    				if ( data != null ) {
	    				spnCnsttypecd.setValue(data.getCnsttypecd());
	    				spnDtlcnsttypecd.setValue(data.getDtlcnsttypecd());
	    			    etPrt.setText(data.getPrt()); // 위치
	    			    etCnts.setText(data.getCnts()); // 내용
	    			    if ( WConstant.WRITE_MODE_UPDATE.equals(wMode) ) { // 수정
	    			    	setDisabled(spnCnsttypecd);
	    			    	setDisabled(spnDtlcnsttypecd);
	    			    }
    				}
    			} catch (Exception e) {
    				e.printStackTrace();
    			}
    		}
    		@Override
    		public void callback(PicMngDtlDTOOut result) {
//    			this.result = result;
//              TestChkMainActivity.this.alert("끝나면 실행한다.");
    		}
    	}.sync(new AsyncHttpParam(Constant.SERVER_DATA_URL,inParams,servcie));
    }
    
	private void nextImage()
	    {
	    	if( mViewFlipper.getChildCount() > 1 ) { 
		    	mViewFlipper.setInAnimation(AnimationUtils.loadAnimation(this,	R.anim.appear_from_right));
				mViewFlipper.setOutAnimation(AnimationUtils.loadAnimation(this, R.anim.disappear_to_left));
				mViewFlipper.showNext();
				ImageView iv = (ImageView) mViewFlipper.getCurrentView();
				ImageFileInfo imgInfo = finfo.get(mViewFlipper.getDisplayedChild());
				
				int seq = mViewFlipper.getDisplayedChild() + 1;
//				Glide.with(PhotoMngDtlActivity.this).load("http://118.220.189.69:8011/citis/citis.inspection.MobileCheckCMD.cals?service=ncrRprtFileDownload&pRprtSeq=1&pFileAsr=RQSTS").into(iv);
//				Glide.with(PhotoMngDtlActivity.this).load("http://www.selphone.co.kr/homepage/img/team/" + seq + ".jpg").into(iv);
				startProgressBar();
//				Glide.with(PhotoMngDtlActivity.this).load("http://192.168.0.71/" + seq + ".jpg").placeholder(android.R.drawable.ic_menu_gallery)
				Glide.with(PhotoMngDtlActivity.this).load(imgInfo.getFileUrl()).placeholder(android.R.drawable.ic_menu_gallery)
				.error(android.R.drawable.ic_menu_gallery)
				.crossFade().listener(new RequestListener<String, GlideDrawable>() {
			         @Override
			         public boolean onException(Exception e, String model, Target<GlideDrawable> target, boolean isFirstResource) {
			        	 stopProgressBar();
			             return false;
			         }

			         @Override
			         public boolean onResourceReady(GlideDrawable resource, String model, Target<GlideDrawable> target, boolean isFromMemoryCache, boolean isFirstResource) {
			             stopProgressBar();
			             return false;
			         }
			     }).into(iv);
//				 iv.setImageURI(Uri.fromFile(imgInfo.getResource()));
//				 toast(seq + " / " + imgInfo.getFileName() + "/" + (imgInfo.getResource().getAbsolutePath()));
				loast(seq + " / " + imgInfo.getFileName() + " / " + imgInfo.getFileUrl() );				

	//		setText(R.id.tv_infor, ""+mViewFlipper.getCurrentView().getTag().toString());
	    	}
	    }

	private void previousImage()
	{
		if( mViewFlipper.getChildCount() > 1 ) {    	
	    	mViewFlipper.setInAnimation(AnimationUtils.loadAnimation(this,	R.anim.appear_from_left));
			mViewFlipper.setOutAnimation(AnimationUtils.loadAnimation(this, R.anim.disappear_to_right));
	    	mViewFlipper.showPrevious();
			ImageView iv = (ImageView) mViewFlipper.getCurrentView();
			ImageFileInfo imgInfo = finfo.get(mViewFlipper.getDisplayedChild());
			
			int seq = mViewFlipper.getDisplayedChild() + 1;
//			Glide.with(PhotoMngDtlActivity.this).load("http://118.220.189.69:8011/citis/citis.inspection.MobileCheckCMD.cals?service=ncrRprtFileDownload&pRprtSeq=1&pFileAsr=RQSTS").into(iv);
//			Glide.with(PhotoMngDtlActivity.this).load("http://www.selphone.co.kr/homepage/img/team/" + seq + ".jpg").into(iv);
			startProgressBar();			
//			Glide.with(PhotoMngDtlActivity.this).load("http://192.168.0.71/" + seq + ".jpg")
			Glide.with(PhotoMngDtlActivity.this).load(imgInfo.getFileUrl())
			.placeholder(android.R.drawable.ic_menu_gallery)
			.error(android.R.drawable.ic_menu_gallery)			
			.crossFade().listener(new RequestListener<String, GlideDrawable>() {				
		         @Override
		         public boolean onException(Exception e, String model, Target<GlideDrawable> target, boolean isFirstResource) {
		        	 stopProgressBar();
		             return false;
		         }

		         @Override
		         public boolean onResourceReady(GlideDrawable resource, String model, Target<GlideDrawable> target, boolean isFromMemoryCache, boolean isFirstResource) {
		             stopProgressBar();
		             return false;
		         }
		     }).into(iv);
			
//			 iv.setImageURI(Uri.fromFile(imgInfo.getResource()));
//			 toast(seq + " / " + imgInfo.getFileName() + "/" + (imgInfo.getResource().getAbsolutePath()));
			loast(seq + " / " + imgInfo.getFileName() + " / " + imgInfo.getFileUrl() );			
	//		setText(R.id.tv_infor, ""+mViewFlipper.getCurrentView().getTag().toString());
		}
	}

	@SuppressWarnings("unused")
	private ImageView setPic(String fileName){
	        ImageView iv = new ImageView(this);
	//		int targetW = mImagePicViewer.getWidth(); // ImageView 의 가로 사이즈 구하기
	//		int targetH = mImagePicViewer.getHeight(); // ImageView 의 세로 사이즈 구하기
	//		if ( targetW == 0 ) targetW = 70;
	//		if ( targetH == 0 ) targetH = 70;
	        // ImageView 객체 생성
	        iv.setAdjustViewBounds(true);
	        iv.setLayoutParams(new LinearLayout.LayoutParams(LinearLayout.LayoutParams.MATCH_PARENT, LinearLayout.LayoutParams.MATCH_PARENT));
	        iv.setScaleType(ImageView.ScaleType.FIT_XY); // 레이아웃 크기에 이미지를 맞춘다
	//        
	//		RelativeLayout.LayoutParams params = (RelativeLayout.LayoutParams)imgBtnTop1.getLayoutParams();
	//		params.addRule(RelativeLayout.CENTER_IN_PARENT);
	//		params.addRule(RelativeLayout.ALIGN_PARENT_RIGHT);
	//		params.addRule(RelativeLayout.LEFT_OF, R.id.btn_top2);
	
			
			// Bitmap 정보를 가져온다.
			BitmapFactory.Options bmOptions = new BitmapFactory.Options(); 
	//		bmOptions.inJustDecodeBounds = true;
	//		BitmapFactory.decodeFile( Constant.PIC_DIR + File.separator + mFileName, bmOptions);
	//		int photoW = bmOptions.outWidth; // 사진의 가로 사이즈 구하기
	//		int photoH = bmOptions.outHeight; // 사진의 세로 사이즈 구하기
	//
	//		// 사진을 줄이기 위한 비율 구하기
	//		int scaleFactor = Math.min( photoW/targetW, photoH/targetH);
	//		bmOptions.inJustDecodeBounds = false;
	//		bmOptions.inSampleSize = scaleFactor;
	//		bmOptions.inPurgeable = true;
	//		
			ExifInterface exif = null;
			try {
				exif = new ExifInterface(fileName);
			} catch (IOException e) {
				e.printStackTrace();
			}
			Util.i("test","fileName : " + fileName);
			
			int exifOrientation = exif.getAttributeInt(ExifInterface.TAG_ORIENTATION, ExifInterface.ORIENTATION_NORMAL);
			int exofDegree = Util.exifOrientationToDegrees(exifOrientation);
			Bitmap bitmap = BitmapFactory.decodeFile(fileName, bmOptions);
			bitmap = Util.rotate(bitmap, exofDegree);
			iv.setImageBitmap( bitmap);
			return iv;
		}

	@OnClick({R.id.btn_save, R.id.btn_del, R.id.btn_camera})
    protected void onClick(View v) {
        final int viewID = v.getId();
        if ( viewID == R.id.btn_save  ) {
			execSave(viewID);
		} else if ( viewID == R.id.btn_del ) {
    		confirm(R.string.msg_del_confirm, new DialogInterface.OnClickListener() {
				@Override
				public void onClick(DialogInterface dialog, int which) {
					execDel(viewID);
				}
			});
        } else if (viewID == R.id.btn_camera ) {
        	pc = new PicCamera(this, Constant.PIC_DIR,PicCamera.MODE_PICTURE,cnstrphtSeq,".jpg");
        	pc.setSingleMode(false);         	
        	pc.start();
        }
    }
	
	@Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
    	if ( requestCode == Constant.PROC_ID_TAKE_CAMERA ) {
			if ( resultCode != 0 ) {
				pc.save();
				if ( pc.fileCount() > 0 ) {
					String[] files = pc.getFiles();
					if ( files.length > 0 ) {
						loast(pc.getFileName());
						startProgressBar();						
						new android.os.Handler().postDelayed(
							    new Runnable() {
							        public void run() {
										WUtil.HttpFileUpload(Constant.SERVER_DATA_URL,"service=picMngItemSave&cnstrphtSeq="+cnstrphtSeq+"&siteNo="+pSiteNo,pc.getFileName(), new Callback() {
											@Override
											public void onResponse(Response paramResponse) throws IOException {
									            retrieve();		
											}
											
											@Override
											public void onFailure(Request paramRequest, IOException paramIOException) {
												alert("업로드중 오류가 발생하였습니다.");
											}
											
										});

							        }
							    }, 
					    1000);
					}
				}
			}
    	}
    }

	private void execSave(int viewID) {
        String inParams = "";
        PicMngSaveDTOIn in = new PicMngSaveDTOIn();
            in.setSysRegId(var.USER_ID);
            PicMngSaveDTO data = new PicMngSaveDTO();
        	data.setwMode(wMode);            
        	data.setCnstrphtSeq(pCnstrphtSeq);            
        	data.setSiteNo(pSiteNo); // 현장번호[담당,관할]
//        	data.setCnsttypecd(getValue(spnCnsttypecd)); // 공종코드        	
        	data.setDtlcnsttypecd(getValue(spnDtlcnsttypecd)); // 세부공종코드        	
        	data.setPrt (getString(etPrt)); // 위치
        	data.setCnts(getString(etCnts)); // 내용
        in.setData(data);
        Gson gson = new Gson();
        inParams = gson.toJson(in);
        String servcie = "picMngSave"; // picMngSave	pic_mng_save

        Util.i(" save[" +servcie+"] in param json : " + inParams);
        new AsyncHttp<PicMngSaveDTOOut,PicMngSaveDTOOut>(this) {
//            private PicMngSaveDTOOut result;
            @Override
            public void complete(PicMngSaveDTOOut result) {
                Util.i(result.getClass().getName() +" result : " + result);
                try {
                	PhotoMngDtlActivity.this.stopProgressBar();
                    PicMngSaveDTO data = result.getData();
                    if ( Constant.ERR_CODE_SUCCESS.equals(result.getMsgCode())) {
            	    	cnstrphtSeq = data.getCnstrphtSeq();
            	    	if ( wMode.equals(WConstant.WRITE_MODE_FISRT) ) {
            	    		setVisibility(btnDel);
            	    		setVisibility(btnCamera);
	            			Intent i = PhotoMngDtlActivity.this.getIntent();
	            			i.putExtra("w_mode", WConstant.WRITE_MODE_UPDATE);
	            			i.putExtra("cnstrpht_seq", cnstrphtSeq);
            	    	}
            	    	
            	    	String msgSaved = null;
            	    	if ( wMode.equals(WConstant.WRITE_MODE_FISRT) ) {
            	    		msgSaved = getString(R.string.msg_saved_and_take_picture_camera); // 카메라촬영버튼을 눌러 사진을 촬영하세요.       	    		
            	    	} else {
            	    		msgSaved = getString(R.string.msg_saved); // 저장되었습니다.            	    		
            	    	}
            	    	
            	        init(new CallBack() {
            				@Override
            				public void complete(Object object) {
            					detail();
            			        retrieve();				
            				}
            			});
            	        throw new Exception(msgSaved); // 저장메시지
                    } else {
                        throw new Exception(result.getMsg());
                    }
                } catch (Exception e) {
//                  e.printStackTrace();
                    alert(e.getMessage(),new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface arg0, int arg1) {
                        }
                    });
                }
            }
            @Override
            public void callback(PicMngSaveDTOOut result) {
//                this.result = result;
//              TestChkMainActivity.this.alert("끝나면 실행한다.");
            }
        }.execute(new AsyncHttpParam(Constant.SERVER_DATA_URL,inParams,servcie));
	}
	
	private void execDel(int viewID) {
		String inParams = "";
		PicMngItemDeleteDTOIn in = new PicMngItemDeleteDTOIn();
		in.setSysRegId(var.USER_ID);
		PicMngItemDeleteDTO data = new PicMngItemDeleteDTO();
		data.setpCnstrphtSeq(cnstrphtSeq);
		in.setData(data);
		Gson gson = new Gson();
		inParams = gson.toJson(in);
		String servcie = "picMngItemDelete"; // picMngItemDelete	pic_mng_item_delete
		
		Util.i(" save[" +servcie+"] in param json : " + inParams);
		new AsyncHttp<PicMngItemDeleteDTOOut,PicMngItemDeleteDTOOut>(this) {
//			private PicMngItemDeleteDTOOut result;
			@Override
			public void complete(PicMngItemDeleteDTOOut result) {
				Util.i(result.getClass().getName() +" result : " + result);
				try {
					PhotoMngDtlActivity.this.stopProgressBar();
//					PicMngItemDeleteDTO data = result.getData();
					if ( Constant.ERR_CODE_SUCCESS.equals(result.getMsgCode())) {
						Util.deleteFilesWithPrefix(Constant.PIC_DIR, PicCamera.MODE_PICTURE + "_" + cnstrphtSeq);
						alert(getString(R.string.msg_deleted),new DialogInterface.OnClickListener() {
							@Override
							public void onClick(DialogInterface arg0, int arg1) {
								Intent i = new Intent(PhotoMngDtlActivity.this,PhotoMngActivity.class); // 사진관리		
							    i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP|Intent.FLAG_ACTIVITY_SINGLE_TOP);		
								setResult(WConstant.PROC_ID_PHOTO_MNG_DTL_DELETE, i);
								finish();								
							}
						});
					} else {
						throw new Exception(result.getMsg());
					}
				} catch (Exception e) {
//                  e.printStackTrace();
					alert(e.getMessage(),new DialogInterface.OnClickListener() {
						@Override
						public void onClick(DialogInterface arg0, int arg1) {
						}
					});
				}
			}
			@Override
			public void callback(PicMngItemDeleteDTOOut result) {
//				this.result = result;
//              TestChkMainActivity.this.alert("끝나면 실행한다.");
			}
		}.execute(new AsyncHttpParam(Constant.SERVER_DATA_URL,inParams,servcie));
	}
	
    @Override
    public void onBackPressed() {
        finish();
    }

    /**
     * Top상단 메인 버튼 클릭
     * @param v
     */
    @Override
    public void onClickMainButton(View v) {
        WUtil.goMain(this);
    }

    /**
     * Top상단 첫번째 버튼 클릭
     */
    @Override
    public void onClickOneButton(View v) {
        onBackPressed();
    }

    /**
     * Top상단 두번째 버튼 클릭
     */
    @Override
    public void onClickTwoButton(View v) {
        View anchor = (View) findViewById( R.id.et_search );
        showMenu(anchor, R.menu.main);
//          showMenu(v, R.menu.main);
    }

    @Override
    protected void onPause() {
        super.onPause();
//      AppContext.putValue("et_search", getValue(R.id.et_search));
    }

    @Override
    protected void onResume() {
        super.onResume();
//      setText(R.id.et_search,AppContext.getValue("et_search").toString());
    }
    
	
    SimpleOnGestureListener customGestureDetector = new SimpleOnGestureListener()  {
        @Override
        public boolean onFling(MotionEvent e1, MotionEvent e2, float velocityX, float velocityY) {
 
            // Swipe left (next)
            if (e1.getX() > e2.getX()) {
            	nextImage();
            }
 
            // Swipe right (previous)
            if (e1.getX() < e2.getX()) {
            	previousImage();
            }
 
//            return super.onFling(e1, e2, velocityX, velocityY);
            return true;
        }
    };    
}
