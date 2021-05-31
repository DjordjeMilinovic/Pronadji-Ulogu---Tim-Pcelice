<?php
/*Autor: Jelena Pančevski 0123/2018
 */
namespace App\Models;

use CodeIgniter\Model;
/*AdministratorModel – klasa za pristup informacijama iz tabele Administrator
 @version 1.0*/
class AdministratorModel extends Model
{
    protected $table      = 'Administrator';
    protected $primaryKey = 'KorisnickoIme';
    protected $useAutoIncrement = true;
    protected $returnType     = 'object';
    protected $allowedFields = ['Lozinka','DatumRodjenja','Ime','Prezime','Email'];   
}