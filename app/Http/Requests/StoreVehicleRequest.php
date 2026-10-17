<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'brand' => ['required', 'string', 'max:80'],
            'model' => ['required', 'string', 'max:80'],
            'year' => ['required', 'integer', 'between:1980,'.(now()->year + 1)],
            'plate' => [
                'required', 'string', 'max:12',
                Rule::unique('vehicles', 'plate')->where('user_id', $this->user()->id),
            ],
            'mileage' => ['required', 'integer', 'min:0', 'max:2000000'],
            'color' => ['nullable', 'string', 'max:40'],
            'vin' => ['nullable', 'string', 'max:32'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('plate')) {
            $this->merge([
                'plate' => strtoupper(preg_replace('/\s+/', '', (string) $this->input('plate'))),
            ]);
        }
    }
}
