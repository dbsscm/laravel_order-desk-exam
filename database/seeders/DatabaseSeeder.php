<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $maria = User::create(['name' => 'Maria Santos', 'email' => 'maria@example.com', 'password' => 'not-used']);
        $juan = User::create(['name' => 'Juan Dela Cruz', 'email' => 'juan@example.com', 'password' => 'not-used']);
        $ana = User::create(['name' => 'Ana Reyes', 'email' => 'ana@example.com', 'password' => 'not-used']);

        $products = collect([
            ['sku' => 'CTN-OIL155', 'name' => 'Century Tuna Flakes in Oil 155g (case of 48)', 'price' => 206400, 'stock' => 40],
            ['sku' => 'SRD-TOM155', 'name' => '555 Sardines in Tomato Sauce 155g (case of 100)', 'price' => 215000, 'stock' => 12],
            ['sku' => 'ARG-CB175', 'name' => 'Argentina Corned Beef 175g (case of 48)', 'price' => 288000, 'stock' => 200],
            ['sku' => 'CTN-HOT180', 'name' => 'Century Tuna Hot & Spicy 180g (case of 48)', 'price' => 235200, 'stock' => 3],
            ['sku' => 'ARG-ML150', 'name' => 'Argentina Meat Loaf 150g (case of 48)', 'price' => 124800, 'stock' => 60],
            ['sku' => 'ARG-VS130', 'name' => 'Argentina Vienna Sausage 130g (case of 48)', 'price' => 168000, 'stock' => 5],
            ['sku' => 'TNA-AFR155', 'name' => '555 Tuna Afritada 155g (case of 48)', 'price' => 163200, 'stock' => 25],
            ['sku' => 'SRD-HOT155', 'name' => '555 Sardines Hot 155g (case of 100)', 'price' => 225000, 'stock' => 150],
            ['sku' => 'CTN-CAL155', 'name' => 'Century Tuna Calamansi 155g (case of 48)', 'price' => 211200, 'stock' => 18],
            ['sku' => 'TNA-MEC155', 'name' => '555 Tuna Mechado 155g (case of 48)', 'price' => 163200, 'stock' => 80],
            ['sku' => 'ARG-BL150', 'name' => 'Argentina Beef Loaf 150g (case of 48)', 'price' => 139200, 'stock' => 35],
        ])->mapWithKeys(fn (array $row) => [$row['sku'] => Product::create($row)]);

        $this->order($maria, Order::STATUS_COMPLETED, 21, [['CTN-CAL155', 2], ['SRD-HOT155', 1]], $products);
        $this->order($ana, Order::STATUS_COMPLETED, 14, [['ARG-BL150', 3], ['ARG-CB175', 10]], $products);
        $this->order($maria, Order::STATUS_COMPLETED, 10, [['ARG-CB175', 5], ['ARG-ML150', 2]], $products);
        $this->order($juan, Order::STATUS_COMPLETED, 8, [['CTN-HOT180', 1]], $products);
        $this->order($maria, Order::STATUS_CANCELLED, 6, [['SRD-TOM155', 1]], $products);
        $this->order($juan, Order::STATUS_PENDING, 3, [['ARG-VS130', 1], ['TNA-MEC155', 4]], $products);
        $this->order($maria, Order::STATUS_PENDING, 1, [['TNA-AFR155', 2]], $products);

        // This product was removed from the catalog after it had already been ordered.
        $products['CTN-CAL155']->delete();
    }

    private function order(User $user, string $status, int $daysAgo, array $lines, $products): void
    {
        $date = Carbon::now()->subDays($daysAgo)->setTime(9 + $daysAgo % 8, 15);

        $order = Order::create([
            'user_id' => $user->id,
            'status' => $status,
            'total' => 0,
        ]);

        $total = 0;

        foreach ($lines as [$sku, $quantity]) {
            $product = $products[$sku];

            $order->items()->create([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'unit_price' => $product->price,
                'quantity' => $quantity,
            ]);

            $total += $product->price * $quantity;
        }

        $order->total = $total;
        $order->created_at = $date;
        $order->updated_at = $date;
        $order->save();
    }
}
