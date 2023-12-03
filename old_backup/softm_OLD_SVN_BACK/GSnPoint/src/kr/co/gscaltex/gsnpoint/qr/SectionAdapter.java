package kr.co.gscaltex.gsnpoint.qr;

import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.HashMap;
import java.util.List;

import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.qr.result.ResultHandlerFactory;

import android.app.Activity;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import com.google.zxing.Result;
import com.google.zxing.client.result.ParsedResult;

public class SectionAdapter extends BaseAdapter {
	private Activity activity;
	private List<Result> items;

	public SectionAdapter(Activity activity, List<Result> items) {
		this.activity = activity;
		this.items = items;
	}

	public int getCount() {
		return items.size();
	}

	public Object getItem(int position) {
		return items.get(position);
	}

	public long getItemId(int position) {
		return position;
	}

	public View getView(int position, View convertView, ViewGroup parent) {
		View view = convertView;
		ViewWrapper wrapper;
		ParsedResult result = ResultHandlerFactory.parseResult(items.get(position));
		SimpleDateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd");
		String date = dateFormat.format(new Date(items.get(position).getTimestamp()));
		String name = getTitle(result.toString());

		if (view == null) {
			LayoutInflater inflater = (LayoutInflater)activity.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
			view = inflater.inflate(R.layout.qrcode_list_item, null);
			wrapper = new ViewWrapper(view, position);
			view.setTag(wrapper);
		}
		else {
			wrapper = (ViewWrapper)view.getTag();
		}

		if (name != null) {
			wrapper.tvDate.setText(date);
			wrapper.tvName.setText(name);
		}

		return view;
	}

	private String getTitle(String text) {
		HashMap<String, String> results = QRCodeParser.getList(text);
		if (results.containsKey(QRCodeParser.KEY_TTL))
			return results.get(QRCodeParser.KEY_TTL);
		else
			return text;
	}

	class ViewWrapper {
		int position;
		TextView tvDate;
		TextView tvName;

		public ViewWrapper(View base, int position) {
			this.position = position;
			tvDate = (TextView)base.findViewById(R.id.list_item_date);
			tvName = (TextView)base.findViewById(R.id.list_item_name);
		}
	}
}
