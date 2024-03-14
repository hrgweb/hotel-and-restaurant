<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_new_category(): void
    {
        $body = Category::factory()->make();

        $this->post(route('categories.store'), $body->toArray())->assertStatus(201);
    }
}
