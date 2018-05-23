<?php

namespace HubertNNN\FlowPlayer;

class Video
{
    /** @var \HubertNNN\FlowPlayer\Contracts\FlowPlayerService */
    protected $service;

    protected $privateLoaded = false;
    protected $analyticsLoaded = false;

    protected $forUpdate = [];

    protected $id;

    public function __construct($service, $id)
    {
        $this->service = $service;
        $this->id = $id;
    }

    public function loadPrivateData($source = null)
    {
        if($this->privateLoaded)
            return;

        if($source === null) {
            $client = $this->service->getGuzzle();
            $apiKey = $this->service->getApiKey();
            $videoId = $this->id;

            $url = "https://web.lemonwhale.com/web/video/v2/$videoId.json?api_key=$apiKey";
            $response = $client->get($url);
            $source = \GuzzleHttp\json_decode($response->getBody());
        }

        $this->adTag = $source->adtag;
        $this->categoryId = $source->categoryid;
        $this->createdAt = $source->created_at;
        $this->description = $source->description;
        $this->duration = $source->duration;
        $this->externalVideoId = $source->externalvideoid;
        $this->images = $source->images; //ToArray
        $this->mediaFiles = $source->mediafiles;
        $this->name = $source->name;
        $this->noAds = $source->noads;
        $this->published = $source->published;
        $this->episode = $source->episode;
        $this->publishedAt = $source->published_at;
        $this->siteId = $source->siteid;
        $this->transcodingStatus = $source->state;
        $this->tags = $source->tags;
        $this->updatedAt = $source->updated_at;
        $this->userId = $source->userid;
        $this->views = $source->views;
    }

    public function loadAnalytics()
    {
        if($this->analyticsLoaded)
            return;

        // TODO: Implement me

    }


    // System
    // -----------------------------------------------------------------------------------------------------------------
    // Api

    protected $flowPlayerService;

    protected $name;
    protected $description;

    protected $episode;
    protected $duration;
    protected $views;

    protected $userId;
    protected $categoryId;
    protected $siteId;

    protected $createdAt;
    protected $updatedAt;
    protected $publishedAt;
    protected $published;

    protected $images;
    protected $mediaFiles;

    protected $noAds;
    protected $adTag;

    protected $transcodingStatus;

    protected $tags;
    protected $externalVideoId;

    // -----------------------------------------------------------------------------------------------------------------

    public function __get($name)
    {
        $loaders = [
            'loadPrivateData' => [
                'name',
                'description',
                'episode',
                'duration',
                'views',
                'userId',
                'categoryId',
                'siteId',
                'createdAt',
                'updatedAt',
                'publishedAt',
                'published',
                'images',
                'mediaFiles',
                'noAds',
                'adTag',
                'transcodingStatus',
                'tags',
                'externalVideoId',
            ],
        ];

        foreach ($loaders as $loader => $variables) {
            if(in_array($name, $variables)) {
                call_user_func([$this, $loader]);
                return $this->$name;
            }
        }

        throw new \InvalidArgumentException('Property not found: ' . $name);
    }

    public function __set($name, $value)
    {
        $fields = [
            'userId' => 'userid',
            'tags' => 'tags',
            'name' => 'name',
            'description' => 'description',
            'categoryId' => 'categoryid',
            'publishedAt' => 'publish_at',
            'published' => 'published',
        ];

        if(isset($fields[$name])) {
            $this->$name = $value;
            $this->forUpdate[$name] = $value;
        } else {
            throw new \InvalidArgumentException('Property value is read only: ' . $name);
        }
    }


    // -----------------------------------------------------------------------------------------------------------------


    public function save()
    {
        if(empty($this->forUpdate))
            return;

        $values = $this->forUpdate;
        $prepared = [];

        $prepareField = function ($field, $targetField, $type = 'text') use($values, &$prepared) {
            if(!isset($values[$field]))
                return;

            if($type == 'text') {
                $prepared[$targetField] = $values[$field];
                return;
            }

            if($type == 'date') {
                $prepared[$targetField] = $values[$field]->format('c');
                return;
            }

            if($type == 'array') {
                $prepared[$targetField] = implode(',', $values[$field]);
                return;
            }

            throw new \InvalidArgumentException('Unknown type: ' . $type);
        };

        $prepareField('userId', 'userid');
        $prepareField('tags', 'tags', 'array');
        $prepareField('name', 'name');
        $prepareField('description', 'description');
        $prepareField('categoryId', 'categoryid');
        $prepareField('publishedAt', 'publish_at', 'date');
        $prepareField('published', 'published');

        // -------------------------------------------------------------------------------------------------------------

        $client = $this->service->getGuzzle();
        $siteId = $this->service->getSiteId();
        $apiKey = $this->service->getApiKey();

        $url = "https://web.lemonwhale.com/web/video/v2/update.json";
        $data = [
            'api_key' => $apiKey,
            'siteId' => $siteId,
            'id' => $this->id,
        ];
        $data = array_merge($data, $prepared);
        $client->post($url, ['json' => $data]);
    }

    public function delete()
    {
        //TODO: Implement me after bug in flowplayer api will get fixed
    }
}
