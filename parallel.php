<?php

require_once "./vendor/autoload.php";

\Amp\Parallel\Worker\createWorker();

\Amp\async(static function () {
    var_dump("test ?");
})->await();

//Process exit()