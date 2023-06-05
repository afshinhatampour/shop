<?php

namespace Manage\Product;

use App\Enums\ProductEnums;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Tests\TestCase;
use Throwable;
use function PHPUnit\Framework\stringContains;

class ProductControllerTest extends TestCase
{
    use DatabaseMigrations;

    const TEST_CASE_PRODUCT_ID = 1;

    /**
     * @return void
     */
    public function runDatabaseMigrations(): void
    {
        $this->artisan('migrate:refresh');
        $this->artisan('db:seed');
        $this->artisan('passport:install');
    }

    /**
     * @return void
     * @test
     * @throws Throwable
     */
    public function indexProducts(): void
    {
        $user = User::first();
        $accessToken = $user->createToken('token name')->accessToken;
        $response = $this->get(route('products.index'), [
            'Authorization' => 'Bearer ' . $accessToken
        ]);
        $response->assertStatus(HttpFoundationResponse::HTTP_OK);

        $response->assertJsonFragment([
            'title'     => Product::first()->title,
            'content'   => Product::first()->content,
            'status'    => Product::first()->status,
            'unique_id' => Product::first()->unique_id
        ]);

        $response->assertJsonFragment([
            'from' => 1
        ]);

        $content = $response->decodeResponseJson();
        $content->assertPath('message', trans('product.manage.index'));
        $content->assertPath('code', HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @return void
     * @test
     * @throws Throwable
     */
    public function showProduct(): void
    {
        $user = User::first();
        $accessToken = $user->createToken('token name')->accessToken;
        $response = $this->get(route('products.show',
            ['product' => self::TEST_CASE_PRODUCT_ID]),
            ['Authorization' => 'Bearer ' . $accessToken]
        );
        $response->assertStatus(HttpFoundationResponse::HTTP_OK);

        $response->assertJsonFragment([
            'title'     => Product::find(self::TEST_CASE_PRODUCT_ID)->title,
            'content'   => Product::find(self::TEST_CASE_PRODUCT_ID)->content,
            'status'    => Product::find(self::TEST_CASE_PRODUCT_ID)->status,
            'unique_id' => Product::find(self::TEST_CASE_PRODUCT_ID)->unique_id
        ]);

        $content = $response->decodeResponseJson();
        $content->assertPath('message', trans('product.manage.show'));
        $content->assertPath('code', HttpFoundationResponse::HTTP_OK);
    }

    /**
     * @return void
     * @test
     * @throws Throwable
     */
    public function storeProduct(): void
    {
        $beforeCreateNewProductCount = Product::count();
        $earlyProductParams = [
            'title'   => 'unit test product title',
            'content' => 'unit test product content',
            'status'  => ProductEnums::STATUS['active']];

        $user = User::first();
        $accessToken = $user->createToken('token name')->accessToken;

        $response = $this->post(route('products.store'), $earlyProductParams,
            ['Authorization' => 'Bearer ' . $accessToken]);
        $response->assertStatus(HttpFoundationResponse::HTTP_CREATED);

        $content = $response->decodeResponseJson();
        $content->assertPath('message', trans('product.manage.create'));
        $content->assertPath('code', HttpFoundationResponse::HTTP_CREATED);
        $this->assertEquals(Product::count(), ++$beforeCreateNewProductCount);

        $earlyProductCreated = Product::orderByDesc('id')->first();
        $this->assertEquals($earlyProductCreated->title, $earlyProductParams['title']);
        $this->assertEquals($earlyProductCreated->content, $earlyProductParams['content']);
        $this->assertEquals($earlyProductCreated->status, $earlyProductParams['status']);
        $this->assertTrue((bool)stringContains($earlyProductCreated->unique_id, ProductEnums::UNIQUE_ID_PREFIX));
        $this->assertEquals(1, Product::where('unique_id', $earlyProductCreated->unique_id)->count());
    }

    /**
     * @return void
     * @test
     * @throws Throwable
     */
    public function updateProduct(): void
    {
        $selectProductForUpdateParams = [
            'title'   => 'update by test title',
            'content' => 'update by test content',
            'status'  => ProductEnums::STATUS['inactive']
        ];

        $selectedProductForUpdateObject = Product::find(self::TEST_CASE_PRODUCT_ID);

        $user = User::first();
        $accessToken = $user->createToken('token name')->accessToken;

        $response = $this->put(route('products.update', ['product' => self::TEST_CASE_PRODUCT_ID]),
            $selectProductForUpdateParams, ['Authorization' => 'Bearer ' . $accessToken]);
        $response->assertStatus(HttpFoundationResponse::HTTP_OK);

        $content = $response->decodeResponseJson();
        $content->assertPath('message', trans('product.manage.update'));
        $content->assertPath('code', HttpFoundationResponse::HTTP_OK);
        $content->assertPath('data.title', $selectProductForUpdateParams['title']);
        $content->assertPath('data.content', $selectProductForUpdateParams['content']);
        $content->assertPath('data.status', $selectProductForUpdateParams['status']);
        $content->assertPath('data.unique_id', $selectedProductForUpdateObject->unique_id);
    }

    /**
     * @return void
     * @throws Throwable
     * @test
     */
    public function deleteProduct(): void
    {
        $user = User::first();
        $accessToken = $user->createToken('token name')->accessToken;

        $response = $this->delete(route('products.destroy', ['product' => self::TEST_CASE_PRODUCT_ID]), [],
            ['Authorization' => 'Bearer ' . $accessToken]);
        $response->assertStatus(HttpFoundationResponse::HTTP_NO_CONTENT);
    }
}
