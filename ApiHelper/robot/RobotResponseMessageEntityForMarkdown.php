<?php


namespace sinri\sinridingtalkhelper\ApiHelper\robot;

/**
 * Class RobotResponseMessageEntityForMarkdown
 * @package sinri\sinridingtalkhelper\ApiHelper\robot
 * @since 0.3
 */
class RobotResponseMessageEntityForMarkdown extends RobotResponseMessageEntityForText
{
    protected $title;

    /**
     * @param string $title
     * @return RobotResponseMessageEntityForMarkdown
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function __construct()
    {
        parent::__construct();
        $this->msgType = self::MESSAGE_TYPE_MARKDOWN;
    }

    public function generateDataStructure()
    {
        $entity = [
            'msgtype' => self::MESSAGE_TYPE_MARKDOWN,
            self::MESSAGE_TYPE_MARKDOWN => [
                'title' => $this->title,
                'content' => $this->content,
            ]
        ];
        $at = $this->generateAtComponent();
        if (!empty($at)) $entity['at'] = $at;
        return $entity;
    }
}