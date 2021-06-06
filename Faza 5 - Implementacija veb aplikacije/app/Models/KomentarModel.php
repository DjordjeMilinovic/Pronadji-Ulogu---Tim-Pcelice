<?php

namespace App\Models;

use CodeIgniter\Model;

class KomentarModel extends Model
{
    protected $table      = 'Komentar';
    protected $primaryKey = 'IdKom';

     protected $useAutoIncrement = true;

    protected $returnType     = 'object';
   

    protected $allowedFields = ['KorisnickoIme', 'IdTema', 'Tekst', 'Datum'];

   
}

