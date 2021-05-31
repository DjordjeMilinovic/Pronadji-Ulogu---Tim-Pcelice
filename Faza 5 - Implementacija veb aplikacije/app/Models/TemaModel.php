<?php

namespace App\Models;

use CodeIgniter\Model;

class TemaModel extends Model
{
    protected $table      = 'tema';
    protected $primaryKey = 'IdTema';

     protected $useAutoIncrement = true;

    protected $returnType     = 'object';
   

    protected $allowedFields = ['KorisnickoIme', 'Naslov', 'KratakOpis', 'Tekst', 'Datum'];

   
}

