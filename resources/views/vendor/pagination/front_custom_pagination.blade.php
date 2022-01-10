@if ($paginator->hasPages())
<nav aria-label="Page navigation example">
    <ul class="pagination pagination-circle">
       
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><a href="" class="page-link">Previous</a></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" style="color: #232d68; border: 1px solid #acacac;" rel="prev">Previous</a></li>
        @endif


      
        @foreach ($elements as $element)
           
            @if (is_string($element))
                <li class="page-item disabled"><a href="" class="page-link">{{ $element }}</a></li>
            @endif


           
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><a href="" class="page-link" style="background-color: #ccccce; border: 1px solid #ccccce;">{{ $page }}</a></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}" style="color: #232d68;">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

       
        
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" style="color: #232d68;" rel="next">Next</a></li>
        @else
            <li class="page-item disabled"><a href="" class="page-link">Next</a></li>
        @endif
    </ul>
</nav>
@endif 