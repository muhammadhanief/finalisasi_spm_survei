<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Entry;
use App\Models\QuestionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Model
{
    use HasFactory;
    /**
     * Answer constructor.
     *
     * @param  array  $attributes
     */
    // public function __construct(array $attributes = [])
    // {
    //     if (!isset($this->table)) {
    //         $this->setTable(config('survey.database.tables.answers'));
    //     }

    //     $this->casts['value'] = get_class(app(Value::class));

    //     parent::__construct($attributes);
    // }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['value', 'question_id', 'entry_id', 'question_type_id'];

    /**
     * The entry the answer belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entry()
    {
        return $this->belongsTo(Entry::class, 'entry_id');
    }

    /**
     * The question the answer belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function questionType()
    {
        return $this->belongsTo(QuestionType::class, 'question_type_id');
    }

    public function getAnswerValueAttribute($value)
    {
        $data = $this->question->answeroption->answeroptionvalues->where('value', $value)->first()->name;
        return $data;
    }
}
