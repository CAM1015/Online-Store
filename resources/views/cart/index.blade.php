@extends('layouts.app')

@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])

@section('content')
<div class="card">
  <div class="card-header">
    {{ __('messages.products_in_cart') }}
  </div>
  <div class="card-body">

    <!-- Mensaje de error si el saldo es insuficiente -->
    @if(session('error'))
    <div class="alert alert-danger">
      {{ session('error') }}
    </div>
    @endif

    <table class="table table-bordered table-striped text-center">
      <thead>
        <tr>
          <th scope="col">{{ __('messages.id') }}</th>
          <th scope="col">{{ __('messages.name') }}</th>
          <th scope="col">{{ __('messages.price') }}</th>
          <th scope="col">{{ __('messages.quantity') }}</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($viewData["products"] as $cartItem) <!-- Aquí cambiamos para usar CartItem -->
        <tr>
          <td>{{ $cartItem->product->id }}</td> <!-- Accedemos a las propiedades del producto -->
          <td>{{ $cartItem->product->name }}</td>
          <td>${{ $cartItem->product->price }}</td>
          <td>{{ $cartItem->quantity }}</td> <!-- Usamos la cantidad directamente de CartItem -->
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="row">
      <div class="text-end">
        <a class="btn btn-outline-secondary mb-2"><b>{{ __('messages.total_to_pay') }}:</b> ${{ $viewData["total"] }}</a>
        @if (count($viewData["products"]) > 0)
        <a href="{{ route('cart.purchase') }}" class="btn bg-primary text-white mb-2">{{ __('messages.purchase') }}</a>
        <a href="{{ route('cart.delete') }}">
          <button class="btn btn-danger mb-2">
            {{ __('messages.remove_all_from_cart') }}
          </button>
        </a>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
