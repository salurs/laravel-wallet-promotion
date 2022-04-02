<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionCode extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['amount', 'quota', 'status', 'start_date', 'end_date', 'code'];

    public function scopeIsValidCode($query)
    {
        return $query->where('status', true)->where('quota', '>', 0)->where('start_date', '<=', now())->where('end_date', '>=', now());
    }

    public function getStartDateAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i');
    }

    public function getEndDateAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
