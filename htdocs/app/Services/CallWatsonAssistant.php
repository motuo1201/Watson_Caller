<?php
namespace App\Services;

use GuzzleHttp\Client;

class CallWatsonAssistant{
    /**
     * Watson Assistantを呼び出すモジュール
     *
     * @param string $spokenWord ユーザーが入力した文字列
     * @param array $context watson assistantのcontextデータ
     * @return json Watson AssistantをCallした結果
     */
    public function call(string $spokenWord,array $context)
    {
        $context["private"] = ["my_credentials" => 
            [
                //ここは環境変数から取得
                "user"     => config('watson.icf_user'),
                "password" => config('watson.icf_password')
            ]
        ];

        $requestData  = json_encode(['input'=>['text'=>$spokenWord],'context'=>$context]);
        $headers = ['Content-Type' => 'application/json','Content-Length' => strlen($requestData)];
        $curlOpts = [
            CURLOPT_USERPWD        => config('watson.user_name').':'.config('watson.password'),
            CURLOPT_POSTFIELDS     => $requestData
        ];
        $path         = config('watson.workspace_id') . '/message?version=2018-07-10';
        $guzzleClient = new Client(['base_uri'=>'https://gateway-fra.watsonplatform.net/assistant/api/v1/workspaces/']);
        return $guzzleClient->request('POST',$path,['headers'=> $headers,'curl'=>$curlOpts])->getBody()->getContents();
    }
}