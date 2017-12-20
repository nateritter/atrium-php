<?php

namespace NateRitter\AtriumPHP;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use NateRitter\AtriumPHP\Models\User;
use NateRitter\AtriumPHP\Models\Member;
use NateRitter\AtriumPHP\Models\Account;
use NateRitter\AtriumPHP\Models\Connect;
use NateRitter\AtriumPHP\Models\Challenge;
use NateRitter\AtriumPHP\Models\Credential;
use NateRitter\AtriumPHP\Models\Institution;
use NateRitter\AtriumPHP\Models\Transaction;

/**
 * Atrium PHP Primary class
 *
 * @package atrium-php
 * @author Nate Ritter <nate@perfectspace.com>
 **/
class AtriumClient
{
    /**
     * MX environment (`vestibule.mx.com` or `atrium.mx.com`)
     * @var string
     */
    public $environment = '';

    /**
     * Your MX API key
     * @var string
     */
    public $mx_api_key = '';

    /**
     * Your MX Client ID
     * @var string
     */
    public $mx_client_id = '';

    /**
     * Constructor
     * @param string $environment  Environment (`vestibule.mx.com` or `atrium.mx.com`)
     * @param string $mx_api_key   Your MX API key
     * @param string $mx_client_id Your MX Client ID
     */
    public function __construct($environment, $mx_api_key, $mx_client_id)
    {
        $this->environment = $environment;
        $this->mx_api_key = $mx_api_key;
        $this->mx_client_id = $mx_client_id;
    }

    /**
     * List created members
     * @param  string $userGUID
     * @param  string $page
     * @param  string $records_per_page
     * @return array
     */
    public function listMembers($userGUID, $page = '', $records_per_page = '')
    {
        $params = $this->optionalParameters('', '', '', $page, $records_per_page);

        $response = $this->makeRequest('GET', '/users/' . $userGUID . '/members' . $params, []);
        $parsedJSON = json_decode($response);
        $JSONArray = (array) $parsedJSON->members;
        $members = [];

        foreach ($JSONArray as $member) {
            $members[] = new Member((array) $member);
        }

        return $members;
    }

    /**
     * Delete a member by their GUID
     * @param  string $userGUID
     * @param  string $memberGUID
     * @return string             JSON encoded string
     */
    public function deleteMember($userGUID, $memberGUID)
    {
        return $this->makeRequest('DELETE', '/users/' . $userGUID . '/members/' . $memberGUID, []);
    }

    /**
     * Update a member
     * @param  string  $userGUID
     * @param  string  $memberGUID
     * @param  string  $identifier
     * @param  string  $metadata     JSON encoded string
     * @return \NateRitter\AtriumPHP\Models\Member
     */
    public function updateMember(
        $userGUID,
        $memberGUID,
        $identifier = '',
        $credentials = '',
        $metadata = ''
    )
    {
        $inner = [];

        if ($identifier != '') {
            $inner['identifier'] = $identifier;
        }

        if ($credentials != '') {
            $inner['credentials'] = $credentials;
        }

        if ($metadata !== '') {
            $inner['metadata'] = json_encode($metadata);
        }

        $outer['member'] = $inner;

        $response = $this->makeRequest('PUT', '/users/' . $userGUID . '/members/' . $memberGUID, $outer);
        $response = json_decode($response);

        return new Member((array) $response->member);
    }

    /**
     * Read the user's member
     * @param  string $userGUID
     * @param  string $memberGUID
     * @return \NateRitter\AtriumPHP\Models\Member
     */
    public function readMember($userGUID, $memberGUID)
    {
        $response = $this->makeRequest('GET', '/users/' . $userGUID . '/members/' . $memberGUID, []);
        return new Member((array) json_decode($response)->member);
    }

    public function createMember(
        $userGUID,
        $credentials,
        $institutionCode,
        $identifier = '',
        $metadata = ''
    )
    {
        $inner = [];
        $inner['institution_code'] = $institutionCode;
        $inner['credentials'] = $credentials;

        if ($identifier != '') {
            $inner['identifier'] = $identifier;
        }

        if ($metadata !== '') {
            $inner['metadata'] = json_encode($metadata);
        }

        $outer['member'] = $inner;

        $response = $this->makeRequest('POST', '/users/' . $userGUID . '/members', $outer);
        $response = json_decode($response);

        return new Member((array) $response->member);
    }

    /**
     * Read Institution Credentials
     * @param  string $institutionCode
     * @param  string $page
     * @param  string $records_per_page
     * @return \NateRitter\AtriumPHP\Models\Credential
     */
    public function readInstitutionCredentials(
        $institutionCode,
        $page = '',
        $records_per_page = ''
    )
    {
        $params = $this->optionalParameters('', '', '', $page, $records_per_page);

        $response = $this->makeRequest('GET', '/institutions/' . $institutionCode . '/credentials' . $params, []);
        $parsedJSON = json_decode($response);
        $JSONArray = (array) $parsedJSON->credentials;
        $credentials = [];

        foreach ($JSONArray as $credential) {
            $credentials[] = new Credential((array) $credential);
        }

        return $credentials;
    }

    /**
     * Read a specific institution
     * @param  string $institutionCode
     * @return \NateRitter\AtriumPHP\Models\Institution
     */
    public function readInstitution($institutionCode)
    {
        $response = $this->makeRequest('GET', '/institutions/' . $institutionCode, []);
        return new Institution((array) json_decode($response)->institution);
    }

    /**
     * List the institutions available
     * @param  string $name
     * @param  string $page
     * @param  string $records_per_page
     * @return array
     */
    public function listInstitutions($name = '', $page = '', $records_per_page = '')
    {
        $params = $this->optionalParameters($name, '', '', $page, $records_per_page);

        $response = $this->makeRequest('GET', '/institutions' . $params, []);
        $parsedJSON = json_decode($response);
        $JSONArray = (array) $parsedJSON->institutions;
        $institutions = [];

        foreach ($JSONArray as $institution) {
            $institutions[] = new Institution((array) $institution);
        }

        return $institutions;
    }

    /**
     * Update a user
     * @param  string  $userGUID
     * @param  string  $identifier
     * @param  boolean $is_disabled
     * @param  string  $metadata     JSON encoded string
     * @return \NateRitter\AtriumPHP\Models\User
     */
    public function updateUser(
        $userGUID,
        $identifier = '',
        $is_disabled = true,
        $metadata = ''
    )
    {
        $inner = [];

        if ($identifier != '') {
            $inner['identifier'] = $identifier;
        }

        if (empty($is_disabled)) {
            $inner['is_disabled'] = 'false';
        } else {
            $inner['is_disabled'] = 'true';
        }

        if ($metadata !== '') {
            $inner['metadata'] = json_encode($metadata);
        }

        $outer['user'] = $inner;

        $response = $this->makeRequest('PUT', '/users/' . $userGUID, $outer);
        $response = json_decode($response);

        return new User((array) $response->user);
    }

    /**
     * Read the user account
     * @param  string $userGUID
     * @return \NateRitter\AtriumPHP\Models\User
     */
    public function readUser($userGUID)
    {
        $response = $this->makeRequest('GET', '/users/' . $userGUID, []);
        return new User((array) json_decode($response)->user);
    }

    /**
     * Delete a user by their GUID
     * @param  string $userGUID
     * @return string           JSON encoded string
     */
    public function deleteUser($userGUID)
    {
        return $this->makeRequest('DELETE', '/users/' . $userGUID, []);
    }

    /**
     * List created users
     * @param  string $page
     * @param  string $records_per_page
     * @return array
     */
    public function listUsers($page = '', $records_per_page = '')
    {
        $params = $this->optionalParameters('', '', '', $page, $records_per_page);

        $response = $this->makeRequest('GET', '/users' . $params, []);
        $parsedJSON = json_decode($response);
        $JSONArray = (array) $parsedJSON->users;
        $users = [];

        foreach ($JSONArray as $user) {
            $users[] = new User((array) $user);
        }

        return $users;
    }

    /**
     * Create a new user
     * @param  string $identifier
     * @param  bool   $is_disabled
     * @param  string $metadata    JSON encoded string
     * @return \NateRitter\AtriumPHP\Models\User
     */
    public function createUser($identifier = '', $is_disabled = true, $metadata = '')
    {
        $inner = [];
        $outer = [];

        if ($identifier !== '') {
            $inner['identifier'] = (string) $identifier;
        }

        if (empty($is_disabled)) {
            $inner['is_disabled'] = 'false';
        } else {
            $inner['is_disabled'] = 'true';
        }

        if ($metadata !== '') {
            $inner['metadata'] = json_encode($metadata);
        }

        $outer['user'] = $inner;

        $response = $this->makeRequest('POST', '/users', $outer);
        $response = json_decode($response);

        return new User((array) $response->user);
    }

    /**
     * Makes a request to the endpoint and retuns a JSON string
     * @param  string $mode     API HTTP mode (GET, POST, etc)
     * @param  string $endpoint
     * @param  array  $body
     * @return string           JSON string response or error
     */
    public function makeRequest($mode, $endpoint, array $body)
    {
        $conn = new Client([
            'base_uri' => 'https://'.$this->environment.'/',
            'accept' => 'application/vnd.mx.atrium.v1+json',
            'content-type' => 'application/json',
            'headers' => [
                'MX-API-KEY'   => $this->mx_api_key,
                'MX-CLIENT-ID' => $this->mx_client_id
            ]
        ]);

        $response = $conn->request($mode, $endpoint, [
            RequestOptions::JSON => $body
        ]);

        if ($error = $this->httpError($response->getStatusCode())) {
            $conn = null;
            return json_encode($error);
        }

        $contents = $response->getBody(true)->getContents();
        $conn = null;

        return $contents;
    }

    /**
     * Echo and exit on HTTP error
     * @param  int   $code HTTP status code
     * @return mixed       Error string or false
     */
    public function httpError($code)
    {
        $error = null;

        switch ($code) {
            case 400:
                $error = (string) $code . ' error: Required parameter is missing.';
                break;
            case 401:
                $error = (string) $code . ' error: Invalid MX-API-KEY, MX-CLIENT-ID, or being used in wrong environment.';
                break;
            case 403:
                $error = (string) $code . ' error: Requests must be HTTPS.';
                break;
            case 404:
                $error = (string) $code . ' error: GUID / URL path not recognized.';
                break;
            case 405:
                $error = (string) $code . ' error: Endpoint constraint not met.';
                break;
            case 406:
                $error = (string) $code . ' error: Specify valid API version.';
                break;
            case 409:
                $error = (string) $code . ' error: Object already exists.';
                break;
            case 422:
                $error = (string) $code . ' error: Data provided cannot be processed.';
                break;
            case 500:
            case 502:
            case 504:
                $error = (string) $code . ' error: An unexpected error occured on the MX system.';
                break;
            case 503:
                $error = (string) $code . ' error: Please try again later. The MX Platform is currently being updated.';
                break;
        }

        // Quit on 4XX or 5XX errors
        if ((int) floor($code / 100) == 4 || (int) floor($code / 100) == 5) {
            return $error;
        }

        return false;
    }

    /**
     * Returns string from list of parameters
     * @param  string $name
     * @param  string $from_date
     * @param  string $to_date
     * @param  string $page
     * @param  string $records_per_page
     * @return string
     */
    public function optionalParameters(
        $name = '',
        $from_date = '',
        $to_date = '',
        $page = '',
        $records_per_page = ''
    )
    {
        $params = '?';

        if ($name != '') {
            $params .= 'name=' . $name . '&';
        }
        if ($from_date != '') {
            $params .= 'from_date=' . $from_date . '&';
        }
        if ($to_date != '') {
            $params .= 'to_date=' . $to_date . '&';
        }
        if ($page != '') {
            $params .= 'page=' . $page . '&';
        }
        if ($records_per_page != '') {
            $params .= 'records_per_page=' . $records_per_page . '&';
        }

        return substr($params, 0, -1);
    }
}
