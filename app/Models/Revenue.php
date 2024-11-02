<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    use HasFactory;

    protected $table = 'revenues';

    protected $fillable = [
        'artist_name',
        'revenue_amount',
        'revenue_month',
        'status',
        'tf_img_file_path'
    ];
    

    public function getAmountAttribute($value)
    {
        return number_format($value, 2); // Mengembalikan nilai dengan 2 desimal
    }

    public function setAmountAttribute($value)
    {
        $this->attributes['revenue_amount'] = round($value, 2); // Menyimpan nilai dengan 2 desimal
    }

    public static function getPaidRevenueTotal(): string
{
    $total = static::where('status', 'transferred')->sum('revenue_amount');
    return '$' . number_format($total, 2); // Memformat sebagai mata uang dengan 2 angka desimal
}

public static function getPendingRevenueTotal(): string
{
    $total = static::where('status', 'waiting')->sum('revenue_amount');
    return '$' . number_format($total, 2); // Memformat sebagai mata uang dengan 2 angka desimal
}
}
