<?php

namespace App\Http\Requests\Character;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'class_id' => ['required', 'integer', 'exists:character_classes,id'],

            // basic character info
            'name'         => ['required', 'string', 'max:255'],
            'background'   => ['sometimes', 'nullable', 'string'],
            'gender'       => ['sometimes', 'nullable', 'string', 'max:255'],
            'age'          => ['sometimes', 'nullable', 'integer', 'min:1'],
            'height_cm'    => ['sometimes', 'nullable', 'integer', 'min:1'],
            'weight_g'     => ['sometimes', 'nullable', 'integer', 'min:1'],
            'size'         => ['sometimes', 'string', 'in:tiny,small,medium,large,huge,gargatuan'], //TODO: add enum of size`s?
            'sanity_meter' => ['sometimes', 'nullable', 'integer', 'between:0,10'],

            // 10 starter ability points
            'point_allocations'                    => ['sometimes', 'array'],
            'point_allocations.*.allocatable_type' => ['required', 'string', 'in:ability'],
            'point_allocations.*.allocatable_id'   => ['required', 'integer', 'exists:abilities,id'],
            'point_allocations.*.amount'           => ['required', 'integer', 'between:1,10'],

            'feat_id'           => ['sometimes', 'exists:feats,id'], // TODO: add rarity checker rule
        ];
    }

    public function character(): array {
        return $this->safe()->only([
            'class_id',
            'name',
            'background',
            'gender',
            'age',
            'height_cm',
            'weight_g',
            'size',
            'sanity_meter',
            'feat_id',
        ]);
    }

    public function pointAllocations(): array {
        return $this->safe()->input('point_allocations', []);
    }
}
