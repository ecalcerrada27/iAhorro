<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function expert()
    {
        return $this->belongsTo(Expert::class, 'expert_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getter(): array
    {
        return [
            "id" => $this->id,
            'name' => $this->user->name,
            'last_name' => $this->user->last_name,
            'email' => $this->user->email,
            'phone' => $this->user->phone,
            'net_income' => $this->user->net_income,
            'requested_quantity' => $this->requested_quantity,
            'comunication_time' => $this->comunication_time,
            'created_at' => $this->created_at
        ];
        
    }
}
