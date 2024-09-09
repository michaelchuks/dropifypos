<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr><th>Username</th><th>Amount(N)</th><th>Recipiant Name</th><th>Bank</th><th>Account No</th><th>Reference</th><th>Dtae</th><th></th></tr>
    </thead>
    <tbody>
        @foreach($transfers as $transfer)
        <tr><td>{{ucwords($transfer->username)}}</td>
        <td>{{$transfer->amount}}</td>
        <td>{{$transfer->recipiant_name}}</td>
        <td>{{$transfer->recipiant_bank}}</td>
        <td>{{$transfer->recipiant_account_number}}</td>
        <td>{{$transfer->reference_id}}</td>
        <td>{{$transfer->created_at}}</td>
        <td>
            <form method="post" action="{{url("/admin/deletetransfer")}}">
                @csrf
                <input type="hidden" name="transfer_id" value="{{$transfer->id}}" />
                <button method="submit" class="btn btn-sm btn-danger" name="delete_transfer_btn"><span class="fa fa-trash"></span> Delete</button>
            </form>
        </td>

        </tr>
        
        
    
    @endforeach
    </tbody>
    </table>