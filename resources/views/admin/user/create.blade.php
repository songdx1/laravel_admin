<script src="/vendor/laravel-admin/AdminLTE/plugins/select2/select2.full.min.js"></script>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">创建</h3>

        <div class="box-tools">
            {!! $tools !!}
        </div>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form action="{!! route('admin.auth.users.index') !!}" method="post" accept-charset="UTF-8" class="form-horizontal" pjax-container="">   

    <div class="box-body">
        <div class="fields-group">
            <div class="col-md-12">

                <div class="form-group  ">
                    <label for="username" class="col-sm-2 asterisk control-label">用户名</label>
                    <div class="col-sm-8">        
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>            
                            <input type="text" id="username" name="username" value="" required class="form-control username" placeholder="输入 用户名">            
                        </div>        
                    </div>
                </div>

                <div class="form-group  ">
                    <label for="name" class="col-sm-2 asterisk control-label">名称</label>
                    <div class="col-sm-8">                        
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>                            
                            <input type="text" id="name" name="name" value="" required class="form-control name" placeholder="输入 名称">                            
                        </div>                        
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="avatar" class="col-sm-2  control-label">头像</label>
                    <div class="col-sm-8">
                        <input type="file" class="avatar" name="avatar" >
                    </div>
                </div>

                <div class="form-group  ">
                    <label for="password" class="col-sm-2 asterisk control-label">密码</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-eye-slash fa-fw"></i></span>                            
                            <input type="password" id="password" name="password" value="" required class="form-control password" placeholder="输入 密码">
                        </div>
                    </div>
                </div>

                <div class="form-group  ">
                    <label for="password_confirmation" class="col-sm-2 asterisk control-label">确认密码</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-eye-slash fa-fw"></i></span>
                            <input type="password" id="password_confirmation" required name="password_confirmation" value="" class="form-control password_confirmation" placeholder="输入 确认密码">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="roles" class="col-sm-2 control-label">角色</label>
                    <div class="col-sm-8">
                        <select class="form-control roles" style="width: 100%;" name="roles[]" multiple="multiple" data-placeholder="输入 角色" aria-hidden = "true" >
                            @foreach($roles as $select => $option)
                                <option value="{{$select}}" >{{$option}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="permissions" class="col-sm-2 control-label">权限</label>
                    <div class="col-sm-8">
                        <select class="form-control permissions" style="width: 100%;" name="permissions[]" multiple="multiple" data-placeholder="输入 权限" aria-hidden = "true" >
                            @foreach($permissions as $select => $option)
                                <option value="{{$select}}" >{{$option}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>            
        </div>
    </div>
    <!-- /.box-body -->

    <div class="box-footer">
        @csrf
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <div class="btn-group pull-right">
                <button type="submit" class="btn btn-primary">提交</button>
            </div>            
            <div class="btn-group pull-left">
                <button type="reset" class="btn btn-warning">重置</button>
            </div>
        </div>
    </div>

<!-- /.box-footer -->
    </form>
</div>
<script>
$(".roles").select2({"allowClear":true,"placeholder":{"id":"","text":"角色"}});
$(".permissions").select2({"allowClear":true,"placeholder":{"id":"","text":"权限"}});
$("input.avatar").fileinput({"overwriteInitial":false,"msgPlaceholder":"选择文件","initialPreviewAsData":true,"browseLabel":"浏览"});
</script>

