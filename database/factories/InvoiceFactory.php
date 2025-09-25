<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        $issue = $this->faker->dateTimeBetween('-2 months', 'now');
        $due = (clone $issue)->modify('+14 days');

        // Ambil client acak, atau buat jika belum ada (tanpa ClientFactory)
        $clientId = Client::query()->inRandomOrder()->value('client_id');
        if (!$clientId) {
            $client = Client::query()->create([
                'client_name' => $this->faker->company(),
                'email' => $this->faker->unique()->safeEmail(),
                'whatsapp' => '62'.$this->faker->numberBetween(8110000000, 8999999999),
                'address' => $this->faker->address(),
            ]);
            $clientId = $client->getKey();
        }

        return [
            'invoice_code' => 'INV-'.strtoupper(Str::random(6)),
            'client_id' => $clientId,
            'order_id' => null,
            'issue_date' => $issue->format('Y-m-d'),
            'due_date' => $due->format('Y-m-d'),
            'status' => $this->faker->randomElement(['draft','sent','paid','overdue']),
            'total_amount' => $this->faker->numberBetween(250000, 15000000),
        ];
    }
}
