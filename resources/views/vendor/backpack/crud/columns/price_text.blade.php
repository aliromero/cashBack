{{-- regular object attribute --}}

<?php

$takhfif =  ($entry->getDisType() == "percent") ? $entry->price - ($entry->price * $entry->discount / 100)  : $entry->price - $entry->discount; ?>
<td>
    @if($entry->discount > 0)<strike>{{ $entry->price }}</strike>@endif
 {{ $takhfif . " تومان" }}</td>