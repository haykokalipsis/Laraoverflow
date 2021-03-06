<?php

namespace App\Http\Controllers;

use App\Http\Requests\AskQuestionRequest;
use App\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        $questions = Question::with(['user'])->latest()->paginate(5);
        return view('questions.index', compact('questions'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AskQuestionRequest $request)
    {
        auth()->user()->questions()->create($request->all());
        return redirect()->route('questions.index')->with('success', 'Your question has been submitted');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $question->increment('views');
        return view('questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
//        if (\Gate::denies('update-question', $question))
//            abort(403, 'Access denied');

        $this->authorize('update', [Question::class, $question]);
        return view('questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(AskQuestionRequest $request, Question $question)
    {
        $question->update($request->only(['title', 'body']));

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Your question has been updated.',
                'title' => $question->title,
                'bodyHtml' => $question->full_body_html_getter,
            ], 200);
        }

        return redirect()->route('questions.index')->with('success', 'Your question has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
//        if (\Gate::denies('delete-question', $question))
//            abort(403, 'Access denied');

        $this->authorize('deletes', [Question::class, $question]);

        if (request()->expectsJson()) {
            return response()->json([
                'message' => 'Your question has been deleted.',
            ], 200);
        }

        $question->delete();
        return redirect()->route('questions.index')->withSuccess('Your question has been deleted.');
    }
}
