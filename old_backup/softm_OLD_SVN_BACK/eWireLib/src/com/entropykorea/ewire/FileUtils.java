package com.entropykorea.ewire;

import java.io.File;
import java.io.FilenameFilter;

public class FileUtils {
	
	public static String[] getFilesRegularExpression( String path, final String regularExpression ) {
		
		File file = new File( path );
		String[] list = file.list( new FilenameFilter() {
            @Override
            public boolean accept(File dir, String name) 
            {
                return name.matches(regularExpression);
            }
		});
		
		return list;
	}

	public static String[] getFilesRegularExpressionWithDirectory( String path, final String regularExpression ) {
		
		String[] resultlist;
		String[] list = getFilesRegularExpression( path, regularExpression );
		
		resultlist = list;
		for( int i=0 ; i<list.length ; i++ ) {
			resultlist[i] = path + File.separator + list[i];
		}
		
		return resultlist;
	}

	public static String[] getFiles( String path, final String ext ) {
		
		File file = new File( path );
		String[] list = file.list( new FilenameFilter() {
            @Override
            public boolean accept(File dir, String name) 
            {
                return name.endsWith( ext );
            }
		});
		
		return list;
	}

	public static String[] getFilesWithDirectory( String path, final String ext ) {
	
		String[] resultlist;
		String[] list = getFiles( path, ext );
		
		resultlist = list;
		for( int i=0 ; i<list.length ; i++ ) {
			resultlist[i] = path + File.separator + list[i];
		}
		
		return resultlist;
	}

	public static boolean deleteFiles( String path, final String ext ) {
		
		boolean rtn = true;
		String[] fileNames = getFiles( path, ext );
		
		if( fileNames == null )
			return false;
		
		for( String fileName : fileNames ) {
			//eWireLog.d("EWIRE", "" + i +":"+ path+"/"+list[i]);
			try {
				File f = new File( path + "/" + fileName );
				f.delete();
			} catch (Exception e) {
				e.printStackTrace();
				rtn = false;
			}
		}
		
		return rtn;		
	}

	public static boolean deleteFile( String fileName ) {
		
		boolean rtn = true;
		
		if( fileName == null )
			return false;
		
		try {
			File f = new File( fileName );
			f.delete();
		} catch (Exception e) {
			e.printStackTrace();
			rtn = false;
		}
		
		return rtn;		
	}
	
}
