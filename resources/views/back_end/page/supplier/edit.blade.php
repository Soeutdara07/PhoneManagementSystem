<div class="modal fade" id="modalUpdateSupplier" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width:40%;">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Update Supplier</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
           <form method="POST" id="formUpdateSupplier" enctype="multipart/form-data">

                <div class="form-group">
                   <input type="hidden" id="supplier_id" name="supplier_id">
                   <label for="">Supplier Name</label>
                   <input type="text" name="supplier_name" class="supplier_name_edit form-control">
                   <p></p>
                </div>
                <div class="form-group">
                   <label for="">Supplier Type</label>
                   <input type="text" name="type" class="type_edit form-control">
                   <p></p>
                </div>
                <div class="form-group">
                   <label for="">Address</label>
                   <input type="text" name="address" class="address_edit form-control">
                   <p></p>
                </div>
                <div class="form-group">
                   <label for="">Contact Info</label>
                   <input type="text" name="contact_info" class="contact_info_edit form-control">
                   <p></p>
                </div>

           </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" onclick="UpdateSupplier('#formUpdateSupplier')" class="btn btn-primary">Update</button>
        </div>
      </div>
    </div>
</div>