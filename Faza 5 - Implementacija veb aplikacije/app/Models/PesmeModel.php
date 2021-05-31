<?php
/*Autor: Jelena Pančevski 0123/2018
 */
namespace App\Models;

use CodeIgniter\Model;
/*PesmeModel – klasa za pristup informacijama iz tabele Pesma
 @version 1.0*/
class PesmeModel extends Model
{
    protected $table      = 'Pesma';
    protected $primaryKey = 'IdSadrzaj';
    protected $useAutoIncrement = true;
    protected $returnType     = 'object';
    protected $allowedFields = ['Naziv', 'Autor','Vrsta', 'IdSadrzaj'];
  
}
