<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stocks';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Calc the cost per unit
     *
     * @return string
     */
    public function cpu()
    {
        return round($this->cost / $this->amount, 2);
    }

    /**
     * Profit percentage
     */
    public function profitPercentage()
    {
        $product = $this->product;
        $cpu = $this->cpu();

        if($cpu == 0)
        {
            return 'NA';
        }

        return ($product->price - $cpu) / $cpu * 100;
    }

    /**
     * A stock entry belongs to a single product
     */
    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    /**
     * Get only elements in stock
     */
    public function scopeHasStock($query)
    {
        return $query->where('in_stock', '>', 0);
    }
}
