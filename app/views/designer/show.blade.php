@extends('layouts.default')
@section('content')
<h2>Designer Fact Sheet &middot; {{ $designer->first_name }} {{ $designer->last_name }}</h2>
<div class="container" id='content_panel'>
   <div class="row-fluid">
      <div class="span12">
         <div>
            <div class="span7">
               <div>
                  <h3>{{ $designer->first_name }} {{ $designer->last_name }}</h3>
                  <h4>{{ $designer->company_name }}</h4>
                  <br />
                  <table class="table table-striped">
                     <tbody>
                        <tr>
                           <td>Address</td>
                           <td>
                              <address>
                                 {{ $designer->address1}}<br />
                                 {{ $designer->address2}}<br />
                                 {{ $designer->city }}<br />
                                 {{ $designer->state }}<br />
                                 {{ $designer->country }}<br />
                                 {{ $designer->zip }}<br />
                              </address>
                           </td>
                        </tr>
                        <tr>
                           <td>Email</td>
                           <td><a href="mailto:{{$designer->email_address}}">{{$designer->email_address}}</a></td>
                        </tr>
                        <tr>
                           <td>Web links</td>
                           <td>
                              @if (isset($designer->url1))<a target="_blank" href="{{ $designer->url1 }}">{{$designer->url1}}</a>@endif
                              @if (isset($designer->url2))<br /><a target="_blank" href="{{ $designer->url2 }}">{{$designer->url2}}</a>@endif
                           </td>
                        </tr>
                        <tr>
                           <td>Phone</td>
                           <td>
                              @if (isset($designer->phone1)){{ $designer->phone1 }}@endif
                              @if (isset($designer->phone2))<br />{{ $designer->phone2 }}@endif
                           </td>
                        </tr>
                        <tr>
                           <td>Notes</td>
                           <td>
                              {{$designer->notes}}
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
            <div class="span5">
               <div id="designers_boats" class="well">
                  <h3 class="modal-header">Boats</h3>
                  <ul class="nav nav-list">
                     @foreach ($designer->boats as $boat)
                     <li>
                        <a class='open-modal' data-type='boat' data-id='{{ $boat->id }}' title="{{ $boat->name }} - {{ $boat->short_description }}">
                           @if (isset($boat->thumbnail_pic->value))                                                
                           <img width="50" height="50" src="{{$boat->thumbnail_pic->value}}" style="float:left;margin-right: 10px;">
                           @endif
                           <p class="list-item">{{$boat->name}}</p>
                           <br />
                        </a>
                     </li>
                     @endforeach
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@if (Auth::check())				
@if (Auth::user()->id == $designer->user_id)
<div class="row-fluid well">
   <div class="span3">
      <i class="icon-wrench"></i> Edit
   </div>
   <div class="span3">
      <a class='open-modal' data-id='delete/{{$designer->id}}' data-type='designer'><i class="icon-remove"></i> Delete</a>
   </div>
</div>
@endif
@endif
<div class="well">
   <h6>Created {{ $designer->created_at }} &middot; Last updated {{ $designer->updated_at }}</h6>
</div>
<ul class="breadcrumb">
   <li><a href="/">Home</a> <span class="divider">/</span></li>
   <li><a href="/designer">Designers</a> <span class="divider">/</span></li>
   <li class="active">{{ $designer->first_name }} {{ $designer->last_name }} Details</li>
</ul>
@stop