/***********************************
[ucloud Android manager] version [2.0]

Copyright © 2013 kt Inc. All rights reserved. 

This is a proprietary software of kt Inc. 
and you may not use this file except in compliance with 
license agreement with kt Inc. Any redistribution or use of this software, 
with or without modification shall be strictly prohibited without prior written approval of kt Inc. and the copyright notice above does not evidence any actual or intended publication of such software.

 ************************************/

package com.entropykorea.gas.as.common.object;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.view.ContextThemeWrapper;
import android.view.Gravity;
import android.widget.TextView;

import com.entropykorea.gas.as.R;

public class Alert {
  
  private static String confirmMethodNameOk;
  private static String confirmMethodNameCancel;
//  private static Object confirmObject;
  private static Activity confirmActivity;
  private static Context confirmContext;
  
  public static void alert(Activity activity, String msg, String methodNameOk) {
    confirmActivity = activity;
    confirmMethodNameOk = methodNameOk;
    
    alert(msg);
  }
  
  public static void confirm(Activity activity, String message, String methodNameOk, String methodNameCancel) {
    String ok = ((Context) activity).getText(R.string.ok).toString();
    String cancel = ((Context) activity).getText(R.string.cancel).toString();
    
    confirmMethodNameOk = methodNameOk;
    confirmMethodNameCancel = methodNameCancel;
    //confirmObject = activity;
    confirmActivity = activity;
    
    confirm(message, ok, cancel);
  }
  
  private static void alert(String msg) {
    
    AlertDialog.Builder dialog = new AlertDialog.Builder(new ContextThemeWrapper(confirmActivity, R.style.DialogTheme));
    String btnStr = confirmActivity.getText(R.string.ok).toString();
    dialog.setMessage("\n" + msg + "\n");
    dialog.setPositiveButton(btnStr, new DialogInterface.OnClickListener() {
      @Override
      public void onClick(DialogInterface dialog, int which) {
        if (confirmMethodNameOk != null && confirmMethodNameOk.length() > 0) {
          try {
            confirmActivity.getClass().getMethod(confirmMethodNameOk).invoke(confirmActivity);
          } catch (Exception e) {
            e.printStackTrace();
            MLog.d(confirmMethodNameOk + " call error!");
          }
        }
      }
    });
    dialog.create();
    AlertDialog dig = dialog.show();

    TextView messageText = (TextView)dig.findViewById(android.R.id.message);
    messageText.setGravity(Gravity.CENTER);
  }
  
  private static void confirm(String msg, String okText, String cancelText) {
    
    AlertDialog.Builder dialog = new AlertDialog.Builder(new ContextThemeWrapper(confirmActivity, R.style.DialogTheme));
    // dialog.setTitle("안내");
    dialog.setMessage("\n" + msg + "\n");
    dialog.setPositiveButton(okText, new DialogInterface.OnClickListener() {
      @Override
      public void onClick(DialogInterface dialog, int which) {
        if (confirmMethodNameOk != null && confirmMethodNameOk.length() > 0) {
          try {
            confirmActivity.getClass().getMethod(confirmMethodNameOk).invoke(confirmActivity);
          } catch (Exception e) {
            e.printStackTrace();
            MLog.d(confirmMethodNameOk + " call error!");
          }
        }
      }
    });
    
    dialog.setNeutralButton(cancelText, new DialogInterface.OnClickListener() {
      @Override
      public void onClick(DialogInterface dialog, int which) {
        if (confirmMethodNameCancel != null && confirmMethodNameCancel.length() > 0) {
          try {
            confirmActivity.getClass().getMethod(confirmMethodNameCancel).invoke(confirmActivity);
          } catch (Exception e) {
            e.printStackTrace();
            MLog.d(confirmMethodNameCancel + " call error!");
          }
        }
      }
    });
    dialog.create();
    AlertDialog dig = dialog.show();

    TextView messageText = (TextView)dig.findViewById(android.R.id.message);
    messageText.setGravity(Gravity.CENTER);
  }
}
