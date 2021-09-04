<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    protected $connection="mysql";
    protected $fillable=[];
    protected $guarded=array('EventID');
    protected $table='tblevent';
    public $primaryKey = "EventID";
}
