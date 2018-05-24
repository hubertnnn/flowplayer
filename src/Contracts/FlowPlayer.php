<?php

namespace HubertNNN\FlowPlayer\Contracts;

interface FlowPlayer
{
    const TRANSCODING_STATUS_QUEUED = 'QUEUED';
    const TRANSCODING_STATUS_PROCESSING = 'PROCESSING';
    const TRANSCODING_STATUS_FINISHED = 'FINISHED';
    const TRANSCODING_STATUS_ERROR = 'ERROR';

    // Public api
    public function getVideo($id);
    public function listVideos($page = 0, $pageSize = 20); //TODO: Filters, categorise, search

    // Private api
    public function createVideo();
}
