<?php

namespace App\Controllers;
/*Administrator – klasa za obradu funkcionalnosti dodeljenih administratoru
 @version 1.0*/

class Administrator extends Korisnik {
    /*
    Autor: Jelena Pančevski 0123/2018
    Prikazivanje početne stranice ulogovanog administratora
    Predefinisana metoda-poziva se ukoliko nije navedena ni jedna metoda datog kontrolera
    @return void
    */
    public function index() {
        $this->prikaz("pocetna_administrator.html", []);
    }
/*
    Autor: Jelena Pančevski 0123/2018
    Prikazivanje zadate stranice ($page) uz prosleđivanje zadatih parametara unutar niza $data
    @return void
    */
    protected function prikaz($page, $data) {
        $data['controller'] = 'Administrator';
        $data['Korisnik'] = $this->session->get('Korisnik');
        echo view("stranice/$page", $data);
    }
/*
    Autor: Jelena Pančevski 0123/2018
    Prikazivanje profila prijavljenog administratora
    @return void
    */
    public function profil() {
        $this->prikaz("pocetna_administrator.html", []);
        echo view("stranice/izmenaprofila.html",);
    }

/*
    Autor: Jelena Pančevski 0123/2018
    Prikazivanje spiska zahteva za kreiranje kastinga. 
    Prikazuju se svi kastinzi koji čekaju na odobrenje od strane administratora
    @return void
    */
    public function ZahteviZaKasting() {
        $kastingdetaljnije = base_url('Administrator/kastingdetaljnije');
        $kastingModel = new \App\Models\KastingModel();
        $kastinzi = $kastingModel->where('Status', 'Na cekanju')->findAll();
        $string = "";
        if ($kastinzi != null) {
            foreach ($kastinzi as $kasting) {
                $korisnikModel = new \App\Models\KorisnikModel();
                $reditelj = $korisnikModel->find($kasting->KorisnickoIme);

                $string .= "  <div id=" . $kasting->IdKasting . ">
            <table>
            <tr>
                <td> <img class='image' src='/files/images/castings/" . $kasting->IdKasting . ".jpg' onerror=\"this.src='/files/images/alt/casting.png';\"></td>
                <td >
                    <div class = 'TitleDir'>
                        <div>
                            <h2>" .
                        $kasting->Naziv
                        . "</h2>
                            <h3>" .
                        $reditelj->Ime . " " . $reditelj->Prezime
                        . "</h3>
                        </div>
                    </div>
                  
                    <!--Kategorija glumci statisti-->
                    <div class='infoBox'>
                       <table>
                           <tr>
                               <td>Kategorija:</td>
                               <td>Glumci:</td>
                               <td>Statisti:</td>
                           </tr>
                           <tr>
                               <td>" . $kasting->Kategorija . "</td>
                               <td class='centerText'>" . $kasting->BrojGlumaca . "</td>
                               <td class='centerText'>" . $kasting->BrojStatista . "</td>
                           </tr>
                       </table>
                    </div>
                </td>
                <td>
                <form method='post' action=\"".$kastingdetaljnije."\" >
                <input type='text' hidden name='IdKastinga' value='" .$kasting->IdKasting."'> 
                    <div class='button'><button type='submit'   >Detaljnije</button></div>
                        </form>
                    <td>
                        <div class='button'><button type='submit' onclick='removeAccept(" . $kasting->IdKasting . ")'name='prihvati" . $kasting->IdKasting . "'>Prihvati</button></div>
                    </td>
                    <td>
             <div class='button'><button type='submit' onclick='removeReject(" . $kasting->IdKasting . ")' name='odbij" . $kasting->IdKasting . "'>Odbij</button></div>
                    </td>
                </td>
            </tr>
            </table>
        </div>";
            }
        }
        $string .= "</div></body></html>";

        $this->prikaz("pocetna_administrator.html", []);
        echo view("stranice/zahtevizakastinge.html", ["string" => $string]);
    }
/*
    Autor: Đorđe Milinović 0334/2018
    Prikazivanje spiska zahteva za registraciju reditelja. 
    Prikazuju se svi reditelji koji čekaju na odobrenje od strane administratora da naprave nalog.
    @return void
    */
   
    public function ZahteviZaReditelja() {
     
        $rediteljModel = new \App\Models\RediteljModel();
        $reditelji = $rediteljModel->where('Status', 'Na cekanju')->findAll();
        $string = "";

        if ($reditelji != null) {
            foreach ($reditelji as $reditelj) {
                $prihvati = "\"DirectorRequest('" . $reditelj->KorisnickoIme . "','prihvati')\"";
                $odbij = "\"DirectorRequest('" . $reditelj->KorisnickoIme . "','odbij')\"";
                $korisnikModel = new \App\Models\KorisnikModel();
                $korisnik = $korisnikModel->find($reditelj->KorisnickoIme);

                $string .= " <div id='" . $reditelj->KorisnickoIme . "' class='Director'>
            <table>
            <tr>
                
                <td>
                    <div class='TitleTheme'> Ime i Prezime: " . $korisnik->Ime . " " . $korisnik->Prezime . "</div>
                    <div class='TitleTheme'>Korisničko ime:" . $korisnik->KorisnickoIme . "</div>
                </td>
                <td>
             <div class='button'><button type='submit' onclick=" . $prihvati . ">Prihvati</button></div>
                </td>
                <td>
                    <div class='button'><button type='submit'  onclick=" . $odbij . ">Odbij</button></div>
                </td>
            </tr>
            </table>
        </div> ";
            }
        }
        $string .= "</div></body></html>";

        $this->prikaz("pocetna_administrator.html", []);
        echo view("stranice/zahtevizareditelja.html", ["string" => $string]);
    }
    

    /*
    Autor: Jelena Pančevski 0123/2018
    Promena statusa zahteva u Odbijen. 
    Poziva se nakon što administrator odluči da odbije određeni zahtev za kreiranje kastinga.
    @return void
    */
    public function OdbijKasting() {
        $IdKastinga = $_POST['IdKastinga'];
        $kastingModel = new \App\Models\KastingModel();
        $kastingModel->update($IdKastinga, ['Status' => 'Odbijen']);
    }
/*
    Autor: Jelena Pančevski 0123/2018
    Promena statusa zahteva u Prihvacen. 
    Poziva se nakon što administrator odluči da prihvati određeni zahtev za kreiranje kastinga.
    @return void
    */
    public function PrihvatiKasting() {
        $IdKastinga = $_POST['IdKastinga'];
        $kastingModel = new \App\Models\KastingModel();
        $kastingModel->update($IdKastinga, ['Status' => 'Prihvacen']);
    }
    /*
    Autor: Đorđe Milinović 0334/2018
    Metoda prihvatanja/odbijanja zahteva za registraciju reditelja.
    Nakon prihvatanja/odbijanja zahteva, korisniku se šalje mejl o statusu registracije.
    */

    public function PrihvatiOdbijReditelja() {
        $KorisnickoIme = $_POST['Reditelj'];
        $rediteljModel = new \App\Models\RediteljModel();
        $Odluka = $_POST['Odluka'];
        switch ($Odluka) {
            case "prihvati": $rediteljModel->update($KorisnickoIme, ['Status' => 'Prihvacen']);
                $registrovaniKorisnik = new \App\Models\RegistrovaniKorisnikModel();
                $mail = $registrovaniKorisnik->find($KorisnickoIme)->Email;
                mail($mail, 'Registracija na sajt', 'Prihvaceni ste.', []);
                break;
            case "odbij": $rediteljModel->update($KorisnickoIme, ['Status' => 'Odbijen']);
                #test
                $registrovaniKorisnik = new \App\Models\RegistrovaniKorisnikModel();
                $mail = $registrovaniKorisnik->find($KorisnickoIme)->Email;
                mail($mail, 'Registracija na sajt', 'Odbijeni ste.', []); #razne zagrade su jer tu idu parametri za header maila
                $rediteljModel->delete($KorisnickoIme);
                $registrovaniKorisnik->delete($KorisnickoIme);
                break;
        }
    }
/*
    Autor: Đorđe Milinović 0334/2018
    Omotač metoda koja poziva prikaz postojećih kastinga po kriterijumu:Televizija
    @return void
    */
    public function prikaziKastingeTelevizija() {
        $this->dohvatiKastingInfo(0, 3);
    }
    
/*
    Autor: Đorđe Milinović 0334/2018
    Omotač metoda koja poziva prikaz postojećih kastinga po kriterijumu:Pozorište
    @return void
    */
    public function prikaziKastingePozoriste() {
        $this->dohvatiKastingInfo(1, 3);
    }
  /*
    Autor: Đorđe Milinović 0334/2018
    Omotač metoda koja poziva prikaz svih postojećih kastinga
    @return void
    */
     public function prikaziSveKastinge() {
        $this->dohvatiKastingInfo(2, 3);
    }
    
      
    public function prikaziDodavanjeNoveTeme() {

        $this->prikaz("pocetna_administrator.html", []);
        echo view("stranice/dodajtemu.html", []);
    }
      /*Mihajlo Nikitovic
    fja za dodavanje nove teme u bazu i na forum*/
     
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
             $this->response->redirect(base_url('Administrator/prikaziTeme'));
       }
       
       /*Mihajlo Nikitovic
    fja za prikazivanje teme na forumu*/
     
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
        
}
