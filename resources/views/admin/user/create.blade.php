<script src="/vendor/bootstrap-fileinput/js/fileinput.min.js"></script>
<script src="/vendor/bootstrap-fileinput/js/locales/zh.js"></script>
<div class="box box-info">
    <div class="row">
        <h3 class="col-sm-6 box-title">创建</h3>
        <div class="col-sm-6 text-right">
            {!! $tools !!}
        </div>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form action="{!! route('admin.auth.users.index') !!}" method="post" accept-charset="UTF-8" class="form-horizontal" pjax-container="">   

    <div class="card-body row">
        <div class="col-sm-2  control-label"></div>
        <div class="col-sm-8">

            <div class="input-group mb-3">
                <label for="username" class="col-sm-2 asterisk control-label">用户名</label>
                <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-edit"></i></span>        
                </div>        
                <input type="text" id="username" name="username" value="" required class="form-control username" placeholder="输入 用户名">            
            </div>

            <div class="input-group mb-3">
                <label for="name" class="col-sm-2 asterisk control-label">名称</label>
                <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-edit"></i></span>                     
                </div>                        
                <input type="text" id="name" name="name" value="" required class="form-control name" placeholder="输入 名称">                            
            </div>
            
            <div class="input-group mb-3">
                <label for="avatar" class="col-sm-2  control-label">头像</label>
                <div class="col-sm-8">
                    <input type="file" class="avatar" name="avatar" >
                </div>
            </div>

            <div class="input-group mb-3">
                <label for="password" class="col-sm-2 asterisk control-label">密码</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-eye-slash fa-fw"></i></span>                           
                </div>
                <input type="password" id="password" name="password" value="" required class="form-control password" placeholder="输入 密码">
            </div>

            <div class="input-group mb-3">
                <label for="password_confirmation" class="col-sm-2 asterisk control-label">确认密码</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-eye-slash fa-fw"></i></span> 
                </div>
                <input type="password" id="password_confirmation" required name="password_confirmation" value="" class="form-control password_confirmation" placeholder="输入 确认密码">
            </div>

            <div class="input-group mb-3">
                <label for="roles" class="col-sm-2 control-label">角色</label>
                <div class="col-sm-10">
                    <select class="form-control roles" style="width: 100%;" name="roles[]" multiple="multiple" data-placeholder="输入 角色" aria-hidden = "true" >
                        @foreach($roles as $select => $option)
                            <option value="{{$select}}" >{{$option}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="input-group mb-3">
                <label for="permissions" class="col-sm-2 control-label">权限</label>
                <div class="col-sm-10">
                    <select class="form-control permissions" style="width: 100%;" name="permissions[]" multiple="multiple" data-placeholder="输入 权限" aria-hidden = "true" >
                        @foreach($permissions as $select => $option)
                            <option value="{{$select}}" >{{$option}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>            
    </div>
    <!-- /.box-body -->

    @include('admin::formFooter')

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
    'language': 'zh',
});
</script>

