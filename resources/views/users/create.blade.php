<x-app-layout>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <x-slot name="header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0 fs-4 fw-semibold">
                    Users / Edit
                </h2>

                <a href="{{ route('users.index') }}" class="btn btn-primary btn-sm">
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


                            <form action="{{route('users.store')}}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="name" class="form-label">Name:</label>
                                    <input type="text" id="name" name="name"  value="{{old('name') }}"  class="form-control 
                                    @error('name') is-invalid @enderror" 
                                    placeholder="Enter Name">

                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>


                                <label for="email" class="form-label">Email:</label>
                                    <input type="text" id="email" name="email"  value="{{old('email')}}"  class="form-control 
                                    @error('email') is-invalid @enderror" 
                                    placeholder="Enter Email">

                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                              <label for="password" class="form-label">Password:</label>
                                    <input type="password" id="password" name="password"  value="{{old('password')}}"  class="form-control 
                                    @error('password') is-invalid @enderror" 
                                    placeholder="Enter password">

                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                     <label for="confirm_password " class="form-label">Confirm Password:</label>
                                    <input type="password" id="confirm_password" name="confirm_password"  value="{{old('confirm_password')}}"  class="form-control 
                                    @error('confirm_password') is-invalid @enderror" 
                                    placeholder="Confirm Your Password">

                                    @error('confirm_password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>


                            <div class="row">

                                 @if ($roles ->isNotEmpty())
                                    @foreach ($roles as $role)
                            
                                    <div class="col-md-4 mb-4">
                                        <div class="form-check">
                                                
                                         <input  type="checkbox" class="form-check-input" id="role-{{ $role->id }}"  name="role[]" 
                                                value="{{ $role->name }}">

                                            <label class="form-check-label" for="role-{{ $role->id }}">
                                                  {{ $role->name }}
                                            </label>

                                         </div>
                                    </div>

                                    @endforeach
                                 @endif
                            </div>


                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-sm px-4">
                                        Create
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