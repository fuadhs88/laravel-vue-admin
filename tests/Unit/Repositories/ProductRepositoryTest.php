<?php

namespace Repositories;

use App\Models\Product;
use App\Models\Tag;
use App\Repositories\ProductRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @author Admin <admin@gmail.com>
     */
    public function testAddTags()
    {
        $product = Product::factory()->create();
        $tag = Tag::factory()->create();

        $repository = app(ProductRepository::class);
        $repository->addTags($product, [$tag->id]);

        $this->assertGreaterThan(0, $product->tags->count());
    }

    /**
     * @author Admin <admin@gmail.com>
     */
    public function testGet()
    {
        $product = Product::factory()->create();
        $repository = app(ProductRepository::class);
        $model = $repository->get();
        $this->assertGreaterThan(0, $product->count());
    }

    /**
     * @author Admin <admin@gmail.com>
     */
    public function testFind()
    {
        $product = Product::factory()->create();
        $repository = app(ProductRepository::class);
        $product_ = $repository->find($product->id);
        $this->assertGreaterThan(0, $product_->count());
    }

    /**
     * @author Admin <admin@gmail.com>
     */
    public function testCreate()
    {
        $repository = app(ProductRepository::class);
        $product = $repository->create([
            'name' => "abc",
            'description' => "abc",
            'price' => 100,
            'category_id' => 1,
            'photo' => 'images/cars/cima_1912_top_01.jpg.ximg.l_full_m.smart.jpg',
            ]
        );
        $product_ = $repository->find($product->id);
        $this->assertEquals($product->id, $product_->id);
    }


    /**
     * @author Admin <admin@gmail.com>
     */
    public function testUpdate()
    {
        $product = Product::factory()->create();
        $repository = app(ProductRepository::class);
        $product = $repository->update($product->id, [
                'name' => "abc",
                'description' => "abc",
                'price' => 100,
                'category_id' => 1,
                'photo' => 'images/cars/cima_1912_top_01.jpg.ximg.l_full_m.smart.jpg',
            ]
        );
        $product_ = $repository->find($product->id);
        $this->assertEquals($product->abc, $product_->abc);
    }

    /**
     * @author Admin <admin@gmail.com>
     */
    public function testDelete()
    {
        $product = Product::factory()->create();
        $repository = app(ProductRepository::class);
        $product = $repository->delete($product->id);
        $this->assertEquals(true, $product);
    }

    /**
     * @author Admin <admin@gmail.com>
     */
    public function testShow()
    {
        $product = Product::factory()->create();
        $repository = app(ProductRepository::class);
        $product_ = $repository->show($product->id);
        $this->assertEquals($product->name, $product_->name);
    }
}
