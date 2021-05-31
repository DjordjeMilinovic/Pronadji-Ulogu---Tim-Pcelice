<?php
/*Autor: Jelena Pančevski 0123/2018
 */
namespace App\Models;

use CodeIgniter\Model;
/*RediteljModel – klasa za pristup informacijama iz tabele Reditelj
 @version 1.0*/
class RediteljModel extends Model
{
    protected $table      = 'Reditelj';
    protected $primaryKey = 'KorisnickoIme';
    protected $useAutoIncrement = true;
    protected $returnType     = 'object';
    protected $allowedFields = ['Lozinka','DatumRodjenja','Ime','Prezime','Email','Status','KorisnickoIme'];

}
