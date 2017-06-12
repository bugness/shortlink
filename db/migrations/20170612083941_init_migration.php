<?php

use Phinx\Migration\AbstractMigration;

class InitMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        // create the table
        $table = $this->table('links');
        $table
            ->addColumn('code', 'string', ['limit' => 6, 'null' => true, 'comment' => 'Unique code for link'])
            ->addColumn('destination', 'text', ['null' => true, 'comment' => 'Origin URL'])
            ->create();
    }
}
