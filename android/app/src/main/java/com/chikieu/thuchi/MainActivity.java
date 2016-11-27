package com.chikieu.thuchi;

import android.app.Fragment;
import android.app.FragmentManager;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.widget.Button;

import java.io.DataOutputStream;
import java.io.InputStream;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLConnection;
import java.net.URLEncoder;

public class MainActivity extends AppCompatActivity {
    MainActivity mainActivity;
    Fragment incomeFrag;
    Fragment menuFrag;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        mainActivity = this;

        incomeFrag = new income();
        menuFrag = new mainmenu();

        android.webkit.CookieSyncManager.createInstance(this);
        // unrelated, just make sure cookies are generally allowed
        android.webkit.CookieManager.getInstance().setAcceptCookie(true);

        // magic starts here
        WebkitCookieManagerProxy coreCookieManager = new WebkitCookieManagerProxy(null, java.net.CookiePolicy.ACCEPT_ALL);
        java.net.CookieHandler.setDefault(coreCookieManager);

        try {
            Uri.Builder builder = new Uri.Builder()
                    .appendQueryParameter("password", URLEncoder.encode("2811", "UTF-8"))
                    .appendQueryParameter("applogin", URLEncoder.encode("0", "UTF-8"));
            String query = builder.build().getEncodedQuery();

            new GetPostTask().execute("http://chikieu.com/apis/login.php", query);
        } catch (UnsupportedEncodingException e) {
            e.printStackTrace();
        }


    }

    @Override
    public void onBackPressed() {
        getFragmentManager().popBackStackImmediate();
    }


    class GetPostTask extends AsyncTask<String, Void, String> {

        private Exception exception;

        protected String doInBackground(String... params) {
            try {
                return Helper.postData(params[0], params[1]);
            } catch (Exception e) {
                this.exception = e;

                return null;
            }
        }

        protected void onPostExecute(String feed) {
            FragmentManager fragmentManager = getFragmentManager();
            fragmentManager.beginTransaction()
                    .replace(R.id.activity_main, menuFrag, "menu").commit();

        }
    }

    class GetChartTask extends AsyncTask<String, Void, String> {

        private Exception exception;

        protected String doInBackground(String... params) {
            try {
                return Helper.postData(params[0], params[1]);
            } catch (Exception e) {
                this.exception = e;

                return null;
            }
        }

        protected void onPostExecute(String feed) {
            Log.v("chikieu", feed);
        }
    }
}
