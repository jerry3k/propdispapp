<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Migration_Add_subjobs extends CI_Migration {

	var $Table = 'subjobs';

	public function up() {

		$this->dbforge->add_field( array(
			'id'                => array(
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			),
			'invoice_no'        => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),
			'jobid'             => array(
				'type'       => 'INT',
				'constraint' => 11,
				'null'       => true,
			),
			'job_type'          => array(
				'type'       => 'INT',
				'constraint' => 11,
				'null'       => true,
			),
			'client_id'         => array(
				'type'       => 'INT',
				'constraint' => 11,
				'null'       => true,
			),
			'fitter_id'         => array(
				'type'       => 'INT',
				'constraint' => 11,
				'null'       => true,
			),
			'print_name'        => array(
				'type'       => 'VARCHAR',
				'constraint' => '150',
				'null'       => true,
			),
			'position'          => array(
				'type'       => 'VARCHAR',
				'constraint' => '150',
				'null'       => true,
			),
			'price'             => array(
				'type' => 'float',
				'null' => true,
			),
			'qty'               => array(
				'type'       => 'INT',
				'constraint' => '11',
				'null'       => true,
			),
			'expense'           => array(
				'type' => 'float',
				'null' => true,
			),
			'discount'          => array(
				'type' => 'float',
				'null' => true,
			),
			'total'             => array(
				'type'       => 'VARCHAR',
				'constraint' => '150',
				'null'       => true,
			),
			'job_date'          => array(
				'type' => 'DATE',
				'null' => true,
			),
			'enter_date'        => array(
				'type' => 'datetime',
				'null' => true,
			),
			'access'            => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),
			'keys_text'         => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),
			'problems'          => array(
				'type'       => 'VARCHAR',
				'constraint' => '150',
				'null'       => true,
			),
			'appointment'       => array(
				'type'       => 'VARCHAR',
				'constraint' => '150',
				'null'       => true,
			),
			'client_contact'    => array(
				'type'       => 'VARCHAR',
				'constraint' => '200',
				'null'       => true,
			),
			'board'             => array(
				'type'       => 'VARCHAR',
				'constraint' => '150',
				'null'       => true,
			),
			'job_status'        => array(
				'type'       => 'INT',
				'constraint' => '1',
				'null'       => true,
			),
			'date_done'         => array(
				'type' => 'date',
				'null' => true,
			),
			'contact_type'      => array(
				'type'       => 'VARCHAR',
				'constraint' => '50',
				'null'       => true,
			),
			'charge'            => array(
				'type'       => 'VARCHAR',
				'constraint' => '50',
				'null'       => true,
			),
			'pay'               => array(
				'type'       => 'VARCHAR',
				'constraint' => '50',
				'null'       => true,
			),
			'date_to_be_done'   => array(
				'type' => 'datetime',
				'null' => true,
			),
			'job_cancelled'     => array(
				'type'       => 'INT',
				'constraint' => '1',
				'null'       => true,
			),
			'comments'          => array(
				'type' => 'TEXT',
				'null' => true,
			),
			'poref'             => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),
			'espc'              => array(
				'type'       => 'VARCHAR',
				'constraint' => '50',
				'null'       => true,
			),
			'lost_property'     => array(
				'type'       => 'VARCHAR',
				'constraint' => '50',
				'null'       => true,
			),
			'lost_type'         => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),
			'overplate'         => array(
				'type'       => 'VARCHAR',
				'constraint' => '50',
				'null'       => true,
			),
			'questionmark'      => array(
				'type'       => 'VARCHAR',
				'constraint' => '50',
				'null'       => true,
			),
			'internal_comments' => array(
				'type' => 'TEXT',
				'null' => true,
			),
			'added_time'        => array(
				'type' => 'datetime',
				'null' => true,
			),
			'added_by'          => array(
				'type'       => 'INT',
				'constraint' => '11',
				'null'       => true,
			),
			'added_ip'          => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),
			'is_return'         => array(
				'type'       => 'INT',
				'constraint' => 11,
				'null'       => true,
			),
			'sort'              => array(
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