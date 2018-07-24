<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Category;
use LaravelLocalization;

class Chk_if_cat_title_unique implements Rule
{
    private $id_cat;
    private $attr;
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    public function __construct($id = 0)
    {
        $this->id_cat = $id;
    }

    public function fired($id, $cat_title, $slug) {

        $cat =  Category::where('id', '!=', $id)->get();
       
        $arr = array();
       
        foreach ($cat as $row) {
            $cat_title_str = $row->cat_title; 
        }

        $titles = unserialize($cat_title_str);
        
        //strcmp is funcation reture 0 if is equal string
        $res = strcasecmp($cat_title, $titles[$slug]);
        
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
         $num_rows = Category::where('id', '!=', $this->id_cat)->count();


          if($num_rows >0)
          {
             foreach (LaravelLocalization::getSupportedLocales() as $k => $v) {

               $res =  $this->fired($this->id_cat, $value[$k], $k);
               //

               if($res == TRUE) {
                return FALSE;
               }

             }
             
             return TRUE;

          }
        return TRUE;
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
