package com.chikieu.thuchi;

import android.app.FragmentManager;
import android.content.Context;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.TextView;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.UnsupportedEncodingException;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.zip.Inflater;


/**
 * A simple {@link Fragment} subclass.
 * Activities that contain this fragment must implement the
 * {@link chart.OnFragmentInteractionListener} interface
 * to handle interaction events.
 * Use the {@link chart#newInstance} factory method to
 * create an instance of this fragment.
 */
public class chart extends Fragment {
    // TODO: Rename parameter arguments, choose names that match
    // the fragment initialization parameters, e.g. ARG_ITEM_NUMBER
    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";

    // TODO: Rename and change types of parameters
    private String mParam1;
    private String mParam2;

    private OnFragmentInteractionListener mListener;
    View rootView;
    public chart() {
        // Required empty public constructor
    }

    /**
     * Use this factory method to create a new instance of
     * this fragment using the provided parameters.
     *
     * @param param1 Parameter 1.
     * @param param2 Parameter 2.
     * @return A new instance of fragment chart.
     */
    // TODO: Rename and change types and number of parameters
    public static chart newInstance(String param1, String param2) {
        chart fragment = new chart();
        Bundle args = new Bundle();
        args.putString(ARG_PARAM1, param1);
        args.putString(ARG_PARAM2, param2);
        fragment.setArguments(args);
        return fragment;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        if (getArguments() != null) {
            mParam1 = getArguments().getString(ARG_PARAM1);
            mParam2 = getArguments().getString(ARG_PARAM2);
        }
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        rootView = inflater.inflate(R.layout.fragment_chart, container, false);
        DateFormat dateFormat = new SimpleDateFormat("MM");
        Date date = new Date();
        ((EditText) rootView.findViewById(R.id.month)).setText(dateFormat.format(date));
        parseDate(mParam1);
        ((Button) rootView.findViewById(R.id.back)).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                getFragmentManager().popBackStackImmediate();
            }
        });

        ((Button) rootView.findViewById(R.id.get)).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {


                Uri.Builder builder = new Uri.Builder()
                        .appendQueryParameter("month", ((EditText) rootView.findViewById(R.id.month)).getText().toString());
                String query = builder.build().getEncodedQuery();

                new ChartTask().execute("http://chikieu.com/apis/inout/inoutchart.php", query);
            }
        });

        return rootView;
    }

    public void parseDate(String data){


        try {
            JSONObject root = new JSONObject(data);
            ((TextView) rootView.findViewById(R.id.totaldebt)).setText(Helper.formatNumber(Long.parseLong(root.getString("debt"))));
            ((TextView) rootView.findViewById(R.id.totalinhand)).setText(Helper.formatNumber(Long.parseLong(root.getString("hand"))));
            ((TextView) rootView.findViewById(R.id.monthused)).setText(Helper.formatNumber(Long.parseLong(root.getString("moutcome"))));
            ((TextView) rootView.findViewById(R.id.foodused)).setText(Helper.formatNumber(Long.parseLong(root.getString("mfoutcome"))));

            final JSONArray array = root.getJSONArray("list");
            ((ListView) rootView.findViewById(R.id.listview)).setAdapter(new BaseAdapter() {
                @Override
                public int getCount() {
                    return array.length();
                }

                @Override
                public Object getItem(int i) {
                    try {
                        return array.getJSONObject(i);
                    } catch (JSONException e) {
                        e.printStackTrace();
                        return null;
                    }
                }

                @Override
                public long getItemId(int i) {
                    return 0;
                }

                @Override
                public View getView(int i, View view, ViewGroup viewGroup) {
                    if (view == null) {
                        view = LayoutInflater.from(getActivity()).inflate(R.layout.chart_unit, null);
                    }
                    try {
                        JSONObject obj = array.getJSONObject(i);
                        ((TextView) view.findViewById(R.id.money)).setText(Helper.formatNumber(Long.parseLong(obj.getString("money"))));
                        ((TextView) view.findViewById(R.id.content)).setText(new String(obj.getString("content").getBytes("ISO-8859-1"), "UTF-8"));
                        ((TextView) view.findViewById(R.id.date)).setText(obj.getString("date"));
                    } catch (Exception e) {
                        e.printStackTrace();
                    }

                    return view;
                }
            });

        } catch (JSONException e) {
            e.printStackTrace();
        }
    }

    class ChartTask extends AsyncTask<String, Void, String> {

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
            parseDate(feed);
        }
    }
    // TODO: Rename method, update argument and hook method into UI event
    public void onButtonPressed(Uri uri) {
        if (mListener != null) {
            mListener.onFragmentInteraction(uri);
        }
    }

    @Override
    public void onAttach(Context context) {
        super.onAttach(context);
        if (context instanceof OnFragmentInteractionListener) {
            mListener = (OnFragmentInteractionListener) context;
        } else {
//            throw new RuntimeException(context.toString()
//                    + " must implement OnFragmentInteractionListener");
        }
    }

    @Override
    public void onDetach() {
        super.onDetach();
        mListener = null;
    }

    /**
     * This interface must be implemented by activities that contain this
     * fragment to allow an interaction in this fragment to be communicated
     * to the activity and potentially other fragments contained in that
     * activity.
     * <p>
     * See the Android Training lesson <a href=
     * "http://developer.android.com/training/basics/fragments/communicating.html"
     * >Communicating with Other Fragments</a> for more information.
     */
    public interface OnFragmentInteractionListener {
        // TODO: Update argument type and name
        void onFragmentInteraction(Uri uri);
    }
}
