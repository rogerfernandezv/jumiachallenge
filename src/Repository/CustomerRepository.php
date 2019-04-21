<?php

namespace Jumia\Repository;

use Jumia\Repository\Database;

/**
 * Class CustomerRepository
 * @package Jumia\Repository
 * @author Roger Fernandez
 */
class CustomerRepository implements CustomerRepositoryInterface
{
    private $database;

    const CAMEROON = 237;
    const ETHIOPIA = 251;
    const MAROCCO = 212;
    const MOZAMBIQUE = 258;
    const UGANDA = 256;

    /**
     * CustomerRepository constructor.
     * @param \Jumia\Repository\Database $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * Return name and phone from customer
     * @return array
     */
    public function getCustomers()
    {
        $sql = "
            SELECT name, phone FROM customer
        ";

        $customers = $this->database->fetchArray($sql);

        return $customers;
    }

    /**
     * Search by country code
     *
     * @param string $countryCode
     * @return array
     */
    public function getByCountry($countryCode)
    {
        $sql = "
            SELECT name, phone FROM customer
            WHERE phone like '({$countryCode})%'
        ";

        $customers = $this->database->fetchArray($sql);

        return $customers;
    }
}
