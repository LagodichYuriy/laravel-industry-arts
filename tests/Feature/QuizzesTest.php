<?php

namespace Tests\Feature;

use App\Misc\Math\Quizzes\SquareQuiz;
use App\Misc\Math\Quizzes\TripletQuiz;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class QuizzesTest extends TestCase
{
    use DatabaseTransactions;

    public function testSquareQuiz()
    {
        $response = $this->post('/api/quizzes/square', [SquareQuiz::PARAM_N => SquareQuiz::PARAM_N_MIN - 1]);
        $response->assertUnprocessable();
        $response->assertJsonStructure(['errors' => [SquareQuiz::PARAM_N]]);

        $response = $this->post('/api/quizzes/square', [SquareQuiz::PARAM_N => SquareQuiz::PARAM_N_MAX + 1]);
        $response->assertUnprocessable();
        $response->assertJsonStructure(['errors' => [SquareQuiz::PARAM_N]]);

        $response = $this->post('/api/quizzes/square', [SquareQuiz::PARAM_N => 3]);
        $response->assertStatus(200);
        $response->assertJsonFragment(['number' => 3, 'value' => 22]); # (1 + 2 + 3)^2 = 36
                                                                       # 1^2 + 2^2 + 3^2 = 14
                                                                       # diff = 22


        $hitsBefore = data_get($response->decodeResponseJson(), 'data.occurrences');

        $response = $this->post('/api/quizzes/square', [SquareQuiz::PARAM_N => 3]); # repeat
        $response->assertStatus(200);

        $hitsAfter = data_get($response->decodeResponseJson(), 'data.occurrences');

        # DB logger test
        $this->assertTrue($hitsBefore + 1 == $hitsAfter);


        $response = $this->post('/api/quizzes/square', [SquareQuiz::PARAM_N => 5]);
        $response->assertStatus(200);
        $response->assertJsonFragment(['number' => 5, 'value' => 170]); # (1 + 2 + 3 + 4 + 5)^2 = 225
                                                                        # 1^2 + 2^2 + 3^2 + 4^2 + 5^2 = 55
                                                                        # diff = 170
    }

    public function testTripletQuiz()
    {
        $keys = [TripletQuiz::PARAM_A, TripletQuiz::PARAM_B, TripletQuiz::PARAM_C];

        $response = $this->post('/api/quizzes/triplet');
        $response->assertUnprocessable();
        $response->assertJsonStructure(['errors' => $keys]);

        $response = $this->post('/api/quizzes/triplet', array_combine($keys, [1, 1, 1]));
        $response->assertStatus(200);
        $response->assertJsonFragment(['is_pythagorean' => false, 'n' => 1]);

        $response = $this->post('/api/quizzes/triplet', array_combine($keys, [3, 4, 5]));
        $response->assertStatus(200);
        $response->assertJsonFragment(['is_pythagorean' => true, 'n' => 60]);

        $response = $this->post('/api/quizzes/triplet', array_combine($keys, [6, 8, 10]));
        $response->assertStatus(200);
        $response->assertJsonFragment(['is_pythagorean' => true]);
    }
}
