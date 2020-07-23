<?php

declare(strict_types=1);

namespace App\Helper;

use function array_udiff_assoc;

class ArrayDiff
{
    /** @var array */
    private $oldData;

    /** @var array */
    private $newData;

    public function __construct(array $oldData = [], array $newData = [])
    {
        $this->oldData = $oldData;
        $this->newData = $newData;
    }

    public function getDeleteDiff()
    {
        return array_udiff_assoc(
            $this->oldData,
            $this->newData,
            static function ($a, $b) {
                return $a === $b ? 0 : 1;
            }
        );
    }

    public function getInsertDiff()
    {
        return array_udiff_assoc(
            $this->newData,
            $this->oldData,
            static function ($a, $b) {
                return $a === $b ? 0 : 1;
            }
        );
    }
}
