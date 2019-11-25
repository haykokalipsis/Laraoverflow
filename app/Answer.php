<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['body', 'user_id'];

    // Relationships----------------------------------------------------------------------------------------------------
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Polymorphic Relationships----------------------------------------------------------------------------------------
    public function votes()
    {
        return $this->morphToMany(User::class, 'voteable');
    }

    // Accessors--------------------------------------------------------------------------------------------------------
    public function getBodyHtmlGetterAttribute()
    {
        return \Parsedown::instance()->text($this->body);
    }

    public function getCreatedDateGetterAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusGetterAttribute()
    {
        return $this->isBest() ? 'vote-accepted' : '';
    }

    public function getIsBestGetterAttribute()
    {
        return $this->isBest();
    }
    // Other-----------------------------------------------------------------------------------------------------------------
    public function isBest()
    {
        return $this->id === $this->question->best_answer_id;
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($answer) {
            $answer->question->increment('answers_count');
        });

        static::deleted(function ($answer) {
            $question = $answer->question;
            $question->decrement('answers_count');

            if ($question->best_answer_id === $answer->id) {
                $question->best_answer_id = null;
                $question->save();
            }

            // Or make the foreign key option in questions migration and leave this code as methods only needed code.
            // $answer->question->decrement('answers_count');
        });

        static::saved(function ($answer) {
            echo "Answer saved\n";
        });
    }

    public function downVotes()
    {
        return $this->votes()->wherePivot('vote', -1);
    }

    public function upVotes()
    {
        return $this->votes()->wherePivot('vote', 1);
    }
}
