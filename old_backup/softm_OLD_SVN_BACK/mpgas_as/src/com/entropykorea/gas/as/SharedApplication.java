package com.entropykorea.gas.as;

import android.content.Context;
import android.content.res.Configuration;
import android.database.sqlite.SQLiteDatabase;

import com.entropykorea.ewire.database.SqliteManager;
import com.entropykorea.gas.as.bean.User;
import com.entropykorea.gas.as.common.util.Util;
import com.entropykorea.gas.lib.DefaultApplication;

public class SharedApplication extends DefaultApplication {
  
  public static SharedApplication mInstance = null;
  public static SQLiteDatabase mSqliteDatabase = null;
  public static SqliteManager mSqliteManager = null;
  private static Context context;
  public static User user = new User();
  
  @Override
  public void onCreate() {
    super.onCreate();
    mInstance = this;
    Util.createDir();
    
    context = getBaseContext();
  }
  
  @Override
  public void onTerminate() {
    mSqliteManager.close();
    mSqliteDatabase = null;
    super.onTerminate();
  }
  
  @Override
  public void onConfigurationChanged(Configuration newConfig) {
    // Log.i(TAG, "Application:ConfigurationChanged");
    super.onConfigurationChanged(newConfig);
  }
  
  @Override
  protected void onInitDataBase() {
    mSqliteDatabase = getDatabase();
    int ver = Integer.valueOf(getString(R.string.db_user_version));
    
    if (mSqliteManager == null) {
      mSqliteManager = new SqliteManager(getBaseContext(), mSqliteDatabase);
    }
    
    if (mSqliteManager.getVersion() == 0) {
      mSqliteManager.importSql(R.raw.createtable);
    }
    
    // 데이타 버전 1 의 경우 데이타 삭제 ( 버전 2 로 많은 변화 )
    // WApplication 에서 데이타 삭제
    else if (mSqliteManager.getVersion() < ver) {
      mSqliteManager.importSql(R.raw.droptable);
      mSqliteManager.importSql(R.raw.createtable);
    }
  }
  
}
