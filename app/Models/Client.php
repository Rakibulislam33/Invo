<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    // protected $fillable  = ['name', 'email'];
    protected $guarded = ['id','created_at', 'updated_at'];


    public function tasks()
    {
        return $this->hasMany(Task::class,'client_id','id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class,'client_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
