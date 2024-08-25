<nav class="navbar navbar-expand-sm navbar-white bg-white">
    <div class="container">
        <a class="navbar-brand" href="{{ route('products.index') }}"><i class="fas fa-shop"></i></a>
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId"
            aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                @can('viewAny', App\Models\Sale::class)
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('sales') ? 'active' : '' }}"
                            href="{{ route('sales.index') }}">Vendas</a>
                    </li>
                @endcan

                @can('viewAny', App\Models\Product::class)
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('products') ? 'active' : '' }}"
                            href="{{ route('products.index') }}">Produtos</a>
                    </li>
                @endcan
                @can('viewAny', App\Models\Category::class)
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('categories') ? 'active' : '' }}"
                            href="{{ route('categories.index') }}">Categorias</a>
                    </li>
                @endcan
                @if(auth()->user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('users') ? 'active' : '' }}"
                            href="{{ route('users.index') }}">Usuários</a>
                    </li>
                @endif
            </ul>
            <div class="end-menu">
                <ul>
                    @can('create', App\Models\Sale::class)
                        <li class="nav-item btn btn-success mt-2">
                            <a class="nav-link nav-sell-button" href="{{ route('sales.create') }}">
                                <i class="fas fa-cart-shopping"></i> Vender
                            </a>
                        </li>
                    @endcan
                </ul>
                <ul>
                    @if (auth()->user()->role != 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.show', auth()->user()->id) }}">
                                <div class="user-info">
                                    <div class="user-credentials">
                                        <div class="username">
                                            {{ auth()->user()->name }}
                                        </div>
                                        <div class="email">
                                            {{ auth()->user()->email }}
                                        </div>
                                    </div>
                                    <div class="user-icon">
                                        {{ auth()->user()->name[0] }}
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endif

                    <li class="nav-item btn-exit">
                        <a class="nav-link" href="{{ route('logout') }}"><i
                                class="fas fa-right-from-bracket"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
