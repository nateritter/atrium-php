<?php

namespace NateRitter\AtriumPHP\Models;

/**
 * Atrium PHP Account model
 *
 * @package atrium-php
 * @author Nate Ritter <nate@perfectspace.com>
 **/
class Account
{
    public $apr;
    public $apy;
    public $available_balance;
    public $available_credit;
    public $balance;
    public $created_at;
    public $credit_limit;
    public $day_payment_is_due;
    public $guid;
    public $institution_code;
    public $interest_rate;
    public $is_closed;
    public $last_payment;
    public $matures_on;
    public $member_guid;
    public $minimum_balance;
    public $minimum_payment;
    public $name;
    public $original_balance;
    public $started_on;
    public $subtype;
    public $total_account_value;
    public $type;
    public $updated_at;
    public $user_guid;

    /**
     * Constructor
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->apr = $response['apr'];
        $this->apy = $response['apy'];
        $this->available_balance = $response['available_balance'];
        $this->available_credit = $response['available_credit'];
        $this->balance = $response['balance'];
        $this->created_at = $response['created_at'];
        $this->credit_limit = $response['credit_limit'];
        $this->day_payment_is_due = $response['day_payment_is_due'];
        $this->guid = $response['guid'];
        $this->institution_code = $response['institution_code'];
        $this->interest_rate = $response['interest_rate'];
        $this->is_closed = $response['is_closed'];
        $this->last_payment = $response['last_payment'];
        $this->matures_on = $response['matures_on'];
        $this->member_guid = $response['member_guid'];
        $this->minimum_balance = $response['minimum_balance'];
        $this->minimum_payment = $response['minimum_payment'];
        $this->name = $response['name'];
        $this->original_balance = $response['original_balance'];
        $this->started_on = $response['started_on'];
        $this->subtype = $response['subtype'];
        $this->total_account_value = $response['total_account_value'];
        $this->type = $response['type'];
        $this->updated_at = $response['updated_at'];
        $this->user_guid = $response['user_guid'];
    }
}
