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
import android.widget.Button;

import java.net.URLEncoder;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Date;


/**
 * A simple {@link Fragment} subclass.
 * Activities that contain this fragment must implement the
 * {@link mainmenu.OnFragmentInteractionListener} interface
 * to handle interaction events.
 * Use the {@link mainmenu#newInstance} factory method to
 * create an instance of this fragment.
 */
public class mainmenu extends Fragment {
    // TODO: Rename parameter arguments, choose names that match
    // the fragment initialization parameters, e.g. ARG_ITEM_NUMBER
    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";

    // TODO: Rename and change types of parameters
    private String mParam1;
    private String mParam2;

    private OnFragmentInteractionListener mListener;

    Fragment mainFragment;

    public mainmenu() {
        // Required empty public constructor
        mainFragment = this;
    }



    /**
     * Use this factory method to create a new instance of
     * this fragment using the provided parameters.
     *
     * @param param1 Parameter 1.
     * @param param2 Parameter 2.
     * @return A new instance of fragment mainmenu.
     */
    // TODO: Rename and change types and number of parameters
    public static mainmenu newInstance(String param1, String param2) {
        mainmenu fragment = new mainmenu();
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
        View rootView = inflater.inflate(R.layout.fragment_mainmenu, container, false);
        initButton(rootView);
        return rootView;
    }

    public void initButton(View rootView){
        ((Button)rootView.findViewById(R.id.income)).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                FragmentManager fragmentManager = getFragmentManager();
                fragmentManager.beginTransaction().add(R.id.activity_main, new income(), "income").remove(mainFragment).addToBackStack("menu").commit();
            }
        });
        ((Button)rootView.findViewById(R.id.outcome)).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                FragmentManager fragmentManager = getFragmentManager();
                fragmentManager.beginTransaction().add(R.id.activity_main, new outcome(), "outcome").remove(mainFragment).addToBackStack("menu").commit();
            }
        });
        ((Button)rootView.findViewById(R.id.debt)).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                FragmentManager fragmentManager = getFragmentManager();
                fragmentManager.beginTransaction().add(R.id.activity_main, new debt(), "debt").remove(mainFragment).addToBackStack("menu").commit();
            }
        });
        ((Button)rootView.findViewById(R.id.paydebt)).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                FragmentManager fragmentManager = getFragmentManager();
                fragmentManager.beginTransaction().add(R.id.activity_main, new paydebt(), "paydebt").remove(mainFragment).addToBackStack("menu").commit();
            }
        });
        ((Button)rootView.findViewById(R.id.chart)).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                DateFormat dateFormat = new SimpleDateFormat("MM");
                Date date = new Date();

                Uri.Builder builder = new Uri.Builder()
                        .appendQueryParameter("month", dateFormat.format(date));
                String query = builder.build().getEncodedQuery();

                new ChartTask().execute("http://chikieu.com/apis/inout/inoutchart.php", query);
            }
        });
        ((Button)rootView.findViewById(R.id.listview)).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                Uri.Builder builder = new Uri.Builder()
                        .appendQueryParameter("page", "0");
                String query = builder.build().getEncodedQuery();

                new ListTask().execute("http://chikieu.com/apis/inout/inoutlist.php", query);
            }
        });
        ((Button)rootView.findViewById(R.id.peopledebt)).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                Uri.Builder builder = new Uri.Builder()
                        .appendQueryParameter("page", "0");
                String query = builder.build().getEncodedQuery();

                new DebtListTask().execute("http://chikieu.com/apis/debt/debtlist.php", query);
            }
        });
    }

    class DebtListTask extends AsyncTask<String, Void, String> {


        protected String doInBackground(String... params) {
            try {
                return Helper.getData(params[0], params[1]);
            } catch (Exception e) {

                return null;
            }
        }

        protected void onPostExecute(String feed) {
            FragmentManager fragmentManager = getFragmentManager();
            fragmentManager.beginTransaction().add(R.id.activity_main, peopledebt.newInstance(feed,""), "peopledebt").remove(mainFragment).addToBackStack("menu").commit();
        }
    }

    class ListTask extends AsyncTask<String, Void, String> {


        protected String doInBackground(String... params) {
            try {
                return Helper.getData(params[0], params[1]);
            } catch (Exception e) {

                return null;
            }
        }

        protected void onPostExecute(String feed) {
            FragmentManager fragmentManager = getFragmentManager();
            fragmentManager.beginTransaction().add(R.id.activity_main, listall.newInstance(feed,""), "listall").remove(mainFragment).addToBackStack("menu").commit();
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
            FragmentManager fragmentManager = getFragmentManager();
            fragmentManager.beginTransaction().add(R.id.activity_main, chart.newInstance(feed,""), "chart").remove(mainFragment).addToBackStack("menu").commit();
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
