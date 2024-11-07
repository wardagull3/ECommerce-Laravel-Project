<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\LowStockDetected;
use App\Models\LowStockNotification;

class NotifyAdminLowStockListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function handle(LowStockDetected $event)
    {
        LowStockNotification::updateOrCreate(
            ['product_id' => $event->product->id],
            ['stock_level' => $event->product->latestVariant()->stock_level]
        );
    }

}
