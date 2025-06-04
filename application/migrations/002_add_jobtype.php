<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Migration_Add_jobtype extends CI_Migration {

	public function up() {
		$this->dbforge->add_field( array(
			'id'          => array(
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			),
			'name'    => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),
			'description'    => array(
				'type'       => 'TEXT',
				'null'       => true,
			),
			'price_a'    => array(
				'type'       => 'FLOAT',
				'null'       => true,
			),
			'price_b'    => array(
				'type'       => 'FLOAT',
				'null'       => true,
			),
			'discount'    => array(
				'type'       => 'FLOAT',
				'null'       => true,
			),
			'print_name'    => array(
				'type'       => 'VARCHAR',
				'constraint' => '10',
				'null'       => true,
			),
			'position'    => array(
				'type'       => 'VARCHAR',
				'constraint' => '10',
				'null'       => true,
			),
			'status'   => array(
				'type'       => 'INT',
				'constraint' => '1',
				'null'       => true,
			),
			'added_by'    => array(
				'type'       => 'INT',
				'constraint' => '11',
				'null'       => true,
			),
			'added_time'  => array(
				'type' => 'datetime',
				'null' => true,
			),
			'added_ip'    => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),
		) );

		$this->dbforge->add_key( 'id', true );
		$this->dbforge->create_table( 'jobtype' );
	}

	public function down() {
		$this->dbforge->drop_table( 'jobtype' );
	}
}