package com.example.ppevaccin;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import com.firebase.ui.database.FirebaseListAdapter;
import com.firebase.ui.database.FirebaseListOptions;
import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.Query;
import com.google.firebase.database.ValueEventListener;



import android.os.Bundle;
import android.view.View;
import android.widget.ListView;
import android.widget.TextView;

public class ListReservation extends AppCompatActivity {

    ListView list;
    FirebaseListAdapter adapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_list_reservation);

        list = (ListView) findViewById(R.id.list);



        Query query = FirebaseDatabase.getInstance("https://ppe-android-vaccin-default-rtdb.europe-west1.firebasedatabase.app/")
                .getReference().child("Reservation");
        FirebaseListOptions<reserve> options = new FirebaseListOptions.Builder<reserve>()
                .setLayout(R.layout.reservation_data)
                .setQuery(query,reserve.class)
                .build();

        adapter = new FirebaseListAdapter(options) {
            @Override
            protected void populateView(@NonNull View v, @NonNull Object model, int position) {
                TextView nomdata = v.findViewById(R.id.namedata);
                TextView prenomdata = v.findViewById(R.id.prenomdata);
                TextView heuredata = v.findViewById(R.id.heuredata);
                TextView datedata = v.findViewById(R.id.datedata);

                reserve reservation = (reserve) model;
                nomdata.setText(reservation.getNom().toString()+" ");
                prenomdata.setText(reservation.getPrenom().toString()+" ");
                heuredata.setText(reservation.getHeure().toString()+" ");
                datedata.setText(reservation.getDate().toString()+" ");

            }
        };
        list.setAdapter(adapter);
    }

    @Override
    protected void onStart() {
        super.onStart();
        adapter.startListening();
    }

    @Override
    protected void onStop() {
        super.onStop();
        adapter.stopListening();
    }
}