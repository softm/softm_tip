package rest.resource;

import java.io.File;
import java.util.Iterator;
import java.util.List;

import javax.servlet.http.HttpServletRequest;
import javax.ws.rs.POST;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;
import javax.ws.rs.core.Context;

import org.apache.commons.fileupload.FileItem;
import org.apache.commons.fileupload.FileItemFactory;
import org.apache.commons.fileupload.FileUploadException;
import org.apache.commons.fileupload.disk.DiskFileItemFactory;
import org.apache.commons.fileupload.servlet.ServletFileUpload;

@Path("fileupload")
public class FileUploadResource {

	@POST
	@Produces("text/plain")
	public String loadFile(@Context HttpServletRequest request) {
		String resultStatus="fail";
		String fileRepository="I:\\testRepo\\";
		 if (ServletFileUpload.isMultipartContent(request)) { 
			 FileItemFactory factory = new DiskFileItemFactory();
			 ServletFileUpload upload = new ServletFileUpload(factory);
			 List<FileItem> items=null;
			try {
				items = upload.parseRequest(request);
			} catch (FileUploadException e) {
				
				e.printStackTrace();
			}
			if(items!=null) {
			 Iterator<FileItem> iter = items.iterator();  
			 while (iter.hasNext()) {  
				 FileItem item = iter.next();				 
			     if(!item.isFormField() && item.getSize() > 0) {  
				    	 String fileName = processFileName(item.getName());
				    	 try {
							item.write(new File(fileRepository+fileName));
						} catch (Exception e) {
							e.printStackTrace();
						}  
				         resultStatus="ok";
			     }			     
			 }  
			}			
		 }
		return resultStatus;
	}
	
	private String processFileName(String fileNameInput) {
		String fileNameOutput=null;
		fileNameOutput = fileNameInput.substring(fileNameInput.lastIndexOf("\\")+1,fileNameInput.length());
		return fileNameOutput;
	}
	
}
