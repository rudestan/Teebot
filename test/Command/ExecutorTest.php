<?php

namespace TeebotTest\Command;

use Symfony\Component\Config\Definition\Exception\Exception;
use TeebotTest\AbstractTestCase;
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

        $result = $this->executor->processEntities($entities);

        $this->assertSame($expectedResult, $result);

        if ($mainEntity instanceof Update) {
            $this->assertSame($mainEntity->getUpdateType(), $updateType);
        }
    }

    /**
     * Tests that processEntities throws an exception
     */
    public function testException()
    {
        $entities = [
            new \stdClass(),
        ];

        try {
            $this->executor->processEntities($entities);
        } catch (\Exception $e) {
            $this->assertInstanceOf(Notice::class, $e);
        }
    }
}