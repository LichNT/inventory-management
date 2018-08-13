@if (session('alert-type')) 
    @switch(session('alert-type')) 
        @case('alert-danger')
            <div class="alert alert-warning alert-dismissible flat">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-warning"></i>{{empty(session('alert-content'))? 'Thông báo': session('alert-content')}}</h4>
                <ul>
                    @if(session('alert-content-detail'))
                        <li> {{session('alert-content-detail')}}  </li>
                    @endif  

                    @if($errors)
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach                        
                    @endif                                                                                      
                </ul>
                {{$slot}}
            </div>
            @break
        @case('alert-info')
            <div class="alert alert-info alert-dismissible flat">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-info"></i>{{empty(session('alert-content'))? 'Thông báo': session('alert-content')}}</h4>  
                <ul>
                    @if(session('alert-content-detail'))
                        <li> {{session('alert-content-detail')}}  </li>
                    @endif  

                    @if($errors)
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach                        
                    @endif                                                                                      
                </ul>              
                {{$slot}}
            </div>
            @break  
        @case('alert-warning')
            <div class="alert alert-warning alert-dismissible flat">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-warning"></i>{{empty(session('alert-content'))? 'Thông báo': session('alert-content')}}</h4>
                <ul>
                    @if(session('alert-content-detail'))
                        <li> {{session('alert-content-detail')}}  </li>
                    @endif  

                    @if($errors)
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach                        
                    @endif                                                                                      
                </ul>
                {{$slot}}
            </div>
            @break 
        @case('alert-success')
            <div class="alert bg-olive alert-dismissible flat">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i>{{empty(session('alert-content'))? 'Thông báo': session('alert-content')}}</h4>
                <ul>
                    @if(session('alert-content-detail'))
                        <li> {{session('alert-content-detail')}}  </li>
                    @endif  

                    @if($errors)
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach                        
                    @endif                                                                                      
                </ul>
                {{$slot}}
            </div>
            @break 
        @default
            <div class="alert bg-olive alert-dismissible flat">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i>{{empty(session('alert-content'))? 'Thông báo': session('alert-content')}}</h4>
                <ul>
                    @if(session('alert-content-detail'))
                        <li> {{session('alert-content-detail')}}  </li>
                    @endif  

                    @if($errors)
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach                        
                    @endif                                                                                      
                </ul>
                {{$slot}}
            </div>
    @endswitch    
@endif