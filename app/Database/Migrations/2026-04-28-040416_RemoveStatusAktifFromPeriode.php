public function up()
{
    $this->forge->dropColumn('periode', 'status_aktif');
}

public function down()
{
    $this->forge->addColumn('periode', [
        'status_aktif' => [
            'type'       => 'ENUM',
            'constraint' => ['aktif', 'tidak aktif'],
            'default'    => 'tidak aktif',
        ],
    ]);
}