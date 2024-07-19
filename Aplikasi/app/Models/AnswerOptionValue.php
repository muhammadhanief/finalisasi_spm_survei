<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AnswerOption;

class AnswerOptionValue extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'answer_option_id', 'value'];

    public function answeroption()
    {
        return $this->belongsTo(AnswerOption::class, 'answer_option_id');
    }
}
