package com.entropykorea.ewire;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.util.zip.ZipEntry;
import java.util.zip.ZipInputStream;
import java.util.zip.ZipOutputStream;


public class Zip {
	//private String filename = "";
	private static final int DATA_BLOCK_SIZE = 4096; 
	
	public Zip() {
		
	}
		
	public static boolean unZip( String zipFile, String outputFolder ) {

		byte[] buffer = new byte[DATA_BLOCK_SIZE];

		try{

			//create output directory is not exists
			File folder = new File(outputFolder);
			if(!folder.exists()){
				folder.mkdir();
			}

			//get the zip file content
			ZipInputStream zis = new ZipInputStream(new FileInputStream(zipFile));
			//get the zipped file list entry
			ZipEntry ze = zis.getNextEntry();

			while(ze!=null){

				String fileName = ze.getName();
				File newFile = new File(outputFolder + File.separator + fileName.toLowerCase() );

				//System.out.println("file unzip : "+ newFile.getAbsoluteFile());

				//create all non exists folders
				//else you will hit FileNotFoundException for compressed folder
				new File(newFile.getParent()).mkdirs();

				FileOutputStream fos = new FileOutputStream(newFile);             

				int len;
				while ((len = zis.read(buffer)) > 0) {
					fos.write(buffer, 0, len);
				}

				fos.close();   
				ze = zis.getNextEntry();
			}

			zis.closeEntry();
			zis.close();

			//System.out.println("Done");

		}catch(IOException ex){
			ex.printStackTrace();
			return false;
		}
		return true;
	}
	
	private static boolean addZip( ZipOutputStream zos, String sourceFolder, String file ) {

		boolean rtn = false;
		byte[] buffer = new byte[DATA_BLOCK_SIZE];

		try {
			System.out.println("File Added : " + file);
			ZipEntry ze= new ZipEntry( file );
			
			zos.putNextEntry(ze);

			FileInputStream in = new FileInputStream( sourceFolder + File.separator + file );

			int len;
			while ((len = in.read(buffer)) > 0) {
				zos.write(buffer, 0, len);
			}

			in.close();
			rtn = true;
		} catch (FileNotFoundException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		}
		
		return rtn;
	}
	
	private static boolean addZip( ZipOutputStream zos, String file ) {

		boolean rtn = false;
		byte[] buffer = new byte[DATA_BLOCK_SIZE];
		
		//eWireLog.d("EWIRE", filepath + File.separator + filename );
		try {
			File f = new File( file );
			String filepath = f.getParent();
			String filename = f.getName();

			eWireLog.d("File Added : " + file );
			ZipEntry ze= new ZipEntry( filename );
			
			zos.putNextEntry(ze);

			FileInputStream in = new FileInputStream( file );

			int len;
			while ((len = in.read(buffer)) > 0) {
				zos.write(buffer, 0, len);
			}

			in.close();
			rtn = true;
		} catch (FileNotFoundException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		}
		
		return rtn;
	}

	public static boolean makeZip( String zipFile, String sourceFolder, String[] files, String[] files2 ) {


		try{

			FileOutputStream fos = new FileOutputStream(zipFile);
			ZipOutputStream zos = new ZipOutputStream(fos);

			//System.out.println("Output to Zip : " + filename);

			for(String file : files){
				if( !addZip( zos, sourceFolder, file ) ) {
					zos.closeEntry();
					//remember close it
					zos.close();
					return false;
				}
					
			}
			
			// additional files
			if( files2 != null ) {
				for(String file : files2){
					if( !addZip( zos, file ) ) {
						zos.closeEntry();
						//remember close it
						zos.close();
						return false;
					}
				}
			}

			zos.closeEntry();
			//remember close it
			zos.close();

			//System.out.println("Done");
		}catch(IOException ex){
			ex.printStackTrace();
			return false;
		}		

		return true;
	}

}
