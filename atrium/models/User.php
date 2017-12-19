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

    /**
     * Constructor
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->guid = $response['guid'];
        $this->identifier = $response['identifier'];
        $this->is_disabled = $response['is_disabled'];
        $this->metadata = $response['metadata'];
    }
}
