@extends('layouts.default')
@section('content')
<div class="row-fluid">
   <div class="span6">
      <h3>Welcome to the Wooden Boat database!</h3>
   </div>
   <div class="span4">
      <h4>A collection of small wooden watercraft that can be built from plans, kits, etc.</h4>
   </div>
</div>
@if (isset($searchQuery))
<div class="well">
   <h4>{{ $searchCount}} Search Results for: {{ $searchQuery }}</h4>   
</div>
@endif 
<div class="row-fluid">
   @if (count($boats) > 0)
   <div class="boat-group">                  
      @foreach ($boats as $boat)
      <?php if (!is_object($boat)) { continue; } ?>
      <div class="boat-listing" id="{{ $boat->id }}">
         <div class="boat-wrap">
            <a data-id="{{ $boat->id }}" data-type="boat" class="boat-photo open-modal" title="{{ $boat->name }} - {{ $boat->short_description }}">
            @if (isset($boat->thumbnail_pic))
            <img src="{{$boat->thumbnail_pic->value}}" alt="{{ $boat->name }} - {{ $boat->short_description }}" border="0" width="120" height="80">
            @else
            @endif
            @if (count($boat->photos) > 0)
            <a data-id="{{ $boat->id }}" data-type="photo" class="open-modal" title="{{ $boat->name }} - {{ $boat->short_description }}">
            <em>Photo Gallery</em>
            </a>
            @endif
            </a>
            <ul class="boat-summary">
               <li class="boat-header ellipsis">
                  <a class='open-modal' data-type='boat' data-id='{{ $boat->id }}' title="{{ $boat->name }} - {{ $boat->short_description }}">						
                  <b><span class="ellipsis">{{ $boat->name }} - {{ $boat->short_description }}</span></b>
                  </a>                                                                                                                                   								
               </li>
               <li class="boat-meta">            
                  <span class="boat-type"><?php echo ucfirst($boat->boat_type); ?></span>
                  <span class="boat-length"><strong>Length (LOA)</strong>:
                  @if (isset($boat->LOA->value))                    
                  <?php echo $uc->start()->from($boat->LOA->unit)->value($boat->LOA->value)->convert(); ?>  <?php echo $uc->getResultUnit(); ?>
                  @else
                  N/A
                  @endif
                  </span>                    
                  <span class="boat-beam">                    
                  <strong>Beam</strong>: 
                  @if (isset($boat->beam->value))                             
                  <?php echo $uc->start()->from($boat->beam->unit)->value($boat->beam->value)->convert(); ?>  <?php echo $uc->getResultUnit(); ?>
                  @else
                  N/A
                  @endif
                  </span>
                  <span class="boat-weight">                    
                  <strong>Weight</strong>: 
                  @if (isset($boat->dry_weight->value))                  
                  <?php echo $uc->start()->from($boat->dry_weight->unit)->value($boat->dry_weight->value)->convert(); ?>  <?php echo $uc->getResultUnit(); ?>
                  @else
                  N/A
                  @endif
                  </span>
                  <span class="boat-sailarea">
                  <strong>Sail area</strong>:
                  @if (isset($boat->sail_area->value))
                  <?php echo $uc->start()->from($boat->sail_area->unit)->value($boat->sail_area->value)->convert(); ?>  <?php echo $uc->getResultUnit(); ?>
                  @else
                  N/A
                  @endif
                  </span>
                  <br />
                  @if (isset($boat->url1))
                  <span class="boat-link"><a target="_blank" href="{{ $boat->url1->value }}">Designer's Site Link</a></span>
                  @endif
                  <span class="boat-link">
                  <a href="/boat/{{ $boat->id }}">Details</a>
                  </span>
               </li>
               <li class="boat-meta ellipsis">                
                  @if (is_array($boat->construction_types))
                  <span class="boat-construction">
                  <strong>Construction options:</strong>
                  @foreach ($boat->construction_types as $ctype)
                  <?php echo ucfirst($ctype->name); ?>&nbsp;&middot;&nbsp;  
                  @endforeach
                  </span><br />
                  @endif     
                  <span class="boat-designed-by">
                  <a class='open-modal' data-type='designer' data-id='{{ $boat->designer_id }}'><span class="boat-city">Designed by {{ $boat->designer_name }}</span></a>
                  </span> 					
               </li>
               <li class="boat-meta boat-actions">
                  @if (Auth::check())				
                  @if (Auth::user()->id == $boat->user_id)
                  <div class="row-fluid">
                     <div class="span3">
                        <i class="icon-wrench"></i> Edit
                     </div>
                     <div class="span3">
                        <a class='open-modal' data-id='delete/{{$boat->id}}' data-type='boat'>
                           <i class="icon-remove"></i> Delete</a>
                     </div>
                  </div>
                  @endif
                  @endif
               </li>
            </ul>
         </div>
      </div>
      @endforeach
   </div>
   @endif
   
      
   @if ($boats['totalpages'] > 1)
   <div class="container">
    <form id="pagination_form" method="post" action="/boat/search">
    @if (isset($searchQuery))   
        <input type="hidden" name="searchTerm" value="{{ $searchQuery }}" id="searchTerm">
    @endif
        <input type="hidden" name="page" value="{{ $boats['currentpage']}}" id="page">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <div class="pagination">
        <ul>@for ($i=1;$i < $boats['totalpages']+1;$i++)                               
            @if ($i == $boats['currentpage'])
            <li class="active">
            @else
            <li>
            @endif
                <a class="paginate_link" data-index="{{$i}}">{{$i}}</a>
            </li>
            @endfor   
        </ul>
        </div>
    </form>   
   </div>   
   @endif
   
   @if (Auth::check())
   <div class="well">   
   <a class='open-modal' data-id="add" data-type="boat"><i class="icon-plus"></i> Add New Boat</a> &nbsp;&nbsp;&nbsp;
   <a class='open-modal' data-id='add' data-type='designer'><i class="icon-plus"></i>  Add New Designer</a>
   </div>
   @endif
   
   
   
      
</div>
<ul class="breadcrumb">
   <li><a href="/">Home</a> <span class="divider">/</span></li>
   <li><a href="/boat">Boats</a> <span class="divider">/</span></li>
   <li class="active">List</li>
</ul>
@stop