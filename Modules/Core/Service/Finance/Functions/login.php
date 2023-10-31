<?php

namespace Modules\Core\Service\Finance\Functions;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait login
{
    public function login (){
        try {
            $response = Http::post($this->base_path.'/authenticate', [
                'username' => $this->user_name,
                'password' => $this->password,
            ]);
            if ($response->successful()){
                $res = json_decode( $response->body() );
                return $res->token;
            }
            Log::error( 'taraz:login:'.$response->body() );
            return null;
        }catch (\Exception $e){
            Log::error( 'taraz:login:'.$e->getMessage() );
            return null;
        }

    }
}
