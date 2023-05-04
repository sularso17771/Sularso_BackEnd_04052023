<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transactions extends Model
{
    use HasFactory;

    protected $guarded      = [];

    protected $table        = 'transactions';

    public $timestamps      = false;   

    public function customer()
    {
        return $this->belongsTo('App\Models\Customers','customer_id','id');
    }        
}
