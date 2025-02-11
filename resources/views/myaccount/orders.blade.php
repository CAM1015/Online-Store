@extends('layouts.app')
@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])
@section('content')
@forelse ($viewData["orders"] as $order)
<div class="card mb-4">
  <div class="card-header">
    {{ __('messages.order') }} #{{ $order->getId() }}
  </div>
  <div class="card-body">
    <b>{{ __('messages.date') }}:</b> {{ $order->getCreatedAt() }}<br />
    <b>{{ __('messages.total') }}:</b> ${{ $order->getTotal() }}<br />
    <table class="table table-bordered table-striped text-center mt-3">
      <thead>
        <tr>
          <th scope="col">{{ __('messages.item_id') }}</th>
          <th scope="col">{{ __('messages.product_name') }}</th>
          <th scope="col">{{ __('messages.price') }}</th>
          <th scope="col">{{ __('messages.quantity') }}</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($order->getItems() as $item)
        <tr>
          <td>{{ $item->getId() }}</td>
          <td>
            <a class="link-success" href="{{ route('product.show', ['id'=> $item->getProduct()->getId()]) }}">
              {{ $item->getProduct()->getName() }}
            </a>
          </td>
          <td>${{ $item->getPrice() }}</td>
          <td>{{ $item->getQuantity() }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@empty
<div class="alert alert-danger" role="alert">
  {{ __('messages.no_purchases') }}
</div>
@endforelse
@endsection
