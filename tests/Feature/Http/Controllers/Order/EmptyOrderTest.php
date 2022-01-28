<?php

namespace Tests\Feature\Http\Controllers\Order;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmptyOrderTest extends TestCase
{
    public function test_empty_order()
    {
        $response = $this->call('GET', '/cart');
        $response->assertStatus(200);
        $response->assertSee('My Cart');
        $response->assertSeeInOrder(['My Cart', 'Add More Items', 'Special Requests', 'Add Note...', 'Update Note', 'Price Detail', 'Price', '0 items', 'Tax', 'Order Total', '$0.00', '$0.00', '$0.00', 'Checkout', 'Empty Cart']);
    }
}
