@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Create Fp Izin</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'fpIzins.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('fp_izin.fields')
                </div>

            </div>

            <div class="card-footer">
                <a href="{{ route('fpIzins.index') }}" class="btn btn-default">Cancel</a>
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
