<x-app-layout>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <x-slot name="header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0 fs-3 fw-semibold">
                   Users 
                </h2>

                @can('Create users')
                <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm px-4">
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
                                <th>Name</th>
                                <th>Email</th>              
                                <th>Roles</th>              
                                <th width="10%">Created</th>
                                <th width="20%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($users->IsNotEmpty())
                            @foreach($users as $user)

                            <tr>
                                <td>{{$user -> id}}</td>
                                <td>{{$user -> name}}</td>
                                <td>{{$user -> email}}</td>                              
                                <td>{{$user -> roles->pluck('name')->implode(', ')}}</td>                              
                                <td width="10%">{{ $user->created_at->format('d-m-Y') }} </td>
                                <td class="text-center">
                                    @can('Edit users')
                                    <a href="{{route('users.edit',$user->id)}}" class="btn btn-warning btn-sm me-1">
                                        Edit
                                    </a>
                                    @endcan

                                  @can('Delete users')
                                   <a href="javascript:void(0);" onclick="deleteUser({{ $user->id }})" class="btn btn-danger btn-sm me-1">
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
                        {{ $users->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>

    <x-slot name="script">
        
        <script type="text/javascript">

          function deleteUser(id){
             if(confirm("Are You Sure You Want to Delete?")){
                $.ajax({
                    url : '{{route("users.destroy")}}',
                    type : 'delete',
                    data : {id:id},
                    dataType : 'json',
                    headers : {
                        'x-csrf-token' : '{{ csrf_token() }}'
                    },  
                    success : function(response){
                        window.location.href = '{{route("users.index")}}'
                    }
                });
            }
        }
        </script>
    </x-slot>

</x-app-layout>