<?php
namespace App\Models;

use CodeIgniter\DataCaster\Cast\TimestampCast;
use CodeIgniter\Model;

class VisiMisiModel extends Model
{
    protected $table = 'content_visi_misi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['judul', 'isi', 'created_at', 'updated_at'];
    public $timestamps = false;
}