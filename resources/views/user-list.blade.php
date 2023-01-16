@extends('layouts.app')
@section('title')
Users
@endsection

@section('user-list')
@if(session('wrong'))
    <div class="text-center alert alert-danger" style="font-size:20px">
        <b>{{session('wrong')}}</b>
    </div>
@endif

<div class="container mt-4">
  
  <div class="col-md-12 mt-1 mb-2"><button type="button" id="addNewBook" class="btn btn-success">Add</button></div>

  <div class="card">

    <div class="card-header text-center font-weight-bold">
      <h2>Users</h2>
    </div>

    <div class="card-body">
      <select id="status">
        <option selected>All</option>
        <option value="1">Blocked</option>
      </select>
        <table class="table table-bordered" id="datatable-ajax-crud">
           <thead>
              <tr>
                <th>#</th>
                 <th>Id</th>
                 <th>Photo</th>
                 <th>Name</th>
                 <th>Email</th>
                 <th>Created at</th>
                 <th>Action</th>
              </tr>
           </thead>
        </table>

    </div>

  </div>
  <!-- boostrap add and edit book model -->
    <div class="modal fade" id="ajax-book-model" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="ajaxBookModel"></h4>
          </div>
          <div class="modal-body">
            <form action="javascript:void(0)" id="addEditBookForm" name="addEditBookForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="id" id="id">
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label"><b>Name</b></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="title" name="name" placeholder="Enter User Fullname" maxlength="50" required="">
                </div>
              </div>  

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label"><b>Email</b></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="code" name="email" placeholder="Enter User's email" maxlength="50" required="">
                </div>
              </div> 

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label"><b>New Password</b></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="npassword" name="npassword" placeholder="Skip if you don't want to change" maxlength="50">
                </div>
              </div>

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label"><b>Password</b></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="password" name="password" placeholder="Enter password" maxlength="50" required="">
                </div>
              </div>           

               <div class="form-group">
                <label class="col-sm-2 control-label"><b>Picture</b></label>
                <div class="col-sm-6 pull-left">
                  <input type="file" class="form-control btn-sm" id="image" name="image" required="">
                </div>               
                <div class="col-sm-6 pull-right">
                  <img id="preview-image" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif"
                        alt="preview image" style="max-height: 250px;">
                </div>
              </div>

              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" id="btn-save" value="addNewBook">Save changes
                </button>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            
          </div>
        </div>
      </div>
    </div>
<!-- end bootstrap model -->

<script type="text/javascript">
     
 $(document).ready( function () {

    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#image').change(function(){
           
    let reader = new FileReader();

    reader.onload = (e) => { 

      $('#preview-image').attr('src', e.target.result); 

    }

    reader.readAsDataURL(this.files[0]); 
  
   });

    $('#datatable-ajax-crud').DataTable({
           processing: true,
           serverSide: true,
           ajax: "{{ url('user-list') }}",
           columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    {data: 'id', name: 'id',  'visible': false},
                    { data: 'foto', name: 'foto' , orderable: false,
                      "render": function(data, type, row){
                        return '<img style="width:65px; height:60px;" src="'+data+'" />';
                    }},
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'created_at', name: 'created_at' },
                    {data: 'action', name: 'action', orderable: false},
                 ],
          order: [[0, 'ASC']]

          
      
    });
    


    $('#addNewBook').click(function () {
       $('#addEditBookForm').trigger("reset");
       $('#ajaxBookModel').html("Add Book");
       $('#ajax-book-model').modal('show');
       $("#image").attr("required", "true");
       $('#id').val('');
       $('#preview-image').attr('src', 'https://www.riobeauty.co.uk/images/product_image_not_found.gif');


    });
 
    $('body').on('click', '.edit', function () {

        var id = $(this).data('id');
         
        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('edit-user') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res){
              $('#ajaxBookModel').html("Edit user");
              $('#ajax-book-model').modal('show');
              $('#id').val(res.id);
              $('#title').val(res.name);
              $('#code').val(res.email);
              $('#author').val(res.author);
              $('#image').removeAttr('required');
              $('#preview-image').attr('src','http://127.0.0.1:8000/storage/images'+foto);

           }
        });

    });

    $('body').on('click', '.delete', function () {

       if (confirm("Delete user?") == true) {
        var id = $(this).data('id');
         
        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('delete-user') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res){

              var oTable = $('#datatable-ajax-crud').dataTable();
              oTable.fnDraw(false);
           }
        });
       }

    });

   $('#addEditBookForm').submit(function(e) {

     e.preventDefault();
  
     var formData = new FormData(this);
  
     $.ajax({
        type:'POST',
        url: "{{ url('add-user')}}",
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: (data) => {
          $("#ajax-book-model").modal('hide');
          var oTable = $('#datatable-ajax-crud').dataTable();
          oTable.fnDraw(false);
          $("#btn-save").html('Submit');
          $("#btn-save"). attr("disabled", false);
        },
        error: function(data){
           console.log(data);
         }
       });
   });
});

$('body').on('click', '.block', function () {

if (confirm("Do you want to block this user?") == true) {
let id = $(this).data('id');
  
// ajax 
$.ajax({
    type:"POST",
    url: "{{ url('block-user') }}",
    data: { id: id },
    dataType: 'json',
    success: function(res){       
        var oTable = $('#datatable-ajax-crud').dataTable();
        oTable.fnDraw(false); 
      }
  });
}

});

$('body').on('click', '.unblock', function () {

if (confirm("Do you want to unblock this user?") == true) {
let id = $(this).data('id');
  
// ajax
$.ajax({
    type:"POST",
    url: "{{ url('unblock-user') }}",
    data: { id: id },
    dataType: 'json',
    success: function(res){

        var oTable = $('#datatable-ajax-crud').dataTable();
        oTable.fnDraw(false);
      }
  });
}

});
</script>
@endsection