<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    foreach (['owner', 'manager', 'supervisor', 'cashier', 'warehouse'] as $role) {
        Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
    }

    // Insert langsung ke tabel branches sesuai struktur kolom pada migration
    // create_branches_table (lihat catatan di README terkait penamaan kolom).
    $this->branchId = DB::table('branches')->insertGetId([
        'branch_name' => 'Cabang Utama',
        'city' => 'Jakarta',
        'address' => 'Jl. Testing No. 1',
        'phone_number' => '081234567890',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $this->category = Category::create([
        'name' => 'Minuman',
        'description' => 'Kategori minuman',
    ]);

    $this->product = Product::create([
        'category_id' => $this->category->id,
        'barcode' => 'BRG-001',
        'name' => 'Air Mineral 600ml',
        'purchase_price' => 2000,
        'selling_price' => 3000,
        'stock' => 50,
        'minimum_stock' => 5,
    ]);

    $this->cashier = User::create([
        'username' => 'kasir1',
        'name' => 'Kasir Satu',
        'email' => 'kasir1@test.com',
        'password' => bcrypt('password'),
        'is_active' => true,
    ]);
    $this->cashier->assignRole('cashier');
});

it('allows a cashier to create a sales transaction and reduces product stock automatically', function () {
    $response = $this->actingAs($this->cashier)->post(route('sales.store'), [
        'branch_id' => $this->branchId,
        'items' => [
            ['product_id' => $this->product->id, 'qty' => 3],
        ],
    ]);

    $sale = Sale::first();

    expect($sale)->not->toBeNull();
    expect((float) $sale->total)->toBe(9000.0);
    expect($sale->details)->toHaveCount(1);

    $this->product->refresh();
    expect($this->product->stock)->toBe(47);

    $response->assertRedirect(route('sales.show', $sale));
});

it('rejects a sale when quantity exceeds available stock', function () {
    $response = $this->actingAs($this->cashier)->post(route('sales.store'), [
        'branch_id' => $this->branchId,
        'items' => [
            ['product_id' => $this->product->id, 'qty' => 999],
        ],
    ]);

    $response->assertSessionHasErrors('items');

    $this->product->refresh();
    expect($this->product->stock)->toBe(50);
});

it('blocks non-cashier roles from accessing the sales transaction page', function () {
    $owner = User::create([
        'username' => 'owner1',
        'name' => 'Owner Satu',
        'email' => 'owner1@test.com',
        'password' => bcrypt('password'),
        'is_active' => true,
    ]);
    $owner->assignRole('owner');

    $this->actingAs($owner)->get(route('sales.create'))->assertStatus(403);
});

it('only lets owner and manager view the transaction report', function () {
    $owner = User::create([
        'username' => 'owner2',
        'name' => 'Owner Dua',
        'email' => 'owner2@test.com',
        'password' => bcrypt('password'),
        'is_active' => true,
    ]);
    $owner->assignRole('owner');

    $this->actingAs($owner)->get(route('reports.transactions'))->assertStatus(200);
    $this->actingAs($this->cashier)->get(route('reports.transactions'))->assertStatus(403);
});

it('lets owner, manager, and warehouse view the stock report', function () {
    $warehouse = User::create([
        'username' => 'gudang1',
        'name' => 'Petugas Gudang',
        'email' => 'gudang1@test.com',
        'password' => bcrypt('password'),
        'is_active' => true,
    ]);
    $warehouse->assignRole('warehouse');

    $this->actingAs($warehouse)->get(route('reports.stock'))->assertStatus(200);
    $this->actingAs($this->cashier)->get(route('reports.stock'))->assertStatus(403);
});
