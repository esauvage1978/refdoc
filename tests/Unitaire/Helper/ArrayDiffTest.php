<?php

declare(strict_types=1);

namespace App\Tests\Unitaire\Helper;

use App\Helper\ArrayDiff;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArrayDiffTest extends WebTestCase
{

    /**
     * @dataProvider datas
     */
    public function testArrayDiff($array1, $array2, $delete, $insert): void
    {
        $ad = new ArrayDiff($array1, $array2);
        $this->assertSame($ad->getDeleteDiff(), $delete,' Delete');
        $this->assertSame($ad->getInsertDiff(), $insert,' insert');
    }
    public function datas()
    {
        yield [
            [],
            [],
            [],
            []
        ];

        yield [
            ['1'=>'a'],
            [],
            ['1' => 'a'],
            []
        ];

        yield [
            [],
            ['1' => 'a'],
            [],
            ['1' => 'a']
        ];

        yield [
            ['1' => 'a', '2' => 'b'],
            ['1' => 'a', '2' => 'c'],
            ['2' => 'b'],
            ['2' => 'c']
        ];

    }
}
