@foreach (session('flash_notification', collect())->toArray() as $message)
    @if ($message['overlay'])
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'],
            'body'       => $message['message']
        ])
    @else
        <div class="alert bg-{{ $message['level'] }} alert-styled-left">
            <button type="button" class="close" data-dismiss="alert">
                <span>×</span><span class="sr-only">Fechar</span>
            </button>
            {!! $message['message'] !!}
        </div>
    @endif
@endforeach

{{ session()->forget('flash_notification') }}