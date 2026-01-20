<?php
namespace App\Models;

use CodeIgniter\DataCaster\Cast\TimestampCast;
use CodeIgniter\Model;

class VisiMisiModel extends Model
{
    protected $table = 'content_visi_misi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['judul', 'isi'];
    protected $useTimestamps = true;
    
}