<script src="/vendor/laravel-admin/AdminLTE/plugins/select2/select2.full.min.js"></script>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">创建</h3>

        <div class="box-tools">
            {!! $renderList !!}
        </div>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    {!! $form->open(['class' => "form-horizontal"]) !!}

    @php
    extract($image)
    @endphp

    <div class="box-body">
        <div class="fields-group">
            <div class="col-md-12">

                <div class="form-group  ">
                    <label for="username" class="col-sm-2 asterisk control-label">用户名</label>
                    <div class="col-sm-8">        
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>            
                            <input type="text" id="username" name="username" value="" class="form-control username" placeholder="输入 用户名">            
                        </div>        
                    </div>
                </div>

                <div class="form-group  ">
                    <label for="name" class="col-sm-2 asterisk control-label">名称</label>
                    <div class="col-sm-8">                        
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>                            
                            <input type="text" id="name" name="name" value="" class="form-control name" placeholder="输入 名称">                            
                        </div>                        
                    </div>
                </div>
                
                @include('admin::form.file')

                <div class="form-group  ">
                    <label for="password" class="col-sm-2 asterisk control-label">密码</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-eye-slash fa-fw"></i></span>                            
                            <input type="password" id="password" name="password" value="" class="form-control password" placeholder="输入 密码">
                        </div>
                    </div>
                </div>

                <div class="form-group  ">
                    <label for="password_confirmation" class="col-sm-2 asterisk control-label">确认密码</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-eye-slash fa-fw"></i></span>
                            <input type="password" id="password_confirmation" name="password_confirmation" value="" class="form-control password_confirmation" placeholder="输入 确认密码">
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
                        <input type="hidden" name="roles[]" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="permissions" class="col-sm-2 control-label">角色</label>
                    <div class="col-sm-8">
                        <select class="form-control permissions" style="width: 100%;" name="permissions[]" multiple="multiple" data-placeholder="输入 权限" aria-hidden = "true" >
                            @foreach($permissions as $select => $option)
                                <option value="{{$select}}" >{{$option}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="permissions[]" />
                    </div>
                </div>

            </div>            
        </div>
    </div>
    <!-- /.box-body -->

    {!! $form->renderFooter() !!}

    @foreach($form->getHiddenFields() as $field)
        {!! $field->render() !!}
    @endforeach

<!-- /.box-footer -->
    {!! $form->close() !!}
</div>
<script>
$(".roles").select2({"allowClear":true,"placeholder":{"id":"","text":"角色"}});
$(".permissions").select2({"allowClear":true,"placeholder":{"id":"","text":"权限"}});
</script>

