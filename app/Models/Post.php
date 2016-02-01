<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'Post';

    protected $primaryKey = 'id_Post';

    protected $fillable = ['identifiant','message','type','date','nb_Places','source','destination','prix',
    'depart','telephone','id_Groups','id_User'];

    public $timestamps=true;
}
