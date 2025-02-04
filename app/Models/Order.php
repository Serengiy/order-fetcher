<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'sergey_isaykin';
    protected $guarded = ['id'];
    public $timestamps = true;
}