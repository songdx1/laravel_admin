<script src="/vendor/bootstrap-fileinput/js/fileinput.min.js"></script>
<script src="/vendor/bootstrap-fileinput/js/locales/zh.js"></script>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">编辑</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form action="/admin/auth/setting" method="post" accept-charset="UTF-8" class="form-horizontal" pjax-container="">

    <div class="card-body row">
        <div class="col-sm-2  control-label"></div>
        <div class="col-sm-8">

            <div class="input-group mb-3">
                <label class="col-sm-2 control-label"> 用户名</label>
                <div class="input-group-prepend">
                    {{ $model->username }}
                </div>
            </div>

            <div class="input-group mb-3">
                <label class="col-sm-2 control-label"> 名称</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-edit"></i></span>
                </div>
                <input type="text" id="name" name="name" value="{{ $model->name }}" class="form-control" placeholder="输入名称">  
            </div>
            
            <div class="input-group mb-3">
                <label for="avatar" class="col-sm-2  control-label">头像</label>
                <div class="col-sm-8">
                    <input type="file" class="avatar" name="avatar" >
                </div>
            </div>

            <div class="input-group mb-3">
                <label for="password" class="col-sm-2 control-label">密码</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-eye-slash fa-fw"></i></span>                            
                </div>
                <input type="password" id="password" name="password" value="" class="form-control password" placeholder="输入密码">
            </div>
            <div class="input-group mb-3">
                <label for="password_confirmation" class="col-sm-2 control-label">确认密码</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-eye-slash fa-fw"></i></span>
                </div>
                <input type="password" id="password_confirmation" name="password_confirmation" value="" class="form-control password_confirmation" placeholder="输入确认密码">
            </div>
            @method('PUT')
        </div>            
    </div>
    <!-- /.box-body -->    

    @include('admin::formFooter')

<!-- /.box-footer -->
    </form>
</div>
<script>
$("input.avatar").fileinput({
    'language': 'zh',
    "overwriteInitial":false,
    initialPreviewAsData: true,
    initialPreview: [
        '{{ $model->avatar }}',
    ],
    "fileActionSettings":{"showRemove":false,"showDrag":false}
});
</script>

