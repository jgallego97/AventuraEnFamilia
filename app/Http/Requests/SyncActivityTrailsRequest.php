<?php

namespace App\Http\Requests;

use App\Models\Activity;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SyncActivityTrailsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'trails' => [
                'bail',
                'required',
                'array',
                'min:1',
                function (string $attribute, mixed $value, Closure $fail) {
                    $hasMain = collect($value)->contains(
                        fn ($trail) => ($trail['type'] ?? null) === 'main'
                    );

                    if (! $hasMain) {
                        $fail('La actividad necesita al menos un trail principal.');
                    }
                },
            ],
            'trails.*.trail_id' => ['required', 'integer', 'exists:trails,id', 'distinct'],
            'trails.*.position' => ['required', 'integer', 'min:1', 'distinct'],
            'trails.*.type' => ['required', Rule::in(Activity::TRAIL_TYPES)],
            'trails.*.pace' => ['required', Rule::in(Activity::PACES)],
        ];
    }
}
