package test;

import java.io.UnsupportedEncodingException;
import java.net.URLDecoder;

import org.json.simple.JSONObject;
import org.json.simple.JSONValue;

public class TestJson {
    public static void main(String[] args) {
        String p_jsondata = "\"username\":\"11\",\"address\":\"22\"";
       
        String jsonStr = null;
        try {
            jsonStr = "{" + URLDecoder.decode(p_jsondata, "UTF-8") + "}";
        } catch (UnsupportedEncodingException e1) {
            e1.printStackTrace();
        }
        JSONObject json = (JSONObject) JSONValue.parse(jsonStr);
        System.out.println(" - address : " + json.get("address").toString() );
    }
}