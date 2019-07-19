@php
    $routes = [
        'cashback.earnings' => 'Cashback Earnings',
        'cashback.withdraw' => 'Withdraw',
        'cashback.missing' => 'Missing Cashback',
        'cashback.missing.claim' => 'Missing Cashback Claim',
        'cashback.settings' => 'Profile Setting',
        'cashback.users' => 'Manage Users',
        'cashback.purchase.orders' => 'Purchase Orders',
    ];
@endphp
<label>Actions</label>
<select name="action" id="action_option">
    <option value="">--Select Action--</option>
    @foreach($routes as $route => $text)
        @if(userHasAccess($route))
            <?php $url = route($route); $uri = str_replace(env('APP_URL') . "/", '', $url); ?>
            <option value="{{$text}}" {{Request::is($uri) ? 'selected' : ''}} data-url="{{$url}}">
                {{$text}}
            </option>
        @endif
    @endforeach
</select>