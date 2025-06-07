<span style="width: 45px" class="d-inline-block">
    @if ($item->getPrevSibling())
        <a href="{{ route('admin.articleCategory.move', ['articleCategory' => $item, 'type' => 'up']) }}"
            class="btn btn-primary">
            Up
        </a>
    @endif
</span>

<span style="width: 65px" class="d-inline-block">
    @if ($item->getNextSibling())
        <a href="{{ route('admin.articleCategory.move', ['articleCategory' => $item, 'type' => 'down']) }}"
            class="btn btn-danger">
            Dow
        </a>
    @endif
</span>
