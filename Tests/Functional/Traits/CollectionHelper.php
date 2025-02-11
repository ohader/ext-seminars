<?php

declare(strict_types=1);

namespace OliverKlee\Seminars\Tests\Functional\Traits;

use OliverKlee\Oelib\DataStructures\Collection;

/**
 * This trait provides methods useful for testing collections (usually in functional tests).
 */
trait CollectionHelper
{
    private static function assertContainsModelWithUid(Collection $models, int $uid): void
    {
        self::assertTrue($models->hasUid($uid));
    }

    private static function assertNotContainsModelWithUid(Collection $models, int $uid): void
    {
        self::assertFalse($models->hasUid($uid));
    }
}
