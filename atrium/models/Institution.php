<?php

namespace NateRitter\AtriumPHP\Models;

/**
 * Atrium PHP Institution model
 *
 * @package atrium-php
 * @author Nate Ritter <nate@perfectspace.com>
 **/
class Institution
{
    public $code;
    public $name;
    public $url;
    public $small_logo_url;
    public $medium_logo_url;

    /**
     * Constructor
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->code = $response['code'];
        $this->name = $response['name'];
        $this->url = $response['url'];
        $this->small_logo_url = $response['small_logo_url'];
        $this->medium_logo_url = $response['medium_logo_url'];
    }
}
