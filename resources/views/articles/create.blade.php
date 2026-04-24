<x-app-layout>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <x-slot name="header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0 fs-4 fw-semibold">
                    Articles / Create
                </h2>

                <a href="{{ route('articles.index') }}" class="btn btn-primary btn-sm">
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


                            <form action="{{route('articles.store')}}" method="POST">
                                @csrf

                                <div class="mb-3">

                                    <label for="name" class="form-label">Title:</label>
                                    <input type="text" id="title" name="title" value="{{old('title') }}" class="form-control 
                                    @error('title') is-invalid @enderror"
                                    placeholder="Enter title">

                                    @error('title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                     <label for="name" class="form-label">Content:</label>
                                     <textarea name="text"  placeholder="Content"   id="text" cols="30" rows="10" class="form-control">{{old('text') }}</textarea>


                                    <label for="author" class="form-label">Author:</label>
                                    <input type="text" id="author" name="author" value="{{old('author') }}" class="form-control 
                                    @error('author') is-invalid @enderror"
                                    placeholder="Enter Author">

                                    @error('author')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror


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