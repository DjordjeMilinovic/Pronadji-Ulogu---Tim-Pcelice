<?php

namespace App\Controllers;
/*Korisnik – klasa za obradu funkcionalnosti koje su zajedničke za sve registrovane korisnike
 @version 1.0*/
class Korisnik extends BaseController
{
    /*
    Autor: Jelena Pančevski 0123/2018
    Metoda za odjvaljivanje prijavljenog korisnika, uništava sesiju datog korisnika prilikom poziva.
    @return void, odnosno preusmerava korisnika na početnu stranicu gosta
    */
    public function logout() {
        $this->session->destroy();
        return redirect()->to(site_url('/'));
    }
    /*
    Autor: Jelena Pančevski 0123/2018
    Izmena informacija na profilu registrovanog korisnika
    Moguće je promeniti ime i prezime registrovanog korisnika
    @return void
    */
     public function izmenaprofila(){
       $korisnik= $this->session->get("Korisnik");
       $Ime= $_POST['Ime'];
       $Prezime=$_POST['Prezime'];
       $korisnikModel= new \App\Models\KorisnikModel();
       if($Ime!="" && $Prezime!="") $korisnikModel->update($korisnik->KorisnickoIme, ['Ime'=>$Ime,'Prezime'=>$Prezime]);
       else if ($Ime!="")$korisnikModel->update($korisnik->KorisnickoIme, ['Ime'=>$Ime]);
       else if ($Prezime!="")$korisnikModel->update($korisnik->KorisnickoIme, ['Prezime'=>$Prezime]);
       $Id= $korisnik->KorisnickoIme;
       $korisnik= $korisnikModel->find($Id);
       $this->session->set('Korisnik',$korisnik);
   }
    
}