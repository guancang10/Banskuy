@extends('layouts.app')

@section('styles')
    <style>
        a.profile-link {
            color: black;
            font-size: 20px;
        }

        a.profile-link:hover {
            color: white;
        }

        li.nav-item a.active {
            border-left: 10px solid black;
            color: white;
        }

        .file-upload {
            background-color: #ffffff;
            width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .file-upload-btn {
            width: 100%;
            margin: 0;
            color: #fff;
            background: #AC8FFF;
            border: none;
            padding: 10px;
            border-radius: 4px;
            border-bottom: 4px solid #AC8FFF;
            transition: all .2s ease;
            outline: none;
            text-transform: uppercase;
            font-weight: 700;
        }

        .file-upload-btn:hover {
            background: #d0c1fa;
            color: #ffffff;
            transition: all .2s ease;
            cursor: pointer;
        }

        .file-upload-btn:active {
            border: 0;
            transition: all .2s ease;
        }

        .file-upload-content {
            display: none;
            text-align: center;
        }

        .file-upload-input {
            position: absolute;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            outline: none;
            opacity: 0;
            cursor: pointer;
        }

        .image-upload-wrap {
            margin-top: 20px;
            border: 4px dashed #AC8FFF;
            position: relative;
        }

        .image-dropping,
        .image-upload-wrap:hover {
            background-color: #d0c1fa;
            border: 4px dashed #ffffff;
        }

        .image-title-wrap {
            padding: 0 15px 15px 15px;
            color: #222;
        }

        .drag-text {
            text-align: center;
        }

        .drag-text h3 {
            font-weight: 100;
            text-transform: uppercase;
            padding: 60px 0;
        }

        .file-upload-image {
            max-height: 200px;
            max-width: 200px;
            margin: auto;
            padding: 20px;
        }

        .remove-image {
            width: 200px;
            margin: 0;
            color: #fff;
            background: #cd4535;
            border: none;
            padding: 10px;
            border-radius: 4px;
            border-bottom: 4px solid #b02818;
            transition: all .2s ease;
            outline: none;
            text-transform: uppercase;
            font-weight: 700;
        }

        .remove-image:hover {
            background: #c13b2a;
            color: #ffffff;
            transition: all .2s ease;
            cursor: pointer;
        }

        .remove-image:active {
            border: 0;
            transition: all .2s ease;
        }

        #buttonShowEdit {
            display: none;
        }

        #edit-navbar {
            display: block;
        }

        @media (max-width: 767px) {
            #buttonShowEdit {
                display: block;
            }

            #edit-navbar {
                position: absolute;
                z-index: 2;
                display: none;
            }
        }

        @media (min-width: 767px) {
            #edit-navbar {
                display: block;
            }
        }

    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-4 p-0" style="width: 100vp;background-color: #AC8FFF;" id="edit-navbar">
                @include('Shared._sidebar-edit')

            </div>
            <button class="btn btn-secondary col-1 align-self-start px-1 py-3" id="buttonShowEdit" type="button">
                <span>&#9776;</span>
            </button>
            <div class="tab-content col-md-8 my-3" id="myTabContent">
                <div class="tab-pane fade show active" id="editprofile" role="tabpanel" aria-labelledby="editprofile-tab">
                    @include('Profile.Misc.component-form-editprofile', ['user' => $user])
                </div>
                <div class="tab-pane fade" id="changepassword" role="tabpanel" aria-labelledby="changepassword-tab">
                    @include('Profile.Misc.component-form-changepassword')
                </div>
                <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
                    @include('Profile.Misc.component-view-keamanan')
                </div>
                <div class="tab-pane fade" id="email" role="tabpanel" aria-labelledby="email-tab">
                    @include('Profile.Misc.component-view-email')
                </div>
                <div class="tab-pane fade" id="about" role="tabpanel" aria-labelledby="about-tab">
                    @include('Profile.Misc.component-view-tentang')
                </div>
                <div class="tab-pane fade" id="Help" role="tabpanel" aria-labelledby="Help-tab">
                    @include('Profile.Misc.component-view-bantuan')
                </div>
                <div class="tab-pane fade" id="leveltracking" role="tabpanel" aria-labelledby="leveltracking-tab">
                    <div class="container">
                        @include('Profile.Misc.component-list-leveltracking')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="form-file" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Upload Profile Photo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" method="POST" action="/UpdateProfilePicture">
                        @csrf
                        @method('POST')
                        <div class="file-upload">
                            <input type="hidden" name="UserID" value="{{ Crypt::encrypt($user->UserID) }}">
                            <button class="file-upload-btn" type="button"
                                onclick="$('.file-upload-input').trigger( 'click' )">Tambah Foto</button>

                            <div class="image-upload-wrap">
                                <input class="file-upload-input" type='file' onchange="readURL(this);" accept="image/*"
                                    name="ProfilePicture" />
                                <div class="drag-text">
                                    <h3>Pratinjau Foto</h3>
                                </div>
                            </div>
                            <div class="file-upload-content">
                                <img class="file-upload-image" src="#" alt="your image" />
                                <div class="image-title-wrap">
                                    <button type="button" onclick="removeUpload()" class="remove-image">Hapus <span
                                            class="image-title">Foto</span></button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn-banskuy text-white">Unggah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="form-delete-file" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Delete Profile Photo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form method="POST" action="/deleteprofilephoto">
                        @csrf
                        @method('DELETE')
                        <div class="form-row">
                            <label>Anda yakin ingin menghapus Foto ?</label>
                            <input type="hidden" name="UserID" value="{{ Crypt::encrypt($user->UserID) }}">
                        </div>
                        <div class="form-row">
                            <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger text-white">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $("ul#editTab li.nav-item a.nav-link").on('click', function() {
                $("#edit-navbar").css("display","");
            });
            $("#buttonShowEdit").on('click', function() {
                $("#edit-navbar").show();
            });
            var passwordError = <?php echo ($errors->any() && $errors->has('NewPassword')) || $errors->has('OldPassword') ? json_encode($errors) : '""'; ?>;
            if (passwordError) $("#changepassword-tab").click();
            var user;
            banskuy.getReq('/getprofile/' + <?php echo '"' . Crypt::encrypt($user->UserID) . '"'; ?>)
                .then(function(data) {
                    user = data.payload;
                })
                .finally(function() {
                    banskuy.getReq('/getprovince')
                        .then(function(data) {
                            var optionProvince = document.getElementById("Province");
                            let newOption = new Option('', '');
                            optionProvince.add(newOption, undefined);
                            data.msg.forEach(element => {
                                let newOption = new Option(element.ProvinceName,
                                    element.ProvinceID);
                                optionProvince.add(newOption, undefined);
                            });
                            if (user.address) {
                                $(optionProvince).val(user.address.ProvinceID);
                            }
                            if ($(optionProvince).val()) {
                                $("#City").prop("disabled", false);
                                $("#City").empty();
                                banskuy.getReq('/getcity/' + $(optionProvince).val())
                                    .then(function(data) {
                                        var optionCity = document.getElementById(
                                            "City");
                                        let newOption = new Option('', '');
                                        optionCity.add(newOption, undefined);
                                        data.msg.forEach(element => {
                                            let newOption = new Option(
                                                element
                                                .CityName, element
                                                .CityID);
                                            optionCity.add(newOption,
                                                undefined);
                                        });
                                        if (user.address) {
                                            $(optionCity).val(user.address.CityID);
                                        }
                                    })
                            } else {
                                $("#City").prop("disabled", true);
                            }
                            $(optionProvince).on('change', function() {
                                if ($(this).val()) {
                                    $("#City").prop("disabled", false);
                                    $("#City").empty();
                                    banskuy.getReq('/getcity/' + $(this).val())
                                        .then(function(data) {
                                            var optionCity = document
                                                .getElementById(
                                                    "City");
                                            let newOption = new Option(
                                                '', '');
                                            optionCity.add(newOption,
                                                undefined);
                                            data.msg.forEach(
                                                element => {
                                                    let newOption =
                                                        new Option(
                                                            element
                                                            .CityName,
                                                            element
                                                            .CityID
                                                        );
                                                    optionCity.add(
                                                        newOption,
                                                        undefined
                                                    );
                                                });
                                            if (user.address) {
                                                $(optionCity).val(user
                                                    .address.CityID);
                                                // console.log(option);
                                            }
                                        })
                                } else {
                                    $("#City").prop("disabled", true);
                                    $("#City").empty();
                                }
                            });
                        })
                });
            $("#editphoto").on('click', function() {
                event.preventDefault();
                $("#form-file").modal();
            });
            $("#deletephoto").on('click', function() {
                event.preventDefault();
                $("#form-delete-file").modal();
            });
            user = '';
        });

        function readURL(input) {
            if (input.files && input.files[0]) {

                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.image-upload-wrap').hide();

                    $('.file-upload-image').attr('src', e.target.result);
                    $('.file-upload-content').show();

                    $('.image-title').html(input.files[0].name);
                };

                reader.readAsDataURL(input.files[0]);

            } else {
                removeUpload();
            }
        }

        function removeUpload() {
            $('.file-upload-input').replaceWith($('.file-upload-input').clone());
            $('.file-upload-content').hide();
            $('.image-upload-wrap').show();
        }
        $('.image-upload-wrap').bind('dragover', function() {
            $('.image-upload-wrap').addClass('image-dropping');
        });
        $('.image-upload-wrap').bind('dragleave', function() {
            $('.image-upload-wrap').removeClass('image-dropping');
        });
    </script>
@endsection
