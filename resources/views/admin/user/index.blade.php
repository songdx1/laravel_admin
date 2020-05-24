<div class="box">

    <div class="box-header with-border">
        <div class="pull-left">
            @include('admin::renderHeaderTools')
        </div>
        <div class="pull-right">
            @include('admin::renderRightTools',['actions'=>['create'=>1]])
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
                                        <input type="number" class="form-control" placeholder="ID" name="id" value="{{ request()->get('id') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"> 用户名</label>
                                <div class="col-sm-8">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-addon">
                                        <i class="fa fa-pencil"></i>
                                        </div>
                                        <input type="text" class="form-control" placeholder="用户名" name="username" value="{{ request()->get('username') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"> 名称</label>
                                <div class="col-sm-8">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-addon">
                                            <i class="fa fa-pencil"></i>
                                        </div>
                                        <input type="text" class="form-control" placeholder="名称" name="name" value="{{ request()->get('name') }}">
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
                    <th>ID</th>
                    <th>用户名</th>
                    <th>名称</th>
                    <th>角色</th>
                    <th>创建时间</th>
                    <th>更新时间</th>
                    <th class="column-__actions__">操作</th>
                </tr>
            </thead>

            <tbody>

                @foreach($lists as $list)
                <tr>
                    <td>
                        {{ $list->id }}
                    </td>
                    <td>
                        {{ $list->username }}
                    </td>
                    <td>
                        {{ $list->name }}
                    </td>
                    <td>
                        @foreach($list->roles as $key => $value)
                            <span class="label label-success">{{ $value->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        {{ $list->created_at }}
                    </td>
                    <td>
                        {{ $list->updated_at }}
                    </td>
                    <td class="column-__actions__">
                        @if($list->id != 1)
                        <a href="{{ route('admin.auth.users.show',$list) }}" class="grid-row-view">
                            <i class="fa fa-eye"></i>
                        </a>
                        @endif
                        <a href="{{ route('admin.auth.users.edit',$list) }}" class="grid-row-edit">
                            <i class="fa fa-edit"></i>
                        </a>
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

</script>
