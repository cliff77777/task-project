<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function CheckMailVerifyForView($request)
    {
        Log::debug('CheckMailVerifyForView');

        if (!$request->user()->hasVerifiedEmail()) {
            setSessionMessageFromStatusCode('error','email_not_verified');
        }else{
            setSessionMessageFromStatusCode('error','email_not_verified','forget');
        }

        if(session('error')){
            $view='error.error_index';
        }else{
            $view='home';
        }
        return $view;

    }

    /**
     * 執行一個需要數據庫事務的方法
     *
     * @param callable $callback
     * @return mixed
     */
    protected function executeInTransaction(callable $callback)
    {
        DB::beginTransaction();

        try {
            $result = $callback();
            DB::commit();
            return $result;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


}
