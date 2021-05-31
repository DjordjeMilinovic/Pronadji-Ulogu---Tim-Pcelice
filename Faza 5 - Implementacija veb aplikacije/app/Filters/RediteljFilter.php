<?php
/*Autor: Jelena Pancevski 0123/2018*/
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
/*RediteljFilter – klasa za proveru pristupa stranicama dodeljenim Reditelju
 @version 1.0*/
class RediteljFilter implements FilterInterface {
/*
   Autor: Jelena Pančevski 0123/2018
   Metoda koja proverava da li je korektan pristup stranicama reditelja ukoliko Administrator,RegistrovaniKorisnik ili Gost 
   pokusaju da pristupe kao Reditelj preusmeravaju se na svoju pocetnu stranu. 
   @return void
    */
    public function before(RequestInterface $request, $arguments = null) {
        $session = session();
        if (!$session->has("Korisnik")) {
            return redirect()->to(site_url("Gost"));
        }
        $administratorModel = new \App\Models\AdministratorModel();
        $korisnikModel = new \App\Models\RegistrovaniKorisnikModel();
        $korisnik = $session->get("Korisnik");
        if ($administratorModel->find($korisnik->KorisnickoIme))
            return redirect()->to(site_url("Administrator"));
        else if ($korisnikModel->find($korisnik->KorisnickoIme))
            return redirect()->to(site_url("RegistrovaniKorisnik"));
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
        // Do something here
    }

}
