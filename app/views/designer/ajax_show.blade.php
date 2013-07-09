<div class="modal-header">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
   <h4>{{ $designer->first_name }} {{ $designer->last_name }}</h4>
</div>
<div class="modal-body">
   <div class="designer_factsheet container-fluid" id='content_panel'>
      <div class="row-fluid">
         <div class="span12">
            <table class="table table-striped">
               <tr>
                  <td>Company</td>
                  <td>{{ $designer->company_name }}</td>
               </tr>
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
            </table>
         </div>
      </div>
   </div>
</div>
<div class="modal-footer">
   <a class="btn btn-primary" href="/designer/{{$designer->id}}">Details</a>
</div>