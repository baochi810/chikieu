package com.chikieu.thuchi;

import android.app.AlertDialog;
import android.app.FragmentManager;
import android.content.Context;
import android.content.DialogInterface;
import android.graphics.Color;
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
import android.widget.ImageButton;
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
 * {@link listall.OnFragmentInteractionListener} interface
 * to handle interaction events.
 * Use the {@link listall#newInstance} factory method to
 * create an instance of this fragment.
 */
public class listall extends Fragment {
    // TODO: Rename parameter arguments, choose names that match
    // the fragment initialization parameters, e.g. ARG_ITEM_NUMBER
    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";

    // TODO: Rename and change types of parameters
    private String mParam1;
    private String mParam2;

    private OnFragmentInteractionListener mListener;
    View rootView;
    int page = 0;
    public listall() {
        // Required empty public constructor
    }

    /**
     * Use this factory method to create a new instance of
     * this fragment using the provided parameters.
     *
     * @param param1 Parameter 1.
     * @param param2 Parameter 2.
     * @return A new instance of fragment listall.
     */
    // TODO: Rename and change types and number of parameters
    public static listall newInstance(String param1, String param2) {
        listall fragment = new listall();
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
        rootView = inflater.inflate(R.layout.fragment_listall, container, false);

        parseDate(mParam1);
        ((Button) rootView.findViewById(R.id.back)).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                getFragmentManager().popBackStackImmediate();
            }
        });

        ((Button) rootView.findViewById(R.id.previous)).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if (page == 0)
                    return;
                page--;

                Uri.Builder builder = new Uri.Builder()
                        .appendQueryParameter("page", "" + page  );
                String query = builder.build().getEncodedQuery();

                new ListTask().execute("http://chikieu.com/apis/inout/inoutlist.php", query);
            }
        });

        ((Button) rootView.findViewById(R.id.next)).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                page++;
                Uri.Builder builder = new Uri.Builder()
                        .appendQueryParameter("page", "" + page  );
                String query = builder.build().getEncodedQuery();

                new ListTask().execute("http://chikieu.com/apis/inout/inoutlist.php", query);
            }
        });
        return rootView;
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
            parseDate(feed);
        }
    }

    public void parseDate(String data){


        try {
            final JSONArray array = new JSONArray(data);



            ((ListView) rootView.findViewById(R.id.list)).setAdapter(new BaseAdapter() {
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
                        view = LayoutInflater.from(getActivity()).inflate(R.layout.listall_unit, null);
                    }
                    try {
                        final JSONObject obj = array.getJSONObject(i);
                        TextView text = ((TextView) view.findViewById(R.id.money));
                        int type = Integer.parseInt(obj.getString("type"));
                        switch (type){
                            case 0: {
                                text.setTextColor(Color.parseColor("#00e516"));
                                break;
                            }
                            case 1: {
                                text.setTextColor(Color.parseColor("#E80000"));
                                break;
                            }
                            case 2: {
                                text.setTextColor(Color.parseColor("#00e516"));
                                break;
                            }
                            default: {
                                text.setTextColor(Color.parseColor("#E80000"));
                                break;
                            }
                        }
                        text.setText(Helper.formatNumber(Long.parseLong(obj.getString("money"))));
                        ((TextView) view.findViewById(R.id.content)).setText(new String(obj.getString("content").getBytes("ISO-8859-1"), "UTF-8"));
                        ((TextView) view.findViewById(R.id.date)).setText(obj.getString("date"));
                        ((ImageButton) view.findViewById(R.id.delete)).setOnClickListener(new View.OnClickListener() {
                            @Override
                            public void onClick(View view) {
                                new AlertDialog.Builder(getActivity())
                                        .setIcon(android.R.drawable.ic_dialog_alert)
                                        .setTitle("Delete Record")
                                        .setMessage("Do you want to delete this record?")
                                        .setPositiveButton("Yes", new DialogInterface.OnClickListener()
                                        {
                                            @Override
                                            public void onClick(DialogInterface dialog, int which) {
                                                Uri.Builder builder = null;
                                                try {
                                                    builder = new Uri.Builder()
                                                            .appendQueryParameter("id", obj.getString("id")  );
                                                } catch (JSONException e) {
                                                    e.printStackTrace();
                                                }
                                                String query = builder.build().getEncodedQuery();

                                                new DeleteTask().execute("http://chikieu.com/apis/inout/inoutdel.php", query);
                                            }

                                        })
                                        .setNegativeButton("No", null)
                                        .show();
                            }
                        });

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

    class DeleteTask extends AsyncTask<String, Void, String> {


        protected String doInBackground(String... params) {
            try {
                return Helper.getData(params[0], params[1]);
            } catch (Exception e) {

                return null;
            }
        }

        protected void onPostExecute(String feed) {
            Uri.Builder builder = new Uri.Builder()
                    .appendQueryParameter("page", "" + page  );
            String query = builder.build().getEncodedQuery();

            new ListTask().execute("http://chikieu.com/apis/inout/inoutlist.php", query);
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
