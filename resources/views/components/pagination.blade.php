<div class="row">
    <div class="col-sm-5">
      <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Hiển thị {{(($data->currentPage() -1) * $data->perPage()) + 1 }} tới {{$data->count()+$data->perPage()*($data->currentPage()-1)}} của {{$data->total()}} mục tin</div>
    </div>
    <div class="col-sm-7">
      <div class="dataTables_paginate paging_simple_numbers pull-right">
        <ul class="pagination">          
        {{$data->appends(request()->query())->links()}}     
        </ul>
      </div>
    </div>
    <input type="hidden" value="{{$data->currentPage()}}" id="current_page">
  </div>