@extends('template.admin.index')
@section('content_admin')
<style>
    .badge{cursor: pointer;}    
    .dataTable-input{        
        border: 1px solid black;
    }        
    @media only screen and (max-width: 520px) {
        .dataTable-dropdown  {
          display: none;
        }
    }
</style>

<div class="col-12">
    <div class="card recent-sales overflow-auto">
      <div class="card-body">
        <h5 class="card-title">Data Jurusan <span>| Tambahkan Data</span></h5>
        @if(auth()->user()->is_admin == 1)
          <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">
            Tambah Data</button>
        @endif
        <table class="table table-borderless datatable">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Kode</th>
              <th scope="col">Nama</th>
              <th scope="col">Action</th>             
            </tr>
          </thead>
          <tbody>
            @foreach ($jurusan as $value)                
            <tr>
                <th scope="row">{{$loop->iteration}}</th>     
                <td>{{$value->kode}}</td>  
                <td>{{$value->nama}}</td>                 
                <td>
                  
                  <button class="btn btn-info edit-button"  data-id="{{ $value->id }}" data-bs-toggle="modal"
                    data-bs-target="#editModal"><i class="bi bi-pencil"></i> Edit</button>
                @if(auth()->user()->is_admin == 1)
                  <button class="btn btn-danger delete"  data-id="{{ $value->id }}"><i class="bi bi-trash"></i> Hapus</button>
                @endif

              </td>
            </tr> 
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
</div>


{{-- Modal Create --}}
<div class="modal fade" id="createModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Data Jurusan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="createForm">
              <div class="col-12 mb-2">
                <span style="color: red">*Kode Tidak Boleh Sama</span> <br>
                <label class="form-label">Kode</label>
                <div class="input-group has-validation">
                  <input type="number" class="form-control" id="kode" required>
                </div>
              </div>
              <div class="col-12 mb-2">
                <label class="form-label">Nama</label>
                <div class="input-group has-validation">
                  <input type="text" class="form-control" id="nama" required>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Modal Edit --}}
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Data Jurusan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editForm">        
              <input readonly type="hidden" class="form-control" id="edit_id" name="edit_id">
              <div class="col-12 mb-2">
                <span style="color: red">*Kode Tidak Boleh Sama</span> <br>
                <label class="form-label">Kode</label>
                <div class="input-group has-validation">
                  <input type="number" class="form-control" id="edit_kode" required>
                </div>
              </div>
              <div class="col-12 mb-2">
                <label class="form-label">Nama</label>
                <div class="input-group has-validation">
                  <input type="text" class="form-control" id="edit_nama" required>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
         </form>
      </div>
    </div>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
      // Create
      $("#createForm").submit(function(event) {
          event.preventDefault();

          // VALIDASI PANJANG KODE
          var kode = $("#kode").val();
          if (kode.length > 6) {
              alert("Kode tidak boleh lebih dari 6 angka!");
              return false;
          }

          var formData = new FormData();
          formData.append("_token", "{{ csrf_token() }}");
          formData.append("kode", kode);
          formData.append("nama", $("#nama").val());

          $.ajax({
              url: '{{ url('jurusan/create') }}',
              type: 'POST',
              data: formData,
              contentType: false,
              processData: false,
              success: function(response) {
                  alert(response.message);
                  location.reload();
              },
              error: function(xhr) {
                  console.log(xhr.responseText);
              }
          });
      });

      // Edit
      $(document).on('click', '.edit-button', function(event) {
          event.preventDefault();
          var id = $(this).data('id');
          $.ajax({
              url: '{{ url('jurusan/edit') }}/' + id,
              type: 'GET',
              dataType: 'json',
              success: function(data) {
                   $('#edit_id').val(data.id);
                   $("#edit_kode").val(data.kode);
                   $("#edit_nama").val(data.nama);
              },
              error: function(xhr) {
                  console.log(xhr.responseText);
              }
          });
      });    

      // Update
      $("#editForm").submit(function(event) {
          event.preventDefault();

          // VALIDASI PANJANG KODE
          var kode = $("#edit_kode").val();
          if (kode.length > 6) {
              alert("Kode tidak boleh lebih dari 6 angka!");
              return false;
          }

          var id = $('#edit_id').val();
          var formData = new FormData();
          formData.append("_token", "{{ csrf_token() }}");
          formData.append("kode", kode);
          formData.append("nama", $("#edit_nama").val());

          $.ajax({
              url: '{{ url('jurusan/update') }}/' + id,
              type: 'POST',
              data: formData,
              contentType: false,
              processData: false,
              success: function(response) {
                  alert(response.message);
                  location.reload();
              },
              error: function(xhr) {
                  console.log(xhr.responseText);
              }
          });
      });

      // Delete
      $(document).on('click', '.delete', function(event) {
          event.preventDefault();
          var id = $(this).data('id');
          if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
              $.ajax({
                  url: '{{ url('jurusan/destroy') }}/' + id,
                  type: 'GET',
                  data: {
                      "_token": "{{ csrf_token() }}"
                  },
                  success: function(response) {
                      alert(response.message);
                      location.reload();
                  },
                  error: function(xhr) {
                      console.log(xhr.responseText);
                  }
              });
          }
      });
  });
</script>

@endsection
