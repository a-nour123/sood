<?php

namespace App\Rules;

use App\Models\Family;
use Illuminate\Contracts\Validation\Rule;

class ValidateDomainOrder implements Rule
{
    protected $id;
    protected $parent_id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id, $parent_id)
    {
        $this->id = $id;
        $this->parent_id = $parent_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $order
     * @return bool
     */
    public function passes($attribute, $order)
    {
        $domain = Family::find($this->id);
        $NotAvailableOrder = [];

        if (is_null($this->parent_id)) { // This is domain
            $NotAvailableOrder = Family::whereNull('parent_id')->where('id', '<>', $this->id)->pluck('order')->toArray();
        } else { // This is sub-domain
            if ($this->parent_id == $domain->parent_id)
                $NotAvailableOrder = $domain->parentFamily->families()->where('id', '<>', $this->id)->pluck('order')->toArray(); // Get parent domain sub-domains's orders without current sub-domain order
            else
                $NotAvailableOrder = Family::where('id', $this->parent_id)->families()->pluck('order')->toArray(); // Get new paretnt domain sub-domains's orders
        }

        return $order > 0 && !in_array($order, $NotAvailableOrder);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('locale.ThisOrderNumberIsNotAvailable');
    }
}
