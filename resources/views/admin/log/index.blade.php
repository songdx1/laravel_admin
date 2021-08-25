<link rel="stylesheet" href="/vendor/icheck/skins/all.css">
<script src="/vendor/icheck/icheck.min.js"></script>
<div class="box">

    <div class="box-header with-border">
        <div class="float-left">
            @include('admin::renderHeaderTools',['batchActions'=>['delete'=>1]])
        </div>
        <div class="float-right">
            @include('admin::renderRightTools')
        </div>        
    </div>

    <div class="card card-info collapse  hide" id="filter-box">
        <form action="{!! $lists->path() !!}" class="form-horizontal" pjax-container method="get">
            <div class="card-body">           
                <div class="input-group">
                    <label class="col-sm-2 control-label"> ID</label>
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-edit"></i></span>
                    </div>
                    <input type="number" class="form-control" placeholder="ID"  name="id" value="{{ request()->get('id') }}">
                </div>
                <div class="input-group">
                    <label class="col-sm-2 control-label"> 用户</label>
                    <select class="form-control" name="user_id" >
                        <option>选择用户</option>
                        @foreach($users as $select => $option)
                            <option value="{{$select}}" {{ (string)$select === request()->get('user_id') ?'selected':'' }}>{{$option}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group">
                    <label class="col-sm-2 control-label"> 请求动作</label>
                    <select class="form-control" name="method" >
                        <option>选择请求动作</option>
                        @foreach($methods as $select => $option)
                            <option value="{{$select}}" {{ (string)$select === request()->get('method') ?'selected':'' }}>{{$option}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group">
                    <label class="col-sm-2 control-label"> 请求路径</label>
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-edit"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="请求路径"  name="path" value="{{ request()->get('path') }}">
                </div>
                <div class="input-group">
                    <label class="col-sm-2 control-label"> Ip</label>
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-edit"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Ip"  name="ip" value="{{ request()->get('ip') }}">
                </div>
            </div>
            <!-- /.box-body -->

            <div class="card-foote">
                <button class="btn btn-info submit btn-sm">{{ trans('admin.search') }}</button>
                <a href="{!! $lists->path() !!}" class="btn-default float-right">{{ trans('admin.reset') }}</a>
            </div>
 
        </form>
        
    </div>

    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="column-__row_selector__">
                        <input type="checkbox" class="grid-select-all">
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
                        <input type="checkbox" class="grid-row-checkbox" data-id="{{ $list->id }}">                            
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
                        url: '{{$lists->path()}}/' + id,
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

    (function ($){
        $(".user_id").select2({
            placeholder: {"id":"","text":"选择"},
            "allowClear":true
        });
        $(".method").select2({
            placeholder: {"id":"","text":"选择"},
            "allowClear":true
        });
        $('input').iCheck();
    })(jQuery);

</script>
