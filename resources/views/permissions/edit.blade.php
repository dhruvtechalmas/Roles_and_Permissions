<x-app-layout>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <x-slot name="header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0 fs-4 fw-semibold">
                    Permissions / Edit
                </h2>

                <a href="{{ route('permissions.index') }}" class="btn btn-primary btn-sm">
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

                            <h3 class="text-center mb-4">Edit Permission</h3>

                            <form action="{{route('permissions.update', $permission->id)}}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="name" class="form-label">Name:</label>

                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        value="{{ old('name',$permission->name) }}"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Enter Name"
                                    >

                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-sm px-4">
                                        Update
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