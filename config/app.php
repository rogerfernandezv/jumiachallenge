<?php
	$app = new stdClass();
	$database = require __DIR__ . '/database.php';
	$app->db = new PDO($database['connection']['driver'] . ':' . $database['connection']['file']);
	$app->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	return $app;
