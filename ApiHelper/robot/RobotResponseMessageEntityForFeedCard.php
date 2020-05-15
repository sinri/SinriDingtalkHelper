<?php


namespace sinri\sinridingtalkhelper\ApiHelper\robot;

/**
 * Class RobotResponseMessageEntityForFeedCard
 * @package sinri\sinridingtalkhelper\ApiHelper\robot
 * @since 0.3
 */
class RobotResponseMessageEntityForFeedCard extends RobotResponseMessageEntity
{

    protected $linkList;

    public function __construct()
    {
        parent::__construct();
        $this->msgType = self::MESSAGE_TYPE_FEED_CARD;
        $this->linkList = [];
    }

    /**
     * @param string $title
     * @param string $messageURL
     * @param string $picURL
     * @return $this
     */
    public function addLinkItem($title, $messageURL, $picURL)
    {
        $this->linkList[] = [
            'title' => $title,
            'messageURL' => $messageURL,
            'picURL' => $picURL,
        ];
        return $this;
    }

    public function generateDataStructure()
    {
        return [
            'msgtype' => self::MESSAGE_TYPE_FEED_CARD,
            self::MESSAGE_TYPE_FEED_CARD => [
                'links' => $this->linkList
            ]
        ];
    }
}