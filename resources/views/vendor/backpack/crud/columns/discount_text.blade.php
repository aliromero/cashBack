{{-- regular object attribute --}}


<td>
    @if($entry->getDisType() == "percent") {{ $entry->discount }} درصد @else {{ $entry->discount }} تومان @endif</td>