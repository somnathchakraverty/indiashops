<?php
namespace indiashopps\Models;
use Illuminate\Database\Eloquent\Model;
use indiashopps\Models\Cashback\VendorPayout;
use indiashopps\Models\Cashback\VendorSetting;
class OrderProduct extends Model
{
    public $timestamps = false;
    const AMOUNT_ZERO = 0;
    public static function updateProductQuantity($cart_id, $product_id, $quantity, $action = 'add')
    {
        if (empty($cart_id) || empty($product_id) || empty($quantity)) {
            return false;
        }
        $product = self::whereCartId($cart_id)->whereProductId($product_id)->first();
        if (is_null($product)) {
            return false;
        }
        if (!in_array($action, ['add', 'remove'])) {
            throw new \Exception("Invalid Update action.. permitted actions 'add & remove'");
        }
        switch ($action) {
            case 'add':
                $product->quantity += $quantity;
                break;
            case 'remove':
                $product->quantity -= $quantity;
                break;
        }
        $product->save();
    }
    public static function getProductCashback($amount, $vendor)
    {
        if (array_key_exists($vendor, config('vendor.name'))) {
            $vendor_setting = VendorSetting::whereVendorId($vendor)->where('cashback_enabled', 'Y')->first();
            $vendor_payout  = VendorPayout::whereVendorId($vendor)->whereEnabled('Y')->first();
            if (empty($vendor_payout) || empty($vendor_setting)) {
                return self::AMOUNT_ZERO;
            }
            if (strtolower($vendor_payout->payout_type) == 'flat') {
                $amount = $vendor_payout->payout_amount;
            } else {
                $amount = (($amount * $vendor_payout->payout_amount) / 100);
            }

            if (!empty($amount)) {
                return (($amount * $vendor_setting->cashback_user_percent) / 100);
            }
            return self::AMOUNT_ZERO;
        }
        return self::AMOUNT_ZERO;
    }
    public function cart()
    {
        return $this->belongsTo(PurchaseOrder::class,'cart_id', 'id');
    }
}