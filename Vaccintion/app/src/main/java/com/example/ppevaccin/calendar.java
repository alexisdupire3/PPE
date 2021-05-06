package com.example.ppevaccin;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.graphics.Color;
import android.widget.CalendarView;
import android.widget.EditText;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.Toast;

import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;

public class calendar extends AppCompatActivity {

    String Date;

    Button switcher;
    Button appoitement;

    CalendarView simpleCalendarView;

    EditText HeureInput;
    EditText NomInput;
    EditText PrenomInput;

    reserve reserve;



    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_calendar2);
        simpleCalendarView = (CalendarView) findViewById(R.id.simpleCalendarView); // get the reference of CalendarView
        switcher = (Button) findViewById(R.id.stocks);
        appoitement = (Button) findViewById(R.id.appoitement);
        switcher.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                openMain();
            }
        });

        long selectedDate = simpleCalendarView.getDate(); // get selected date in milliseconds
        simpleCalendarView.setOnDateChangeListener(new CalendarView.OnDateChangeListener() {
            @Override
            public void onSelectedDayChange(CalendarView view, int year, int month, int dayOfMonth) {
                // display the selected date by using a toast
                Date = dayOfMonth + "/" + month + "/" + year;
                reserve.setDate(Date);
            }
        });
        this.HeureInput = findViewById(R.id.HeureInput);
        this.NomInput = findViewById(R.id.NomInput);
        this.PrenomInput = findViewById(R.id.PrenomInput);
        reserve = new reserve();


        appoitement.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                // Write a message to the database
                FirebaseDatabase database = FirebaseDatabase.getInstance("https://ppe-android-vaccin-default-rtdb.europe-west1.firebasedatabase.app/");
                DatabaseReference RefReservation = database.getReference("Reservation");


                reserve.setHeure(HeureInput.getText().toString());
                reserve.setNom(NomInput.getText().toString());
                reserve.setPrenom(PrenomInput.getText().toString());

                RefReservation.push().setValue(reserve);

            }
        });
    }
    public void openMain() {
        Intent intent = new Intent(this, MainActivity.class);
        startActivity(intent);
    }
}