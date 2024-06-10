@extends('layouts.master')

@section('content')

<p>ini file demo</p>

@forelse ($getcategory as $rowcategory)

    <td>{{ $rowcategory->id  }}</td>
    <td>{{ $rowcategory->deskripsi  }}</td>
    <td>{{ $rowcategory->kategori  }}</td>
    <br>

@empty

@endforelse

@endsection