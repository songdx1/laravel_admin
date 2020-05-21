<span class="pull-left">
总共{{$lists->total()}}条
</span>
<span class="pull-right">
    @php
        $paginator = $lists;
    @endphp
    <ul class="pagination pagination-sm no-margin pull-right">
        <!-- Previous Page Link -->
        @if ($paginator->onFirstPage())
        <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
        @else
        <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        <!-- Pagination Elements -->
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <?php
            $half_total_links = floor(7 / 2);
            $from = $paginator->currentPage() - $half_total_links;
            $to = $paginator->currentPage() + $half_total_links;
            if ($paginator->currentPage() < $half_total_links) {
                $to += $half_total_links - $paginator->currentPage();
            }
            if ($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
                $from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
            }
            ?>
            @if ($from < $i && $i < $to)
                <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                    <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </li>
            @endif
        @endfor

        <!-- Next Page Link -->
        @if ($paginator->hasMorePages())
        <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
        <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
        @endif
    </ul>
</span>
<label class="control-label pull-right">
    <small>显示</small>
    @php
    $per_page = (int)request()->get('per_page');
    @endphp
    <select class="input-sm grid-per-pager" name="per-page">
        <option value="{{$lists->path()}}?per_page=10" {{ $per_page == 10 ? 'selected' : '' }} >10</option>
        <option value="{{$lists->path()}}?per_page=20" {{ $per_page == 20 ? 'selected' : '' }} >20</option>
        <option value="{{$lists->path()}}?per_page=30" {{ $per_page == 30 ? 'selected' : '' }} >30</option>
        <option value="{{$lists->path()}}?per_page=50" {{ $per_page == 50 ? 'selected' : '' }} >50</option>
        <option value="{{$lists->path()}}?per_page=100" {{ $per_page == 100 ? 'selected' : '' }} >100</option>
    </select>
    <small>条</small>
</label>
<script>
    $('.grid-per-pager').on("change", function(e) {
        $.pjax({url: this.value, container: '#pjax-container'});
    });
</script>