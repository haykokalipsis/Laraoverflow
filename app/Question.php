<?php

namespace App;

use App\Traits\Voteable;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use Voteable;

    protected $fillable = ['title', 'body'];
    protected $appends = ['created_date_getter', 'is_favourite_getter', 'favourites_count_getter', 'body_html_getter'];

    // Relationships----------------------------------------------------------------------------------------------------
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class)->orderBy('votes_count', 'DESC');
    }

    public function favourites()
    {
        return $this->belongsToMany(User::class, 'favourites')->withTimestamps();
    }

    // Accessors & mutators---------------------------------------------------------------------------------------------
    public function setTitleAttribute(String $value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }

// I prefer saving in db original body, and clean only when getting
//    public function setBodyAttribute($value)
//    {
//        $this->attributes['body'] = clean($value);
//    }

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
        return clean($this->bodyHtml());
    }

    public function getExcerptGetterAttribute()
    {
        return str_limit(strip_tags($this->bodyHtml()), 250);
    }

    public function getIsFavouriteGetterAttribute()
    {
        return $this->favourites()
                ->where('user_id', auth()->id())
                ->count() > 0;
    }

    public function getFavouritesCountGetterAttribute()
    {
        return $this->favourites->count();
    }

    // Other------------------------------------------------------------------------------------------------------------------
    public function acceptBestAnswer(Answer $answer)
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    private function bodyHtml()
    {
        return \Parsedown::instance()->text($this->body);
    }
}
