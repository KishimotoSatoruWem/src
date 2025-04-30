<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Attributes as OA;

#[OA\Info(
    title: 'Memo API',
    version: '1.0.0',
    description: 'メモ管理 DB の API。<br>（注意: Servers プルダウンを選択しないで VSCode の Open API Viewer から Try it すると<br>プロトコルが「vscodewebview://」になってしまい Cors エラーが発生する）',
)]
#[OA\Server(
    url: 'http://localhost:8080',
    description: '開発環境',
)]
#[OA\Tag(
    name: 'memos',
    description: 'メモに関する API 群',
)]
#[OA\Parameter(
    name: 'Cache-Control',
    in: 'header',
    required: false,
    schema: new OA\Schema(
        type: 'string',
        description: 'キャッシュ指定（ブラウザ・経路・CDN）',
        example: 'no-cache',
    )
)]
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
