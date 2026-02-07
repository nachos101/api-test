<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;    

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Detergente Líquido',
                'Lavandina',
                'Cloro',
                'Desodorante para piso',
                'Jabón en polvo',
                'Skip'
            ]),
            'description' => $this->faker->sentence(),
            'category' => $this->faker->randomElement([
                'Detergentes',
                'Desinfectantes',
                'Limpiadores multiusos',
                'Productos para baño',
                'Productos para cocina'
            ]),
            'price' => $this->faker->randomFloat(200, 500, 5000),
            'stock' => $this->faker->numberBetween(0, 100),
        ];
    }
}
