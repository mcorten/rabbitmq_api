<?php

namespace mcorten87\messagequeue_management\exceptions;


use mcorten87\messagequeue_management\objects\CallerObjectInfo;

class BaseException extends \Exception
{

    protected function getCallerInfo() : CallerObjectInfo {
        $backtrace = debug_backtrace();
        $backtrace = $backtrace[2]; // 0 = InvalidDataException, 1 = BaseObject, 2 = the Object we need

        $callerObjectInfo = new CallerObjectInfo($backtrace['file'], $backtrace['args'][0]);
        return $callerObjectInfo;
    }
}