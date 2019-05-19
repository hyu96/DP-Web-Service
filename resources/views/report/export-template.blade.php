<table>
    <tbody>
    @for ($i = 0; $i < $lines; $i++)
        <tr>
            <td>{{ $data['labels'][$i] }}</td>
            <td>{!!  $data['count'][$i] !!} </td>
        </tr>
    @endfor
    </tbody>
</table>