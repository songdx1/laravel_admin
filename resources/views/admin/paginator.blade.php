<style>
    .pagination{
        margin: 0;
    }
</style>
<span class="pull-left">
总共{{$lists->total()}}条
</span>
<span class="pull-right">
    {{ $lists->links() }}    
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