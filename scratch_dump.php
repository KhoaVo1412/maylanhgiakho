<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

echo "=== PRODUCTS FOR LG, PANASONIC, REETECH ===\n";
foreach ([6, 7, 15] as $menuId) {
    echo "--- Menu ID: $menuId ---\n";
    $products = App\Models\Productt::where('active', 1)->where('menu_id', $menuId)->get();
    foreach ($products as $p) {
        echo "ID: {$p->id} | Name: {$p->name}\n";
    }
}
