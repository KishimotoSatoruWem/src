<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'StoreMemo',
    title: 'StoreMemo',
    description: 'ユーザID、メモ本文、背景色IDをもつクラス',
    required: ['user_id', 'body', 'bg_color_id'],
)]

class StoreMemo extends FormRequest
{
    #[OA\Property(
        property: 'user_id',
        description: 'ユーザID',
        type: 'int11',
        example: 0,
        nullable: false,
    )]
    #[OA\Property(
        property: 'body',
        description: 'メモ本文',
        type: 'string',
        example: 'あいうえおかきくけこ',
        nullable: false,
    )]
    #[OA\Property(
        property: 'bg_color_id',
        description: '背景色ID',
        type: 'int11',
        example: 0,
        nullable: false,
    )]
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required',
            'body' => 'required',
            'bg_color_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'ユーザIDが存在しません',
            'body.required' => 'メモ本文が未入力です',
            'bg_color_id.required' => '背景色IDが存在しません',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json([
            'message' => 'Failed validation',
            'errors' => $errors,
        ], 422, [], JSON_UNESCAPED_UNICODE));
    }
}
