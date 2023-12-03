package com.have.datamodel.sample;

import java.util.ArrayList;
import java.util.List;

import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlElement;
import javax.xml.bind.annotation.XmlRootElement;
import javax.xml.bind.annotation.XmlType;


// POJO, no interface no extends

//Sets the path to base URL + /hello
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "", propOrder = {
    "item"
})
@XmlRootElement(name = "Product")
public class DefaultListArray {
	public String error;
  
	public DefaultListArray() {
		//this.item = item;
	} // JAXB needs this	
    @XmlElement(required = true)
    public List<?> item;
	public List<?> getItem() {
        if (item == null) {
            item = new ArrayList();
        }
        return this.item;
    }


}