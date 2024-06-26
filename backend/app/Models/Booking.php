<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'booking';

    protected $appends = ['total_price'];
    protected $fillable = [
        'id','user_id',
        'total_price', 'duration', 'status','check_in','check_out'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function book_details()
    {
        return $this->hasMany(BookDetail::class, 'book_id');
    }
    public function getTotalPriceAttribute()
    {
        return $this->book_details()->sum('price');
    }

    public function getHotelNameAttribute()
    {
        return $this->book_details->first()->roomType->hotel->name;
    }
    public function getFullName($firstName, $lastName) {
    $fullName = trim(($firstName ?? '') . ' ' . ($lastName ?? ''));

    if (empty($firstName) && !empty($lastName)) {
        return trim($lastName);
    }
    if (!empty($firstName) && empty($lastName)) {
        return trim($firstName);
    }

    return $fullName;
}



}
