@extends('layouts.app')

@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])

@section('content')
<head>
  
    <!-- Metadatos Open Graph -->
    <meta property="og:title" content="{{ $viewData['product']->getName() }}" />
    <meta property="og:description" content="{{ $viewData['product']->getDescription() }}" />
    <meta property="og:image" content="{{ asset('/storage/'.$viewData["product"]->getImage()) }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="product" />
    <meta property="og:site_name" content="Online Store" />

    <!-- Metadatos Twitter Cards -->
    <meta name="twitter:title" content="{{ $viewData['product']->getName() }}" />
    <meta name="twitter:description" content="{{ $viewData['product']->getDescription() }}" />
    <meta name="twitter:image" content="{{ asset('/storage/'.$viewData["product"]->getImage()) }}" />
    <meta name="twitter:card" content="summary_large_image" />
</head>


<div class="card mb-3" style="background-color: #ffffff;">
  <div class="row g-0">
    <div class="col-md-4">
      <img src="{{ asset('/storage/'.$viewData["product"]->getImage()) }}" class="img-fluid rounded-start" alt="{{ $viewData['product']->getName() }}">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title" style="color: #196EA4;">
          {{ $viewData["product"]->getName() }} (${{ $viewData["product"]->getPrice() }})
        </h5>
        <p class="card-text" style="color: #333333;">{{ $viewData["product"]->getDescription() }}</p>

        <!-- Formulario para agregar al carrito -->
        <p class="card-text">
        <form method="POST" action="{{ route('cart.add', ['id'=> $viewData['product']->getId()]) }}">
          <div class="row">
            @csrf
            <div class="col-auto">
              <div class="input-group col-auto">
                <div class="input-group-text" style="background-color: #13DCBE; color: #ffffff;">{{ __('messages.quantity') }}</div>
                <input type="number" min="1" max="10" class="form-control quantity-input" name="quantity" value="1" style="border-color: #13DCBE;">
              </div>
            </div>
            <div class="col-auto">
              <button class="btn" style="background-color: #13DCBE; color: #ffffff;" type="submit">{{ __('messages.add_to_cart') }}</button>
            </div>
          </div>
        </form>
        </p>

        <!-- Mostrar las valoraciones existentes -->
        <h3>{{ __('messages.product_review') }}</h3>
        <ul>
          @foreach($viewData["product"]->reviews as $review)
              <li>
                  <strong>{{ $review->user->name }}</strong> ({{ $review->rating }} {{ __('messages.stars') }})
                  <p>{{ $review->review }}</p>
              </li>
          @endforeach
        </ul>

        <!-- Formulario de valoración (solo para usuarios autenticados) -->
        @auth
          <form action="{{ route('product.review', $viewData['product']->getId()) }}" method="POST">
            @csrf
            <div class="form-group">
              <label for="rating">{{ __('messages.rating') }} (1-5 {{ __('messages.stars') }})</label>
              <div id="star-rating" class="rating">
                <input type="radio" id="star5" name="rating" value="5"><label for="star5" class="bi bi-star-fill"></label>
                <input type="radio" id="star4" name="rating" value="4"><label for="star4" class="bi bi-star-fill"></label>
                <input type="radio" id="star3" name="rating" value="3"><label for="star3" class="bi bi-star-fill"></label>
                <input type="radio" id="star2" name="rating" value="2"><label for="star2" class="bi bi-star-fill"></label>
                <input type="radio" id="star1" name="rating" value="1"><label for="star1" class="bi bi-star-fill"></label>
              </div>
            </div>

            <div class="form-group mt-2">
              <label for="review">{{ __('messages.comment') }} ({{ __('messages.optional') }})</label>
              <textarea name="review" id="review" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-primary mt-2">{{ __('messages.send_review') }}</button>
          </form>
        @else
          <p>{{ __('messages.log_in_to_rate') }} <a href="{{ route('login') }}">{{ __('messages.login') }}</a></p>
        @endauth

        <!-- Botones para compartir en redes sociales -->
        <div class="social-share-buttons mt-4">
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-primary">
                <i class="bi bi-facebook"></i> {{ __('messages.share_on_facebook') }}
            </a>
            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($viewData['product']->getName()) }}" target="_blank" class="btn btn-info">
                <i class="bi bi-twitter"></i> {{ __('messages.share_on_twitter') }}
            </a>
            <a href="https://wa.me/?text={{ urlencode($viewData['product']->getName()) }}%20{{ urlencode(url()->current()) }}" target="_blank" class="btn btn-success">
                <i class="bi bi-whatsapp"></i> {{ __('messages.share_on_whatsapp') }}
            </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
