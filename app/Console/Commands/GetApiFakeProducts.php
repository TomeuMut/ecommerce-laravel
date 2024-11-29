<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
Use Illuminate\Support\Facades\Http;

class GetApiFakeProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:get-apifake-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = Http::get('https://fakestoreapi.com/products')->json();
        foreach ($data as $item) {
            Product::create([
                'name' => $item['title'],       // El nombre del producto
                'description' => $item['description'], // Descripción del producto
                'price' => $item['price'],       // Precio del producto
                'stock' => rand(1, 100),         // Stock aleatorio entre 1 y 100 (esto puede ajustarse según la lógica de tu negocio)
                'category_id' => rand(1, 3),     // ID de la categoría (esto debe ser válido, como una categoría existente)
                'image' => $item['image'],       // URL de la imagen del producto
            ]);
        }
    }
}
