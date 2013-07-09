<div class="modal-header">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
   <h4>{{ $boat->name }}: {{ $boat->short_description }}</h4>      
</div>
<div class="modal-body">    
   <div class="container-fluid" id='content_panel'> 
      <div class="row-fluid">
         <div class="span2"><strong>Designer:</strong></div>
         <div class="span8">
            <a href="/designer/{{ $boat->designer_id }}">
            {{ $boat->designer_name }}
            @if (isset($boat->designer_company) && $boat->designer_company != null)&nbsp;({{ $boat->designer_company }})@endif
            </a>
         </div>   
      </div>
<div class="row-fluid">
         <div class="span2"><strong>LOA</strong></div>
         <div class="span2">
            @if (isset($boat->LOA->value))
            <?= $uc->start()->from($boat->LOA->unit)->value($boat->LOA->value)->
               convert(); ?>  <?= $uc->
               getResultUnit(); ?>
            @else
            N/A
            @endif
         </div>
         <div class="span1"></div>
         <div class="span2"><strong>Beam</strong></div>
         <div class="span2">
            @if (isset($boat->beam->value))
            <?= $uc->start()->from($boat->beam->unit)->value($boat->beam->value)->
               convert(); ?>  <?= $uc->
               getResultUnit(); ?>
            @else
            N/A
            @endif
         </div>
      </div>
      <div class="row-fluid">
         <div class="span2"><strong>Dry Weight</strong></div>
         <div class="span2">
            @if (isset($boat->dry_weight->value))        
            <?= $uc->start()->from($boat->dry_weight->unit)->value($boat->
               dry_weight->value)->convert(); ?>  <?= $uc->
               getResultUnit(); ?>
            @else
            N/A
            @endif
         </div>
         <div class="span1"></div>
         <div class="span2"><strong>Sail Area</strong></div>
         <div class="span2">
            @if (isset($boat->sail_area->value))
            <?= $uc->start()->from($boat->sail_area->unit)->value($boat->
               sail_area->value)->convert(); ?>  <?= $uc->
               getResultUnit(); ?>
            @else
            N/A
            @endif
         </div>
      </div>      
      
   <div class="well row-fluid">
    @if (isset($boat->construction_types))
        <div class="span8">
        <b>Construction Methods</b>
        <ul>
         @foreach ($boat->construction_types as $ctype)
         <li><?= ucfirst($ctype->name); ?></li>
         @endforeach
        </ul>
        </div>
        @endif      
   </div>
   
      @if (isset($boat->url1))
      <br />
      <div class="row-fluid">
         <span class="boat-link"><a target="_blank" href="{{ $boat->url1->value }}">Designer's Website Link</a></span>
      </div>
      @endif
      @if (isset($boat->url2))
      <div class="row-fluid">
         <span class="boat-link"><a target="_blank" href="{{ $boat->url2->value }}">Other Link</a></span>
      </div>
      @endif
   </div>
</div>
<div class="modal-footer">
   <a class="btn btn-primary" href="/boat/{{$boat->id}}">Details</a>        
</div>