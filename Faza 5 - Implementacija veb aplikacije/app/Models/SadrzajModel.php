<?php
/*Autor: Jelena Pančevski 0123/2018
 */
namespace App\Models;

use CodeIgniter\Model;
/*SadrzajModel – klasa za pristup informacijama iz tabele Sadrzaj
 @version 1.0*/
class SadrzajModel extends Model
{
    protected $table      = 'Sadrzaj';
    protected $primaryKey = 'IdSadrzaj';
    protected $useAutoIncrement = true;
    protected $returnType     = 'object';
    protected $allowedFields = ['KorisnickoIme'];

   public function SadrzajKorisnika($KorisnickoIme){
      return $this->where('KorisnickoIme',$KorisnickoIme)->findAll();
   }
}
