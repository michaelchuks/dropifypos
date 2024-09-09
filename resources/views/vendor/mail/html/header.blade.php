@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{asset("logo.jpg")}}" class="logo" alt="Dropifypay Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
