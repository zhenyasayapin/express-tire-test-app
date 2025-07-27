<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Cart;
use App\Factory\ProductFactory;
use Zenstruck\Foundry\Test\Factories;

class CartTest extends ApiTestCase
{

    use Factories;
    public function setUp(): void
    {
        self::$alwaysBootKernel = false;
    }

    public function testAddProductToCart(): void
    {
        $productId = ProductFactory::createOne()->getId();

        $client = static::createClient();

        $response = $client->request('POST', '/cart', [
            'json' => [
                'productId' => $productId
            ]
        ]);

        $repository = self::$kernel->getContainer()->get('doctrine')->getRepository(Cart::class);

        $cart = $repository->find(json_decode($response->getContent())->id);

        $cartItem = $cart->getItems()[0];

        $this->assertEquals($productId, $cartItem->getProduct()->getId());
    }

    public function testGetCart(): void
    {
        $client = static::createClient();

        $response = $client->request('GET', '/cart');

        $this->assertResponseIsSuccessful();
        $this->assertGreaterThanOrEqual(1, json_decode($response->getContent())->id);
        $this->assertJsonContains([
            'id' => json_decode($response->getContent())->id,
            'items' => [],
            'totalPrice' => 0,
            'count' => 0
        ]);
    }
}
