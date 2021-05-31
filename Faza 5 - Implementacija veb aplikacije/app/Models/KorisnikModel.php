<?php
/*Autor: Jelena Pančevski 0123/2018
 */
namespace App\Models;

use CodeIgniter\Model;
/*KorisnikModel – klasa za pristup informacijama iz tabele Korisnik
 @version 1.0*/
class KorisnikModel extends Model
{
    protected $table      = 'Korisnik';
    protected $primaryKey = 'KorisnickoIme';
    protected $useAutoIncrement = true;
    protected $returnType     = 'object';
    protected $allowedFields = ['Lozinka','DatumRodjenja','Ime','Prezime','Email'];
  
}