@extends('layouts.default')

@section('content')
<div class="row-fluid">
<table class='table table-striped'>
<tbody>
<tr>
<th>Designer</th>
<th>Email</th>
<th>Website</th>
<th>Phone</th>
<th>Created</th>
<th>Last Update</th>
</tr>
@if (count($designers) > 0)
@foreach ($designers as $designer)
<tr>
<td><a class="open-modal" data-type='designer' data-id="{{ $designer->id }}">{{ $designer->first_name }} {{ $designer->last_name }}<br />{{$designer->company_name}}</a></td>
<td><a href="mailto:{{$designer->email_address}}">{{$designer->email_address}}</a></td>
<td>@if (isset($designer->url1))<a target="_blank" href="{{ $designer->url1 }}">{{$designer->url1}}</a>@endif
                @if (isset($designer->url2))<br /><a target="_blank" href="{{ $designer->url2 }}">{{$designer->url2}}</a>@endif</td>
<td>@if (isset($designer->phone1)){{ $designer->phone1 }}@endif
                @if (isset($designer->phone2))<br />{{ $designer->phone2 }}@endif</td>
<td>{{ $designer->created_at }}</td>
<td>{{ $designer->updated_at }}</td>
</tr>
@endforeach
@else
<tr>
<td colspan="6">There are no designers in our database.  Sadface.</td>
</tr>
@endif
</tbody>
</table>
    @if (Auth::check())            
    <div class="well">   
   <a class='open-modal' data-id="add" data-type="boat"><i class="icon-plus"></i> Add New Boat</a> &nbsp;&nbsp;&nbsp;
   <a class='open-modal' data-id='add' data-type='designer'><i class="icon-plus"></i>  Add New Designer</a>
   </div>
   @endif
</div>

<ul class="breadcrumb">
  <li><a href="/">Home</a> <span class="divider">/</span></li>
  <li><a href="/designer">Designers</a> <span class="divider">/</span></li>
  <li class="active">List</li>
</ul>
@stop