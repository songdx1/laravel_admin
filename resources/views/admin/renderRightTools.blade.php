@if(isset($actions['create']))
<div class="btn-group pull-right grid-create-btn" style="margin-right: 10px">
    <a href="{!! $lists->path() !!}/create" class="btn btn-sm btn-success" title="新增">
        <i class="fa fa-plus"></i><span class="hidden-xs">&nbsp;&nbsp;新增</span>
    </a>
</div>
@endif
<!-- Split dropright button -->
<div class="btn-group">
    <a href="{!! $lists->path() !!}?_export_=all" target="_blank" class="btn btn-sm btn-secondary" title="导出"><i class="fa fa-download"></i><span class="hidden-xs"> 导出</span></a>
    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="sr-only">Toggle Dropright</span>
    </button>
    <div class="dropdown-menu">
        <!-- Dropdown menu links -->
        <a class="dropdown-item" href="{!! $lists->path() !!}?_export_=all" target="_blank">全部</a>
        <a class="dropdown-item" href="{!! $lists->path() !!}?_export_=page%3A1" target="_blank">当前页</a>
    </div>
</div>