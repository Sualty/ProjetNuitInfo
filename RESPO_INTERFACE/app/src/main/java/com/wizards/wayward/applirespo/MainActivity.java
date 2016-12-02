package com.wizards.wayward.applirespo;

import com.google.zxing.integration.android.IntentIntegrator;
import com.google.zxing.integration.android.IntentResult;

import android.content.Context;
import android.hardware.Sensor;
import android.hardware.SensorEvent;
import android.hardware.SensorEventListener;
import android.hardware.SensorManager;
import android.os.Bundle;
import android.app.Activity;
import android.content.Intent;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

public class MainActivity extends Activity implements OnClickListener, SensorEventListener {
    private Button scanBtn;
    private TextView formatTxt, contentTxt;
    private boolean point1, point2, point3;
    float x, y, z;

    private SensorManager sensorManager;
    private Sensor accelerometer;
    private Sensor gravity;
    private Sensor linearAcc;

    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        scanBtn = (Button) findViewById(R.id.scan_button);
        formatTxt = (TextView) findViewById(R.id.scan_format);
        contentTxt = (TextView) findViewById(R.id.scan_content);

        scanBtn.setOnClickListener(this);

        // Initialize sensors
        sensorManager = (SensorManager) getSystemService(Context.SENSOR_SERVICE);
        accelerometer = sensorManager.getDefaultSensor(Sensor.TYPE_ACCELEROMETER);
        gravity = sensorManager.getDefaultSensor(Sensor.TYPE_GRAVITY);
        linearAcc = sensorManager.getDefaultSensor(Sensor.TYPE_LINEAR_ACCELERATION);

        x = 0;
        y = 0;
        z = 0;

        point1 = false;
        point2 = false;
        point3 = false;

    }

    @Override
    protected void onPause() {
        sensorManager.unregisterListener(this, accelerometer);
        sensorManager.unregisterListener(this, gravity);
        sensorManager.unregisterListener(this, linearAcc);
        super.onPause();
    }

    @Override
    protected void onResume() {
        sensorManager.registerListener(this, accelerometer, SensorManager.SENSOR_DELAY_UI);
        sensorManager.registerListener(this, gravity, SensorManager.SENSOR_DELAY_UI);
        sensorManager.registerListener(this, linearAcc, SensorManager.SENSOR_DELAY_UI);
        super.onResume();
    }

    public void onClick(View v) {
        if (v.getId() == R.id.scan_button) {
            IntentIntegrator scanIntegrator = new IntentIntegrator(this);
            scanIntegrator.initiateScan();
        }
    }

    public void onActivityResult(int requestCode, int resultCode, Intent intent) {
        IntentResult scanningResult = IntentIntegrator.parseActivityResult(requestCode, resultCode, intent);
        if (scanningResult != null) {
            /*String scanContent = scanningResult.getContents();
            String scanFormat = scanningResult.getFormatName();
            formatTxt.setText("FORMAT: " + scanFormat);
            contentTxt.setText("CONTENT: " + scanContent);*/
        } else {
            Toast.makeText(getApplicationContext(), "No scan data received!", Toast.LENGTH_SHORT).show();
        }
    }

    @Override
    public void onSensorChanged(SensorEvent event) {
        x = event.values[0];
        y = event.values[1];
        z = event.values[2];

        if ((y >= -1 && y <= 2) && (z >= 9 && z <= 11) && (x >= -1 && x <= 1) && !point1 && !point2 && !point3) {
            point1 = true;
        }

        if ((y >= 5 && y <= 10) && (z >= -1 && z <= 5) && (x >= -1 && x <= 4) && point1 && !point3) {
            point2 = true;
        }

        if ((y >= -5 && y <= 0) && (z >= 11 && z <= 14) && (x >= -1 && x <= 1) && point1 && !point2) {
            point3 = true;
        }

        if (point1 && point2) {
            Toast.makeText(getApplicationContext(), "Add", Toast.LENGTH_SHORT).show();
            point1 = false;
            point2 = false;
        }

        if (point1 && point3) {
            Toast.makeText(getApplicationContext(), "Remove", Toast.LENGTH_SHORT).show();
            point1 = false;
            point3 = false;
        }
    }

    @Override
    public void onAccuracyChanged(Sensor sensor, int accuracy) {
    }

}