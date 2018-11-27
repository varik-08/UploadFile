<table class="table" border="3">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Field</th>
        <th>Count</th>
        <th>Status</th>
    </tr>
    @foreach ($files as $file )
        <tr>
            <td>{{$file->id}}</td>
            <td>@if($file->status == 1) <a href="{{route('top',$file->id)}}">{{$file->fileName}}</a> @else {{$file->fileName}} @endIf</td>
            <td>{{$file->field}}</td>
            <td>{{$file->count}}</td>
            <td>{{$file->status}}</td>
        </tr>
    @endforeach
</table>