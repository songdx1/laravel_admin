<div class="btn-group pull-right" style="margin-right: 10px">
    <a href="{!! $lists->path() !!}?_export_=all" target="_blank" class="btn btn-sm btn-twitter" title="导出"><i class="fa fa-download"></i><span class="hidden-xs"> 导出</span></a>
    <button type="button" class="btn btn-sm btn-twitter dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="{!! $lists->path() !!}?_export_=all" target="_blank">全部</a></li>
        <li><a href="{!! $lists->path() !!}?_export_=page%3A1" target="_blank">当前页</a></li>
    </ul>
</div>
@if(isset($actions['create']))
<div class="btn-group pull-right grid-create-btn" style="margin-right: 10px">
    <a href="{!! $lists->path() !!}/create" class="btn btn-sm btn-success" title="新增">
        <i class="fa fa-plus"></i><span class="hidden-xs">&nbsp;&nbsp;新增</span>
    </a>
</div>
@endif