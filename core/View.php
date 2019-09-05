<?php

class View
{
    /**
     * base_url
     *
     * @var string
     */
    protected $base_dir;

    /**
     * デフォルト
     *
     * @var array
     */
    protected $defaults;

    /**
     * Undocumented variable
     *
     * @var array
     */
    protected $layout_variables = [];

    public function __construct(string $base_dir, array $defaults = [])
    {
        $this->base_dir = $base_dir;
        $this->defaults = $defaults;
    }

    /**
     * レイアウトに渡す変数を指定
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function setLayoutVar(string $name, $value): void
    {
        $this->layout_variables[$name] = $value;
    }

    /**
     * ビューファイルをレンダリング
     *
     * @param string $_path
     * @param array $_variables
     * @param string|bool $_layout
     * @return string
     */
    public function render(string $_path, array $_varibales = [], $_layout = false): string
    {
        $_file = $this->base_dir . '/' .$_path . '.php';

        // 連想配列のそれぞれの要素を変数展開
        extract(array_merge($this->defaults, $_varibales));

        // アウトプットバッファリングの開始
        ob_start();
        // 自動フラッシュの無効
        ob_implicit_flush(0);

        require $_file;

        // 内部のバッファの取得
        $content = ob_get_clean();

        // 何か変数に入っていれば if の中へ
        if ($_layout) {
            $content = $this->render(
                (string)$_layout,
                array_merge($this->layout_variables, [
                '_content' => $content
                ])
            );
        }

        return $content;
    }

    /**
     * 値をエスケープする
     *
     * @param string $string
     * @return string
     */
    public function escape(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}
