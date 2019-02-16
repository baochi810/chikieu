package com.chikieu.thuchi;

import android.content.Context;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.app.Fragment;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.inputmethod.EditorInfo;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;


/**
 * A simple {@link Fragment} subclass.
 * Activities that contain this fragment must implement the
 * {@link peopledebtadd.OnFragmentInteractionListener} interface
 * to handle interaction events.
 * Use the {@link peopledebtadd#newInstance} factory method to
 * create an instance of this fragment.
 */
public class peopledebtadd extends Fragment {
    // TODO: Rename parameter arguments, choose names that match
    // the fragment initialization parameters, e.g. ARG_ITEM_NUMBER
    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";

    // TODO: Rename and change types of parameters
    private String mParam1;
    private String mParam2;

    private peopledebtadd.OnFragmentInteractionListener mListener;
    View rootView;
    EditText amount;
    EditText name;

    public peopledebtadd() {
        // Required empty public constructor
    }

    /**
     * Use this factory method to create a new instance of
     * this fragment using the provided parameters.
     *
     * @param param1 Parameter 1.
     * @param param2 Parameter 2.
     * @return A new instance of fragment peopledebtadd.
     */
    // TODO: Rename and change types and number of parameters
    public static peopledebtadd newInstance(String param1, String param2) {
        peopledebtadd fragment = new peopledebtadd();
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
        rootView =  inflater.inflate(R.layout.fragment_peopledebtadd, container, false);
        initButton(rootView);
        return rootView;
    }

    public void initButton(View view){

        amount = (EditText)rootView.findViewById(R.id.money);
        name = (EditText)rootView.findViewById(R.id.description);

        ((Button) view.findViewById(R.id.add)).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {


                if (amount.getText().toString().length() == 0 || name.getText().toString().length() == 0){
                    Toast.makeText(getActivity(), "Input the full detail BITCH!",
                            Toast.LENGTH_LONG).show();
                } else {
                    sendData();
                }

            }
        });


        ((Button) view.findViewById(R.id.back)).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                getFragmentManager().popBackStackImmediate();
            }
        });
    }


    class AddOutCome extends AsyncTask<String, Void, String> {

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

        }
    }

    public void sendData(){
        Uri.Builder builder = new Uri.Builder()
                .appendQueryParameter("amount", amount.getText().toString())
                .appendQueryParameter("name", name.getText().toString());
        String query = builder.build().getEncodedQuery();

        new AddTask().execute("http://chikieu.com/apis/debt/debtadd.php", query);

        builder = new Uri.Builder()
                .appendQueryParameter("type", "1")
                .appendQueryParameter("specialtype", "0")
                .appendQueryParameter("money", amount.getText().toString())
                .appendQueryParameter("content", name.getText().toString() + " MƯỢN");
        query = builder.build().getEncodedQuery();

        new AddOutCome().execute("http://chikieu.com/apis/inout/inoutadd.php", query);
    }


    class AddTask extends AsyncTask<String, Void, String> {

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
            if (feed.equals("1")){
                Toast.makeText(getActivity(), "Success!",
                        Toast.LENGTH_LONG).show();
                name.setText("");
                amount.setText("");
            } else {
                Toast.makeText(getActivity(), "Fail BITCH!",
                        Toast.LENGTH_LONG).show();
            }
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
