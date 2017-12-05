<?php

require __DIR__ . '/vendor/autoload.php';

use Chemem\Bingo\Functional\Algorithms as A;
use Chemem\Bingo\Functional\Common\Callbacks as CB;

set_exception_handler(
    function (object $error) {
        echo json_encode(['code' => $error->getCode(), 'msg' => $error->getMessage()]);
    }
);

var_dump(A\pluck('string', 'chemem', CB\invalidArrayKey));


