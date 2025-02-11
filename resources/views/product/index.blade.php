@extends('layouts.app')
@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])

@section('content')

<!-- Menú desplegable de categorías -->
<div class="mb-4">
  <label for="categorySelect" class="form-label">{{ __('messages.filter_by_category') }}</label>
  <form id="categoryForm" method="GET" action="{{ route('product.index') }}">
    <select id="categorySelect" class="form-select" name="category" onchange="document.getElementById('categoryForm').submit()">
      <option value="all" {{ request('category') ? '' : 'selected' }}>{{ __('messages.view_all') }}</option>
      @foreach ($viewData["categories"] as $category)
        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
          {{ __('messages.category_' . strtolower($category)) }}
        </option>
      @endforeach
    </select>
  </form>
</div>

<div class="row" id="product-list">
  @foreach ($viewData["products"] as $product)
  <div class="col-md-4 col-lg-3 mb-2" id="product-{{ $product->getId() }}">
    <div class="card border-light" style="background-color: #ffffff;">
      <img src="{{ asset('/storage/'.$product->getImage()) }}" class="card-img-top img-card" alt="{{ $product->getName() }}">
      <div class="card-body text-center">
        <a href="{{ route('product.show', ['id'=> $product->getId()]) }}"
           class="btn" style="background-color: #13DCBE; color: #ffffff;">{{ $product->getName() }}</a>
      </div>
    </div>
  </div>
  @endforeach
</div>

<!-- Spinner de carga, inicialmente oculto -->
<div id="loading" class="text-center my-3" style="display: none;">
  <i class="fa fa-spinner fa-spin" style="color: #13DCBE;"></i> {{ __('messages.loading_more_products') }}
</div>

@endsection

@section('scripts')
<script>
  let page = 2;

  function loadMoreProducts(page) {
    document.getElementById('loading').style.display = 'block';

    fetch(`/load-more-products?page=${page}`)
      .then(response => response.json())
      .then(data => {
        document.getElementById('loading').style.display = 'none';

        if (data.length > 0) {
          let productList = document.getElementById('product-list');
          
          data.forEach(product => {
            const productCard = `
              <div class="col-md-4 col-lg-3 mb-2" id="product-${product.id}">
                <div class="card border-light" style="background-color: #ffffff;">
                  <img src="/storage/${product.image}" class="card-img-top img-card" alt="${product.name}">
                  <div class="card-body text-center">
                    <a href="/products/${product.id}" class="btn" style="background-color: #13DCBE; color: #ffffff;">${product.name}</a>
                  </div>
                </div>
              </div>
            `;
            productList.insertAdjacentHTML('beforeend', productCard);
          });

          page++;
        } else {
          document.getElementById('loading').innerHTML = '{{ __('messages.no_more_products') }}';
        }
      })
      .catch(error => {
        console.error('Error loading more products:', error);
        document.getElementById('loading').style.display = 'none';
      });
  }

  window.addEventListener('scroll', function() {
    if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
      loadMoreProducts(page);
    }
  });
</script>
@endsection
