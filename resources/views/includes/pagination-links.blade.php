@if ($paginator->hasPages())
<div class="card-footer clearfix">
  Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} out of {{ $paginator->total() }} results
  <ul class="pagination pagination-sm m-0 float-right">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <li class="page-item">
            <span class="page-link" href="#">«</span>
        </li>
    @else
        <li class="page-item">
            <a class="page-link" type="button" wire:click="previousPage" href="#">«</a>
        </li>
    @endif
    
    {{-- Numbers --}}
    @foreach($elements as $element)
        @foreach($element as $page => $url)
            @if($page == $paginator->currentPage())
                <li class="page-item active"><span class="page-link" href="#">{{$page}}</span></li>
            @else
                <li class="page-item"><a class="page-link" type="button" wire:click="gotoPage({{$page}})" href="#">{{$page}}</a></li>
            @endif
        @endforeach
    @endforeach
    
    
    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <li class="page-item">
            <a class="page-link" type="button" wire:click="nextPage" href="#">»</a>
        </li>
    @else
        <li class="page-item">
            <span class="page-link" href="#">»</span>
        </li>
    @endif
        
  </ul>
</div>
@endif
