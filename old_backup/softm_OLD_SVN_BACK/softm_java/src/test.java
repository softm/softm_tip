import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;

public class test {

		public static void main(String[] args) {
			String v = "20131218";
			String rtn = "";
			v = v.replaceAll("[^0-9]", "");
			System.out.println(v);
			SimpleDateFormat pm = new SimpleDateFormat("yyyyMMdd");
			SimpleDateFormat sm = new SimpleDateFormat("yyyy-MM-dd");
			try {
				Date vd = pm.parse(v);
				rtn = sm.format(vd);			
			} catch (ParseException e) {
				e.printStackTrace();
			}
			System.out.println(rtn);
		}


}
