<?php

namespace App\Observers;

use App\Models\Risk;

class RiskObserver
{
    /**
     * Handle the Risk "created" event.
     *
     * @param  \App\Models\Risk  $risk
     * @return void
     */
    public function created(Risk $risk)
    {
        $message = __("risk.A new risk ID") . " \"" . ($risk->id + 1000) . "\" was submitted by username \"" . (auth()->user()->name ?? 'Admin') . "\".";
        write_log($risk->id, auth()->id() ?? 1, $message);
    }

    /**
     * Handle the Risk "updated" event.
     *
     * @param  \App\Models\Risk  $risk
     * @return void
     */
    public function updated(Risk $risk)
    {
        //
    }

    /**
     * Handle the Risk "deleted" event.
     *
     * @param  \App\Models\Risk  $risk
     * @return void
     */
    public function deleted(Risk $risk)
    {
        //
    }

    /**
     * Handle the Risk "restored" event.
     *
     * @param  \App\Models\Risk  $risk
     * @return void
     */
    public function restored(Risk $risk)
    {
        //
    }

    /**
     * Handle the Risk "force deleted" event.
     *
     * @param  \App\Models\Risk  $risk
     * @return void
     */
    public function forceDeleted(Risk $risk)
    {
        //
    }
}
