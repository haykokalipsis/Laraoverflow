<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['title', 'body'];

    // Relationships----------------------------------------------------------------------------------------------------
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    // Accessors & mutators---------------------------------------------------------------------------------------------
    public function setTitleAttribute(String $value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }

    public function getUrlGetterAttribute()
    {
        return route('questions.show', $this->slug);
    }

    public function getCreatedDateGetterAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusGetterAttribute()
    {
        if ($this->answers_count > 0) {
            if ($this->best_answer_id) {
                return 'answer-accepted';
            }

            return'answered';
        }

        return 'unanswered';
    }

    public function getBodyHtmlGetterAttribute()
    {
        return \Parsedown::instance()->text($this->body);
    }

    //------------------------------------------------------------------------------------------------------------------
    public function acceptBestAnswer(Answer $answer)
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }
}
