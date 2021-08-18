<link rel="stylesheet" href="/vendor/bootstrap-iconpicker/dist/css/bootstrap-iconpicker.min.css">
<script src="/vendor/bootstrap-iconpicker/dist/js/bootstrap-iconpicker.bundle.min.js"></script>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">创建</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form action="{!! route('admin.auth.menu.index') !!}" method="post" accept-charset="UTF-8" class="form-horizontal" pjax-container="">  

    <div class="box-body">
        <div class="fields-group">
            <div class="col-md-12">

                <div class="input-group ">
                    <label for="parent_id" class="col-sm-2 control-label">父级菜单</label>
                    <select class="form-control" name="parent_id" data-value="" tabindex="-1" aria-hidden="true">
                        @foreach($menuOptions as $select => $option)
                            <option value="{{$select}}">{{$option}}</option>
                        @endforeach
                    </select>                 
                </div>    

                <div class="input-group">
                    <label class="col-sm-2 control-label"> 标题</label>
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-pencil"></i></span>
                    </div>
                    <input type="text" class="form-control"  id="title" name="title" value="" class="form-control name" placeholder=" 标题">        
                </div>

                <div class="input-group">
                    <label for="icon" class="col-sm-2 asterisk control-label">图标</label>
                    <div class="col-sm-8">        
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span> 
                            <input style="width: 140px" type="text" id="icon" name="icon" value="fa-bars" class="form-control icon iconpicker-element iconpicker-input" placeholder="输入 图标" required="1">          
                        </div>   
                        <span class="help-block">
                            <i class="fa fa-info-circle"></i>&nbsp;For more icons please see <a href="http://fontawesome.io/icons/" target="_blank">http://fontawesome.io/icons/</a>
                        </span>     
                    </div>
                </div>

                 <div class="input-group">
                    <label class="col-sm-2 control-label"> 路径</label>
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-pencil"></i></span>
                    </div>
                    <input type="text" class="form-control"  id="uri" name="uri" value="" class="form-control uri" placeholder="输入 路径">         
                </div>

                <div class="input-group">
                    <label for="roles" class="col-sm-2 control-label">角色</label>
                    <select class="form-control" name="roles[]" multiple data-placeholder="选择角色" aria-hidden = "true" >
                        @foreach($roles as $select => $option)
                            <option value="{{$select}}" >{{$option}}</option>
                        @endforeach
                    </select>
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
$('.icon').iconpicker({placement:'bottomLeft'});
</script>


