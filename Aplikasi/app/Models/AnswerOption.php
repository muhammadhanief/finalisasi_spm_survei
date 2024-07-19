<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AnswerOptionValue;

class AnswerOption extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'type'];


    /**
     * The survey sections.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answeroptionvalues()
    {
        return $this->hasMany(AnswerOptionValue::class);
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
