    final static String baseSortStr = "123qwer@#$%^&*()";
    public static String base64DoubleEncode(String v) {
        String encodeStr = Base64.encodeToString((baseSortStr + Base64.encodeToString(v.getBytes(), 0) + baseSortStr).getBytes(), 0);
        return encodeStr;
    }

    public static String base64DoubleDecode(String v) {
        String decodeStr = new String(Base64.decode(v,0));
        decodeStr = decodeStr.substring(baseSortStr.length(),decodeStr.length()-baseSortStr.length());
        decodeStr = new String(Base64.decode(decodeStr,0));
        return decodeStr;
    }