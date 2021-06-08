<?php

namespace App\Controllers;
/*RegistrovaniKorisnik – klasa za obradu funkcionalnosti koje dodeljene registrovanom korisniku
 @version 1.0*/
class RegistrovaniKorisnik extends Korisnik {
    /*
      Autor: Jelena Pančevski 0123/2018
      Prikazivanje zadate stranice ($page) uz prosleđivanje zadatih parametara unutar niza $data
      @return void
     */

    protected function prikaz($page, $data) {
        $data['controller'] = 'RegistrovaniKorisnik';
        $data['Korisnik'] = $this->session->get('Korisnik');
        echo view("stranice/$page", $data);
    }

    /*
      Autor: Jelena Pančevski 0123/2018
      Prikazivanje početne stranice prijavljenog registrovanog korisnika
      Predefinisana metoda-poziva se ukoliko nije navedena ni jedna metoda datog kontrolera
      @return void
     */

    public function index() {
        $this->prikaz("pocetna_korisnik.html", []);
    }

    /*
      Autor: Jelena Pančevski 0123/2018
      Prikazivanje profila prijavljenog registrovanog korisnika
      @return void
     */

    public function profil() {
        $this->prikaz("pocetna_korisnik.html", []);
        echo view("stranice/izmenaprofila.html", /* ["string"=>$string] */);
    }

    /*
      Autor: Mihajlo Nikitović 0164/2018
      Prikazivanje postavljenih monologa prijavljenog registrovanog korisnika
      @return void
     */

    public function monolozi() {  
          $korisnik = $this->session->get('Korisnik');
        if ($korisnik == null) {
            $data['controller'] = 'Gost';
            echo view("stranice/pocetna_gost.html", $data);
            return;
        }
        $KorisnickoIme = $korisnik->KorisnickoIme;
        $sadrzajModel = new \App\Models\SadrzajModel();
        $sadrzaj = $sadrzajModel->SadrzajKorisnika($KorisnickoIme);
        $string = "";
        // select * from pesme where IdSadrzaj in (select * from Sadrzaj where KorisnickoIme= $KorisnickoIme)
        if ($sadrzaj != null) {
            $monoloziModel = new \App\Models\MonologModel();
            $Idevi = [];
            foreach ($sadrzaj as $sad) {
                $Idevi[] = $sad->IdSadrzaj;
            }
            $monolozi = $monoloziModel->whereIn('IdSadrzaj', $Idevi)->findAll();
            if ($monolozi != null) {
                $counter=0;
                foreach ($monolozi as $elem) {
                    $string .= "<td>
                <figure role='group' aria-labelledby='" . $elem->IdSadrzaj . "'>
                    <video class='SongThumbnail'  src='/files/videos/" . $elem->IdSadrzaj . ".mp4' controls >  </video> 
                    <figcaption id='" . $elem->IdSadrzaj . "'>" . $elem->Delo . " <br>
                        Vrsta: " . $elem->Vrsta . "<br>
                        " . $elem->Autor . "</figcaption>
                </figure>
            </td>";
                    $counter++;
                    if($counter==3){
                        $string .="</tr> <tr>";
                        $counter=0;
                    }
                }
            }
        }

        $string .= "</tr>
    </table>
    </div>
</body>
</html>";


        $this->prikaz("pocetna_korisnik.html", []);
        echo view("stranice/monolozi.html",  ["string"=>$string]);
    }
    

    /*
      Autor: Jelena Pančevski 0123/2018
      Prikazivanje postavljenih pesama registrovanog korisnika
      @return void
     */

    public function pesme() {
        $korisnik = $this->session->get('Korisnik');
        if ($korisnik == null) {
            $data['controller'] = 'Gost';
            echo view("stranice/pocetna_gost.html", $data);
            return;
        }
        $KorisnickoIme = $korisnik->KorisnickoIme;
        $sadrzajModel = new \App\Models\SadrzajModel();
        $sadrzaj = $sadrzajModel->SadrzajKorisnika($KorisnickoIme);
        $string = "";
        // select * from pesme where IdSadrzaj in (select * from Sadrzaj where KorisnickoIme= $KorisnickoIme)
        if ($sadrzaj != null) {
            $pesmeModel = new \App\Models\PesmeModel();
            $Idevi = [];
            foreach ($sadrzaj as $sad) {
                $Idevi[] = $sad->IdSadrzaj;
            }
            $pesme = $pesmeModel->whereIn('IdSadrzaj', $Idevi)->findAll();
            if ($pesme != null) {
                $counter=0;
                foreach ($pesme as $pesma) {
                    $string .= "<td>
                <figure role='group' aria-labelledby='" . $pesma->IdSadrzaj . "'>
                    <video class='SongThumbnail'  src='/files/videos/" . $pesma->IdSadrzaj . ".mp4' controls >  </video> 
                    <figcaption id='" . $pesma->IdSadrzaj . "'>" . $pesma->Naziv . " <br>
                        Vrsta: " . $pesma->Vrsta . "<br>
                        " . $pesma->Autor . "</figcaption>
                </figure>
            </td>";
                    $counter++;
                    if($counter==3){
                        $string .="</tr> <tr>";
                        $counter=0;
                    }
                }
            }
        }

        $string .= "</tr>
    </table>
    </div>
</body>
</html>";
        $this->prikaz("pocetna_korisnik.html", []);
        echo view("stranice/pesme.html", ["string" => $string]);
    }

    /*
      Autor: Jelena Pančevski 0123/2018
      Prikaz formulara za postavljanje nove pesame na profil registrovanog korisnika
      @return void
     */

    public function dodajpesmu($data = []) {
        $this->prikaz("pocetna_korisnik.html", []);
        echo view("stranice/dodajpesmu.html", $data);
    }

    /*
      Autor: Jelena Pančevski 0123/2018
      Prikaz formulara za postavljanje novog monologa na profil registrovanog korisnika
      @return void
     */

    public function dodajmonolog($data = []) {
        $this->prikaz("pocetna_korisnik.html", []);
        echo view("stranice/dodajmonolog.html", $data);
    }

    /*
      Autor: Jelena Pančevski 0123/2018
      Metoda koja čuva informacije o novo postavljenom monologu unutar baze podataka, ukoliko dođe do greške prilikom postavljanja monologa obaveštava korisnika.
      @return void, odnosno poziva metodu za prikaz postavljenih monologa prijavljenog korisnika
     */

    public function novimonolog() {
        if (!$this->validate(['Naziv_dela' => 'required'])) {
          return redirect()->to('/');
          //prosledili koja greska je u pitanju
          } 
        if ($_FILES["Monolog"]['error'] != 0) {
            $poruka = "Upload failed: File is too large";
            return $this->dodajmonolog(["poruka" => $poruka]);
        }
        $Delo = $this->request->getVar("Naziv_dela");
        $Autor = $this->request->getVar("Ime_autora") ." ". $this->request->getVar("Prezime_autora");
        if ($Autor == "")
            $Autor = "Nepoznat";
        $Vrsta = $this->request->getVar("TipMonologa");
        $KorisnickoIme = $this->session->get("Korisnik");

        $sadrzajModel = new \App\Models\SadrzajModel();
        $IdSadrzaj = $sadrzajModel->insert(["KorisnickoIme" => $KorisnickoIme->KorisnickoIme], true);
        $monoloziModel = new \App\Models\MonologModel();
        $data = ['IdSadrzaj' => $IdSadrzaj, 'Delo' => $Delo, 'Autor' => $Autor, 'Vrsta' => $Vrsta];
        $monoloziModel->insert($data);

        $target_dir = "files/videos/";
        $file = $_FILES['Monolog']['name'];
        $path = pathinfo($file);
        $filename = "" . $IdSadrzaj; //$path['filename'];
        $ext = $path['extension'];
        $temp_name = $_FILES['Monolog']['tmp_name'];
        $path_filename_ext = $target_dir . $filename . "." . $ext;
        $result = move_uploaded_file($temp_name, $path_filename_ext);
        if ($result == false) {
            $poruka = "Upload failed: Cant save file specified";
            $monoloziModel->delete($IdSadrzaj);
            $sadrzajModel->delete($IdSadrzaj);
            return $this->dodajmonolog(["poruka" => $poruka]);
        }
        $this->response->redirect(base_url('RegistrovaniKorisnik/monolozi'));
    }

    /*
      Autor: Jelena Pančevski 0123/2018
      Metoda koja čuva informacije o novo postavljenoj pesmi unutar baze podataka, ukoliko dođe do greške prilikom postavljanja pesme obaveštava korisnika.
      @return void, odnosno poziva metodu za prikaz postavljenih pesama prijavljenog korisnika
     */

    public function novapesma() {
        
         if (!$this->validate(['Naziv_pesme' => 'required'])) {
          return redirect()->to('/');
          //prosledili koja greska je u pitanju
          } 
        if ($_FILES["Pesma"]['error'] != 0) {
            $poruka = "Upload failed: File is too large";
            return $this->dodajpesmu(["poruka" => $poruka]);
        }
        $Naziv = $this->request->getVar("Naziv_pesme");
        $Autor = $this->request->getVar("Ime_autora") ." ". $this->request->getVar("Prezime_autora");
        if ($Autor == "")
            $Autor = "Nepoznat";
        $Vrsta = $this->request->getVar("TipPesme");
        $KorisnickoIme = $this->session->get("Korisnik");

        $sadrzajModel = new \App\Models\SadrzajModel();
        $IdSadrzaj = $sadrzajModel->insert(["KorisnickoIme" => $KorisnickoIme->KorisnickoIme], true);
        $data = ['Naziv' => $Naziv, 'Autor' => $Autor, 'IdSadrzaj' => $IdSadrzaj, 'Vrsta' => $Vrsta];
        $pesmeModel = new \App\Models\PesmeModel();
        $pesmeModel->insert($data);
        $target_dir = "files/videos/";
        $file = $_FILES['Pesma']['name'];
        $path = pathinfo($file);
        $filename = "" . $IdSadrzaj; //$path['filename'];
        $ext = $path['extension'];
        $temp_name = $_FILES['Pesma']['tmp_name'];
        $path_filename_ext = $target_dir . $filename . "." . $ext;
        $result = move_uploaded_file($temp_name, $path_filename_ext);
        if ($result == false) {
            $poruka = "Upload failed: Cant save file specified";
            $pesmeModel->delete($IdSadrzaj);
            $sadrzajModel->delete($IdSadrzaj);
            return $this->dodajpesmu(["poruka" => $poruka]);
        }
        $this->response->redirect(base_url('RegistrovaniKorisnik/pesme'));
    }

    /*
      Autor: Đorđe Milinović 0334/2018
      Omotač metoda koja poziva prikaz postojećih kastinga po kriterijumu:Televizija
      @return void
     */

    public function prikaziKastingeTelevizija() {
        $this->dohvatiKastingInfo(0, 1);
    }

    /*
      Autor: Đorđe Milinović 0334/2018
      Omotač metoda koja poziva prikaz postojećih kastinga po kriterijumu:Pozorište
      @return void
     */

    public function prikaziKastingePozoriste() {
        $this->dohvatiKastingInfo(1, 1);
    }

    /*
      Autor: Đorđe Milinović 0334/2018
      Omotač metoda koja poziva prikaz svih postojećih kastinga
      @return void
     */

    public function prikaziSveKastinge() {
        $this->dohvatiKastingInfo(2, 1);
    }
    public function prikaziDodavanjeNoveTeme() {

        $this->prikaz("pocetna_korisnik.html", []);
        echo view("stranice/dodajtemu.html", []);
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
           echo '<script>alert("Uspesno ste dodali novu temu")</script>';
            $this->response->redirect(base_url('RegistrovaniKorisnik/prikaziTeme'));
          
}




/*Mihajlo Nikitovic*/
/*
 public function prikaziTeme() {
            
        $temaModel=new \App\Models\TemaModel();
        $teme=$temaModel->findAll();
        $string="";
        $temadetaljnije = base_url("RegistrovaniKorisnik/prikazJedneTeme");
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
                    <form action=\"".$temadetaljnije."\" method='POST'>
                     <input type='hidden' id='hiddenId' name='tema' value=".$elem->IdTema.">
                    <div class='button'><button type='submit'>Detaljnije</button></div>
                    </form>
                </td>
            </tr>
            </table>
        </div>";       
                }
         $string.="</div>
                </body>
                </html>";
                
                 
            }   
           $this->prikaz("pocetna_korisnik.html", []);
           echo view("stranice/forum.html", ["string" => $string]); 
        }*/
      /*Autor: Aleksa Visnjic 0341/18
        funkcija koja izlistava sve prijave na kasting jednog korisnika*/
   public function prijave_na_kasting(){
       $prijavaModel=new \App\Models\PrijavaModel();
       $kastingModel=new \App\Models\KastingModel();
       $prijave=$prijavaModel->where('KorisnickoIme',$this->session->get('Korisnik')->KorisnickoIme)->findAll();
        // $this->prikaz("prijave", $prijave);
         $str="";
         if(sizeof($prijave)>0){
         foreach($prijave as $prijava){
             $kasting=$kastingModel->find($prijava->IdKasting);
             $kastingdetaljnije = base_url("RegistrovaniKorisnik/kastingdetaljnije");
            $str.="<div>
            <table>
                <tr>
                    <td> <img class='image' src='/files/images/castings/".$kasting->IdKasting.".jpg' onerror=\"this.src='/files/images/alt/casting.png';\"></td>
                        
                    <td>
                    
                        <div class = 'TitleDir'>
                            <div>
                                <h2>
                                    ".$kasting->Naziv."
                                </h2>
                                <h3>
                                    ".$kasting->KorisnickoIme."
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
                                        <td>".$kasting->Kategorija."</td>
                                        <td class='centerText'>".$kasting->BrojGlumaca."</td>
                                        <td class='centerText'>".$kasting->BrojStatista."</td>
                                    </tr>
                                </table>
                             </div>
                        </div>
                      
                        <!--Kategorija glumci statisti-->
                        
                    </td>
                    <td><div class='Status'> Status prijave:<br>
                        ".$prijava->Status."
                    </div></td>
                      <td><div class='button'><form action=\"".$kastingdetaljnije."\" method='POST'><input type='hidden' name='IdKastinga' value='".$kasting->IdKasting."'><button type='submit'>Detaljnije</button></form></div></td>
                    
                </tr>
            </table>    
        </div>";
        } 
     }
     else{
          $str="<h2 id='Nema_prijava'>Trenutno nema prijava na kastinge</h2>";
     }
     $this->prikaz("pocetna_korisnik.html", []);
     echo view("stranice/prijave.html", ["string" => $str]);
   }
   
   /*Aleksa Visnjic 0341/18 */
/*Funkcija za poredjenje 2 datuma */
   
/*   public function compareByTimeStamp($kom1, $kom2)
{
       $time1=$kom1->Datum;
       $time2=$kom2->Datum;
    if (strtotime($time1) < strtotime($time2))
        return 1;
    else if (strtotime($time1) > strtotime($time2)) 
        return -1;
    else
        return 0;
}*/
/*Aleksa Visnjic 0341/18 */
/*Funkcija koja prikazuje jednu temu detaljno (temu i sve komentare na njoj)*/
  /*public function prikazJedneTeme(){
        $tema=$_POST['tema'];
       $temaModel=new \App\Models\TemaModel();
       $result=$temaModel->find($tema);
       $komentarModel=new \App\Models\KomentarModel();
       $komentari=$komentarModel->where('IdTema',$tema)->findAll();
       $str="";
       usort($komentari, array($this,'compareByTimeStamp'));
       $vremeteme= date("F j, Y", strtotime($result->Datum));
       $str.="<h1 class='Title'>".$result->Naslov."</h1><br>
           <h3 class='Podnaslov'>".$result->KratakOpis."</h3><br>
           <p class='Opis'>".$result->Tekst."</p><br>
               
        <table>
        <tr>
            <td>
                <div>
                    <img class='Image' src='/files/images/".$result->KorisnickoIme.".jpg' onerror=\"this.src='/files/images/alt/alt.png';\" />
                    <div class='User'>Publisher: ".$result->KorisnickoIme."</div>
                    <div class='User'>Date: ".$vremeteme."</div>
                </div>
            </td>
            <td class='Post'>
               <div>
               </div>
            </td>
        </tr>
        </table>
    
     <ul id='list'>";
       foreach($komentari as $komentar){
           $vreme= date("F j, Y", strtotime($komentar->Datum));
            $str.="<li>
                <table>
                    <tr>
                        <td>
                        <img class='Image' src='files/images/".$komentar->KorisnickoIme.".jpg'/>
                            <div class='User'>Publisher: ".$komentar->KorisnickoIme."</div>
                            <div class='User'>Date: ".$vreme."</div>
                        </td>
                        <td  class='Comment'>
                        <div>
                           ".$komentar->Tekst." 
                        </div>
                        </td>
                    </tr>
                </table>
              </li>";
       }
       $str."</ul>";
       $this->prikaz("pocetna_korisnik.html", []);
       echo view("stranice/tema.html", ["string" => $str, "controller"=>"RegistrovaniKorisnik", "IdTeme"=>$tema]);
   }*/
   /*Aleksa Visnjic 0341/18 */
/*Funkcija koja otvara formu za prijavu za kasting)*/
   public function udji_na_kasting(){
       $kasting=$_POST['kasting'];
       $string="<input type='hidden' name='kasting' value='".$kasting."'>";
       $this->prikaz("pocetna_korisnik.html", []);
       echo view("stranice/prijavanakasting.html", ["string" => $string]);
   }
   
   /*Aleksa Visnjic 0341/18 */
/*Funkcija koja obradjuje formu za kastinge i kreira prijavu na kasting*/
   public function prijava_na_kasting(){
         $kor = $this->session->get("Korisnik");
         $prijavaModel=new \App\Models\PrijavaModel();
         $kasting=$_POST['kasting'];
         
         
          $status="Na cekanju";
         $prijave=$prijavaModel->where("KorisnickoIme", $kor->KorisnickoIme)->find($kasting);
         
         if($prijave==""){
            $bool1=false;
         if (is_uploaded_file($_FILES['cv']['tmp_name'])&& file_exists($_FILES['cv']['tmp_name'])) {
            $target_dir = "files/cv/";
            $file = $_FILES['cv']['name'];
            $path = pathinfo($file);
            $filename = "" .$kor->KorisnickoIme."".$kasting; //$path['filename'];
            $ext = $path['extension'];
            $temp_name = $_FILES['cv']['tmp_name'];
            $path_filename_ext = $target_dir . $filename . "." . $ext;
            $result = move_uploaded_file($temp_name, $path_filename_ext);
            if ($result == false) {
                $poruka = "Nije moguce ucitati CV";
                return $this->prikaz("pocetna_korisnik.html",["poruka" => $poruka]);
            }
            $bool1=true;
            
         }
         else{
                $poruka = "Morate uneti CV";
                return $this->prikaz("pocetna_korisnik.html",["poruka" => $poruka]);
         }
            if (is_uploaded_file($_FILES['video']['tmp_name'])&& file_exists($_FILES['video']['tmp_name'])) {
            $target_dir = "files/videos/";
            
            $file = $_FILES['video']['name'];
            $path = pathinfo($file);
            $filename = "" .$kor->KorisnickoIme."".$kasting; //$path['filename'];
            $ext = $path['extension'];
            $temp_name = $_FILES['video']['tmp_name'];
            $path_filename_ext = $target_dir . $filename . "." . $ext;
            $result = move_uploaded_file($temp_name, $path_filename_ext);
            if ($result == false) {
                $poruka = "Nije moguce ucitati video";
                return $this->prikaz("pocetna_korisnik.html",["poruka" => $poruka]);
            }
         }
            if($bool1){
             $status="Na cekanju";
                $prijavaModel->insert([

                       'KorisnickoIme'=>$kor->KorisnickoIme,
                       'Status'=>$status,
                       'IdKasting'=>$kasting
                   ]);
            }
         }  
         else{
             $poruka = "Vec ste se prijavili na kasting";
             
             return $this->prikaz("pocetna_korisnik.html",["poruka" => $poruka]);
            // return $this->prikaz("pocetna_korisnik.html", ["poruka"=>$poruka]);
         }
        $poruka = "Uspesna prijava na kasting";
        
         return $this->prikaz("pocetna_korisnik.html", ["poruka" => $poruka]);
   }       
        /*Mihajlo Nikitovic*/
/*Korisnik dodaje komentar na temu*/
/*public function dodajNoviKomentar() {

$komentarModel=new \App\Models\KomentarModel();
echo '<script>alert("Uspesno ste dodali novi komentar")</script>';
$datum=date("Y/m/d");
$komentarModel->insert([
'IdTema'=>$_POST['idTeme'],
'KorisnickoIme'=>$this->session->get('Korisnik')->KorisnickoIme,
'Tekst'=>$_POST['NewComment'],
'Datum'=>date("Y/m/d")
]);
echo '<script>alert("Uspesno ste dodali novi komentar")</script>';
$IdTeme=$_POST['idTeme'];
 $str="<li>
                <table>
                    <tr>
                        <td>
                        <img class='Image' src='files/images/".$this->session->get('Korisnik')->KorisnickoIme.".jpg'/>
                            <div class='User'>Publisher: ".$this->session->get('Korisnik')->KorisnickoIme."</div>
                            <div class='User'>Date: ".$datum."</div>
                        </td>
                        <td  class='Comment'>
                        <div>
                           ".$_POST['NewComment']." 
                        </div>
                        </td>
                    </tr>
                </table>
              </li>";
 print($str);
}
  */      
}
