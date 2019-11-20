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

    // Accessors & mutators---------------------------------------------------------------------------------------------
    public function setTitleAttribute(String $value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }

    public function getUrlAttrAttribute()
    {
        return route('questions.show', $this->id);
    }

    public function getCreatedDateAttrAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttrAttribute()
    {
        if ($this->answers > 0) {
            if ($this->best_answer_id) {
                return 'answer-accepted';
            }

            return'answered';
        }

        return 'unanswered';
    }
}
