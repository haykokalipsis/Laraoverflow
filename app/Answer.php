<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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

    //------------------------------------------------------------------------------------------------------------------
    public static function boot()
    {
        parent::boot();

        static::created(function ($answer) {
            $answer->question->increment('answers_count');
            $answer->question->save();
        });

        static::saved(function ($answer) {
            echo "Answer saved\n";
        });
    }
}
