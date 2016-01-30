<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'Admin';

    protected $primaryKey = 'id_Admin';

    protected $fillable = ['access_token'];

    public $timestamps=false;
}
