<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Migration_Add_jobs extends CI_Migration {

	public function up() {
		$this->dbforge->add_field( array(
			'id'              => array(
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			),
			'customer_name'   => array(
				'type'       => 'VARCHAR',
				'constraint' => '150',
				'null'       => true,
			),
			'jobcode'         => array(
				'type'       => 'VARCHAR',
				'constraint' => '150',
				'null'       => true,
			),
			'client_id'       => array(
				'type'       => 'INT',
				'constraint' => 11,
				'null'       => true,
			),
			'address1'        => array(
				'type'       => 'VARCHAR',
				'constraint' => '150',
				'null'       => true,
			),
			'address2'        => array(
				'type'       => 'VARCHAR',
				'constraint' => '150',
				'null'       => true,
			),
			'address3'        => array(
				'type'       => 'VARCHAR',
				'constraint' => '150',
				'null'       => true,
			),
			'country'         => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),
			'city'            => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),
			'postcode'        => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),
			'latitude'        => array(
				'type' => 'float',
				'null' => true,
			),
			'longitude'       => array(
				'type' => 'float',
				'null' => true,
			),
			'added_by'        => array(
				'type'       => 'INT',
				'constraint' => '11',
				'null'       => true,
			),
			'added_time'      => array(
				'type' => 'datetime',
				'null' => true,
			),
			'added_ip'        => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),
		) );

		$this->dbforge->add_key( 'id', true );
		$this->dbforge->create_table( 'jobs' );
	}

	public function down() {
		$this->dbforge->drop_table( 'jobs' );
	}
}