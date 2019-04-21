<?php

namespace Jumia\Repository;

/**
 * Class Database
 * @package Jumia\Repository
 * @author Roger Fernandez
 */
class Database
{
    /** @var PDO $database */
    public $database;

    /** @var mixed $app */
    private $app;

    /**
     * Database constructor.
     */
	public function __construct()
	{

	    $this->app = require __DIR__ . '/../../config/app.php';
		$this->database = $this->app->db;
	}

    /**
     * Fetch data from db as array
     *
     * @param string $query
     * @return array
     */
	public function fetchArray($query)
    {
        $dados = $this->database->query($query);
        $dadosRetorno = [];

        foreach ($dados as $dado) {
            array_push($dadosRetorno, $dado);
        }

        return $dadosRetorno;
    }
}
