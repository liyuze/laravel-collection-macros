<?php

namespace Liyuze\CollectionMacros\Tests\Macros;

use Liyuze\CollectionMacros\Tests\TestCase;

class IfMacrosTest extends TestCase
{
    public function test_if_then()
    {
        $sort = true;
        $value = collect([2, 1, 3])->ifThen($sort)->sort()->ifThen(!$sort)->sortDesc()->value()->first();
        $this->assertEquals(1, $value);
        $sort = false;
        $value = collect([2, 1, 3])->ifThen($sort)->sort()->ifThen(!$sort)->sortDesc()->value()->first();
        $this->assertEquals(3, $value);
    }

    public function test_if_then_for_multi_true()
    {
        $data = collect([1, 2, 3]);
        $value = $data->ifThen(true)->map(fn($v) => $v * 2)
            ->ifThen(true)->avg()
            ->ifThen(false)->count()
            ->value();
        $this->assertEquals(4, $value);
    }

    public function test_unless_then()
    {
        $sort = true;
        $value = collect([2, 1, 3])->unlessThen($sort)->sort()->unlessThen(!$sort)->sortDesc()->value()->first();
        $this->assertEquals(3, $value);
        $sort = false;
        $value = collect([2, 1, 3])->unlessThen($sort)->sort()->unlessThen(!$sort)->sortDesc()->value()->first();
        $this->assertEquals(1, $value);
    }

    public function test_else()
    {
        $sort = true;
        $value = collect([2, 1, 3])->ifThen($sort)->sort()->else()->sortDesc()->value()->first();
        $this->assertEquals(1, $value);
        $sort = false;
        $value = collect([2, 1, 3])->ifThen($sort)->sort()->else()->sortDesc()->value()->first();
        $this->assertEquals(3, $value);
    }

    public function test_unless_then_for_multi_false()
    {
        $data = collect([1, 2, 3]);
        $this->assertEquals(4, $data->unlessThen(false)->map(fn($v) => $v * 2)->unlessThen(false)->avg()->value());
    }

    public function test_after()
    {
        $data = collect([1, 2, 3]);
        $this->assertEquals(2, $data->ifThen(true)->sum()->after(fn($v, $c) => $v / $c->count())->value());
    }

    public function test_value_default_value()
    {
        $data = collect([1, 2, 3]);
        $this->assertEquals(0, $data->ifThen(true)->first(fn($v) => $v > 10)->value(0));
    }
}