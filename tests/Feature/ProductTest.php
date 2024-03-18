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

    public function test_all_categories()
    {
        $this->get(route('categories.index'))->assertOk();
    }

    public function test_add_new_category(): void
    {
        $body = Product::factory()->make();

        $this->post(route('categories.store'), $body->toArray())->assertStatus(201);
    }

    public function test_update_a_category(): void
    {
        $category = Product::factory()->create();

        Storage::fake('avatars');

        $file = UploadedFile::fake()->image(time() . '.png');

        $this->patch(route('categories.update', ['category' => $category->id]), [
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

        $this->delete(route('categories.destroy', ['category' => $category->id]))->assertOk();
    }
}
