<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    //
    protected $table = 'patients';
    protected $primaryKey = 'id_no';
    public $timestamp = false;
}
