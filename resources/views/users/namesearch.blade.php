@foreach($users as $data)
<tr>
<td>{{$data->fullname}}</td>
<td>{{$data->email}}</td>
<td>{{$data->phone}}</td>
<td>{{$data->address}}</td>
<td>{{$data->city}}</td>
<td>{{$data->state}}</td>
<td><a href="{{url("user/$data->id")}}" class="btn btn-info btn-sm">View</a></td>
<td>
 <form method="post" action="{{url("/suspenduser")}}">
     @csrf
  <input type="hidden" name="user_id" value="{{$data->id}}"  />
  <input type="submit" name="suspend_user_btn" class="btn btn-sm btn-danger" onclick="return confirm('are you sure you want to suspend agent')" value="Suspend Agent" />
 </form></td>
</tr>
@endforeach