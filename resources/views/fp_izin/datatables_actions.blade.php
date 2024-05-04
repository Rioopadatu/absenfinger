{!! Form::open(['route' => ['fpIzins.destroy', $uid], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('fpIzins.show', $uid) }}" class='btn btn-default btn-xs'>
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{ route('fpIzins.edit', $uid) }}" class='btn btn-default btn-xs'>
        <i class="fas fa-edit"></i>
    </a>
    {!! Form::button('<i class="fas fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
