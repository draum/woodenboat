@extends('layouts.default')
@section('content')
<div class="container span12">
   <div class="row-fluid">
      <div class="span8">
         <h2>Boat Fact Sheet &middot; {{ $boat->name }} </h2>
         <h3>{{ $boat->short_description }}</h3>
      </div>
      <div class="pull-right span3">
         <a data-id="{{ $boat->id }}" data-type="boat" class="boat-photo open-modal" title="{{ $boat->name }} - {{ $boat->short_description }}">
         @if (isset($boat->thumbnail_pic->value))
         <img src="{{$boat->thumbnail_pic->value}}" alt="{{ $boat->name }} - {{ $boat->short_description }}" border="0" width="120" height="80">
         @else            
         @endif
         @if (count($boat->photos) > 0)
         <a data-id="{{ $boat->id }}" data-type="photo" class="open-modal" title="{{ $boat->name }} - {{ $boat->short_description }}">
         <em>Photo Gallery</em>
         </a>
         @endif
         </a>
      </div>
   </div>
</div>
<div class="container-fluid">
   <div class="row-fluid well">
      <div class="row-fluid">
         <div class="span2"><strong>Designer:</strong></div>
         <div class="span6">
            <a class='open-modal' data-type='designer' data-id='{{ $boat->designer_id }}'>{{ $boat->designer_first_name }} {{ $boat->designer_last_name }}</a>
            @if (isset($boat->designer_company) && $boat->designer_company != null)&nbsp;({{ $boat->designer_company }})@endif
            
         </div>
      </div>
      <div class="row-fluid">
         <div class="span2"><strong>Plans Cost</strong></div>
         <div class="span2">
            @if (isset($boat->plans_cost->value))
            {{ $boat->plans_cost->value }} {{ $boat->plans_cost->unit}}
            @else
            N/A
            @endif
         </div>
         <div class="span1"></div>
         <div class="span2"><strong>Study Plans</strong></div>
         <div class="span2">
            @if (isset($boat->study_plans->value))
            {{ $boat->study_plans->value }} {{ $boat->study_plans->unit}}
            @else
            N/A
            @endif
         </div>
      </div>
   </div>
   <div class="row-fluid well">
      <div class="row-fluid">
         <div class="span2"><strong>LOA</strong></div>
         <div class="span2">
            @if (isset($boat->LOA->value))
            <?= $uc->start()->from($boat->LOA->unit)->value($boat->LOA->value)->convert(); ?>  <?= $uc->getResultUnit(); ?>
            @else
            N/A
            @endif
         </div>
         <div class="span1"></div>
         <div class="span2"><strong>Beam</strong></div>
         <div class="span2">
            @if (isset($boat->beam->value))
            <?= $uc->start()->from($boat->beam->unit)->value($boat->beam->value)->convert(); ?>  <?= $uc->getResultUnit(); ?>
            @else
            N/A
            @endif
         </div>
      </div>
      <div class="row-fluid">
         <div class="span2"><strong>Dry Weight</strong></div>
         <div class="span2">
            @if (isset($boat->dry_weight->value))        
            <?= $uc->start()->from($boat->dry_weight->unit)->value($boat->dry_weight->value)->convert(); ?>  <?= $uc->getResultUnit(); ?>
            @else
            N/A
            @endif
         </div>
         <div class="span1"></div>
         <div class="span2"><strong>Sail Area</strong></div>
         <div class="span2">
            @if (isset($boat->sail_area->value))
            <?= $uc->start()->from($boat->sail_area->unit)->value($boat->sail_area->value)->convert(); ?>  <?= $uc->getResultUnit(); ?>
            @else
            N/A
            @endif
         </div>
      </div>
   </div>
   @if (isset($boat->construction_types))
   <div class="well">
      <b>Construction Methods</b>
      <ul>
         @foreach ($boat->construction_types as $ctype)
         <li><?= ucfirst($ctype->name); ?></li>
         @endforeach
      </ul>
   </div>
   @endif
   @if (isset($boat->url1->value))
   <div class="row-fluid well">
      <span class="boat-link"><a target="_blank" href="{{ $boat->url1->value }}">Designer's Website Link</a></span>
   </div>
   @endif
   @if (isset($boat->url2->value))
   <div class="row-fluid well">
      <span class="boat-link"><a target="_blank" href="{{ $boat->url2->value }}">Other Link</a></span>
   </div>
   @endif
   @if (isset($boat->long_description) && $boat->long_description != '')
   <div class="well">{{ $boat->long_description }}</div>
   @endif
   @if (Sentry::check())
   @if (Sentry::getUser()->id == $boat->user_id)
   <div class="row-fluid well">
      <div class="span3">
			<a class='open-modal' data-id='edit/{{$boat->id}}' data-type='boat'><i class="icon-wrench"></i> Edit</a>
		</div>
      <div class="span3">
         <a class='open-modal' data-id='delete/{{$boat->id}}' data-type='boat'><i class="icon-remove"></i> Delete</a>
      </div>
   </div>
   @endif
   @endif
   <div class="well">
      <h6>Created {{ $boat->created_at }} &middot; Last updated {{ $boat->updated_at }}</h6>
   </div>
</div>
<ul class="breadcrumb">
   <li><a href="/">Home</a> <span class="divider">/</span></li>
   <li><a href="/boat">Boats</a> <span class="divider">/</span></li>
   <li class="active">{{ $boat->name }} Details</li>
</ul>
@stop
