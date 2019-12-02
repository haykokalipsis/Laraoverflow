<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question, Request $request)
    {
        $request->validate([
            'body' => 'required'
        ]);

        $question->answers()->create([
            'body' => $request->input('body'),
            'user_id' => auth()->id()
        ]);

        return redirect()->back()->with('success', 'Your answer has been submitted successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);

        return view('answers.edit', compact(['question', 'answer']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);

        $answer->update($request->validate([
            'body' => 'required'
        ]));

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Your answer has been updated.',
                'bodyHtml' => $answer->full_body_html_getter,
            ], 200);
        }

        return redirect()->route('questions.show', $question->slug)->withSuccess('Your answer has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Answer $answer)
    {
        // Question here is useless, but i leave it to follow uri pattern

        $this->authorize('delete', $answer);
        $answer->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'message' => 'Your answer has been deleted'
            ]);
        }

        return redirect()->back()->withSuccess('Your answer has been deleted');
    }

    public function acceptBestAnswer(Answer $answer)
    {
        $this->authorize('accept', $answer);
        $answer->question->acceptBestAnswer($answer);

        if (request()->expectsJson()) {
            return response()->json([
                'message' => 'You have accepted this answer as best answer'
            ], 200);
        }

        return redirect()->back();
    }
}
