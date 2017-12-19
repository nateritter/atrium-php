<?php

namespace NateRitter\AtriumPHP\Models;

/**
 * Atrium PHP Member model
 *
 * @package atrium-php
 * @author Nate Ritter <nate@perfectspace.com>
 **/
class Member
{
    public $aggregated_at;
    public $guid;
    public $identifier;
    public $institution_code;
    public $is_being_aggregated;
    public $metadata;
    public $name;
    public $status;
    public $successfully_aggregated_at;
    public $user_guid;
    public $challenges;
    public $has_processed_accounts;
    public $has_processed_transactions;

    /**
     * Constructor
     * @param array $response
     */
    public function __construct(array $response)
    {
        if (isset($response['aggregated_at']) && ! empty($response['aggregated_at'])) {
            $this->aggregated_at = $response['aggregated_at'];
        }
        if (isset($response['guid']) && ! empty($response['guid'])) {
            $this->guid = $response['guid'];
        }
        if (isset($response['identifier']) && ! empty($response['identifier'])) {
            $this->identifier = $response['identifier'];
        }
        if (isset($response['institution_code']) && ! empty($response['institution_code'])) {
            $this->institution_code = $response['institution_code'];
        }
        if (isset($response['is_being_aggregated']) && ! empty($response['is_being_aggregated'])) {
            $this->is_being_aggregated = $response['is_being_aggregated'];
        }
        if (isset($response['metadata']) && ! empty($response['metadata'])) {
            $this->metadata = $response['metadata'];
        }
        if (isset($response['name']) && ! empty($response['name'])) {
            $this->name = $response['name'];
        }
        if (isset($response['status']) && ! empty($response['status'])) {
            $this->status = $response['status'];
        }
        if (isset($response['successfully_aggregated_at']) && ! empty($response['successfully_aggregated_at'])) {
            $this->successfully_aggregated_at = $response['successfully_aggregated_at'];
        }
        if (isset($response['user_guid']) && ! empty($response['user_guid'])) {
            $this->user_guid = $response['user_guid'];
        }
        if (isset($response['challenges']) && ! empty($response['challenges'])) {
            $this->challenges = $response['challenges'];
        }
        if (isset($response['has_processed_accounts']) && ! empty($response['has_processed_accounts'])) {
            $this->has_processed_accounts = $response['has_processed_accounts'];
        }
        if (isset($response['has_processed_transactions']) && ! empty($response['has_processed_transactions'])) {
            $this->has_processed_transactions = $response['has_processed_transactions'];
        }
    }
}
