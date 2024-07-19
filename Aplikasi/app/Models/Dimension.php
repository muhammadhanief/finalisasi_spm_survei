<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Question;
use App\Models\Subdimension;
use Spatie\Permission\Traits\HasRoles;

class Dimension extends Model
{
    use HasFactory;
    use HasRoles;
    protected $guard_name = 'web';
    protected $table = 'dimensions';
    protected $fillable = ['name', 'description'];

    public function subdimensions()
    {
        return $this->hasMany(Subdimension::class);
    }
}
