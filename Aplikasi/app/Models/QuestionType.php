<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Question;

class QuestionType extends Model
{
    use HasFactory;

    protected $table = 'question_types';
    protected $fillable = ['name'];

    /**
     * The sections of the dimension.
     *
     * @return HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
