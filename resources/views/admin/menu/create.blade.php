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
    <form method="POST" action="http://laravel.cc/admin/auth/menu" class="form-horizontal" accept-charset="UTF-8" pjax-container="1">  

    <div class="box-body">
        <div class="fields-group">
            <div class="col-md-12">

                <div class="form-group  ">
                    <label for="parent_id" class="col-sm-2 control-label">父级菜单</label>
                    <div class="col-sm-8"> 
                        <select class="form-control parent_id select2-hidden-accessible" style="width: 100%;" name="parent_id" data-value="" tabindex="-1" aria-hidden="true">
                            @foreach($menuOptions as $select => $option)
                                <option value="{{$select}}">{{$option}}</option>
                            @endforeach
                        </select>                 
                    </div>
                </div>                

                <div class="form-group  ">
                    <label for="title" class="col-sm-2 asterisk control-label">标题</label>
                    <div class="col-sm-8">                        
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>                            
                            <input type="text" id="title" name="title" value="" class="form-control name" placeholder="输入 标题">                            
                        </div>                        
                    </div>
                </div>

                <div class="form-group  ">
                    <label for="icon" class="col-sm-2 asterisk control-label">图标</label>
                    <div class="col-sm-8">        
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>            
                            <input type="text" id="icon" name="icon" value="icon" class="form-control slug" placeholder="输入 图标">            
                        </div>        
                    </div>
                </div>

                <div class="form-group  ">
                    <label for="username" class="col-sm-2 control-label">路径</label>
                    <div class="col-sm-8">        
                        <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>            
                            <input type="text" id="uri" name="uri" value="" class="form-control uri" placeholder="输入 路径">            
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
$(".parent_id").select2({"allowClear":true,"placeholder":{"id":"","text":"父级菜单"}});
</script>


