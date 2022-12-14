<div class="row">
    <div class="col">
        <h2>Sunting Profil</h2>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-2 col-md-3 text-center px-0">
            <img src="{{ env('FTP_URL') }}{{ $user->Photo ? 'ProfilePicture/Donatur/' . $user->Photo->Path : 'assets/Smiley.png' }}"
                alt="UsernamePhotoProfile"
                style="border-radius: 50%; border: 1px solid black; width: 130px; height: 130px;"
                onerror="this.onerror==null;this.src='{{ env('FTP_URL') }}assets/Smiley.png'">
            <p {{ $user->Photo ? ($user->Photo->Path && $user->Photo->Path != '' ? 'style="font-size: 15px;"' : '') : '' }}><a
                    href="" id="editphoto">Sunting Foto</a>
                @if ($user->Photo && $user->Photo->Path && $user->Photo->Path != '') | <a href="" id="deletephoto">Hapus Foto</a></p> @endif
        </div>
        <div class="col-sm-9 col-md-9 mt-4">
            <h2>{{ $user->Username ? $user->Username : '-' }}</h2>
        </div>
    </div>
    <form id='formupdateprofile' action="/updateprofile" method="POST">
        @csrf
        @method("PUT")
        <input type="hidden" name="UserID" value="{{ Crypt::encrypt($user->UserID) }}">
        <div class="form-row py-1">
            <div class="col-md-2">
                <label for="FirstName">Nama Depan<span class="text-danger">*</span></label>
            </div>
            <div class="col-md-6">
                <input type="text" name="FirstName" id="FirstName"
                    value="{{ old('FirstName') ? old('FirstName') : $user->FirstName }}"
                    class="form-control @error('FirstName') is-invalid @enderror" required>
                @error('FirstName')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-row py-1">
            <div class="col-md-2">
                <label for="LastName">Nama Belakang<span class="text-danger">*</span></label>
            </div>
            <div class="col-md-6">
                <input type="text" name="LastName" id="LastName"
                    value="{{ old('LastName') ? old('LastName') : $user->LastName }}"
                    class="form-control @error('LastName') is-invalid @enderror" required>
                @error('LastName')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-row py-1">
            <div class="col-md-2">
                <label for="Username">Nama Pengguna<span class="text-danger">*</span></label>
            </div>
            <div class="col-md-6">
                <input type="text" name="Username" id="Username"
                    value="{{ old('Username') ? old('Username') : $user->Username }}"
                    class="form-control @error('Username') is-invalid @enderror" required>
                @error('Username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-row py-1">
            <div class="col-md-2">
                <label for="Email">Email<span class="text-danger">*</span></label>
            </div>
            <div class="col-md-6">
                <input type="email" name="Email" id="Email" value="{{ old('Email') ? old('Email') : $user->Email }}"
                    class="form-control  @error('Email') is-invalid @enderror" required>
                @error('Email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-row py-1">
            <div class="col-md-2">
                <label for="PhoneNumber">Nomor Telephone<span class="text-danger">*</span></label>
            </div>
            <div class="col-md-6">
                <input type="tel" name="PhoneNumber" id="PhoneNumber"
                    value="{{ old('PhoneNumber') ? old('PhoneNumber') : $user->PhoneNumber }}"
                    class="form-control @error('PhoneNumber') is-invalid @enderror" required>
                @error('PhoneNumber')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-row py-1">
            <div class="col-md-2">
                <label for="Gender">Jenis Kelamin<span class="text-danger">*</span></label>
            </div>
            <div class="col-md-6">
                <div class="form-check form-check-inline">
                    <input class="form-check-input"
                        {{ old('Gender') ? (old('Gender') == 'Male' ? 'checked' : '') : ($user->Gender == 'Male' ? 'checked' : '') }}
                        type="radio" name="Gender" id="Gender" value="Male">
                    <label class="form-check-label" for="Male">Laki-laki</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="Gender"
                        {{ old('Gender') ? (old('Gender') == 'Female' ? 'checked' : '') : ($user->Gender == 'Female' ? 'checked' : '') }}
                        id="Gender" value="Female">
                    <label class="form-check-label" for="Female">Perempuan</label>
                </div>
                @error('Gender')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-row py-1">
            <div class="col-md-2">
                <label for="Address">Alamat<span class="text-danger">*</span></label>
            </div>
            <div class="col-md-6">
                {{-- {{dd($user)}} --}}
                <textarea name="Address" id="Address" class="form-control"
                    style="resize: none; @error('Address') is-invalid @enderror"
                    required>{{ old('Address') ? old('Address') : ($user->Address ? $user->Address->Address : '') }}</textarea>
                @error('Address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-row py-1">
            <div class="col-md-2">
                <label for="Country">Negara<span class="text-danger">*</span></label>
            </div>
            <div class="col-md-6">
                <select name="Country" id="Country" class="form-control @error('Country') is-invalid @enderror"
                    required>
                    <option value="1" selected>Indonesia</option>
                </select>
                @error('Country')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-row py-1">
            <div class="col-md-2">
                <label for="Province">Provinsi<span class="text-danger">*</span></label>
            </div>
            <div class="col-md-6">
                <select name="Province" id="Province" class="form-control @error('Province') is-invalid @enderror"
                    required></select>
            </div>
            @error('Province')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-row py-1">
            <div class="col-md-2">
                <label for="City">Kota<span class="text-danger">*</span></label>
            </div>
            <div class="col-md-6">
                <select name="City" id="City" class="form-control @error('City') is-invalid @enderror"
                    required></select>
            </div>
            @error('City')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-6 pr-2">
                <button type="submit" class="float-right py-1 px-5"
                    style="border-radius: 20px; background-color: #AC8FFF; border: none;">Simpan</button>
            </div>
        </div>
    </form>
</div>
