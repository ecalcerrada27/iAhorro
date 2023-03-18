<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expert extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function registers()
    {
        return $this->hasMany(Register::class);
    }

    public function getter(): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name
        ];
        
    }

}
