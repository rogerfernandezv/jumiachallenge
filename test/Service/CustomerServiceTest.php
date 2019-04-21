<?php

namespace JumiaTest\Service;

use Jumia\Service\CustomerService;
use Jumia\Repository\CustomerRepository;
use PHPUnit\Framework\TestCase;

/**
 * Class CustomerServiceTest
 * Teste Unitário - Jumia\Service\CustomerService
 *
 * @package JumiaTest\Service
 * @author Roger Fernandez
 * @copyright GPL
 */
class CustomerServiceTest extends TestCase
{

    private $container;

    private $customerService;

    private $customerRepository;

    private $countries;

    protected function setUp()
    {
        $this->customerRepository = $this->prophesize(CustomerRepository::class);
        $this->customerRepository->getCustomers()->willReturn($this->getSeed());
        $this->customerRepository->getByCountry(212)->willReturn($this->getSeedCountry());

        $this->customerService = new CustomerService($this->customerRepository->reveal());

        $this->countries = [
            ['code' => CustomerRepository::CAMEROON, 'desc' => 'Cameroon'],
            ['code' => CustomerRepository::ETHIOPIA, 'desc' => 'Ethiopia'],
            ['code' => CustomerRepository::MAROCCO, 'desc' => 'Marocco'],
            ['code' => CustomerRepository::MOZAMBIQUE, 'desc' => 'Mozambique'],
            ['code' => CustomerRepository::UGANDA, 'desc' => 'Uganda']
        ];
    }

    private function getSeed()
    {
        return [
            [
                'name' => 'Walid Hammadi',
                0 => 'Walid Hammadi',
                'phone' => '(212) 6007989253',
                1 => '(212) 6007989253',
            ],
            [
                'name' => 'Yosaf Karrouch',
                0 => 'Yosaf Karrouch',
                'phone' => '(212) 698054317',
                1 => '(212) 698054317',
            ],
            [
                'name' => 'Ezequiel Fenias',
                0 => 'Ezequiel Fenias',
                'phone' => '(258) 848826725',
                1 => '(258) 848826725',
            ]
        ];
    }

    private function getSeedValidate()
    {
        return [
            [
                'name' => 'Walid Hammadi',
                'phone' => '6007989253',
                'desc' => 'Marocco',
                'state' => false,
                'countryCode' => '212'
            ],
            [
                'name' =>  'Yosaf Karrouch',
                'phone' =>  '698054317',
                'desc' =>  'Marocco',
                'state' => true,
                'countryCode' =>  '212'
            ],
            [
                'name' =>  'Ezequiel Fenias',
                'phone' =>  '848826725',
                'desc' =>  'Mozambique',
                'state' => true,
                'countryCode' => '258'
            ]
        ];
    }

    private function getSeedCountryValidate()
    {
        return [
            [
                'name' => 'Walid Hammadi',
                'phone' => '6007989253',
                'desc' => 'Marocco',
                'state' => false,
                'countryCode' => '212'
            ],
            [
                'name' =>  'Yosaf Karrouch',
                'phone' =>  '698054317',
                'desc' =>  'Marocco',
                'state' => true,
                'countryCode' =>  '212'
            ]
        ];
    }

    private function getSeedCountry()
    {
        return [
            [
                'name' => 'Walid Hammadi',
                0 => 'Walid Hammadi',
                'phone' => '(212) 6007989253',
                1 => '(212) 6007989253',
            ],
            [
                'name' => 'Yosaf Karrouch',
                0 => 'Yosaf Karrouch',
                'phone' => '(212) 698054317',
                1 => '(212) 698054317',
            ]
        ];
    }

    // Test validateData() function from CustomerService
    public function testValidateData()
    {
        $validateData = $this->customerService->validateData($this->getSeed());
        $this->assertEquals($this->getSeedValidate(), $validateData);
    }

    // Test getData() function from CustomerService
    public function testGetData()
    {
        $data = ['desc' => 'Mozambique', 'state' => true];
        $result = $this->customerService->getData(258, '(258) 848826725');
        $this->assertEquals($result, $data);
    }

    // Test getPhones() function from CustomerService
    public function testGetPhones()
    {
        $customers = $this->customerService->getPhones();
        $this->assertEquals($this->getSeedValidate(), $customers);
    }

    // Test searchBy() function from CustomerService
    public function testSearchBy()
    {
        $customers = $this->customerService->searchBy(['countryCode' => 212]);
        $this->assertEquals($customers, $this->getSeedCountryValidate());
    }

    // Test getCountries() function from CustomerService
    public function testGetCountries()
    {
        $countries = $this->customerService->getCountries();
        $this->assertEquals($this->countries, $countries);
    }
}
