<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_products()
    {
        $this->get(route('products.index'))->assertOk();
    }

    public function test_add_new_category(): void
    {
        $body = Product::factory()->make();

        $this->post(route('products.store'), $body->toArray())->assertStatus(201);
    }

    public function test_update_a_category(): void
    {
        $category = Product::factory()->create();

        Storage::fake('avatars');

        $file = UploadedFile::fake()->image(time() . '.png');

        $this->patch(route('products.update', ['category' => $category->id]), [
            'thumbnail' => $file,
            'name' => 'updated name',
            'desc' => 'updated ipsum'
        ])->assertCreated()->assertJson([
            'name' => 'updated name'
        ]);
    }

    public function test_remove_a_category(): void
    {
        $category = Product::factory()->create();

        $this->delete(route('products.destroy', ['category' => $category->id]))->assertOk();
    }
}
