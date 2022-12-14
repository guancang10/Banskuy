<script type="text/template" id="component-list-donation">
    <div class="d-flex justify-content-center mb-3">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header <%=data.headerColor%>">
                    <div class="row">
                        <div class="col-md-8 <%=data.headerTextColor%>">
                            <%=data.transactionDate%>
                        </div>
                        <div class="col-md-3">
                            <button
                                class="btn <%=data.statusColor%> float-right"><%=data.status%></button>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
                <div class="card-body row ">
                    <div class="col-md-2 text-center">
                        <img src="{{ env('FTP_URL') }}{{ 'assets/Smiley.png' }}" alt="UsernamePhotoProfile"
                            style="border-radius: 50%; border: 1px solid black; width: 70px; height: 70px;"
                            onerror="this.onerror==null;this.src='{{ env('FTP_URL') }}assets/Smiley.png'">
                    </div>
                    <div class="col-md-7">
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label for="">Judul Donasi</label>
                            </div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-7">
                                <p class="card-text">
                                    <%=data.donationTitle%>
                                </p>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label for="">Tipe Donasi</label>
                            </div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-7">
                                <p class="card-text">
                                    <%=data.donationType%>
                                </p>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label for="">Nama Yayasan</label>
                            </div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-7">
                                <p class="card-text">
                                    <%=data.foundationName%>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="buttonhistorydetail">
                            <button type="button" id="btnHistoryDetail" data-id="<%=data.transactionID%>" class="historydetail_button">
                                {{ __('Detail Transaksi') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</script>
