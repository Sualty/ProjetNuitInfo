package com.wizards.wayward.applirespo.network;

import com.wizards.wayward.applirespo.inventaire.Objet;

import java.io.IOException;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.ProtocolException;
import java.net.URL;

/**
 * Created by blou on 01/12/16.
 */

public class NetworkManager implements NetworkInterface {

    private String url_name="bloublou";//TODO remplacer


    @Override
    public void ajoutObjet(Objet type_objet, int nombre) throws IOException {
        HttpURLConnection httpcon = (HttpURLConnection) ((new URL(this.url_name).openConnection()));
        httpcon.setDoOutput(true);

        //setting http parameters
        httpcon.setRequestProperty("Content-Type", "application/json");
        httpcon.setRequestProperty("Accept", "application/json");
        httpcon.setRequestMethod("POST");

        httpcon.connect();

        String envoi =  "{ajouter:{'nom':"+type_objet.getNom()+",'nombre':"+nombre+"}}";

        byte[] outputBytes =envoi.getBytes("UTF-8");
        OutputStream os = httpcon.getOutputStream();
        os.write(outputBytes);

        os.close();
    }

    @Override
    public void supprimerObjet(Objet type_objet, int nombre) throws IOException {
        HttpURLConnection httpcon = (HttpURLConnection) ((new URL(this.url_name).openConnection()));
        httpcon.setDoOutput(true);

        //setting http parameters
        httpcon.setRequestProperty("Content-Type", "application/json");
        httpcon.setRequestProperty("Accept", "application/json");
        httpcon.setRequestMethod("POST");

        httpcon.connect();

        String envoi =  "{supprimer:{'nom':"+type_objet.getNom()+",'nombre':"+nombre+"}}";

        byte[] outputBytes =envoi.getBytes("UTF-8");
        OutputStream os = httpcon.getOutputStream();
        os.write(outputBytes);

        os.close();
    }
}
