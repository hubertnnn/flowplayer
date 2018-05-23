<?php

namespace HubertNNN\FlowPlayer\Modules;

use HubertNNN\FlowPlayer\Contracts\FlowPlayerService;
use HubertNNN\FlowPlayer\Video;

class SearchModule
{
    /** @var FlowPlayerService */
    protected $service;

    public function __construct($service)
    {
        $this->service = $service;
    }

    public function listVideos($page = 1, $pageSize = 20)
    {
        $client = $this->service->getGuzzle();
        $siteId = $this->service->getSiteId();
        $apiKey = $this->service->getApiKey();

        $url = "https://web.lemonwhale.com/web/video/v2/site/$siteId.json";
        $data = [
            'api_key' => $apiKey,
            'page' => $page,
            'page_size' => $pageSize,
        ];

        $response = $client->get($url, ['query' => $data]);
        $response = \GuzzleHttp\json_decode($response->getBody());

        $output = [];
        foreach ($response as $videoData) {

            /** @var Video $video */
            $video = $this->service->getVideo($videoData->id);
            $video->loadPrivateData($videoData);

            $output[] = $video;

        }

        return $output;
    }
}
