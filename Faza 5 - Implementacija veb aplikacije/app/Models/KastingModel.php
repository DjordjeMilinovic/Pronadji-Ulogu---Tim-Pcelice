<?php

/* Autor: Jelena Pančevski 0123/2018
 */

namespace App\Models;

use CodeIgniter\Model;

/* KastingModel – klasa za pristup informacijama iz tabele Kasting
  @version 1.0 */

class KastingModel extends Model {

    protected $table = 'Kasting';
    protected $primaryKey = 'IdKasting';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $allowedFields = ['KorisnickoIme', 'Naziv', 'Opis', 'BrojGlumaca', 'BrojStatista', 'Kategorija', 'Status'];
/* Autor: Jelena Pančevski 0123/2018
    Metoda koja vraca sve kastinge koji su prihvaceni odredjene kategorije (Film/Pozoriste/Oba). 
    Metoda se koristi pri pozivu metode za pregled svih kastinga
    @return Niz svih kastinga pronadjenih u bazi koji odgovaraju gore navedenim uslovima
 */
    public function SviKastinzi($Kategorija) {
        switch($Kategorija){
            case "Pozoriste": case "Film":return $this->where(['Kategorija'=>$Kategorija,'Status'=>'Prihvacen'])->findAll();
            break;
            default:return $this->where('Status','Prihvacen')->findAll();
            break;
        }
       
    }
/* Autor: Jelena Pančevski 0123/2018
    Metoda koja vraca sve kastinge koji su prihvaceni odredjene kategorije (Film/Pozoriste/Oba) i kojima je BrojGlumaca >0. 
    Metoda se koristi pri pozivu metode za pregled svih kastinga
    @return Niz svih kastinga pronadjenih u bazi koji odgovaraju gore navedenim uslovima
 */
    public function GlumciKastinzi($Kategorija) {
        switch($Kategorija){
      case "Pozoriste": case "Film":   return $this->where(['Kategorija'=>$Kategorija,'Status'=>'Prihvacen','BrojGlumaca >'=>'0'])->findAll();
        break;
      default:return $this->where(['Status'=>'Prihvacen','BrojGlumaca >'=>'0'])->findAll();
          break;
        }
    }
/* Autor: Jelena Pančevski 0123/2018
    Metoda koja vraca sve kastinge koji su prihvaceni odredjene kategorije (Film/Pozoriste/Oba) i kojima je BrojStatista >0. 
    Metoda se koristi pri pozivu metode za pregled svih kastinga
    @return Niz svih kastinga pronadjenih u bazi koji odgovaraju gore navedenim uslovima
 */
    public function StatistiKastinzi($Kategorija) {
        switch($Kategorija){
    
       case "Pozoriste": case "Film":  return $this->where(['Kategorija'=>$Kategorija,'Status'=>'Prihvacen','BrojStatista >'=>'0'])->findAll();
        break;
    default:return $this->where(['Status'=>'Prihvacen','BrojStatista >'=>'0'])->findAll();
          break;
        }
    }

}
