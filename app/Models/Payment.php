<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = ['amount', 'date', 'title', 'case_id', 'method'];
    public function case()
    {
        return $this->belongsTo(Issue::class, 'case_id');
    }
}
