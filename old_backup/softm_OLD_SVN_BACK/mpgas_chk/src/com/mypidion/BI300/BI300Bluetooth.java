package com.mypidion.BI300;

import java.util.Set;

import org.apache.http.util.EncodingUtils;

import android.app.AlertDialog;
import android.bluetooth.BluetoothAdapter;
import android.bluetooth.BluetoothDevice;
import android.content.Context;
import android.content.DialogInterface;
import android.os.Handler;
import android.os.Message;
import android.util.Log;
import android.widget.Toast;

import com.entropykorea.gas.chk.R;
import com.mypidion.BI300SDK.BI300Service;

public class BI300Bluetooth {
  // Debugging
  private final String TAG = "DeviceListActivity";
  private Context context = null;
  
  // Member fields
  private BluetoothAdapter mBluetoothAdapter;
  private BI300Service mBI300Service = null;
  
  private String strAddress = "";
  public Handler messageHandler = null;
  
  public BI300Bluetooth(Context context, Handler hd) {
    this.context = context;
    messageHandler = hd;
  }
  
  // protected void onStart() {
  // // TODO Auto-generated method stub
  //
  // values = (TextView) findViewById(R.id.values);
  //
  // // Initialize the button to perform device discovery
  // scanButton = (Button) findViewById(R.id.button_start);
  // scanButton.setOnClickListener(new OnClickListener() {
  // public void onClick(View v) {
  // startBI300();
  // }
  // });
  //
  // scanButton = (Button) findViewById(R.id.button_stop);
  // scanButton.setOnClickListener(new View.OnClickListener() {
  //
  // @Override
  // public void onClick(View v) {
  // stopBI300();
  // }
  // });
  // }
  
  public void startBI300() {
    // Get local Bluetooth adapter
    mBluetoothAdapter = BluetoothAdapter.getDefaultAdapter();
    
    // If the adapter is null, then Bluetooth is not supported
    if (mBluetoothAdapter == null) {
      Toast.makeText(context, "Bluetooth is not available", Toast.LENGTH_LONG).show();
      return;
    }
    if (mBI300Service == null) {
      mBI300Service = new BI300Service(context, mHandler);
      
      Set<BluetoothDevice> pairedDevices = mBluetoothAdapter.getBondedDevices();
      
      // If there are paired devices, add each one to the ArrayAdapter
      // 블루투스가 꺼져 있으면 동작 하지 않는다..
      if (pairedDevices.size() > 0) {
        for (BluetoothDevice deviceCd : pairedDevices) {
          Log.i(TAG, "bluetooth mode 1:" + deviceCd.getName() + ", " + deviceCd.getAddress());
          if (deviceCd.getName().contains("BI-300")) {
            strAddress = deviceCd.getAddress();
            // 자동연결
            BluetoothDevice device = mBluetoothAdapter.getRemoteDevice(strAddress);
            // Attempt to connect to the device
            Log.i("ScanMode", "" + mBluetoothAdapter.getState());
            
            // mBI300Service.start();//서버 모드
            mBI300Service.connect(device);// 클라이언트 모드
            
            Log.i("Device", device.getBondState() + "");
          }
        }
      } else {
        String msg = "블루투스를 확인 하세요.";
        new AlertDialog.Builder(context).setTitle("알림").setMessage(msg).setPositiveButton("확인", new DialogInterface.OnClickListener() {
          public void onClick(DialogInterface dialog, int whichButton) {
            stopBluetooth();
            stopBI300();
          }
        }).create().show();
      }
    }
  }
  
  public void stopBI300() {
    // Stop the Bluetooth BI300 services
    if (mBI300Service != null) {
      mBI300Service.biSetScanDataLengthDefault();
      mBI300Service.stop();
      mBI300Service = null;
    }
    if (StaticCollection.D) Log.e(TAG, "--- SERVICE STOP ---");
  }
  
  private void stopBluetooth() {
    // Make sure we're not doing discovery anymore
    if (mBluetoothAdapter != null) {
      mBluetoothAdapter.cancelDiscovery(); // 디바이스 찾기 멈추고
      mBluetoothAdapter.disable(); // 어답터 끈다. 블루투스를 계속 켜놓고 싶으면 이 라인 주석처리.
      mBluetoothAdapter = null;
    }
    // Unregister broadcast listeners
    if (StaticCollection.D) Log.e(TAG, "--- BLUETOOTH STOP ---");
  }
  
  // The Handler that gets information back from the BI300Service
  private final Handler mHandler = new Handler() {
    @Override
    public void handleMessage(Message msg) {
      switch (msg.what) {
        case StaticCollection.MESSAGE_STATE_CHANGE:
          if (StaticCollection.D) Log.i(TAG, "MESSAGE_STATE_CHANGE: " + msg.arg1);
          if (msg.arg1 == 0 || msg.arg1 == 1) {
            String ms = "장비가 꺼져 있습니다.";
//            new AlertDialog.Builder(context).setTitle("알림").setMessage(ms).setPositiveButton("확인", new DialogInterface.OnClickListener() {
//              public void onClick(DialogInterface dialog, int whichButton) {
//                stopBI300();
//              }
//            }).create().show();
            Toast.makeText(context, ms, Toast.LENGTH_SHORT).show();
            stopBI300();            
          }
          switch (msg.arg1) {
            case BI300Service.STATE_CONNECTED:
              Toast.makeText(context, context.getString(R.string.title_connected_to), Toast.LENGTH_SHORT).show();
              break;
            case BI300Service.STATE_CONNECTING:
              Toast.makeText(context, context.getString(R.string.title_connecting), Toast.LENGTH_SHORT).show();
              break;
            case BI300Service.STATE_LISTEN:
            case BI300Service.STATE_NONE:// 블루투스 끊긴 상
              Toast.makeText(context, context.getString(R.string.title_not_connected), Toast.LENGTH_SHORT).show();
              break;
            case 4: // BI300Service.STATE_ERROR:
              Toast.makeText(context, context.getString(R.string.title_error), Toast.LENGTH_SHORT).show();
              break;
          }
          break;
        case StaticCollection.MESSAGE_READ:
          byte[] readBuf = (byte[]) msg.obj;
          // construct a string from the valid bytes in the buffer
          String readMessage = new String();
          
          // 비영어권 문자를 사용할떄는 아래 코드를 사용해야 함. 일반적인 경우라면 그냥 버퍼를 스트링으로 바꾸면됨
          readMessage = EncodingUtils.getString(readBuf, 0, msg.arg1, "Shift-JIS");
          // try {
          //
          // readMessage = new String(readBuf, 0, msg.arg1, "UTF-8");
          //
          // } catch (UnsupportedEncodingException e) {
          // // TODO Auto-generated catch block
          // e.printStackTrace();
          // }
          int what = 1;
          String result = readMessage;
          messageHandler.sendMessage(messageHandler.obtainMessage(what, result));
          break;
        case StaticCollection.MESSAGE_DEVICE_NAME:
          // save the connected device's name
          break;
        case StaticCollection.MESSAGE_TOAST:
          Toast.makeText(context, msg.getData().getString(StaticCollection.TOAST), Toast.LENGTH_SHORT).show();
          break;
      }
    }
  };
  
}