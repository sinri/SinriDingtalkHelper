<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/9/30
 * Time: 14:06
 */

namespace sinri\sinridingtalkhelper\ApiHelper;


class SinriDingtalkHelper
{
    const METHOD_HEAD = "HEAD";//since v1.3.0
    const METHOD_GET = "GET";//since v1.3.0
    const METHOD_POST = "POST";//since v1.3.0
    const METHOD_PUT = "PUT";//since v1.3.0
    const METHOD_DELETE = "DELETE";//since v1.3.0
    const METHOD_OPTION = "OPTION";//since v1.3.0
    const METHOD_PATCH = "PATCH";//since v1.3.0
    const METHOD_CLI = "cli";//since v1.3.0

    /**
     * @since 2.0.0 turn to static
     * @param $method
     * @param $url
     * @param null|array|string $data
     * @param array $headers
     * @param array $cookies
     * @param bool $bodyAsJson
     * @return bool|string
     */
    public static function executeCurl($method, $url, $data = null, $headers = [], $cookies = [], $bodyAsJson = false)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $use_body = in_array($method, [self::METHOD_POST, self::METHOD_PUT]);
        if ($use_body) {
            curl_setopt($ch, CURLOPT_POST, 1);
        }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if ($data !== null) {
            if ($use_body) {
                $body = $data;
                if (is_array($data)) {
                    if ($bodyAsJson) {
                        $json_body_header = 'Content-Type: application/json';
                        if (!in_array($json_body_header, $headers)) {
                            $headers[] = $json_body_header;
                        }
                        $body = json_encode($data);
                    } else {
                        $body = http_build_query($data);
                    }
                }
                curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            } else {
                $body = null;
                $query_string = http_build_query($data);
                if (!empty($query_string)) {
                    $url .= "?" . $query_string;
                }
            }
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        if (!empty($cookies)) {
            curl_setopt($ch, CURLOPT_COOKIE, implode(';', $cookies));
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    /**
     * 按照PSR-0规范，不过PSR-4看起来也是支持的
     * @since 2.0.0 turn to static
     * @param string $class_name such as sinri\enoch\test\routing\controller\SampleHandler
     * @param string $base_namespace such as sinri\enoch
     * @param string $base_path /code/sinri/enoch
     * @param string $extension
     * @return null|string
     */
    public static function getFilePathOfClassNameWithPSR0($class_name, $base_namespace, $base_path, $extension = '.php')
    {
        if (strpos($class_name, $base_namespace) === 0) {
            $class_file = str_replace($base_namespace, $base_path, $class_name);
            $class_file .= $extension;
            $class_file = str_replace('\\', '/', $class_file);
            return $class_file;
        }
        return null;
    }
}