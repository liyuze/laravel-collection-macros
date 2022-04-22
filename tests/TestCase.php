<?php

namespace Liyuze\CollectionMacros\Tests;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            'Liyuze\CollectionMacros\CollectionMacrosServiceProvider',
        ];
    }
}