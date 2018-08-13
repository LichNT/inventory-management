<div class="col-xs-12 col-md-12 ">
</br>
    <table class="pull-right">
        <tr>
            <td>
                <legend>Tài liệu đính kèm</legend>
            </td>
        </tr>
        <tr>
            <td>
                <input type="file" name="files[]" multiple="multiple" onchange="getFileSizeandName(this);"/>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <div id="uploaddiv">
                    <table id="uploadTable" class="table table-striped table-bordered">
                        <tr>
                            <th>Tên file</th>
                            <th>Kích thước</th>
                            <th style="text-align: center">Xóa</th>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</div>
<script src="{{asset('js/file.js')}}"></script>

