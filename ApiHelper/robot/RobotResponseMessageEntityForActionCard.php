<?php


namespace sinri\sinridingtalkhelper\ApiHelper\robot;

/**
 * Class RobotResponseMessageEntityForActionCard
 * @package sinri\sinridingtalkhelper\ApiHelper\robot
 * @since 0.3
 */
class RobotResponseMessageEntityForActionCard extends RobotResponseMessageEntity
{
    const BUTTON_ORIENTATION_VERTICAL = '0';
    const BUTTON_ORIENTATION_HORIZONTAL = '1';

    const HIDE_AVATAR_YES = '1';
    const HIDE_AVATAR_NO = '0';

    protected $title;
    protected $text;

    protected $hideAvatar;
    protected $btnOrientation;
    protected $buttonList;

    public function __construct()
    {
        parent::__construct();
        $this->msgType = self::MESSAGE_TYPE_ACTION_CARD;
        $this->buttonList = [];
    }

    /**
     * @param bool $hideAvatar
     * @return RobotResponseMessageEntityForActionCard
     */
    public function setHideAvatar($hideAvatar)
    {
        $this->hideAvatar = $hideAvatar ? self::HIDE_AVATAR_YES : self::HIDE_AVATAR_NO;
        return $this;
    }

    /**
     * @param int $btnOrientation 0-按钮竖直排列 1-按钮横向排列
     * @return RobotResponseMessageEntityForActionCard
     */
    public function setBtnOrientation($btnOrientation)
    {
        $this->btnOrientation = $btnOrientation;
        return $this;
    }

    /**
     * @param string $title 首屏会话透出的展示内容
     * @param string $text markdown格式的消息内容
     * @return $this
     */
    public function setContent($title, $text)
    {
        $this->title = $title;
        $this->text = $text;
        return $this;
    }

    public function addButton($title, $url)
    {
        $this->buttonList[] = [
            'title' => $title,
            'url' => $url,
        ];
        return $this;
    }

    public function generateDataStructure()
    {
        $entity = [
            'msgtype' => self::MESSAGE_TYPE_ACTION_CARD,
            self::MESSAGE_TYPE_ACTION_CARD => [
                'title' => $this->title,
                'text' => $this->text,
            ]
        ];
        if (count($this->buttonList) > 1) {
            $entity['hideAvatar'] = $this->hideAvatar;
            $entity['btnOrientation'] = $this->btnOrientation;
            $entity['btns'] = [];
            foreach ($this->buttonList as $item) {
                $entity['btns'][] = [
                    'title' => $item['title'],
                    'actionURL' => $item['url'],
                ];
            }
        } else {
            $entity['singleTitle'] = $this->buttonList[0]['title'];
            $entity['singleURL'] = $this->buttonList[0]['url'];
        }
        return $entity;
    }
}