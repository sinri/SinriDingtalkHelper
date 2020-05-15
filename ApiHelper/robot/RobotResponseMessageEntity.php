<?php


namespace sinri\sinridingtalkhelper\ApiHelper\robot;

/**
 * Class RobotResponseMessageEntity
 * @package sinri\sinridingtalkhelper\ApiHelper\robot
 * @since 0.3
 */
class RobotResponseMessageEntity
{
    const MESSAGE_TYPE_TEXT = 'text';
    const MESSAGE_TYPE_MARKDOWN = 'markdown';
    const MESSAGE_TYPE_ACTION_CARD = 'actionCard';
    const MESSAGE_TYPE_FEED_CARD = 'feedCard';
    const MESSAGE_TYPE_EMPTY = 'empty';

    /**
     * @var string
     */
    protected $msgType;

    /**
     * RobotResponseMessageEntity constructor.
     * If not overrode, it is for silence
     */
    public function __construct()
    {
        $this->msgType = self::MESSAGE_TYPE_EMPTY;
    }

    /**
     * @return array a json entity
     */
    public function generateDataStructure()
    {
        return ['msgtype' => $this->msgType];
    }
}

/*
 * {
     "msgtype": "text",
     "text": {
         "content": "我就是我, @150XXXXXXXX 是不一样的烟火"
     },
     "at": {
         "atMobiles": [
             "150XXXXXXXX"
         ],
         "atDingtalkIds": [
             "XXXXXXXXXXX"
         ],
         "isAtAll": false
     }
 }

{
     "msgtype": "markdown",
     "markdown": {
         "title":"杭州天气",
         "text": "#### 杭州天气 @150XXXXXXXX \n> 9度，西北风1级，空气良89，相对温度73%\n> ![screenshot](https://img.alicdn.com/tfs/TB1NwmBEL9TBuNjy1zbXXXpepXa-2400-1218.png)\n> ###### 10点20分发布 [天气](https://www.dingalk.com) \n"
     },
      "at": {
          "atMobiles": [
              "150XXXXXXXX"
          ],
          "isAtAll": false
      }
 }

{
    "msgtype": "actionCard",
    "actionCard": {
        "title": "打造一间咖啡厅",
        "text": "![screenshot](https://img.alicdn.com/tfs/TB1NwmBEL9TBuNjy1zbXXXpepXa-2400-1218.png) \n #### 乔布斯 20 年前想打造的苹果咖啡厅 \n\n Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划",
        "singleTitle" : "阅读全文",
        "singleURL" : "https://www.dingtalk.com/"
    }
}

{
    "msgtype": "actionCard",
    "actionCard": {
        "title": "乔布斯 20 年前想打造一间苹果咖啡厅，而它正是 Apple Store 的前身",
        "text": "![screenshot](https://img.alicdn.com/tfs/TB1NwmBEL9TBuNjy1zbXXXpepXa-2400-1218.png) \n\n #### 乔布斯 20 年前想打造的苹果咖啡厅 \n\n Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划",
        "hideAvatar": "0",
        "btnOrientation": "0",
        "btns": [
            {
                "title": "内容不错",
                "actionURL": "https://www.dingtalk.com/"
            },
            {
                "title": "不感兴趣",
                "actionURL": "https://www.dingtalk.com/"
            }
        ]
    }
}

{
    "msgtype": "feedCard",
    "feedCard": {
        "links": [
            {
                "title": "时代的火车向前开1",
                "messageURL": "https://www.dingtalk.com/",
                "picURL": "https://img.alicdn.com/tfs/TB1NwmBEL9TBuNjy1zbXXXpepXa-2400-1218.png"
            },
            {
                "title": "时代的火车向前开2",
                "messageURL": "https://www.dingtalk.com/",
                "picURL": "https://img.alicdn.com/tfs/TB1NwmBEL9TBuNjy1zbXXXpepXa-2400-1218.png"
            }
        ]
    }
}

{
    "msgtype": "empty"
}

 */