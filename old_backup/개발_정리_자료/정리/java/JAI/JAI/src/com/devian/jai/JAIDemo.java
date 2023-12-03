package com.devian.jai;

import java.awt.Frame;
import java.awt.image.RenderedImage;
import java.awt.image.renderable.ParameterBlock;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.OutputStream;

import javax.media.jai.Interpolation;
import javax.media.jai.JAI;
import javax.media.jai.PlanarImage;
import javax.media.jai.RenderedOp;
import javax.media.jai.operator.CompositeDescriptor;
import javax.media.jai.operator.ConstantDescriptor;
import javax.media.jai.widget.ScrollingImagePanel;

import com.sun.media.jai.codec.BMPEncodeParam;
import com.sun.media.jai.codec.FileSeekableStream;
import com.sun.media.jai.codec.ImageCodec;
import com.sun.media.jai.codec.ImageEncoder;
import com.sun.media.jai.codec.JPEGEncodeParam;

public class JAIDemo {
	@SuppressWarnings("deprecation")
	ScrollingImagePanel panel;

	/**
	 * @param args
	 */
	@SuppressWarnings("deprecation")
	public static void main(String[] args) {
			if(args.length < 2){
				System.out.println("Usage : java JAIDemo [resize|composite|mask] <input_image_filename>");
				System.exit(-1);
			}
			RenderedImage resultImage = null;
			
			if(args[0].toLowerCase().equals("resize"))
				resultImage = resize(args[1], Float.parseFloat(args[2]));
			else if(args[0].toLowerCase().equals("composite"))
				resultImage = composite(args[1], args[2]);
			else if(args[0].toLowerCase().equals("mask"))
				resultImage = mask(args[1], args[2], args[3]);
			int width = resultImage.getWidth();
			int height = resultImage.getHeight();

			/* Attach image2 to a scrolling panel to be displayed. */
			ScrollingImagePanel panel = new ScrollingImagePanel(
					resultImage, width, height);
			/* Create a frame to contain the panel. */
			Frame window = new Frame("JAI Sample Program");
			window.add(panel);
			window.pack();
			window.show();	

	}
	
	private static void writeFile(String path, RenderedOp op) {
		OutputStream os = null;
		try{
			os = new FileOutputStream(path);
			JPEGEncodeParam param = new JPEGEncodeParam();
			ImageEncoder enc = ImageCodec.createImageEncoder("jpeg", os, param);
			enc.encode(op);
			os.close();
		} catch (IOException e){
			e.printStackTrace();
		}		
		
	}

	public static RenderedImage resize(String path, float scale){
		 /*
		  * Create an input stream from the specified file name
		  * to be used with the file decoding operator.
		*/
		FileSeekableStream stream = null;
		try{
			stream = new FileSeekableStream(path);
		} catch (IOException e){
			e.printStackTrace();
			System.exit(0);
		}
		/* Create an operator to decode the image file. */
		RenderedOp image1 = JAI.create("stream", stream);
		
		/*
		 * Create a standard bilinear interpolation object to be
		 * used with the ¡°scale¡± operator.
		*/
		Interpolation interp = Interpolation.getInstance(
		Interpolation.INTERP_BILINEAR);
		/**
		* Stores the required input source and parameters in a
		* ParameterBlock to be sent to the operation registry,
		* and eventually to the ¡°scale¡± operator.
		*/
		ParameterBlock pb = new ParameterBlock();
		pb.addSource(image1);
		pb.add(scale); // x scale factor
		pb.add(scale); // y scale factor
		pb.add(0.0F); // x translate
		pb.add(0.0F); // y translate
		pb.add(interp);       // interpolation method
		/* Create an operator to scale image1. */
		RenderedOp image2 = JAI.create("scale", pb);
		/* Get the width and height of image2. */
		return image2;
	}

	public static RenderedImage composite(String path1, String path2){
		 /*
		  * Create an input stream from the specified file name
		  * to be used with the file decoding operator.
		*/
		FileSeekableStream st1 = null;
		FileSeekableStream st2 = null;
		try{
			st1 = new FileSeekableStream(path1);
			st2 = new FileSeekableStream(path2);
		} catch (IOException e){
			e.printStackTrace();
			System.exit(0);
		}
		/* Create an operator to decode the image file. */
		RenderedOp image1 = JAI.create("stream", st1);
		RenderedOp image2 = JAI.create("stream", st2);
//		ParameterBlock pb = new ParameterBlock();
//		pb.addSource(image1);
//		RenderedOp extended_alpha = (RenderedOp)JAI.create("constant", pb, null);
		
		Byte[] bandValues = new Byte[3];
		bandValues[0] = new Byte((byte)0);
		bandValues[1] = new Byte((byte)0);
		bandValues[2] = new Byte((byte)0);
		
		ParameterBlock pb = new ParameterBlock();
		pb.add((float)image1.getWidth());
		pb.add((float)image1.getHeight());
		pb.add(bandValues);
		PlanarImage alpha1 = JAI.create("constant", pb, null);

		bandValues[0] = new Byte((byte)255);
		bandValues[1] = new Byte((byte)255);
		bandValues[2] = new Byte((byte)255);

		pb = new ParameterBlock();
		pb.add((float)image2.getWidth());
		pb.add((float)image2.getHeight());
		pb.add(bandValues);
		PlanarImage alpha2 = JAI.create("constant", pb, null);
		
		// Create the ParameterBlock
		pb = new ParameterBlock();
		pb.addSource(image1);
		pb.addSource(image2);
		pb.add(alpha1);
		pb.add(alpha2);
		pb.add(Boolean.FALSE);
		pb.add(CompositeDescriptor.NO_DESTINATION_ALPHA);
		// Create the composite operation.
		RenderedImage dst = (RenderedImage)JAI.create("composite", pb);
		/* Create an operator to scale image1. */
		return dst;
	}

	public static RenderedImage mask(String path1, String mask1, String mask2){
		 /*
		  * Create an input stream from the specified file name
		  * to be used with the file decoding operator.
		*/
		FileSeekableStream st1 = null;
		FileSeekableStream st2 = null;
		FileSeekableStream st3 = null;
		try{
			st1 = new FileSeekableStream(path1);
			st2 = new FileSeekableStream(mask1);
			st3 = new FileSeekableStream(mask2);
		} catch (IOException e){
			e.printStackTrace();
			System.exit(0);
		}
		/* Create an operator to decode the image file. */
		RenderedOp image1 = JAI.create("stream", st1);
		RenderedOp image2 = JAI.create("stream", st2);
		RenderedOp image3 = JAI.create("stream", st3);
		
		
		ParameterBlock pb = new ParameterBlock();
		pb.addSource(image1);
		pb.addSource(image2);
		RenderedOp dst = JAI.create("subtract", pb);

		pb = new ParameterBlock();
		pb.addSource(dst);
		pb.addSource(image3);
		dst = JAI.create("add", pb);
		writeFile(path1.replaceFirst(".jpg",".1.jpg"), dst);
		return (RenderedImage )dst;
	}
}
