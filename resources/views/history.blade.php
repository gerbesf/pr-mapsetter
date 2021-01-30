<table class="table" style="width: 100%">
    @foreach($list as $item)
        <tr>
            <td>{{ $item->name }}</td>
            <td>{{ $item->map_key }}</td>
            <td>{{ $item->map_mode }}</td>
            <td>{{ $item->map_size }}</td>
            <td>{{ $item->timestamp }}</td>
        </tr>
    @endforeach
</table>
