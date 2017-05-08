<?php

namespace Drupal\d8_demo_2;

use Drupal\Core\Database\Connection;

class DbWrapper {
	private $connection;
	public function __construct(Connection $connection) {
		$this->connection = $connection;
	}
	public function getData() {
		// kint ( t ( 'inside getdata' ) );
		$result = $this->connection->select ( 'd8_demo_2', 'd' )->fields ( 'd' )->range ( 0, 1 )->execute ();
		// $result->fetchAssoc ();
		return $result->fetchAssoc ();
	}
	public function setData($fname, $lname) {
		// kint ( t ( 'inside setdata' ) );
		$this->connection->insert ( 'd8_demo_2' )->fields ( [
				'firstname',
				'lastname'
		], [
				$fname,
				$lname
		] )->execute ();
	}
}