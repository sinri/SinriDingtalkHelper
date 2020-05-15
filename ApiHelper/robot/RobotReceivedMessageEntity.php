<?php


namespace sinri\sinridingtalkhelper\ApiHelper\robot;

use Exception;

/**
 * Class RobotReceiveNewsEntity
 * @see https://ding-doc.dingtalk.com/doc#/serverapi2/elzz1p
 * @since 0.3
 * @package sinri\sinridingtalkhelper\ApiHelper\robot
 * @property-read string msgType
 * @property-read string content
 * @property-read string msgId 加密的消息ID
 * @property-read int createAt 消息的时间戳，单位ms
 * @property-read int conversationType 1-单聊、2-群聊
 * @property-read string conversationId 加密的会话ID
 * @property-read string conversationTitle 会话标题（群聊时才有）
 * @property-read string senderId 加密的发送者ID
 * @property-read string senderNick 发送者昵称
 * @property-read string senderCorpId 发送者当前群的企业corpId（企业内部群有）
 * @property-read string senderStaffId 发送者在企业内的userid（企业内部群有）
 * @property-read string chatbotUserId 加密的机器人ID
 * @property-read array atUsers 被@人的信息 {dingtalkId: 加密的发送者ID staffId: 发送者在企业内的userid（企业内部群有）}
 */
class RobotReceivedMessageEntity
{
    const CONVERSATION_TYPE_SINGLE = 1;
    const CONVERSATION_TYPE_GROUP = 2;

    const MESSAGE_TYPE_TEXT = 'text';

    /**
     * @var int from header
     */
    protected $timestamp;
    /**
     * @var string from header
     */
    protected $sign;
    /**
     * @var array json, the parsed whole POST body
     */
    protected $body;

    /**
     * RobotReceivedMessageEntity constructor.
     * @param int $timestamp from header
     * @param string $sign from header
     * @param array $body parsed POST request body which is in JSON format
     */
    public function __construct($timestamp, $sign, $body)
    {
        $this->timestamp = $timestamp;
        $this->sign = $sign;

        $this->body = $body;
    }

    /**
     * @param string $appSecret
     * @param null|int $receivedTime PHP timestamp with 1000 times (as null for time()*1000)
     * @throws Exception
     */
    public function assertValidRequest($appSecret, $receivedTime = null)
    {
        if ($receivedTime === null) {
            $receivedTime = time() * 1000;
        }
        if ($this->timestamp > $receivedTime + 3600 * 1000 || $this->timestamp < $receivedTime - 3600 * 1000) {
            throw new Exception("not a valid request on time");
        }
        $stringToSign = $this->timestamp . "\n" . $appSecret;
        $computedSign = base64_encode(hash_hmac('sha256', $stringToSign, $appSecret, true));
        if ($this->sign != $computedSign) {
            throw new Exception("sign not same " . $this->sign . ' ~ ' . $computedSign);
        }
    }

    public function __isset($name)
    {
        switch ($name) {
            case 'msgType':
                return isset($this->body['msgtype']);
                break;
            case 'content':
                return isset($this->body[$this->msgType]) && isset($this->body[$this->msgType]['content']);
                break;
            default:
                return isset($this->body[$name]);
        }
    }

    public function __get($name)
    {
        switch ($name) {
            case 'msgType':
                return isset($this->body['msgtype']) ? $this->body['msgtype'] : false;
                break;
            case 'content':
                return (isset($this->body[$this->msgType]) && isset($this->body[$this->msgType]['content'])) ? $this->body[$this->msgType]['content'] : false;
                break;
            default:
                return isset($this->body[$name]) ? $this->body[$name] : false;
        }
    }
}