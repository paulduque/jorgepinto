@foreach ($news as $item)
    @include('news._card', ['item' => $item])
@endforeach
