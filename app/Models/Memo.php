<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Memo',
    title: 'Memo',
    description: 'ユーザID、メモ本文、背景色IDをもつクラス',
    required: ['user_id', 'body', 'bg_color_id'],
)]
class Memo extends Model
{
    use HasFactory;

    #[OA\Property(
        property: 'id',
        description: 'id',
        type: 'integer',
        format: 'int64',
        example: 0,
        nullable: false,
    )]
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
    #[OA\Property(
        property: 'created_at',
        description: 'created_at',
        type: 'string',
        example: '2023-12-31T12:34:56.123456Z',
        nullable: false,
    )]
    #[OA\Property(
        property: 'updated_at',
        description: 'updated_at',
        type: 'string',
        example: '2023-12-31T12:34:56.123456Z',
        nullable: false,
    )]
    protected $fillable = [
        'user_id',
        'body',
        'bg_color_id',
    ];
}
