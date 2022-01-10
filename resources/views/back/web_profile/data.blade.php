@extends('layouts.back', ['web' => $web])
@section('title', 'Profile Web')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
  integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
  crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/spectrum-colorpicker2/dist/spectrum.min.css">

<style>
  .dropify-wrapper {
    border: 1px solid #e2e7f1;
    border-radius: .3rem;
    height: 90%;
  }

  #cke_description {
    border: 1px solid #e2e7f1;
    border-width: thin;
  }

  .card {
    border-radius: 10px;
  }

  label.error {
    color: #f1556c;
    font-size: 13px;
    font-size: .875rem;
    font-weight: 400;
    line-height: 1.5;
    margin-top: 5px;
    padding: 0;
  }

  input.error {
    color: #f1556c;
    border: 1px solid #f1556c;
  }

  textarea.error {
    color: #f1556c;
    border: 1px solid #f1556c;
  }
</style>
@endsection
@section('container')
<section class="section">
  <div class="section-header">
    <h1>Profile Web</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard.index') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Profile Web</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-xl">
        <div class="card">
          <div class="card-body">
            @if(count($web))
            @foreach ($web as $webs)
            <form action="{{ route('web-profile.update', $webs->id) }}" method="POST" id="editWebForm"
              enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="row">
                <div class="col-sm">
                  <label for="primary_color">Primary Color</label>
                  <input type="text" id="color-picker" name="edit_primary_color" class="form-control text-dark"
                    value="{{ $webs->primary_color }}" placeholder="Warna Primer">
                </div>
                <div class="col-sm">
                  <label for="name">Nama</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text text-white" style="background-color: rgb(235, 196, 21)"
                        id="inputGroupPrepend3"><i class="far fa-id-card"></i></span>
                    </div>
                    <input type="text" id="edit_name" name="edit_name" value="{{old('edit_name') ?? $webs->name}}"
                      class="form-control text-dark" placeholder="Nama">
                  </div>
                  <label for="edit_name" generated="true" class="error" style="display: none;"></label>
                </div>
                
              </div>
              <br>
              <div class="row">
                <div class="col-sm">
                  <label for="twitter">Twitter</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text text-white" style="background-color: rgb(38, 40, 41)"
                        id="inputGroupPrepend3"><i class="fab fa-twitter"></i></span>
                    </div>
                    <input type="text" id="edit_twitter" name="edit_twitter" value="{{old('edit_twitter') ?? $webs->twitter}}"
                      class="form-control text-dark" placeholder="Twitter">
                  </div>
                  <label for="edit_twitter" generated="true" class="error" style="display: none;"></label>
                </div>
                <div class="col-sm">
                  <label for="facebook">Facebook</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text text-white" style="background-color: rgb(38, 40, 41)"
                        id="inputGroupPrepend3"><i class="fab fa-facebook-square"></i></span>
                    </div>
                    <input type="text" id="edit_facebook" name="edit_facebook" value="{{old('edit_facebook') ?? $webs->facebook}}"
                      class="form-control text-dark" placeholder="Facebook">
                  </div>
                  <label for="edit_facebook" generated="true" class="error" style="display: none;"></label>
                </div>
                <div class="col-sm">
                  <label for="instagram">Instagram</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text text-white" style="background-color: rgb(38, 40, 41)"
                        id="inputGroupPrepend3"><i class="fab fa-instagram"></i></span>
                    </div>
                    <input type="text" id="edit_instagram" name="edit_instagram" value="{{old('edit_instagram') ?? $webs->instagram}}"
                      class="form-control text-dark" placeholder="Instagram">
                  </div>
                  <label for="edit_instagram" generated="true" class="error" style="display: none;"></label>
                </div>
                <div class="col-sm">
                  <label for="email">Email</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text text-white" id="inputGroupPrepend3" style="background-color: rgb(38, 40, 41);"><i
                          class="fa fa-envelope"></i> </span>
                    </div>
                    <input type="email" id="edit_email" onkeyup="keyup('email')" name="edit_email"
                      class="form-control text-dark" value="{{old('edit_email') ?? $webs->email}}"
                      placeholder="Alamat email">
                  </div>
                  <br>
                  <label for="edit_email" generated="true" class="error" style="display: none;"></label>
                </div>
              </div>
              <br>
              <br><br>
              <div class="row">
                <div class="col-sm">
                  <label for="edit_description">Deskripsi Penulis</label>
                  <textarea name="edit_description" id="description"
                    class="form-control">{!!$webs->description!!}</textarea>
                  <label for="edit_description" generated="true" class="error" style="display: none;"></label>
                </div>
                <div class="col-sm">
                  <label for="edit_photo">Foto Penulis</label>
                  <input type="file" class="form-control dropify" name="edit_photo"
                      data-allowed-file-extensions="png jpg jpeg" data-show-remove="false" data-default-file="@if(!empty($webs->photo) &&
                      Storage::exists($webs->photo)){{ Storage::url($webs->photo) }}@endif">
                  <label for="edit_photo" generated="true" class="error" style="display: none;"></label>
                </div>
              </div>
              <br>
              <div class="row ">
                <div class="col-sm pt-3">
                  <button type="button" class="btn btn-md btn-danger text-right" data-toggle="modal"
                    data-target="#deleteProfileWeb"><i class="fas fa-plus-circle"></i>
                    Hapus</button>
                </div>
                <div class="col-sm text-sm-right pt-3">
                  <button type="submit" class="btn btn-md btn-primary" id="editButton"><i
                      class="fas fa-plus-circle"></i> Perbaharui</button>
                </div>
              </div>
            </form>
            <form action="{{ route('web-profile.destroy', $webs->id) }}" method="post" id="hapusForm">
              @csrf
              @method('delete')
            </form>
            @endforeach
            @else
            <form action="{{ route('web-profile.store') }}" method="POST" id="tambahWebForm"
              enctype="multipart/form-data">
              @csrf
              <div class="row">
                <div class="col-sm">
                  <label for="primary_color">Primary Color</label>
                  <input type="text" id="color-picker" name="primary_color" class="form-control text-dark"
                    value="#6777ef" placeholder="Warna Primer">
                </div>
                <div class="col-sm">
                  <label for="name">Nama</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text text-white" style="background-color: rgb(235, 196, 21)"
                        id="inputGroupPrepend3"><i class="far fa-id-card"></i></span>
                    </div>
                    <input type="text" id="name" name="name" value="{{old('name')}}" class="form-control text-dark"
                      placeholder="Nama">
                  </div>
                  <label for="name" generated="true" class="error" style="display: none;"></label>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-sm">
                  <label for="twitter">Twitter</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text text-white" style="background-color: rgb(38, 40, 41)"
                        id="inputGroupPrepend3"><i class="fab fa-twitter"></i></span>
                    </div>
                    <input type="text" id="twitter" name="twitter" value="{{old('twitter')}}" class="form-control text-dark"
                      placeholder="Twitter">
                  </div>
                  <label for="twitter" generated="true" class="error" style="display: none;"></label>
                </div>
                <div class="col-sm">
                  <label for="facebook">Facebook</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text text-white" style="background-color: rgb(38, 40, 41)"
                        id="inputGroupPrepend3"><i class="fab fa-facebook-square"></i></span>
                    </div>
                    <input type="text" id="facebook" name="facebook" value="{{old('facebook')}}" class="form-control text-dark"
                      placeholder="Facebook">
                  </div>
                  <label for="facebook" generated="true" class="error" style="display: none;"></label>
                </div>
                <div class="col-sm">
                  <label for="instagram">Instagram</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text text-white" style="background-color: rgb(38, 40, 41)"
                        id="inputGroupPrepend3"><i class="fab fa-instagram"></i></span>
                    </div>
                    <input type="text" id="instagram" name="instagram" value="{{old('instagram')}}" class="form-control text-dark"
                      placeholder="Instagram">
                  </div>
                  <label for="instagram" generated="true" class="error" style="display: none;"></label>
                </div>
                <div class="col-sm">
                  <label for="email">Email</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text text-white" id="inputGroupPrepend3" style="background-color: rgb(38, 40, 41);"><i
                          class="fa fa-envelope"></i> </span>
                    </div>
                    <input type="email" id="email" onkeyup="keyup('email')" name="email" class="form-control text-dark"
                      value="{{old('email')}}" placeholder="Alamat email">
                  </div>
                  <label for="email" generated="true" class="error" style="display: none;"></label>
                </div>
              </div>
              <br>
              <br><br>
              <div class="row">
                <div class="col-sm">
                  <label for="description">Deskripsi Penulis</label>
                  <textarea name="description" id="description" class="form-control"></textarea>
                  <label for="description" generated="true" class="error" style="display: none;"></label>
                </div>
                <div class="col-sm">
                  <label for="photo">Foto Penulis</label>
                  <input type="file" class="form-control dropify" name="photo"
                      data-allowed-file-extensions="png jpg jpeg" data-show-remove="false">
                  <label for="photo" generated="true" class="error" style="display: none;"></label>
                </div>
            </div>
              </div>
              <br>
              <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-md btn-danger text-right" disabled><i
                    class="fas fa-plus-circle"></i>
                  Hapus</button>
                <button type="submit" class="btn btn-md btn-primary" id="tambahButton"><i
                    class="fas fa-plus-circle"></i> Tambahkan</button>
              </div>
            </form>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@section('modal')
<div class="modal fade" tabindex="-1" role="dialog" id="deleteProfileWeb">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Hapus Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Apakah anda yakin untuk <b>menghapus profile web</b> ini?
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
        <button type="button" class="btn btn-primary" id="hapusButton">Ya, Hapus</button>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/spectrum-colorpicker2/dist/spectrum.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
  integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
<script src="{{ asset('assets/ckeditor_without_image/ckeditor.js')}}"></script>
<script>
  CKEDITOR.replace('description');
</script>
<script>
  $('#color-picker').spectrum({
  type: "component"
});
$('.dropify').dropify();
</script>
<script>
  $(document).ready(function() {
  $.ajaxSetup({
      headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $("#tambahWebForm").validate({
      ignore: [],
      rules: {
          name:{
              required: true,
          },
          description:{
              required: true,
          },
          twitter:{
              required: true,
          },
          facebook:{
              required: true,
          },
          instagram:{
              required: true,
          },
          email:{
              required: true,
              email: true,
          },
      },
      messages: {
          name: {
                required: "Nama harus di isi"
          },
          description: {
                  required: "Deskripsi harus di isi"
          },
          twitter: {
                  required: "Twitter harus di isi"
          },
          facebook: {
                  required: "Facebook harus di isi"
          },
          instagram: {
                  required: "Instagram harus di isi"
          },
          email: {
                  required: "Email harus di isi",
                  email: "Masukkan alamat email yang valid",
          }
      },
      submitHandler: function(form) {
        $("#tambahButton").prop('disabled', true);
            form.submit();
      }
  });

  $("#editWebForm").validate({
      ignore: [],
      rules: {
          edit_name:{
              required: true,
          },
          edit_description:{
              required: true,
          },
          edit_twitter: {
              required: true,
          },
          edit_facebook: {
              required: true,
          },
          edit_instagram: {
              required: true,
          },
          edit_email: {
              required: true,
              email: true,
          }
      },
      messages: {
          edit_name: {
                required: "Nama harus di isi"
          },
          edit_description: {
                required: "Deskripsi harus di isi"
          },
          edit_twitter: {
                required: "Twitter harus di isi"
          },
          edit_facebook: {
                required: "Facebook harus di isi"
          },
          edit_instagram: {
                required: "Instagram harus di isi"
          },
          edit_email: {
                required: "Email harus di isi",
                email: "Masukkan alamat email yang valid"
          }
      },
      submitHandler: function(form) {
        $("#editButton").prop('disabled', true);
            form.submit();
      }
    });
});

$("#hapusButton").click(function() {
  $("#hapusButton").prop('disabled', true);
  $("#hapusForm").submit();
});
</script>


@endsection