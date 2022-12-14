@foreach ($user->UserLevel as $level)
    <div class="row py-3">
        <div class="col-md-3 text-center">
            <img src="{{ env('FTP_URL') }}{{ $level->LevelGrade ? 'assets/' . $level->LevelGrade->Path : 'assets/Smiley.png' }}"
                alt="UsernamePhotoProfile"
                style="border-radius: 50%; border: 1px solid black; width: 17vw; height: 17vw;"
                onerror="this.onerror==null;this.src='{{ env('FTP_URL') }}assets/Smiley.png'">
        </div>
        <div class="col-md-9 pl-4">
            <div class="row pt-5">
                <h3>{{ $level->LevelGrade->LevelName }}
                    <small style="display: inline-block; vertical-align: top; color: #2f9194;">
                        <?php 
                                    $order = $level->LevelGrade->LevelOrder;
                                    for ($i=0; $i < $order; $i++) {?>
                        *
                        <?php } ?></small>
                </h3>
            </div>
            <div class="row">
                <div class="d-flex flex-column">
                    <?php
                    $time = strtotime($level->ReceivedDate);
                    
                    $newformat = date('M d, Y', $time);
                    ?>
                    <p>Tanggal Diterima: {{ $newformat }}</p>
                    @if ($level->IsCurrentLevel && $level->GradeLevelID != '4')
                        <p>Pengalaman sampai level selanjutnya:
                            {{ $level->Level->where('LevelID', $level->LevelID)->first()->Exp }}/<span
                                id="nextlevelxp"></span> XP</p>
                        <p>Level selanjutnya: <span id="nextlevelname" class="py-1 px-3"
                                style="background-color: #AC8FFF; border-radius: 20px;"></span></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach
