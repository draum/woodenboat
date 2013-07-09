<div class="modal-header">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
   <h4>Add New Designer</h4>
</div>
<div class="modal-body">
   <form class="container-fluid" id="add-designer-form" data-async data-target="#add_designer_modal" action="/designer/add" data-remote="true" method="post">
      <div class="control-group">
         <div class="controls controls-row row-fluid">                 
            <input id="first_name" class='span5 input-xlarge' name="first_name" type="text" placeholder="First Name"/>
            <input id="last_name" class='span5 input-xlarge' name="last_name" type="text" placeholder="Last Name"/>                        
         </div>
         <div class="controls controls-row row-fluid">                 
            <input id="company_name" class='span5 input-xlarge' name="company_name" type="text" placeholder="Company Name"/>
            <input id="email_address" class='span5 input-xlarge' name="email_address" type="email" placeholder="Email Address"/>                        
         </div>
         <label class="control-label"><strong>Address</strong></label>
         <div class="controls controls-row row-fluid">                             
            <input id="address1" class='span5 input-xlarge' name="address1" type="text" placeholder="Address 1"/>
            <input id="address2" class='span5 input-xlarge' name="address2" type="text" placeholder="Address 2"/>                        
         </div>
         <div class="controls controls-row row-fluid">                 
            <input id="city" class='span3 input-xlarge' name="city" type="text" placeholder="City"/>
            <input id="state" class='span3 input-xlarge' name="state" type="text" placeholder="State"/>
            <input id="zip" class='span2 input-xlarge' name="zip" type="text" placeholder="Postal Code"/>
            <input id="country" class='span2 input-xlarge' name="country" type="text" placeholder="Country"/>                        
         </div>
         <div class="controls controls-row row-fluid">                            
            <input id="phone1" class='span5 input-xlarge' name="phone1" type="text" placeholder="Phone 1"/>
            <input id="phone2" class='span5 input-xlarge' name="phone2" type="text" placeholder="Phone 2"/>                        
         </div>
         <div class="controls controls-row row-fluid">                 
            <input id="url1" class='span5 input-xlarge' name="url1" type="text" placeholder="Website URL 1"/>
            <input id="url2" class='span5 input-xlarge' name="url2" type="text" placeholder="Website URL 2"/>                        
         </div>
         <div class="controls controls-row row-fluid">
            <label class="control-label"><strong>Notes</strong></label>
            <textarea class='input-xlarge span12' rows=4 id="notes" placeholder='Notes' name="notes"></textarea>
         </div>
      </div>
</div>
<div class="modal-footer">    
<button class="btn" data-dismiss="modal">Cancel</button>
<button type="submit" class="btn btn-primary">Save</button>
</div>
<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
</form>
<script>
   $(document).ready(function() {
       $('#add-designer-form').validate({
           errorClass : 'error',
           validClass : 'success',
           errorElement : 'span',
           showErrors : function(errorMap, errorList) {
               $.each(this.successList, function(index, value) {
                   return $(value).popover("hide");
               });
               return $.each(errorList, function(index, value) {
                   var _popover;
                   _popover = $(value.element).popover({
                       trigger : "manual",
                       placement : "top",
                       content : value.message,
                       template : "<div class=\"popover\" style='z-index: 99;'><div class=\"arrow\"></div><div class=\"popover-inner\"><div class=\"popover-content\"><p></p></div></div></div>"
                   });
                   _popover.data("popover").options.content = value.message;
                   return $(value.element).popover("show");
               });
           },
   
           highlight : function(element, errorClass, validClass) {
               $(element).parents("div[class='clearfix']").addClass(errorClass).removeClass(validClass);
           },
           unhighlight : function(element, errorClass, validClass) {
               $(element).parents(".error").removeClass(errorClass).addClass(validClass);
           },
   
           rules : {
               first_name : {
                   required : true
               },
               last_name : {
                   required : true
               },
           }
       });
   });
</script>