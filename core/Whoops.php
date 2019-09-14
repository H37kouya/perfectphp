<?php

namespace Core;

use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;

class Whoops
{
    /**
     * whoops\Run クラスの格納
     *
     * @var Run
     */
    protected $whoops;

    public function __construct()
    {
        $this->initialize();
        $this->register();
    }

    protected function initialize(): void
    {
        $this->whoops = new Run;
    }

    public function getWhoops(): Run
    {
        return $this->whoops;
    }

    protected function register(): void
    {
        $this->whoops->prependHandler(new PrettyPageHandler);
        $this->whoops->register();
    }
}
