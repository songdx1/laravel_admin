<link rel="stylesheet" href="/vendor/laravel-admin/AdminLTE/plugins/iCheck/all.css">
<script src="/vendor/laravel-admin/AdminLTE/plugins/iCheck/icheck.min.js"></script>
<script src="/vendor/laravel-admin/AdminLTE/plugins/select2/select2.full.min.js"></script>
<div class="box">
    @if(isset($title))
    <div class="box-header with-border">
        <h3 class="box-title"> {{ $title }}</h3>
    </div>
    @endif

    <div class="box-header with-border">
        <div class="pull-left">
            @include('admin::renderHeaderTools')
        </div>
        <div class="pull-right">
            {!! $grid->renderColumnSelector() !!}
            {!! $grid->renderExportButton() !!}
            {!! $grid->renderCreateButton() !!}
        </div>        
    </div>

    <div class="box-header with-border hide" id="filter-box">
        <form action="{!! $lists->path() !!}" class="form-horizontal" pjax-container method="get">
            <div class="row">
                <div class="col-md-12">
                    <div class="box-body">
                        <div class="fields-group">
                            <div class="form-group">
                                <label class="col-sm-2 control-label"> ID</label>
                                <div class="col-sm-8">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-addon">
                                            <i class="fa fa-pencil"></i>
                                        </div>
                                        <input type="text" class="form-control id" placeholder="ID" name="id" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"> 用户</label>
                                <div class="col-sm-8">
                                <select class="form-control user_id" name="user_id" style="width: 100%;">
                                    <option></option>
                                    @foreach($users as $select => $option)
                                        <option value="{{$select}}" {{ (string)$select === request()->get('user_id') ?'selected':'' }}>{{$option}}</option>
                                    @endforeach
                                </select>                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"> 请求动作</label>
                                <div class="col-sm-8">
                                <select class="form-control method" name="method" style="width: 100%;">
                                    <option></option>
                                    @foreach($methods as $select => $option)
                                        <option value="{{$select}}" {{ (string)$select === request()->get('method') ?'selected':'' }}>{{$option}}</option>
                                    @endforeach
                                </select>                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"> 请求路径</label>
                                <div class="col-sm-8">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-addon">
                                        <i class="fa fa-pencil"></i>
                                        </div>
                                        <input type="text" class="form-control path" placeholder="请求路径" name="path" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"> Ip</label>
                                <div class="col-sm-8">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-addon">
                                            <i class="fa fa-pencil"></i>
                                        </div>
                                        <input type="text" class="form-control ip" placeholder="Ip" name="ip" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <div class="btn-group pull-left">
                                <button class="btn btn-info submit btn-sm"><i class="fa fa-search"></i>&nbsp;&nbsp;{{ trans('admin.search') }}</button>
                            </div>
                            <div class="btn-group pull-left " style="margin-left: 10px;">
                                <a href="{!! $lists->path() !!}" class="btn btn-default btn-sm"><i class="fa fa-undo"></i>&nbsp;&nbsp;{{ trans('admin.reset') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
    </div>

    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="column-__row_selector__">
                        <div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
                            <input type="checkbox" class="grid-select-all">
                        </div>
                    </th>
                    <th class="column-id">ID</th>
                    <th class="column-user-name">用户</th>
                    <th class="column-method">请求动作</th>
                    <th class="column-path">请求路径</th>
                    <th class="column-ip">Ip</th>
                    <th class="column-input">输入</th>
                    <th class="column-created_at">创建时间</th>
                    <th class="column-__actions__">操作</th>
                </tr>
            </thead>

            <tbody>

                @foreach($lists as $list)
                <tr>
                    <td class="column-__row_selector__">
                        <div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
                            <input type="checkbox" class="grid-row-checkbox" data-id="{{ $list->id }}">                            
                        </div>
                    </td>
                    <td>
                        {{ $list->id }}
                    </td>
                    <td>
                        {{ $list->user->name }}
                    </td>
                    <td>
                        @php
                        $color = Arr::get($methodColors, $list->method, 'grey');
                        @endphp
                        <span class="badge bg-{!!$color!!}">{{ $list->method }}</span>
                    </td>
                    <td>
                        <span class="label label-info">{{ $list->path }}</span>
                    </td>
                    <td>
                        <span class="label label-primary">{{ $list->ip }}</span>
                    </td>
                    <td>
                        @php
                        $input = json_decode($list->input, true);
                        $input = Arr::except($input, ['_pjax', '_token', '_method', '_previous_']);
                        if (empty($input)) {
                            $input = '<code>{}</code>';
                        }else{
                            $input = '<pre>'.json_encode($input, JSON_PRETTY_PRINT | JSON_HEX_TAG).'</pre>';
                        }
                        @endphp
                        {!! $input !!}
                    </td>
                    <td>
                        {{ $list->created_at }}
                    </td>
                    <td class="column-__actions__">
                        <a href="javascript:void(0);" data-id="{{ $list->id }}" class="grid-row-delete">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>

    <div class="box-footer clearfix">
        @include('admin::paginator')
    </div>
    
    <!-- /.box-body -->
</div>
<script>
$(function () {
    $('.grid-select-all').iCheck({checkboxClass:'icheckbox_minimal-blue'}).on('ifChanged', function () { 
        if (this.checked) {
            $.admin.grid.select();
            $('input.grid-row-checkbox').attr('checked',true);
            $('div.icheckbox_minimal-blue').addClass('checked',true);
            $('div.icheckbox_minimal-blue').attr('aria-disabled',true);
            var selected = $('input.grid-row-checkbox').length;  
            $('.grid-select-all-btn').show();
            $('.grid-select-all-btn .selected').html("已选择 {n} 项".replace('{n}', selected));
        } else {
            $.admin.grid.unselect();
            $('input.grid-row-checkbox').attr('checked',false)
            $('div.icheckbox_minimal-blue').removeClass('checked',false);
            $('div.icheckbox_minimal-blue').attr('aria-disabled',false);
            $('.grid-select-all-btn').hide();
        }
    });

    $('.grid-row-checkbox').iCheck({checkboxClass:'icheckbox_minimal-blue'}).on('ifChanged', function () {    
        var id = $(this).data('id');
        if (this.checked) {
            $.admin.grid.select(id);
            $(this).closest('tr').css('background-color', '#ffffd5');
        } else {
            $.admin.grid.unselect(id);
            $(this).closest('tr').css('background-color', '');
        }
    }).on('ifClicked', function () {        
        var id = $(this).data('id');        
        if (this.checked) {
            $.admin.grid.unselect(id);
        } else {
            $.admin.grid.select(id);
        }        
        var selected = $.admin.grid.selected().length;        
        if (selected > 0) {
            $('.grid-select-all-btn').show();
        } else {
            $('.grid-select-all-btn').hide();
        }        
        $('.grid-select-all-btn .selected').html("已选择 {n} 项".replace('{n}', selected));
    });

    $('.grid-row-delete').unbind('click').click(function() {
        var id = $(this).data('id');
        swal({
            title: "确认删除?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确认",
            showLoaderOnConfirm: true,
            cancelButtonText: "取消",
            preConfirm: function() {
                return new Promise(function(resolve) {
                    $.ajax({
                        method: 'post',
                        url: '{!! route('admin.auth.logs.index') !!}/' + id,
                        data: {
                            _method:'delete',
                            _token:LA.token,
                        },
                        success: function (data) {
                            $.pjax.reload('#pjax-container');

                            resolve(data);
                        }
                    });
                });
            }
        }).then(function(result) {
            var data = result.value;
            if (typeof data === 'object') {
                if (data.status) {
                    swal(data.message, '', 'success');
                } else {
                    swal(data.message, '', 'error');
                }
            }
        });
    });

});

    (function ($){
        $(".user_id").select2({
            placeholder: {"id":"","text":"选择"},
            "allowClear":true
        });
        $(".method").select2({
            placeholder: {"id":"","text":"选择"},
            "allowClear":true
        });
    })(jQuery);

</script>
