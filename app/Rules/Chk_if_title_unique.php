<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Item;
use LaravelLocalization;

class Chk_if_title_unique implements Rule
{

    private $id_item;
    private $attr;
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    public function __construct($id = 0)
    {
        $this->id_item = $id;
    }

    public function fired($id, $item_title, $slug) {
        $items =  Item::where('id', '!=', $id)->get();
        
        $arr = array();
        
        foreach ($items as $row) {
            $item_title_str = $row->item_title; 
        }
        $titles = unserialize($item_title_str);
        //strcmp is funcation reture 0 if is equal string
        $res = strcasecmp($item_title, $titles[$slug]);
        
        if ($res == 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        $this->attr = $attribute;
         $num_rows = Item::where('id', '!=', $this->id_item)->count();

          if($num_rows >0)
          {
             foreach (LaravelLocalization::getSupportedLocales() as $k => $v) {

               $res =  $this->fired($this->id_item, $value[$k], $k);
               //

               if($res == TRUE) {
                return FALSE;
               }

             }

             return TRUE;

          }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return str_replace('_', ' ', $this->attr) . ' ' .trans('rule.unique');
    }
}
