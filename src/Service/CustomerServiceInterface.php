<?php

namespace Jumia\Service;

/**
 * Interface CustomerServiceInterface
 * @package Jumia\Service
 * @author Roger Fernandez
 */
interface CustomerServiceInterface
{
    /**
     * Return phones
     *
     * @return array
     */
    public function getPhones();

    /**
     * Return phones by criteria
     *
     * @param array $params
     * @return array
     */
    public function searchBy($params);

    /**
     * Separate phone and country code
     *
     * @param      $customers
     * @param null $state
     * @return array
     */
    public function validateData($customers, $state=null);

    /**
     * Return Countries
     *
     * @return array
     */
    public function getCountries();

    /**
     * Add country name and state
     *
     * @param $countryCode
     * @param $phoneNumber
     * @return array|null
     */
    public function getData($countryCode, $phoneNumber);


}