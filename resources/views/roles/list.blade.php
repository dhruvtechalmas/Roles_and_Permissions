<x-app-layout>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <x-slot name="header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0 fs-3 fw-semibold">
                   Roles 
                </h2>

                <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm px-4">
                    Create
                </a>
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
                                <th>Name</th>
                                <th>Permissions</th>
                                <th width="10%">Created</th>
                                <th width="20%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($roles->IsNotEmpty())
                            @foreach($roles as $role)

                            <tr>
                                <td>{{$role -> id}}</td>
                                <td>{{$role -> name}}</td>
                                <td>{{$role -> permissions -> pluck('name') -> implode(', ')}}</td>
                                <td width="10%">{{ $role->created_at->format('d-m-Y') }} </td>
                                <td class="text-center">
                                    <a href="{{route('roles.edit',$role->id)}}" class="btn btn-warning btn-sm me-1">
                                        Edit
                                    </a>

                                   <a href="javascript:void(0);" onclick="deleteRole({{ $role->id }})" class="btn btn-danger btn-sm me-1">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                             @endif
                
                        </tbody>
                    </table>

                    <div class="my-3">
                        {{ $roles->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>

    <x-slot name="script">
        
        <script type="text/javascript">

          function deleteRole(id){
             if(confirm("Are You Sure You Want to Delete?")){
                $.ajax({
                    url : '{{route("roles.destroy")}}',
                    type : 'delete',
                    data : {id:id},
                    dataType : 'json',
                    headers : {
                        'x-csrf-token' : '{{ csrf_token() }}'
                    },  
                    success : function(response){
                        window.location.href = '{{route("roles.index")}}'
                    }
                });
            }
        }
        </script>
    </x-slot>

</x-app-layout>