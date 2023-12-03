package com.entropykorea.ewire.util;


public class Vers {
	public String mVersion;
	
	public int mMajor = 0;
	public int mMinor = 0;
	public int mBuild = 0;
	public int mRevision = 0;
	
	public void init( int major, int minor, int build, int revision )
	{
		mMajor = major;
		mMinor = minor;
		mBuild = build;
		mRevision = revision;
	}
	
	public Vers( String version )
	{
		mVersion = version;
		parse( mVersion );
	}
	
	public Vers( int major )
	{
		init( major, 0, 0, 0 );
	}

	public Vers( int major, int minor )
	{
		init( major, minor, 0, 0 );
	}

	public Vers( int major, int minor, int build )
	{
		init( major, minor, build, 0 );
	}

	public Vers( int major, int minor, int build, int revision )
	{
		init( major, minor, build, revision );
		mMajor = major;
		mMinor = minor;
		mBuild = build;
		mRevision = revision;
	}
	
	public void parse( String version )
	{
		StringSplit ss = new StringSplit( version, "\\." );
		
		mMajor = IntegerEx.parseInt( ss.get(0) );
		mMinor = IntegerEx.parseInt( ss.get(1) );
		mBuild = IntegerEx.parseInt( ss.get(2) );
		mRevision = IntegerEx.parseInt( ss.get(3) );
	}
	
	public int compare( Vers ver )
	{
		int rtn = 0;
		
		if( mMajor > ver.mMajor )
			return 1;
		else if( mMajor < ver.mMajor )
			return -1;
		
		if( mMinor > ver.mMinor )
			return 1;
		else if( mMinor < ver.mMinor )
			return -1;
		
		if( mBuild > ver.mBuild )
			return 1;
		else if( mBuild < ver.mBuild )
			return -1;
		
		if( mRevision > ver.mRevision )
			return 1;
		else if( mRevision < ver.mRevision )
			return -1;
		
		return rtn;
	}
	
	
}
