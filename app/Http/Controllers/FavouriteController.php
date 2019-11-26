<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Question $question)
    {
        $question->favourites()->attach(auth()->id());
        return back();
    }

    public function destroy(Question $question)
    {
        $question->favourites()->detach(auth()->id());
        return back();

        $user1->voteAnswers()->updateExistingPivot($answer1, ['vote' => -1]);
    }
}
