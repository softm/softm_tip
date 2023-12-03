package com.mypidion.BI300;

import java.util.UUID;

public class StaticCollection {
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	// bluetooth connection
	/// Message types sent from the BI300Service Handler
	public static final int MESSAGE_STATE_CHANGE = 1;
    public static final int MESSAGE_READ = 2;
    public static final int MESSAGE_WRITE = 3;
    public static final int MESSAGE_DEVICE_NAME = 4;
    public static final int MESSAGE_TOAST = 5;

    /// Key names received from the BI300Service Handler
    public static final String DEVICE_NAME = "device_name";
    public static final String TOAST = "toast";
    
    public static final int REQUEST_CONNECT_DEVICE = 1;
    public static final int REQUEST_ENABLE_BT = 2;
    
    // Return Intent extra
    public static String EXTRA_DEVICE_ADDRESS = "device_address";
    
    // debug log 용..
    public static final boolean D = true;
    
    public static final UUID MY_UUID = UUID.fromString("00001101-0000-1000-8000-00805F9B34FB");
}
