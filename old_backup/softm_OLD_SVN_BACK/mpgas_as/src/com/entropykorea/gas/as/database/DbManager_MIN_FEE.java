package com.entropykorea.gas.as.database;

import java.util.ArrayList;

import android.content.ContentValues;
import android.database.Cursor;
import android.database.DatabaseUtils;
import android.database.SQLException;
import android.database.sqlite.SQLiteDatabase;
import android.os.Handler;

import com.entropykorea.gas.as.AppContext;
import com.entropykorea.gas.as.bean.MinFee;
import com.entropykorea.gas.as.common.object.MLog;
import com.entropykorea.gas.as.constants.Constant;

public class DbManager_MIN_FEE {
  
  private static SQLiteDatabase mSQLiteDB;
  private String dbTable = DBTable_MIN_FEE.Columns._TABLENAME;
  private DBTable_MIN_FEE.Columns columns = new DBTable_MIN_FEE.Columns();
  
  private ArrayList<MinFee> totalList;
  private MinFee bean;
  private Handler handler;
  
  public DbManager_MIN_FEE() {
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
    // if (mDB != null) mDB.close();
  }
  
  // Delete Contact
  public boolean deleteColumn(int key) {
    boolean result = false;
    try {
      result = mSQLiteDB.delete(dbTable, columns.ITEM_CD + "=" + key, null) > 0;
      HandlerBoolean(result);
    } catch (SQLException e) {
      MLog.e(dbTable + "Error writing delete - " + dbTable + e.toString());
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
      MLog.e(dbTable + "Error writing delete - " + dbTable + e.toString());
      HandlerBoolean(result);
    } finally {
      if (mSQLiteDB != null && mSQLiteDB.inTransaction()) mSQLiteDB.endTransaction();
    }
    return result;
  }
  
  // Insert DB
  public long insertColumn(MinFee bean) {
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
      MLog.e(dbTable + "Error writing insert : " + e.toString());
      e.printStackTrace();
      HandlerBoolean(result);
    } finally {
      if (mSQLiteDB != null && mSQLiteDB.inTransaction()) mSQLiteDB.endTransaction();
    }
    return insert;
  }
  
  public void insert(String sql) {
    mSQLiteDB.rawQuery(sql, null);
  }
  
  // Update DB
  public boolean updateColumn(int alramId, MinFee bean) {
    boolean result = false;
    
    ContentValues values = null;
    values = getValues(bean);
    
    try {
      mSQLiteDB.beginTransaction();
      result = mSQLiteDB.update(dbTable, values, columns.ITEM_CD + "=" + alramId, null) > 0;
      mSQLiteDB.setTransactionSuccessful();
      HandlerBoolean(result);
    } catch (SQLException e) {
      MLog.e(dbTable + "Error writing update - " + dbTable + e.toString());
      HandlerBoolean(result);
    } finally {
      if (mSQLiteDB != null && mSQLiteDB.inTransaction()) mSQLiteDB.endTransaction();
    }
    return result;
  }
  
  private ContentValues getValues(MinFee bean) {
    ContentValues values = new ContentValues();
    values.put(columns.AREA_CD, bean.AREA_CD);
    values.put(columns.ITEM_CD, bean.ITEM_CD);
    values.put(columns.ITEM_NM, bean.ITEM_NM);
    values.put(columns.PROC_UNIT_PRICE, bean.PROC_UNIT_PRICE);
    
    return values;
  }
  
  /**
   * 데이터 리스트
   **/
  public ArrayList<MinFee> getTotalList(Cursor cursor) {
    if (cursor == null) return null;
    totalList = null;
    totalList = new ArrayList<MinFee>();
    try {
      while (cursor.moveToNext()) {
        bean = new MinFee();
        if (cursor.getInt(cursor.getColumnIndex(columns.PROC_UNIT_PRICE)) != 0) {
          bean.AREA_CD = cursor.getString(cursor.getColumnIndex(columns.AREA_CD));
          bean.ITEM_CD = cursor.getString(cursor.getColumnIndex(columns.ITEM_CD));
          bean.ITEM_NM = cursor.getString(cursor.getColumnIndex(columns.ITEM_NM));
          bean.PROC_UNIT_PRICE = cursor.getInt(cursor.getColumnIndex(columns.PROC_UNIT_PRICE));
          totalList.add(bean);
        }
      }
    } catch (SQLException e) {
      MLog.e(dbTable + "Error writing select - " + dbTable + e.toString());
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
    String orderBy = null;
    return mSQLiteDB.query(dbTable, null, null, null, null, null, orderBy);
  }
  
  // ITEM_CD 를 통해 컬럼 얻어 오기
  public Cursor getItemCdColumn(String key) {
    String where = columns.AREA_CD + "=" + key;
    Cursor c = mSQLiteDB.query(dbTable, null, where, null, null, null, null);
    return c;
  }
  
}
