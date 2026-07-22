<?php

namespace App\Models;

use CodeIgniter\Model;

class PeriodeModel extends Model
{
    protected $table            = 'periode';
    protected $primaryKey       = 'id_periode';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['nama_periode', 'tahun'];
    protected $useTimestamps    = true; 
}