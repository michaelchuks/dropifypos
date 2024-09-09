
<form method="post" action="{{url("/initiateflutterwavetransfer")}}">
    @csrf
<label>Select Bank</label>
<select name="bank_code">
    @foreach($banks as $bank)
<option value="{{$bank->code}}">{{$bank->bank}}</option>
    @endforeach
</select>
<br />

<label>Account Number</label>
<input type="phone" name="account_number" required />
<br />


<label>Amount</label>
<input type="number" name="amount" required />
<br />


<label>Naration</label>
<input type="text" name="narration" />

<br />

<input type="submit" value="Continue" />
</form>