package com.entropykorea.gas.as.database;

import java.util.ArrayList;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.DatabaseUtils;
import android.database.SQLException;
import android.database.sqlite.SQLiteDatabase;
import android.os.Handler;

import com.entropykorea.gas.as.AppContext;
import com.entropykorea.gas.as.SharedApplication;
import com.entropykorea.gas.as.bean.AreaCenter;
import com.entropykorea.gas.as.common.object.MLog;
import com.entropykorea.gas.as.constants.Constant;

public class DbManager_AREA_CENTER {
  
  private static SQLiteDatabase mSQLiteDB;
  private String dbTable = DBTable_AREA_CENTER.Columns._TABLENAME;
  private DBTable_AREA_CENTER.Columns columns = new DBTable_AREA_CENTER.Columns();
  
  private ArrayList<AreaCenter> totalList;
  private AreaCenter bean;
  private Handler handler;
  
  public DbManager_AREA_CENTER(Context context) {
    mSQLiteDB = AppContext.getSQLiteDatabase();
  }
  
  public void DbHandler(Handler handler) {
    this.handler = handler;
  }
  
  private void HandlerBoolean(boolean result) {
    if(handler == null) return;
    if (result) {
      handler.sendEmptyMessage(Constant.RESULT_SUCCESS);
    } else {
      handler.sendEmptyMessage(Constant.RESULT_FAIL);
    }
  }
  
  public synchronized void close() {
    if (mSQLiteDB != null) mSQLiteDB.close();
  }
  
  // Insert DB
  public long insertColumn(AreaCenter bean) {
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
    }
    return insert;
  }
  
  // Update DB
  public boolean updateColumn(int alramId, AreaCenter bean) {
    boolean result = false;
    
    ContentValues values = null;
    values = getValues(bean);
    
    try {
      mSQLiteDB.beginTransaction();
      result = mSQLiteDB.update(dbTable, values, columns.AREA_CENTER_CD + "=" + alramId, null) > 0;
      mSQLiteDB.setTransactionSuccessful();
      HandlerBoolean(result);
    } catch (SQLException e) {
      MLog.e("Error writing update - " + dbTable + e.toString());
      HandlerBoolean(result);
    } finally {
      if (mSQLiteDB != null && mSQLiteDB.inTransaction()) mSQLiteDB.endTransaction();
    }
    return result;
  }
  
  // Delete Contact
  public boolean deleteColumn(int key) {
    boolean result = false;
    try {
      result = mSQLiteDB.delete(dbTable, columns.AREA_CENTER_CD + "=" + key, null) > 0;
      HandlerBoolean(result);
    } catch (SQLException e) {
      MLog.e("Error writing delete - " + dbTable + e.toString());
      HandlerBoolean(result);
    } finally {
      if (mSQLiteDB != null && mSQLiteDB.inTransaction()) mSQLiteDB.endTransaction();
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
    }
    return result;
  }
  
  private ContentValues getValues(AreaCenter bean) {
    ContentValues values = new ContentValues();
    values.put(columns.AREA_CENTER_CD, bean.AREA_CENTER_CD);
    values.put(columns.AREA_CENTER_NM, bean.AREA_CENTER_NM);
    values.put(columns.TEL_NO, bean.TEL_NO);
    
    return values;
  }
  
  /**
   * 데이터 리스트
   **/
  public ArrayList<AreaCenter> getTotalList() {
    
    Cursor cursor = getAllColumns();
    totalList = new ArrayList<AreaCenter>();
    try {
      while (cursor.moveToNext()) {
        bean = new AreaCenter();
        bean.AREA_CENTER_CD = cursor.getString(cursor.getColumnIndex(columns.AREA_CENTER_CD));
        bean.AREA_CENTER_NM = cursor.getString(cursor.getColumnIndex(columns.AREA_CENTER_NM));
        bean.TEL_NO = cursor.getString(cursor.getColumnIndex(columns.TEL_NO));
        totalList.add(bean);
      }
    } catch (SQLException e) {
      MLog.e("Error writing select - " + dbTable + e.toString());
    } finally {
      if (cursor != null) cursor.close();
    }
    return totalList;
  }
  
  // count
  public long getCursorCount() {
    long count = DatabaseUtils.queryNumEntries(mSQLiteDB, dbTable);
    return count;
  }
  
  // Select All
  public Cursor getAllColumns() {
    // String orderBy = columns.Min_TIME_STAMP + " DESC";
    String orderBy = columns.AREA_CENTER_CD + " DESC";
    return mSQLiteDB.query(dbTable, null, null, null, null, null, orderBy);
  }
  
  // TYPE_CD 를 통해 컬럼 얻어 오기
  public Cursor getColumn(long key) {
    Cursor c = mSQLiteDB.query(dbTable, null, columns.AREA_CENTER_CD + "=" + key, null, null, null, null);
    if (c != null && c.getCount() != 0) c.moveToFirst();
    return c;
  }
  
  // 이름 검색 하기 (rawQuery)
  public Cursor getMatchName(String name) {
    Cursor c = mSQLiteDB.rawQuery("select * from " + dbTable + " where AREA_CENTER_NM=" + "'" + name + "'", null);
    return c;
  }
  
}
