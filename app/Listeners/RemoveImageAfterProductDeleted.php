<?php

namespace App\Listeners;

use App\Events\ProductDeleted;
use App\Models\Image;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;

class RemoveImageAfterProductDeleted
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ProductDeleted  $event
     * @return void
     */
    public function handle(ProductDeleted $event)
    {
        $image_id = $event->image_id;
        $images = Image::whereIn('id', $image_id)->get();
        foreach ($images as $image) {
            Storage::delete($image->path);
            $image->delete();
        }
    }
}
