<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Utils;
use Illuminate\Support\Facades\Storage;
use App\Models\Question;
use App\Models\Answer;

class QuestionAnswerController extends Controller
{
    public function index()
    {

        $questions = Question::with('answers')->get();

        return response()->json($questions);
    }

    public function store(Request $request)
    {
        $request->validate([
            "question" => "required"
        ]);

        $question = new Question();

        $question->user_id = $request->user_id;
        $question->question = $request->question;
        $question->save();

        //return a json response
        return response()->json([
            "status" => "success",
            "message" => "Question posted successfully",
            "question" => $question
        ]);
    }


    public function show($id)
    {

        $answers = Answer::where('question_id', $id)->get();
        $question = Question::find($id)->question;

        return response()->json([
            "status" => "success",
            "message" => "Question and Answers retrieved successfully",
            "question" => $question,
            "answers" => $answers,

        ]);
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
