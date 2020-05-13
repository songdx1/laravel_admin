<div class="box-header with-border {{ $expand?'':'hide' }}" id="filter-box">
    <form action="route('admin.auth.logs.index')" class="form-horizontal" pjax-container method="get">

        <div class="row">
            <div class="col-md-12">
                <div class="box-body">
                    <div class="fields-group">
                        
                        <div class="form-group">
                            <label class="col-sm-2 control-label"> ID</label>
                            <div class="col-sm-8">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-addon">
                                        <i class="fa fa-pencil"></i>
                                    </div>
                                    <input type="text" class="form-control id" placeholder="ID" name="id" value="">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="btn-group pull-left">
                            <button class="btn btn-info submit btn-sm"><i class="fa fa-search"></i>&nbsp;&nbsp;搜索</button>
                        </div>
                        <div class="btn-group pull-left " style="margin-left: 10px;">
                            <a href="route('admin.auth.logs.index')" class="btn btn-default btn-sm"><i class="fa fa-undo"></i>&nbsp;&nbsp;重置</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </form>
</div>