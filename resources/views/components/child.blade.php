<ul>
@foreach($childs as $child)
	<li>
    <a>{{$child->ten }}</a>
	@if(count($child->childs))
        @component('components.child',['childs' =>$child->childs ])
            @endComponent
        @endif
	</li>
@endforeach
</ul>