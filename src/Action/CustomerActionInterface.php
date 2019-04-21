<?php

namespace Jumia\Action;

/**
 * Interface CustomerActionInterface
 * @package Jumia\Action
 * @author Roger Fernandez
 */
interface CustomerActionInterface
{
    /**
     * Return phones
     *
     * @return array
     */
    public function getPhones();

    /**
     * Return countries
     *
     * @return array
     */
    public function getCountries();

    /**
     * Return phones by criteria
     *
     * @param array $params
     * @return array
     */
    public function searchBy($params);
}