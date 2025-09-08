@extends('frontend.layouts.app')

@section('content')
<section class="w-full bg-primary text-white px-4 py-10">
    <div class="w-full max-w-screen-xl mx-auto pb-10">
        <div class="flex flex-col lg:flex-row justify-between gap-5 lg:items-end border-b border-white/10">
            <div class="flex items-center gap-3">
                <img src="/frontend/assets/images/student-profile-vector.svg" alt="Tutor Avatar" class="w-28" />
                <div>
                    <span class="text-gray-250">Tutor Dashboard</span>
                    <h1 class="text-4xl font-bold tracking-tight text-white">Welcome Back!</h1>
                </div>
            </div>
            <div class="flex items-center gap-1 mb-3">
                <span class="text-gray-910 text-[15px] font-medium">Home</span>
                <span class="text-white text-[15px font-medium]">> Upload Study Notes</span>
            </div>
        </div>

        <div class="space-y-10 divide-y divide-zinc-700">
            <div class="w-full pt-10">
                <div class="grid grid-cols-12">
                    <div class="col-span-12 md:col-span-12 lg:col-span-12">
                        <div class="flex items-center gap-10 mb-10">
                            <a href="{{ url()->previous() }}"
                                class="bg-white rounded-full w-8 h-8 flex items-center justify-center cursor-pointer">
                                <img src="/frontend/assets/icons/arrow-left.svg" alt="Icon" class="size-4">
                            </a>
                            <h6 class="text-[20px] text-gray-75 font-semibold">Upload Study Notes: {{ $subject->name }} - {{ $subject->grade->name }}</h6>
                        </div>

                        <form method="POST" action="{{ route('tutor.notes.store', $subject->slug) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="grid grid-cols-12 gap-5">
                                <div class="col-span-12 lg:col-span-2">
                                    <div class="flex flex-col gap-3 items-center">
                                        <div class="flex items-center justify-center">
                                            <img src="/frontend/assets/images/sample/image-1.png" alt="Image"
                                                class="w-[154px] h-[186px] rounded-[13px] object-cover" />
                                        </div>
                                        <span class="font-bebas">{{ $subject->name }} - {{ $subject->grade->name }}</span>
                                    </div>
                                </div>
                                <div class="col-span-12 lg:col-span-10">
                                    <div class="grid grid-cols-12 gap-10">
                                        <div class="col-span-12 lg:col-span-6">
                                            <label class="block mb-2 text-[15px] font-medium text-gray-200">Topic</label>
                                            <select name="topic_id" id="topic_id"
                                                class="appearance-none bg-gray-1000 border border-gray-950 text-gray-75 rounded-[14px] w-full px-4 py-3">
                                                <option value="">Select topic</option>
                                                @foreach ($topics as $topic)
                                                    <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-span-12 lg:col-span-6">
                                            <div class="w-full">
                                                <label class="block mb-2 text-[15px] font-medium text-gray-200 mb-1">Material Title</label>
                                                <input type="text" name="start_date" placeholder="Input Material Title Here .."
                                                    class="appearance-none bg-gray-1000 border border-gray-950 text-gray-75 rounded-[14px] w-full px-4 py-3" />
                                            </div>
                                        </div>

                                        <div class="col-span-12">
                                            <label class="block mb-2 text-[15px] font-medium text-gray-200">Study Notes and Reference Materials</label>
                                            <div class="w-full">
                                                <label for="file-upload" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-700 border-dashed rounded-lg cursor-pointer bg-gray-950 hover:bg-gray-900 transition-colors">
                                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                        <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                                        </svg>
                                                        <p class="mb-2 text-sm text-gray-400">
                                                            <span class="font-semibold">Click to upload</span> or drag and drop
                                                        </p>
                                                        <p class="text-xs text-gray-500">PDF, DOCX, PNG, JPG (MAX. 5MB)</p>
                                                        <p id="file-name-display" class="mt-4 font-semibold text-green-400"></p>
                                                    </div>
                                                    <input id="file-upload" name="file" type="file" class="hidden" />
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-span-12">
                                            <div class="w-full">
                                                <label class="block mb-2 text-[15px] font-medium text-gray-200 mb-1">Description</label>
                                                <textarea name="description" rows="4"
                                                    class="appearance-none bg-gray-1000 border border-gray-950 text-gray-75 rounded-[14px] w-full px-4 py-3"
                                                    placeholder="Enter description here..."></textarea>
                                            </div>
                                        </div>
                                        <div class="col-span-12 lg:col-span-12">
                                            <button type="submit"
                                                class="bg-gray-50 hover:bg-gray-200 rounded-full text-sm px-8 py-3 w-full">
                                                <span class="text-black text-[16px] font-semibold">Upload Study Notes and Reference Materials</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    const fileUpload = document.getElementById('file-upload');
    const fileNameDisplay = document.getElementById('file-name-display');

    fileUpload.addEventListener('change', function() {
        if (fileUpload.files.length > 0) {
            const fileName = fileUpload.files[0].name;
            fileNameDisplay.textContent = 'Selected file: ' + fileName;
        } else {
            fileNameDisplay.textContent = '';
        }
    });
</script>
@endpush