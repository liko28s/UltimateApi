<?php

namespace Nextria\Helpers;

use Monolog\Handler\StreamHandler;

class Logger {
    /** @var \Monolog\Logger  */
    private $loggerInstance;
    /** @var string  */
    private $path;
    /** @var string  */
    private $fileName;
    /** @param string|null $userName*/
    public function __construct($userName = null) {
        $this->fileName = $userName ? "$userName.txt" : "log.txt";
        $this->path = "logs/".date('Y-m-d')."/";
        $this->createPath();
        $this->loggerInstance = new \Monolog\Logger('SIGRIHC_LOGGER');
        $this->loggerInstance->pushHandler(new StreamHandler($this->path.$this->fileName));
    }
    /** @return void */
    public function createPath() {
        mkdir($this->path,0777,true);
    }
    /** @return \Monolog\Logger */
    public function getInstance() {
        return $this->loggerInstance;
    }
}