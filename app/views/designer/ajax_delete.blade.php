<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4>Delete {{ $designer->first_name }} {{ $designer->last_name }}</h4>
</div>

<div class="modal-body">
    Are you sure you want to delete this designer?<br />   
</div>
 
<div class="modal-footer">
   <form action="/designer/delete/{{$designer->id}}" method="POST">
   <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">    
   <button class="btn" data-dismiss="modal">Cancel</button>   
   <button type='submit' class="btn btn-danger">Confirm Delete</button>
   </form>
</div>
