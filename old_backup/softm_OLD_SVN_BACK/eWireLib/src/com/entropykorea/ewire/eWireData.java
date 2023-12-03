package com.entropykorea.ewire;

import java.io.File;
import java.io.UnsupportedEncodingException;
import java.util.HashMap;
import java.util.Map.Entry;

import android.content.Context;
import android.content.Intent;
import android.database.sqlite.SQLiteDatabase;
import android.os.AsyncTask;
import android.widget.Toast;

import com.entropykorea.ewire.database.Sqlite;
import com.entropykorea.ewire.dialog.eWireTransDialog;
import com.entropykorea.ewire.spec.FieldSpec;
import com.entropykorea.ewire.spec.SpecReflection;

public abstract class eWireData {

	public final static String BROADCAST_ACTION_EWIREDATA = "com.entropykorea.ewire.EWIREDATA";
	private final static String ENCODING = "KSC5601";
	private final static String DAT_EXTENTION = ".dat";
	private final static String ZIP_EXTENTION = ".zip";
	public final static String DEFAULT_DISPLAYMESSAGE = "처리 중입니다.\n잠시만 기다리십시요"; // default
	// message

	public final static int DIALOGTYPE_NONE = 0;
	public final static int DIALOGTYPE_WAIT = 1;
	public final static int DIALOGTYPE_PROGRESS = 2;
	public final static int DIALOGTYPE_WAIT_PROGRESS = 3;
	
	private boolean deleteAfterImport = true; 

	private Context context = null;
	private Sqlite sqlite = null;
	private eWireFileLine fileLine = null;
	private String outputfolder = new String();
	private String zipfilename = new String();
	private String[] addfilenames = null;

	private Object[] databasespecication = null;
	private eWireError ewireerror = eWireError.NONE_ERROR;

	// options
	private int dialogtype = 2; // 0: none 1: only progress 2: dialog + horizontal progress 3:
	private boolean showstatusbar = false;
	private boolean showerror = false;
	private boolean soundplay = false;
	private String displaymessage = DEFAULT_DISPLAYMESSAGE;

	private int delaytime = 0;

	private eWireTransDialog progressDialog;

	public eWireData(Context context) {
		this.context = context;
	}
	
	public void setShowStatusBar( boolean showstatusbar ) {
		this.showstatusbar = showstatusbar;
	}

	public void setDatabase(SQLiteDatabase sqlitedatabase) {
		this.sqlite = new Sqlite(sqlitedatabase);
	}

	public void setZipfilename(String zipfilename) {
		this.zipfilename = zipfilename;
	}

	public void setOutputFolder(String outputfolder) {
		this.outputfolder = outputfolder;
	}

	public void setDatabaseSpecication(Object[] databasespecication) {
		this.databasespecication = databasespecication;
	}

	public void setAddFiles(String path, String[] filenames) {
		this.addfilenames = filenames;
		for (int i = 0; i > filenames.length; i++) {
			addfilenames[i] = path + File.separator + filenames[i];
		}
	}

	public void setAddFiles(String[] filenames) {
		this.addfilenames = filenames;
	}

	public void setAddFiles(HashMap<String, String> filenames) {
		String[] string;
		int i = 0;
		string = new String[filenames.size()];
		for (Entry<String, String> e : filenames.entrySet()) {
			string[i] = e.getValue();
			i++;
		}
		this.addfilenames = string;
	}

	// option
	public void setDialogType(int type) {
		this.dialogtype = type;
	}

	public void setShowError(boolean showerror) {
		this.showerror = showerror;
	}

	public void setSoundPlay(boolean soundplay) {
		this.soundplay = soundplay;
	}

	public void setDisplayMessage(String displaymessage) {
		this.displaymessage = displaymessage;
	}

	public void setDelayTime(int milisecond) {
		this.delaytime = milisecond;
	}
	
	public void setDeleteAfterImport(boolean deleteAfterImport) {
		this.deleteAfterImport = deleteAfterImport;
	}

	// interface
	public abstract void preExcute();

	public interface preExcute {
		void preExcute();
	}

	private preExcute callbackPreExcute = null;

	public void setPreExcute(preExcute callback) {
		this.callbackPreExcute = callback;
	}

	public abstract void postExcute();

	public interface postExcute {
		void postExcute();
	}

	private postExcute callbackPostExcute = null;

	public void setPostExcute(postExcute callback) {
		this.callbackPostExcute = callback;
	}

	public abstract void onFinished(boolean result, String resultMessage);

	public interface onFinished {
		void onFinished(boolean result, String resultMessage);
	}

	private onFinished callbackOnFinished = null;

	public void setOnFinished(onFinished callback) {
		this.callbackOnFinished = callback;
	}

	// error
	public String getErrorMessage() {
		return this.ewireerror.getDesc();
	}

	public String getErrorMessageDetail() {
		return this.ewireerror.getDetail();
	}

	public String getErrorCode() {
		return this.ewireerror.getCode();
	}

	// util
	private boolean stringInList(String[] listString, String string) {
		for (String list : listString) {
			if (list.contains(string)) {
				return true;
			}
		}
		return false;
	}

	// string -> byte and space
	private void string2byte(String src, byte[] tar) {
		byte[] temp;
		try {
			temp = src.getBytes(ENCODING);
		} catch (UnsupportedEncodingException e) {
			temp = new byte[0];
		}
		int temp_len = temp.length;
		int len = tar.length;

		for (int i = 0; i < len; i++) {
			if (temp_len > i)
				tar[i] = temp[i];
			else
				tar[i] = 0x20; // space
		}
	}

	private void logShow(String msg) {
		eWireLog.d( msg);
	}

	// functions
	// line(byte) -> string array
	private String[] parseLine(byte[] byteBuf, FieldSpec[] fieldSpecs) {

		int len = fieldSpecs.length;
		int fieldLen = 0;
		int offset = 0;
		int i;
		String[] resultString = new String[len];
		byte[] fieldByteBuf = null;

		for (i = 0; i < len; i++) {

			fieldLen = fieldSpecs[i].length;
			fieldByteBuf = new byte[fieldLen];

			// readbuf -> fieldbuf
			System.arraycopy(byteBuf, offset, fieldByteBuf, 0, fieldLen);
			offset += fieldLen;

			// encoding
			try {
				resultString[i] = new String(fieldByteBuf, ENCODING).trim();
			} catch (UnsupportedEncodingException e) {
				resultString[i] = "";
			}
		}
		return resultString;
	}

	// db -> line(byte)
	private byte[] makeLine(Sqlite sqlite2, int totalLineLength,
			FieldSpec[] fieldSpecs) {

		int len = fieldSpecs.length;
		int fieldLen = 0;
		int offset = 0;
		int i;
		byte[] resultLine = new byte[totalLineLength];
		byte[] fieldByteBuf = null;
		byte[] crlf = { 0x0d, 0x0a };
		String fieldName, fieldValue;

		for (i = 0; i < len; i++) {

			fieldLen = fieldSpecs[i].length;
			fieldByteBuf = new byte[fieldLen];

			fieldName = fieldSpecs[i].name.trim();
			fieldValue = sqlite2.getValue(fieldName);

			string2byte(fieldValue, fieldByteBuf);

			// fieldBytebuf -> resultLine
			System.arraycopy(fieldByteBuf, 0, resultLine, offset, fieldLen);
			offset += fieldLen;
		}

		// CRLF
		System.arraycopy(crlf, 0, resultLine, offset, crlf.length);

		return resultLine;
	}

	private String genImportSql(String[] fieldValues, String tableName,
			FieldSpec[] fieldSpecs) {

		int i, len = fieldSpecs.length;
		String sql = new String();

		// INSERT OR REPLACE INTO TABLENAME ( COLUMN-NAME ) VALUES ( EXPR );
		sql = "INSERT OR REPLACE INTO " + tableName + " ( ";
		for (i = 0; i < len; i++) {
			sql += fieldSpecs[i].name.trim();
			if (i < len - 1) {
				sql += ",";
			}
		}
		sql += " ) VALUES ( ";
		for (i = 0; i < len; i++) {
			sql += "'";
			if( fieldSpecs[i].isEncrypt ) {
				String encoded = Aes256.encode( fieldValues[i] );
				if( encoded != null ) {
					sql += encoded;
				} else {
					sql += fieldValues[i];
				}
			} else {
				sql += fieldValues[i];
			}
			sql += "'";
			if (i < len - 1) {
				sql += ",";
			}
		}
		sql += " )";

		return sql;
	}

	private String genExportSql(String tableName, String selectClause,
			String whereClause) {

		String sql = new String();

		if (selectClause != null) {
			sql = selectClause;
		} else {
			// SELECT * FROM TABLENAME WHERE WEHRECLAUSE
			sql = "SELECT * FROM " + tableName;
			if (whereClause != null) {
				sql += " " + whereClause;
			}
		}
		return sql;
	}

	private boolean doImport() {

		String[] fileList = null;
		String fileName, tableName;
		int totalLineLength;
		FieldSpec[] fieldSpecs;
		byte[] readBuf;
		int i;

		// get file list
		fileList = FileUtils.getFiles(outputfolder, DAT_EXTENTION);
		if (fileList == null) {
			ewireerror = eWireError.ZIP_NOZIP_ERROR;
			return true;
		}

		fileLine = new eWireFileLine();

		for (Object spec : databasespecication) {

			fileName = SpecReflection.getFileName(spec);

			if (stringInList(fileList, fileName)) {

				fileName = SpecReflection.getFileName(spec);
				fieldSpecs = SpecReflection.getFieldSpecs(spec);
				tableName = SpecReflection.getTableName(spec);
				totalLineLength = SpecReflection.getTotalLength(spec) + 2; // CRLF

				// setting
				fileLine.setFileName(outputfolder + File.separator + fileName);
				fileLine.setFieldLengths(totalLineLength);

				// file open
				if (!fileLine.open(eWireFileLine.MODEREAD)) {
					ewireerror = eWireError.FILE_OPEN_ERROR;
					return false;
				}

				// file size not match
				if (!fileLine.isReadBlock()) {
					ewireerror = eWireError.FILE_SIZE_ERROR;
					return false;
				}

				String insertSql = new String();
				// int insertSqlCount = 0;

				// loop line
				for (i = 0; i < fileLine.getTotalReadBlock(); i++) {

					// read line
					try {
						readBuf = fileLine.read();
					} catch (Exception e) {
						e.printStackTrace();
						fileLine.close();
						ewireerror = eWireError.FILE_READ_ERROR;
						return false;
					}

					// parse field
					String[] fieldValues = parseLine(readBuf, fieldSpecs);
					// gen sql command
					insertSql = genImportSql(fieldValues, tableName, fieldSpecs);
					logShow("" + insertSql);

					// excute sql
					if (!sqlite.execSql(insertSql)) {
						fileLine.close();
						ewireerror = eWireError.SQL_INSERT_ERROR;
						ewireerror.setDetail(sqlite.getErrorMessage());
						return false;
					}
					//
					// insertSql = "";
					// insertSqlCount = 0;
					// }

				}

				fileLine.close();
			}
		}

		return true;
	}

	private boolean doExport() {

		String fileName, tableName, whereClause, selectClause;
		int totalLineLength;
		FieldSpec[] fieldSpecs;
		byte[] writeBuf;

		fileLine = new eWireFileLine();

		for (Object spec : databasespecication) {

			fileName = SpecReflection.getFileName(spec);
			fieldSpecs = SpecReflection.getFieldSpecs(spec);
			tableName = SpecReflection.getTableName(spec);
			whereClause = SpecReflection.getWhereClause(spec);
			selectClause = SpecReflection.getSelectClause(spec);
			totalLineLength = SpecReflection.getTotalLength(spec) + 2; // CRLF

			// setting
			fileLine.setFileName(outputfolder + File.separator + fileName);
			fileLine.setFieldLengths(totalLineLength); // CRLF

			// file open
			if (!fileLine.open(eWireFileLine.MODEWRITE)) {
				ewireerror = eWireError.FILE_OPEN_ERROR;
				return false;
			}

			// gen sql command
			String selectSql = genExportSql(tableName, selectClause,
					whereClause);

			logShow("" + selectSql);

			// excute sql
			if (!sqlite.rawQuery(selectSql)) {
				fileLine.close();
				ewireerror = eWireError.SQL_SELECT_ERROR;
				ewireerror.setDetail(sqlite.getErrorMessage());
				return false;
			}

			if (sqlite.moveToFirst()) {
				do {
					writeBuf = makeLine(sqlite, totalLineLength, fieldSpecs);

					try {
						fileLine.write(writeBuf);
					} catch (Exception e) {
						e.printStackTrace();
						fileLine.close();
						ewireerror = eWireError.FILE_WRITE_ERROR;
						return false;
					}

				} while (sqlite.moveToNext());
			}

			fileLine.close();

		}

		return true;
	}

	public void showDialog() {
		if (progressDialog != null) {
			hideDialog();
		}
		progressDialog = new eWireTransDialog(context, this.dialogtype, true, this.showstatusbar);
		progressDialog.setMessage(displaymessage);
		progressDialog.show();
	}

	public void hideDialog() {
		if (progressDialog != null) {
			progressDialog.hide();
			progressDialog.dismiss();
			progressDialog = null;
		}
	}

	// util
	private void sleep(int milisecond) {
		try {
			Thread.sleep(milisecond);
		} catch (InterruptedException e) {
			e.printStackTrace();
		}
	}

	private void endData(boolean result) {

		// wait
		if (this.delaytime > 0) {
			sleep(this.delaytime);
		}

		hideDialog();

		mResultMessage = ewireerror.getDesc();

		// 정상의 경우
		if (result) {
			if (this.soundplay) {
				eWireSound.playOk(context);
			}
		} else {
			if (this.showerror) {
				Toast.makeText(context, mResultMessage, Toast.LENGTH_SHORT)
						.show();
			}

			eWireLog.e(ewireerror.getError());
		}

		onFinished(result, mResultMessage);

		if (callbackOnFinished != null) {
			callbackOnFinished.onFinished(result, mResultMessage);

		} else {
			// Broadcast
			Intent intent = new Intent();
			intent.setAction(BROADCAST_ACTION_EWIREDATA);
			intent.putExtra("RESULT", result);
			intent.putExtra("RESULTMESSAGE", mResultMessage);
			context.sendBroadcast(intent);
		}
	}

	// //////////////////////////////////////////
	// thread

	boolean mThreadRunning = false;
	String mResultMessage = new String();

	public String getResult() {
		return mResultMessage;
	}

	// ///////////////////////////////////////////
	// imort

	// call ImportTask
	public void excuteImport() {
		if (mThreadRunning == true)
			return;
		ewireerror = eWireError.NONE_ERROR;
		showDialog();
		new ImportTask().execute();
	}

	// call ExportTask
	public void excuteExport() {
		if (mThreadRunning == true)
			return;
		ewireerror = eWireError.NONE_ERROR;
		showDialog();
		new ExportTask().execute();
	}

	class ImportTask extends AsyncTask<Void, Void, Boolean> {

		@Override
		protected Boolean doInBackground(Void... params) {
			mThreadRunning = true;
			return _excuteImport();
		}

		@Override
		protected void onPostExecute(Boolean result) {
			mThreadRunning = false;
			endData(result);
			super.onPostExecute(result);
		}
	}

	class ExportTask extends AsyncTask<Void, Void, Boolean> {

		@Override
		protected Boolean doInBackground(Void... params) {
			mThreadRunning = true;
			return _excuteExport();
		}

		@Override
		protected void onPostExecute(Boolean result) {
			mThreadRunning = false;
			endData(result);
			super.onPostExecute(result);
		}
	}

	private boolean _excuteImport() {

		boolean rtn = false;

		// delete all dat
		FileUtils.deleteFiles(outputfolder, DAT_EXTENTION);

		// unzip
		if (!Zip.unZip(zipfilename, outputfolder)) {
			ewireerror = eWireError.ZIP_UNZIP_ERROR;
			return false;
		}

		// transaction
		sqlite.beginTransaction();

		if (callbackPreExcute != null) {
			callbackPreExcute.preExcute();
		} else {
			preExcute();
		}

		// sqlite parameter set
		sqlite.execSql("PRAGMA synchornous = OFF", "PRAGMA auto_vacuum = 0");

		rtn = doImport();

		sqlite.execSql("PRAGMA synchornous = ON", "PRAGMA auto_vacuum = 1");

		if (rtn) {
			if (callbackPostExcute != null) {
				callbackPostExcute.postExcute();
			} else {
				postExcute();
			}

			sqlite.commit();
		} else {
			sqlite.rollBack();
		}

		// delete all dat
		if( this.deleteAfterImport ) {
			FileUtils.deleteFiles(outputfolder, DAT_EXTENTION);
			FileUtils.deleteFiles(outputfolder, ZIP_EXTENTION);
		}
		
		return rtn;
	}

	public boolean _excuteExport() {

		boolean rtn = false;
		String[] fileList = null;

		// delete all dat
		FileUtils.deleteFiles(outputfolder, DAT_EXTENTION);

		// transaction
		sqlite.beginTransaction();

		if (callbackPreExcute != null) {
			callbackPreExcute.preExcute();
		}

		rtn = doExport();

		if (rtn) {
			if (callbackPostExcute != null) {
				callbackPostExcute.postExcute();
			}
			sqlite.commit();
		} else {
			sqlite.rollBack();
		}

		// get file list
		fileList = FileUtils.getFiles(outputfolder, DAT_EXTENTION);
		if (fileList == null) {
			ewireerror = eWireError.ZIP_NOZIP_ERROR;
			return false;
		}

		// zip
		if (!Zip.makeZip(zipfilename, outputfolder, fileList, addfilenames)) {
			ewireerror = eWireError.ZIP_MAKEZIP_ERROR;
			return false;
		}

		// delete all dat
		if( this.deleteAfterImport ) {
			FileUtils.deleteFiles(outputfolder, DAT_EXTENTION);
		}
		
		return rtn;
	}

}
