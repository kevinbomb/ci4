<?php
namespace App\Models;
use CodeIgniter\Model;
class Modeluser extends Model
{
protected $table = 'user';
protected $primaryKey = 'id';
protected $allowedFields = [
'id','email','username','password','tangalLahir', 'noTelepon'
];
}