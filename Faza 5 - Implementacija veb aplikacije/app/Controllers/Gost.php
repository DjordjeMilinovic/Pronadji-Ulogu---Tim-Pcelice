<?php

/* Gost – klasa za obradu funkcionalnosti dodeljenih gostu
  @version 1.0 */

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
            return $this->prikaz('pocetna_gost.html', ['errors' => $this->validator->getErrors()]);
        }
        $korisnikModel = new KorisnikModel();
        $korisnik = $korisnikModel->find($this->request->getVar("KorisnickoIme"));
        if ($korisnik == null) {
            return $this->prikaz("pocetna_gost.html", ['poruka' => 'Korisnicko ime ne postoji', 'korisnickoime' => $this->request->getVar("KorisnickoIme")]);
        }
        if ($korisnik->Lozinka != $this->request->getVar('Lozinka'))
            return $this->prikaz("pocetna_gost.html", ['poruka' => 'Pogresna lozinka', 'korisnickoime' => $this->request->getVar("KorisnickoIme")]);
        $rediteljModel = new \App\Models\RediteljModel();
        $registrovanikorisnikModel = new \App\Models\RegistrovaniKorisnikModel();

        $result = $registrovanikorisnikModel->find($korisnik->KorisnickoIme);
        if ($result == null)
            $result = $rediteljModel->find($korisnik->KorisnickoIme);
        else {
            $this->session->set('Korisnik', $korisnik);
            return redirect()->to(site_url('RegistrovaniKorisnik'));
        }
        if ($result == null) {
            $this->session->set('Korisnik', $korisnik);
            return redirect()->to(site_url('Administrator'));
        } else {
            if ($result->Status == 'Prihvacen') {
                $this->session->set('Korisnik', $korisnik);
                return redirect()->to(site_url('Reditelj'));
            } else
                return $this->prikaz("pocetna_gost.html", ['poruka' => 'Zahtev za registraciju na cekanju', 'korisnickoime' => $this->request->getVar("KorisnickoIme")]);
        }
    }

    /* Funkcija za prebacivanje na stranicu za registraciju */

    public function reg_strana() {
        $this->prikaz('pocetna_gost.html', []);
        echo view("stranice/registracija.html");
    }

    /* Funkcija za obradu forme za registraciju */

    public function registracijaKorisnika() {
        if (!$this->validate(['username' => 'trim|required', 'password' => 'trim|required|min_length[6]', 'name' => 'required', 'surname' => 'required', 'email' => 'trim|required', 'birthday' => 'required', 'TipKorisnika' => 'required'], ['password' => ['min_length' => 'Lozinka mora imati barem 6 karaktera']])) {
            $this->prikaz('pocetna_gost.html', []);
            return $this->prikaz('registracija.html', ['errors' => $this->validator->getErrors()]);
        }
        $korisnikModel = new KorisnikModel();
        $korisnik = $korisnikModel->find($this->request->getVar("username"));
        if ($korisnik != null) {
            $this->prikaz('pocetna_gost.html', []);
            return $this->prikaz("registracija.html", ['poruka' => 'Korisnicko ime vec postoji', 'greska' => 0]);
        }
        $korisnik = $korisnikModel->where('email', $this->request->getVar("email"))->findAll();
        if ($korisnik != null) {
            $this->prikaz('pocetna_gost.html', []);
            return $this->prikaz("registracija.html", ['poruka' => 'E-adresa ime vec postoji', 'greska' => 1]);
        }
        if (is_uploaded_file($_FILES['image']['tmp_name']) && file_exists($_FILES['image']['tmp_name'])) {
            $target_dir = "files/images/";
            $file = $_FILES['image']['name'];
            $path = pathinfo($file);
            $filename = "" . $this->request->getVar("username");
            $ext = $path['extension'];
            $temp_name = $_FILES['image']['tmp_name'];
            $path_filename_ext = $target_dir . $filename . "." . $ext;
            $result = move_uploaded_file($temp_name, $path_filename_ext);
            if ($result == false) {
                $this->prikaz('pocetna_gost.html', []);
                return $this->prikaz("registracija.html", ['poruka' => 'Sliku nije moguce ucitati']);
            }
        }

        $rediteljModel = new \App\Models\RediteljModel();
        $registrovanikorisnikModel = new \App\Models\RegistrovaniKorisnikModel();
        $TipKorisnika = $this->request->getVar("TipKorisnika");
        $dob = date('Y-m-d', strtotime($this->request->getVar("birthday")));
        $korisnikModel->insert([
            'KorisnickoIme' => $this->request->getVar("username"),
            'Lozinka' => $this->request->getVar("password"),
            'Ime' => $this->request->getVar("name"),
            'Prezime' => $this->request->getVar("surname"),
            'DatumRodjenja' => $dob,
            'Email' => $this->request->getVar("email")
        ]);
        if ($TipKorisnika == 1) {
            $registrovanikorisnikModel->insert([
                'KorisnickoIme' => $this->request->getVar("username")
            ]);
        } else {
            $rediteljModel->insert([
                'KorisnickoIme' => $this->request->getVar("username"),
                'Status' => 'Na cekanju'
            ]);
        }

        echo '<script>alert("Registracija uspesna")</script>';
        return $this->prikaz('pocetna_gost.html', []);
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

    /* Mihajlo Nikitovic
      fja za prikazivanja teme na forumu */


    /* public function prikaziTeme() {

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

      } */

    /* Mihajlo Nikitovic */
    /* Korisnik dodaje komentar na temu */

    public function dodajNoviKomentar() {

        echo '<script>alert("Da biste mogli da postavljate komentare morate biti registrovani")</script>';
    }

}
