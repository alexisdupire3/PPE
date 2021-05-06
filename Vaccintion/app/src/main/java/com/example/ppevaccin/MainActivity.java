package com.example.ppevaccin;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.CalendarView;
import android.widget.EditText;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;

public class MainActivity extends AppCompatActivity {

    //Input
    int PfizerNumber;
    int ModernaNumber;
    int AstraZenecaNumber;

    EditText PfizerInput;
    EditText ModernaInput;
    EditText AstraZenecaInput;

    Button btnSendData;
    Button btnGetData;
    Button switcher;
    Button list;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        //Input
        this.PfizerInput = findViewById(R.id.PfizerInput);
        this.ModernaInput = findViewById(R.id.ModernaInput);
        this.AstraZenecaInput = findViewById(R.id.AstraZenecaInput);
        //Button
        this.btnSendData = findViewById(R.id.btnSendData);
        this.btnGetData = findViewById(R.id.btnGetData);


        switcher = (Button) findViewById(R.id.reservation);
        switcher.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View v) {
                openCalendar();
            }
        });
        list = (Button) findViewById(R.id.reserv_list);
        list.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View v) {
                openList();
            }
        });

        final String TAG = "MainActivity";

        //Récupération des données
        btnGetData.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                FirebaseDatabase database = FirebaseDatabase.getInstance("https://ppe-android-vaccin-default-rtdb.europe-west1.firebasedatabase.app/");
                DatabaseReference RefPfizer = database.getReference("Pfizer");
                DatabaseReference RefAstraZeneca = database.getReference("Astra Zeneca");
                DatabaseReference RefModerna = database.getReference("Moderna");

                //PFIZER
                RefPfizer.addValueEventListener(new ValueEventListener() {
                    @Override
                    public void onDataChange(@NonNull DataSnapshot dataSnapshot) {
                        Long value = dataSnapshot.getValue(Long.class);
                        String data = Long.toString(value);
                        PfizerInput.setText(Long.toString(value));
                        if (value < 5){
                            Context context = getApplicationContext();
                            int duration = Toast.LENGTH_SHORT;
                            Toast toast = Toast.makeText(context,"Attention ! Il ne reste plus que " + data + "en stock !", duration);
                        }
                    }

                    @Override
                    public void onCancelled(@NonNull DatabaseError error) {

                    }
                });
                //ASTRAZENECA
                RefAstraZeneca.addValueEventListener(new ValueEventListener() {
                    @Override
                    public void onDataChange(@NonNull DataSnapshot dataSnapshot) {
                        Long value = dataSnapshot.getValue(Long.class);
                        AstraZenecaInput.setText(Long.toString(value));
                    }

                    @Override
                    public void onCancelled(@NonNull DatabaseError error) {

                    }
                });
                //Moderna
                RefModerna.addValueEventListener(new ValueEventListener() {
                    @Override
                    public void onDataChange(@NonNull DataSnapshot dataSnapshot) {
                        Long value = dataSnapshot.getValue(Long.class);
                        ModernaInput.setText(Long.toString(value));
                    }

                    @Override
                    public void onCancelled(@NonNull DatabaseError error) {

                    }
                });
            }
        });

        //Envoie des données
        btnSendData.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                // Write a message to the database
                FirebaseDatabase database = FirebaseDatabase.getInstance("https://ppe-android-vaccin-default-rtdb.europe-west1.firebasedatabase.app/");
                DatabaseReference RefPfizer = database.getReference("Pfizer");
                DatabaseReference RefAstraZeneca = database.getReference("Astra Zeneca");
                DatabaseReference RefModerna = database.getReference("Moderna");
                DatabaseReference RefType = database.getReference("Moderna");

                PfizerNumber = Integer.valueOf(PfizerInput.getText().toString());
                ModernaNumber = Integer.valueOf(ModernaInput.getText().toString());
                AstraZenecaNumber = Integer.valueOf(AstraZenecaInput.getText().toString());


                RefPfizer.setValue(PfizerNumber);
                RefAstraZeneca.setValue(ModernaNumber);
                RefModerna.setValue(AstraZenecaNumber);




            }
        });
    }
    public void openCalendar(){
        Intent intent = new Intent(this, calendar.class);
        startActivity(intent);
    }

    public void openList(){
        Intent intent = new Intent(this, ListReservation.class);
        startActivity(intent);
    }


}