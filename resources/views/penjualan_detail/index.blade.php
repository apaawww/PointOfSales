<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transaksi</title>
</head>
<body>
    @extends('layouts.master')

@section('title')
    <b> Transaksi Penjualan</b>
@endsection

@push('css')
<style>
    .tampil-bayar {
        font-size: 5em;
        text-align: center;
        height: 100px;
    }

    .tampil-terbilang {
        padding: 10px;
        background: #f0f0f0;
    }

    .table-penjualan tbody tr:last-child {
        display: none;
    }

    @media(max-width: 768px) {
        .tampil-bayar {
            font-size: 3em;
            height: 70px;
            padding-top: 5px;
        }
    }
</style>
@endpush

@section('breadcrumb')
    @parent
    <li class="active">Transaksi Penjualan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-body">
                    
                <form class="form-produk">
                    @csrf
                    <div class="form-group row">
                        <label for="kode_produk" class="col-lg-2">Kode Produk</label>
                        <div class="col-lg-5">
                            <div class="input-group">
                                <input type="hidden" name="id_penjualan" id="id_penjualan" value="{{ $id_penjualan }}">
                                <input type="hidden" name="id_produk" id="id_produk">
                                <input type="text" class="form-control" name="kode_produk" id="kode_produk">
                                <span class="input-group-btn">
                                    <button onclick="tampilProduk()" class="btn btn-flat btn-info" type="button"><i class="fa fa-arrow-right"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </form>

                <table class="table table-striped table-bordered table-penjualan">
                    <thead>
                        <th width="5%">No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th width="15%">Jumlah</th>
                        <th>Diskon</th>
                        <th>Subtotal</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="tampil-bayar bg-primary"></div>
                        <div class="tampil-terbilang"></div>
                    </div>
                    <div class="col-lg-4">
                        <form action="{{ route('transaksi.simpan') }}" class="form-penjualan" method="post">
                            @csrf
                            <input type="hidden" name="id_penjualan" value="{{ $id_penjualan }}">
                            <input type="hidden" name="total" id="total">
                            <input type="hidden" name="total_item" id="total_item">
                            <input type="hidden" name="bayar" id="bayar">
                            <input type="hidden" name="id_member" id="id_member" value="{{ $memberSelected->id_member }}">

                            <div class="form-group row">
                                <label for="totalrp" class="col-lg-2 control-label">Total</label>
                                <div class="col-lg-8">
                                    <input type="text" id="totalrp" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kode_member" class="col-lg-2 control-label">Member</label>
                                <div class="col-lg-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="kode_member" value="{{ $memberSelected->kode_member }}">
                                        <span class="input-group-btn">
                                            <button onclick="tampilMember()" class="btn btn-flat btn-info" type="button"><i class="fa fa-arrow-right"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="diskon" class="col-lg-2 control-label">Diskon</label>
                                <div class="col-lg-8">
                                    <input type="number" name="diskon" id="diskon" class="form-control" 
                                        value="{{ ! empty($memberSelected->id_member) ? $diskon : 0 }}" 
                                        readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bayar" class="col-lg-2 control-label">Bayar</label>
                                <div class="col-lg-8">
                                    <input type="text" id="bayarrp" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="diterima" class="col-lg-2 control-label">Diterima</label>
                                <div class="col-lg-8">
                                    <input type="text" id="diterima" class="form-control" name="diterima">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kembali" class="col-lg-2 control-label">Kembali</label>
                                <div class="col-lg-8">
                                    <input type="text" id="kembali" name="kembali" class="form-control" value="" readonly>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right btn-simpan"><i class="fa fa-floppy-o"></i> Simpan Transaksi</button>
            </div>
        </div>
    </div>
</div>

@includeIf('penjualan_detail.produk')
@includeIf('penjualan_detail.member')
@endsection

@push('scripts')
<script>
    let table, table2;

    $(function () {
        $('body').addClass('sidebar-collapse');

        table = $('.table-penjualan').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('transaksi.data', $id_penjualan) }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'harga_jual'},
                {data: 'jumlah'},
                {data: 'diskon'},
                {data: 'subtotal'},
                {data: 'aksi', searchable: false, sortable: false},
            ],
            dom: 'Brt',
            bSort: false,
            paginate: false
        })
        .on('draw.dt', function () {
            loadForm($('#diskon').val());
            setTimeout(() => {
                $('#diterima').trigger('input');
            }, 300);
        });
        table2 = $('.table-produk').DataTable();

        $(document).on('input', '.quantity', function () {
            let id = $(this).data('id');
            let jumlah = parseInt($(this).val());

            if (jumlah < 1) {
                $(this).val(1);
                alert('Jumlah tidak boleh kurang dari 1');
                return;
            }
            if (jumlah > 10000) {
                $(this).val(10000);
                alert('Jumlah tidak boleh lebih dari 10000');
                return;
            }

            $.post(`{{ url('/transaksi') }}/${id}`, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'put',
                    'jumlah': jumlah
                })
                .done(response => {
                    $(this).on('mouseout', function () {
                        table.ajax.reload(() => loadForm($('#diskon').val()));
                    });
                })
                .fail(errors => {
                    alert('Tidak dapat menyimpan data');
                    return;
                });
        });
        
        $(document).on('input', '#diskon', function () {
            if ($(this).val() == "") {
                $(this).val(0).select();
            }

            loadForm($(this).val());
        });


        $(document).on('input', '#diterima', function () {
            var inputValue = $(this).val().replace(/\D/g, '');
            if (inputValue === "") {
                inputValue = 0;
            }
            $(this).val(formatRupiah(inputValue));
            calculateChange();
        }).focus(function () {
            $(this).select();
        });
        $('.btn-simpan').on('click', function () {
            var total = parseFloat($('#total').val().replace(/\D/g, ''));
            var diterima = parseFloat($('#diterima').val().replace(/\D/g, ''));
            var diskon = parseFloat($('#diskon').val());

            var totalSetelahDiskon = total - (total * diskon / 100);

            var kembali = diterima - totalSetelahDiskon;

            if (kembali < 0) {
                alert('Uang yang diterima kurang dari total !');
            } else {
                $('.form-penjualan').submit();
            }
        });

        
        // $('.btn-simpan').on('click', function () {
        //     $('.form-penjualan').submit();
        // });
    });

    function tampilProduk() {
        $('#modal-produk').modal('show');
    }
    
    function hideProduk() {
        $('#modal-produk').modal('hide');
    }

    function pilihProduk(id, kode) {
        $('#id_produk').val(id);
        $('#kode_produk').val(kode);
        hideProduk();
        tambahProduk();
    }

    function tambahProduk() {
        $.post('{{ route('transaksi.store') }}', $('.form-produk').serialize())
            .done(response => {
                $('#kode_produk').focus();
                table.ajax.reload(() => loadForm($('#diskon').val()));
            })
            .fail(errors => {
                alert('Tidak dapat menyimpan data');
                return;
            });
    }

    function tampilMember() {
        $('#modal-member').modal('show');
    }
    
    function pilihMember(id, kode) {
        $('#id_member').val(id);
        $('#kode_member').val(kode);
        $('#diskon').val('{{ $diskon }}');
        loadForm($('#diskon').val());
        $('#diterima').val(0).focus().select();
        hideMember();
    }
    
    function hideMember() {
        $('#modal-member').modal('hide');
    }
    
    function deleteData(url) {
        if (confirm('Yakin ingin menghapus data terpilih?')) {
            $.post(url, {
                '_token': $('[name=csrf-token]').attr('content'),
                '_method': 'delete'
                })
                .done((response) => {
                    table.ajax.reload(() => loadForm($('#diskon').val()));
                })
                .fail((errors) => {
                    alert('Tidak dapat menghapus data');
                    return;
                });
            }
    }
    
    function loadForm(diskon = 0 , diterima = 0) {
    $('#total').val($('.total').text());
        $('#total_item').val($('.total_item').text());

        $.get(`{{ url('/transaksi/loadform') }}/${diskon}/${$('.total').text()}/${diterima}`)
        .done(response => {
            $('#totalrp').val('Rp. '+ response.totalrp);
            $('#bayarrp').val(' '+ response.bayarrp);
            $('#bayar').val(response.bayar);

            $('.tampil-bayar').text('Bayar: '+ response.bayarrp);
            $('.tampil-terbilang').text(response.terbilang);

            $('#kembali').val('Rp. '+ response.kembalirp);
            if ($('#diterima').val() > 0) {
                $('.tampil-bayar').text('Kembali: '+ response.kembalirp);
                $('.tampil-terbilang').text(response.kembali_terbilang);
            }

        }).fail(errors => {
            alert('Tidak dapat menampilkan data');
            return;
        })           
    }
    function formatRupiah(angka) {
        angka = angka.toString();
        var number_string = angka.replace(/Rp\.|\s/g, ''),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        return 'Rp. ' + rupiah;
    }


    function calculateChange() {
        var total = parseFloat($('#total').val().replace(/\D/g, '')); 
        var diterima = parseFloat($('#diterima').val().replace(/\D/g, '')); 
        var diskon = parseFloat($('#diskon').val());

        var totalSetelahDiskon = total - (total * diskon / 100);

        var kembali = diterima - totalSetelahDiskon;
        


        if (isNaN(kembali) || kembali <= 0) {
        $('#kembali').val('Rp. 0');
        $('.tampil-bayar').text('Bayar: ' + formatRupiah(diterima));
        $('.tampil-terbilang').text('');
        } else {
            $('#kembali').val(formatRupiah(kembali.toFixed(2))); 
            $('.tampil-bayar').text('Kembali: ' + formatRupiah(kembali.toFixed(2)));
            $('.tampil-terbilang').text(terbilang(kembali));
        }
    }
    calculateChange();

    

    function updateFormattedRupiah() {
        var diterimaInput = document.getElementById('diterima');
        var formattedRupiah = formatRupiah(diterimaInput.value);
        diterimaInput.value = formattedRupiah;
    }

    var diterimaInput = document.getElementById('diterima');
    diterimaInput.addEventListener('input', function () {
        var inputValue = parseFloat($(this).val().replace(/\D/g, '')); 
        if (isNaN(inputValue)) {
            inputValue = 0;
        }
        $(this).val(formatRupiah(inputValue)); 
        calculateChange();
    });
    updateFormattedRupiah();

    
    



</script>
@endpush
    
</body>
</html>