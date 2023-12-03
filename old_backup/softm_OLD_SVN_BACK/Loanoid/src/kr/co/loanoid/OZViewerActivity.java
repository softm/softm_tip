package kr.co.loanoid;

import java.io.File;
import java.io.IOException;

import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.ActivityNotFoundException;
import android.content.DialogInterface;
import android.content.Intent;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Environment;
import android.util.Log;
import android.view.KeyEvent;
import android.view.View;
import android.view.Window;
import android.widget.FrameLayout;
import android.widget.Toast;
import oz.toto.framework.IAsyncReturn;
import oz.toto.framework.OZTotoEvent;
import oz.toto.framework.OZTotoEventHandler;
import oz.toto.framework.OZTotoObject;
import oz.toto.framework.OZTotoRuntime;
import oz.toto.framework.OZTotoWebView;
import oz.toto.framework.OZTotoWebViewListener;

public class OZViewerActivity extends Activity {

	FrameLayout parentView = null;
    OZTotoWebView toto = null;
    boolean isMain = true;
	OZTotoRuntime m_runtime;
	OZTotoRuntime m_runtime_un;

    OZTotoObject OZTotoFrameworkObj = null; //筌롢끇苡�癰귨옙占쎈땾 占쎄퐨占쎈섧占쏙옙

    private static final int RESULT = 1000;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        requestWindowFeature(Window.FEATURE_NO_TITLE);
        parentView = new FrameLayout(this);
        toto = new OZTotoWebView(this);
        parentView.addView(toto, new FrameLayout.LayoutParams(FrameLayout.LayoutParams.MATCH_PARENT, FrameLayout.LayoutParams.MATCH_PARENT));
        setContentView(parentView);
        OZTotoWebView.setDebugMode(true);

	    Intent intent = getIntent();
	    String ozr = WUtil.toDefault(intent.getStringExtra("ozr"));
	    String params = WUtil.toDefault(intent.getStringExtra("params"));
	    //Toast.makeText (this, ozr, Toast.LENGTH_SHORT).show();
	    Toast.makeText (this, "시작", Toast.LENGTH_SHORT).show();

//        toto.run("http://211.116.251.120/toto/");
        //toto.run("http://ods.charmloan.co.kr/oz70/");
//	    if ( "LoanPic".equals(ozr) ) {
//	    	ozr = "";
//	    }
		String host = getResources().getString(R.string.host);
		String startUrl = getResources().getString(R.string.start_url);
		String ozviewerFileName = getResources().getString(R.string.ozviewer_file_name);
	    Toast.makeText(OZViewerActivity.this, host + "/toto" + ozr + "/", Toast.LENGTH_SHORT).show();
        //toto.run("http://ods.charmloan.co.kr/toto" + ozr + "/");
        toto.run(host + "/toto" + ozr, ozviewerFileName + "?" + params);

        //toto.run("http://211.116.251.120/oz", "toto_ozviewer.jsp");
//        toto.run("http://192.168.0.198:8080/totoLoanPic/"); // 사전품의 3단계
//        toto.run("http://192.168.0.198:8080/totoSignPic/"); //
//        toto.run("http://192.168.0.198:8080/totoSignDoc/");

        toto.setTotoWebViewListener(new OZTotoWebViewListener() {
        	OZTotoEventHandler OZTotoFrameworkEvent = new OZTotoEventHandler() {
        		 @Override
        		 public void onEvent(OZTotoEvent e) {
                        System.out.println("!!!!!!![EVENT] Name="+e.eventName+", obj="+e.jsonObject);
                        Log.d("OZViewerActivity.java","!!!!!!![EVENT] Name="+e.eventName+", obj="+e.jsonObject);
                        if (e.eventName.equals("JSTONative_btnClick_Confirm")) {
                             JSONObject obj = e.jsonObject;
                             try {
                                  JSONObject jevent = obj.getJSONObject("event");
                                  String title = jevent.getString("title");
                                  String msg = jevent.getString("msg");
                                  confirm(title, msg);
                             } catch (JSONException e1) {
                                  // TODO Auto-generated catch block
                                  e1.printStackTrace();
                             }
                        }
                        if (e.eventName.equals("JSTONative_btnClick_Alert")) {
                            JSONObject obj = e.jsonObject;
                            try {
                                 JSONObject jevent = obj.getJSONObject("event");
                                 String title = jevent.getString("title");
                                 String msg = jevent.getString("msg");
                                 alert(title, msg);
                            } catch (JSONException e1) {
                                 // TODO Auto-generated catch block
                                 e1.printStackTrace();
                            }
                       }
                       if (e.eventName.equals("JSTONative_btnClick_PdfShow")) {
                            JSONObject obj = e.jsonObject;
                            System.out.println(">>>>>>JSTONative_btnClick_PdfShow>>>>");

                            try {
                                 JSONObject jevent = obj.getJSONObject("event");
                                 String path = jevent.getString("path");

                                 //start download
                                 new DownloadFile().execute(path, "contract_temp.pdf");
                                 viewPDF(toto);
                            } catch (JSONException e1) {
                                 // TODO Auto-generated catch block
                                 e1.printStackTrace();
                            }
                       }
                       if (e.eventName.equals("JSTONative_btnClick_AppFinish")) {
                           JSONObject obj = e.jsonObject;
                           System.out.println(">>>>>>JSTONative_btnClick_AppFinish>>>>");

                           try {
                                JSONObject jevent = obj.getJSONObject("event");
                                String flag = jevent.getString("flag");
                                if(flag.equals("finish")){
                                	exit();
                                }else{
                                	if (toto.canGoBack()) toto.goBack();
                                }
                           } catch (JSONException e1) {
                                // TODO Auto-generated catch block
                                e1.printStackTrace();
                           }
                      }
                       if (e.eventName.equals("Search_ZipCode")) {
                    	   JSONObject obj = e.jsonObject;

                    	   try{
                    		   JSONObject jevent = obj.getJSONObject("event");
                    		   String flag = jevent.getString("name");
                    		   //
                    		   //goAddrWeb(flag);

                    	   }catch(JSONException e1){
                    		   e1.printStackTrace();
                    	   }
                       }

                 if(e.eventName.equals("OpenViewer")) {
                     Toast.makeText(OZViewerActivity.this, "토스트.!@@", Toast.LENGTH_SHORT).show();
       		 	}

        		 if(e.eventName.equals("CloseViewer")) {
        			 try {
        				 JSONObject obj = e.jsonObject;
        				 JSONObject jevent = obj.getJSONObject("event");
        				 String j = jevent.getString("data");
        				 Intent intent = new Intent();
        				 intent.putExtra("data", j);
        				 OZViewerActivity.this.setResult(RESULT_OK, intent);
        				 OZViewerActivity.this.finish();
        			 } catch (JSONException e1) {
        				 e1.printStackTrace();
        				 Intent intent = new Intent();
        				 intent.putExtra("data", "");
        				 OZViewerActivity.this.setResult(RESULT_OK, intent);
        				 OZViewerActivity.this.finish();
        			 }
        		 }
        	}
        	 };

			@Override
			public void onPageLoad(final OZTotoRuntime runtime) {
			     runtime.getObject("OZTotoFramework", new IAsyncReturn() {
			           @Override
			           public void onReturn(Object _obj) {
			        	   OZTotoObject obj = (OZTotoObject)_obj;
			        	   obj.addEventListener("JSTONative_btnClick_Confirm", OZTotoFrameworkEvent);
			        	   obj.addEventListener("JSTONative_btnClick_Alert", OZTotoFrameworkEvent);
			        	   obj.addEventListener("JSTONative_btnClick_PdfShow", OZTotoFrameworkEvent);
			        	   obj.addEventListener("JSTONative_btnClick_AppFinish", OZTotoFrameworkEvent);
			        	   obj.addEventListener("Search_ZipCode", OZTotoFrameworkEvent);
			        	   /*obj.addEventListener("JSTONative_btnClick_AppFinish", new OZTotoEventHandler() {
								@Override
								public void onEvent(OZTotoEvent arg0) {
									// TODO Auto-generated method stub
									exit();
								}
						   });*/
			        	   obj.addEventListener("CloseViewer", OZTotoFrameworkEvent);
			        	   OZTotoFrameworkObj = obj;
			           }
			     });
			}

        	@Override
        	public void onPageUnload(OZTotoRuntime runtime) {
                  final int id = runtime.__id__();
                  System.out.println(">>>>>>onPageUnload>>>>"+id);
        	}

			@Override
			public void onSelectedMenuButton() {
				// TODO Auto-generated method stub

			}

        });


    }

    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event)  {
        if (keyCode == KeyEvent.KEYCODE_BACK) {
            if (toto.canGoBack()) {
                toto.goBack();
            }else exit();
            return true;
        }
        return super.onKeyDown(keyCode, event);
    }

    private void exit()
    {
        runOnUiThread(new Runnable() {
            @Override
            public void run() {
                new AlertDialog.Builder(OZViewerActivity.this)
                .setIcon(android.R.drawable.ic_dialog_alert)
                .setTitle("Exit")
                .setMessage("Are you sure you want to exit?")
                .setPositiveButton("YES", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        finish();
                    }
                })
                .setNegativeButton("NO", null)
                .show();
            }
        });
    }

    private void confirm(final String title, final String msg)
    {
    	runOnUiThread(new Runnable() {
    		@Override
    		public void run() {
    			new AlertDialog.Builder(OZViewerActivity.this)
    			.setIcon(android.R.drawable.ic_dialog_alert)
    			.setTitle(title)
    			.setMessage(msg)
    			.setPositiveButton("YES", new DialogInterface.OnClickListener() {
	    			@Override
	    			public void onClick(DialogInterface dialog, int which) {
	    				if (OZTotoFrameworkObj != null) {
	    					JSONObject jobj = new JSONObject();
	    					try {
								jobj.put("RESULT","YES");
							} catch (JSONException e) {
								// TODO Auto-generated catch block
								e.printStackTrace();
							}
	    					OZTotoFrameworkObj.dispatchEvent("NativeTOJS_btnClick_Confirm", jobj);
	    				}
	    			}
    			})
    			.setNegativeButton("NO", new DialogInterface.OnClickListener() {
    				@Override
	    			public void onClick(DialogInterface dialog, int which) {
	    				if (OZTotoFrameworkObj != null) {
	    					JSONObject jobj = new JSONObject();
	    					try {
								jobj.put("RESULT","NO");
							} catch (JSONException e) {
								// TODO Auto-generated catch block
								e.printStackTrace();
							}
	    					OZTotoFrameworkObj.dispatchEvent("NativeTOJS_btnClick_Confirm", jobj);
	    				}
	    			}
    			})
    			//.setNegativeButton("NO", null)
    			.show();
    		}
    	});
    }

    private void alert(final String title, final String msg)
    {
    	runOnUiThread(new Runnable() {
    		@Override
    		public void run() {
    			new AlertDialog.Builder(OZViewerActivity.this)
    			.setIcon(android.R.drawable.ic_dialog_alert)
                .setTitle(title)
                .setMessage(msg)
                .setPositiveButton("OK", null)
                .show();
               }
          });
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        if (toto != null) {
            toto.onActivityResult( this, requestCode, resultCode, data);
        }
        super.onActivityResult(requestCode, resultCode, data);
        switch(requestCode){
        	case RESULT:
        		if(resultCode==RESULT_OK){
        			Bundle bundle = data.getExtras();

        			String strFlag = bundle.getString("strFalg");
        			String strZipcodeRoad = bundle.getString("sZipRoad");
        			String strAddrRoad = bundle.getString("sAddrRoad");
        			String strZipcodeJibun = bundle.getString("sZipJibun");
        			String strAddrJibun = bundle.getString("sAddrJibun");

        			JSONObject jobj = new JSONObject();
        			try{
        				jobj.put("flag", strFlag);
        				jobj.put("roadZipcode", strZipcodeRoad);
        				jobj.put("roadAddress", strAddrRoad);
        				jobj.put("jibunZipcode", strZipcodeJibun);
        				jobj.put("jibunAddress", strAddrJibun);

        			}catch(JSONException e){
        				e.printStackTrace();
        			}
        			OZTotoFrameworkObj.dispatchEvent("addrResult", jobj);

        		}

        		break;

        }
    }

    // Download file
    private class DownloadFile extends AsyncTask<String, Void, Void>{

         @Override
         protected Void doInBackground(String... strings) {
             String fileUrl = strings[0];
             String fileName = strings[1];
             String extStorageDirectory = Environment.getExternalStorageDirectory().toString();
             File folder = new File(extStorageDirectory, "cleantopia");
             folder.mkdir();

             File pdfFile = new File(folder, fileName);

             try{
                 pdfFile.createNewFile();
             }catch (IOException e){
                 e.printStackTrace();
             }
             FileDownloaderUtil.downloadFile(fileUrl, pdfFile);
             return null;
         }
   }

    public void viewPDF(View v)
    {
        File pdfFile = new File(Environment.getExternalStorageDirectory() + "/cleantopia/" + "contract_temp.pdf");  // -> filename = maven.pdf
        Uri path = Uri.fromFile(pdfFile);
        Intent pdfIntent = new Intent(Intent.ACTION_VIEW);
        pdfIntent.setDataAndType(path, "application/pdf");
        pdfIntent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);

        try{
            startActivity(pdfIntent);
        }catch(ActivityNotFoundException e){
            Toast.makeText(OZViewerActivity.this, "No Application available to view PDF", Toast.LENGTH_SHORT).show();
        }
    }

/*    public void goAddrWeb(String flag){
    	Intent intent = new Intent(this, AddrActivity.class);
//    	startActivity(intent);
    	intent.putExtra("strFlag", flag);
    	startActivityForResult(intent, RESULT);

    }*/

}
