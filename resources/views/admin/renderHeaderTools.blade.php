<div class="btn-group grid-select-all-btn" style="margin-right: 5px; display: none;">
    <a class="btn btn-sm btn-default hidden-xs"><span class="selected">已选择 0 项</span></a>
    <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="#" class="grid-batch-0">批量删除 </a></li>
    </ul>
</div>

<div class="btn-group" style="margin-right: 5px" data-toggle="buttons">
    <label class="btn btn-sm btn-dropbox filter-btn" title="筛选">
        <input type="checkbox"><i class="fa fa-filter"></i><span class="hidden-xs">&nbsp;&nbsp;筛选</span>
    </label>
</div>

<script>
    $('.filter-btn').unbind('click');
    $('.filter-btn').click(function (e) {
        if ($('#filter-box').is(':visible')) {
            $('#filter-box').addClass('hide');
        } else {
            $('#filter-box').removeClass('hide');
        }
    });
</script>