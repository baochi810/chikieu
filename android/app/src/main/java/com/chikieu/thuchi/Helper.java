package com.chikieu.thuchi;

import java.io.DataOutputStream;
import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLConnection;
import java.text.DecimalFormat;

/**
 * Created by chingo on 11/27/16.
 */

public class Helper {

    public static String postData(String sURL, String sData) {
        try {
            URL url;
            url = new URL(sURL);
            URLConnection connection;
            connection = url.openConnection();
            HttpURLConnection httppost = (HttpURLConnection) connection;
            httppost.setDoInput(true);
            httppost.setDoOutput(true);
            httppost.setRequestMethod("POST");


            DataOutputStream dos = new DataOutputStream(httppost.getOutputStream());
            dos.write(sData.getBytes()); // bytes[] b of post data

            String reply;
            InputStream in = httppost.getInputStream();
            StringBuffer sb = new StringBuffer();
            try {
                int chr;
                while ((chr = in.read()) != -1) {
                    sb.append((char) chr);
                }
                reply = sb.toString();
            } finally {
                in.close();
            }
            return reply;
        } catch (Exception e) {
            e.printStackTrace();
            return "ERROR";
        }

    }

    public static String getData(String sURL, String sData) {
        try {
            URL url;
            url = new URL(sURL);
            URLConnection connection;
            connection = url.openConnection();
            HttpURLConnection httppost = (HttpURLConnection) connection;
            httppost.setDoInput(true);
            httppost.setDoOutput(true);
            httppost.setRequestMethod("GET");


            DataOutputStream dos = new DataOutputStream(httppost.getOutputStream());
            dos.write(sData.getBytes()); // bytes[] b of post data

            String reply;
            InputStream in = httppost.getInputStream();
            StringBuffer sb = new StringBuffer();
            try {
                int chr;
                while ((chr = in.read()) != -1) {
                    sb.append((char) chr);
                }
                reply = sb.toString();
            } finally {
                in.close();
            }
            return reply;
        } catch (Exception e) {
            e.printStackTrace();
            return "ERROR";
        }

    }

    public static String formatNumber(long number){
        DecimalFormat formatter = new DecimalFormat("###,###,###");
        return formatter.format(number);
    }
}
