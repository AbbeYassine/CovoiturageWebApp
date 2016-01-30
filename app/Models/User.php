<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'User';

    protected $primaryKey = 'id_User';

    protected $fillable = ['identifiant','nom','prenom','telephone','link','active','login','password'];

    public $timestamps=false;
}
