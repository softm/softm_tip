package com.entropykorea.gas.as.common.object;

import java.io.ByteArrayOutputStream;
import java.io.DataOutputStream;
import java.io.IOException;

import android.graphics.Bitmap;
import android.media.Image;

public class BMPGenerator {

	/**
	 * @param image
	 * @return
	 * @throws IOException
	 * @see {@link #encodeBMP(int[], int, int)}
	 */
	public static byte[] encodeBMP(Bitmap image) throws IOException {
		int width = image.getWidth();
		int height = image.getHeight();
		int[] rgb = new int[height * width];
		image.getPixels(rgb, 0, width, 0, 0, width, height);
		return encodeBMP(rgb, width, height);
	}

	public static byte[] encodeBMP_1(Bitmap image) throws IOException {
		int width = image.getWidth();
		int height = image.getHeight();
		int[] rgb = new int[height * width];
		image.getPixels(rgb, 0, width, 0, 0, width, height);
		return encodeBMP_1(rgb, width, height);
	}

	/**
	 * A self-contained BMP generator, which takes a byte array (without any unusual
	 * offsets) extracted from an {@link Image}. The target platform is J2ME. You may
	 * wish to use the convenience method {@link #encodeBMP(Image)} instead of this.
	 * <p>
	 * A BMP file consists of 4 parts:-
	 * <ul>
	 * <li>header</li>
	 * <li>information header</li>
	 * <li>optional palette</li>
	 * <li>image data</li>
	 * </ul>
	 * At this time only 24 bit uncompressed BMPs with Windows V3 headers can be created.
	 * Future releases may become much more space-efficient, but will most likely be
	 * ditched in favour of a PNG generator.
	 * 
	 * @param rgb
	 * @param width
	 * @param height
	 * @return
	 * @throws IOException
	 * @see http://en.wikipedia.org/wiki/Windows_bitmap
	 */
	public static byte[] encodeBMP_1(int[] rgb, int width, int height)
	throws IOException {
		
		byte temp = (byte)0x00;
		int colorValue = 0;
		//int pad = (4 - (width % 4)) % 4;
		// the size of the BMP file in bytes
		int size = 0; //14 + 40 + height * (pad + width);
		size = 14 + 40 + 8 + ((((width*1)+31) & ~31) >> 3) * height;
		
		//int size = 14 + 40 + height * (pad + width * 3);
		ByteArrayOutputStream bytes = new ByteArrayOutputStream(size);
		DataOutputStream stream = new DataOutputStream(bytes);
		
		// HEADER
		// the magic number used to identify the BMP file: 0x42 0x4D
		stream.writeByte(0x42);
		stream.writeByte(0x4D);
		stream.writeInt(swapEndian(size));
		// reserved
		stream.writeInt(0);
		// the offset, i.e. starting address of the bitmap data
		stream.writeInt(swapEndian(14 + 40 + 8));
		// INFORMATION HEADER (Windows V3 header)
		// the size of this header (40 bytes)
		stream.writeInt(swapEndian(40));
		// the bitmap width in pixels (signed integer).
		stream.writeInt(swapEndian(width));
		// the bitmap height in pixels (signed integer).
		stream.writeInt(swapEndian(height));
		// the number of colour planes being used. Must be set to 1.
		stream.writeShort(swapEndian((short) 1));
		// the number of bits per pixel, which is the colour depth of the image.
		stream.writeShort(swapEndian((short) 1));
		// the compression method being used.
		stream.writeInt(0);

		// image size. The size of the raw bitmap data. 0 is valid for uncompressed.	        
        //stream.writeInt(0);
        stream.writeByte(0x50); // 1
        stream.writeByte(0x1F); // 1
        stream.writeByte(0x00); // 1
        stream.writeByte(0x00); // 1
        
        // the horizontal resolution of the image. (pixel per meter, signed integer)
        //stream.writeInt(0);
        stream.writeByte(0x13); // 1
        stream.writeByte(0x0B); // 1
        stream.writeByte(0x00); // 1
        stream.writeByte(0x00); // 1
        
        // the vertical resolution of the image. (pixel per meter, signed integer)
        //stream.writeInt(0);
        stream.writeByte(0x13); // 1
        stream.writeByte(0x0B); // 1
        stream.writeByte(0x00); // 1
        stream.writeByte(0x00); // 1

        // the number of important colours used, or 0 when every colour is important;
		// generally ignored.
		stream.writeInt(0);
		// PALETTE
		// none for 24 bit depth
		// IMAGE DATA
		// starting in the bottom left, working right and then up
		// a series of 3 bytes per pixel in the order B G R.

        // 3 byte 추가..
        stream.writeInt(0);
		stream.writeInt(0);
        stream.writeByte(0xff); // 1
        stream.writeByte(0xff); // 1
        stream.writeByte(0xff); // 1
        stream.writeByte(0x00); // 1
        
        int idx = 0;
		for (int j=height - 1;j >= 0; j--)
		{
			for (int i=0;i< width; i++)
			{
				colorValue = rgb[i + width * j];
				int t = i % 8;
				if (i == 0 || t == 0)
				{
					temp = (byte)0x00; // (byte)0x00 1바이트 완료시마다 초기화
				}

				if (colorValue < -1) // 각 픽셀에 값이 있을경우 1bit 씩 채워 넣는다
				{
					switch(t)
					{
					case 0:
						temp = (byte)(temp | 0x80); // 0x80
						break;
					case 1:
						temp = (byte)(temp | 0x40);
						break;
					case 2:
						temp = (byte)(temp | 0x20);
						break;
					case 3:
						temp = (byte)(temp | 0x10);
						break;
					case 4:
						temp = (byte)(temp | 0x08);
						break;
					case 5:
						temp = (byte)(temp | 0x04);
						break;
					case 6:
						temp = (byte)(temp | 0x02);
						break;
					case 7:
						temp = (byte)(temp | 0x01);
						break;
					}
				}

				if (t == 7)
				{
					temp = (byte)(temp ^ 0xff);
					stream.write(temp); // 8bit 모두 채우면 출력버퍼로 보냄;
				}

				if (i + 1 == width)
				{
					if ( t != 7 )
					{
						stream.write(temp ^ 0xff); // 8bit 모두 못채우고 한줄이 끝날경우 출력버퍼로
					}
					if (width / 32 != 0) // 1bit bmp 는 4 byte(32bit) 단위로 계산 모자라면 00 으로 채움
					{
						if (width % 32 > 24) {
							// 24 이상이면 이미 위 루틴에서 8비트 채우고 출력 버퍼로 보냈을테니 이 부분은 00 안채워도 됨!
						}
						else if (width % 32 > 16) {
							stream.write((byte)0x00);
						}
						else if (width % 32 > 8) {
							stream.writeShort((short)0x0000); //out.putShort();
						}
						else {
							stream.writeShort((short)0x0000); //out.putShort();
							stream.write((byte)0x00);
						}
					}
				}
				//i++;
			}
		}		
	
		byte[] out = bytes.toByteArray();
		bytes.close();
		// quick consistency check
		if (out.length != size) {
			String a = "bad math";
		}
		return out;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public static byte[] encodeBMP(int[] rgb, int width, int height)
	throws IOException {
		int pad = (4 - (width % 4)) % 4;
		// the size of the BMP file in bytes
		int size = 14 + 40 + height * (pad + width * 3);
		ByteArrayOutputStream bytes = new ByteArrayOutputStream(size);
		DataOutputStream stream = new DataOutputStream(bytes);
		// HEADER
		// the magic number used to identify the BMP file: 0x42 0x4D
		stream.writeByte(0x42);
		stream.writeByte(0x4D);
		stream.writeInt(swapEndian(size));
		// reserved
		stream.writeInt(0);
		// the offset, i.e. starting address of the bitmap data
		stream.writeInt(swapEndian(14 + 40));
		// INFORMATION HEADER (Windows V3 header)
		// the size of this header (40 bytes)
		stream.writeInt(swapEndian(40));
		// the bitmap width in pixels (signed integer).
		stream.writeInt(swapEndian(width));
		// the bitmap height in pixels (signed integer).
		stream.writeInt(swapEndian(height));
		// the number of colour planes being used. Must be set to 1.
		stream.writeShort(swapEndian((short) 1));
		// the number of bits per pixel, which is the colour depth of the image.
		stream.writeShort(swapEndian((short) 24));
		// the compression method being used.
		stream.writeInt(0);
		// image size. The size of the raw bitmap data. 0 is valid for uncompressed.
		stream.writeInt(0);
		// the horizontal resolution of the image. (pixel per meter, signed integer)
		stream.writeInt(0);
		// the vertical resolution of the image. (pixel per meter, signed integer)
		stream.writeInt(0);
		// the number of colours in the colour palette, or 0 to default to 2n.
		stream.writeInt(0);
		// the number of important colours used, or 0 when every colour is important;
		// generally ignored.
		stream.writeInt(0);
		// PALETTE
		// none for 24 bit depth
		// IMAGE DATA
		// starting in the bottom left, working right and then up
		// a series of 3 bytes per pixel in the order B G R.
		for (int j = height - 1; j >= 0; j--) {
			for (int i = 0; i < width; i++) {
				int val = rgb[i + width * j];
				stream.writeByte(val & 0x000000FF);
				stream.writeByte((val >>> 8 ) & 0x000000FF);
				stream.writeByte((val >>> 16) & 0x000000FF);
			}
			// number of bytes in each row must be padded to multiple of 4
			for (int i = 0; i < pad; i++) {
				stream.writeByte(0);
			}
		}
		byte[] out = bytes.toByteArray();
		bytes.close();
		// quick consistency check
		if (out.length != size)
			throw new RuntimeException("bad math");
		return out;
	}

	/**
	 * Swap the Endian-ness of a 32 bit integer.
	 * 
	 * @param value
	 * @return
	 */
	private static int swapEndian(int value) {
		int b1 = value & 0xff;
		int b2 = (value >> 8 ) & 0xff;
		int b3 = (value >> 16) & 0xff;
		int b4 = (value >> 24) & 0xff;

		return b1 << 24 | b2 << 16 | b3 << 8 | b4 << 0;
	}

	/**
	 * Swap the Endian-ness of a 16 bit integer.
	 * 
	 * @param value
	 * @return
	 */
	private static short swapEndian(short value) {
		int b1 = value & 0xff;
		int b2 = (value >> 8 ) & 0xff;

		return (short) (b1 << 8 | b2 << 0);
	}
}
