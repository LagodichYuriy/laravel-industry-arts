<?php

namespace App\Http\Requests\API;

use App\Http\Requests\ApiRequest;
use App\Misc\Math\Quizzes\TripletQuiz;

class QuizzesTripletRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            TripletQuiz::PARAM_A => 'required|integer|min:' . TripletQuiz::PARAM_ANY_MIN . '|max:' . TripletQuiz::PARAM_ANY_MAX,
            TripletQuiz::PARAM_B => 'required|integer|min:' . TripletQuiz::PARAM_ANY_MIN . '|max:' . TripletQuiz::PARAM_ANY_MAX,
            TripletQuiz::PARAM_C => 'required|integer|min:' . TripletQuiz::PARAM_ANY_MIN . '|max:' . TripletQuiz::PARAM_ANY_MAX,
        ];
    }
}
