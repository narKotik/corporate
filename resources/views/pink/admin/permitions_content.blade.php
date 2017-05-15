<div id="content-page" class="content group">
    <div class="hentry group">
        <h3 class="title_page">Привилегии</h3>
        <form action="{{ route('permitions.store') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="short-table white">
                <table style="width:100%;">
                    <thead>
                        <tr>
                            <th>Привилегии</th>
                            @if(!$roles->isEmpty())
                                @foreach($roles as $role)
                                    <th>{{ $role->name }}</th>
                                @endforeach
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                    @if(!$permitions->isEmpty())
                        @foreach($permitions as $permition)
                            <tr>
                                <td>{{$permition->name}}</td>
                                @foreach($roles as $role)
                                    <td>
                                        <input type="checkbox" value="{{ $permition->id }}" name="{{ $role->id }}[]" {{ $role->hasPermition($permition->name) ? 'checked' : '' }}>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <input type="submit" value="Отправить" class="btn btn-the-salmon-dance-3">
        </form>
    </div>
</div>