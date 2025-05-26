<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;
    protected $fillable = [
    'customer_id',
    'opponent_name',
    'opponent_type',
    'opponent_phone',
    'opponent_address',
    'opponent_nation',
    'opponent_lawyer',
    'lawyer_phone',
    'court_name',
    'circle',
    'case_number',
    'case_title',
    'attorney_number',
    'register_date',
    'judge_name',
    'contract_price',
    'paid_fees',            // أضف هذا
    'remaining_fees',       // وأضف هذا
    'notes',
    'case_category_id',
];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function category()
    {
        return $this->belongsTo(CaseCategory::class, 'case_category_id');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class, 'case_id');
    }
    public function sessions()
    {
        return $this->hasMany(Session::class, 'case_id');
    }
    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'case_id');
    }
    public function expenses()
    {
        return $this->hasMany(CaseExpense::class, 'case_id');
    }
}
