<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = 
    [
    'name',
    'email',
    'phone',
    'address',
    'nationality',
    'ID_number',
    'company_name',
    'notes',
    'user_id',
    'customer_category_id'
];

public function user()
{
    return $this->belongsTo(User::class);
}

public function cases()
{
    return $this->hasMany(Issue::class);
}
public function casess()
{
    return $this->belongsTo(Issue::class);
}

public function category()
{
    return $this->belongsTo(CustomerCategory::class, 'customer_category_id');
}
}
