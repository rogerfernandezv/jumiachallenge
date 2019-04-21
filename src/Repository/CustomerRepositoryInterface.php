<?php

namespace Jumia\Repository;

/**
 * Interface CustomerRepositoryInterface
 * @package Jumia\Repository
 * @author Roger Fernandez
 */
interface CustomerRepositoryInterface
{
    /**
     * Return name and phone from customer
     * @return array
     */
    public function getCustomers();

    /**
     * Search by country code
     *
     * @param string $countryCode
     * @return array
     */
    public function getByCountry($countryCode);
}