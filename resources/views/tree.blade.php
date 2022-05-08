<div class="col-lg-8 col-sm-12 mb-5">
    <h1 class="text-center">Drzewo kategorii</h1>
    <div class="tree-body">
        <div class="tree">
           <ul><li>
                @if (!empty($list))


                    @if ($list!=null)
                        <div data-id="{{$list->id}}" class="list">{{$list->nazwa}}</div><button class="removeFirst btn btn-danger m-2">Usuń</button> <button class="edit btn btn-success">Edytuj</button>
                    @endif
                @else
                <button class="addFirst btn btn-secondary">+</button>
                @endif
           </li></ul>
        </div>
    </div>
</div>
