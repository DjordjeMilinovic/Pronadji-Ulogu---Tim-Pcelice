<?php

/*Autor:Đorđe Milinović 0334/2018
 */

namespace App\Models;

use CodeIgniter\Model;

/* PrijavaModel – klasa za pristup informacijama iz tabele Prijava
  @version 1.0 */

class PrijavaModel extends Model {

    protected $table = 'Prijava';
    protected $primaryKey =  'IdKasting';
    //protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $allowedFields = ['KorisnickoIme', 'IdKasting', 'Status'];
    
    /* Autor:Đorđe Milinović 0334/2018
      Metoda koja prihvata kandidatovu prijavu za odre�eni kasting.
      @return void */
    public function prihvatiPrijavu($KorisnickoIme, $IdKasting){
       
      $this->update(['KorisnickoIme'=>$KorisnickoIme, 'IdKasting'=> $IdKasting], ['Status' => 'Prihvacen']);
    }
    /* Autor:Đorđe Milinović 0334/2018
      Metoda koja odbija kandidatovu prijavu za odre�eni kasting.
      @return void */
     public function odbijPrijavu($KorisnickoIme, $IdKasting){
       
      $this->update(['KorisnickoIme'=>$KorisnickoIme, 'IdKasting'=> $IdKasting], ['Status' => 'Odbijen']);
    }
}

