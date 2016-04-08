<?php

use Teebot\Command\Executor;
use Teebot\Entity\Update;
use Teebot\Entity\Error;
use Teebot\Entity\Message;
use Teebot\Entity\Chat;
use Teebot\Entity\From;
use Teebot\Exception\Notice;

class ExecutorTest extends AbstractTestCase
{
    /** @var Executor */
    protected $executor;

    public function setUp()
    {
        $config = $this->getConfigMock();

        $this->executor = Executor::getInstance();
        $this->executor->initWithConfig($config);
    }

    public function dataProviderProcessEntities()
    {
        return [
            [
                new Update([   // decoded from json data for "update" entity
                    'update_id' => '696864219',
                    'message' => [
                        'message_id' => '3891',
                        'from' => [
                            'id' => '56293731',
                            'first_name' => 'Stan',
                            'last_name' => 'Drozdov'
                        ],
                        'chat' => [
                            'id' => '56293731',
                            'first_name' => 'Stan',
                            'last_name' => 'Drozdov',
                            'type' => 'private'
                        ],
                        'date' => '1460071727',
                        'text' => 'Text'
                    ]
                ]),
                Update::class,
                Message::ENTITY_TYPE,
                true
            ],
            [
                new Error([
                    'error_code' => '400',
                    'description' => 'Wrong parameters sent!'
                ]),
                Error::class,
                null,
                true
            ],
            [
                new \stdClass(),
                stdClass::class,
                null,
                false
            ]
        ];
    }

    /**
     * Tests entities processing
     *
     * @dataProvider dataProviderProcessEntities
     *
     * @covers       Teebot\Command\Executor::processEntities()
     * @covers       Teebot\Command\Executor::getEntitiesFlow()
     * @covers       Teebot\Command\Executor::processEntitiesFlow()
     *
     * @param array $mainEntity Main entity class
     * @param string $expectedClass Expected class of main entity
     * @param string $updateType Type of the update (if it is Update)
     */
    public function testProcessEntities($mainEntity, $expectedClass, $updateType, $expectedResult)
    {
        $this->assertInstanceOf($expectedClass, $mainEntity);

        $entities = [$mainEntity];

        $result = $this->executor->processEntities($entities);

        $this->assertSame($expectedResult, $result);

        if ($mainEntity instanceof Update) {
            $this->assertSame($mainEntity->getUpdateType(), $updateType);
        }
    }
}