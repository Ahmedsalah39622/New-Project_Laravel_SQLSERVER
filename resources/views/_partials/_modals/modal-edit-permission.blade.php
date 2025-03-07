<div class="modal fade" id="editPermissionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ url('/admin/permissions') }}">
      @csrf
      @method('PUT')
      <input type="hidden" name="id" id="permission_id">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Permission</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <label for="permission_name">Permission Name</label>
          <input type="text" name="name" class="form-control" id="permission_name" required>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>
