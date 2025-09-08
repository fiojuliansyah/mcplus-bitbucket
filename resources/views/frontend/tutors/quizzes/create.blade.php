@extends('frontend.layouts.app')

@section('content')
<section class="w-full bg-primary text-white px-4 py-10">
    <div class="w-full max-w-screen-xl mx-auto pb-10">
        <!-- HEADER -->
        <div class="flex flex-col lg:flex-row justify-between gap-5 lg:items-end border-b border-white/10 pb-4">
            <!-- LEFT SECTION -->
            <div class="flex items-center gap-3">
                <img src="/frontend/assets/images/student-profile-vector.svg" alt="Tutor Avatar" class="w-28" />
                <div>
                    <span class="text-gray-250">Tutor Dashboard</span>
                    <h1 class="text-4xl font-bold tracking-tight text-white">Welcome Back!</h1>
                </div>
            </div>
            <!-- RIGHT SECTION - BREADCRUMB -->
            <div class="flex items-center gap-1 mb-3">
                <span class="text-gray-910 text-[15px] font-medium">Home</span>
                <span class="text-white text-[15px font-medium">> Create Quizzes</span>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="pt-10">
            <div class="flex items-center gap-10 mb-10">
                <a href="{{ url()->previous() }}" class="bg-white rounded-full w-8 h-8 flex items-center justify-center cursor-pointer">
                    <img src="/frontend/assets/icons/arrow-left.svg" alt="Icon" class="size-4">
                </a>
                <h6 class="text-[20px] text-gray-75 font-semibold">Create Quizzes</h6>
            </div>

            <!-- FORM -->
            <form action="{{ route('tutor.quizzes.store') }}" method="POST" class="grid grid-cols-12 gap-5">
                @csrf
                <div class="col-span-12 lg:col-span-2">
                    <div class="flex flex-col gap-3 items-center">
                        <div class="flex items-center justify-center">
                            <img src="/frontend/assets/images/sample/image-1.png" alt="Image" class="w-[154px] h-[186px] rounded-[13px] object-cover" />
                        </div>
                        <span class="font-bebas text-center">{{ $subject->name }} - {{ $subject->grade->name }}</span>
                    </div>
                </div>

                <div class="col-span-12 lg:col-span-10">
                    <div class="grid grid-cols-12 gap-x-5 gap-y-6">
                        <div class="col-span-12">
                            <label for="topic_id" class="block mb-2 text-[15px] font-medium text-gray-200">Topic</label>
                            <select name="topic_id" id="topic_id" class="appearance-none bg-gray-1000 border @error('topic_id') border-red-500 @else border-gray-950 @enderror text-gray-75 rounded-[14px] w-full px-4 py-3">
                                <option value="">Select topic</option>
                                @foreach ($topics as $topic)
                                <option value="{{ $topic->id }}" {{ old('topic_id') == $topic->id ? 'selected' : '' }}>{{ $topic->name }}</option>
                                @endforeach
                            </select>
                            @error('topic_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-12 lg:col-span-6">
                            <label for="start_date" class="block mb-2 text-[15px] font-medium text-gray-200">Start Date</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" class="appearance-none bg-gray-1000 border @error('start_date') border-red-500 @else border-gray-950 @enderror text-gray-75 placeholder:text-gray-500 rounded-[14px] w-full px-4 py-3" required />
                             @error('start_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-12 lg:col-span-6">
                            <label for="end_date" class="block mb-2 text-[15px] font-medium text-gray-200">End Date</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="appearance-none bg-gray-1000 border @error('end_date') border-red-500 @else border-gray-950 @enderror text-gray-75 placeholder:text-gray-500 rounded-[14px] w-full px-4 py-3" required />
                             @error('end_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-12 lg:col-span-6">
                            <label for="estimate_time" class="block mb-2 text-[15px] font-medium text-gray-200">Estimated Time (Minutes)</label>
                            <input type="number" name="estimate_time" id="estimate_time" value="{{ old('estimate_time') }}" class="appearance-none bg-gray-1000 border @error('estimate_time') border-red-500 @else border-gray-950 @enderror text-gray-75 placeholder:text-gray-500 rounded-[14px] w-full px-4 py-3" placeholder="e.g. 60" required />
                             @error('estimate_time')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-12 lg:col-span-6">
                            <label for="attempts_time" class="block mb-2 text-[15px] font-medium text-gray-200">Attempts Time</label>
                            <input type="number" name="attempts_time" id="attempts_time" value="{{ old('attempts_time') }}" class="appearance-none bg-gray-1000 border @error('attempts_time') border-red-500 @else border-gray-950 @enderror text-gray-75 placeholder:text-gray-500 rounded-[14px] w-full px-4 py-3" placeholder="e.g. 3" required />
                             @error('attempts_time')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="col-span-12 lg:col-span-6">
                            <label for="max_score" class="block mb-2 text-[15px] font-medium text-gray-200">Max Score</label>
                            <input type="number" name="max_score" id="max_score" value="{{ old('max_score') }}" class="bg-gray-1000 border @error('max_score') border-red-500 @else border-gray-950 @enderror text-gray-75 placeholder:text-gray-500 rounded-[14px] w-full px-4 py-3" placeholder="e.g. 100" required />
                            @error('max_score')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-12 lg:col-span-6">
                            <label for="total_question" class="block mb-2 text-[15px] font-medium text-gray-200">Total Questions</label>
                            <input type="number" name="total_question" id="total_question" value="{{ old('total_question') }}" class="bg-gray-1000 border @error('total_question') border-red-500 @else border-gray-950 @enderror text-gray-75 placeholder:text-gray-500 rounded-[14px] w-full px-4 py-3" placeholder="e.g. 20" required />
                            @error('total_question')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-12 lg:col-span-6">
                            <label for="auto_mark" class="block mb-2 text-[15px] font-medium text-gray-200">Auto Mark</label>
                            <div class="relative">
                                <select name="auto_mark" id="auto_mark" class="appearance-none pr-10 bg-gray-1000 border @error('auto_mark') border-red-500 @else border-gray-950 @enderror text-gray-75 placeholder:text-gray-500 rounded-[14px] w-full px-4 py-3">
                                    <option value="yes" {{ old('auto_mark') == 'yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="no" {{ old('auto_mark', 'no') == 'no' ? 'selected' : '' }}>No</option>
                                </select>
                                <div class="pointer-events-none absolute right-5 top-1/2 transform -translate-y-1/2 text-white">
                                    <img src="/frontend/assets/icons/angle-down.svg" alt="Icon">
                                </div>
                            </div>
                             @error('auto_mark')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-12 mt-4">
                            <button type="submit" class="bg-gray-50 hover:bg-gray-200 rounded-full text-sm px-8 py-3 w-full">
                                <span class="text-black text-[16px] font-semibold">Save and Add Questions</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection