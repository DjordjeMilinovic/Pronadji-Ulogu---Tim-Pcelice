<?php
/*Autor: Jelena Pancevski 0123/2018*/
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
/*AdministratorFilter – klasa za proveru pristupa stranicama dodeljenim Administratoru
 @version 1.0*/
class AdministratorFilter implements FilterInterface {
/*
   Autor: Jelena Pančevski 0123/2018
   Metoda koja proverava da li je korektan pristup stranicama administratora ukoliko Gost,RegistrovaniKorisnik ili Reditelj 
   pokusaju da pristupe kao Administratori preusmeravaju se na svoju pocetnu stranu. 
   @return void
    */
    public function before(RequestInterface $request, $arguments = null) {
        $session = session();
        if (!$session->has("Korisnik")) {
            return redirect()->to(site_url("Gost"));
        }
        $rediteljModel = new \App\Models\RediteljModel();
        $korisnikModel = new \App\Models\RegistrovaniKorisnikModel();
        $korisnik = $session->get("Korisnik");
        if ($rediteljModel->find($korisnik->KorisnickoIme))
            return redirect()->to(site_url("Reditelj"));
        else if ($korisnikModel->find($korisnik->KorisnickoIme))
            return redirect()->to(site_url("RegistrovaniKorisnik"));
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
        // Do something here
    }

}
