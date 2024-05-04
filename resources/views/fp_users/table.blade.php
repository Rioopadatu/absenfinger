<div class="table-responsive">
    <table class="table" id="fpUsers-table">
        <thead>
            <tr>
                <th>Userid</th>
                <th>ID</th>
        <th>Name</th>
        <th>Role</th>
        <th>Password</th>
        <th>Cardno</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($fpUsers as $fpUser)
            <tr>
                <td>{{ $fpUser->userid }}</td>
                <td>{{ $fpUser->id }}</td>
            <td>{{ $fpUser->name }}</td>
            <td>{{ $fpUser->role }}</td>
            <td>{{ $fpUser->password }}</td>
            <td>{{ $fpUser->cardno }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['fpUsers.destroy', $fpUser->uid], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('fpUsers.show', [$fpUser->uid]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('fpUsers.edit', [$fpUser->uid]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
