<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseExpense extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'amount', 'date', 'case_id'];

    public function case()
    {
        return $this->belongsTo(Issue::class, 'case_id');
    }
}
