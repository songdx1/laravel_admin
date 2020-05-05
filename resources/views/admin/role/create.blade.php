<script src="/vendor/laravel-admin/AdminLTE/plugins/select2/select2.full.min.js"></script>
<script src="/vendor/laravel-admin/bootstrap-duallistbox/dist/jquery.bootstrap-duallistbox.min.js"></script>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">创建</h3>

        <div class="box-tools">
            {!! $tools !!}
        </div>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    {!! $form->open(['class' => "form-horizontal"]) !!}  

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
                
                <div class="form-group">
                    <label for="permissions" class="col-sm-2 control-label">权限</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="bootstrap-duallistbox-nonselected-list_permissions[]" style="width: 100%;" name="permissions[]" multiple="multiple" data-placeholder="输入 权限" data-value >
                            @foreach($permissions as $select => $option)
                                <option value="{{$select}}">{{$option}}</option>
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
$(".permissions").bootstrapDualListbox({
    "infoText":"总共 {0} 项",
    "infoTextEmpty":"空列表",
    "infoTextFiltered":"{0} / {1}",
    "filterTextClear":"显示全部",
    "filterPlaceHolder":"过滤",
    "selectorMinimalHeight":200
});
</script>

