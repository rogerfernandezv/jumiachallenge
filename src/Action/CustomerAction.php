<?php

namespace Jumia\Action;

use Jumia\Service\CustomerService;
use Jumia\Repository\CustomerRepository;
use Jumia\Repository\Database;

/**
 * Class CustomerAction
 * @package Jumia\Action
 * @author Roger Fernandez
 */
class CustomerAction implements CustomerActionInterface
{
    private $customerService;

    /**
     * CustomerAction constructor.
     */
    public function __construct()
    {
        $this->customerService = new CustomerService(
            new CustomerRepository(new Database())
        );
    }

    /**
     * Return phones
     *
     * @return array
     */
    public function getPhones()
    {
        return $this->customerService->getPhones();
    }

    /**
     * Return countries
     *
     * @return array
     */
    public function getCountries()
    {
        return $this->customerService->getCountries();
    }

    /**
     * Return phones by criteria
     *
     * @param array $params
     * @return array
     */
    public function searchBy($params)
    {
        return $this->customerService->searchBy($params);
    }
}
