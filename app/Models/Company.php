<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    //
 use HasFactory;
     //columns that need filling
    protected $fillable = ['name','postcode'];
    public $timestamps = false;

    //Reference one company has many contacts
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }
}
