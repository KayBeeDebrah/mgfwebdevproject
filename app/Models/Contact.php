<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    //
     use HasFactory;
    //Enable soft delete
    use SoftDeletes;
      //fillable fields
    protected $fillable = ['firstname', 'lastname','email','company_id'];
    public $timestamps = false;

    //Each contact belongs to one company
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
