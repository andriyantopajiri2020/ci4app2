<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pegawai extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => TRUE,
				'auto_increment' => TRUE,
			],
			'nama'       => [
				'type'       	=> 'VARCHAR',
				'constraint' 	=> '255',
			],
			'alamat' => [
				'type' 			=> 'VARCHAR',
				'constraint' 	=> '255',
			],
			'create_at'	=> [
				'type'			=> 'DATETIME',
				'null'			=> TRUE
			],
			'updated_at' => [
				'type'			=> 'DATETIME',
				'null'			=> TRUE
			]
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->createTable('pegawai');
	}

	public function down()
	{
		$this->forge->dropTable('pegawai');
	}
}
