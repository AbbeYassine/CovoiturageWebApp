<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable
{
	use \Illuminate\Auth\Authenticatable;

    protected $table = 'User';

    protected $primaryKey = 'id_User';

    protected $fillable = ['identifiant','nom','prenom','telephone','link','active','login','password'];

    public $timestamps=false;
}