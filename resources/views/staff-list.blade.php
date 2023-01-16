@extends('layouts.app')
@section('title')
Staff
@endsection

@section('staff-list')

<div class="container mt-4">
  
  <div class="col-md-12 mt-1 mb-2"><button type="button" id="addNewBook" class="btn btn-success">Add</button></div>

  <div class="card">

    <div class="card-header text-center font-weight-bold">
      <h2>Staff</h2>
    </div>

    <div class="card-body">

        <table class="table table-bordered" id="datatable-ajax-crud">
           <thead>
              <tr>
                <th>#</th>
                 <th>Id</th>
                 <th>Photo</th>
                 <th>Name</th>
                 <th>Position</th>
                 <th>Hired at</th>
                 <th>Wage</th>
                 <th>Birthday</th>
                 <th>Phone</th>
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
                <label for="name" class="col-sm-2 control-label"><b>Full name</b></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="name" name="name" placeholder="Enter Book Name" maxlength="50" required="">
                </div>
              </div>  

              <div class="form-group">
                <label class="col-sm-2 control-label"><b>Position</b></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="position" name="position" placeholder="Enter author Name" required="">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><b>Hired at</b></label>
                <div class="col-sm-12">
                  <input type="date" class="form-control" id="hire" name="hire" placeholder="Enter author Name" required="">
                </div>
              </div>            

              <div class="form-group">
                <label class="col-sm-2 control-label"><b>Wage</b></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="wage" name="wage" placeholder="Enter author Name" required="">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><b>Birthday</b></label>
                <div class="col-sm-12">
                  <input type="date" class="form-control" id="birthday" name="birthday" placeholder="Enter author Name" required="">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><b>Phone</b></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter author Name" required="">
                </div>
              </div>

               <div class="form-group">
                <label class="col-sm-2 control-label"><b>Image</b></label>
                <div class="col-sm-6 pull-left">
                  <input type="file" class="form-control" id="image" name="image" required="">
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
           ajax: "{{ url('staff-list') }}",
           columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    {data: 'id', name: 'id', 'visible': false},
                    { data: 'foto', name: 'foto' , orderable: false, 
                      "render": function(data, type, row) {
                        return '<img style="width:65px; height:60px;" src="'+data+'" />'; 
                    }},
                    { data: 'name', name: 'title' },
                    { data: 'position', name: 'position' },
                    { data: 'hired_at', name: 'hired_at' },
                    { data: 'wage', name: 'wage' },
                    { data: 'birthdate', name: 'birthdate' },
                    { data: 'phone', name: 'phone' },
                    { data: 'created_at', name: 'created_at' },
                    {data: 'action', name: 'action', orderable: false},
                 ],
          order: [[0, 'desc']]
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
            url: "{{ url('edit-staff') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res){
              $('#ajaxBookModel').html("Edit staff");
              $('#ajax-book-model').modal('show');
              $('#id').val(res.id);
              $('#name').val(res.name);
              $('#position').val(res.position);
              $('#hire').val(res.hired_at);
              $('#wage').val(res.wage);
              $('#birthday').val(res.birthdate);
              $('#phone').val(res.phone);
              $('#image').removeAttr('required');

           }
        });

    });

    $('body').on('click', '.delete', function () {

       if (confirm("Delete Record?") == true) {
        var id = $(this).data('id');
         
        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('delete-staff') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res){

              var oTable = $('#datatable-ajax-crud').dataTable();
              oTable.fnDraw(false);
           }
        });
       }

    });

    $('body').on('click', '.document', function () {


    var id = $(this).data('id');
      
    // ajax
    $.ajax({
        type:"POST",
        url: "{{ url('staff/documents/{id}') }}",
        data: { id: id },
        dataType: 'json',
        success: function(res){

          var oTable = $('#datatable-ajax-crud').dataTable();
          oTable.fnDraw(false); 
    }
 });


});

   $('#addEditBookForm').submit(function(e) {

     e.preventDefault();
  
     var formData = new FormData(this);
  
     $.ajax({
        type:'POST',
        url: "{{ url('add-staff')}}",
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
</script>
@endsection