<?php
/**
 *
 *
 * User: Chu
 * Date: 2018/1/9
 * Time: 下午6:04
 */

namespace Yoshocon\Spgateway\Libraries;

use GuzzleHttp\Client;

class Helpers
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * 智付通資料加密
     *
     * @param      $postData
     *
     * @param null $key
     * @param null $iv
     *
     * @return string
     */
    public function encryptReceiptPostData($postData, $key = null, $iv = null)
    {
        // 所有資料與欄位使用 = 符號組合，並用 & 符號串起字串
        $postData = http_build_query($postData);

        // 加密字串
        $post_data = trim(bin2hex(openssl_encrypt(
            $this->addPadding($postData),
            'AES-256-CBC',
            config('spgateway.receipt.HashKey'),
            OPENSSL_RAW_DATA | OPENSSL_NO_PADDING,
            config('spgateway.receipt.HashIV')
        )));
        return $post_data;
    }

    public function encryptPostData($postData, $key = null, $iv = null)
    {
        // 所有資料與欄位使用 = 符號組合，並用 & 符號串起字串
        $postData = http_build_query($postData);

        // 加密字串
        $post_data = trim(bin2hex(openssl_encrypt(
            $this->addPadding($postData),
            'AES-256-CBC',
            config('spgateway.mpg.HashKey'),
            OPENSSL_RAW_DATA | OPENSSL_NO_PADDING,
            config('spgateway.mpg.HashIV')
        )));
        return $post_data;
    }

    public function addPadding($string, $blocksize = 32)
    {
        $len = strlen($string);
        $pad = $blocksize - ($len % $blocksize);
        $string .= str_repeat(chr($pad), $pad);
        return $string;
    }

    public function sendPostRequest($url, $postData, $headers = [])
    {
        return $this->client->request('POST', $url, ['form_params' => $postData, 'headers' => $headers])
                            ->getBody()
                            ->getContents();
    }

    /**
     * 產生訂單編號
     *
     * @return string
     */
    public function generateOrderNo()
    {
        return date('YmdHis') . str_random(6);
    }
}
