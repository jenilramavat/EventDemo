<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recurrence extends Model
{

    protected $connection="mysql";
    protected $fillable=[];
    protected $guarded=array('RecurrenceID');
    protected $table='tblRecurrence';
    public $primaryKey = "RecurrenceID";
}
