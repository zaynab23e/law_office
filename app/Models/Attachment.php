<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'file_path', 'file_type', 'case_id'];
    public function case()
    {
        return $this->belongsTo(Issue::class, 'case_id');
    }
    
}
