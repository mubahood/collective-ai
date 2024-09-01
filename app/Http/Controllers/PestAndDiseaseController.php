<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PestsAndDisease;
use Illuminate\Http\Request;
use App\Models\ExpertAnswer;
use Illuminate\Support\Facades\Auth;

class PestAndDiseaseController extends Controller
{
    //function to get questions and answers
    public static function index()
    {
    
        $questions = PestsAndDisease::with('expertAnswers')->get();
       
        return view('pests-and-diseases.questions', compact('questions'));
    }


    public function store(Request $request)
    {
        $request->validate([
            "question" => "required"
        ]);

        $question = new PestsAndDisease();
    
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
       
        $answers = ExpertAnswer::where('question_id', $id)->get();
        $question = PestsAndDisease::find($id)->question;

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

