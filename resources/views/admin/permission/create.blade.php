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
    {!! $form->open(['class' => "form-horizontal"]) !!}  

    <div class="box-body">
        <div class="fields-group">
            <div class="col-md-12">                

                <div class="form-group  ">
                    <label for="name" class="col-sm-2 asterisk control-label">名称</label>
                    <div class="col-sm-8">                        
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>                            
                            <input type="text" id="name" name="name" value="" class="form-control name" placeholder="输入 名称">                            
                        </div>                        
                    </div>
                </div>

                <div class="form-group  ">
                    <label for="username" class="col-sm-2 asterisk control-label">标识</label>
                    <div class="col-sm-8">        
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>            
                            <input type="text" id="slug" name="slug" value="" class="form-control slug" placeholder="输入 标识">            
                        </div>        
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="http_method" class="col-sm-2 control-label">HTTP方法</label>
                    <div class="col-sm-8">
                        <select class="form-control http_method" style="width: 100%;" name="http_method[]" multiple="multiple" data-placeholder="HTTP方法" aria-hidden = "true" >
                            @foreach($methods as $select => $option)
                                <option value="{{$select}}" >{{$option}}</option>
                            @endforeach
                        </select>
                        <span class="help-block">
                            <i class="fa fa-info-circle"></i>&nbsp;为空默认为所有方法
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="permissions" class="col-sm-2 control-label">HTTP路径</label>
                    <div class="col-sm-8">        
                        <textarea name="http_path" class="form-control http_path" rows="5" placeholder="输入 HTTP路径"></textarea>        
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
$(".http_method").select2({"allowClear":true,"placeholder":{"id":"","text":"权限"}});
</script>

