<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Migration_Add_admin extends CI_Migration {

	var $Table = 'admins';

	public function up() {
		$this->dbforge->add_field( array(
			'id'            => array(
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			),
			'username'      => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),
			'gender'        => array(
				'type'       => 'VARCHAR',
				'constraint' => '50',
				'null'       => true,
			),
			'email'         => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),
			'password'      => array(
				'type'       => 'VARCHAR',
				'constraint' => '150',
				'null'       => true,
			),
			'type'          => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),
			'phone'         => array(
				'type'       => 'VARCHAR',
				'constraint' => '200',
				'null'       => true,
			),
			'about'         => array(
				'type' => 'TEXT',
				'null' => true,
			),
			'is_active'     => array(
				'type'       => 'INT',
				'constraint' => '1',
				'null'       => true,
			),
			'is_admin'      => array(
				'type'       => 'INT',
				'constraint' => '1',
				'null'       => true,
			),
			'email_contact' => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),
			'company_name'  => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),
			'telephone'     => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),
			'fax'           => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),

			'address1'       => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),
			'address2'       => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),
			'address3'       => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),
			'postcode'       => array(
				'type'       => 'VARCHAR',
				'constraint' => '50',
				'null'       => true,
			),
			'country'        => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),
			'city'           => array(
				'type'       => 'VARCHAR',
				'constraint' => '50',
				'null'       => true,
			),
			'website'        => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),
			'sticker'        => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),
			'job_type'       => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),
			'pricing_system' => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),
			'fsb_let_bd' => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'       => true,
			),
			'note'           => array(
				'type' => 'text',
				'null' => true,
			),
			'added_by'       => array(
				'type'       => 'INT',
				'constraint' => '11',
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
			'server_info'    => array(
				'type'       => 'VARCHAR',
				'constraint' => '255',
				'null'       => true,
			),
			'is_login'    => array(
				'type'       => 'INT',
				'constraint' => '11',
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