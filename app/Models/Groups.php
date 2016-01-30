<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    protected $table = 'Groups';

    protected $primaryKey = 'id_Groups';

    protected $fillable = ['identifiant','nom'];

    public $timestamps=false;
}
