<?php
/*Gost – klasa za obradu funkcionalnosti dodeljenih gostu
 @version 1.0*/
namespace App\Controllers;

use App\Models\KorisnikModel;

class Gost extends BaseController {
    /*
    Autor: Jelena Pančevski 0123/2018
    Prikazivanje početne stranice gosta
    Predefinisana metoda-poziva se ukoliko nije navedena ni jedna metoda datog kontrolera
    @return void
    */
    public function index() {
        $this->prikaz("pocetna_gost.html", []);
    }
/*
    Autor: Jelena Pančevski 0123/2018
    Prikazivanje zadate stranice ($page) uz prosleđivanje zadatih parametara unutar niza $data
    @return void
    */
    protected function prikaz($page, $data) {
        $data['controller'] = 'Gost';
        echo view("stranice/$page", $data);
    }

/*
    Autor: Jelena Pančevski 0123/2018
    Metoda koja se poziva prilikom ulogovanja korisnika.
    @return void , odnosno preusmerava gosta na odgovarajuću početnu stranicu
    */
    public function loginSubmit() {
        if (!$this->validate(['KorisnickoIme' => 'trim|required', 'Lozinka' => 'trim|required'])) {
            return $this->prikaz('pocetna_gost.html',['errors'=>$this->validator->getErrors()]);   
        }
        $korisnikModel = new KorisnikModel();
        $korisnik = $korisnikModel->find($this->request->getVar("KorisnickoIme"));
        if ($korisnik == null) {
            return $this->prikaz("pocetna_gost.html", ['poruka' => 'Korisnicko ime ne postoji', 'korisnickoime' => $this->request->getVar("KorisnickoIme")]);
        }
        if ($korisnik->Lozinka != $this->request->getVar('Lozinka'))
            return $this->prikaz("pocetna_gost.html", ['poruka' => 'Pogresna lozinka', 'korisnickoime' => $this->request->getVar("KorisnickoIme")]);

        $this->session->set('Korisnik', $korisnik);


        $rediteljModel = new \App\Models\RediteljModel();
        $registrovanikorisnikModel = new \App\Models\RegistrovaniKorisnikModel();

        $result = $registrovanikorisnikModel->find($korisnik->KorisnickoIme);
        if ($result == null)
            $result = $rediteljModel->find($korisnik->KorisnickoIme);
        else
            return redirect()->to(site_url('RegistrovaniKorisnik'));
        if ($result == null)
            return redirect()->to(site_url('Administrator'));
        else{
        if ($result->Status == 'Prihvacen')
        return redirect()->to(site_url('Reditelj'));
        else
         return $this->prikaz("pocetna_gost.html", ['poruka' => 'Zahtev za registraciju na cekanju', 'korisnickoime' => $this->request->getVar("KorisnickoIme")]);
        }
    }   
/*
    Autor: Đorđe Milinović 0334/2018
    Omotač metoda koja poziva prikaz postojećih kastinga po kriterijumu:Televizija
    @return void
    */
     public function prikaziKastingeTelevizija() {
        $this->dohvatiKastingInfo(0, 0);
    }
    
/*
    Autor: Đorđe Milinović 0334/2018
    Omotač metoda koja poziva prikaz postojećih kastinga po kriterijumu:Pozorište
    @return void
    */
    public function prikaziKastingePozoriste() {
        $this->dohvatiKastingInfo(1, 0);
    }
  /*
    Autor: Đorđe Milinović 0334/2018
    Omotač metoda koja poziva prikaz svih postojećih kastinga
    @return void
    */
      public function prikaziSveKastinge() {
        $this->dohvatiKastingInfo(2, 0);
    }
public function prikaziDodavanjeNoveTeme() {
 echo '<script>alert("Morate se prvo ulogovati!!!")</script>';
       $this->prikaz("pocetna_gost.html", []);
    }
       /*Mihajlo Nikitovic
    fja za prikazivanja teme na forumu*/
     
        
        public function prikaziTeme() {
            
            $temaModel=new \App\Models\TemaModel();
            $teme=$temaModel->findAll();
            $string="";
            if($teme!=null){
                foreach ($teme as $elem){
                    
                    $string.="<div>
            <table>
            <tr>
                <td> <img class='image' src='/files/images/".$elem->KorisnickoIme.".jpg' onerror=\"this.src='/files/images/alt/alt.png';\"></td>
                <td>
                    <div class='TitleTheme'>".$elem->Naslov.  "</div>
                    <div class='ShortCaption'>".$elem->KratakOpis."</div>
                    <div class='Text'>Publisher:".$elem->KorisnickoIme."</div>
                    <div class='Text'>Date:".$elem->Datum."
                    </div>
                </td>
                <td>
                    <div class='button'><a href='#' target='blank' ><button type='submit'>Detaljnije</button></a></div>
                </td>
            </tr>
            </table>
        </div>";
                    
                }
         $string.="</div>
                </body>
                </html>";
                
                 
            }   
           $this->prikaz("pocetna_gost.html", []);
                 echo view("stranice/forum.html", ["string" => $string]); 
            
        }
}
