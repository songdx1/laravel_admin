<!-- Default box -->
<div class="card">
    <div class="card-header">
    <h3 class="card-title">Available extensions</h3>

    <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
        <i class="fas fa-minus"></i>
        </button>
        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
        <i class="fas fa-times"></i>
        </button>
    </div>
    </div>
    <div class="card-body">
    <ul class="products-list product-list-in-box">
        @foreach($extensions as $extension)
        <li class="item">
            <div class="product-img">
                <i class="{{$extension['icon']}}"></i>
            </div>
            <div class="product-info">
                <a href="{{ $extension['link'] }}" target="_blank" class="product-title">
                    {{ $extension['name'] }}
                </a>
                @if($extension['installed'])
                    <span class="pull-right installed"><i class="fa fa-check"></i></span>
                @endif
            </div>
        </li>
        @endforeach

        <!-- /.item -->
        </ul>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->