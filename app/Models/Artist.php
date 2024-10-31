<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;
    protected $table = 'artists'; 
    protected $fillable = [
        'artist_name',
        'legal_name',
        'artist_avatar',
        'artist_idcard',
        'total_royalties',
        'total_releases',
    ];
}
