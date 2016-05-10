<?php

namespace TeebotTest\Command;

use Teebot\Config;
use TeebotTest\AbstractTestCase;
use Teebot\Command\Handler;
use Teebot\Entity\Update;
use Teebot\Entity\Error;
use Teebot\Entity\Message;
use Teebot\Entity\Chat;
use Teebot\Entity\From;
use Teebot\Exception\Notice;
use Teebot\Entity\AbstractEntity;

class HandlerTest extends AbstractTestCase
{
    /** @var Handler */
    protected $handler;

    public function setUp()
    {
        $config = $this->getConfigMock();

        $this->handler = Handler::getInstance();
        $this->handler->initWithConfig($config);
    }

    public function registerMockObject($object) {}

    public function dataProviderProcessEntities()
    {
        return [
            [
                new Update([   // decoded from json data for "update" entity
                    'update_id' => '696864219',
                    'message'   => [
                        'message_id' => '3891',
                        'from'       => [
                            'id'         => '56293731',
                            'first_name' => 'Stan',
                            'last_name'  => 'Drozdov'
                        ],
                        'chat'       => [
                            'id'         => '56293731',
                            'first_name' => 'Stan',
                            'last_name'  => 'Drozdov',
                            'type'       => 'private'
                        ],
                        'date'       => '1460071727',
                        'text'       => 'Text'
                    ]
                ]),
                Update::class,
                Message::ENTITY_TYPE,
                true
            ],
            [
                new Error([
                    'error_code'  => '400',
                    'description' => 'Wrong parameters sent!'
                ]),
                Error::class,
                null,
                true
            ]
        ];
    }

    /**
     * Tests that config is an instance of Teebot\Config class
     */
    public function testGetConfig()
    {
        $this->assertInstanceOf(Config::class, $this->handler->getConfig());
    }

    /**
     * Tests entities processing
     *
     * @dataProvider dataProviderProcessEntities
     *
     * @param array  $mainEntity     Main entity class
     * @param string $expectedClass  Expected class of main entity
     * @param string $updateType     Type of the update (if it is Update)
     * @param bool   $expectedResult Expected result of method's execution
     */
    public function testProcessEntities($mainEntity, $expectedClass, $updateType, $expectedResult)
    {
        $this->assertInstanceOf($expectedClass, $mainEntity);

        $entities = [$mainEntity];

        $result = $this->handler->processEntities($entities);

        $this->assertSame($expectedResult, $result);

        if ($mainEntity instanceof Update) {
            $this->assertSame($mainEntity->getUpdateType(), $updateType);
        }
    }

    /**
     * Tests that processEntities throws an exception
     */
    public function testProcessEntitiesException()
    {
        $entities = [
            new \stdClass(),
        ];

        try {
            $this->handler->processEntities($entities);
        } catch (\Exception $e) {
            $this->assertInstanceOf(Notice::class, $e);
        }
    }

    /**
     * Data provider for testing getEtitiesFlow()
     *
     * @return array
     */
    public function dataProviderGetEntitiesChain()
    {
        $entities = $this->dataProviderProcessEntities();

        return [
            [
                $entities[0][0],
                [
                    ['entity' => Update::class],
                    [
                        'entity' => Message::class,
                        'parent' => Message::class
                    ]

                ]
            ],
            [
                $entities[1][0],
                [
                    ['entity' => Error::class]
                ]
            ]
        ];
    }

    /**
     * Tests getEntitiesChain() method which builds an event flow from received nested entities
     *
     * @dataProvider dataProviderGetEntitiesChain
     *
     * @param AbstractEntity $entity        Entity
     * @param array          $instancesFlow Instances flow
     */
    public function testGetEntitiesChain($entity, $instancesFlow)
    {
        $flow = $this->handler->getEntitiesChain($entity);

        for ($i = 0; $i < count($flow); $i++) {
            $flowStep      = $flow[$i];
            $instancesStep = $instancesFlow[$i];

            $this->assertCount(count($instancesStep), $flowStep);

            foreach ($instancesStep as $key => $class) {
                $this->assertArrayHasKey($key, $flowStep);
                $this->assertInstanceOf($class, $flowStep[$key]);
            }
        }
    }
}
