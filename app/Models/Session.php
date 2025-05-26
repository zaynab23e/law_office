<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;
    protected $fillable =['title','description','date','case_id','reminder_sent'];

    public function case()
    {
        return $this->belongsTo(Issue::class);
    }
}
