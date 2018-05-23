<?php

namespace HubertNNN\FlowPlayer\Contracts;

/**
 * @property string $id
 * @property string $name
 * @property string description
 * @property string episode
 * @property string duration
 * @property string views
 * @property string userId
 * @property string categoryId
 * @property string siteId
 * @property string createdAt
 * @property string updatedAt
 * @property string publishedAt
 * @property string published
 * @property string images
 * @property string mediaFiles
 * @property string noAds
 * @property string adTag
 * @property string transcodingStatus
 * @property string tags
 * @property string externalVideoId
 */
interface Video
{
    public function save();
    public function delete();
}
