<?php

namespace HubertNNN\FlowPlayer\Modules;

use HubertNNN\FlowPlayer\Contracts\FlowPlayerService;

class UploadModule
{
    /** @var FlowPlayerService */
    protected $service;

    public function __construct($service)
    {
        $this->service = $service;
    }


    protected function loadFile($source)
    {
        return fopen($source, 'r');
    }

    public function createVideo($source, $name)
    {
        $client = new \GuzzleHttp\Client();
        $siteId = $this->service->getSiteId();
        $apiKey = $this->service->getApiKey();
        $userId = $this->service->getUserId();


        //--------------------------------------------------------------------------------------------------------------
        // Init upload

        $url = "https://web.lemonwhale.com/web/video/v2/signed-upload-url";
        $data = [
            'api_key' => $apiKey,
            'site_id' => $siteId,
            'user_id' => $userId,
            'name' => $name,
        ];

        $response = $client->post($url, ['json' => $data]);
        $response = \GuzzleHttp\json_decode($response->getBody());

        $videoId = $response->video_id;
        $url = $response->signed_video_url;

        //--------------------------------------------------------------------------------------------------------------
        // Send file

        $client->put($url, ['body' => $this->loadFile($source)]);

        //--------------------------------------------------------------------------------------------------------------
        // start transcoding

        $url = 'https://web.lemonwhale.com/web/video/v2/signed-upload-complete';
        $data = [
            'api_key' => $apiKey,
            'id' => $videoId,
        ];

        $client->post($url, ['json' => $data]);

        //--------------------------------------------------------------------------------------------------------------
        // Create video object

        return $this->service->getVideo($videoId);
    }

}
