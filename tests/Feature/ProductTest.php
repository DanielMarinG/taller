<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use Database\Factories\ProductFactory; // Importa la factory

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_product()
    {
        $response = $this->post('/products', [
            'description' => 'New Product',
            'price' => 10.50,
            'stock' => 100,
        ]);

        $response->assertStatus(302); // Cambiado de 201 a 302 porque Laravel por defecto redirige después de una inserción exitosa.
        $this->assertDatabaseHas('products', ['description' => 'New Product']);
    }

    /** @test */
    public function it_can_read_a_product()
{
    $product = Product::create([
        'description' => 'Test Product',
        'price' => 20.00,
        'stock' => 50,
    ]);

    $response = $this->get('/products/' . $product->id);

    $response->assertStatus(200);
    
    // Verifica que la descripción del producto está presente en la respuesta
    $response->assertSee($product->description);
    
    // Verifica que el precio del producto está presente en la respuesta
    $response->assertSee((string)$product->price); // Convertimos el precio a string
    
    // Verifica que el stock del producto está presente en la respuesta
    $response->assertSee((string)$product->stock); // Convertimos el stock a string
    
    // Asegúrate de agregar más aserciones según los atributos que desees verificar

    // Si necesitas verificar más atributos, puedes seguir agregando aserciones como las anteriores
}

    /** @test */
    public function it_can_update_a_product()
    {
        $product = Product::create([
            'description' => 'Test Product',
            'price' => 20.00,
            'stock' => 50,
        ]);

        $response = $this->put('/products/' . $product->id, [
            'description' => 'Updated Product',
            'price' => 15.75,
            'stock' => 200,
        ]);

        $response->assertStatus(302); // Cambiado de 200 a 302 por la misma razón que en el método de creación.
        $this->assertDatabaseHas('products', ['description' => 'Updated Product']);
    }

    /** @test */
    public function it_can_delete_a_product()
    {
        $product = Product::create([
            'description' => 'Test Product',
            'price' => 20.00,
            'stock' => 50,
        ]);

        $response = $this->delete('/products/' . $product->id);

        $response->assertStatus(302); // Cambiado de 204 a 302 porque Laravel redirige después de una eliminación exitosa.
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    /** @test */
    public function it_can_list_all_products()
    {
        // Crear algunos productos manualmente
        $products = [
            Product::create(['description' => 'Product 1', 'price' => 10.00, 'stock' => 20]),
            Product::create(['description' => 'Product 2', 'price' => 15.00, 'stock' => 30]),
            Product::create(['description' => 'Product 3', 'price' => 20.00, 'stock' => 40]),
        ];

        $response = $this->get('/products');

        $response->assertStatus(200);

        // Verificar que los productos estén presentes en la respuesta
        foreach ($products as $product) {
            $response->assertSee($product->description);
            $response->assertSee((string)$product->price);
            $response->assertSee((string)$product->stock);
        }
    }

    
}

