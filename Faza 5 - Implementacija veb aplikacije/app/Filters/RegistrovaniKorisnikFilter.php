<?php
/*Autor: Jelena Pancevski 0123/2018*/
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
/*RegistrovaniKorisnikFilter – klasa za proveru pristupa stranicama dodeljenim RegistrovanomKorisniku
 @version 1.0*/
class RegistrovaniKorisnikFilter implements FilterInterface {
/*
   Autor: Jelena Pančevski 0123/2018
   Metoda koja proverava da li je korektan pristup stranicama registrovanog korisnika, ukoliko Gost,Administrator ili Reditelj 
   pokusaju da pristupe kao Registrovani korisnik preusmeravaju se na svoju pocetnu stranu. 
   @return void
    */
    public function before(RequestInterface $request, $arguments = null) {
        $session = session();
        if (!$session->has("Korisnik")) {
            return redirect()->to(site_url("Gost"));
        }
        $rediteljModel = new \App\Models\RediteljModel();
        $administratorModel = new \App\Models\AdministratorModel();

        $korisnik = $session->get("Korisnik");

        if ($rediteljModel->find($korisnik->KorisnickoIme))
            return redirect()->to(site_url("Reditelj"));
        else if ($administratorModel->find($korisnik->KorisnickoIme))
            return redirect()->to(site_url("Administrator"));
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
        // Do something here
    }

}
