<?php

use Framework\Database\Connection\Connection;

class SeedProducts
{
    public function migrate(Connection $connection)
    {
        $products = [
            [
                'name' => 'Space Tour',
                'description' => 'Take a trip on a rocket ship. Our tours are out of this world. Sign up now for a journey you won&apos;t soon forget.',
            ],
            [
                'name' => 'Large Rocket',
                'description' => 'Need to bring some extra space-baggage? Everyone asking you to bring back a moon rock for them? This is the rocket you want...',
            ],
            [
                'name' => 'Small Rocket',
                'description' => 'Space exploration is expensive. This rocket comes in under budget and atmosphere.',
            ],
        ];

        foreach ($products as $product) {
            $connection
                ->query()
                ->from('products')
                ->insert(['name', 'description'], $product);
        }
    }
}
