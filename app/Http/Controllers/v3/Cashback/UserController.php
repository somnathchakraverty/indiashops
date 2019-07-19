<?php

namespace indiashopps\Http\Controllers\v3\Cashback;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use indiashopps\Events\CorporateUserCreated;
use indiashopps\Events\WithdrawalStatusChanged;
use indiashopps\Http\Controllers\v3\BaseController;
use indiashopps\Mail\WithdrawRequestSubmitted;
use indiashopps\Models\Cashback\AffiliateClick;
use indiashopps\Models\Cashback\Ticket;
use indiashopps\Models\Cashback\TicketComment;
use indiashopps\Models\Cashback\UserCashback;
use indiashopps\Models\Cashback\UserWithdrawal;
use indiashopps\Models\OrderProduct;
use indiashopps\Models\PurchaseOrder;
use indiashopps\User;

class UserController extends BaseController
{
    private $view_path = 'v3.';

    public function __construct()
    {
        $this->middleware('cashback_permission');

        if (isMobile()) {
            $this->view_path = "v3.mobile.";
        }
    }

    public function earnings()
    {
        $data['transactions'] = UserCashback::whereUserId(\Auth::user()->id)
                                            ->orderBy('user_cbid', "DESC")
                                            ->paginate(10);

        if (request()->ajax() && request()->get('type') == 'transaction') {
            return view('v3.cashback.include.transactions', $data);
        }

        $user     = User::with(['cashback', 'paid'])->whereId(\Auth::user()->id)->first();
        $cashback = $user->cashback->groupBy('status')->map(function ($c) {
            return (object)[
                'amount' => $c->sum('cashback_amount')
            ];
        });

        $data['cashback'] = $cashback;
        $data['paid']     = $user->paid->sum('cashback_amount');

        return view($this->view_path . 'cashback.user-earning', $data);
    }

    public function withdraw(Request $request)
    {
        if ($request->isMethod('POST')) {
            if ($request->has('withdrawal_type')) {
                switch ($request->withdrawal_type) {
                    case 'wallet':
                        $rules = [
                            'store'        => 'required',
                            'email'        => 'required|email',
                            'name'         => 'required',
                            'phone_number' => 'required'
                        ];

                        break;

                    case 'bank':
                        $rules = [
                            'account_holder_name' => 'required',
                            'bank_name'           => 'required',
                            'account_number'      => 'required',
                            'branch_address'      => 'required',
                            'ifsc_code'           => 'required|regex:/^[A-Za-z]{4}\d{7}$/'
                        ];

                        break;
                }

                $validation = \Validator::make($request->all(), $rules);

                if ($validation->fails()) {
                    return redirect()
                        ->back()
                        ->withErrors($validation->messages())
                        ->with('action', $request->withdrawal_type);
                }
                $available_balance = User::getAvailableCashbackAmount();

                if ($available_balance < UserCashback::MINIMUM_WITHDRAWAL_AMOUNT) {
                    return redirect()
                        ->back()
                        ->withErrors(['Minimum threshold not reached.. 250'])
                        ->with('action', $request->withdrawal_type);
                }

                switch ($request->withdrawal_type) {
                    case 'wallet':

                        $insert = [
                            'mode'       => (strtolower($request->store) == 'paytm') ? 'wallet' : 'voucher',
                            'mode_info1' => $request->store,
                            'mode_info2' => $request->email,
                            'mode_info3' => $request->name,
                            'mode_info4' => $request->phone_number,
                        ];
                        break;

                    case 'bank':
                        $insert = [
                            'mode'       => 'bank',
                            'mode_info1' => $request->account_holder_name,
                            'mode_info2' => $request->bank_name,
                            'mode_info3' => $request->account_number,
                            'mode_info4' => $request->branch_address,
                            'mode_info5' => $request->ifsc_code,
                        ];
                        break;
                }
                $insert['user_id']         = \Auth::user()->id;
                $insert['amount']          = $available_balance;
                $insert['cashback_amount'] = $available_balance;
                $insert['reward_amount']   = 0;
                $insert['status']          = 'requested';

                UserWithdrawal::insert($insert);

                event(new WithdrawalStatusChanged(auth()->user()->id));

                /**Sending withdrawal mail request to admin..**/
                \Mail::queue(new WithdrawRequestSubmitted(auth()->user(), $available_balance));

                return redirect()
                    ->back()
                    ->with('message', 'Withdrawal requested submitted..!')
                    ->with('action', $request->action);
            } else {
                return redirect()
                    ->back()
                    ->withErrors(['Invalid Request..!'])
                    ->with('action', $request->withdrawal_type);
            }
        }

        if ($request->has('status') && $request->get('status') != '') {
            $data['withdrawals'] = UserWithdrawal::whereUserId(\Auth::user()->id)
                                                 ->where('status', 'like', $request->get('status'));
        } else {
            $data['withdrawals'] = UserWithdrawal::whereUserId(\Auth::user()->id);
        }

        $data['withdrawals'] = $data['withdrawals']->orderBy('withdrawal_id', "DESC")->paginate(10);
        $data['status']      = ($request->has('status')) ? $request->get('status') : '';

        if (request()->ajax() && request()->get('type') == 'withdrawal') {
            return view($this->view_path . 'cashback.include.withdrawals', $data);
        }

        $earnings = UserCashback::whereUserId(\Auth::user()->id)->whereIn('status', [
            UserCashback::STATUS_APPROVED
        ])->select(['cashback_type', \DB::raw('SUM(cashback_amount) as amount')])->groupBy('cashback_type')->get();

        $data['earnings'] = $earnings->map(function ($e) {
            return (object)$e->toArray();
        })->keyBy('cashback_type');

        $data['pending_withdrawal'] = UserWithdrawal::getPendingAmount();

        return view($this->view_path . 'cashback.withdraw', $data);
    }

    public function missing(Request $request)
    {
        if ($request->isMethod('POST')) {
            $validator = \Validator::make($request->all(), [
                'store'            => 'required',
                'click_out_time'   => 'required',
                'order_id'         => 'required',
                'transaction_date' => 'required|date',
                'amount'           => 'required',
                'message'          => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages());
            }

            $claim = Ticket::whereClickId($request->get('click_out_time'))->first();

            if (!is_null($claim)) {
                return redirect()->back()->withErrors(["Claim Already Submitted for this click..!"]);
            }

            $claim = new Ticket;
            $click = AffiliateClick::find($request->get('click_out_time'));

            if (is_null($click)) {
                return redirect()->back()->withErrors(["Invalid click ID selected.. Please contact Admin..!"]);
            }

            $claim->user_id      = \Auth::user()->id;
            $claim->click_id     = $request->get('click_out_time');
            $claim->click_time   = $click->click_time;
            $claim->vendor_id    = $request->get('store');
            $claim->order_id     = $request->get('order_id');
            $claim->order_date   = $request->get('transaction_date');
            $claim->order_amount = $request->get('amount');
            $claim->order_proof  = '';
            $claim->user_comment = $request->get('message');
            $claim->status       = Ticket::DEFAULT_STATUS;

            $claim->save();

            return redirect()->route('cashback.missing.claim')->with('messages', ['Claim Submitted..!!']);
        }
        $data['clicks'] = AffiliateClick::getMissingClicks();

        return view($this->view_path . 'cashback.missing', $data);
    }

    public function missingClaim()
    {
        $data['tickets'] = Ticket::getUserTickets();

        return view($this->view_path . 'cashback.missing-claims', $data);
    }

    public function settings(Request $request)
    {
        $data['user'] = auth()->user();

        if ($request->isMethod('POST')) {
            if ($request->has('action') && $request->has('user_id')) {
                switch ($request->get('action')) {
                    case 'profile':

                        $validator = \Validator::make($request->all(), [
                            'name'          => 'required',
                            'date_of_birth' => 'required|date',
                            'gender'        => 'required',
                            'country'       => 'required',
                            'city'          => 'required',
                            'mobile'        => 'required|min:10',
                        ]);

                        if ($validator->fails()) {
                            return redirect()
                                ->back()
                                ->withErrors($validator->messages())
                                ->with('action', $request->action);
                        }

                        if (Carbon::now()->timestamp < Carbon::parse($request->get('date_of_birth'))->timestamp) {
                            return redirect()
                                ->back()
                                ->withErrors(['DOB cannot be a future date..'])
                                ->with('action', $request->action);
                        }

                        $user = User::find($request->user_id);

                        $user->name    = $request->get('name');
                        $user->bday    = $request->get('date_of_birth');
                        $user->gender  = $request->get('gender');
                        $user->country = $request->get('country');
                        $user->city    = $request->get('city');
                        $user->mobile  = $request->get('mobile');

                        $user->save();

                        break;

                    case 'password':
                        $validator = \Validator::make($request->all(), [
                            'old_password' => 'required',
                            'password'     => 'required|confirmed|min:6',
                        ]);

                        if ($validator->fails()) {
                            return redirect()
                                ->back()
                                ->withErrors($validator->messages())
                                ->with('action', $request->action);
                        }

                        $valid = \Auth::attempt([
                            'id'       => $request->get('user_id'),
                            'password' => $request->get('old_password')
                        ], $request->has('remember'));

                        if (!$valid) {
                            return redirect()
                                ->back()
                                ->withErrors(['Invalid Old Password..!'])
                                ->with('action', $request->action);
                        }

                        $user = User::find($request->user_id);

                        $user->password = bcrypt($request->get('password'));
                        $user->save();

                        break;

                    default:
                        return redirect()->back()->with('action', $request->action);
                }

                return redirect()->back()->with([
                    'message' => 'Profile Updated Successfully..',
                    'action'  => $request->action
                ]);

            } else {
                return redirect()->back()->withErrors(['Invalid request, please resubmit..!']);
            }
        }

        return view($this->view_path . 'cashback.settings', $data);
    }

    public function claimDetail($ticket_id)
    {
        if (request()->isMethod('GET') && request()->get('action') == 'close') {
            $claim = Ticket::find($ticket_id);

            if (is_null($claim)) {
                return redirect()->back()->withErrors(['Invalid ID']);
            }

            $claim->closed_on = Carbon::now()->toDateTimeString();
            $claim->status    = Ticket::CLOSED;
            $claim->closed_by = 'user';
            $claim->save();

            return redirect()->back()->with('message', 'Ticket Closed Successfully..!');
        }
        $data['claim'] = Ticket::whereTicketId($ticket_id)->with(['setting', 'payout', 'comments'])->first();

        if (is_null($data['claim'])) {
            return response()->json([], 403);
        }

        return view($this->view_path . 'cashback.claim', $data);
    }

    public function addComment($ticket_id)
    {
        $all              = request()->all();
        $all['ticket_id'] = $ticket_id;

        $validator = \Validator::make($all, [
            'comment'   => 'required|min:10',
            'ticket_id' => 'exists:tb_tickets,ticket_id',
        ], [
            'ticket_id.exists' => 'Invalid Ticket Specified..'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->messages());
        }

        $comment            = new TicketComment;
        $comment->comment   = request()->get('comment');
        $comment->ticket_id = $ticket_id;
        $comment->added_by  = 'user';
        $comment->save();

        return redirect()->back()->with('message', 'Comment Added successfully..!');
    }

    public function users($user_id = 0)
    {
        if (!empty($user_id)) {

            $data['user'] = $user = User::find($user_id);

            if (is_null($user)) {
                return redirect()->back()->withErrors(['Invalid USER.. !!']);
            }

            if (!auth()->user()->isAdmin() && $user->isAdmin()) {
                return redirect()->back()->withErrors(['You can change Admin\'s profile..']);
            }

            if (request()->has('delete')) {
                $user->mapping->delete();
                $user->delete();

                return redirect()->route('cashback.users')->with('message', "User Deleted..!");
            }

            if (request()->isMethod('post')) {

                $validator = validator(request()->all(), [
                    'name'   => 'required',
                    'gender' => 'required',
                    'mobile' => 'required|numeric|min:10'
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator->messages());
                }

                if (request()->get('permissions')) {
                    $permissions = collect(request()->get('permissions'))->toJson();
                } else {
                    $permissions = '[]';
                }

                $update = request()->only([
                    'name',
                    'gender',
                    'mobile'
                ]);

                $user->update($update);
                $user->mapping->update(["permissions" => $permissions]);

                auth()->user()->userConditionChecks();

                return redirect()->route('cashback.users')->with('message', "User updated successfully..!");
            }

            $data['permissions'] = $user->mapping->getPermissions();

            return view($this->view_path . 'cashback.users.edit', $data);
        }

        $data['users'] = User::usersQuery()->paginate(10);

        return view($this->view_path . 'cashback.users.list', $data);
    }

    public function createUser(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->action == 'new_user') {
                $validator = validator($request->all(), [
                    'name'   => 'required',
                    'email'  => 'required|email|unique:and_user,email',
                    'gender' => 'required',
                    'mobile' => 'required|numeric|min:10'
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator->messages());
                }
                $password = bcrypt(str_random(10));
                $user     = new User;

                $user->name       = $request->get('name');
                $user->password   = $password;
                $user->email      = $request->get('email');
                $user->gender     = $request->get('gender');
                $user->mobile     = $request->get('mobile');
                $user->company_id = auth()->user()->company_id;
                $user->save();

                event(new CorporateUserCreated($user->id, $request->get('permissions', [])));

                auth()->user()->userConditionChecks();

                return redirect()->route('cashback.users')->with('message', 'User created successfully..!!');
            }

            return redirect()->back()->withErrors('Invalid Action supplied..');
        }

        return view($this->view_path . 'cashback.users.create');
    }

    /**
     * @param int $order_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function purchaseOrders($order_id = 0)
    {
        if (!empty($order_id)) {
            /*###--Get the Order base on purchase ID, if on detail page.--###*/
            $data['order'] = $order = PurchaseOrder::with('products')->find($order_id);

            if (request()->isMethod('post')) {
                $validator = validator(request()->all(), [
                    'email' => 'required|email',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator->messages());
                }

                $email = request()->get('email');
                $user  = auth()->user();
                \Mail::send('v3.cashback.purchase.approval_order', [
                    'order'     => $order,
                    'user'      => $user,
                    'order_url' => route('cashback.purchase.orders', [$order->id])
                ], function ($message) use ($email, $user) {
                    $message->from(env('MAIL_USERNAME'), "Indiashopps");
                    $message->to($email, '')->subject('Purchase Order for Approval');
                });

                return redirect()
                    ->back()
                    ->with("message", "Email Sent to <strong>" . $email . "</strong> for Approval..!");
            }

            if (is_null($data['order'])) {
                return redirect()->back()->withErrors('Invalid Purchase ID supplied. !');
            }

            if (request()->has('print')) {
                return view($this->view_path . 'cashback.purchase.print_order', $data);
            }

            if (request()->has('approve')) {
                if (!userHasAccess('purchase.approve')) {
                    $error = 'Access Denied, please contact your Admin..';
                } elseif ($order->status == PurchaseOrder::STATUS_APPROVED) {
                    $error = 'Order already Approved..';
                } elseif ($order->status == PurchaseOrder::STATUS_REJECTED) {
                    $error = 'Reject Order cannot be Approved..';
                } elseif ($order->status == PurchaseOrder::STATUS_CLOSED) {
                    $error = 'Closed Order cannot be Approved..';
                }

                if (isset($error)) {
                    return redirect()->route('cashback.purchase.orders')->withErrors($error);
                }

                $order->status = PurchaseOrder::STATUS_APPROVED;
                $order->save();

                PurchaseOrder::clearOrderCache();

                return redirect()->back()->with('message', 'Order Approved..');
            }

            if (request()->has('reject')) {
                if (!userHasAccess('purchase.approve')) {
                    $error = 'Access Denied, please contact your Admin..';
                } elseif ($order->status == PurchaseOrder::STATUS_APPROVED) {
                    $error = 'Approved Order cannot be rejected..';
                } elseif ($order->status == PurchaseOrder::STATUS_REJECTED) {
                    $error = 'Already Rejected..';
                } elseif ($order->status == PurchaseOrder::STATUS_CLOSED) {
                    $error = 'Closed Order cannot be Rejected..';
                }

                if (isset($error)) {
                    return redirect()->route('cashback.purchase.orders')->withErrors($error);
                }

                $order->status = PurchaseOrder::STATUS_REJECTED;
                $order->save();

                PurchaseOrder::clearOrderCache();

                return redirect()->back()->with('message', 'Order Rejected..');
            }

            if (request()->has('delete')) {
                if (request()->has('product_id')) {
                    $return = PurchaseOrder::deleteProduct(request()->get('product_id'));

                    if ($return instanceof MessageBag) {
                        return redirect()->back()->withErrors($return->getMessages());
                    }

                    return redirect()->back()->with('message', 'Product Deleted..!!');
                } else {
                    return redirect()->back();
                }
            }

            if (request()->has('email')) {
                $user = auth()->user();
                \Mail::send('v3.cashback.purchase.email_order', [
                    'order' => $order,
                ], function ($message) use ($user) {
                    $message->from(env('MAIL_USERNAME'), "Indiashopps");
                    $message->to($user->email, $user->name)->subject('Purchase Order Details');
                });

                return redirect()->back()->with("message", "Email Sent..!");
            }

            if (request()->has('close')) {
                if (!userHasAccess('purchase.approve')) {
                    $error = 'Access Denied, please contact your Admin..';
                } elseif ($order->status != PurchaseOrder::STATUS_CLOSED) {
                    $order->status = PurchaseOrder::STATUS_CLOSED;
                    $order->save();

                    PurchaseOrder::clearOrderCache();

                    return redirect()->back()->with('message', 'Order Closed..');
                } else {
                    $error = 'Order Already Closed..!!';
                }

                if (isset($error)) {
                    return redirect()->route('cashback.purchase.orders')->withErrors($error);
                }
            }

            return view($this->view_path . 'cashback.purchase.detail', $data);
        }

        if (request()->has('create_order')) {
            if (PurchaseOrder::hasOpenOrder()) {
                return redirect()->back()->withErrors(["Already has one open purchase order..!!"]);
            } else {
                PurchaseOrder::createOrder();
                PurchaseOrder::clearOrderCache();

                return redirect()->back()->with('message', "New Purchase Order created..!!");
            }
        }

        if (PurchaseOrder::hasOpenOrder()) {
            $data['hasOrder'] = true;
        } else {
            $data['hasOrder'] = false;
        }

        $data['orders'] = PurchaseOrder::getCompanyOrders();

        return view($this->view_path . 'cashback.purchase.orders', $data);
    }

    public function addProductToPurchaseOrder(Request $request)
    {
        PurchaseOrder::addProductToOrder($request);

        return response()->json(["Product Added"]);
    }

    public function updateProductQuantity(Request $request)
    {

        if (!$request->has('cart_id')) {
            return $this->jsonError('Invalid Purchase ID');
        }

        if (!$request->has('pid') || !$request->has('qty')) {
            return $this->jsonError('Invalid Product Details');
        }

        $purchase = PurchaseOrder::find($request->get('cart_id'));

        if (is_null($purchase)) {
            return $this->jsonError('Invalid Purchase ID');
        }

        $product = OrderProduct::whereId($request->get('pid'))->first();

        if (is_null($product)) {
            return $this->jsonError('Invalid Product Details');
        }

        $price     = $product->product_price;
        $old_total = $price * $product->quantity;
        $new_total = $price * $request->get('qty');

        $diff_qty      = $request->get('qty') - $product->quantity;
        $diff_savings  = ($product->saving * $request->get('qty')) - ($product->saving * $product->quantity);
        $diff_cashback = ($product->cashback * $request->get('qty')) - ($product->cashback * $product->quantity);
        $diff          = $new_total - $old_total;

        $purchase->total_price += $diff;
        $purchase->total_savings += $diff_savings;
        $purchase->no_of_products += $diff_qty;
        $purchase->total_cashback += $diff_cashback;

        $purchase->save();

        $product->quantity = $request->get('qty');
        $product->save();

        return response()->json([], 201);
    }

    private function jsonError($error)
    {
        session()->put("message", $error);

        return response()->json([]);
    }
}