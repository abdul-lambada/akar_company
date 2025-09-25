<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\InvoiceItem>
 */
class InvoiceItemFactory extends Factory
{
    protected $model = InvoiceItem::class;

    public function definition(): array
    {
        $qty = $this->faker->numberBetween(1, 5);
        $price = $this->faker->numberBetween(100000, 3000000);
        return [
            'invoice_id' => Invoice::query()->inRandomOrder()->value('invoice_id') ?? Invoice::factory()->create()->getKey(),
            'description' => $this->faker->sentence(3),
            'quantity' => $qty,
            'unit_price' => $price,
            'line_total' => $qty * $price,
        ];
    }
}
