/*
 * Copyright (C) 2008 ZXing authors
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

package kr.co.gscaltex.gsnpoint.qr.result;

import kr.co.gscaltex.gsnpoint.qr.PreferencesActivity;
import android.app.Activity;
import android.app.AlertDialog;
import android.content.ActivityNotFoundException;
import android.content.Intent;
import android.content.SharedPreferences;
import android.preference.PreferenceManager;
import android.view.View;

import com.google.zxing.Result;
import com.google.zxing.client.result.ParsedResult;
import com.google.zxing.client.result.ParsedResultType;
import kr.co.gscaltex.gsnpoint.R;

/**
 * A base class for the Android-specific barcode handlers. These allow the app to polymorphically
 * suggest the appropriate actions for each data type.
 *
 * This class also contains a bunch of utility methods to take common actions like opening a URL.
 * They could easily be moved into a helper object, but it can't be static because the Activity
 * instance is needed to launch an intent.
 *
 * @author dswitkin@google.com (Daniel Switkin)
 */
public abstract class ResultHandler {
	private final ParsedResult result;
	private final Activity activity;
	private final Result rawResult;
	private final String customProductSearch;

	ResultHandler(Activity activity, ParsedResult result) {
		this(activity, result, null);
	}

	ResultHandler(Activity activity, ParsedResult result, Result rawResult) {
		this.result = result;
		this.activity = activity;
		this.rawResult = rawResult;
		this.customProductSearch = parseCustomSearchURL();

		// Make sure the Shopper button is hidden by default. Without this, scanning a product followed
		// by a QR Code would leave the button on screen among the QR Code actions.
		//View shopperButton = activity.findViewById(R.id.shopper_button);
		//shopperButton.setVisibility(View.GONE);
	}

	ParsedResult getResult() {
		return result;
	}

	boolean hasCustomProductSearch() {
		return customProductSearch != null;
	}

	/**
	 * Indicates how many buttons the derived class wants shown.
	 *
	 * @return The integer button count.
	 */
	public abstract int getButtonCount();

	/**
	 * The text of the nth action button.
	 *
	 * @param index From 0 to getButtonCount() - 1
	 * @return The button text as a resource ID
	 */
	public abstract int getButtonText(int index);


	/**
	 * Execute the action which corresponds to the nth button.
	 *
	 * @param index The button that was clicked.
	 */
	public abstract void handleButtonPress(int index);

	/**
	 * The Google Shopper button is special and is not handled by the abstract button methods above.
	 *
	 * @param listener The on click listener to install for this button.
	 */
	protected void showGoogleShopperButton(View.OnClickListener listener) {
		//View shopperButton = activity.findViewById(R.id.shopper_button);
		//shopperButton.setVisibility(View.VISIBLE);
		//shopperButton.setOnClickListener(listener);
	}

	/**
	 * Create a possibly styled string for the contents of the current barcode.
	 *
	 * @return The text to be displayed.
	 */
	public CharSequence getDisplayContents() {
		String contents = result.getDisplayResult();
		return contents.replace("\r", "");
	}

	/**
	 * A string describing the kind of barcode that was found, e.g. "Found contact info".
	 *
	 * @return The resource ID of the string.
	 */
	public abstract int getDisplayTitle();

	/**
	 * A convenience method to get the parsed type. Should not be overridden.
	 *
	 * @return The parsed type, e.g. URI or ISBN
	 */
	public final ParsedResultType getType() {
		return result.getType();
	}

	void launchIntent(Intent intent) {
		if (intent != null) {
			intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_WHEN_TASK_RESET);
			intent.addFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
			try {
				activity.startActivity(intent);
			}
			catch (ActivityNotFoundException e) {
				AlertDialog.Builder builder = new AlertDialog.Builder(activity);
				builder.setTitle(R.string.alert_str);
				builder.setMessage(R.string.msg_intent_failed);
				builder.setPositiveButton(R.string.button_ok, null);
				builder.show();
			}
		}
	}

	protected void showNotOurResults(int index, AlertDialog.OnClickListener proceedListener) {
		SharedPreferences prefs = PreferenceManager.getDefaultSharedPreferences(activity);
		if (prefs.getBoolean(PreferencesActivity.KEY_NOT_OUR_RESULTS_SHOWN, false)) {
			// already seen it, just proceed
			proceedListener.onClick(null, index);
		} else {
			// note the user has seen it
			prefs.edit().putBoolean(PreferencesActivity.KEY_NOT_OUR_RESULTS_SHOWN, true).commit();
			AlertDialog.Builder builder = new AlertDialog.Builder(activity);
			builder.setMessage(R.string.msg_not_our_results);
			builder.setPositiveButton(R.string.button_ok, proceedListener);
			builder.show();
		}
	}

	private String parseCustomSearchURL() {
		SharedPreferences prefs = PreferenceManager.getDefaultSharedPreferences(activity);
		String customProductSearch = prefs.getString(PreferencesActivity.KEY_CUSTOM_PRODUCT_SEARCH, null);
		if (customProductSearch != null && customProductSearch.trim().length() == 0) {
			return null;
		}
		return customProductSearch;
	}

	String fillInCustomSearchURL(String text) {
		String url = customProductSearch.replace("%s", text);
		if (rawResult != null) {
			url = url.replace("%f", rawResult.getBarcodeFormat().toString());
		}
		return url;
	}

}