@extends('v3.mobile.layout.cashback')
@section('cashback_section')
    <style type="text/css">
        .hmb-5 { font-size: 24px; padding: 15px 0px; text-align: center; display: block; }
        .btn-outline-primary { color: #fff !important; background: #ff3131 !important; margin: 10px 15px 0px 0px !important; }
        .bgcolor { background: #eaeaea; border-radius: 10px; margin-top: 30px; padding: 0 10px 20px }
    </style>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane active" id="missing-cb-claim-tabpan" role="tabpanel">
            <section class="m-cb-claims">
                <h2 class="hmb-5">Users</h2>
                <div class="table-responsive text-center">
                    <table class="table">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($users->count() > 0)
                            @foreach($users as $u)
                                <tr class="border-bottom">
                                    <td>{{$u->name}}</td>
                                    <td>{{$u->email}}</td>
                                    <td>{{$u->gender}}</td>
                                    <td>{{$u->mobile}}</td>
                                    <td>{{($u->active == 1) ? 'Active' : 'Inactive'}}</td>
                                    <td>
                                        <a class="btn btn-outline-primary" href="{{route('cashback.users',[$u->id])}}" title="View">
                                            Edit
                                        </a>
                                        <a class="btn btn-outline-primary" href="{{route('cashback.users',[$u->id])}}?delete" title="Delete" onclick="return confirm('Are you sure.?')">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6">No User(s)</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation example">
                        {!! $users->render() !!}
                    </nav>
                </div>
                @if(userHasAccess('cashback.users.create'))
                    <a href="{{route('cashback.users.create')}}" class="btn-outline-primary btn">Create New User</a>
                @endif
            </section>
        </div>
    </div>
@endsection
@section('section_scripts')
    <script>
        function loadRestJS() {

        }
    </script>
@endsection