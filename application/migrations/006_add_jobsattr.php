<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Migration_Add_jobsattr extends CI_Migration {
	var $Table = 'jobsattr';

	public function up() {

		$this->dbforge->add_field( array(
			'id'             => array(
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			),
			'job_id'      => array(
				'type'       => 'INT',
				'constraint' => 11,
				'null'       => true,
			),
			'client_id'      => array(
				'type'       => 'INT',
				'constraint' => 11,
				'null'       => true,
			),
			'sticker'       => array(
				'type'       => 'VARCHAR',
				'constraint' => '150',
				'null'       => true,
			),
			'position'       => array(
				'type'       => 'VARCHAR',
				'constraint' => '150',
				'null'       => true,
			),
			'added_time'     => array(
				'type' => 'datetime',
				'null' => true,
			),
			'added_ip'       => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),
			'status'       => array(
				'type'       => 'INT',
				'constraint' => 11,
				'null'       => true,
			),
		) );

		$this->dbforge->add_key( 'id', true );
		$this->dbforge->create_table( $this->Table );
	}

	public function down() {
		$this->dbforge->drop_table( $this->Table );
	}

}