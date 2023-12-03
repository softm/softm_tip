package com.entropykorea.gas.as.database;

import java.util.ArrayList;

import android.content.ContentValues;
import android.database.Cursor;
import android.database.DatabaseUtils;
import android.database.SQLException;
import android.database.sqlite.SQLiteDatabase;
import android.os.Handler;
import android.os.Message;

import com.entropykorea.gas.as.AppContext;
import com.entropykorea.gas.as.bean.Min;
import com.entropykorea.gas.as.bean.MinFeePay;
import com.entropykorea.gas.as.common.object.MLog;
import com.entropykorea.gas.as.constants.Constant;

public class DbManager_MIN_FEE_PAY {
  
  private static SQLiteDatabase mSQLiteDB;
  private String dbTable = DBTable_MIN_FEE_PAY.Columns._TABLENAME;
  private DBTable_MIN_FEE_PAY.Columns columns = new DBTable_MIN_FEE_PAY.Columns();
  
  private ArrayList<MinFeePay> totalList;
  private MinFeePay bean;
  private Handler handler;
  
  public DbManager_MIN_FEE_PAY() {
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
  
  private void HandlerLong(Long result) {
    if (handler == null) return;
    if (result == -1) {
      handler.sendMessage(Message.obtain(handler, Constant.RESULT_FAIL, result));
    } else {
      handler.sendMessage(Message.obtain(handler, Constant.RESULT_SUCCESS, result));
    }
  }
  
  public synchronized void close() {
    if (mSQLiteDB != null) mSQLiteDB.close();
  }
  
  // Delete Contact
  public boolean deleteColumn(MinFeePay bean) {
    boolean result = false;
    String where = columns.REQUIRE_IDX + "=" + bean.REQUIRE_IDX + " AND " + columns.ITEM_CD + " = '" + bean.ITEM_CD+"'";
    try {
      result = mSQLiteDB.delete(dbTable, where, null) > 0;
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
      // HandlerBoolean(result);
    } catch (SQLException e) {
      MLog.e("Error writing delete - " + dbTable + e.toString());
      // HandlerBoolean(result);
    } finally {
      if (mSQLiteDB != null && mSQLiteDB.inTransaction()) mSQLiteDB.endTransaction();
    }
    return result;
  }
  
  // Insert DB
  public long insertColumn(MinFeePay bean) {
    long insert = 0;
    
    ContentValues values = null;
    values = getValues(bean);
    try {
      mSQLiteDB.beginTransaction();
      insert = mSQLiteDB.insert(dbTable, null, values);
      mSQLiteDB.setTransactionSuccessful();
      HandlerLong(insert);
    } catch (SQLException e) {
      MLog.e("Error writing insert - " + dbTable + e.toString());
      e.printStackTrace();
      HandlerLong(insert);
    } finally {
      if (mSQLiteDB != null && mSQLiteDB.inTransaction()) mSQLiteDB.endTransaction();
    }
    return insert;
  }
  
  // Update DB
  public boolean updateColumn(MinFeePay bean) {
    boolean result = false;
    
    ContentValues values = null;
    values = getValues(bean);
    String where = columns.REQUIRE_IDX + "=" + bean.REQUIRE_IDX + " AND " + columns.ITEM_CD + " = '" + bean.ITEM_CD+"'";
    try {
      mSQLiteDB.beginTransaction();
      result = mSQLiteDB.update(dbTable, values, where, null) > 0;
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
  
  private ContentValues getValues(MinFeePay bean) {
    ContentValues values = new ContentValues();
    values.put(columns.REQUIRE_IDX, bean.REQUIRE_IDX);
    values.put(columns.AREA_CD, bean.AREA_CD);
    values.put(columns.ITEM_CD, bean.ITEM_CD);
    values.put(columns.PROC_UNIT_PRICE, bean.PROC_UNIT_PRICE);
    values.put(columns.PROC_QTY, bean.PROC_QTY);
    
    return values;
  }
  
  /**
   * 데이터 리스트
   **/
  public ArrayList<MinFeePay> getTotalList(Cursor cursor) {
    if (cursor == null) return null;
    totalList = null;
    totalList = new ArrayList<MinFeePay>();
    try {
      while (cursor.moveToNext()) {
        bean = new MinFeePay();
        bean.REQUIRE_IDX = cursor.getString(cursor.getColumnIndex(columns.REQUIRE_IDX));
        bean.AREA_CD = cursor.getString(cursor.getColumnIndex(columns.AREA_CD));
        bean.ITEM_CD = cursor.getString(cursor.getColumnIndex(columns.ITEM_CD));
        bean.PROC_UNIT_PRICE = cursor.getString(cursor.getColumnIndex(columns.PROC_UNIT_PRICE));
        bean.PROC_QTY = cursor.getInt(cursor.getColumnIndex(columns.PROC_QTY));
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
    String orderBy = columns.REQUIRE_IDX;
    return mSQLiteDB.query(dbTable, null, null, null, null, null, orderBy);
  }
  
  // REQUIRE_IDX 를 통해 컬럼 얻어 오기
  public Cursor getColumn(Min min) {
    String where = columns.REQUIRE_IDX + "=" + min.REQUIRE_IDX + " AND " + columns.AREA_CD + "=" + min.AREA_CD;
    Cursor c = mSQLiteDB.query(dbTable, null, where, null, null, null, null);
    return c;
  }
  
  // REQUIRE_IDX 를 통해 컬럼 얻어 오기
  public Cursor getColumn(int key) {
    String where = columns.REQUIRE_IDX + "=" + key;
    Cursor c = mSQLiteDB.query(dbTable, null, where, null, null, null, null);
    return c;
  }
  
  // 이름 검색 하기 (rawQuery)
  public Cursor getMatchName(String name) {
    Cursor c = mSQLiteDB.rawQuery("select * from " + dbTable + " where AREA_CD =" + "'" + name + "'", null);
    return c;
  }
  
}
