<!-- Userid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('userid', 'Userid:') !!}
    {!! Form::text('userid', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Role Field -->
<div class="form-group col-sm-6">
    {!! Form::label('role', 'Role:') !!}
    {!! Form::number('role', null, ['class' => 'form-control']) !!}
</div>

<!-- Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', 'Password:') !!}
    {!! Form::password('password', ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Cardno Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cardno', 'Cardno:') !!}
    {!! Form::text('cardno', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>