@if(Admin::user()->visible(\Illuminate\Support\Arr::get($item, 'roles', [])) && Admin::user()->can(\Illuminate\Support\Arr::get($item, 'permission')))
    @if(!isset($item['children']))
        <li class="nav-item">
            <a href="{{ admin_url($item['uri']) }}" class="nav-link">
                <i class="far nav-icon fa {{$item['icon']}}"></i>
                <p>{{ admin_trans($item['title']) }}</p>
            </a>
        </li>
    @else
        <li class="nav-item menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa {{ $item['icon'] }}"></i>
              <p>
              {{ admin_trans($item['title']) }}
              <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                @foreach($item['children'] as $item)
                    @include('admin::partials.menu', $item)
                @endforeach
            </ul>
        </li>
    @endif
@endif