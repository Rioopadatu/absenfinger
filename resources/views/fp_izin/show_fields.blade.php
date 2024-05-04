<div class="form-group col-sm-6">
    {!! Form::label('fp_user_id', 'Pilih Karyawan:') !!}
    <p>{{ $fpIzin->fp_user->name }}</p>
</div>


<!-- Tanggal Mulai Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tanggal_mulai', 'Tanggal Mulai:') !!}
    <p>{{ $tanggal_mulai }}</p>

</div>

<!-- Tangga Berakhir Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tanggal_berakhir', 'Tanggal Berakhir:') !!}
    <p>{{ $tanggal_berakhir }}</p>
</div>

<!-- Tanggal Mulai Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id', 'Keterangan:') !!}
    <p>{{ $fpIzin->keterangan }}</p>
</div>
<!-- Tanggal Mulai Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id', 'status:') !!}
    @if ($fpIzin->status == null)
        <p>Menunggu</p>
    @elseif ($fpIzin->status == 1)
        <p>Di Terima</p>
    @elseif ($fpIzin->status == 2)
        <p>Di Tolak</p>
        @else
        <p>Tidak Di Termukan</p>
    @endif

</div>
