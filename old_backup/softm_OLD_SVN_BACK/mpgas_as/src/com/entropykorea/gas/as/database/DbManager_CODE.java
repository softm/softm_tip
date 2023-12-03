package com.entropykorea.gas.as.database;

import java.util.ArrayList;

import android.content.ContentValues;
import android.database.Cursor;
import android.database.DatabaseUtils;
import android.database.SQLException;
import android.database.sqlite.SQLiteDatabase;
import android.os.Handler;

import com.entropykorea.gas.as.AppContext;
import com.entropykorea.gas.as.bean.Code;
import com.entropykorea.gas.as.common.object.MLog;
import com.entropykorea.gas.as.constants.Constant;

public class DbManager_CODE {
  
  private static SQLiteDatabase mSQLiteDB;
  private String dbTable = DBTable_CODE.Columns._TABLENAME;
  private DBTable_CODE.Columns columns = new DBTable_CODE.Columns();
  
  private ArrayList<Code> totalList;
  private Code bean;
  private Handler handler;
  
  public DbManager_CODE() {
    mSQLiteDB = AppContext.getSQLiteDatabase();
    // open();
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
  
  // Insert DB
  public long insertColumn(Code bean) {
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
  public boolean updateColumn(int cd, Code bean) {
    boolean result = false;
    
    ContentValues values = null;
    values = getValues(bean);
    
    try {
      mSQLiteDB.beginTransaction();
      result = mSQLiteDB.update(dbTable, values, columns.CD + "=" + cd, null) > 0;
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
      result = mSQLiteDB.delete(dbTable, columns.CD + "=" + key, null) > 0;
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
  
  private ContentValues getValues(Code bean) {
    ContentValues values = new ContentValues();
    values.put(columns.TYPE_CD, bean.TYPE_CD);
    values.put(columns.CD, bean.CD);
    values.put(columns.CD_NM, bean.CD_NM);
    values.put(columns.MGT_CHAR1, bean.MGT_CHAR1);
    values.put(columns.MGT_CHAR2, bean.MGT_CHAR2);
    values.put(columns.MGT_CHAR3, bean.MGT_CHAR3);
    values.put(columns.MGT_CHAR4, bean.MGT_CHAR4);
    values.put(columns.MGT_CHAR5, bean.MGT_CHAR5);
    values.put(columns.MGT_CHAR6, bean.MGT_CHAR6);
    values.put(columns.MGT_NUM1, bean.MGT_NUM1);
    values.put(columns.MGT_NUM2, bean.MGT_NUM2);
    values.put(columns.ORD, bean.ORD);
    values.put(columns.REMARK, bean.REMARK);
    
    return values;
  }
  
  /**
   * 데이터 리스트
   **/
  public ArrayList<Code> getTotalList(Cursor cursor) {
    
    if (cursor == null) return null;
    totalList = null;
    totalList = new ArrayList<Code>();
    try {
      while (cursor.moveToNext()) {
        bean = new Code();
        bean.TYPE_CD = cursor.getString(cursor.getColumnIndex(columns.TYPE_CD));
        bean.CD = cursor.getString(cursor.getColumnIndex(columns.CD));
        bean.CD_NM = cursor.getString(cursor.getColumnIndex(columns.CD_NM));
        bean.MGT_CHAR1 = cursor.getString(cursor.getColumnIndex(columns.MGT_CHAR1));
        bean.MGT_CHAR2 = cursor.getString(cursor.getColumnIndex(columns.MGT_CHAR2));
        bean.MGT_CHAR3 = cursor.getString(cursor.getColumnIndex(columns.MGT_CHAR3));
        bean.MGT_CHAR4 = cursor.getString(cursor.getColumnIndex(columns.MGT_CHAR4));
        bean.MGT_CHAR5 = cursor.getString(cursor.getColumnIndex(columns.MGT_CHAR5));
        bean.MGT_CHAR6 = cursor.getString(cursor.getColumnIndex(columns.MGT_CHAR6));
        bean.MGT_NUM1 = cursor.getString(cursor.getColumnIndex(columns.MGT_NUM1));
        bean.MGT_NUM2 = cursor.getString(cursor.getColumnIndex(columns.MGT_NUM2));
        bean.ORD = cursor.getString(cursor.getColumnIndex(columns.ORD));
        bean.REMARK = cursor.getString(cursor.getColumnIndex(columns.REMARK));
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
    String orderBy = columns.TYPE_CD + " DESC";
    return mSQLiteDB.query(dbTable, null, null, null, null, null, orderBy);
  }
  
  // TYPE_CD 를 통해 컬럼 얻어 오기
  public Cursor getColumn(String key) {
    Cursor c = mSQLiteDB.query(dbTable, null, columns.TYPE_CD + "= '" + key + "'", null, null, null, null);
    return c;
  }
  
  
  public Cursor getCode(String type, String name) {
    String where = "TYPE_CD like '%" + type + "%' AND CD_NM like '%" + name + "%'";
    Cursor c = mSQLiteDB.query(dbTable, null, where, null, null, null, null);
    return c;
  }
  
}
