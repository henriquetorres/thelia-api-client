<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace Thelia\Api\Client\Tests;
use Thelia\Api\Client\Client;

/**
 * Class ClientTest
 * @package Thelia\Api\Client\Tests
 * @author Benjamin Perche <bperche@openstudio.fr>
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Client
     */
    protected $client;

    protected $baseUrl;

    public function setUp()
    {
        $this->client = new Client(
            "79E95BD784CADA0C9A578282E",
            "B45B9F244866F77E53255D6C0E0B60A2FA295CB0CFE25",
            $this->baseUrl = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "server.txt")
        );
    }

    public function testClientReturnsAnArrayOnGetAction()
    {
        list($status, $data) = $this->client->sendList("products");

        $this->assertEquals(200, $status);

        $this->assertTrue(is_array($data));
        $this->assertGreaterThan(0, count($data));
    }

    public function testClientReturnsGoodValuesWithLoopParameters()
    {
        /**
         * Test one locale
         */
        list($status, $data) = $this->client->sendList("products", ["lang" => 'fr_FR']);

        $this->assertEquals(200, $status);

        $this->assertTrue(is_array($data));
        $this->assertGreaterThan(0, count($data));
        $this->assertArrayHasKey('LOCALE', $data[0]);
        $this->assertEquals("fr_FR", $data[0]['LOCALE']);

        /**
         * Test another
         */
        list($status, $data) = $this->client->sendList("products", ["lang" => 'en_US']);

        $this->assertEquals(200, $status);

        $this->assertTrue(is_array($data));
        $this->assertGreaterThan(0, count($data));
        $this->assertArrayHasKey('LOCALE', $data[0]);
        $this->assertEquals("en_US", $data[0]['LOCALE']);
    }
}
 