<div class="category-container">
    <ul>
        <li class="nav-item {{ request()->routeIs('home.index') ? 'active' : '' }}">
            <a href="{{ route('home.index') }}">Todo</a>
        </li>


        @foreach ($navbar as $category)
        {{-- se evitan los ataques XSS --}}
            <li class="nav-item {{ Request::is('categorys/'.$category->slug) ? 'active' : '' }}">
                <a href="{{ route('categories.detail', $category->slug) }}">{{ $category->name }}</a>
            </li>
        @endforeach


        <li class="nav-item {{ request()->routeIs('home.all') ? 'active' : '' }}">
            <a href="{{ route('home.all') }}">Todas las categorias</a>
        </li>

    </ul>
</div>