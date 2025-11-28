@extends('layouts.app')
@section('title', 'Menu del Restaurante')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Menu del Restaurante') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <pre>
                        {{var_dump($categories)}}
                    </pre>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
