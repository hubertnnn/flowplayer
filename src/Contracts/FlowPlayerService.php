<?php

namespace HubertNNN\FlowPlayer\Contracts;

interface FlowPlayerService extends FlowPlayer
{
    public function fetchData($endpoint, $parameters);

    public function getGuzzle();
    public function getSiteId();
    public function getApiKey();
    public function getUserId();
}
