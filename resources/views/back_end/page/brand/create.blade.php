<div class="modal fade" id="modalCreateBrand" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width:40%;">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Create Brand</h1>
        </div>
        <div class="modal-body">
           <form method="POST" class="formCreateBrand" enctype="multipart/form-data">

                <div class="form-group">
                   <label for="" class="">Brand Name</label>
                   <input type="text" name="brand_name" class="brand_name form-control " id="" placeholder="Brand Name">
                   <p></p>
                </div>
                <div class="form-group">
                  <label for="">Status</label>
                  <select name="status" class="status form-control">
                     <option value="1">Active</option>
                     <option value="0">Inactive</option>
                  </select>
                  <p></p>
                </div>

           </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" onclick="BrandStore('.formCreateBrand')" class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
</div>

