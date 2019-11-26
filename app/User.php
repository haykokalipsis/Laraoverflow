<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Relationships--------------------------------------------------------------------------------------------------------
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function favourites()
    {
        return $this->belongsToMany(Question::class, 'favourites')->withTimestamps();
    }

    // Polymorphic Relationships----------------------------------------------------------------------------------------
    public function voteQuestions()
    {
        return $this->morphedByMany(Question::class, 'voteable');
    }

    public function voteAnswers()
    {
        return $this->morphedByMany(Answer::class, 'voteable');
    }

    // Accessors--------------------------------------------------------------------------------------------------------
    public function getAvatarGetterAttribute()
    {
        $email = $this->email;
        $size = 32;

        return  "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;
    }

    // Other------------------------------------------------------------------------------------------------------------
    public function voteQuestion(Question $question, $vote)
    {
        $voteQuestions = $this->voteQuestions();
        $this->_vote($voteQuestions, $question, $vote);
    }

    public function voteAnswer(Answer $answer, $vote)
    {
        $voteAnswers = $this->voteAnswers();
        $this->_vote($voteAnswers, $answer, $vote);
    }

    private function _vote($relationship, $model, $vote)
    {
        if ($relationship->where('voteable_id', $model->id)->exists()) {
            $relationship->updateExistingPivot($model, ['vote' => $vote]);
        } else {
            $relationship->attach($model,['vote' => $vote]);
        }

        $model->load('votes'); // Refresh the relationship, since we just changed the table
        $downVotes = (int) $model->downVotes()->sum('vote');
        $upVotes = (int) $model->upVotes()->sum('vote');
        $model->votes_count = $upVotes + $downVotes;

        $model->save();
    }


}
