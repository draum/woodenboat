<div class="modal-header">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
   <h4>Edit {{ $boat->name}}</h4>
</div>
<div class="modal-body">
   <form class="container-fluid" id="edit-boat-form" data-async data-target="#edit_boat_modal" action="/boat/edit/{{$boat->id}}" data-remote="true" method="post">
      <div class="control-group">
         <div class="controls controls-row row-fluid">                 
            <input id="name" class='span5 input-xlarge' name="name" type="text" value="{{$boat->name}}" placeholder="Boat Name"/>                        
            <input id="short_description" class='span5 input-xlarge' name="short_description" type="text" value="{{ $boat->short_description }}" placeholder="A short description of the boat">    
         </div>
      </div>
      <div class="control-group">
         <div class="controls controls-row row-fluid">
            <select id="boat_type" placeholder='Watercraft Type' class='span5 input-xlarge' name="boat_type">
               <option value="-">Select craft type...</option>
               @foreach ($boat_types as $boat_type)
               @if ($boat_type->id == $boat->type_id)
               <option selected value="{{$boat_type->id}}"><?= ucfirst($boat_type->name); ?></option>
               @else
               <option value="{{$boat_type->id}}"><?= ucfirst($boat_type->name); ?></option>
               @endif
               @endforeach
            </select>
            <select id="designer" class='span5 input-xlarge' name="designer">
               <option value="-">Select designer...</option>
               @foreach ($designers as $designer)
               @if ($designer->id == $boat->designer_id)
               <option selected value="{{$designer->id}}">{{$designer->first_name}} {{$designer->last_name}}</option>
               @else               
               <option value="{{$designer->id}}">{{$designer->first_name}} {{$designer->last_name}}</option>
               @endif
               @endforeach
               <option value="unknown">Unknown</option>
            </select>
            <a href="/designer"><i class="icon-plus"></i></a>
         </div>
      </div>
      <div class="control-group">
         <div class="controls controls-row row-fluid">
            <div class="span5">
               <label class="control-label"><strong>Construction Options</strong></label>
               <div class="controls">                   
                  <select id="construction_types" name="construction_types[]" class='input-xlarge' multiple="multiple">
                     @foreach ($construction_types as $ctype)
                     @if (in_array($ctype->id,array_keys($boat->friendly_construction_types)))                     
                     <option selected value="{{ $ctype->id }}">{{ $ctype->name }}</option>
                     @else
                     <option value="{{ $ctype->id }}">{{ $ctype->name }}</option>
                     @endif
                     @endforeach    
                  </select>
               </div>
            </div>
            <div class="span5">
               <label class="control-label"><strong>Long Description</strong></label>
               <div class="controls">                     
                  <textarea class='input-xlarge span12' rows=4 id="long_description" value="{{$boat->long_description}}" "placeholder='Detailed Description' name="long_description"></textarea>
               </div>
            </div>
         </div>
      </div>
      <div class="control-group">
         <div class="controls controls-row row-fluid">
            <div class="controls">
               <input class='span3' id="loa_value" name="loa_value" value="@if (isset($boat->LOA)){{$boat->LOA->value}} @endif" type="text" placeholder="Length Overall (not LWL)">    
               <select class='span2' id="loa_unit" name="loa_unit">
               <?php $ftS = null;
                $mS = null;
                if (isset($boat->LOA->unit)) {
                    if ($boat->LOA->unit == "FT")
                        $ftS = "selected";
                    if ($boat->LOA->unit == "M")
                        $mS = "selected";
                }
 ?>                
                  <option {{$ftS}} value="FT">FT</option>
                  <option {{$mS}} value="M">M</option>
               </select>
               <input class='span3' id="beam_value" name="beam_value" type="text" value="@if (isset($boat->beam)){{$boat->beam->value}} @endif" placeholder="Beam/Width">    
               <select class='span2' id="beam_unit" name="beam_unit" >
               <?php $ftS = null;
                $mS = null;
                if (isset($boat->beam->unit)) {
                    if ($boat->beam->unit == "FT")
                        $ftS = "selected";
                    if ($boat->beam->unit == "M")
                        $mS = "selected";
                }
 ?>
                  <option {{$ftS}} value="FT">FT</option>
                  <option {{$mS}} value="M">M</option>
               </select>
            </div>
         </div>
         <div class="controls controls-row row-fluid">
            <div class="controls">
               <input class='span3' id="dry_weight_value" name="dry_weight_value" value="@if (isset($boat->dry_weight)){{$boat->dry_weight->value}} @endif" type="text" placeholder="Weight (dry)">    
               <select class='span2' id="dry_weigth_unit" name="dry_weight_unit">
               <?php $kgS = null;
                $lbS = null;
                if (isset($boat->dry_weight->unit)) {
                    if ($boat->dry_weight->unit == "KGS")
                        $kgS = "selected";
                    if ($boat->dry_weight->unit == "LBS")
                        $lbS = "selected";
                }
 ?>
                  <option {{$kgS}}" value="LBS">LBS</option>
                  <option {{$mS}}" value="KGS">KGS</option>
               </select>
               <input class='span3' id="sail_area_value" name="sail_area_value" type="text" value="@if (isset($boat->sail_area->value)){{$boat->sail_area->value}} @endif" placeholder="Sail Area">    
               <select class='span2' id="sail_area_unit" name="sail_area_unit">
               <?php $ftS = null;
                $mS = null;
                if (isset($boat->sail_area->unit)) {
                    if ($boat->sail_area->unit == "FT")
                        $ftS = "selected";
                    if ($boat->sail_area->unit == "M")
                        $mS = "selected";
                }
 ?>
                  <option {{$ftS}} value="SQFT">SQFT</option>
                  <option {{$mS}} value="SQM">SQM</option>
               </select>
            </div>
         </div>
      </div>
      <div class="control-group">
         <div class="controls controls-row row-fluid">
            <div class="controls">
               <input class='span7' id="thumbnail_pic" name="thumbnail_pic" value="@if (isset($boat->thumbnail_pic)) {{$boat->thumbnail_pic->value}} @endif" type="text" placeholder="Thumbnail URL">
            </div>
         </div>
      </div>
      <div class="control-group">
         <div class="controls controls-row row-fluid">
            <div class="controls">
               <input class='span5' id="url1" name="url1" type="text" value="@if (isset($boat->url1)){{$boat->url1->value}}@endif" placeholder="Designer's Site Link">
               <input class='span5' id="url2" name="url2" type="text" value="@if (isset($boat->url2)){{$boat->url2->value}}@endif" placeholder="Alternate Link">
            </div>
         </div>
      </div>
</div>
<div class="modal-footer">    
<button type="submit" class="btn" data-dismiss="modal">Cancel</button>
<button type="submit" class="btn btn-primary">Save</button>
</div>
<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
</form>
<script>
	$(document).ready(function() {
		$('#edit-boat-form').validate({
			rules : {
				name : {
					minlength : 3,
					required : true
				},
				boat_type : {
					required : true,
					number : true,
					min : 0
				},
				designer : {
					required : true,
					number : true,
					min : 0
				},
				"construction_types[]" : {
					required : true
				}
			},
			highlight : function(element) {
				$(element).closest('.control-group').removeClass('success').addClass('error');
			},
			success : function(element) {
				element.addClass('valid').closest('.control-group').removeClass('error').addClass('success');
			},
			showErrors : function(errorMap, errorList) {
				$("." + this.settings.validClass).tooltip("destroy");
				for (var i = 0; i < errorList.length; i++) {
					var error = errorList[i];
					$("#" + error.element.id).tooltip({
						placement : "bottom",
						trigger : "focus"
					}).attr("data-original-title", error.message)
				}
			},
			messages : {
				"construction_types[]" : "Please select at least one construction type.",
				boat_type : "Please select a craft type",
				designer : "Please select a designer"
			},
		});
		$("#save_button").click(function(e) {
			e.preventDefault();
			$("#add-boat-form").submit();
		});
	});
</script>