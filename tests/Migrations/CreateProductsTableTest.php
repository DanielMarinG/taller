<?php

namespace Tests\Migrations;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CreateProductsTableTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function products_table_exists()
    {
        $this->assertTrue(Schema::hasTable('products'));
    }

    /** @test */
    public function products_table_has_expected_columns()
    {
        $expectedColumns = ['id', 'description', 'price', 'stock', 'created_at', 'updated_at'];

        foreach ($expectedColumns as $column) {
            $this->assertTrue(Schema::hasColumn('products', $column));
        }
    }

    /** @test */
    public function products_table_id_is_auto_increment()
    {
        $column = Schema::getColumnType('products', 'id');
        $this->assertEquals('bigint', $column);
        $this->assertTrue(Schema::getColumn('products', 'id')['autoincrement']);
    }

    // Puedes continuar escribiendo más pruebas para validar las restricciones y tipos de datos de las columnas.
}