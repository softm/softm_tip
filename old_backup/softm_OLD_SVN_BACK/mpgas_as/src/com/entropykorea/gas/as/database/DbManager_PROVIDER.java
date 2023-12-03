package com.entropykorea.gas.as.database;

import android.content.ContentValues;
import android.database.Cursor;
import android.database.DatabaseUtils;
import android.database.SQLException;
import android.database.sqlite.SQLiteDatabase;
import android.os.Handler;

import com.entropykorea.gas.as.AppContext;
import com.entropykorea.gas.as.bean.Provider;
import com.entropykorea.gas.as.common.object.MLog;
import com.entropykorea.gas.as.constants.Constant;

public class DbManager_PROVIDER {
  
  private static SQLiteDatabase mSQLiteDB;
  private String dbTable = DBTable_PROVIDER.Columns._TABLENAME;
  private DBTable_PROVIDER.Columns columns = new DBTable_PROVIDER.Columns();
  
  private Provider bean;
  private Handler handler;
  
  public DbManager_PROVIDER() {
    mSQLiteDB = AppContext.getSQLiteDatabase();
  }
  
  public void DbHandler(Handler handler) {
    this.handler = handler;
  }
  
  private void HandlerBoolean(boolean result) {
    if (handler == null) return;
    if (result) {
      handler.sendEmptyMessage(Constant.RESULT_SUCCESS);
    } else {
      handler.sendEmptyMessage(Constant.RESULT_FAIL);
    }
  }
  
  public synchronized void close() {
    if (mSQLiteDB != null) mSQLiteDB.close();
  }
  
  // Delete Contact
  public boolean deleteColumn() {
    boolean result = false;
    try {
      result = mSQLiteDB.delete(dbTable, null, null) > 0;
      HandlerBoolean(result);
    } catch (SQLException e) {
      MLog.e("Error writing delete - " + dbTable + e.toString());
      HandlerBoolean(result);
    } finally {
      if (mSQLiteDB != null && mSQLiteDB.inTransaction()) mSQLiteDB.endTransaction();
      // close();
    }
    return result;
  }
  
  // Delete All
  public boolean deleteAllColumn() {
    boolean result = false;
    try {
      if (getCursorCount() > 0) result = mSQLiteDB.delete(dbTable, null, null) > 0;
      HandlerBoolean(result);
    } catch (SQLException e) {
      MLog.e("Error writing delete - " + dbTable + e.toString());
      HandlerBoolean(result);
    } finally {
      if (mSQLiteDB != null && mSQLiteDB.inTransaction()) mSQLiteDB.endTransaction();
      // close();
    }
    return result;
  }
  
  // Insert DB
  public long insertColumn(Provider bean) {
    long insert = 0;
    boolean result = false;
    
    ContentValues values = null;
    values = getValues(bean);
    try {
      mSQLiteDB.beginTransaction();
      insert = mSQLiteDB.insert(dbTable, null, values);
      mSQLiteDB.setTransactionSuccessful();
      HandlerBoolean(result);
    } catch (SQLException e) {
      MLog.e("Error writing insert - " + dbTable + e.toString());
      e.printStackTrace();
      HandlerBoolean(result);
    } finally {
      if (mSQLiteDB != null && mSQLiteDB.inTransaction()) mSQLiteDB.endTransaction();
      // close();
    }
    return insert;
  }
  
  // Update DB
  public boolean updateColumn(Provider bean) {
    boolean result = false;
    
    ContentValues values = null;
    values = getValues(bean);
    
    try {
      mSQLiteDB.beginTransaction();
      result = mSQLiteDB.update(dbTable, values, null, null) > 0;
      mSQLiteDB.setTransactionSuccessful();
      HandlerBoolean(result);
    } catch (SQLException e) {
      MLog.e("Error writing update - " + dbTable + e.toString());
      HandlerBoolean(result);
    } finally {
      if (mSQLiteDB != null && mSQLiteDB.inTransaction()) mSQLiteDB.endTransaction();
      // close();
    }
    return result;
  }
  
  private ContentValues getValues(Provider bean) {
    ContentValues values = new ContentValues();
    values.put(columns.CO_NM, bean.CO_NM);
    values.put(columns.CEO_NM, bean.CEO_NM);
    values.put(columns.CO_NO, bean.CO_NO);
    values.put(columns.ADDR, bean.ADDR);
    values.put(columns.ROAD_ADDR1, bean.ROAD_ADDR1);
    values.put(columns.ROAD_ADDR2, bean.ROAD_ADDR2);
    values.put(columns.TEL_NO, bean.TEL_NO);
    values.put(columns.VAN_NO, bean.VAN_NO);
    values.put(columns.VAN_CARD_NO, bean.VAN_CARD_NO);
    
    return values;
  }
  
  /**
   * 데이터 리스트
   **/
  public Provider getTotalList(Cursor cursor) {
    bean = null;
    bean = new Provider();
    
    try {
      while (cursor.moveToNext()) {
        bean.CO_NM = cursor.getString(cursor.getColumnIndex(columns.CO_NM));
        bean.CEO_NM = cursor.getString(cursor.getColumnIndex(columns.CEO_NM));
        bean.CO_NO = cursor.getString(cursor.getColumnIndex(columns.CO_NO));
        bean.ADDR = cursor.getString(cursor.getColumnIndex(columns.ADDR));
        bean.ROAD_ADDR1 = cursor.getString(cursor.getColumnIndex(columns.ROAD_ADDR1));
        bean.ROAD_ADDR2 = cursor.getString(cursor.getColumnIndex(columns.ROAD_ADDR2));
        bean.TEL_NO = cursor.getString(cursor.getColumnIndex(columns.TEL_NO));
        bean.VAN_NO = cursor.getString(cursor.getColumnIndex(columns.VAN_NO));
        bean.VAN_CARD_NO = cursor.getString(cursor.getColumnIndex(columns.VAN_CARD_NO));
      }
    } catch (SQLException e) {
      MLog.e("Error writing select - " + dbTable + e.toString());
    } finally {
      if (cursor != null) cursor.close();
    }
    return bean;
  }
  
  // count
  public long getCursorCount() {
    long count = DatabaseUtils.queryNumEntries(mSQLiteDB, dbTable);
    return count;
  }
  
  // Select All
  public Cursor getAllColumns() {
    String orderBy = null;
    return mSQLiteDB.query(dbTable, null, null, null, null, null, orderBy);
  }
}
