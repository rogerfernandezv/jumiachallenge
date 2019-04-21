<?php

namespace Jumia\Service;

use Jumia\Repository\CustomerRepository;

/**
 * Class CustomerService
 * @package Jumia\Service
 * @author Roger Fernandez
 */
class CustomerService implements CustomerServiceInterface
{
    /** @var \Jumia\Repository\CustomerRepository $customerRepository */
    private $customerRepository;

    /**
     * CustomerService constructor.
     *
     * @param \Jumia\Repository\CustomerRepository $customerRepository
     */
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * Return phones
     *
     * @return array
     */
    public function getPhones()
    {
        $customers = $this->customerRepository->getCustomers();
        return $this->validateData($customers);
    }

    /**
     * Return phones by criteria
     *
     * @param array $params
     * @return array
     */
    public function searchBy($params)
    {
        if (!empty($params['countryCode'])) {
            $customers = $this->customerRepository->getByCountry($params['countryCode']);
        } else {
            $customers = $this->customerRepository->getCustomers();
        }

        if (!empty($params['state'])) {
            $state = $params['state'] == 'ok' ? true : false;

            return $this->validateData($customers, $state);
        }

        return $this->validateData($customers);
    }

    /**
     * Separate phone and country code
     *
     * @param      $customers
     * @param null $state
     * @return array
     */
    public function validateData($customers, $state=null)
    {
        $phones = [];
        foreach ($customers as $customer) {
            $countryCode = '';
            $phoneReal = '';

            preg_match("/\((\d+)\)/", $customer['phone'], $matches);
            if (!empty($matches[1])):
                $countryCode = $matches[1];
            endif;

            preg_match("/\)[\s]?(\d+)/", $customer['phone'], $matches);
            if (!empty($matches[1])):
                $phoneReal =  $matches[1];
            endif;

            $data = $this->getData($countryCode, $customer['phone']);

            if (!is_null($data)) {
                $phone['name'] = $customer['name'];
                $phone['phone'] = $phoneReal;
                $phone['desc'] = $data['desc'];
                $phone['state'] = $data['state'];
                $phone['countryCode'] = $countryCode;

                if ((!is_null($state) && $state == $data['state']) || (is_null($state))) {
                    $phones[] = $phone;
                }
            }
        }

        return $phones;
    }

    /**
     * Return Countries
     *
     * @return array
     */
    public function getCountries()
    {
        $countries = [
            ['code' => CustomerRepository::CAMEROON, 'desc' => 'Cameroon'],
            ['code' => CustomerRepository::ETHIOPIA, 'desc' => 'Ethiopia'],
            ['code' => CustomerRepository::MAROCCO, 'desc' => 'Marocco'],
            ['code' => CustomerRepository::MOZAMBIQUE, 'desc' => 'Mozambique'],
            ['code' => CustomerRepository::UGANDA, 'desc' => 'Uganda']
        ];

        return $countries;
    }

    /**
     * Add country name and state
     *
     * @param $countryCode
     * @param $phoneNumber
     * @return array|null
     */
    public function getData($countryCode, $phoneNumber)
    {
        $result = ['desc' => '', 'state' => false];
        switch($countryCode):
            case CustomerRepository::CAMEROON:
                $result['desc'] = 'Cameroon';
                if (preg_match('/^(\(237\)[\s]?[2368]\d{7,8})$/', $phoneNumber)) {
                    $result['state'] = true;
                }
                break;
            case CustomerRepository::ETHIOPIA:
                $result['desc'] = 'Ethiopia';
                if (preg_match('/^(\(251\)[\s]?[1-59]\d{8})$/', $phoneNumber)) {
                    $result['state'] = true;
                }
                break;
            case CustomerRepository::MAROCCO:
                $result['desc'] = 'Marocco';
                if (preg_match('/^(\(212\)[\s]?[5-9]\d{8})$/', $phoneNumber)) {
                    $result['state'] = true;
                }
                break;
            case CustomerRepository::MOZAMBIQUE:
                $result['desc'] = 'Mozambique';
                if (preg_match('/^(\(258\)[\s]?[28]\d{7,8})$/', $phoneNumber)) {
                    $result['state'] = true;
                }
                break;
            case CustomerRepository::UGANDA:
                $result['desc'] = 'Uganda';
                if (preg_match('/^(\(256\)[\s]?\d{9})$/', $phoneNumber)) {
                    $result['state'] = true;
                }
                break;
            default:
                break;
        endswitch;

        if (!empty($result['desc'])) {
            return $result;
        }

        return null;
    }
}
