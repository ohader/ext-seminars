<?php

declare(strict_types=1);

namespace OliverKlee\Seminars\Tests\Functional\Domain\Repository\Event;

use Nimut\TestingFramework\TestCase\FunctionalTestCase;
use OliverKlee\Seminars\Domain\Model\Event\EventDate;
use OliverKlee\Seminars\Domain\Model\Event\EventInterface;
use OliverKlee\Seminars\Domain\Model\Event\EventTopic;
use OliverKlee\Seminars\Domain\Model\Event\SingleEvent;
use OliverKlee\Seminars\Domain\Repository\Event\EventRepository;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

/**
 * @covers \OliverKlee\Seminars\Domain\Model\Event\Event
 * @covers \OliverKlee\Seminars\Domain\Model\Event\SingleEvent
 * @covers \OliverKlee\Seminars\Domain\Model\Event\EventTopic
 * @covers \OliverKlee\Seminars\Domain\Model\Event\EventDate
 * @covers \OliverKlee\Seminars\Domain\Repository\Event\EventRepository
 */
final class EventRepositoryTest extends FunctionalTestCase
{
    protected $testExtensionsToLoad = ['typo3conf/ext/oelib', 'typo3conf/ext/seminars'];

    /**
     * @var EventRepository
     */
    private $subject;

    /**
     * @var PersistenceManager
     */
    private $persistenceManager;

    protected function setUp(): void
    {
        parent::setUp();

        if ((new Typo3Version())->getMajorVersion() >= 11) {
            $this->subject = GeneralUtility::makeInstance(EventRepository::class);
        } else {
            $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
            $this->subject = $objectManager->get(EventRepository::class);
        }

        $this->persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
    }

    /**
     * @test
     */
    public function mapsSingleEventWithAllFields(): void
    {
        $this->importDataSet(__DIR__ . '/Fixtures/EventRepository/SingleEventWithAllFields.xml');

        $result = $this->subject->findByUid(1);

        self::assertInstanceOf(SingleEvent::class, $result);
        self::assertSame('Jousting', $result->getInternalTitle());
    }

    /**
     * @test
     */
    public function mapsEventTopicWithAllFields(): void
    {
        $this->importDataSet(__DIR__ . '/Fixtures/EventRepository/EventTopicWithAllFields.xml');

        $result = $this->subject->findByUid(1);

        self::assertInstanceOf(EventTopic::class, $result);
        self::assertSame('Jousting topic', $result->getInternalTitle());
    }

    /**
     * @test
     */
    public function mapsEventDateWithAllFields(): void
    {
        $this->importDataSet(__DIR__ . '/Fixtures/EventRepository/EventDateAndTopicWithAllFields.xml');

        $result = $this->subject->findByUid(1);

        self::assertInstanceOf(EventDate::class, $result);
        self::assertSame('Jousting date', $result->getInternalTitle());
    }

    /**
     * @test
     */
    public function persistsSingleEventWithSingleEventRecordType(): void
    {
        $event = new SingleEvent();
        $this->subject->add($event);
        $this->persistenceManager->persistAll();

        $connection = $this->getConnectionPool()->getConnectionForTable('tx_seminars_seminars');
        $result = $connection
            ->executeQuery('SELECT * FROM tx_seminars_seminars WHERE uid = :uid', ['uid' => $event->getUid()]);
        if (\method_exists($result, 'fetchAssociative')) {
            $databaseRow = $result->fetchAssociative();
        } else {
            $databaseRow = $result->fetch();
        }

        self::assertIsArray($databaseRow);
        self::assertSame(EventInterface::TYPE_SINGLE_EVENT, $databaseRow['object_type']);
    }

    /**
     * @test
     */
    public function persistsEventTopicWithEventTopicType(): void
    {
        $event = new EventTopic();
        $this->subject->add($event);
        $this->persistenceManager->persistAll();

        $connection = $this->getConnectionPool()->getConnectionForTable('tx_seminars_seminars');
        $result = $connection
            ->executeQuery('SELECT * FROM tx_seminars_seminars WHERE uid = :uid', ['uid' => $event->getUid()]);
        if (\method_exists($result, 'fetchAssociative')) {
            $databaseRow = $result->fetchAssociative();
        } else {
            $databaseRow = $result->fetch();
        }

        self::assertIsArray($databaseRow);
        self::assertSame(EventInterface::TYPE_EVENT_TOPIC, $databaseRow['object_type']);
    }

    /**
     * @test
     */
    public function persistsEventDateWithEventDateType(): void
    {
        $event = new EventDate();
        $this->subject->add($event);
        $this->persistenceManager->persistAll();

        $connection = $this->getConnectionPool()->getConnectionForTable('tx_seminars_seminars');
        $result = $connection
            ->executeQuery('SELECT * FROM tx_seminars_seminars WHERE uid = :uid', ['uid' => $event->getUid()]);
        if (\method_exists($result, 'fetchAssociative')) {
            $databaseRow = $result->fetchAssociative();
        } else {
            $databaseRow = $result->fetch();
        }

        self::assertIsArray($databaseRow);
        self::assertSame(EventInterface::TYPE_EVENT_DATE, $databaseRow['object_type']);
    }
}
