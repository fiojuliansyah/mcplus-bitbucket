@extends('layouts.guest')

@section('content')
    <header class="relative w-full md:max-h-[900px] flex items-center font-inter overflow-hidden px-4 py-48 md:py-56">
        <img src="/frontend/assets/images/header-bg.svg" alt="" class="w-full h-full object-cover absolute top-0 left-0 -z-10" />
        <div class="w-full max-w-screen-lg mx-auto flex justify-center items-center">
            
            <form method="POST" action="{{ route('create.account.store') }}" enctype="multipart/form-data" class="w-full max-w-lg mx-auto bg-white text-black text-center shadow-lg rounded-2xl md:rounded-3xl px-5 py-8 md:p-10 lg:p-20">
                @csrf
                @if ($errors->any())
                    <div class="w-full bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-left mb-4" role="alert">
                        <strong class="font-bold">Oops! Something went wrong.</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <h1 class="text-xl md:text-3xl font-bold">
                    Create {{ ucfirst($user->account_type) }} account
                </h1>
                
                <div class="w-full space-y-4 py-3 pt-8">
                    @if ($user->account_type === 'student')
                        <div class="w-full flex justify-center">
                            <div class="relative">
                                <label for="avatar" class="cursor-pointer">
                                    <img id="avatar-preview" class="w-32 h-32 rounded-full object-cover border-2 border-gray-300" src="/frontend/assets/images/camera.svg" alt="Avatar Preview">
                                </label>
                                <input type="file" name="avatar" id="avatar" class="hidden" accept="image/*" />
                            </div>
                        </div>
                        @error('avatar')
                            <p class="text-red-500 text-xs text-left">{{ $message }}</p>
                        @enderror
                    @endif


                    <div class="w-full text-left">
                        <label for="name" class="font-medium">{{ ucfirst($user->account_type) }} Name</label>
                        <input type="text" name="name" id="name" class="w-full text-white bg-black mt-1 border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ old('name') }}" />
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="w-full text-left">
                        <label for="ic_number" class="font-medium">IC Number</label>
                        <input type="text" name="ic_number" id="ic_number" class="w-full text-white bg-black mt-1 border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ old('ic_number') }}" />
                        @error('ic_number')
                             <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    @if ($user->account_type === 'student')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="w-full text-left">
                                <label for="gender" class="font-medium">Gender</label>
                                <select name="gender" id="gender" class="w-full text-white bg-black mt-1 border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="male" @if(old('gender') == 'male') selected @endif>Male</option>
                                    <option value="female" @if(old('gender') == 'female') selected @endif>Female</option>
                                </select>
                                @error('gender')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="w-full text-left">
                                <label for="grade" class="font-medium">Grade</label>
                                <select name="grade" id="grade" class="w-full text-white bg-black mt-1 border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="form-5">Form 5</option>
                                    <option value="form-4">Form 4</option>
                                    <option value="form-3">Form 3</option>
                                    <option value="form-2">Form 2</option>
                                    <option value="form-1">Form 1</option>
                                    <option value="year-6">Year 6</option>
                                    <option value="year-5">Year 5</option>
                                </select>
                                @error('grade')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @else
                    <div class="w-full text-left">
                        <label for="gender" class="font-medium">Gender</label>
                        <select name="gender" id="gender" class="w-full text-white bg-black mt-1 border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="male" @if(old('gender') == 'male') selected @endif>Male</option>
                            <option value="female" @if(old('gender') == 'female') selected @endif>Female</option>
                        </select>
                        @error('gender')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    @endif

                    <div class="w-full text-left">
                        <label for="phone" class="font-medium">Phone Number</label>
                        <div class="w-full grid grid-cols-10 gap-2">
                            <input type="tel" name="phone" id="phone" class="w-full col-span-2 placeholder-white bg-black rounded-md p-3" placeholder="+60" />
                            <input type="tel" name="phone" id="phone" class="w-full col-span-8 text-white bg-black rounded-md p-3" />
                        </div>
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    @if ($user->account_type === 'parent')
                        <div class="w-full text-left">
                            <label for="postcode" class="font-medium">Postcode</label>
                            <input type="text" name="postcode" id="postcode" class="w-full text-white bg-black mt-1 border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ old('postcode') }}" />
                            @error('postcode')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif
                    <div class="mt-12">
                        <button type="submit" class="w-full flex justify-center items-center text-sm md:text-base transition-all duration-300 bg-zinc-200 hover:bg-zinc-300 rounded-lg hover:cursor-pointer p-3">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </header>
@endsection

@push('scripts')
<script>
    document.getElementById('avatar').addEventListener('change', function(event) {
        const [file] = event.target.files;
        if (file) {
            const preview = document.getElementById('avatar-preview');
            preview.src = URL.createObjectURL(file);
            preview.onload = () => {
                URL.revokeObjectURL(preview.src);
            }
        }
    });
</script>
@endpush