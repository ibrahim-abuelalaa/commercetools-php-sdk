<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 * @created: 22.01.15, 10:30
 */

namespace Commercetools\Core;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    protected function getConfig()
    {
        return [
                Config::CLIENT_ID => 'id',
                Config::CLIENT_SECRET => 'secret',
                Config::OAUTH_URL => 'oauthUrl',
                Config::PROJECT => 'project',
                Config::API_URL => 'apiUrl'
        ];
    }

    public function testSetCredentialsOnly()
    {
        $testConfig = $this->getConfig();
        unset($testConfig[Config::OAUTH_URL]);
        unset($testConfig[Config::API_URL]);
        $config = Config::fromArray($testConfig);
        $this->assertInstanceOf('\Commercetools\Core\Config', $config);

        $this->assertEquals($testConfig[Config::CLIENT_ID], $config->getClientId());
        $this->assertEquals($testConfig[Config::CLIENT_SECRET], $config->getClientSecret());
        $this->assertEquals('https://auth.sphere.io/oauth/token', $config->getOauthUrl());
        $this->assertEquals($testConfig[Config::PROJECT], $config->getProject());
        $this->assertEquals('https://api.sphere.io', $config->getApiUrl());
    }

    public function testFromArray()
    {
        $testConfig = $this->getConfig();
        $config = Config::fromArray($testConfig);
        $this->assertInstanceOf('\Commercetools\Core\Config', $config);

        $this->assertEquals($testConfig[Config::CLIENT_ID], $config->getClientId());
        $this->assertEquals($testConfig[Config::CLIENT_SECRET], $config->getClientSecret());
        $this->assertEquals($testConfig[Config::OAUTH_URL] . '/oauth/token', $config->getOauthUrl());
        $this->assertEquals($testConfig[Config::PROJECT], $config->getProject());
        $this->assertEquals($testConfig[Config::API_URL], $config->getApiUrl());
    }


    public function testEmptyArray()
    {
        $config = new Config();
        $config->fromArray([]);

        $this->assertEmpty($config->getClientId());
        $this->assertEmpty($config->getClientSecret());
        $this->assertEmpty($config->getProject());
        $this->assertEquals('https://auth.sphere.io/oauth/token', $config->getOauthUrl());
        $this->assertEquals('https://api.sphere.io', $config->getApiUrl());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testUnknownEntry()
    {
        $config = new Config();
        $config->fromArray(['key' => 'value']);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidConfig()
    {
        $config = new Config();
        $config->fromArray([]);
        $config->check();
    }

    public function mandatoryConfig()
    {
        return [
            [Config::CLIENT_ID],
            [Config::CLIENT_SECRET],
            [Config::PROJECT],
        ];
    }

    /**
     * @dataProvider mandatoryConfig
     * @expectedException \InvalidArgumentException
     */
    public function testNoClientIdSet($mandatoryField)
    {
        $testConfig = $this->getConfig();
        unset($testConfig[$mandatoryField]);
        $config = new Config();
        $config->fromArray($testConfig);
        $config->check();
    }

    public function testValidConfig()
    {
        $testConfig = $this->getConfig();
        $config = Config::fromArray($testConfig);
        $this->assertTrue($config->check());
    }

    public function testBatchPoolSize()
    {
        $config = new Config();
        $this->assertSame(25, $config->getBatchPoolSize());
        $config->setBatchPoolSize(30);
        $this->assertSame(30, $config->getBatchPoolSize());
    }

    public function testDefaultScope()
    {
        $config = Config::fromArray($this->getConfig());

        $this->assertSame('manage_project:project', $config->getScope());
    }

    /**
     * @dataProvider getScopes
     */
    public function testScopes($project, $scope, $expectedResult)
    {
        $config = [
            Config::PROJECT => $project,
            Config::SCOPE => $scope,
        ];
        $config = Config::fromArray($config);

        $this->assertSame($expectedResult, $config->getScope());
    }

    public function getScopes()
    {
        return [
            [
                'project',
                'scope',
                'scope:project'
            ],
            [
                'project',
                'scope1:project1 scope2:project2',
                'scope1:project1 scope2:project2'
            ],
            [
                'project',
                'scope1 scope2',
                'scope1:project scope2:project'
            ],
            [
                'project',
                'scope1 scope2:project2',
                'scope1:project scope2:project2'
            ],
            [
                'project',
                ['scope1'],
                'scope1:project'
            ],
            [
                'project',
                ['scope1', 'scope2'],
                'scope1:project scope2:project'
            ],
            [
                'project',
                ['scope1' => 'project1', 'scope2' => 'project2'],
                'scope1:project1 scope2:project2'
            ],
            [
                'project',
                ['scope1', 'scope2' => 'project2'],
                'scope1:project scope2:project2'
            ],
        ];
    }
}
