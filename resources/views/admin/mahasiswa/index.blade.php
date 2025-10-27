@extends('template.admin.index')
@section('content_admin')
<style>
    .badge{cursor: pointer;}
    .dataTable-input{ border: 1px solid black; }
    @media only screen and (max-width: 520px) {
        .dataTable-dropdown { display: none; }
    }
    .foto-preview {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 5px;
    }
</style>

<div class="col-12">
  <div class="card recent-sales overflow-auto">
    <div class="card-body">
      <h5 class="card-title">Data Mahasiswa <span>| Tambahkan Data</span></h5>
      @if(auth()->user()->is_admin == 1)
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">Tambah Data</button>
      @endif

      <table class="table table-borderless datatable">
        <thead>
          <tr>
            <th>#</th>
            <th>Foto</th>
            <th>NIM</th>
            <th>Nama</th>
            <th>Jurusan</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Jenis Kelamin</th>
            <th>Created by</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($mahasiswa as $value)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
              @if($value->foto)
                <img src="{{ asset('storage/'.$value->foto) }}" class="foto-preview" alt="Foto {{ $value->nama }}">
              @else
                <span class="text-muted">-</span>
              @endif
            </td>
            <td>{{ $value->nim }}</td>
            <td>{{ $value->nama }}</td>
            <td>{{ $value->jurusan->nama }}</td>
            <td>{{ $value->tempat_lahir }}</td>
            <td>{{ \Carbon\Carbon::parse($value->tanggal_lahir)->translatedFormat('d F Y') }}</td>
            <td>{{ $value->jenis_kelamin }}</td>
            <td>{{ $value->user->name ?? '-' }}</td>
            <td>
              <button class="btn btn-info edit-button" data-id="{{ $value->id }}" data-bs-toggle="modal" data-bs-target="#editModal">
                <i class="bi bi-pencil"></i> Edit
              </button>
              @if(auth()->user()->is_admin == 1)
              <button class="btn btn-danger delete" data-id="{{ $value->id }}">
                <i class="bi bi-trash"></i> Hapus
              </button>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="createModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Data Mahasiswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="createForm" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-6 mb-2">
              <label class="form-label">NIM</label>
              <input type="number" class="form-control" name="nim" required>
            </div>
            <div class="col-md-6 mb-2">
              <label class="form-label">Nama</label>
              <input type="text" class="form-control" name="nama" required>
            </div>
            <div class="col-md-6 mb-2">
              <label class="form-label">Jurusan</label>
              <select class="form-control" name="jurusan_id" required>
                <option value="" disabled selected>-- Pilih Jurusan --</option>
                @foreach($jurusan as $j)
                <option value="{{ $j->id }}">{{ $j->kode }} - {{ $j->nama }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6 mb-2">
              <label class="form-label">Tempat Lahir</label>
              <input type="text" class="form-control" name="tempat_lahir" required>
            </div>
            <div class="col-md-6 mb-2">
              <label class="form-label">Tanggal Lahir</label>
              <input type="date" class="form-control" name="tanggal_lahir" required>
            </div>
            <div class="col-md-6 mb-2">
              <label class="form-label">Jenis Kelamin</label>
              <select class="form-control" name="jenis_kelamin" required>
                <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                <option value="Laki-Laki">Laki-Laki</option>
                <option value="Perempuan">Perempuan</option>
              </select>
            </div>
            <div class="col-md-6 mb-2">
              <label class="form-label">Foto (max 500KB)</label>
              <input type="file" class="form-control" name="foto" accept="image/*">
            </div>

            {{-- Akun Login --}}
            <div class="col-12"><hr></div>
            <div class="col-12">
              <h6 class="mb-2">Akun Login Mahasiswa</h6>
            </div>
            <div class="col-md-6 mb-2">
              <label class="form-label">Email (untuk login)</label>
              <input type="email" class="form-control" name="email" required>
            </div>
            <div class="col-md-6 mb-2">
              <label class="form-label">Password (min 5 karakter)</label>
              <input type="password" class="form-control" name="password" minlength="5" required>
            </div>
            {{-- <div class="col-md-6 mb-3">
              <label class="form-label">Role</label>
              <select class="form-control" name="is_admin" required>
                <option value="" disabled selected>-- Pilih Role --</option>
                <option value="0">User</option>
                <option value="1">Admin</option>
              </select>
            </div> --}}
            <input type="hidden" value="0" name="is_admin">
          </div>

          <div class="modal-footer mt-2">
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
        <h5 class="modal-title">Edit Data Mahasiswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="editForm" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="id" id="edit_id">
          <div class="row">
            <div class="col-md-6 mb-2">
              <label class="form-label">NIM</label>
              <input type="number" class="form-control" name="nim" id="edit_nim" required>
            </div>
            <div class="col-md-6 mb-2">
              <label class="form-label">Nama</label>
              <input type="text" class="form-control" name="nama" id="edit_nama" required>
            </div>
            <div class="col-md-6 mb-2">
              <label class="form-label">Jurusan</label>
              <select class="form-control" name="jurusan_id" id="edit_jurusan_id" required>
                <option value="" disabled>-- Pilih Jurusan --</option>
                @foreach($jurusan as $j)
                <option value="{{ $j->id }}">{{ $j->kode }} - {{ $j->nama }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6 mb-2">
              <label class="form-label">Tempat Lahir</label>
              <input type="text" class="form-control" name="tempat_lahir" id="edit_tempat_lahir" required>
            </div>
            <div class="col-md-6 mb-2">
              <label class="form-label">Tanggal Lahir</label>
              <input type="date" class="form-control" name="tanggal_lahir" id="edit_tanggal_lahir" required>
            </div>
            <div class="col-md-6 mb-2">
              <label class="form-label">Jenis Kelamin</label>
              <select class="form-control" name="jenis_kelamin" id="edit_jenis_kelamin" required>
                <option value="Laki-Laki">Laki-Laki</option>
                <option value="Perempuan">Perempuan</option>
              </select>
            </div>
            <div class="col-md-6 mb-2">
              <label class="form-label">Foto (max 500KB)</label>
              <input type="file" class="form-control" name="foto" id="edit_foto" accept="image/*">
            </div>
          </div>

          <div class="modal-footer mt-2">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Scripts --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {

    // CREATE
    $("#createForm").submit(function(event) {
        event.preventDefault();

        // Validasi NIM <= 6 digit
        var nim = $("input[name='nim']").val().toString().trim();
        if (nim.length > 6) {
            alert("NIM tidak boleh lebih dari 6 angka!");
            return false;
        }

        // Validasi foto max 500KB
        var foto = $("input[name='foto']")[0].files[0];
        if (foto && foto.size > 500 * 1024) {
            alert("Ukuran foto tidak boleh lebih dari 500KB!");
            return false;
        }

        // Validasi email & password & role
        var email = $("input[name='email']").val().trim();
        var password = $("input[name='password']").val();
        // var is_admin = $("select[name='is_admin']").val();

        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert("Format email tidak valid!");
            return false;
        }
        // if (!is_admin) {
        //     alert("Silakan pilih role!");
        //     return false;
        // }
        if (!password || password.length < 5) {
            alert("Password minimal 5 karakter!");
            return false;
        }

        var formData = new FormData(this);
        $.ajax({
            url: "{{ route('mahasiswa.store') }}",
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert(response.message);
                location.reload();
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    let message = Object.values(errors).flat().join("\n");
                    alert("Error:\n" + message);
                } else {
                    alert("Terjadi kesalahan saat menyimpan data.");
                }
            }
        });
    });

    // EDIT - get data
    $(document).on('click', '.edit-button', function() {
        var id = $(this).data('id');
        $.get("/mahasiswa/" + id + "/edit", function(data) {
            $('#edit_id').val(data.id);
            $('#edit_nim').val(data.nim);
            $('#edit_nama').val(data.nama);
            $('#edit_jurusan_id').val(data.jurusan_id);
            $('#edit_tempat_lahir').val(data.tempat_lahir);
            $('#edit_tanggal_lahir').val(data.tanggal_lahir);
            $('#edit_jenis_kelamin').val(data.jenis_kelamin);
        });
    });

    // UPDATE
    $("#editForm").submit(function(event) {
        event.preventDefault();

        // Validasi NIM <= 6 digit
        var nim = $("#edit_nim").val().toString().trim();
        if (nim.length > 6) {
            alert("NIM tidak boleh lebih dari 6 angka!");
            return false;
        }

        // Validasi foto max 500KB
        var foto = $("#edit_foto")[0].files[0];
        if (foto && foto.size > 500 * 1024) {
            alert("Ukuran foto tidak boleh lebih dari 500KB!");
            return false;
        }

        var id = $('#edit_id').val();
        var formData = new FormData(this);
        formData.append("_method", "PUT");

        $.ajax({
            url: "/mahasiswa/" + id,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert(response.message);
                location.reload();
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    let message = Object.values(errors).flat().join("\n");
                    alert("Error:\n" + message);
                } else {
                    alert("Gagal memperbarui data!");
                }
            }
        });
    });

    // DELETE
    $(document).on('click', '.delete', function() {
        var id = $(this).data('id');
        if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
            $.ajax({
                url: "/mahasiswa/" + id,
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": "DELETE"
                },
                success: function(response) {
                    alert(response.message);
                    location.reload();
                },
                error: function() {
                    alert("Gagal menghapus data!");
                }
            });
        }
    });

});
</script>
@endsection
