<?php
/*Autor: Jelena Pančevski 0123/2018
 */
namespace App\Models;

use CodeIgniter\Model;
/*MonologModel – klasa za pristup informacijama iz tabele Monolog
 @version 1.0*/
class MonologModel extends Model
{
    protected $table      = 'Monolog';
    protected $primaryKey = 'IdSadrzaj';
    protected $useAutoIncrement = true;
    protected $returnType     = 'object';
    protected $allowedFields = ['Delo', 'Autor','Vrsta','IdSadrzaj'];
   
}
