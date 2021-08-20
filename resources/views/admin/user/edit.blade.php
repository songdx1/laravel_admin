<script src="/vendor/bootstrap-fileinput/js/fileinput.min.js"></script>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">编辑</h3>

        <div class="box-tools">
            {!! $tools !!}
        </div>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form action="{!! route('admin.auth.users.update',$model) !!}" method="post" accept-charset="UTF-8" class="form-horizontal" pjax-container="">

    <div class="card-body row">
        <div class="col-sm-2  control-label"></div>
        <div class="col-sm-8">

                <div class="input-group mb-3">
                <label class="col-sm-2 control-label">用户名</label>
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-edit"></i></span>            
                    </div>       
                    <input type="text" id="username" name="username" value="{{ $model->username }}" class="form-control username" placeholder="输入 用户名">            
                </div>

                <div class="input-group mb-3">
                    <label class="col-sm-2 control-label">名称</label>
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-edit"></i></span>                           
                    </div>       
                    <input type="text" id="name" name="name" value="{{ $model->name }}" class="form-control name" placeholder="输入 名称">                            
                </div>
                
                <div class="input-group mb-3">
                    <label class="col-sm-2 control-label">头像</label>
                    <div class="col-sm-8">
                        <input type="file" class="avatar" name="avatar" >
                    </div>
                </div>

                <div class="input-group mb-3">
                <label class="col-sm-2 control-label">密码</label>
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-eye-slash fa-fw"></i></span>                            
                    </div>
                    <input type="password" id="password" name="password" value="" class="form-control password" placeholder="输入 密码">
                </div>

                <div class="input-group mb-3">
                <label class="col-sm-2 control-label">确认密码</label>
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-eye-slash fa-fw"></i></span>
                    </div>
                    <input type="password" id="password_confirmation" name="password_confirmation" value="" class="form-control password_confirmation" placeholder="输入 确认密码">
                </div>

                <div class="input-group mb-3">
                <label class="col-sm-2 control-label">角色</label>
                    <div class="input-group-prepend col-sm-10">
                        <select multiple class="roles" name="roles[]" style="width: 100%;">
                            @foreach($roles as $select => $option)
                                <option value="{{$select}}" {{  in_array($select, $model->roles()->pluck('id')->toArray() ) ?'selected':'' }}>{{$option}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <label class="col-sm-2 control-label">权限</label>
                    <div class="input-group-prepend col-sm-10">
                        <select multiple class="permissions" name="permissions[]" style="width: 100%;">
                            @foreach($permissions as $select => $option)
                                <option value="{{$select}}" {{  in_array($select, $model->permissions()->pluck('id')->toArray() ) ?'selected':'' }} >{{$option}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <label class="col-sm-2 control-label">创建时间</label>
                    <div class="input-group-prepend">
                        {{ $model->created_at }}
                    </div>
                </div>
                <div class="input-group mb-3">
                    <label class="col-sm-2 control-label">更新时间</label>               
                    <div class="input-group-prepend">
                        {{ $model->updated_at }}
                    </div>
                </div>

            </div>            
        </div>
    </div>
    <!-- /.box-body -->    

    @include('admin::editFormFooter')

<!-- /.box-footer -->
    </form>
</div>
<script>
$(".roles").select2({
    placeholder: "选择角色",
    allowClear: true
});
$(".permissions").select2({
    placeholder: "选择权限",
    allowClear: true
});
$("input.avatar").fileinput({
    "overwriteInitial":false,
    "msgPlaceholder":"选择文件",
    "browseLabel":"浏览",
    initialPreviewAsData: true,
    initialPreview: [
        '{{ $model->avatar }}',
    ],
    "fileActionSettings":{"showRemove":false,"showDrag":false}
});
</script>

