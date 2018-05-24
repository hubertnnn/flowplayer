<?php

namespace HubertNNN\FlowPlayer;

use HubertNNN\FlowPlayer\Modules\SearchModule;
use HubertNNN\FlowPlayer\Modules\UploadModule;

class FlowPlayerService
{
    protected $apiKey;
    protected $siteId;
    protected $userId;

    public function __construct($apiKey, $siteId, $userId = null)
    {
        $this->apiKey = $apiKey;
        $this->siteId = $siteId;
        $this->userId = $userId;
    }

    // -----------------------------------------------------------------------------------------------------------------
    // Public api

    public function getVideo($id, $autoload = false)
    {
        return new Video($this, $id, $autoload);
    }

    public function listVideos($page = 1, $limit = 20)
    {
        //TODO: Filters, categorise, search

        $module = new SearchModule($this);
        return $module->listVideos($page, $limit);
    }

    // -----------------------------------------------------------------------------------------------------------------
    // Private api

    public function createVideo($source, $title)
    {
        $module = new UploadModule($this);
        return $module->createVideo($source, $title);
    }

    // -----------------------------------------------------------------------------------------------------------------
    // Internal api

    public function getGuzzle()
    {
        //TODO: Use shared instance
        return new \GuzzleHttp\Client();
    }

    public function getSiteId()
    {
        return $this->siteId;
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function getUserId()
    {
        return $this->userId;
    }
}
