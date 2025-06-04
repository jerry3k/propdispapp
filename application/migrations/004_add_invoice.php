<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Migration_Add_invoice extends CI_Migration {

	var $Table = 'invoice';

	public function up() {
		$this->dbforge->add_field( array(
			'id'            => array(
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			),
			'invoice_no' => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),
			'job_id'     => array(
				'type'       => 'INT',
				'constraint' => 11,
				'null'       => true,
			),
			'client_id'     => array(
				'type'       => 'INT',
				'constraint' => 11,
				'null'       => true,
			),
			'fitter_id'     => array(
				'type'       => 'INT',
				'constraint' => 11,
				'null'       => true,
			),
			'job_type'     => array(
				'type'       => 'INT',
				'constraint' => 11,
				'null'       => true,
			),
			'invoice_date'    => array(
				'type' => 'date',
				'null' => true,
			),
			'added_by'      => array(
				'type'       => 'INT',
				'constraint' => '11',
				'null'       => true,
			),
			'added_time'    => array(
				'type' => 'datetime',
				'null' => true,
			),
			'added_ip'      => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),
			'send_email'    => array(
				'type'       => 'INT',
				'constraint' => '1',
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