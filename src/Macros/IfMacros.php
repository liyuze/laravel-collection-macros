<?php

namespace Liyuze\CollectionMacros\Macros;

class IfMacros
{
    public static function ifThen()
    {
        return function (mixed $value): IfHigherOrderCollectionProxy {
            return new IfHigherOrderCollectionProxy($this, boolval(value($value)));
        };
    }

    public static function unlessThen()
    {
        return function (mixed $value): IfHigherOrderCollectionProxy {
            return new IfHigherOrderCollectionProxy($this, !boolval(value($value)));
        };
    }
}
