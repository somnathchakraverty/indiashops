<?php namespace indiashopps\Providers;

use indiashopps\Models\Cashback\UserCashback;
use indiashopps\Models\Cashback\UserWithdrawal;
use View;
use Illuminate\Support\ServiceProvider;


class MenuServiceProviderV2 extends ServiceProvider
{

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        View::composer('v3.master', 'indiashopps\Http\ViewComposers\MenuComposerV2');
        View::composer('v3.mobile.master', 'indiashopps\Http\ViewComposers\MenuComposerV2');
        View::composer('v3.amp.master', 'indiashopps\Http\ViewComposers\MenuComposerV2');

        View::composer('v3.cashback.include.user-info', function ($view) {
            $earnings           = UserCashback::whereUserId(\Auth::user()->id)->whereIn('status', [
                UserCashback::STATUS_APPROVED,
                UserCashback::STATUS_PENDING
            ])->select(['status', \DB::raw('SUM(cashback_amount) as amount')])->groupBy('status')->get();
            $earnings           = $earnings->map(function ($e) {
                return (object)$e->toArray();
            })->keyBy('status');
            $pending_withdrawal = UserWithdrawal::getPendingAmount();
            $view->with(['earnings' => $earnings, 'pending_withdrawal' => $pending_withdrawal]);
        });
        View::composer('v3.layout.cashback', function ($view) {
            $view->with(['layout_file' => (isMobile()) ? 'v3.mobile.master' : 'v3.master']);
        });

        View::composer('v3.mobile.cashback.include.user-info', function ($view) {
            $earnings           = UserCashback::whereUserId(\Auth::user()->id)->whereIn('status', [
                UserCashback::STATUS_APPROVED,
                UserCashback::STATUS_PENDING
            ])->select(['status', \DB::raw('SUM(cashback_amount) as amount')])->groupBy('status')->get();
            $earnings           = $earnings->map(function ($e) {
                return (object)$e->toArray();
            })->keyBy('status');
            $pending_withdrawal = UserWithdrawal::getPendingAmount();
            $view->with(['earnings' => $earnings, 'pending_withdrawal' => $pending_withdrawal]);
        });
        View::composer('v3.mobile.layout.cashback', function ($view) {
            $view->with(['layout_file' => (isMobile()) ? 'v3.mobile.master' : 'v3.master']);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}