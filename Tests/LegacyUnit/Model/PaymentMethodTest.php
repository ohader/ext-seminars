<?php

declare(strict_types=1);

namespace OliverKlee\Seminars\Tests\LegacyUnit\Model;

use OliverKlee\Seminars\Model\PaymentMethod;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OliverKlee\Seminars\Model\PaymentMethod
 */
final class PaymentMethodTest extends TestCase
{
    /**
     * @var PaymentMethod
     */
    private $subject;

    protected function setUp(): void
    {
        $this->subject = new PaymentMethod();
    }
    /**
     * @test
     */
    public function getTitleWithNonEmptyTitleReturnsTitle(): void
    {
        $this->subject->setData(['title' => 'Cash']);

        self::assertEquals(
            'Cash',
            $this->subject->getTitle()
        );
    }

    /////////////////////////////////////
    // Tests regarding the description.
    /////////////////////////////////////

    /**
     * @test
     */
    public function getDescriptionWithoutDescriptionReturnsAnEmptyString(): void
    {
        $this->subject->setData([]);

        self::assertEquals(
            '',
            $this->subject->getDescription()
        );
    }

    /**
     * @test
     */
    public function getDescriptionWithDescriptionReturnsDescription(): void
    {
        $this->subject->setData(['description' => 'Just plain cash, baby!']);

        self::assertEquals(
            'Just plain cash, baby!',
            $this->subject->getDescription()
        );
    }

    /**
     * @test
     */
    public function setDescriptionSetsDescription(): void
    {
        $this->subject->setDescription('Just plain cash, baby!');

        self::assertEquals(
            'Just plain cash, baby!',
            $this->subject->getDescription()
        );
    }

    /**
     * @test
     */
    public function hasDescriptionWithoutDescriptionReturnsFalse(): void
    {
        $this->subject->setData([]);

        self::assertFalse(
            $this->subject->hasDescription()
        );
    }

    /**
     * @test
     */
    public function hasDescriptionWithDescriptionReturnsTrue(): void
    {
        $this->subject->setDescription('Just plain cash, baby!');

        self::assertTrue(
            $this->subject->hasDescription()
        );
    }
}
