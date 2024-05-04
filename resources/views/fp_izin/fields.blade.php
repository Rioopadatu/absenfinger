<div class="form-group col-sm-6">
    {!! Form::label('fp_user_id', 'Nama :') !!}
    <p>{{ $Fpusers->name }}</p>
    <input type="hidden" name="fp_user_uid" value="{{ $Fpusers->uid }}">
</div>


<!-- Tanggal Mulai Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tanggal_mulai', 'Tanggal Mulai:') !!}
    {!! Form::date('tanggal_mulai', $fpIzin->tanggal_mulai ?? null, ['class' => 'form-control', 'id' => 'tanggal_mulai']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('tanggal_berakhir', 'Tanggal Berakhir:') !!}
    {!! Form::date('tanggal_berakhir', $fpIzin->tanggal_berakhir ?? null, ['class' => 'form-control', 'id' => 'tanggal_berakhir']) !!}
</div>


<!-- Tanggal Mulai Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id', 'Keterangan:') !!}
    {!! Form::select('keterangan', ['Pilih Keterangan','sakit' => 'Sakit', 'Izin' => 'Izin', 'Cuti' => 'Cuti'], $fpIzin->keterangan ?? null, ['class' => 'form-control', 'id' => 'keterangan']) !!}
</div>
<!-- Tanggal Mulai Field -->
@if($Fpusers->role == 1)
    <div class="form-group col-sm-6">
        {!! Form::label('id', 'status:') !!}
        {!! Form::select('status', ['Pilih status','0' => 'Menunggu', '1' => 'Disetujui', '2' => 'Di Tolak'], null, ['class' => 'form-control', 'id' => 'keterangan']) !!}
    </div>
@else
    <!-- Render something else if the condition is false or $fpIzin_role is null -->
@endif

@push('page_scripts')
<script type="text/javascript">
        $('#timestamp').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush
