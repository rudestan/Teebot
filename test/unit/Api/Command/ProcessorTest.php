<?php

namespace TeebotUnitTest\Api\Command;

use PHPUnit_Framework_TestCase as TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Teebot\Api\Command\{
    Processor,
    ValueObject\ChainItem
};
use Teebot\Api\Entity\{
    Audio,
    Error,
    Message,
    Update,
    User,
    MessageEntity
};
use Teebot\Api\Method\{
    GetUpdates,
    SendMessage
};
use Teebot\Api\{
    Response,
    HttpClient
};
use Teebot\Configuration\ContainerInterface;

/**
 * Test case for the Processor class
 */
class ProcessorTest extends TestCase
{
    /**
     * @var Processor
     */
    protected $sut;

    /**
     * @var ContainerInterface|ObjectProphecy
     */
    protected $configContainerProphecy;

    /**
     * @var HttpClient|ObjectProphecy
     */
    protected $httpClientProphecy;

    protected function setUp()
    {
        $this->configContainerProphecy = $this->prophesize('Teebot\Configuration\ContainerInterface');
        $this->httpClientProphecy      = $this->prophesize('Teebot\Api\HttpClient');
        $this->sut                     = new Processor($this->configContainerProphecy->reveal(),
            $this->httpClientProphecy->reveal());
    }

    /**
     * Tests whether processEntities throws an exception in case the entity chain is empty. Normally there shoud be
     * either Error or Update entity in the entities array.
     *
     * @expectedException \Teebot\Api\Exception\ProcessEntitiesException
     */
    public function testProcessEntitiesThrowsException()
    {
        $messageEntity = new MessageEntity();

        $this->sut->processEntities([$messageEntity]);
    }

    /**
     * Data provider for testGetEntitiesChain
     *
     * @return array
     */
    public function getEntitiesChainDataProvider(): array
    {
        $errorEntity = new Error();

        $message      = new Message(['message' => []]);
        $updateEntity = new Update();
        $updateEntity->setMessage($message);

        $audio    = new Audio([]);
        $message2 = new Message(['message' => []]);
        $message2->setAudio($audio);
        $updateEntity2 = new Update();
        $updateEntity2->setMessage($message2);

        return [
            [
                $errorEntity,
                [
                    new ChainItem($errorEntity),
                ],
            ],
            [
                new MessageEntity(),
                [],
            ],
            [
                $updateEntity,
                [
                    new ChainItem($updateEntity),
                    new ChainItem($message, $message),
                ],
            ],
            [
                $updateEntity2,
                [
                    new ChainItem($updateEntity2),
                    new ChainItem($message2, $message2),
                    new ChainItem($audio, $message2),
                ],
            ],
        ];
    }

    /**
     * Tests whether getEntitiesChain returns a valid result
     *
     * @param       $entity
     * @param array $expectedResult
     *
     * @dataProvider getEntitiesChainDataProvider
     */
    public function testGetEntitiesChain($entity, array $expectedResult)
    {
        $actualResult = $this->sut->getEntitiesChain($entity);
        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * Tests that valid Response object returned if valid json data received
     */
    public function testCall()
    {
        $sendMessageMethod = new SendMessage([
            'chat_id' => 123,
            'text'    => 'Text',
        ]);

        $options = [
            'query' => [
                'chat_id' => 123,
                'text'    => 'Text',
            ],
        ];

        $this->httpClientProphecy->request($sendMessageMethod->getName(), $options)->shouldBeCalled(1);
        $this->httpClientProphecy
            ->request($sendMessageMethod->getName(), $options)
            ->willReturn('{"ok":true,"result":[]}')
            ->shouldBeCalled(1);

        $actualResponse = $this->sut->call($sendMessageMethod);

        $this->assertInstanceOf(Response::class, $actualResponse);
        $this->assertFalse($actualResponse->isErrorReceived());
        $this->assertSame(0, $actualResponse->getEntitiesCount());
    }

    /**
     * Tests that valid Response object returned if valid json data received
     *
     * @expectedException \Teebot\Api\Exception\DecodingDataException
     */
    public function testCallThrowsDecodingException()
    {
        $sendMessageMethod = new SendMessage([
            'chat_id' => 123,
            'text'    => 'Text',
        ]);

        $options = [
            'query' => [
                'chat_id' => 123,
                'text'    => 'Text',
            ],
        ];

        $this->httpClientProphecy->request($sendMessageMethod->getName(), $options)->shouldBeCalled(1);
        $this->httpClientProphecy
            ->request($sendMessageMethod->getName(), $options)
            ->willReturn('not valid json')
            ->shouldBeCalled(1);

        $this->sut->call($sendMessageMethod);
    }

    /**
     * Tests that valid Response object with Update entity returned with provided json
     */
    public function testCallWithGetUpdatesMethod()
    {
        $getUpdates = new GetUpdates();
        $options    = [
            'query' => [
                'limit'   => 1,
                'timeout' => 3,
            ],
        ];

        $this->httpClientProphecy->request($getUpdates->getName(), $options)->shouldBeCalled(1);
        $this->httpClientProphecy
            ->request($getUpdates->getName(), $options)
            ->willReturn('{"ok":true,"result":[{"update_id":767221831,"message":{"message_id":6197,"from":{"id":56293731,"is_bot":false,"first_name":"Test name","last_name":"Test","language_code":"en"},"chat":{"id":56293731,"first_name":"Test name","last_name":"Test","type":"private"},"date":1511476752,"text":"/me","entities":[{"offset":0,"length":3,"type":"bot_command"}]}}]}')
            ->shouldBeCalled(1);

        $result = $this->sut->call($getUpdates);

        $this->assertInstanceOf(Response::class, $result);
        $this->assertEquals(1, $result->getEntitiesCount());

        /** @var Update $firstEntity */
        $firstEntity = $result->getFirstEntity();

        $this->assertInstanceOf(Update::class, $firstEntity);

        $user = $firstEntity->getMessage()->getFrom();

        $this->assertInstanceOf(User::class, $user);
        $this->assertSame('Test name', $user->getFirstName());
    }
}
