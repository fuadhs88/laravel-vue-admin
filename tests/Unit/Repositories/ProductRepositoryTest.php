<?php

namespace Repositories;

use App\Models\Product;
use App\Models\Tag;
use App\Repositories\ProductRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class ProductRepositoryTest extends TestCase
{

    use RefreshDatabase;

    public function testAddTags()
    {
        $product = Product::factory()->create();
        $tag = Tag::factory()->create();

        $repository = app(ProductRepository::class);
        $repository->addTags($product, [$tag->id]);

        $this->assertGreaterThan(0, $product->tags()->count());

    }
}
