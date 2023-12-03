package com.kogas.dms.bean;

import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlElement;
import javax.xml.bind.annotation.XmlRootElement;
import javax.xml.bind.annotation.XmlType;

import org.apache.commons.digester.rss.Item;

@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "", propOrder = {
    "item"
})
@XmlRootElement(name = "Product")
public class Root {
    @XmlElement(required = true)
    protected Item item;
    public Item getItem() {
        return item;
    }
    public void setItem(Item value) {
        this.item = value;
    }
}
