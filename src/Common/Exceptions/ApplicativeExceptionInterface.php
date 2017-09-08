<?php

namespace Chemem\Bingo\Functional\Common\Exceptions;

interface ApplicativeExceptionInterface
{
    public static function invalidApplicationOperation(ApplicativeAbstract $value);
}
