<div class="modal fade bd-example-modal-lg" id="mdlMakeReport" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content p-4">
            <div class="modal-header">
                <h2 class="modal-title w-100 text-center">Laporkan Yayasan</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mb-1">
                <h3>Apakah anda yakin ingin melaporkan yayasan ini?</h3>
                <div class="mt-4">
                    <form action="/MakeReportUser" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="targetId" name="targetId" value="{{Crypt::encrypt($foundation->FoundationID)}}">
                        <input type="hidden" id="roleId" name="roleId" value="2">
                        <div class="form-group w-100">
                            <div class="mt-2 mr-1">
                                <h5>Tipe Pelanggaran</h5>
                            </div>
                            <select class="form-control" id="ddlReportType" name="ddlReportType">
                            </select>
                        </div>

                        <div class="form-group mt-4">
                            <div>
                                <h5>Detail Laporan</h5>
                            </div>
                            <textarea class="form-control" id="txaReportDesc" name="txaReportDesc" rows="5"></textarea>
                            <div>
                                <h6 class="text-red">*Tolong berikan informasi mengenai pelanggaran yang terjadi</h6>
                            </div>
                        </div>

                        <div class="form-group w-100 mt-3  text-center">
                            <button type="submit" class="btn btn-primary w-75" id="btnSubmit">
                                <h4 class="mt-1">Buat Laporan</h4>
                            </button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>