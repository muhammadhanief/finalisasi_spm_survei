<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;

class Subdimension extends Model
{
    use HasFactory;
    use HasRoles;
    protected $guard_name = 'web';
    protected $fillable = ['name', 'description', 'dimension_id'];

    /**
     * The sections of the dimension.
     *
     * @return HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function dimension()
    {
        return $this->belongsTo(Dimension::class, 'dimension_id');
    }
}
