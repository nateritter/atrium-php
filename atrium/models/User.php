<?php

namespace NateRitter\AtriumPHP\Models;

/**
 * Atrium PHP User model
 *
 * @package atrium-php
 * @author Nate Ritter <nate@perfectspace.com>
 **/
class User
{
    public $guid;
    public $identifier;
    public $is_disabled;
    public $metadata;
    public $connect_widget_url;

    /**
     * Constructor
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->guid = $response['guid'];
        $this->identifier = (isset($response['identifier'])) ? $response['identifier'] : null;
        $this->is_disabled = (isset($response['is_disabled'])) ? $response['is_disabled'] : false;
        $this->metadata = (isset($response['metadata'])) ? $response['metadata'] : null;
        $this->connect_widget_url = (isset($response['connect_widget_url'])) ? $response['connect_widget_url'] : null;
    }
}
