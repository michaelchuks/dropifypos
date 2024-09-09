<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr><th>Username</th><th>Amount</th><th>Reference Id</th><th>Date</th><th></th></tr>
    </thead>
    <tbody>
        @foreach($deposits as $deposit)
        <tr><td>{{ucwords($deposit->user->username)}}</td>
        <td>{{$deposit->amount}}</td>
        <td>{{$deposit->reference_id}}</td>
        <td>{{$deposit->created_at}}</td>

        <td>
            <form method="post" action="{{url("/admin/deletedeposit")}}">
                @csrf
                <input type="hidden" name="deposit_id" value="{{$deposit->id}}" />
                <button method="submit" class="btn btn-sm btn-danger" name="delete_deposit_btn"><span class="fa fa-trash"></span> Delete</button>
            </form>
        </td>
        </tr>
        
        
    
    @endforeach
    </tbody>
    </table>