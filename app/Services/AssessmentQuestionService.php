<?php

namespace App\Services;

use App\Models\Assessment;
use App\Models\QuestionBankQuestion;

class AssessmentQuestionService
{
    public function buildSyncPayload(array $validated): array
    {
        $payload = collect($validated['questions'] ?? [])->map(function (array $item, int $index) {
            return [
                'question_id' => (int) $item['question_id'],
                'mark' => $item['mark'] ?? null,
                'order' => $item['order'] ?? ($index + 1),
            ];
        });

        $random = $this->resolveRandomQuestions($validated);
        $merged = $payload->merge($random)->unique('question_id')->values();

        return $merged->mapWithKeys(function (array $item) {
            return [
                $item['question_id'] => [
                    'mark' => $item['mark'],
                    'order' => $item['order'],
                ],
            ];
        })->all();
    }

    public function attachWithoutDuplicates(Assessment $assessment, array $syncPayload): void
    {
        if (empty($syncPayload)) {
            return;
        }

        $existingIds = $assessment->questions()->pluck('question_bank_questions.id')->all();
        $filtered = collect($syncPayload)->reject(function (array $pivot, int $questionId) use ($existingIds) {
            return in_array((int) $questionId, $existingIds, true);
        })->all();

        if (!empty($filtered)) {
            $assessment->questions()->attach($filtered);
        }
    }

    protected function resolveRandomQuestions(array $validated)
    {
        $random = $validated['random'] ?? [];

        if (!($random['enabled'] ?? false)) {
            return collect();
        }

        $count = (int) ($random['count'] ?? 0);
        if ($count < 1) {
            return collect();
        }

        $query = QuestionBankQuestion::query()->active();

        if (!empty($random['difficulty'])) {
            $query->where('difficulty', $random['difficulty']);
        }

        if (!empty($random['category_ids'])) {
            $categoryIds = $random['category_ids'];
            $query->whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('question_categories.id', $categoryIds);
            });
        }

        return $query->inRandomOrder()->limit($count)->get()->values()->map(function (QuestionBankQuestion $question, int $index) {
            return [
                'question_id' => $question->id,
                'mark' => $question->default_mark,
                'order' => $index + 1,
            ];
        });
    }
}
