@extends('layouts.app')
@section('title')
Products
@endsection

@section('product-list')

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
                                    <div class="stat-digit" style="font-size:14px;">{{$cprofit}}/{{$fprofit}} <i class='fas fa-euro-sign' style='font-size:16px'></i></div>
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
      <h3>Products</h3>
    </div>

    <div class="card-body">

        <table class="table table-bordered" id="datatable-ajax-crud">
           <thead>
              <tr>
                <th>#</th>
                <th>ID</th> 
                <th>Picture</th>
                <th>Brands</th>
                <th>Products</th>
                <th>Purchase price</th>
                <th>Sale Price</th>
                <th>Amount</th>
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
                <label for="name" class="col-sm-2 control-label"><b>Brands</b></label>
                <div class="col-sm-12">
                  <select name="brand_id" class="form-control" id="brands">
                      <option value="">Choose</option>
                      @foreach($bdata as $binfo)
                        <option value="{{$binfo->id}}">{{$binfo->brands}}</option>
                      @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label"><b>Product</b></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="title" name="product" placeholder="Enter Product's Name" maxlength="50" required="">
                </div>
              </div>  

              <div class="form-group">
                <label for="name" class="col-sm-4 control-label"><b>Purchase Price</b></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="code" name="pprice" placeholder="Enter Purchase Price" maxlength="50" required="">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><b>Sale Price</b></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="author" name="sprice" placeholder="Enter Sale Price" required="">
                </div>
              </div>   
              <div class="form-group">
                <label class="col-sm-2 control-label"><b>Amount</b></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="amount" name="amount" placeholder="Enter Product Amount" required="">
                </div>
              </div>             

               <div class="form-group">
                <label class="col-sm-2 control-label"><b>Product's Image</b></label>
                <div class="col-sm-6 pull-left">
                  <input type="file" class="form-control btn-sm" id="image" name="image" required="">
                </div>               
                <div class="col-sm-6 pull-right">
                  <img id="preview-image" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif"
                        alt="preview image" style="max-height: 250px;">
                </div>
              </div>

              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" id="btn-save" value="addNewBook">Add Product
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
           ajax: "{{ url('product-list') }}",
           columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    {data: 'id', name: 'id', 'visible': false},
                    { data: 'images', name: 'images' , orderable: false,  
                      "render": function(data, type, row) {
                        return '<img style="width:65px; height:60px;" src="'+data+'" />'; 
                    }},
                    { data: 'brands', name: 'brands'},
                    { data: 'products', name: 'products'},
                    { data: 'pprice', name: 'pprice' },
                    { data: 'sprice', name: 'sprice' },
                    { data: 'amount', name: 'amount' },
                    { data: 'created_at', name: 'created_at' },
                    {data: 'action', name: 'action', orderable: false}, 
                 ],
                
          order: [[0, 'desc']]
    });


    $('#addNewBook').click(function () {
       $('#addEditBookForm').trigger("reset");
       $('#ajaxBookModel').html("Add Product");
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
            url: "{{ url('edit-product') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res){
              $('#ajaxBookModel').html("Edit Product");
              $('#ajax-book-model').modal('show');
              $('#id').val(res.id);
              $('#brands').val(res.brand_id);
              $('#title').val(res.products);
              $('#code').val(res.pprice);
              $('#author').val(res.sprice);
              $('#amount').val(res.amount);
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
            url: "{{ url('delete-product') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res){
              if(res=='This product has already ordered')
              {alert(res)}

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
        url: "{{ url('add-product')}}",
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