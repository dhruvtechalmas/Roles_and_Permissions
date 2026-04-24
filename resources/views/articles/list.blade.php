<x-app-layout>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <x-slot name="header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0 fs-4 fw-semibold">
                   Articles
                </h2>

                @can('Create articles')
                <a href="{{ route('articles.create') }}" class="btn btn-primary btn-sm px-4">
                    Create
                </a>
                @endcan

            </div>
        </div>
    </x-slot>

    <div class="py-5">
        <div class="container">

            @include('components.message')

            <div class="card shadow-sm">
                <div class="card-body p-4">
                    
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="10%">ID</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Created</th>
                                <th width="20%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($articles->IsNotEmpty())
                            @foreach($articles as $article)

                            <tr>
                                <td>{{$article -> id}}</td>
                                <td>{{$article -> title}}</td>
                                <td>{{$article -> author}}</td>
                                <td>{{ $article->created_at->format('d-m-Y') }} </td>
                                <td class="text-center">

                                    @can('Edit articles')                                        
                                    <a href="{{route('articles.edit',$article->id)}}" class="btn btn-warning btn-sm me-1">
                                        Edit
                                    </a>
                                    @endcan
                                    
                                    @can('Delete articles')                                        
                                   <a href="javascript:void(0);" onclick="deleteArticle({{ $article->id }})" class="btn btn-danger btn-sm me-1">
                                        Delete
                                    </a>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                             @endif
                
                        </tbody>
                    </table>

                     <div class="my-3">
                        {{ $articles->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>

    <x-slot name="script">
        
    <script type="text/javascript">

        function deleteArticle(id){
            if(confirm("Are You Sure You Want to Delete?")){
                $.ajax({
                    url : '{{route("articles.destroy")}}',
                    type : 'delete',
                    data : {id:id},
                    dataType : 'json',
                    headers : {
                        'x-csrf-token' : '{{ csrf_token() }}'
                    },  
                    success : function(response){
                        window.location.href = '{{route("articles.index")}}'
                    }
                });
            }
        }
        </script>
    </x-slot>

</x-app-layout>