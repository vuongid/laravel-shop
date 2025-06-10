 <li class="dd-item" data-id="{{ $item->id }}">
     <div class="dd-handle">
         {{ $item->name }}
     </div>
     @if (count($item->children))
         <ol class="dd-list">
             @foreach ($item->children as $itemChild)
                 @include('admin.pages.articleCategory.partials.index.list_item', ['item' => $itemChild])
             @endforeach
         </ol>
     @endif
 </li>
