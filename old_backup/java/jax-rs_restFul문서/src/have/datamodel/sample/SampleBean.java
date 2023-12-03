package com.have.datamodel.sample;

import javax.xml.bind.annotation.XmlRootElement;

@XmlRootElement
public class SampleBean {
	  public String name;
	  public int age;
	      
	  public SampleBean() {} // JAXB needs this
	
	  public SampleBean(String name, int age) {
	    this.name = name;
	     this.age = age;
	   }
}
