package kr.co.gscaltex.gsnpoint.util;

import java.io.BufferedInputStream;

import java.io.BufferedOutputStream;

import java.io.File;

import java.io.FileInputStream;

import java.io.FileOutputStream;

public class FileSeparator {

	public static void main(String[] args) {

		// 아래의 두 상수는 분할할 파일의 경로와, 몇 바이트로 분할할 것인지를 정의합니다.
		
		final String FILE_PATH = "C:\\db\\npoint.db3";
		int idx = FILE_PATH.lastIndexOf ( "." ); 
		final String SEP_FILE_PATH = FILE_PATH.substring(0,idx);
		final long BYTE_OF_UNIT = 1048576;
		System.out.println("SEP_FILE_PATH : " + SEP_FILE_PATH);
		File input = new File(FILE_PATH);

		FileInputStream fis = null;

		BufferedInputStream bis = null;

		FileOutputStream fos = null;

		BufferedOutputStream bos = null;

		try {

			fis = new FileInputStream(input);

			bis = new BufferedInputStream(fis);

			byte[] buf = new byte[4096];

			int l = 0;

			int acc = 0;

			int count = 1;

			while ((l = bis.read(buf)) > 0) {
				
				if (acc % BYTE_OF_UNIT == 0) {
					System.out.println("file : " + SEP_FILE_PATH + "." + String.format("%03d", count) );
					File output = new File(SEP_FILE_PATH + "." + String.format("%03d", count++));

					if (fos != null) {

						bos.close();

						fos.close();

					}

					fos = new FileOutputStream(output);
					bos = new BufferedOutputStream(fos);

				}

				bos.write(buf, 0, l);

				acc += l;

			}

		} catch (Exception e) {

			e.printStackTrace();

		} finally {

			if (bos != null)
				try {
					bos.close();
				} catch (Exception e) {
				}

			if (fos != null)
				try {
					fos.close();
				} catch (Exception e) {
				}

			if (bis != null)
				try {
					bis.close();
				} catch (Exception e) {
				}

			if (fis != null)
				try {
					fis.close();
				} catch (Exception e) {
				}

		}

	}

}