<?php
namespace indiashopps\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\MessageBag;

class PurchaseOrder extends Model
{
    const STATUS_OPEN     = '1';
    const STATUS_APPROVED = '2';
    const STATUS_REJECTED = '3';
    const STATUS_CLOSED   = '4';
    const STATUES         = [
        self::STATUS_OPEN     => 'Open',
        self::STATUS_APPROVED => 'Approved',
        self::STATUS_REJECTED => 'Rejected',
        self::STATUS_CLOSED   => 'Closed',
    ];

    public static function getCompanyOrders()
    {
        $query = self::query();
        return $query->whereCompanyId(auth()->user()->company_id)->orderBy('created_at', 'DESC')->paginate(10);
    }

    public static function hasOpenOrder()
    {
        if (!auth()->check()) {
            return false;
        }

        $hasOrder = Cache::rememberForever(self::getOrderCacheId(), function () {
            $query = self::query();
            $order = $query->whereCompanyId(auth()->user()->company_id)->whereStatus(self::STATUS_OPEN)->first();

            if (is_null($order)) {
                return false;
            }

            return true;
        });

        return $hasOrder;
    }

    public static function getOrderCacheId()
    {
        if (!auth()->check()) {
            return false;
        }

        $cache_id = "purchase_order_" . auth()->user()->company_id;

        return $cache_id;
    }

    public static function clearOrderCache()
    {
        if (!auth()->check()) {
            return false;
        }

        Cache::forget(self::getOrderCacheId());
    }

    public function getStatus()
    {
        return self::STATUES[$this->status];
    }

    public function getDate()
    {
        return Carbon::parse($this->created_at)->format('jS F, Y g:i:s a');
    }

    public function totalProducts()
    {
        return $this->no_of_products;
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class, 'cart_id', 'id');
    }

    public static function addProductToOrder($product)
    {
        $purchase = self::whereCompanyId(auth()->user()->company_id)->whereStatus(self::STATUS_OPEN)->first();
        if (is_null($purchase)) {
            $purchase = self::createOrder();
        }
        $purchase->no_of_products += 1;
        $purchase->total_price += $product->price;
        $purchase->total_savings += $product->saving;
        $purchase->save();
        $purchase->updateProducts($product);
    }

    public static function createOrder()
    {
        $purchase                 = new self;
        $purchase->no_of_products = 0;
        $purchase->total_price    = 0;
        $purchase->total_savings  = 0;
        $purchase->total_cashback = 0;
        $purchase->status         = 1;
        $purchase->company_id     = auth()->user()->company_id;

        $purchase->save();

        return $purchase;
    }

    public function updateProducts($product)
    {
        $orderProduct = OrderProduct::whereCartId($this->id)->whereProductId($product->id)->first();
        if (is_null($orderProduct)) {
            $orderProduct                = new OrderProduct;
            $orderProduct->cart_id       = $this->id;
            $orderProduct->product_id    = $product->id;
            $orderProduct->product_name  = $product->name;
            $orderProduct->product_image = $product->image;
            $orderProduct->product_price = $product->price;
            $orderProduct->saving        = 0;
            $orderProduct->quantity      = 0;
            $orderProduct->cashback      = OrderProduct::getProductCashback($product->price, $product->vendor);
            $orderProduct->vendor        = $product->vendor;
            $orderProduct->out_url       = $product->out_url;
            $orderProduct->product_group = $product->group;
            $orderProduct->comp          = (isset($product->comp)) ? '1' : '0';
        }
        $orderProduct->quantity = $orderProduct->quantity + 1;
        $orderProduct->saving   = $orderProduct->saving + $product->saving;
        $orderProduct->save();
        $this->total_cashback += $orderProduct->cashback;
        $this->save();
    }

    public static function deleteProduct($product_id)
    {
        $Errors = new MessageBag();
        if (empty($product_id)) {
            $Errors->add('invalid_id', "Invalid Product ID");
            return $Errors;
        }
        $product = OrderProduct::with('cart')->whereId($product_id)->first();
        if (is_null($product)) {
            $Errors->add('invalid_id', "Invalid Product ID");
            return $Errors;
        }
        if ($product->cart->company_id != auth()->user()->company_id) {
            $Errors->add('invalid_id', "Invalid Product ID");
            return $Errors;
        }
        $total_price    = $product->product_price * $product->quantity;
        $total_savings  = $product->saving * $product->quantity;
        $total_cashback = $product->cashback * $product->quantity;
        $product->cart->total_price -= $total_price;
        $product->cart->total_savings -= $total_savings;
        $product->cart->total_cashback -= $total_cashback;
        $product->cart->no_of_products -= $product->quantity;
        $product->cart->save();
        $product->delete();
        return true;
    }
}