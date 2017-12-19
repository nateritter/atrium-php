<?php

namespace NateRitter\AtriumPHP\Models;

/**
 * Atrium PHP Challenge model
 *
 * @package atrium-php
 * @author Nate Ritter <nate@perfectspace.com>
 **/
class Challenge
{
    public $field_name;
    public $guid;
    public $label;
    public $type;
    public $image_data;
    public $options;

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
        if (isset($response['image_data']) && ! empty($response['image_data'])) {
            $this->image_data = $response['image_data'];
        }
        if (isset($response['options']) && ! empty($response['options'])) {
            $this->options = $response['options'];
        }
    }
}
