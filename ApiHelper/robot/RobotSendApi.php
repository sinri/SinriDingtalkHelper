<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/9/30
 * Time: 14:04
 */

namespace sinri\sinridingtalkhelper\ApiHelper\robot;


use sinri\sinridingtalkhelper\ApiHelper\SinriDingtalkHelper;

/**
 * 钉钉自定义机器人发消息的接口
 * @see https://open-doc.dingtalk.com/docs/doc.htm?spm=a219a.7629140.0.0.kO4wOL&treeId=257&articleId=105735&docType=1#s4
 * Class RobotSendApi
 * @package sinri\sinridingtalkhelper\ApiHelper\robot
 */
class RobotSendApi
{
    protected $accessToken;
    protected $apiWithAccessToken;

    public $isDebug;

    /**
     * 获取自定义机器人webhook里面的access_token
     * RobotSendApi constructor.
     * @param $accessToken
     */
    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
        $this->apiWithAccessToken = "https://oapi.dingtalk.com/robot/send?access_token=" . $this->accessToken;

        $this->isDebug = false;
    }

    const AT_ALL = "AT_ALL";

    /**
     * 发送文本消息
     * @param string $content
     * @param array|string $at default as [], const AT_ALL, or [mobiles]
     * @return mixed
     */
    public function sendText($content, $at = [])
    {
        $dataJson = [
            "msgtype" => "text",
            "text" => [
                "content" => $content
            ],
            "at" => [
                "atMobiles" => (is_array($at) ? $at : []),
                "isAtAll" => ($at === self::AT_ALL ? true : false)
            ]
        ];
        return $this->callApi($dataJson);
    }

    /**
     * 发送一个图文连接，也可以不放图片
     * @param $title
     * @param $text
     * @param $messageUrl
     * @param string $pictureUrl
     * @return bool|string
     */
    public function sendLink($title, $text, $messageUrl, $pictureUrl = "")
    {
        $dataJson = [
            "msgtype" => "link",
            "link" => [
                "text" => $text,
                "title" => $title,
                "picUrl" => $pictureUrl,
                "messageUrl" => $messageUrl,
            ]
        ];
        return $this->callApi($dataJson);
    }

    /**
     * 发送一个markdown格式的内容
     * @param string $title
     * @param string $markdown 如果需要@人，在text内容里要有@手机号
     * @param array $at 被@人的手机号
     * @return bool|string
     */
    public function sendMarkdown($title, $markdown, $at = [])
    {
        $dataJson = [
            "msgtype" => "markdown",
            "markdown" => [
                "title" => $title,
                "text" => $markdown,
            ],
            "at" => [
                "atMobiles" => (is_array($at) ? $at : []),
                "isAtAll" => ($at === self::AT_ALL ? true : false)
            ]
        ];
        return $this->callApi($dataJson);
    }

    /**
     * 整体跳转ActionCard类型
     * @param string $title
     * @param string $markdown
     * @param string $singleTitle 按钮标题
     * @param string $singleURL 按钮跳转链接
     * @param bool $hideAvatar 是否隐藏发信者头像
     * @return bool|string
     */
    public function sendActionCardWithSingleLink($title, $markdown, $singleTitle, $singleURL, $hideAvatar = true)
    {
        $dataJson = [
            "actionCard" => [
                "title" => $title,
                "text" => $markdown,
                "hideAvatar" => ($hideAvatar ? "1" : "0"),
                "btnOrientation" => "0",
                "singleTitle" => $singleTitle,
                "singleURL" => $singleURL
            ],
            "msgtype" => "actionCard"
        ];
        return $this->callApi($dataJson);
    }

    /**
     * 独立跳转ActionCard类型
     * @param $title
     * @param $markdown
     * @param array $buttonMetas {BTN_TITLE:BTN_UTL,...}
     * @param bool $hideAvatar 是否隐藏发信者头像
     * @return bool|string
     */
    public function sendActionCardWithMultiLinks($title, $markdown, $buttonMetas, $hideAvatar = true)
    {
        $btns = [];
        foreach ($buttonMetas as $btnTitle => $btnUrl) {
            $btns[] = [
                "title" => $btnTitle,
                "actionURL" => $btnUrl
            ];
        }
        $dataJson = [
            "actionCard" => [
                "title" => $title,
                "text" => $markdown,
                "hideAvatar" => ($hideAvatar ? "1" : "0"),
                "btnOrientation" => "0",
                "btns" => $btns,
            ],
            "msgtype" => "actionCard"
        ];
        return $this->callApi($dataJson);
    }

    /**
     * FeedCard类型
     * @param array $links items as {title:XX,messageURL:YY,picURL:ZZ}
     * @return bool|string
     */
    public function sendFeedCard($links)
    {
        $dataJson = [
            "feedCard" => [
                "links" => $links
            ],
            "msgtype" => "feedCard"
        ];
        return $this->callApi($dataJson);
    }

    protected function callApi($dataJson)
    {
        $response = SinriDingtalkHelper::executeCurl(
            SinriDingtalkHelper::METHOD_POST,
            $this->apiWithAccessToken,
            $dataJson,
            [], [], true
        );

        if ($this->isDebug) {
            echo $response . PHP_EOL;
        }

        return $response;
    }
}