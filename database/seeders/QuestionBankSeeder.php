<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\QuestionCategory;
use App\Models\QuestionBankQuestion;

class QuestionBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teacher = User::where('type', 'admin')->first();

        if (!$teacher) {
            return;
        }

        $math = QuestionCategory::firstOrCreate(['name' => 'Math']);
        $science = QuestionCategory::firstOrCreate(['name' => 'Science']);
        $language = QuestionCategory::firstOrCreate(['name' => 'Language']);

        $questions = [
            [
                'question_text' => '2 + 2 = 4',
                'type' => 'true_false',
                'default_mark' => 1,
                'difficulty' => 'easy',
                'categories' => [$math->id],
            ],
            [
                'question_text' => 'What is the derivative of x^2?',
                'type' => 'text',
                'default_mark' => 3,
                'difficulty' => 'medium',
                'categories' => [$math->id],
            ],
            [
                'question_text' => 'Water boils at 100C at sea level.',
                'type' => 'true_false',
                'default_mark' => 2,
                'difficulty' => 'easy',
                'categories' => [$science->id],
            ],
            [
                'question_text' => 'Choose the correct synonym for "fast".',
                'type' => 'mcq',
                'default_mark' => 2,
                'difficulty' => 'medium',
                'categories' => [$language->id],
            ],
            [
                'question_text' => 'Define photosynthesis.',
                'type' => 'text',
                'default_mark' => 5,
                'difficulty' => 'hard',
                'categories' => [$science->id],
            ],
        ];

        foreach ($questions as $item) {
            $question = QuestionBankQuestion::firstOrCreate(
                [
                    'question_text' => $item['question_text'],
                    'teacher_id' => $teacher->id,
                ],
                [
                    'type' => $item['type'],
                    'default_mark' => $item['default_mark'],
                    'difficulty' => $item['difficulty'],
                    'status' => true,
                ]
            );

            $question->categories()->syncWithoutDetaching($item['categories']);
        }
    }
}
