<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Categoria_producto;

class CategoriaProductoTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    /** @test */
    
    public function list_of_categories_products_can_be_retrieved()
    {
        //$this->withoutExceptionHandling();

        factory(Categoria_producto::class, 2)->create();

        $response = $this->get('/categorias_productos');

        $categories = Categoria_producto::all();

        $response->assertOk();

       // $response->assertJson();
    }
}
