<div class="modal-header">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
   <h4>Add New Boat</h4>
</div>
<div class="modal-body">
   <form class="container-fluid" id="add-boat-form" data-async data-target="#add_boat_modal" action="/boat/add" data-remote="true" method="post">
      <div class="control-group">
         <div class="controls controls-row row-fluid">                 
            <input id="name" class='span5 input-xlarge' name="name" type="text" placeholder="Boat Name"/>                        
            <input id="short_description" class='span5 input-xlarge' name="short_description" type="text" placeholder="A short description of the boat">    
         </div>
      </div>
      <div class="control-group">
         <div class="controls controls-row row-fluid">
            <select id="boat_type" placeholder='Watercraft Type' class='span5 input-xlarge' name="boat_type">
               <option value="-">Select craft type...</option>
               @foreach ($boat_types as $boat_type)
               <option value="{{$boat_type->id}}"><?= ucfirst($boat_type->name); ?></option>
               @endforeach
            </select>
            <select id="designer" class='span5 input-xlarge' name="designer">
               <option value="-">Select designer...</option>
               @foreach ($designers as $designer)
               <option value="{{$designer->id}}">{{$designer->first_name}} {{$designer->last_name}}</option>
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
                     <option value="{{ $ctype->id }}">{{ $ctype->name }}</option>
                     @endforeach    
                  </select>
               </div>
            </div>
            <div class="span5">
               <label class="control-label"><strong>Long Description</strong></label>
               <div class="controls">                     
                  <textarea class='input-xlarge span12' rows=4 id="long_description" placeholder='Detailed Description' name="long_description"></textarea>
               </div>
            </div>
         </div>
      </div>
      <div class="control-group">
         <div class="controls controls-row row-fluid">
            <div class="controls">
               <input class='span3' id="loa_value" name="loa_value" type="text" placeholder="Length Overall (not LWL)">    
               <select class='span2' id="loa_unit" name="loa_unit">
                  <option>FT</option>
                  <option>M</option>
               </select>
               <input class='span3' id="beam_value" name="beam_value" type="text" placeholder="Beam/Width">    
               <select class='span2' id="beam_unit" name="beam_unit">
                  <option>FT</option>
                  <option>M</option>
               </select>
            </div>
         </div>
         <div class="controls controls-row row-fluid">
            <div class="controls">
               <input class='span3' id="dry_weight_value" name="dry_weight_value" type="text" placeholder="Weight (dry)">    
               <select class='span2' id="dry_weigth_unit" name="dry_weight_unit">
                  <option>LBS</option>
                  <option>KGS</option>
               </select>
               <input class='span3' id="sail_area_value" name="sail_area_value" type="text" placeholder="Sail Area">    
               <select class='span2' id="sail_area_unit" name="sail_area_unit">
                  <option>SQFT</option>
                  <option>SQM</option>
               </select>
            </div>
         </div>
      </div>
      <div class="control-group">
         <div class="controls controls-row row-fluid">
            <div class="controls">
               <input class='span7' id="thumbnail_pic" name="thumbnail_pic" type="text" placeholder="Thumbnail URL">
            </div>
         </div>
      </div>
      <div class="control-group">
         <div class="controls controls-row row-fluid">
            <div class="controls">
               <input class='span5' id="url1" name="url1" type="text" placeholder="Designer's Site Link">
               <input class='span5' id="url2" name="url2" type="text" placeholder="Alternate Link">
            </div>
         </div>
      </div>
</div>
<div class="modal-footer">    
<button class="btn" data-dismiss="modal">Cancel</button>
<button id='save_button' class="btn btn-primary">Save</button>
</div>
<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
</form>
<script>
	$(document).ready(function() {
		$('#add-boat-form').validate({
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