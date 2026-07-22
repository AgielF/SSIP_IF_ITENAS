<?php
namespace App\Models;
use CodeIgniter\Model;

class AsistenPeriodeModel extends Model
{
    protected $table            = 'asisten_periode';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id_user', 'id_periode', 'jabatan', 'status_tugas'];
    protected $useTimestamps    = true;
}