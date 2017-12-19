<?php

namespace NateRitter\AtriumPHP\Models;

/**
 * Atrium PHP Connect model
 *
 * @package atrium-php
 * @author Nate Ritter <nate@perfectspace.com>
 **/
class Connect
{
    public $connect_widget_url;
    public $guid;

    /**
     * Constructor
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->connect_widget_url = $responsep['connect_widget_url'];
        $this->guid = $responsep['guid'];
    }
}
