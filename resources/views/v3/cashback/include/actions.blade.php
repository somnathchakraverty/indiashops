<ul class="nav nav-pills mb-5" id="pills-tab" role="tablist">
    @if(userHasAccess('cashback.earnings'))
        <li class="nav-item">
            <a class="nav-link {{Request::is('cashback/earnings') ? 'active' : ''}}" id="cashback-tab" href="{{route('cashback.earnings')}}" role="tab">
                <i class="fa fa-money mr-2"></i> Cashback Earnings
            </a>
        </li>
    @endif
    @if(userHasAccess('cashback.withdraw'))
        <li class="nav-item">
            <a class="nav-link {{Request::is('cashback/withdraw') ? 'active' : ''}}" id="withdraw-tab" href="{{route('cashback.withdraw')}}" role="tab">
                <i class="fa fa-credit-card-alt"></i> Withdraw
            </a>
        </li>
    @endif
    @if(userHasAccess('cashback.missing'))
        <li class="nav-item">
            <a class="nav-link {{Request::is('cashback/missing-cashback') ? 'active' : ''}}" id="missing-cb-tab" href="{{route('cashback.missing')}}" role="tab">
                <i class="fa fa-info-circle"></i> Missing Cashback
            </a>
        </li>
    @endif
    @if(userHasAccess('cashback.missing.claim'))
        <li class="nav-item">
            <a class="nav-link {{ ( Request::is('cashback/missing-claim') || Request::is('cashback/claim*') ) ? 'active' : ''}}" id="missing-cb-claim-tab" href="{{route('cashback.missing.claim')}}" role="tab">
                <i class="fa fa-list-alt"></i> Missing Cashback Claim
            </a>
        </li>
    @endif
    @if(userHasAccess('cashback.settings'))
        <li class="nav-item">
            <a class="nav-link {{Request::is('cashback/profile-settings') ? 'active' : ''}}" id="profile-setting-tab" href="{{route('cashback.settings')}}" role="tab">
                <i class="fa fa-expeditedssl"></i> Profile Setting
            </a>
        </li>
    @endif
    @if(userHasAccess('cashback.users'))
        <li class="nav-item">
            <a class="nav-link {{Request::is('cashback/users') ? 'active' : ''}}" id="profile-setting-tab" href="{{route('cashback.users')}}" role="tab">
                <i class="fa fa-users"></i> Manage Users
            </a>
        </li>
    @endif

    @if(userHasAccess('cashback.purchase.orders'))
        <li class="nav-item">
            <a class="nav-link {{Request::is('purchase-orders') ? 'active' : ''}}" id="profile-setting-tab" href="{{route('cashback.purchase.orders')}}" role="tab">
                <i class="fa fa-shopping-cart"></i> Purchase Orders
            </a>
        </li>
    @endif
</ul>