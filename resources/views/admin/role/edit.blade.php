<script src="/vendor/laravel-admin/AdminLTE/plugins/select2/select2.full.min.js"></script>
<script src="/vendor/laravel-admin/bootstrap-duallistbox/dist/jquery.bootstrap-duallistbox.min.js"></script>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">编辑</h3>

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

                <div class="form-group ">
                    <label class="col-sm-2 control-label">ID</label>
                    <div class="col-sm-8">
                        <div class="box box-solid box-default no-margin box-show">
                            <div class="box-body">
                                {{ $model->id }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group  ">
                    <label for="name" class="col-sm-2 asterisk control-label">名称</label>
                    <div class="col-sm-8">                        
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>                            
                            <input type="text" id="name" name="name" value="{{ $model->name }}" class="form-control name" placeholder="输入 名称">                            
                        </div>                        
                    </div>
                </div>

                <div class="form-group  ">
                    <label for="username" class="col-sm-2 asterisk control-label">标识</label>
                    <div class="col-sm-8">        
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>            
                            <input type="text" id="slug" name="slug" value="{{ $model->slug }}" class="form-control slug" placeholder="输入 标识">            
                        </div>        
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="permissions" class="col-sm-2 control-label">权限</label>
                    <div class="col-sm-8">
                        <select class="form-control permissions" style="width: 100%;" name="permissions[]" multiple="multiple" data-placeholder="输入 权限" data-value >
                            @foreach($permissions as $select => $option)
                                <option value="{{$select}}" {{  in_array($select, $model->permissions()->pluck('id')->toArray() ) ?'selected':'' }}>{{$option}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="permissions[]" />
                    </div>
                </div>
                
                <div class="form-group ">
                    <label class="col-sm-2 control-label">创建时间</label>
                    <div class="col-sm-8">
                        <div class="box box-solid box-default no-margin box-show">
                            <div class="box-body">
                                {{ $model->created_at }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group ">
                    <label class="col-sm-2 control-label">更新时间</label>
                    <div class="col-sm-8">
                        <div class="box box-solid box-default no-margin box-show">
                            <div class="box-body">
                                {{ $model->updated_at }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>            
        </div>
    </div>
    <!-- /.box-body -->

    {!! $form->renderFooter() !!}

    <input type="hidden" name="_method" value="PUT" class="_method">

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

