<?php

use JwtManager\JwtManager;
use PHPUnit\Framework\TestCase;

class JwtManagerTest extends TestCase
{
    private $appSecret = 'DyONazNKD35e3TfpcOJGHewtjxPGkjSh';
    private $context = 'test';

    /**
     * @covers JwtManager\JwtManager::__construct
     */
    public function testJwtManagerCanBeInstantiated()
    {
        $JwtManager = new JwtManager(
            $this->appSecret,
            $this->context
        );

        $this->assertInstanceOf(JwtManager::class, $JwtManager);
    }

    /**
     * @covers JwtManager\JwtManager::getExpire
     */
    public function testGetExpire()
    {
        $JwtManager = new JwtManager(
            $this->appSecret,
            $this->context
        );

        $expire = $JwtManager->getExpire();
        
        $this->assertIsInt($expire);
        $this->assertNotNull($expire);
    }

    /**
     * @covers JwtManager\JwtManager::generate
     * @covers JwtManager\JwtManager::getHeader
     * @covers JwtManager\JwtManager::getPayload
     * @covers JwtManager\JwtManager::getSignature
     * @covers JwtManager\JwtManager::base64UrlEncode
     */
    public function testGenerate()
    {
        $JwtManager = new JwtManager(
            $this->appSecret,
            $this->context
        );

        $token = $JwtManager->generate('token', '68162dc1-a392-491f-9d46-639f0e0f179d');
        
        $this->assertIsString($token);
        $this->assertRegExp(
            '^([a-zA-Z0-9_=]{4,})\.([a-zA-Z0-9_=]{4,})\.([a-zA-Z0-9_\-\+\/=]{4,})^',
            $token
        );
    }

    /**
     * @covers JwtManager\JwtManager::isValid
     * @covers JwtManager\JwtManager::splitParts
     * @covers JwtManager\JwtManager::getSignature
     * @covers JwtManager\JwtManager::base64UrlEncode
     */
    public function testIsValid()
    {
        $JwtManager = new JwtManager(
            $this->appSecret,
            $this->context
        );

        $token = $JwtManager->generate('token', '68162dc1-a392-491f-9d46-639f0e0f179d');

        $JwtManager = new JwtManager(
            $this->appSecret,
            $this->context
        );

        $valid = $JwtManager->isValid($token);
        
        $this->assertIsBool($valid);
        $this->assertTrue($valid);
    }

    /**
     * @covers JwtManager\JwtManager::isValid
     * @covers JwtManager\JwtManager::splitParts
     * @covers JwtManager\JwtManager::getSignature
     * @covers JwtManager\JwtManager::base64UrlEncode
     */
    public function testInvalidFormat()
    {
        $token = 'token';

        $JwtManager = new JwtManager(
            $this->appSecret,
            $this->context
        );

        $this->expectExceptionObject(
            new \Exception('Invalid JWT Token', 401)
        );

        $JwtManager->isValid($token);
    }

    /**
     * @covers JwtManager\JwtManager::isValid
     * @covers JwtManager\JwtManager::splitParts
     * @covers JwtManager\JwtManager::getSignature
     * @covers JwtManager\JwtManager::base64UrlEncode
     */
    public function testIsNotValid()
    {
        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9'.
                 '.eyJhdWQiOiJ0b2tlbiIsImV4cCI6MzAsIml'.
                 'hdCI6MTUzMjMwODY3MSwiaXNzIjoibXllZHV'.
                 '6ei1hcGkiLCJzdWIiOjgxNTk1OX0=.t5HzL1'.
                 '+FDvvi+T7JM8c9l12PM16R8CCj6lDKuCgwrong';

        $JwtManager = new JwtManager(
            $this->appSecret,
            $this->context
        );

        $this->expectExceptionObject(
            new \Exception('Invalid JWT Token', 401)
        );

        $valid = $JwtManager->isValid($token);
    }

    /**
     * @covers JwtManager\JwtManager::isOnTime
     * @covers JwtManager\JwtManager::decodePayload
     * @covers JwtManager\JwtManager::base64UrlDecode
     */
    public function testIsOnTime()
    {
        $JwtManager = new JwtManager(
            $this->appSecret,
            $this->context
        );

        $token = $JwtManager->generate('token', '68162dc1-a392-491f-9d46-639f0e0f179d');
        $onTime = $JwtManager->isOnTime($token);
        
        $this->assertIsBool($onTime);
        $this->assertTrue($onTime);
    }

    /**
     * @covers JwtManager\JwtManager::isOnTime
     * @covers JwtManager\JwtManager::decodePayload
     * @covers JwtManager\JwtManager::base64UrlDecode
     */
    public function testIsOnTimeMissingIatExp()
    {
        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9'.
                 '.eyJhdWQiOiJ0b2tlbiIsImlzcyI6Im15ZWR'.
                 '1enotYXBpIiwic3ViIjo4MTU5NTl9.AkSOlj'.
                 'nyMK4SM4bW5V04jiYClceFgINOrmcrqN4NsuQ=';

        $JwtManager = new JwtManager(
            $this->appSecret,
            $this->context
        );

        $this->expectExceptionObject(
            new \Exception('Invalid JWT Token', 401)
        );

        $JwtManager->isOnTime($token);
    }

    /**
     * @covers JwtManager\JwtManager::isOnTime
     * @covers JwtManager\JwtManager::decodePayload
     * @covers JwtManager\JwtManager::base64UrlDecode
     * @covers JwtManager\JwtManager::splitParts
     */
    public function testIsNotOnTime()
    {
        $oldToken = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9'.
                    '.eyJhdWQiOiJ0b2tlbiIsImV4cCI6MzAsIml'.
                    'hdCI6MTUzMjMwODY3MSwiaXNzIjoibXllZHV'.
                    '6ei1hcGkiLCJzdWIiOjgxNTk1OX0=.t5HzL1'.
                    '+FDvvi+T7JM8c9l12PM16R8CCj6lDKuCgDzHk=';

        $JwtManager = new JwtManager(
            $this->appSecret,
            $this->context
        );

        $this->expectExceptionObject(
            new \Exception('Expired JWT Token', 401)
        );

        $JwtManager->isOnTime($oldToken);
    }

    /**
     * @covers JwtManager\JwtManager::tokenNeedToRefresh
     * @covers JwtManager\JwtManager::decodePayload
     * @covers JwtManager\JwtManager::base64UrlDecode
     * @covers JwtManager\JwtManager::splitParts
     */
    public function testTokenNeedToRefresh()
    {
        $JwtManager = new JwtManager(
            $this->appSecret,
            $this->context,
            1,
            1
        );

        $token = $JwtManager->generate('token', '68162dc1-a392-491f-9d46-639f0e0f179d');
        sleep(2);

        $need = $JwtManager->tokenNeedToRefresh($token);
        
        $this->assertIsBool($need);
        $this->assertTrue($need);
    }

    /**
     * @covers JwtManager\JwtManager::tokenNeedToRefresh
     * @covers JwtManager\JwtManager::decodePayload
     * @covers JwtManager\JwtManager::base64UrlDecode
     * @covers JwtManager\JwtManager::splitParts
     */
    public function testTokenNeedToRefreshMissingIatExp()
    {
        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9'.
                 '.eyJhdWQiOiJ0b2tlbiIsImlzcyI6Im15ZWR'.
                 '1enotYXBpIiwic3ViIjo4MTU5NTl9.AkSOlj'.
                 'nyMK4SM4bW5V04jiYClceFgINOrmcrqN4NsuQ=';

        $JwtManager = new JwtManager(
            $this->appSecret,
            $this->context
        );

        $this->expectExceptionObject(
            new \Exception('Invalid JWT Token', 401)
        );

        $JwtManager->tokenNeedToRefresh($token);
    }

    /**
     * @covers JwtManager\JwtManager::tokenNeedToRefresh
     * @covers JwtManager\JwtManager::decodePayload
     * @covers JwtManager\JwtManager::base64UrlDecode
     * @covers JwtManager\JwtManager::splitParts
     */
    public function testTokenNotNeedToRefresh()
    {
        $JwtManager = new JwtManager(
            $this->appSecret,
            $this->context
        );

        $token = $JwtManager->generate('token', '68162dc1-a392-491f-9d46-639f0e0f179d');
        $need = $JwtManager->tokenNeedToRefresh($token);
        
        $this->assertIsBool($need);
        $this->assertFalse($need);
    }

    protected function tearDown(): void
    {
        //
    }
}
