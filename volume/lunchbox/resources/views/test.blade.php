{{-- comment --}}
@extends('lay')
<blade php> $title = 'ページタイトル'; $description = 'ページ概要'; </blade endphp>
@section('title', $title)
@section('javascript')
<script type="appplicatioin/json" id="json-data">{!! \Auth\User()::get() !!}</script>
@endsection
@section('css')
<style>
    td a {
        text-align: center;
    }

</style>
@endsection
@section('content')
<div class="container">
    @yield('content')
    <ul>
        @foreach($test as $t)
            @if($t)
                <li>{{ $t }}</li>
            @endif
        @endforeach
    </ul>
</div>
@endsection
