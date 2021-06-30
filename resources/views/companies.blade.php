<html>
 <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
  <title>Manage Company Data</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
 </head>
 <body>
  <div class="container">
     <br />
     <h3 align="center">Manage Company Data</h3>
     <br />

        <form action="{{route('companies_data.export')}}" method="GET" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <button type="submit" class="btn btn-sm btn-primary">Download Sample</button>
        </div>
        </form>

        <form action="{{route('companies_data.import_store')}}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <input type="file" name="file" />

                <button type="submit" class="btn btn-sm btn-primary">Import</button>
            </div>
       </form>

     <div align="right">
      <button type="button" name="create_record" id="create_record" class="btn btn-sm btn-success btn-sm">Create Record</button>
     </div>
     <br />
   <div class="table-responsive">
    <table class="table table-bordered table-striped" id="company_table">
           <thead>
            <tr>
                <th>Logo</th>
                <th>Company Name</th>
                <th>Email</th>
                <th>Website</th>
                <th>Status</th>
                <th>Total Employees</th>
                <th>Action</th>
            </tr>
           </thead>
       </table>
   </div>
   <br />
   <br />
  </div>



  <!--add/update records-->
  <div id="formModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
     <div class="modal-content">
      <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal">&times;</button>
             <h4 class="modal-title">Add New Record</h4>
           </div>
           <div class="modal-body">
            <span id="form_result"></span>
            <form method="post" id="company_form" class="form-horizontal" enctype="multipart/form-data">
             @csrf
             <div class="form-group">
               <label class="control-label col-md-4" >Company Name : </label>
               <div class="col-md-8">
                <input type="text" name="company_name" id="company_name" class="form-control" />
               </div>
              </div>

              <div class="form-group">
               <label class="control-label col-md-4">Company Email : </label>
               <div class="col-md-8">
                <input type="email" name="company_email" id="company_email" class="form-control" />
               </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-4" >Company Website : </label>
                <div class="col-md-8">
                 <input type="text" name="company_website" id="company_website" class="form-control" />
                </div>
               </div>
               <div class="form-group">
                <label class="control-label col-md-4" >Company Status : </label>
                <div class="col-md-8">
                    <input type="radio" id="activeStatus" name="active_status" value=1>Active
                    <input type="radio" id="inActiveStatus" name="active_status" value=0 >Inactive
                </div>
               </div>



              <div class="form-group">
               <label class="control-label col-md-4">Logo : </label>
               <div class="col-md-8">
                <input type="file" name="company_logo" id="company_logo" />
                <span id="store_image"></span>
               </div>
              </div>

              <br />
              <div class="form-group" align="center">
               <input type="hidden" name="action" id="action" />
               <input type="hidden" name="hidden_id" id="hidden_id" />
               <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add" />
              </div>
            </form>
           </div>
        </div>
       </div>
   </div>
 <!--end add/update records-->


 <div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Confirmation</h2>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
            </div>
            <div class="modal-footer">
             <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


 </body>



</html>

<script>
    $(document).ready(function(){

        $('#company_table').DataTable({
  processing: true,
  serverSide: true,
  ajax:{
   url: "{{ route('companies.index') }}",
   method:"GET",
  },
  columns:[
   {
    data: 'company_logo',
    name: 'company_logo',
    render: function(data, type, full, meta){
     return "<img src={{ URL::to('/') }}/images/" + data + " width='100' class='img-thumbnail' />";
    },
    orderable: false
   },
   {
    data: 'company_name',
    name: 'company_name'
   },
   {
    data: 'company_email',
    name: 'company_email'
   },
   {
    data: 'company_website',
    name: 'company_website'
   },
   {
    data: 'active_status',
    name: 'active_status'
   },
   {
    data: 'employees_count',
    name: 'employees_count'
   },
   {
    data: 'action',
    name: 'action',
    orderable: false
   }
  ]
 });


 $('#create_record').click(function(){
    $('.modal-title').text("Add New Record");
     $('#action_button').val("Add");
     $('#action').val("Add");
     $('#formModal').modal('show');
 });



 $('#company_form').on('submit', function(event){
  event.preventDefault();

  if($('#action').val() == 'Add')
  {
   $.ajax({
    url:"{{ route('companies.store') }}",
    method:"POST",
    data: new FormData(this),
    contentType: false,
    cache:false,
    processData: false,
    dataType:"json",
    success:function(data)
    {
     var html = '';
     if(data.errors)
     {
      html = '<div class="alert alert-danger">';
      for(var count = 0; count < data.errors.length; count++)
      {
       html += '<p>' + data.errors[count] + '</p>';
      }
      html += '</div>';
     }
     if(data.success)
     {
      html = '<div class="alert alert-success">' + data.success + '</div>';
      $('#company_form')[0].reset();
      $('#company_table').DataTable().ajax.reload();
     }
     $('#form_result').html(html);
    }
   })
  }







if($('#action').val() == "Edit")
  {

   $.ajax({
    // headers: {
    //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    // },
    url:"{{ route('companies.update_data') }}",
    method:"POST",
    data:new FormData(this),
    contentType: false,
    cache: false,
    processData: false,
    dataType:"json",
    success:function(data)
    {
     var html = '';
     if(data.errors)
     {
      html = '<div class="alert alert-danger">';
      for(var count = 0; count < data.errors.length; count++)
      {
       html += '<p>' + data.errors[count] + '</p>';
      }
      html += '</div>';
     }
     if(data.success)
     {
      html = '<div class="alert alert-success">' + data.success + '</div>';
      $('#company_form')[0].reset();
      $('#store_image').html('');
      $('#company_table').DataTable().ajax.reload();
     }
     $('#form_result').html(html);
    }
   });
  }


});


$(document).on('click', '.edit', function(){
  var id = $(this).attr('id');
  $('#form_result').html('');
  $.ajax({
   url:"/companies/"+id+"/edit",
   dataType:"json",
   success:function(html){
    $('#company_name').val(html.data.company_name);
    $('#company_email').val(html.data.company_email);
    $('#company_website').val(html.data.company_website);

    if(html.data.active_status == 1){
        $('#activeStatus').prop('checked', true);
        $('#inActiveStatus').prop('checked', false);
    }else{
        $('#inActiveStatus').prop('checked', true);
        $('#activeStatus').prop('checked', false);
    }

    $('#store_image').html("<img src={{ URL::to('/') }}/images/" + html.data.company_logo + " width='100' class='img-thumbnail' />");
    $('#store_image').append("<input type='hidden' name='hidden_image' value='"+html.data.company_logo+"' />");
    $('#hidden_id').val(html.data.id);
    $('.modal-title').text("Edit New Record");
    $('#action_button').val("Edit");
    $('#action').val("Edit");
    $('#formModal').modal('show');
   }
  })
 });




 var companyId;

$(document).on('click', '.delete', function(){
    companyId = $(this).attr('id');
 $('#confirmModal').modal('show');
});

$('#ok_button').click(function(){
 $.ajax({
  url:"companies/destroy_data/"+companyId,
  beforeSend:function(){
   $('#ok_button').text('Deleting...');
  },
  success:function(data)
  {
   setTimeout(function(){
    $('#confirmModal').modal('hide');
    $('#company_table').DataTable().ajax.reload();
   }, 2000);
  }
 })
});


    })
</script>
