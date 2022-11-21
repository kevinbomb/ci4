<?php
namespace App\Models;
use CodeIgniter\Model;
class Modelupcoming extends Model
{
protected $table = 'upcoming';
protected $primaryKey = 'id';
protected $allowedFields = [
'id','judul','direktur','tanggal','sinopsis'
];
}