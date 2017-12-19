<?php

namespace NateRitter\AtriumPHP\Models;

/**
 * Atrium PHP Credential model
 *
 * @package atrium-php
 * @author Nate Ritter <nate@perfectspace.com>
 **/
class Credential
{
    public $field_name;
    public $guid;
    public $label;
    public $type;

    /**
     * Constructor
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->field_name = $response['field_name'];
        $this->guid = $response['guid'];
        $this->label = $response['label'];
        $this->type = $response['type'];
    }
}
