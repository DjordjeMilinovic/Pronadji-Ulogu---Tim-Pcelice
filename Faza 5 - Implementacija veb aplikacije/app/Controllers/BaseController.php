<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
/* BaseController – klasa za obradu funkcionalnosti koje su zajedničke za sve korisnike
  @version 1.0 */
class BaseController extends Controller {

    /**
     * Instance of the main Request object.
     *
     * @var IncomingRequest|CLIRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['url', 'form', 'html'];

    /**
     * Constructor.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param LoggerInterface   $logger
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        $this->session = \Config\Services::session();
    }

    /*
      Autor: Đorđe Milinović 0334/2018
      Metoda koja poziva dohvatanje kastinga korišćenjem odgovarajućeg filtra.
      @return void
     */
    public function FiltriranjeKastinga(){
        $tip=$_POST['Tip'];
        $uloga= $_POST['ActorType'];
        $controller=$_POST["Controller"]; 
        $prijava;
        switch($controller){
        case "RegistrovaniKorisnik": $prijava=1;
            break;
        case "Gost":$prijava=0;
            break;
        case "Reditelj":$prijava=2;
            break;
        case "Administrator":$prijava=3;
            break;
        }
        
        switch ($tip) {
            case 0:
                $tip='Film';
                break;
            case 1:
                $tip='Pozoriste';
                break;
            case 2:
                $tip='Sve';
                break;
        }

        $string= $this->dohvatiKastinge($tip, $prijava, $uloga,$controller);
        print($string);
    }
    /*
      Autor: Đorđe Milinović 0334/2018
      Metoda koja dohvata kastinge odgovarajućeg tipa(Film/Pozorište), prijave (RegistrovaniKorisnik/ostali), uloga(Glumac/Statista/Oba)
      @return string
     */
    public function dohvatiKastinge($tip, $prijava, $uloga,$controler){
         $kastingdetaljnije = base_url($controler . "/kastingdetaljnije");
        $kastingModel = new \App\Models\KastingModel();
        $kastinzi;
        $uslovi;
        switch ($uloga) {
            case 0: $kastinzi= $kastingModel->SviKastinzi($tip);
                break;
            case 1:
                $kastinzi = $kastingModel->GlumciKastinzi($tip);
                break;
            case 2:
                $kastinzi = $kastingModel->StatistiKastinzi($tip);
                break;
        }

        $string = "";
        if ($kastinzi != null) {
            foreach ($kastinzi as $kasting) {
                $korisnikModel = new \App\Models\KorisnikModel();
                $reditelj = $korisnikModel->find($kasting->KorisnickoIme);

                $string .= " 
                    <br>
                    <br>
<div id=" . $kasting->IdKasting . " class='div_class'>
<table>
<tr>
<td> <img class='image' src='/files/images/castings/" . $kasting->IdKasting . ".jpg'onerror=\"this.src='/files/images/alt/casting.png';\"></td>
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
 <form  class='button' method='post' action=\"" . $kastingdetaljnije . "\" >
                <input type='text' hidden name='IdKastinga' value='" . $kasting->IdKasting . "'><button  type='submit'>Detaljnije</button></form>
";
                if ($prijava < 2) {
                    //treba i
                    $string .= "<td><form action='' class = 'button' >
                           <button type = 'submit' onclick = 'removeAccept(" . $kasting->IdKasting . ")'name = 'prihvati" . $kasting->IdKasting . "'>Priavi se</button>
                        </form></td>";
                }

                $string .= "
</td>
</tr>
</table>
</div>";
            }
        }

        return $string;
    }
    public function dohvatiKastingInfo($tip, $prijava, $uloga) {
        $kor = $this->session->get("Korisnik");
        $controler;
        if ($kor != null) {
            $rediteljModel = new \App\Models\RediteljModel();
            $korisnikModel = new \App\Models\RegistrovaniKorisnikModel();

            if ($rediteljModel->find($kor->KorisnickoIme))
                $controler = "Reditelj";
            else if ($korisnikModel->find($kor->KorisnickoIme))
                $controler = "RegistrovaniKorisnik";
            else
                $controler = "Administrator";
        } else
            $controler = "Gost";
        $kastingdetaljnije = base_url($controler . "/kastingdetaljnije");
        $kastingModel = new \App\Models\KastingModel();
        $kastinzi;
        $uslovi;
        switch ($tip) {
            case 0:
//tv
                $uslovi = ['Status' => 'Prihvacen', 'Kategorija' => 'Film'];
                $kastinzi = $kastingModel->where($uslovi)->findAll();
                break;
            case 1:
//pozoriste
                $uslovi = ['Status' => 'Prihvacen', 'Kategorija' => 'Pozoriste'];
                $kastinzi = $kastingModel->where($uslovi)->findAll();
                break;
            case 2:
//oba
                $kastinzi = $kastingModel->where('Status', 'Prihvacen')->findAll();
                break;
        }
        $string = "";
        if ($kastinzi != null) {
            foreach ($kastinzi as $kasting) {
                $korisnikModel = new \App\Models\KorisnikModel();
                $reditelj = $korisnikModel->find($kasting->KorisnickoIme);

                $string .= " 
                    <br>
                    <br>
<div id=" . $kasting->IdKasting . " class='div_class'>
<table>
<tr>
<td> <img class='image' src='/files/images/castings/" . $kasting->IdKasting . ".jpg'onerror=\"this.src='/files/images/alt/casting.png';\"></td>
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
 <form  class='button' method='post' action=\"" . $kastingdetaljnije . "\" >
                <input type='text' hidden name='IdKastinga' value='" . $kasting->IdKasting . "'><button  type='submit'>Detaljnije</button></form>
";
                if ($prijava < 2) {
                    //treba i
                    $string .= "<td><form action='' class = 'button' >
                           <button type = 'submit' onclick = 'removeAccept(" . $kasting->IdKasting . ")'name = 'prihvati" . $kasting->IdKasting . "'>Priavi se</button>
                        </form></td>";
                }

                $string .= "
</td>
</tr>
</table>
</div>";
            }
        }

        switch ($prijava) {
            case 0:
                $this->prikaz("pocetna_gost.html", []);
                echo view("stranice/pregledKastinga.html", ["string" => $string,'Tip'=>$tip,'controller'=>$controler]);
                break;
            case 1:
                $this->prikaz("pocetna_korisnik.html", []);
                echo view("stranice/pregledKastinga.html", ["string" => $string,'Tip'=>$tip,'controller'=>$controler]);
                break;
            case 2:
                $this->prikaz("pocetna_reditelj.html", []);
                echo view("stranice/pregledKastinga.html", ["string" => $string,'Tip'=>$tip,'controller'=>$controler]);
                break;
            case 3:
                $this->prikaz("pocetna_administrator.html", []);
                echo view("stranice/pregledKastinga.html", ["string" => $string,'Tip'=>$tip,'controller'=>$controler]);
                break;
        }
    }

    /*
      Autor: Đorđe Milinović 0334/2018
      Prikazivanje stranice sa detaljnim opisom odgovarajućeg kastinga
      @return void
     */

    public function kastingdetaljnije() {
        if($this->request->getVar('IdKastinga')==null) {
            return redirect()->to('/');
        }
        $IdKastinga = $_POST["IdKastinga"];
        $kastingModel = new \App\Models\KastingModel();
        $Kasting = $kastingModel->find($IdKastinga);
        $korisnikModel = new \App\Models\KorisnikModel();
        $Reditelj = $korisnikModel->find($Kasting->KorisnickoIme);
        $string = "   

        <div id='List'>

        <div class ='castingPicture'>
            <img src='/files/images/castings/" . $IdKastinga . ".jpg 'onerror=\"this.src='/files/images/alt/casting.png';\">
        </div>

        <div class='castingDetails'>
            <table>
                <tr>
                
                    <td>" . $Kasting->Naziv . "
                    </td>
                </tr>
                <tr>
                    <td>" . $Reditelj->Ime . " " . $Reditelj->Prezime . "</td>
                </tr>
            </table>
        </div>

        <div class = 'type'>
            <table>
                <tr>
                    <td>Kategorija:" . $Kasting->Kategorija . "</td>
                </tr>
                <tr>
                    <td>Glumci: " . $Kasting->BrojGlumaca . "</td>
                </tr>
                <tr>
                    <td>Statisti: " . $Kasting->BrojStatista . "</td>
                </tr>
            </table>
        </div>

        
        

        <div class = 'description'>
            " . $Kasting->Opis . "
        </div>

    </div></body>
</html>";
        $kor = $this->session->get("Korisnik");
        $controler;
        if ($kor != null) {
            $rediteljModel = new \App\Models\RediteljModel();
            $korisnikModel = new \App\Models\RegistrovaniKorisnikModel();

            if ($rediteljModel->find($kor->KorisnickoIme))
                $controler = "Reditelj";
            else if ($korisnikModel->find($kor->KorisnickoIme))
                $controler = "RegistrovaniKorisnik";
            else
                $controler = "Administrator";
        } else
            $controler = "Gost";
        switch ($controler) {
            case "Administrator": $this->prikaz("pocetna_administrator.html", []);
                break;
            case "RegistrovaniKorisnik": $this->prikaz("pocetna_korisnik.html", []);
                break;
            case "Reditelj": $this->prikaz("pocetna_reditelj.html", []);
                break;
            case "Gost": $this->prikaz("pocetna_gost.html", []);
                break;
        }

        echo view("stranice/detaljnijiKasting.html", ["string" => $string]);
    }

}
