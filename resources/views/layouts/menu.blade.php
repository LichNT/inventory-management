@foreach ($menus as $menu)   
    @if (count($menu->children) > 0)
        <li class="treeview">
            @if(Route::has($menu->router_link))
                <a href="{{route($menu->router_link)}}"><i class="fa {{$menu->fa_icon}}"></i> <span>{{$menu->name}}</span>
            @else
                <a href="#"><i class="fa {{$menu->fa_icon}}"></i> <span>{{$menu->name}}</span>
            @endif            
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>    
            <ul class="treeview-menu">                            
                @foreach ($menu->children as $menu_detail)


                    @if (count($menu_detail->children) > 0)
                        <li class="treeview">
                            @if(Route::has($menu_detail->router_link))
                                <a href="{{route($menu_detail->router_link)}}"><i class="fa {{$menu_detail->fa_icon}}"></i> <span>{{$menu_detail->name}}</span>
                                    @else
                                        <a href="#"><i class="fa {{$menu_detail->fa_icon}}"></i> <span>{{$menu_detail->name}}</span>
                                            @endif
                                            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
                                        </a>
                                        <ul class="treeview-menu">
                                            @foreach ($menu_detail->children as $menu_detail2)
                                                @if(Route::has($menu_detail2->router_link))
                                                    <li><a href="{{route($menu_detail2->router_link)}}">
                                                            <i class="fa {{$menu_detail2->fa_icon}}"></i>
                                                            {{$menu_detail2->name}}
                                                        </a>
                                                    </li>
                                                @else
                                                    <li>
                                                        <a href="#">
                                                            <i class="fa {{$menu_detail2->fa_icon}}"></i>
                                                            {{$menu_detail2->name}}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                        </li>
                @elseif(Route::has($menu_detail->router_link))
                        <li><a href="{{route($menu_detail->router_link)}}">
                                <i class="fa {{$menu_detail->fa_icon}}"></i>
                                {{$menu_detail->name}}
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="#">
                                <i class="fa {{$menu_detail->fa_icon}}"></i>
                                {{$menu_detail->name}}
                            </a>
                        </li>
                    @endif                     
                @endforeach
            </ul>
        </li>           
    @elseif (Route::has($menu->router_link))
        <li><a href="{{route($menu->router_link)}}"><i class="fa {{$menu->fa_icon}}"></i><span>{{$menu->name}}</span></a></li>                
    @else
        <li><a href="{{null}}"><i class="fa {{$menu->fa_icon}}"></i> <span>{{$menu->name}}</span></a></li>          
    @endif    
@endforeach