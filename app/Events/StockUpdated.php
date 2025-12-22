<?php

namespace App\Events;

use App\Models\Product;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StockUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $productId;
    public $stock;
    public $isLowStock;
    public $isOutOfStock;

    /**
     * Create a new event instance.
     */
    public function __construct(Product $product)
    {
        $this->productId = $product->id;
        $this->stock = $product->stock;
        $this->isLowStock = $product->isLowStock();
        $this->isOutOfStock = !$product->isInStock();
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): Channel
    {
        return new Channel('stock-updates');
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'stock.updated';
    }
}
