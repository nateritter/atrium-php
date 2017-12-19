<?php

namespace Tests\Unit;

use Faker\Factory;
use Dotenv\Dotenv;
use Tests\TestCase;
use GuzzleHttp\Client;
use NateRitter\AtriumPHP\AtriumClient;

class AtriumClientTest extends TestCase
{
    public $mx_api_key;
    public $mx_client_id;
    public $client;
    public $faker;

    public function setUp()
    {
        $this->faker = Factory::create();
        $this->mx_api_key   = getenv('MX_API_KEY');
        $this->mx_client_id = getenv('MX_CLIENT_ID');

        $this->client = new AtriumClient(
            'vestibule.mx.com',
            $this->mx_api_key,
            $this->mx_client_id
        );
    }

    public function tearDown() {
        // Delete any users that were created
        $users = $this->client->listUsers(1, 1000);
        foreach ($users as $user) {
            $this->client->deleteUser($user->guid);
        }
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
        $identifier = ''; // Don't want collissions with already created users.
        $is_disabled = $this->faker->randomElement([true, false]);
        $metadata = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
        ];

        $result = $this->client->createUser($identifier, $is_disabled, $metadata);
        $this->assertNotNull($result->guid);

        return $result;
    }

    public function testReadUser()
    {
        $createdUser = $this->testCreateUser();

        $result = $this->client->readUser($createdUser->guid);
        $this->assertNotNull($result->guid);
    }

    public function testUpdateUser()
    {
        $createdUser = $this->testCreateUser();

        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;

        $modifiedUser = $createdUser;
        $modifiedUser->metadata = json_encode([
            'first_name' => $firstName,
            'last_name' => $lastName,
        ]);

        $result = $this->client->updateUser(
            $createdUser->guid,
            $createdUser->identifier,
            $createdUser->is_disabled,
            $modifiedUser->metadata
        );

        $decodedMetadata = json_decode($modifiedUser->metadata);

        $this->assertEquals($createdUser->guid, $result->guid);
        $this->assertEquals($createdUser->identifier, $result->identifier);
        $this->assertEquals($createdUser->is_disabled, $result->is_disabled);
        $this->assertNotEquals($createdUser->metadata, $result->metadata);
        $this->assertEquals($decodedMetadata->first_name, $firstName);
        $this->assertEquals($decodedMetadata->last_name, $lastName);
    }

    public function testListUsers()
    {
        $num = $this->faker->numberBetween(1, 10);

        for ($i=0; $i < $num; $i++) {
            $this->testCreateUser();
        }

        $users = $this->client->listUsers();

        $this->assertCount($num, $users);
    }

    public function testDeleteUser()
    {
        $user = $this->testCreateUser();

        $result = $this->client->deleteUser($user->guid);

        $this->assertEmpty($result);
    }

    // # INSTITUTION

    // public function testListInstitution()
    // {
    //     //
    // }

    // public function testReadInstitution()
    // {
    //     //
    // }

    // public function testReadInstitutionCredentials()
    // {
    //     //
    // }

    // # MEMBER

    // public function testCreateMember()
    // {
    //     //
    // }

    // public function testReadMember()
    // {
    //     //
    // }

    // public function testUpdateMember()
    // {
    //     //
    // }

    // public function testDeleteMember()
    // {
    //     //
    // }

    // public function testListMembers()
    // {
    //     //
    // }

    // public function testAggregateMember()
    // {
    //     //
    // }

    // public function testReadMemberAggregationStatus()
    // {
    //     //
    // }

    // public function testListMemberMFAChallenges()
    // {
    //     //
    // }

    // public function testResumeMemberAggregation()
    // {
    //     //
    // }

    // public function testListMemberCredentials()
    // {
    //     //
    // }

    // public function testListMemberAccounts()
    // {
    //     //
    // }

    // public function testListMemberTransactions()
    // {
    //     //
    // }

    // # ACCOUNT

    // public function testReadAccount()
    // {
    //     //
    // }

    // public function testListAccounts()
    // {
    //     //
    // }

    // public function testListAccountTransactions()
    // {
    //     //
    // }

    // public function testReadTransaction()
    // {
    //     //
    // }

    // public function testListTransactions()
    // {
    //     //
    // }

    // # CONNECT WIDGET

    // public function testCreateWidget()
    // {
    //     //
    // }

    // # CLIENT

    // public function testTestMakeRequest()
    // {
    //     //
    // }

    public function testHttpError()
    {
        // 4XX / 5XX error
        $code = $this->faker->randomElement([
            400, 401, 403, 404, 405, 406, 409, 422, 500, 502, 504, 503
        ]);
        $result = $this->client->httpError($code);
        $this->assertNotEquals($result, false);

        // Non 4XX / 5XX error
        $code = $this->faker->numberBetween(100, 300);
        $result = $this->client->httpError($code);
        $this->assertEquals($result, false);

        // No status code passed in
        $this->expectException(\PHPUnit\Framework\Error\Warning::class);
        $result = $this->client->httpError();
    }

    public function testOptionalParameters()
    {
        // Setup
        $name = $this->faker->word;
        $from_date = $this->faker->date;
        $to_date = $this->faker->date;
        $page = $this->faker->randomDigitNotNull;
        $records_per_page = $this->faker->randomDigitNotNull;

        // Blank
        $params = $this->client->optionalParameters();
        $this->assertEquals($params, '');

        // Name
        $params = $this->client->optionalParameters($name);
        $this->assertEquals($params, '?name=' . $name);

        // From Date
        $params = $this->client->optionalParameters('', $from_date);
        $this->assertEquals($params, '?from_date=' . $from_date);

        // To Date
        $params = $this->client->optionalParameters('', '', $to_date);
        $this->assertEquals($params, '?to_date=' . $to_date);

        // Page
        $params = $this->client->optionalParameters('', '', '', $page);
        $this->assertEquals($params, '?page=' . $page);

        // Records Per Page
        $params = $this->client->optionalParameters('', '', '', '', $records_per_page);
        $this->assertEquals($params, '?records_per_page=' . $records_per_page);

        // All at the same time
        $params = $this->client->optionalParameters(
            $name,
            $from_date,
            $to_date,
            $page,
            $records_per_page
        );
        $str = '?name='.$name.'&from_date='.$from_date.'&to_date='.$to_date.'&page='.$page.'&records_per_page='.$records_per_page;
        $this->assertEquals($params, $str);
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
