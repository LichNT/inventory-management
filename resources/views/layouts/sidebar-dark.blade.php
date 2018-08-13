<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li class="active">
            <a href="#control-sidebar-home-tab" data-toggle="tab">
                <i class="fa fa-gears"></i> Tùy chọn giao diện</a>
        </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane active" id="control-sidebar-home-tab">
            <div class="form-group">
                <label class="control-sidebar-subheading">
                    <input type="checkbox" class="pull-right" id="checkboxFixed" onclick="changeLayout()" checked> Bố cục cố định
                </label>
                <p>Kích hoạt bố cục cố định. Phía đầu trang sẽ cố định khi xem nội dung phía dưới</p>
            </div>
            <div class="form-group">
                <label class="control-sidebar-subheading">
                    <input type="checkbox" data-layout="fixed" class="pull-right" onclick="changeMenuLeft()" id="checkboxChangeMenuLeft" checked> Thu gọn menu bên trái
                </label>
                <p>Kích hoạt chế độ thu gọn menu bên trái.</p>
            </div>
            <h4 class="control-sidebar-heading">Giao diện</h4>
            <ul class="list-unstyled clearfix">
                <li style="float:left; width: 33.33333%; padding: 5px;">
                    <a href="javascript:changeSkin('skin-blue')" data-skin="skin-blue" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                        <div>
                            <span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9"></span>
                            <span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;">
                            </span>
                        </div>
                        <div>
                            <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32">
                            </span>
                            <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
                        </div>
                    </a>
                    <p class="text-center no-margin">Blue</p>
                </li>
            </ul>
            <!-- /.control-sidebar-menu -->
        </div>
        <!-- /.tab-pane -->
    </div>
</aside>