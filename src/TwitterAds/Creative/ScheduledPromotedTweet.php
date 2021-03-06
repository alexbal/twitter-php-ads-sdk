<?php

namespace Hborras\TwitterAdsSDK\TwitterAds\Creative;

use Hborras\TwitterAdsSDK\TwitterAds\Analytics;
use Hborras\TwitterAdsSDK\TwitterAds\Errors\BadRequest;
use Hborras\TwitterAdsSDK\TwitterAds\Fields\AnalyticsFields;
use Hborras\TwitterAdsSDK\TwitterAds\Fields\ScheduledPromotedTweetFields;

/**
 * Class ScheduledTweet
 * @package Hborras\TwitterAdsSDK\TwitterAds\Creative
 */
class ScheduledPromotedTweet extends Analytics
{
    const RESOURCE_COLLECTION = 'accounts/{account_id}/scheduled_promoted_tweets';
    const RESOURCE            = 'accounts/{account_id}/scheduled_promoted_tweets/{id}';
    const RESOURCE_STATS      = 'stats/accounts/{account_id}/scheduled_promoted_tweets/{id}';

    const ENTITY = 'PROMOTED_TWEET';

    /** Read Only */
    protected $id;
    protected $approval_status;
    protected $created_at;
    protected $updated_at;
    protected $deleted;

    protected $properties = [
        ScheduledPromotedTweetFields::TWEET_ID,
        ScheduledPromotedTweetFields::ENTITY_STATUS,
    ];

    /** Writable */
    protected $tweet_id;
    protected $paused;

    /**
     * @param $metricGroups
     * @param array $params
     * @param bool $async
     * @return mixed
     * @throws BadRequest
     * @throws \Hborras\TwitterAdsSDK\TwitterAdsException
     * @throws \Hborras\TwitterAdsSDK\TwitterAds\Errors\Forbidden
     * @throws \Hborras\TwitterAdsSDK\TwitterAds\Errors\NotAuthorized
     * @throws \Hborras\TwitterAdsSDK\TwitterAds\Errors\NotFound
     * @throws \Hborras\TwitterAdsSDK\TwitterAds\Errors\RateLimit
     * @throws \Hborras\TwitterAdsSDK\TwitterAds\Errors\ServerError
     * @throws \Hborras\TwitterAdsSDK\TwitterAds\Errors\ServiceUnavailable
     */
    public function stats($metricGroups, $params = [], $async = false)
    {
        $params[AnalyticsFields::ENTITY] = AnalyticsFields::PROMOTED_TWEET;
        return parent::stats($metricGroups, $params, $async);
    }

    /**
     * Saves or updates the current object instance depending on the
     * presence of `object->getId()`.
     */
    public function save()
    {
        $params = $this->toParams();
        if (isset($params[ScheduledPromotedTweetFields::TWEET_ID])) {
            $params[ScheduledPromotedTweetFields::TWEET_IDS] = $params[ScheduledPromotedTweetFields::TWEET_ID];
            unset($params[ScheduledPromotedTweetFields::TWEET_ID]);
        }

        if ($this->getId()) {
            $resource = str_replace(static::RESOURCE_REPLACE, $this->getTwitterAds()->getAccountId(), static::RESOURCE);
            $resource = str_replace(static::RESOURCE_ID_REPLACE, $this->getId(), $resource);
            $response = $this->getTwitterAds()->put($resource, $params);

            return $this->fromResponse($response->getBody()->data);
        }

        $resource = str_replace(static::RESOURCE_REPLACE, $this->getTwitterAds()->getAccountId(), static::RESOURCE_COLLECTION);
        $response = $this->getTwitterAds()->post($resource, $params);

        return $this->fromResponse($response->getBody()->data[0]);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getApprovalStatus()
    {
        return $this->approval_status;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @return mixed
     */
    public function getTweetId()
    {
        return $this->tweet_id;
    }

    /**
     * @return mixed
     */
    public function getPaused()
    {
        return $this->paused;
    }

    /**
     * @param array $properties
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;
    }

    /**
     * @param mixed $tweet_id
     */
    public function setTweetId($tweet_id)
    {
        $this->tweet_id = $tweet_id;
    }

    /**
     * @param mixed $paused
     */
    public function setPaused($paused)
    {
        $this->paused = $paused;
    }
}
