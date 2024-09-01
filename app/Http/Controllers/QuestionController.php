<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Support\Facades\Auth;
use Encore\Admin\Auth\Database\Administrator;



class QuestionController extends Controller
{
    //function to store question
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
            "message" => "Question submitted successfully"
        ]);
        
    }

    //function to get all questions and their associated answers
    public static function get_questions()
    {
        $questions = Question::with('answers')->get();
        //get the authenticated user
        $user_id = Auth::user()->id;

        return view('farmers-forum.chat', compact('questions', 'user_id'));
    }

    //function to submit answers
    public function answers(Request $request)
    {
        $request->validate([
            "answer" => "required"
        ]);

        $answer = new Answer();
    
        $answer->question_id = $request->question_id;
        $answer->user_id = $request->user_id;
        $answer->answer = $request->answer;
        $answer->save();

        //return a json response
        return response()->json([
            "status" => "success",
            "message" => "Answer submitted successfully"
        ]);
        
    }

    //function to get all answers for a particular question
    public static function question_answers($id)
    {
        $answers = Answer::where('question_id', $id)->get();
        $question = Question::find($id)->question;

     
        return view('farmers-forum.answers', compact('answers', 'question'));
    }
}
