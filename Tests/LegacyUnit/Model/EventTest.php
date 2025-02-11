<?php

declare(strict_types=1);

namespace OliverKlee\Seminars\Tests\LegacyUnit\Model;

use OliverKlee\Oelib\Configuration\ConfigurationRegistry;
use OliverKlee\Oelib\Configuration\DummyConfiguration;
use OliverKlee\Oelib\DataStructures\Collection;
use OliverKlee\Oelib\Mapper\LanguageMapper;
use OliverKlee\Oelib\Mapper\MapperRegistry;
use OliverKlee\Seminars\Mapper\RegistrationMapper;
use OliverKlee\Seminars\Model\Event;
use OliverKlee\Seminars\Model\Registration;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OliverKlee\Seminars\Model\AbstractTimeSpan
 * @covers \OliverKlee\Seminars\Model\Event
 */
final class EventTest extends TestCase
{
    /**
     * @var Event
     */
    private $subject;

    /**
     * @var int
     */
    protected $now = 1424751343;

    protected function setUp(): void
    {
        $GLOBALS['SIM_EXEC_TIME'] = $this->now;
        $configurationRegistry = ConfigurationRegistry::getInstance();
        $configuration = new DummyConfiguration();
        $configurationRegistry->set('plugin.tx_seminars', $configuration);

        $this->subject = new Event();
    }

    protected function tearDown(): void
    {
        ConfigurationRegistry::purgeInstance();
    }

    /////////////////////////////////////
    // Tests regarding isSingleEvent().
    /////////////////////////////////////

    /**
     * @test
     */
    public function getLanguageWithLanguageReturnsLanguage(): void
    {
        $this->subject->setData(['language' => 'DE']);

        self::assertSame(
            MapperRegistry::get(LanguageMapper::class)->findByIsoAlpha2Code('DE'),
            $this->subject->getLanguage()
        );
    }

    /**
     * @test
     */
    public function setLanguageSetsLanguage(): void
    {
        $language = MapperRegistry::get(LanguageMapper::class)->findByIsoAlpha2Code('DE');
        $this->subject->setLanguage($language);

        self::assertSame(
            $language,
            $this->subject->getLanguage()
        );
    }

    /**
     * @test
     */
    public function hasLanguageWithLanguageReturnsTrue(): void
    {
        $language = MapperRegistry::get(LanguageMapper::class)->findByIsoAlpha2Code('DE');
        $this->subject->setLanguage($language);

        self::assertTrue(
            $this->subject->hasLanguage()
        );
    }

    /**
     * @test
     */
    public function getRegularRegistrationsReturnsRegularRegistrations(): void
    {
        /** @var Collection<Registration> $registrations */
        $registrations = new Collection();
        $registration = MapperRegistry::get(RegistrationMapper::class)
            ->getLoadedTestingModel(['registration_queue' => 0]);
        $registrations->add($registration);
        $this->subject->setRegistrations($registrations);

        self::assertEquals(
            $registration->getUid(),
            $this->subject->getRegularRegistrations()->getUids()
        );
    }

    /**
     * @test
     */
    public function getRegularRegistrationsNotReturnsQueueRegistrations(): void
    {
        /** @var Collection<Registration> $registrations */
        $registrations = new Collection();
        $registration = MapperRegistry::get(RegistrationMapper::class)
            ->getLoadedTestingModel(['registration_queue' => 1]);
        $registrations->add($registration);
        $this->subject->setRegistrations($registrations);

        self::assertTrue(
            $this->subject->getRegularRegistrations()->isEmpty()
        );
    }

    /**
     * @test
     */
    public function getQueueRegistrationsReturnsQueueRegistrations(): void
    {
        /** @var Collection<Registration> $registrations */
        $registrations = new Collection();
        $registration = MapperRegistry::get(RegistrationMapper::class)
            ->getLoadedTestingModel(['registration_queue' => 1]);
        $registrations->add($registration);
        $this->subject->setRegistrations($registrations);

        self::assertEquals(
            $registration->getUid(),
            $this->subject->getQueueRegistrations()->getUids()
        );
    }

    public function getQueueRegistrationsNotReturnsRegularRegistrations(): void
    {
        /** @var Collection<Registration> $registrations */
        $registrations = new Collection();
        $registration = MapperRegistry::get(RegistrationMapper::class)
            ->getLoadedTestingModel(['registration_queue' => 0]);
        $registrations->add($registration);
        $this->subject->setRegistrations($registrations);

        self::assertTrue(
            $this->subject->getQueueRegistrations()->isEmpty()
        );
    }

    /**
     * @test
     */
    public function hasQueueRegistrationsForOneQueueRegistrationReturnsTrue(): void
    {
        $registrations = new Collection();
        $registration = MapperRegistry::get(RegistrationMapper::class)
            ->getLoadedTestingModel(['registration_queue' => 1]);
        $registrations->add($registration);
        $event = $this->createPartialMock(
            Event::class,
            ['getQueueRegistrations']
        );
        $event->method('getQueueRegistrations')
            ->willReturn($registrations);

        self::assertTrue(
            $event->hasQueueRegistrations()
        );
    }

    /**
     * @test
     */
    public function getRegisteredSeatsCountsSingleSeatRegularRegistrations(): void
    {
        $registrations = new Collection();
        $registration = MapperRegistry::get(RegistrationMapper::class)
            ->getLoadedTestingModel(['seats' => 1]);
        $registrations->add($registration);
        $event = $this->createPartialMock(
            Event::class,
            ['getRegularRegistrations']
        );
        $event->setData([]);
        $event->method('getRegularRegistrations')
            ->willReturn($registrations);

        self::assertEquals(
            1,
            $event->getRegisteredSeats()
        );
    }

    /**
     * @test
     */
    public function getRegisteredSeatsCountsMultiSeatRegularRegistrations(): void
    {
        $registrations = new Collection();
        $registration = MapperRegistry::get(RegistrationMapper::class)
            ->getLoadedTestingModel(['seats' => 2]);
        $registrations->add($registration);
        $event = $this->createPartialMock(
            Event::class,
            ['getRegularRegistrations']
        );
        $event->setData([]);
        $event->method('getRegularRegistrations')
            ->willReturn($registrations);

        self::assertEquals(
            2,
            $event->getRegisteredSeats()
        );
    }

    /**
     * @test
     */
    public function getRegisteredSeatsNotCountsQueueRegistrations(): void
    {
        $queueRegistrations = new Collection();
        $registration = MapperRegistry::get(RegistrationMapper::class)
            ->getLoadedTestingModel(['seats' => 1]);
        $queueRegistrations->add($registration);
        $event = $this->createPartialMock(
            Event::class,
            ['getRegularRegistrations', 'getQueueRegistrations']
        );
        $event->setData([]);
        $event->method('getQueueRegistrations')
            ->willReturn($queueRegistrations);
        $event->method('getRegularRegistrations')
            ->willReturn(new Collection());

        self::assertEquals(
            0,
            $event->getRegisteredSeats()
        );
    }

    /**
     * @test
     */
    public function attachRegistrationAddsRegistration(): void
    {
        /** @var Collection<Registration> $registrations */
        $registrations = new Collection();
        $this->subject->setRegistrations($registrations);

        $registration = MapperRegistry::get(RegistrationMapper::class)->getLoadedTestingModel([]);
        $this->subject->attachRegistration($registration);

        self::assertTrue(
            $this->subject->getRegistrations()->hasUid($registration->getUid())
        );
    }

    /**
     * @test
     */
    public function attachRegistrationNotRemovesExistingRegistration(): void
    {
        /** @var Collection<Registration> $registrations */
        $registrations = new Collection();
        $oldRegistration = MapperRegistry::get(RegistrationMapper::class)->getNewGhost();
        $registrations->add($oldRegistration);
        $this->subject->setRegistrations($registrations);

        $newRegistration = MapperRegistry::get(RegistrationMapper::class)->getLoadedTestingModel([]);
        $this->subject->attachRegistration($newRegistration);

        self::assertTrue(
            $this->subject->getRegistrations()->hasUid($oldRegistration->getUid())
        );
    }

    /**
     * @test
     */
    public function attachRegistrationSetsEventForRegistration(): void
    {
        /** @var Collection<Registration> $registrations */
        $registrations = new Collection();
        $this->subject->setRegistrations($registrations);

        $registration = MapperRegistry::get(RegistrationMapper::class)->getLoadedTestingModel([]);
        $this->subject->attachRegistration($registration);

        self::assertSame(
            $this->subject,
            $registration->getEvent()
        );
    }
}
