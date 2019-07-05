@extends('layouts.app')

@section('content')
    <items-shop-component last_page="{{ $paginator->lastPage() }}"></items-shop-component>
@endsection
