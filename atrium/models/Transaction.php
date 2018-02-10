<?php

namespace NateRitter\AtriumPHP\Models;

/**
 * Atrium PHP Transaction model
 *
 * @package atrium-php
 * @author Nate Ritter <nate@perfectspace.com>
 **/
class Transaction
{
    public $account_guid;
    public $amount;
    public $category;
    public $check_number_string;
    public $created_at;
    public $date;
    public $description;
    public $guid;
    public $is_bill_pay;
    public $is_direct_deposit;
    public $is_expense;
    public $is_fee;
    public $is_income;
    public $is_overdraft_fee;
    public $is_payroll_advance;
    public $latitude;
    public $longitude;
    public $member_guid;
    public $memo;
    public $merchant_category_code;
    public $original_description;
    public $posted_at;
    public $status;
    public $top_level_category;
    public $transacted_at;
    public $type;
    public $updated_at;
    public $user_guid;

    /**
     * Constructor
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->account_guid = $response['account_guid'];
        $this->amount = $response['amount'];
        $this->category = $response['category'];
        $this->check_number_string = $response['check_number_string'];
        $this->created_at = $response['created_at'];
        $this->date = $response['date'];
        $this->description = $response['description'];
        $this->guid = $response['guid'];
        $this->is_bill_pay = $response['is_bill_pay'];
        $this->is_direct_deposit = $response['is_direct_deposit'];
        $this->is_expense = $response['is_expense'];
        $this->is_fee = $response['is_fee'];
        $this->is_income = $response['is_income'];
        $this->is_overdraft_fee = $response['is_overdraft_fee'];
        $this->is_payroll_advance = $response['is_payroll_advance'];
        $this->latitude = $response['latitude'];
        $this->longitude = $response['longitude'];
        $this->member_guid = $response['member_guid'];
        $this->memo = $response['memo'];
        $this->merchant_category_code = $response['merchant_category_code'];
        $this->original_description = $response['original_description'];
        $this->posted_at = $response['posted_at'];
        $this->status = $response['status'];
        $this->top_level_category = $response['top_level_category'];
        $this->transacted_at = $response['transacted_at'];
        $this->type = $response['type'];
        $this->updated_at = $response['updated_at'];
        $this->user_guid = $response['user_guid'];
    }
}
