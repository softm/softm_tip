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
import com.entropykorea.gas.as.bean.MinUnpaidPrice;
import com.entropykorea.gas.as.common.object.MLog;
import com.entropykorea.gas.as.constants.Constant;

public class DbManager_MIN_UNPAID_PRICE {
  
  private static SQLiteDatabase mSQLiteDB;
  private String dbTable = DBTable_MIN_UNPAID_PRICE.Columns._TABLENAME;
  private DBTable_MIN_UNPAID_PRICE.Columns columns = new DBTable_MIN_UNPAID_PRICE.Columns();
  
  private ArrayList<MinUnpaidPrice> totalList;
  private MinUnpaidPrice bean;
  private Context mContext;
  private Handler handler;
  
  public DbManager_MIN_UNPAID_PRICE() {
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
  public boolean deleteColumn(int key) {
    boolean result = false;
    try {
      result = mSQLiteDB.delete(dbTable, columns.REQUIRE_IDX + "=" + key, null) > 0;
      HandlerBoolean(result);
    } catch (SQLException e) {
      MLog.e(dbTable + "Error writing delete : " + e.toString());
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
      MLog.e(dbTable + "Error writing delete DbManager_MIN : " + e.toString());
      HandlerBoolean(result);
    } finally {
      if (mSQLiteDB != null && mSQLiteDB.inTransaction()) mSQLiteDB.endTransaction();
    }
    return result;
  }
  
  // Insert DB
  public long insertColumn(MinUnpaidPrice bean) {
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
  
  // Update DB
  public boolean updateColumn(int alramId, MinUnpaidPrice bean) {
    boolean result = false;
    
    ContentValues values = null;
    values = getValues(bean);
    
    try {
      mSQLiteDB.beginTransaction();
      result = mSQLiteDB.update(dbTable, values, columns.REQUIRE_IDX + "=" + alramId, null) > 0;
      mSQLiteDB.setTransactionSuccessful();
      HandlerBoolean(result);
    } catch (SQLException e) {
      MLog.e(dbTable + "Error writing update DbManager_MIN : " + e.toString());
      HandlerBoolean(result);
    } finally {
      if (mSQLiteDB != null && mSQLiteDB.inTransaction()) mSQLiteDB.endTransaction();
    }
    return result;
  }
  
  private ContentValues getValues(MinUnpaidPrice bean) {
    ContentValues values = new ContentValues();
    values.put(columns.REQUIRE_IDX, bean.REQUIRE_IDX);
    values.put(columns.CHE_MONTH, bean.CHE_MONTH);
    values.put(columns.CHE_PRICE, bean.CHE_PRICE);
    
    return values;
  }
  
  /**
   * 데이터 리스트
   **/
  public ArrayList<MinUnpaidPrice> getTotalList(Cursor cursor) {
    if (cursor == null) return null;
    totalList = new ArrayList<MinUnpaidPrice>();
    try {
      while (cursor.moveToNext()) {
        bean = new MinUnpaidPrice();
        bean.REQUIRE_IDX = cursor.getInt(cursor.getColumnIndex(columns.REQUIRE_IDX));
        bean.CHE_MONTH = cursor.getString(cursor.getColumnIndex(columns.CHE_MONTH));
        bean.CHE_PRICE = cursor.getString(cursor.getColumnIndex(columns.CHE_PRICE));
        totalList.add(bean);
      }
    } catch (SQLException e) {
      MLog.e(dbTable + "Error writing select : " + e.toString());
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
    // String orderBy = DBTable_MIN.Columns.Min_TIME_STAMP + " DESC";
    String orderBy = null;
    return mSQLiteDB.query(dbTable, null, null, null, null, null, orderBy);
  }
  
  // REQUIRE_IDX를 통해 컬럼 얻어 오기
  public Cursor getColumn(int key) {
    String where = columns.REQUIRE_IDX + " = " + key;
    Cursor c = null;
    MLog.e("sql : " + where);
    try {
      c = mSQLiteDB.query(dbTable, null, where, null, null, null, null);
    } catch (Exception e) {
      MLog.e(e.toString());
    }
    return c;
  }
  
}
