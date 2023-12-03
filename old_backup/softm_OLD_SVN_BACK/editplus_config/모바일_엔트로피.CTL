#TITLE=모바일_엔트로피
#INFO
New Cliptext library
#SORT=n

#T=confirm
		confirm(R.string.msg_finish_confirm
				, new DialogInterface.OnClickListener() {
					public void onClick(DialogInterface dialog, int whichButton) {
                    	finish();
					}
				}
				, new DialogInterface.OnClickListener() {
					public void onClick(DialogInterface dialog, int whichButton) {
//						showAlert("취소");						
					}
				}
		);
#T=db.rawQuery-spinner
	private void list() {
		try {
			startProgressBar();			
    		new Thread(new Runnable() {
    			public void run() {
    				ListViewMP lv1 = (ListViewMP)findViewById(R.id.listView1);
					Cursor c = db.rawQuery("SELECT _rowid_ as _id, CD,CD_NM FROM " + ConstantChg.TBL_CODE
					        + " WHERE TYPE_CD = '11'", null);
					ChgTargetRcvAdapter adapter = new ChgTargetRcvAdapter(getApplicationContext(), c, 0);    					
					lv1.setAdapter(adapter);					
    				sendMessage(Constant.PROC_ID_SELECT_SQLITE, "1", true, "USER_DATA");
    			}
    		}).start();	
    		
		} catch (SQLiteException se ) {
	    	Log.e(getClass().getSimpleName(), se.toString());
	    } finally {
	    }
	}
#