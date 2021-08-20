<div class="box">

    <div class="box-header with-border">
        <div class="float-left">
            @include('admin::renderHeaderTools')
        </div>
        <div class="float-right">
            @include('admin::renderRightTools',['actions'=>['create'=>1]])
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
                    <label class="col-sm-2 control-label"> 标识</label>
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-edit"></i></span>
                    </div>
                    <input type="number" class="form-control" placeholder="标识" name="slug" value="{{ request()->get('slug') }}">
                </div>
                <div class="input-group">
                    <label class="col-sm-2 control-label"> 名称</label>
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-edit"></i></span>
                    </div>
                    <input type="number" class="form-control" placeholder="名称" name="name" value="{{ request()->get('name') }}">
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
                    <th>ID</th>
                    <th>标识</th>
                    <th>名称</th>
                    <th>权限</th>
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
                        {{ $list->slug }}
                    </td>
                    <td>
                        {{ $list->name }}
                    </td>
                    <td>
                        @foreach($list->permissions as $key => $value)
                            <span class="btn btn-default">{{ $value->name }}</span>
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
                        <a href="{{ route('admin.auth.roles.show',$list) }}" class="grid-row-view">
                            <i class="fa fa-eye"></i>
                        </a>
                        @endif
                        <a href="{{ route('admin.auth.roles.edit',$list) }}" class="grid-row-edit">
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
