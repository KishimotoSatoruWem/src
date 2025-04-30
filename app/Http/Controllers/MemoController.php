<?php

namespace App\Http\Controllers;

use App\Models\Memo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use OpenApi\Attributes as OA;

class MemoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    #[OA\Get(
        tags: ['memos'],
        path: '/api/memos',
        summary: 'メモリスト取得',
        description: 'メモリストを絞り込みなしで取得します。',
        operationId: 'ListupMemos',
    )]
    #[OA\Parameter(
        ref: '#/components/parameters/Cache-Control',
    )]
    #[OA\Response(
        response: '200',
        description: 'メモリストを正常に取得しました。',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/Memo'),
        ),
    )]
    public function index()
    {
        $memos = Memo::all();
        // Log::debug(print_r($memos, true));
        foreach($memos as $memo) {
            $memo->body_limit = Str::limit($memo->body, 200, '...');
        }
        // Log::debug(print_r($memos, true));
        return response()->json(
            $memos, 200
        );
    }

    /**
     * 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $word = $request->word;
        Log::debug(print_r($word, true));
        if ($word) {
            $memos = Memo::where('body', 'LIKE', '%' . $word . '%')->get();
        } else {
            $memos = Memo::all();
        }
        Log::debug(print_r($memos, true));
        foreach($memos as $memo) {
            $memo->body_limit = Str::limit($memo->body, 200, '...');
        }
        return response()->json(
            $memos, 200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    #[OA\Post(
        tags: ['memos'],
        path: '/api/memos',
        summary: 'メモ登録',
        description: 'メモを登録し登録後のメモを取得します。',
        operationId: 'CreateMemo',
    )]
    #[OA\Parameter(
        ref: '#/components/parameters/Cache-Control',
    )]
    #[OA\RequestBody(
        description: 'StoreMemo',
        content: new OA\JsonContent(
            ref: '#/components/schemas/StoreMemo',
        ),
    )]
    #[OA\Response(
        response: '201',
        description: 'メモを正常に登録しました。',
        content: new OA\JsonContent(
            ref: '#/components/schemas/Memo',
        ),
    )]
    public function store(Request $request)
    {
        $memo = Memo::create($request->all());
        return response()->json(
            $memo, 201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    #[OA\Patch(
        tags: ['memos'],
        path: '/api/memos/{id}',
        summary: 'メモ更新',
        description: 'メモを更新し更新後のメモを取得します。',
        operationId: 'UpdateMemo',
    )]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        schema: new OA\Schema(
            type: 'integer',
            format: 'int64',
            description: '更新対象メモのid',
            example: 0,
        ),
    )]
    #[OA\RequestBody(
        description: 'StoreMemo',
        content: new OA\JsonContent(
            ref: '#/components/schemas/StoreMemo',
        ),
    )]
    #[OA\Response(
        response: '201',
        description: 'メモを正常に更新しました。',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/Memo'),
        ),
    )]
    #[OA\Response(
        response: '404',
        description: '更新対象のメモが存在しません。',
    )]
    public function update(Request $request, string $id)
    {
        $update = [
            'body' => $request->body,
            'bg_color_id' => $request->bg_color_id
        ];
        $memo = Memo::where('id', $id)->update($update);
        $memos = Memo::all();
        if ($memo) {
            return response()->json(
                $memos
            , 200);
        } else {
            return response()->json([
                'message' => 'Memo not found',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    #[OA\Delete(
        tags: ['memos'],
        path: '/api/memos/{id}',
        summary: 'メモ削除',
        description: 'メモを削除します。',
        operationId: 'DeleteMemo',
    )]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        schema: new OA\Schema(
            type: 'integer',
            format: 'int64',
            description: '削除対象メモのid',
            example: 0,
        ),
    )]
    #[OA\Response(
        response: '200',
        description: 'メモを正常に削除しました。',
    )]
    #[OA\Response(
        response: '404',
        description: '削除対象のメモが存在しません。',
    )]
    public function destroy(string $id)
    {
        $memo = Memo::where('id', $id)->delete();
        if ($memo) {
            return response()->json([
                'message' => 'Memo deleted successfully',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Memo not found',
            ], 404);
        }
    }
}
