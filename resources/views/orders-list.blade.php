@extends('layouts.app')
@section('title')
Orders
@endsection

@section('order-list')

<div class="container mt-4">
                  <div class="row"> 
                    <div class="col-lg-3 col-sm-6"  >
                        <div class="card">
                            <div class="stat-widget-one card-body">
                                <div class="stat-icon d-inline-block">
                                    <i class="far fa-money-bill-alt text-success border-success" style="font-size:16px;"></i>
                                </div>
                                <div class="stat-content d-inline-block">
                                    <div class="stat-text" style="font-size:13px;">Current/Future Profit</div>
                                    <div class="stat-digit" style="font-size:16px;">{{$cprofit}}/{{$fprofit}} <i class='fas fa-euro-sign' style='font-size:16px'></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-4">
                        <div class="card">
                            <div class="stat-widget-one card-body">
                                <div class="stat-icon d-inline-block">
                                    <i class="fas fa-user-friends text-primary border-primary" style="font-size:16px;"></i>
                                </div>
                                <div class="stat-content d-inline-block">
                                    <div class="stat-text">Clients</div>
                                    <div class="stat-digit" style="font-size:18px;">{{$cdata->count()}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-one card-body">
                                <div class="stat-icon d-inline-block">
                                    <i class="ti-layout-grid2 text-pink border-pink" style="font-size:16px;"></i>
                                </div>
                                <div class="stat-content d-inline-block">
                                    <div class="stat-text">Brands</div>
                                    <div class="stat-digit" style="font-size:18px;">{{$bsay}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-one card-body">
                                <div class="stat-icon d-inline-block">
                                    <i class="fas fa-money-check-alt text-danger border-danger" style="font-size:16px;"></i>
                                </div>
                                <div class="stat-content d-inline-block">
                                    <div class="stat-text">Expenses</div>
                                    <div class="stat-digit" style="font-size:18px;">{{$expense}} <i class='fas fa-euro-sign' style='font-size:16px'></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
  <div class="col-md-12 mt-1 mb-2"><button type="button" id="addNewBook" class="btn btn-success">Add</button></div>

  <div class="card">

    <div class="card-header text-center font-weight-bold">
      <h2>Orders</h2>
    </div>
                
    <div class="card-body">
              
                <select name="active" id="status" class="form-control">
                    <option selected value="<?=null?>">Hamisi</option>
                    <option value="1">Aktiv</option>
                    <option value="0">Passiv</option>
                </select>
        <table class="table table-bordered" id="datatable-ajax-crud">
        
           <thead>
              <tr>
                <th>#</th>
                 <th>Id</th>
                 <th>Client</th>
                 <th>Product</th>
                 <th>Buy</th>
                 <th>Sell</th>
                 <th>Stock</th>
                 <th>Order</th>
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
                <label for="name" class="col-sm-2 control-label"><b>Product</b></label>
                <div class="col-sm-12">
                    <select name="product_id" class="form-control" id="products">
                        <option value="">Choose</option>
                        @foreach($pdata as $pinfo)
                        <option value="{{$pinfo->id}}">{{$pinfo->brands}} - {{$pinfo->products}} [{{$pinfo->amount}}]</option>
                        @endforeach
                    </select>                
                </div>
              </div>  

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label"><b>Client</b></label>
                <div class="col-sm-12">
                    <select name="client_id" class="form-control" id="clients">
                        <option value="">Choose</option>
                        @foreach($cdata as $cinfo)
                        <option value="{{$cinfo->id}}">{{$cinfo->name}} {{$cinfo->surname}}</option>
                        @endforeach
                    </select>                
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><b>Amount</b></label>
                <div class="col-sm-12">
                  <input type="number" class="form-control" id="author" name="amount" placeholder="Enter Order Amount" required="">
                </div>
              </div>             
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" id="btn-save" value="addNewBook">Add Order
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
           ajax: "{{ url('order-list') }}",
           columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'id', name: 'id', 'visible': false}, 
                    { data: 'name', name: 'name' , orderable: false},
                    { data: 'products', name: 'products' },
                    { data: 'pprice', name: 'pprice' },
                    { data: 'sprice', name: 'sprice' },
                    { data: 'pamount', name: 'pamount' },
                    { data: 'oamount', name: 'oamount' },
                    { data: 'action', name: 'action', orderable: false}, 
                 ],
          order: [[0, 'desc']]
    });


    $('#addNewBook').click(function () {
       $('#addEditBookForm').trigger("reset");
       $('#ajaxBookModel').html("Add Order");
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
            url: "{{ url('edit-order') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res){
              $('#ajaxBookModel').html("Edit Order");
              $('#ajax-book-model').modal('show');
              $('#id').val(res.id);
              $('#products').val(res.product_id);
              $('#clients').val(res.client_id);
              $('#author').val(res.amount);
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
            url: "{{ url('delete-order') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res){

              var oTable = $('#datatable-ajax-crud').dataTable();
              oTable.fnDraw(false);
           }
        });
       }

    });


$('body').on('click', '.confirm', function () {

  if (confirm("Confirm order?") == true) {
  let id = $(this).data('id');
    
  // ajax
  $.ajax({
      type:"POST",
      url: "{{ url('confirm-order') }}",
      data: { id: id },
      dataType: 'json',
      success: function(res){

          if(res=='There is no enough product to confirm this order')
          {alert(res)}
          
          var oTable = $('#datatable-ajax-crud').dataTable();
          oTable.fnDraw(false); 
        }
    });
  }

});



$('body').on('click', '.cancel', function () {

if (confirm("Cancel order?") == true) {
let id = $(this).data('id');
  
// ajax
$.ajax({
    type:"POST",
    url: "{{ url('cancel-order') }}",
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
        url: "{{ url('add-order')}}",
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