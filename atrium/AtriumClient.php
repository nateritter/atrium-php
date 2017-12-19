<?php

namespace NateRitter\AtriumPHP;

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
}
