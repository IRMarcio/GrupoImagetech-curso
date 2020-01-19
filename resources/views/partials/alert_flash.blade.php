<div class="alert alert-{{$tipo}} alert-styled-left text-blue-800 content-group">
    <span class="text-semibold">{{ $msg }}</span>
    @if(!isset($close))
        <button type="button" class="close" data-dismiss="alert">×</button>
    @endif
</div>