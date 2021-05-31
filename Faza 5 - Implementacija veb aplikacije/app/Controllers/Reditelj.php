<?php

namespace App\Controllers;
/*Reditelj – klasa za obradu funkcionalnosti koje su dodeljene reditelju
 @version 1.0*/
class Reditelj extends Korisnik {
/*
    Autor: Jelena Pančevski 0123/2018
    Prikazivanje početne stranice ulogovanog reditelja
    Predefinisana metoda-poziva se ukoliko nije navedena ni jedna metoda datog kontrolera
    @return void
    */
    public function index() {
        $this->prikaz("pocetna_reditelj.html", []);
    }
/*
    Autor: Jelena Pančevski 0123/2018
    Prikazivanje zadate stranice ($page) uz prosleđivanje zadatih parametara unutar niza $data
    @return void
    */
    protected function prikaz($page, $data) {
        $data['controller'] = 'Reditelj';
        $data['Korisnik'] = $this->session->get('Korisnik');
        echo view("stranice/$page", $data);
    }
/*
    Autor: Jelena Pančevski 0123/2018
    Prikazivanje profila prijavljenog reditelja
    @return void
    */
    public function profil() {
        $this->prikaz("pocetna_reditelj.html", []);
        echo view("stranice/izmenaprofila.html");
    }
    /*
    Autor: Jelena Pančevski 0123/2018
    Prikazivanje prijave određenog korisnika na kasting
    @return void
    */
    public function PrijavaKorisnika(){
         if (!$this->validate(['KorisnickoIme' => 'required'])) {
          return redirect()->to('/');
          //prosledili koja greska je u pitanju
          }
        $KorisnickoIme= $_POST['KorisnickoIme'];
        $IdKasting= $_POST['IdKasting'];
        $korisnikModel= new \App\Models\KorisnikModel();
       $korisnik= $korisnikModel->find($KorisnickoIme);
       $string="<img src='/files/images/".$KorisnickoIme.".jpg' onerror=\"this.src='/files/images/alt/alt.png';\">

        <table>
            <tr>
                <td>Ime:".$korisnik->Ime."</td>
            </tr>
            <tr>
                <td>Prezime:".$korisnik->Prezime."</td>
            </tr>
            <tr>
                <td>Email: ".$korisnik->Email."</td>
            </tr>
            <tr>
                <td><a href='/files/cv/".$KorisnickoIme."".$IdKasting.".pdf' >Prikaži CV</a></td>
            </tr>
        </table>";
       echo view("stranice/profilPrijava.html", ["string"=>$string]);
    }
    /*
    Autor: Jelena Pančevski 0123/2018
    Prikazivanje video prijave određenog korisnika na kasting
    @return void
    */
    public function VideoPrijava(){
     if (!$this->validate(['KorisnickoIme' => 'required'])) {
          return redirect()->to('/');
          //prosledili koja greska je u pitanju
          }
     $KorisnickoIme= $_POST['KorisnickoIme'];
     $IdKasting= $_POST['IdKasting'];
     $string= " <video class='video'  src='/files/videos/" . $KorisnickoIme."".$IdKasting.".mp4' controls >  </video>  ";
     $this->prikaz("pocetna_reditelj.html", ['string'=>$string]);
    }
    /*
    Autor: Đorđe Milinović 0334/2018
    Omotač metoda koja poziva prikaz postojećih kastinga po kriterijumu:Televizija
    @return void
    */
    public function prikaziKastingeTelevizija() {
        $this->dohvatiKastingInfo(0, 2, 0);
    }
    
/*
    Autor: Đorđe Milinović 0334/2018
    Omotač metoda koja poziva prikaz postojećih kastinga po kriterijumu:Pozorište
    @return void
    */
   public function prikaziKastingePozoriste() {
        $this->dohvatiKastingInfo(1, 2, 0);
    }
  /*
    Autor: Đorđe Milinović 0334/2018
    Omotač metoda koja poziva prikaz svih postojećih kastinga
    @return void
    */
     public function prikaziSveKastinge() {
        $this->dohvatiKastingInfo(2, 2, 0);
    }
    
    /*
    Autor:Đorđe Milinović 0334/2018
    Preusmerava reditelja na stranicu za dodavanje novog kastinga.
    @return void
   */
    public function novKasting() {

        $this->prikaz("pocetna_reditelj.html", []);
        echo view("stranice/dodajkasting", []);
    }
/*
    Autor:Đorđe Milinović 0334/2018
    Metoda koja beleži novi kasting u bazi podataka, 
    a zatim preusmerava reditelja na početnu.
    @return void
  */
    public function dodajNoviKasting() {
        if (!$this->validate(['kastingNaziv' => 'required'])) {
          return redirect()->to('/');
          
          } 
        $idReditelj = $this->session->get('Korisnik')->KorisnickoIme;
        $naziv = $_POST['kastingNaziv'];
        $kategorija = $_POST['KategorijaKastinga'];
        $opis = $_POST['description'];
        $glumci = 0;
        $statisti = 0;
        if (isset($_POST['CheckGlumac']) && !empty($_POST['Glumac'])) {
            $glumci = $_POST['Glumac'];
        }
        if (isset($_POST['CheckStatista']) && !empty($_POST['Statista'])) {
            $statisti = $_POST['Statista'];
        }

        $data = [
            'KorisnickoIme' => $idReditelj,
            'Naziv' => $naziv,
            'Opis' => $opis,
            'BrojGlumaca' => $glumci,
            'BrojStatista' => $statisti,
            'Kategorija' => $kategorija
        ];
        $kastingModel = new \App\Models\KastingModel();
     $IdKasting = $kastingModel->insert($data, true);#insert u tabelu kasting vraca id zbog true;
       if (is_uploaded_file($_FILES ['slika']['tmp_name'])&& file_exists($_FILES['slika']['tmp_name'])) {
        $target_dir = "files/images/castings/";
        $file = $_FILES['slika']['name'];
        $path = pathinfo($file);
        $filename = "" . $IdKasting; //$path['filename'];
       # echo $filename;
        $ext = $path['extension'];
        $temp_name = $_FILES['slika']['tmp_name'];
        $path_filename_ext = $target_dir . $filename . "." . $ext;
        $result = move_uploaded_file($temp_name, $path_filename_ext);
        if ($result == false) {
            $poruka = "Upload failed: Cant save file specified";
            $monoloziModel->delete($IdKasting);
            $sadrzajModel->delete($IdKasting);
        }
          
          } 
        

       $this->response->redirect(base_url('Reditelj/dohvatiKreiraneKastinge'));
    }
    
    /* Autor:Đorđe Milinović 0334/2018
      Metoda koja odbija kandidatovu prijavu za određeni kasting.
      @return void */

    function odbijKandidata() {
        $KorisnickoIme = $_POST['KorisnickoIme'];
        $IdKasting = $_POST['IdKasting'];
        $prijavaModel = new \App\Models\PrijavaModel();
        $prijavaModel->odbijPrijavu($KorisnickoIme, $IdKasting);
        $this->prikaziKreiraniKasting();
    }
   
     /* Autor:Đorđe Milinović 0334/2018
      Metoda koja prihvata kandidatovu prijavu za određeni kasting.
      @return void */

     function prihvatiKandidata() {
        $KorisnickoIme = $_POST['KorisnickoIme'];
        $IdKasting = $_POST['IdKasting'];
        $prijavaModel = new \App\Models\PrijavaModel();
        $prijavaModel->prihvatiPrijavu($KorisnickoIme, $IdKasting);
        $this->prikaziKreiraniKasting();
    }
    /* //test djordje
    public function spisak() {
        $this->prikaz("pocetna_reditelj.html", []);
        echo view("stranice/spisakKandidata.html");
    }*/

        /*Mihajlo Nikitovic*/
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
                    <div class='button'><a href= '#' target='blank' ><button type='submit'>Detaljnije</button></a></div>
                </td>
            </tr>
            </table>
        </div>";
                    
                }
         $string.="</div>
                </body>
                </html>";
                
                 
            }   
            
          $this->prikaz("pocetna_reditelj.html", []);
           echo view("stranice/forum.html", ["string" => $string]);  
        }
         /*Mihajlo Nikitovic*/
        /*Korisnik dodaje temu na forumu*/
        public function dodajNovuTemu(){
         
            $temaModel=new \App\Models\TemaModel();
            $temaModel->insert([
                
                'Naslov'=>$_POST['naslov'],
                'KorisnickoIme'=>$this->session->get('Korisnik')->KorisnickoIme,
                'KratakOpis'=>$_POST['opis'],
                'Tekst'=>$_POST['description'],
                'Datum'=>date("Y/m/d")
            ]);
          
           $this->response->redirect(base_url('Reditelj/prikaziTeme'));
            echo '<script>alert("Uspesno ste dodali novu temu")</script>';             
           
    }
    
    
    
              /*Mihajlo Nikitovic
            Reditelj dohvata kreirane kastinge */
    public function dohvatiKreiraneKastinge() {
        $spisak = base_url("Reditelj/prikaziKreiraniKasting");
        $kastingdetaljnije = base_url("Reditelj/kastingdetaljnije");
        $korisnik = $this->session->get('Korisnik');
        if ($korisnik == null) {
            $data['controller'] = 'Gost';
            echo view("stranice/pocetna_gost.html", $data);
            return;
        }
        $KorisnickoIme = $korisnik->KorisnickoIme;
        $kastingModel = new \App\Models\KastingModel();
        $kastinzi = $kastingModel->where('KorisnickoIme', $KorisnickoIme)->findAll();
        $string = "";

        if ($kastinzi != null) {
            foreach ($kastinzi as $elem) {
                $string .= " <div>
            <table>
                <tr>
                    <td> <img class='image' src='/files/images/castings/" . $elem->IdKasting . ".jpg' onerror=\"this.src='/files/images/alt/casting.png';\"></td>
                            
                    <td>
                        <div class = 'TitleDir'>
                            <div>
                                <h2>
                                   " . $elem->Naziv . "
                                </h2>
                                <h3>
                                   " . $elem->KorisnickoIme . "
                                </h3>
                            </div>
                            <div class='infoBox'>
                                <table>
                                    <tr>
                                        <td class='Info'>Kategorija:</td>
                                        <td class='Info'>Glumci:</td>
                                        <td class='Info'>Statisti:</td>
                                    </tr>
                                    <tr>
                                        <td>" . $elem->Kategorija . "</td>
                                        <td class='centerText'>" . $elem->BrojGlumaca . "</td>
                                        <td class='centerText'>" . $elem->BrojStatista . "</td>
                                    </tr>
                                </table>
                             </div>
                        </div>
                      
                        <!--Kategorija glumci statisti-->
                        
                    </td>
                    <td><div class='Status'> Status prijave:<br>
                       " . $elem->Status . "
                    </div></td>
                     
                      <td><form  class='button' method='post' action=\"" . $kastingdetaljnije . "\" >
                <button  type='submit'>Detaljnije</button></form></td>
                      <td><form method = 'post' action = '" . $spisak . "' class='button'>"
                        . " <input type='text' hidden name='IdKasting' value='" . $elem->IdKasting . "'>"
                        . "<button type='submit' >Prijave za kasting</button>
                            </form> </td>
                    
                </tr>
            </table>    
        </div>";
            }
        }


        $string .= " 
            </div>
        </body>
    </html>";


        $this->prikaz("pocetna_reditelj.html", []);
        echo view("stranice/kreiranikastinzi.html", ["string" => $string]);
    }
    public function prikaziDodavanjeNoveTeme() {

        $this->prikaz("pocetna_reditelj.html", []);
        echo view("stranice/dodajtemu.html", []);
    }
         /*Mihajlo Nikitovic
    fja za prikazivanja teme na forumu*/
     
        /* Autor:Đorđe Milinović 0334/2018
      Metoda koja preusmerava na stranicu na kojoj se prikazuje
      spisak svih kandidata prijavljenih za određeni kasting.
      @return void */
     public function prikaziKreiraniKasting() {
        if (!$this->validate(['IdKasting' => 'required'])) {
            return redirect()->to('/');
            //prosledili koja greska je u pitanju
        }
        $IdKasting = $_POST['IdKasting'];
        $prijavaModel = new \App\Models\PrijavaModel();
        //mozda mora drugaciji where
        $prijave = $prijavaModel->where(['IdKasting' => $IdKasting])->findAll();
        $prihvati = base_url('Reditelj/prihvatiKandidata');
        $prijavi = base_url('Reditelj/PrijavaKorisnika');
        $odbij = base_url('Reditelj/odbijKandidata');
        $vp = base_url('Reditelj/VideoPrijava');
        $string = "<input hidden type = 'text' value=".$IdKasting." name='IdKasting'>
            </form>
            

        </td>
    </tr>
    <tr>
        <td>
";


        if ($prijave != null) {
            $brojac = 1;
            foreach ($prijave as $prijava) {

                $korisnikModel = new \App\Models\KorisnikModel();
                $korisnikInfo = $korisnikModel->find($prijava->KorisnickoIme);
                if ($prijava->Status != 'Na cekanju')
                    continue;
                $string .= " 
                    <br>
                    <br><div id=  'candidate" . $brojac . "' >
             
            <table >
                <tr class='Name'>
                <td><img class='img' src='/files/images/" . $korisnikInfo->KorisnickoIme . ".jpg' onerror=\"this.src='/files/images/alt/alt.png';\">
                </td>
                    <td align='left'>" . $korisnikInfo->Ime . " " . $korisnikInfo->Prezime . "</td>
                </tr>
                <tr>
                 <td>
                 <form method='post' action=\"" . $vp . "\">
            <input type='text' hidden name='IdKasting' value='" . $prijava->IdKasting . "'>
            <input type='text' hidden name='KorisnickoIme' value='" . $korisnikInfo->KorisnickoIme . "'>
            <input type='submit' value = 'Video prijave'></form>
                   </td>
                   <td>
                   <table>
                   <tr>
                                 <td>
    <form method='post' action=\"" . $prijavi . "\">
            <input type='text' hidden name='IdKasting' value='" . $prijava->IdKasting . "'>
            <input type='text' hidden name='KorisnickoIme' value='" . $korisnikInfo->KorisnickoIme . "'>
            <input type='submit' value='Prijava'></form>
            </td>
            <td>
            <form method = 'post' action=\"" . $prihvati . "\"><input type='text' hidden name='KorisnickoIme' value='" . $korisnikInfo->KorisnickoIme . "'>"
                        . "<input type='text' hidden name='IdKasting' value='" . $prijava->IdKasting . "'>"
                        . "<input type='submit' value='Prihvati'></form>               
</td>

<td>
<form method='post' action=\"" . $odbij . "\">"
                        . "<input type='text' hidden name='IdKasting' value='" . $prijava->IdKasting . "'>"
                        . "<input type='text' hidden name='KorisnickoIme' value='" . $korisnikInfo->KorisnickoIme . "'>"
                        . "<input type='submit' value='Odbij'></form>
</td>
<td><form action=''><input type='checkbox' name='c" . $brojac . "' id='c" . $brojac . "' >Odaberi</form></td>
                   </tr>
                   </table>
                   </td>
                </tr>
            </table>
            
            
            
        </div>
                    ";
                $brojac++;
            }
        }

        $this->prikaz("pocetna_reditelj.html", []);
        echo view("stranice/spisakKandidata.html", ["string" => $string]);
    }
     /* Autor:Đorđe Milinović 0334/2018
      Postavlja status kastinga na Zavrsen.
      @return void */
    public function zavrsi(){
        $IdKasting = $_POST['IdKasting'];
        $kastingModel = new \App\Models\KastingModel();
        
        $kastingModel->update(['IdKasting'=>$IdKasting], ['Status' => 'Zavrsen']);
        $this->dohvatiKreiraneKastinge();
    }
}
