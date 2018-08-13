<div class="box-search">
    <form class="form-horizontal" id="search-form" role="form" action={{ empty($id) ? route($routerName) : route($routerName, $id)}} method="GET">
        <div class="input-group pull-right" id="adv-search">
            <input type="text" class="form-control" value="{{$search}}" name="search" placeholder="Nhập thông tin tìm kiếm..." />
            <span class="input-group-btn">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-flat bg-olive button-search"><span class="caret"></span></button>
                    <button type="submit" class="btn bg-olive pull-right"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>                       
                </div>             
            </span>                                   
        </div>
        <div class="dropdown dropdown-lg" id="dropdown">
            <div class="dropdown-menu dropdown-menu-right">
                <div class="box-body">
                    {{$slot}}                    
                </div>
                <div class="box-footer">
                    <a href="{{ empty($id) ? route($routerName) : route($routerName, $id)}}" class="btn btn-flat btn-default"><i class="fa fa-history"></i> Reset</a>
                    <button type="submit" class="btn btn-flat bg-olive pull-right"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Tìm kiếm</button>
                </div>                                       
            </div>
        </div>                  
    </form>
</div>  
