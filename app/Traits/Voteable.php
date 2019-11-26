<?php


namespace App\Traits;


use App\User;

trait Voteable
{
    // Polymorphic Relationships----------------------------------------------------------------------------------------
    public function votes()
    {
        return $this->morphToMany(User::class, 'voteable');
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
