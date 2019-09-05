<?php

namespace Core;

class Response
{
    /**
     * content
     *
     * @var string
     */
    protected $content;

    /**
     * HTTPステータスコードの格納
     *
     * @var integer
     */
    protected $status_code = 200;

    /**
     * HTTPステータスコードのテキストを格納
     *
     * @var string
     */
    protected $status_text = 'OK';

    /**
     *
     *
     * @var array
     */
    protected $http_header = [];

    /**
     * レスポンスの送信を行う関数
     *
     * @return void
     */
    public function send(): void
    {
        header('HTTP/1.1' . $this->status_code . '' . $this->status_text);

        foreach ($this->http_header as $name => $value) {
            header($name, ':', $value);
        }

        echo $this->content;
    }

    /**
     * HTMLなどの実際にクライアントに返す内容を格納
     *
     * @param string $content
     * @return void
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * HTTPのステータスコードの格納
     *
     * @param integer $status_code
     * @param string $status_text
     * @return void
     */
    public function setStatusCode(int $status_code, string $status_text = ''): void
    {
        $this->status_code = $status_code;
        $this->status_text = $status_text;
    }

    /**
     * HTTpヘッダの格納
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function setHttpHeader(string $name, $value): void
    {
        $this->http_header[$name] = $value;
    }
}
