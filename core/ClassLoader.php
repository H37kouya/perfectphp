<?php

namespace Core;

class ClassLoader
{
    /**
     * クラス名を格納
     *
     * @var array
     */
    protected $dirs;

    /**
     * PHPにオートローダクラスを登録する処理する関数
     *
     * @return void
     */
    public function register(): void
    {
        spl_autoload_register(array($this, 'loadClass'));
    }

    /**
     * PHPにオートローダが実行された際にクラスファイルを読み込む処理をする関数
     *
     * @param string $dir
     * @return void
     */
    public function registerDir(string $dir): void
    {
        $this->dirs[] = $dir;
    }

    /**
     * クラスファイルの読み込みを行う関数
     *
     * @param string $class
     * @return void
     */
    public function loadClass(string $class): void
    {
        foreach ($this->dirs as $dir) {
            $file = $dir . '/' . $class . '.php';
            if (is_readable($file)) {
                require $file;

                return;
            }
        }
    }
}
