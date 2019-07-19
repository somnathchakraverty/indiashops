<?php

namespace indiashopps\Http\Controllers\v3\Cashback;

use Illuminate\Http\Request;
use indiashopps\Http\Controllers\Controller;

class TicketController extends Controller
{
    /**
     * Returns User Tickets..
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTickets()
    {
        return view();
    }

    /**
     * Ticket will be save into the system, once user inputs are validated..
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function submitTicket( Request $request )
    {
        $validator = \Validator::make($request->all(),[
            'user_comment' => 'required|min:10',
        ]);

        if( $validator->fails() )
        {
            return redirect()->back()->withErrors($validator->messages());
        }

        return view();
    }

    public function changeStatus()
    {

    }
}
