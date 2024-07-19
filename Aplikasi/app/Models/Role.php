<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TargetResponden;

class Role extends Model
{
    use HasFactory;
    protected $table = "roles";

    public function targetRespondens()
    {
        return $this->belongsToMany(TargetResponden::class);
    }
}
