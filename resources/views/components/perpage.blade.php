
    <div class="dataTables_length" id="perpage">
        <label>Hiển thị 
            <select name="perpage" id="select_perpage" aria-controls="perpage" class="form-control input-sm" >
                @foreach ($options as $option)
                    <option value="{{$option}}" {{(!empty($perPage)&&$option==$perPage)?'selected':null}} }}>{{$option}} </option>
                @endforeach
            </select> mục tin</label>
    </div>


