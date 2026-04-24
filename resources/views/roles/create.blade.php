<x-app-layout>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <x-slot name="header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0 fs-3 fw-semibold">
                    Roles / Create
                </h2>

                <a href="{{ route('roles.index') }}" class="btn btn-primary btn-sm">
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">

                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                         <form action="{{route('roles.store')}}" method="POST">
                                @csrf

                                <div class="mb-5">
                                    <label for="name" class="form-label">Name:</label>

                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        value="{{old('name') }}"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Enter Name">

                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                           <div class="row">
                                 @if ($permissions->isNotEmpty())
                                    @foreach ($permissions as $permission)
                                      <div class="col-md-4 mb-3">
                                        <div class="form-check">
                                             <input type="checkbox" class="form-check-input" id="permission-{{ $permission->id }}"  name="permission[]" 
                                                value="{{ $permission->name }}">
                                            <label class="form-check-label" for="permission-{{ $permission->id }}">
                                                  {{ $permission->name }}
                                            </label>
                                         </div>
                                      </div>
                                    @endforeach
                                 @endif
                            </div>


                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-sm px-4">
                                        Submit
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>