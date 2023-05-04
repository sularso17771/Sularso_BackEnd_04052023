<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customers extends Model
{
    use HasFactory;

    protected $guarded      = [];

    protected $appends      = ['total'];

    protected $table        = 'customers';

    public $timestamps      = true;   

    public function transaction()
    {
        return $this->hasMany('App\Models\Transactions','customer_id','id');
    }        

    public function getTotalAttribute()
    {
        // Init variable amount point
        $amount_point = 0;

        foreach ($this->transaction as $key) 
        {
            // Count amount point based on type
            switch ($key->description) 
            {
                case 'Beli Pulsa':
                    if ($key->Amount > 10000 && $key->Amount <= 30000) 
                    {
                        $amount_point = floor(($key->Amount - 10000) / 1000) + 1;
                    } 
                    elseif ($key->Amount > 30000) 
                    {
                        $amount_point = floor(($key->Amount - 30000) / 1000) * 2 + 11;
                    }
                    break;
                case 'Bayar Listrik':
                    if ($key->Amount > 50000 && $key->Amount <= 100000) 
                    {
                        $amount_point = floor(($key->Amount - 50000) / 2000) + 1;
                    } 
                    elseif ($key->Amount > 100000) 
                    {
                        $amount_point = floor(($key->Amount - 100000) / 2000) * 2 + 26;
                    }
                    break;
            }       
        }
        return $amount_point; 
    }
}
