<?php


namespace sinri\sinridingtalkhelper\ApiHelper\robot;

/**
 * Class RobotResponseMessageEntityForText
 * @package sinri\sinridingtalkhelper\ApiHelper\robot
 * @since 0.3
 */
class RobotResponseMessageEntityForText extends RobotResponseMessageEntity
{
    protected $content;
    protected $atMobileList;
    protected $atDingtalkIdList;
    protected $isAtAll;

    public function __construct()
    {
        parent::__construct();
        $this->msgType = self::MESSAGE_TYPE_TEXT;
        $this->atMobileList = [];
        $this->atDingtalkIdList = [];
        $this->isAtAll = false;
    }

    /**
     * @param array $atMobileList
     * @return RobotResponseMessageEntityForText
     */
    public function setAtMobileList($atMobileList)
    {
        $this->atMobileList = $atMobileList;
        return $this;
    }

    /**
     * @param array $atDingtalkIdList
     * @return RobotResponseMessageEntityForText
     */
    public function setAtDingtalkIdList($atDingtalkIdList)
    {
        $this->atDingtalkIdList = $atDingtalkIdList;
        return $this;
    }

    /**
     * @param bool $isAtAll
     * @return RobotResponseMessageEntityForText
     */
    public function setIsAtAll($isAtAll)
    {
        $this->isAtAll = $isAtAll;
        return $this;
    }

    /**
     * @param string $content
     * @return RobotResponseMessageEntityForText
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return array
     */
    protected function generateAtComponent()
    {
        $at = [];
        if (!empty($this->atMobileList)) {
            $at['atMobiles'] = $this->atMobileList;
        }
        if (!empty($this->atDingtalkIdList)) {
            $at['atDingtalkIds'] = $this->atDingtalkIdList;
        }
        if (!empty($this->isAtAll)) {
            $at['isAtAll'] = $this->isAtAll;
        }
        return $at;
    }

    public function generateDataStructure()
    {
        $entity = [
            'msgtype' => self::MESSAGE_TYPE_TEXT,
            self::MESSAGE_TYPE_TEXT => [
                'content' => $this->content,
            ]
        ];
        $at = $this->generateAtComponent();
        if (!empty($at)) $entity['at'] = $at;
        return $entity;
    }
}