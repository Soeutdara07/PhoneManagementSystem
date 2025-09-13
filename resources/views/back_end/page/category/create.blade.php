<div class="modal fade" id="modalCreateCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width:40%;">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Creating Category</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
           <form method="POST" class="formCreateCategory" enctype="multipart/form-data">

                <div class="form-group">
                   <label for="">Category Name</label>
                   <input type="text" name="category_name" class="name form-control" id="">
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
          <button type="button" onclick="StoreCategory('.formCreateCategory')" class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
</div>