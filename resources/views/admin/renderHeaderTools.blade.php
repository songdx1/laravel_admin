@if(isset($batchActions['delete']))
<div class="btn-group grid-select-all-btn" style="margin-right: 5px; display: none;">
    <a class="btn btn-sm btn-default hidden-xs"><span class="selected">已选择 0 项</span></a>
    <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <div class="dropdown-menu" role="menu">
        <a href="#" class="dropdown-item grid-batch-0">批量删除 </a>
    </div>
</div>
@endif

<div class="btn-group" >
    <button type="button" class="btn btn-sm btn-primary" data-toggle="collapse" data-target="#filter-box"><i class="fas fa-filter"></i>筛选</button>
</div>

<script>
$(function () {    
    @if(isset($batchActions['delete']))
    $('.grid-select-all').iCheck({checkboxClass:'icheckbox_minimal-blue'}).on('ifChanged', function (e) { 
        if (e.target.checked) {
            $('input.grid-row-checkbox').iCheck("check");
            var selected = $('input.grid-row-checkbox').length;  
            $('.grid-select-all-btn').show();
            $('.grid-select-all-btn .selected').html("已选择 {n} 项".replace('{n}', selected));
        }else {         
            $('input.grid-row-checkbox').iCheck("uncheck");
            $('.grid-select-all-btn').hide();
        }
    });

    $('.grid-row-checkbox').iCheck({checkboxClass:'icheckbox_minimal-blue'}).on('ifChanged', function () {    
        var id = $(this).data('id');
        if (this.checked) {
            $(this).closest('tr').css('background-color', '#ffffd5');
        } else {
            $(this).closest('tr').css('background-color', '');
        }
    }).on('ifClicked', function () {  
        var selected = $('input.grid-row-checkbox:checked').length+1;       
        if (selected > 0) {
            $('.grid-select-all-btn').show();
        } else {
            $('.grid-select-all-btn').hide();
        }        
        $('.grid-select-all-btn .selected').html("已选择 {n} 项".replace('{n}', selected));
    });

    $('.grid-batch-0').on('click', function() {
        swal({
            title: "确认删除?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确认",
            showLoaderOnConfirm: true,
            cancelButtonText: "取消",
            preConfirm: function() {
                return new Promise(function(resolve) {
                    var ids=[];
                    $('input.grid-row-checkbox:checked').each(function(){ 
                        ids.push($(this).data('id')) 
                    }) 
                    $.ajax({
                        method: 'post',
                        url: '{{$lists->path()}}/' + ids,
                        data: {
                            _method:'delete',
                            _token:LA.token,
                            // _token:'{{ csrf_token() }}',
                        },
                        success: function (data) {
                            $.pjax.reload('#pjax-container');
                            resolve(data);
                        }
                    });
                });
            }
        }).then(function(result) {
            var data = result.value;
            if (typeof data === 'object') {
                if (data.status) {
                    swal(data.message, '', 'success');
                } else {
                    swal(data.message, '', 'error');
                }
            }
        });
    });
    @endif

 
    
});

</script>