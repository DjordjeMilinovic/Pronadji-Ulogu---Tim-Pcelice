<?php
/*Autor: Jelena Pancevski 0123/2018*/
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
/*GostFilter – klasa za proveru pristupa stranicama dodeljenim Gostu
 @version 1.0*/
class GostFilter implements FilterInterface {
/*
   Autor: Jelena Pančevski 0123/2018
   Metoda koja proverava da li je korektan pristup stranicama gosta ukoliko Administrator,RegistrovaniKorisnik ili Reditelj 
   pokusaju da pristupe kao Gost preusmeravaju se na svoju pocetnu stranu. 
   @return void
    */
    public function before(RequestInterface $request, $arguments = null) {
        $session = session();
        if ($session->has("Korisnik")) {

            $rediteljModel = new \App\Models\RediteljModel();
            $korisnikModel = new \App\Models\RegistrovaniKorisnikModel();

            $korisnik = $session->get("Korisnik");

            if ($rediteljModel->find($korisnik->KorisnickoIme))
                return redirect()->to(site_url("Reditelj"));
            else if ($korisnikModel->find($korisnik->KorisnickoIme))
                return redirect()->to(site_url("RegistrovaniKorisnik"));
            else
                return redirect()->to(site_url("Administrator"));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
        // Do something here
    }

}
