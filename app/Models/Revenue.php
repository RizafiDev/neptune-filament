<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    use HasFactory;


    

    protected $fillable = ['revenue_amount'];

    public function getAmountAttribute($value)
    {
        return number_format($value, 2); // Mengembalikan nilai dengan 2 desimal
    }

    public function setAmountAttribute($value)
    {
        $this->attributes['revenue_amount'] = round($value, 2); // Menyimpan nilai dengan 2 desimal
    }
}


