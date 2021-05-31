<?php
/*Autor: Jelena Pančevski 0123/2018
 */
namespace App\Models;

use CodeIgniter\Model;
/*RegistrovaniKorisnikModel – klasa za pristup informacijama iz tabele RegistrovaniKorisnik
 @version 1.0*/
class RegistrovaniKorisnikModel extends Model
{
    protected $table      = 'RegistrovaniKorisnik';
    protected $primaryKey = 'KorisnickoIme';
    protected $useAutoIncrement = true;
    protected $returnType     = 'object';
    protected $allowedFields = ['Lozinka','DatumRodjenja','Ime','Prezime','Email','KorisnickoIme'];

}