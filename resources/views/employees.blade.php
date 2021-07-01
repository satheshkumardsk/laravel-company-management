<html>
 <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
  <title>Manage Employee Data</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
 </head>
 <body>


    <nav class="navbar navbar-default">
        <div class="container-fluid">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{route('home')}}">{{ config('app.name', 'Laravel') }}</a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <li><a href="{{route('employees.index')}}">Employees</a></li>
              <li><a href="{{route('companies.index')}}">Companies</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
              <li><a href="{{route('home')}}">Home</a></li>
              <li>  <a class="dropdown-item" href="{{ route('logout') }}"
              onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
               {{ __('Logout') }}
           </a></li>

           <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
               @csrf
           </form>
            </ul>

          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>


  <div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title text-center">Manage Employee Data</h3>
        </div>
      </div>


     <form action="{{route('employees_data.export')}}" method="GET" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <button type="submit" class="btn btn-sm btn-primary">Download Sample</button>
        </div>
        </form>

        <form action="{{route('employees_data.import_store')}}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <input type="file" name="file" />

                <button type="submit" class="btn btn-sm btn-primary">Import</button>
            </div>
       </form>

     <div align="right">
      <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">Create Record</button>
     </div>
     <br />
   <div class="table-responsive">
    <table class="table table-bordered table-striped" id="employee_table">
           <thead>
            <tr>
                <th>First Name</th>
                <th>Last name</th>
                <th>Company</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Designation</th>
                <th>Status</th>
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
            <form method="post" id="employee_form" class="form-horizontal" enctype="multipart/form-data">
             @csrf
             <div class="form-group">
               <label class="control-label col-md-4" >First Name : </label>
               <div class="col-md-8">
                <input type="text" name="first_name" id="first_name" class="form-control" />
               </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-4" >Last Name : </label>
                <div class="col-md-8">
                 <input type="text" name="last_name" id="last_name" class="form-control" />
                </div>
               </div>

              <div class="form-group">
               <label class="control-label col-md-4">Select Company: </label>
               <div class="col-md-8">
                <select class="form-control" id="company_id" name="company_id">
                    <option value="">Select Company</option>
                    @foreach ($companies_data as $company)
                    <option value="{{$company->id}}">{{$company->company_name}}</option>
                    @endforeach
                </select>
               </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-4" >Email : </label>
                <div class="col-md-8">
                 <input type="email" name="email" id="email" class="form-control" />
                </div>
               </div>

               <div class="form-group">
                <label class="control-label col-md-4" >Phone : </label>
                <div class="col-md-8">
                 <input type="number" name="phone" id="phone" class="form-control" />
                </div>
               </div>

               <div class="form-group">
                <label class="control-label col-md-4" >Designation : </label>
                <div class="col-md-8">
                 <input type="text" name="designation" id="designation" class="form-control" />
                </div>
               </div>

               <div class="form-group">
                <label class="control-label col-md-4" >Status : </label>
                <div class="col-md-8">
                    <input type="radio" id="activeStatus" name="active_status" value=1>Active
                    <input type="radio" id="inActiveStatus" name="active_status" value=2 >Inactive
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

        $('#employee_table').DataTable({
  processing: true,
  serverSide: true,
  ajax:{
   url: "{{ route('employees.index') }}",
   method:"GET",
  },
  columns:[
   {
    data: 'first_name',
    name: 'first_name'
   },
   {
    data: 'last_name',
    name: 'last_name'
   },
   {
    data: 'company.company_name',
    name: 'company_id'
   },
   {
    data: 'email',
    name: 'email'
   },
   {
    data: 'phone',
    name: 'phone'
   },
   {
    data: 'designation',
    name: 'designation'
   },
   {
    data: 'active_status',
    name: 'active_status'
   },
   {
    data: 'action',
    name: 'action',
    orderable: false
   }
  ],

  rowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
      if(aData.active_status == 1){
        $('td:eq(6)', nRow).html( 'Active' );
      }else{
        $('td:eq(6)', nRow).html( 'InActive' );
      }

  }
 });


 $('#create_record').click(function(){
    $('.modal-title').text("Add New Record");
     $('#action_button').val("Add");
     $('#action').val("Add");
     $('#formModal').modal('show');
 });



 $('#employee_form').on('submit', function(event){
  event.preventDefault();

  if($('#action').val() == 'Add')
  {
   $.ajax({
    url:"{{ route('employees.store') }}",
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
      $('#employee_form')[0].reset();
      $('#employee_table').DataTable().ajax.reload();
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
    url:"{{ route('employees.update_data') }}",
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
      $('#employee_form')[0].reset();
      $('#employee_table').DataTable().ajax.reload();
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
   url:"/employees/"+id+"/edit",
   dataType:"json",
   success:function(html){
    $('#first_name').val(html.data.first_name);
    $('#last_name').val(html.data.last_name);
    $('#email').val(html.data.email);
    $('#phone').val(html.data.phone);
    $('#designation').val(html.data.designation);
    $('#company_id').val(html.data.company_id);

    if(html.data.active_status == 1){
        $('#activeStatus').prop('checked', true);
        $('#inActiveStatus').prop('checked', false);
    }else{
        $('#inActiveStatus').prop('checked', true);
        $('#activeStatus').prop('checked', false);
    }

    $('#hidden_id').val(html.data.id);
    $('.modal-title').text("Edit New Record");
    $('#action_button').val("Edit");
    $('#action').val("Edit");
    $('#formModal').modal('show');
   }
  })
 });




 var employeeId;

$(document).on('click', '.delete', function(){
    employeeId = $(this).attr('id');
 $('#confirmModal').modal('show');
});

$('#ok_button').click(function(){
 $.ajax({
  url:"employees/destroy_data/"+employeeId,
  beforeSend:function(){
   $('#ok_button').text('Deleting...');
  },
  success:function(data)
  {
   setTimeout(function(){
    $('#confirmModal').modal('hide');
    $('#employee_table').DataTable().ajax.reload();
   }, 2000);
  }
 })
});


    })
</script>
