<!-- Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id', 'Id:') !!}
    {!! Form::select('id', $fpUsers,null, ['class' => 'form-control']) !!}
</div>

<!-- Timestamp Field -->
<div class="form-group col-sm-6">
    {!! Form::label('timestamp', 'Timestamp:') !!}
    {!! Form::text('timestamp', null, ['class' => 'form-control','id'=>'timestamp']) !!}
</div>

{!! Form::hidden('mesin', 'mesin2') !!}


@push('page_scripts')
    <script type="text/javascript">
        $('#timestamp').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type', 'Type:') !!}
    {!! Form::number('type', 0, ['class' => 'form-control']) !!}
</div>
