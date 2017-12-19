<?php

namespace Tests\Unit;

use Dotenv\Dotenv;
use Tests\TestCase;
use GuzzleHttp\Client;
use NateRitter\AtriumPHP\AtriumClient;

class AtriumClientTest extends TestCase
{
    public $mx_api_key;
    public $mx_client_id;
    public $client;

    public function setUp()
    {
        $this->mx_api_key   = getenv('MX_API_KEY');
        $this->mx_client_id = getenv('MX_CLIENT_ID');

        $this->client = new AtriumClient(
            'vestibule.mx.com',
            $this->mx_api_key,
            $this->mx_client_id
        );
    }

    public function tearDown() {
        //
    }

    /**
     * Test the Atrium Client class constructor
     */
    public function testAtriumClientConstructorRequiresParams()
    {
        $this->assertEquals($this->client->mx_api_key, $this->mx_api_key);
        $this->assertEquals($this->client->mx_client_id, $this->mx_client_id);

        $this->expectException(\PHPUnit\Framework\Error\Warning::class);
        $client = new AtriumClient;
    }

    # USER

    public function testCreateUser()
    {
        //
    }

    public function testReadUser()
    {
        //
    }

    public function testUpdateUser()
    {
        //
    }

    public function testListUsers()
    {
        //
    }

    public function testDeleteUser()
    {
        //
    }

    # INSTITUTION

    public function testListInstitution()
    {
        //
    }

    public function testReadInstitution()
    {
        //
    }

    public function testReadInstitutionCredentials()
    {
        //
    }

    # MEMBER

    public function testCreateMember()
    {
        //
    }

    public function testReadMember()
    {
        //
    }

    public function testUpdateMember()
    {
        //
    }

    public function testDeleteMember()
    {
        //
    }

    public function testListMembers()
    {
        //
    }

    public function testAggregateMember()
    {
        //
    }

    public function testReadMemberAggregationStatus()
    {
        //
    }

    public function testListMemberMFAChallenges()
    {
        //
    }

    public function testResumeMemberAggregation()
    {
        //
    }

    public function testListMemberCredentials()
    {
        //
    }

    public function testListMemberAccounts()
    {
        //
    }

    public function testListMemberTransactions()
    {
        //
    }

    # ACCOUNT

    public function testReadAccount()
    {
        //
    }

    public function testListAccounts()
    {
        //
    }

    public function testListAccountTransactions()
    {
        //
    }

    public function testReadTransaction()
    {
        //
    }

    public function testListTransactions()
    {
        //
    }

    # CONNECT WIDGET

    public function testCreateWidget()
    {
        //
    }

    # CLIENT

    public function testTestMakeRequest()
    {
        //
    }

    public function testHttpError()
    {
        //
    }

    public function testOptionalParameters()
    {
        //
    }

    # CONNECTIVITY

    /**
     * Test basic connectivity from a naked API users call including
     * headers and JSON encoded results (just pagination).
     */
    public function testConnectivity()
    {
        $this->markTestSkipped('Skipping a connectivity test.');

        $this->http = new Client([
            'base_uri' => 'https://vestibule.mx.com/',
            'headers' => [
                'MX-API-KEY'   => $this->mx_api_key,
                'MX-CLIENT-ID' => $this->mx_client_id
            ]
        ]);

        $response = $this->http->request('GET', 'users');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/vnd.mx.atrium.v1+json; charset=utf-8", $contentType);

        $results = json_decode($response->getBody(true)->getContents());
        $this->assertEquals($results->pagination->current_page, 1);

        $this->http = null;
    }
}
