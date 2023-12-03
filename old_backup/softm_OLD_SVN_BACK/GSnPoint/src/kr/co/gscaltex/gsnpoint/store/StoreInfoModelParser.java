package kr.co.gscaltex.gsnpoint.store;

import java.io.File;
import java.util.ArrayList;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;

import kr.co.gscaltex.gsnpoint.dao.StoreInfoModel;

import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;

public class StoreInfoModelParser {
	private String mResult = "";
	private String mError = "";
	private String mVer = "";
	private String mBusi_cd="";
	
	private ArrayList<StoreInfoModel> mModels = new ArrayList<StoreInfoModel>();
	public ArrayList<StoreInfoModel> getModelArray() { return mModels; }
	
	public StoreInfoModelParser(){
	}
	
	public String getResult(){ return mResult; }
	public String getError(){ return mError; }
	public String getVersion(){ return mVer; }
	
	public boolean parserModel(String strXMLPath){
		try {
			
			mModels.clear();
   		 
    	    File fXmlFile = new File(strXMLPath);
    	    DocumentBuilderFactory dbFactory = DocumentBuilderFactory.newInstance();
    	    DocumentBuilder dBuilder = dbFactory.newDocumentBuilder();
    	    Document doc = dBuilder.parse(fXmlFile);
    	    doc.getDocumentElement().normalize();
    	 
    	    System.out.println("Root element :" + doc.getDocumentElement().getNodeName());
    	    NodeList nList = doc.getElementsByTagName("xmlContent");
    	   // System.out.println("-----------------------");
    	    
    	    if( nList.getLength() == 0 ){    	    	
    	    	//root element�� ����
    	    	return false;
    	    }
    	    	
    	    
    	    Node dataList = parseHeader(nList.item(0).getChildNodes());
    	    
    	    if( dataList == null ){
    	    	
    	    	return false;
    	    }
    	    	
    	    
    	    //<data>
    	    if( parseDataList(dataList.getChildNodes()) == false ){
    	    	
    	    	return false;
    	    }
    	    
    	  } catch (Exception e) {
    	    e.printStackTrace();
    	    return false;
    	  }
    	  
		return true;
	}
	
	private String getTagValue(String sTag, Element eElement){
        NodeList nlList= eElement.getElementsByTagName(sTag).item(0).getChildNodes();
        Node nValue = (Node) nlList.item(0); 
        if( nValue == null )
        	return null;
        
        return nValue.getNodeValue();
    }
	
	private boolean parseDataList(NodeList data){
		if( data == null )
			return false;
		
		int size = data.getLength();
		Node node;
		for( int i = 0; i < size; i++ ){
			node = data.item(i);
			if( node.getNodeName().equals("data") ){
				StoreInfoModel model = parseStoreModel(node);
				if( model != null ){
					mModels.add(model);
				}
			}
		}
		
		return true;
	}
	
	private StoreInfoModel parseStoreModel(Node data){
		NodeList nodes = data.getChildNodes();
		
		if( nodes == null )
			return null;
		
		final int size = nodes.getLength();
		Node node;
		
		StoreInfoModel model = new StoreInfoModel();
		for( int i = 0; i < size; i++ ){
			node = nodes.item(i);
			if( node.getNodeName().equals("frch_cd") ){
				model.setFrch_cd(getTagValue("frch_cd", (Element)node));
				continue;
			}
			
			if( node.getNodeName().equals("frch_dtl_cd") ){
				model.setFrch_dtl_cd(getTagValue("frch_dtl_cd", (Element)node));
				continue;
			}
			
			if( node.getNodeName().equals("busi_cd") ){
//				mBusi_cd = getTagValue("busi_cd", (Element)node);
//				if(mBusi_cd.equals(Util.BUSI_CD_2_old)){	
//					model.setBusi_cd(Util.BUSI_CD_2_new);
//				}else{
//					model.setBusi_cd(getTagValue("busi_cd", (Element)node));
//				}
				model.setBusi_cd(getTagValue("busi_cd", (Element)node));
				continue;
			}
			
			if( node.getNodeName().equals("frch_nm") ){
				model.setFrch_nm(getTagValue("frch_nm", (Element)node));
				continue;
			}
			
			if( node.getNodeName().equals("tphn_no") ){
				model.setTphn_no(getTagValue("tphn_no", (Element)node));
				continue;
			}
			
			if( node.getNodeName().equals("cco_cd") ){
				model.setCco_cd(getTagValue("cco_cd", (Element)node));
				continue;
			}
			
			if( node.getNodeName().equals("zip_addr") ){
				model.setZip_addr(getTagValue("zip_addr", (Element)node));
				continue;
			}
			
			if( node.getNodeName().equals("dtl_addr") ){
				model.setDtl_addr(getTagValue("dtl_addr", (Element)node));
				continue;
			}
			
			if( node.getNodeName().equals("open_yn") ){
				model.setOpen_yn(getTagValue("open_yn", (Element)node));
				continue;
			}
			
			if( node.getNodeName().equals("lat") ){
				model.setLat(getTagValue("lat", (Element)node));
				continue;
			}
			
			if( node.getNodeName().equals("longi") ){
				model.setLongi(getTagValue("longi", (Element)node));
			}

			if (node.getNodeName().equals("busi_cd_ord")) {
				model.setBusiCdOrd(getTagValue("busi_cd_ord", (Element)node));
			}
		}
		
		return model;
	}
	
	private Node parseHeader(NodeList nodes){
		final int size = nodes.getLength();
		Node node;
		for( int i = 0; i < size; i++ ){
			node = nodes.item(i);
			if( node.getNodeName().equals("list") ){
				return node;
			}
			
			if( node.getNodeName().equals("result") ){
				mResult = getTagValue("result", (Element)node);
				continue;
			}
			
			if( node.getNodeName().equals("err") ){
				mError = getTagValue("err", (Element)node);
				continue;
			}
			
			if( node.getNodeName().equals("ver") ){
				mVer = getTagValue("ver", (Element)node);
				continue;
			}
		}
		return null;
	}
}
