package com.wizards.wayward.applirespo.network;

import com.wizards.wayward.applirespo.inventaire.Objet;

import java.io.IOException;
import java.net.MalformedURLException;
import java.net.ProtocolException;

/**
 * Created by blou on 01/12/16.
 */

public interface NetworkInterface {

    void ajoutObjet(Objet type_objet,int nombre) throws IOException;
    void supprimerObjet(Objet type_objet,int nombre) throws IOException;
    //TODO ici ajouter des signatures de methode pour envoyer des json au serveur
}
