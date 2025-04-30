<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    public function index()
    {
        $this->heyYouGuy(15);
    }

    /**
     * 
     * @param int $n
     * @return void
     */
    public function heyYouGuy($n)
    {
        // 最も大きい数字に対応する文字列のみ表示のため、処理順を数値降順とする
        if ($n % 7 === 0) {
            echo 'Guy' . '<br>';
        } elseif ($n % 5 === 0) {
            echo 'You' . '<br>';
        } elseif ($n % 3 === 0) {
            echo 'Hey' . '<br>';
        } else {
            echo $n . '<br>';
        }
        Log::debug('パラメータ：' . $n);
    }
}
