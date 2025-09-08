@extends('frontend.layouts.app')

@section('content')
<section class="w-full bg-primary text-white px-4 py-10">
    <div class="w-full max-w-screen-xl mx-auto pb-10">
        <!-- HEADER -->
        <div class="flex flex-col lg:flex-row justify-between gap-5 lg:items-end border-b border-white/10 pb-5">
            <!-- LEFT SECTION -->
            <div class="flex items-center gap-3">
                <img src="{{ asset('frontend/assets/images/student-profile-vector.svg') }}" alt="Tutor Avatar" class="w-28" />
                <div>
                    <span class="text-gray-250">Tutor Dashboard</span>
                    <h1 class="text-4xl font-bold tracking-tight text-white">Quiz Management</h1>
                </div>
            </div>
            <!-- RIGHT SECTION - BREADCRUMB -->
            <div class="flex items-center gap-1 mb-3">
                <span class="text-gray-400 text-[15px] font-medium">Home > Create Quizzes</span>
                <span class="text-white text-[15px] font-medium">> Add Questions</span>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="space-y-10 pt-10">
            <!-- Quiz Info Box -->
            <div class="grid grid-cols-12 gap-10">
                <div class="col-span-12 lg:col-span-2">
                    <div class="flex flex-col gap-3 items-center">
                        <img src="{{ asset('frontend/assets/images/sample/image-1.png') }}" alt="Subject Image" class="w-full lg:w-[154px] h-auto lg:h-[186px] rounded-[13px] object-cover" />
                        <span class="font-bebas">{{ $quizz->subject->name }}</span>
                    </div>
                </div>
                <div class="col-span-12 lg:col-span-10">
                    <div class="bg-gray-990 rounded-[21px] p-8">
                        <div class="flex items-start gap-5">
                            <img src="{{ asset('frontend/assets/icons/quiz.svg') }}" alt="Icon" class="w-8">
                            <div class="flex flex-col">
                                <h6 class="text-gray-75 font-bold mb-1">{{ $quizz->topic->name }}</h6>
                                <p class="text-gray-200 mb-8">{{ $quizz->grade->name }} | {{ $quizz->subject->name }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5 border-t border-[#2C2C2C] pt-5 lg:pr-5">
                            <div class="flex gap-5 items-center">
                                <img src="{{ asset('frontend/assets/icons/calendar.svg') }}" alt="Icon" class="w-4 h-4">
                                <div class="flex flex-col">
                                    <span class="text-gray-200 text-sm">Date:</span>
                                    <span class="text-white text-sm font-semibold">{{ \Carbon\Carbon::parse($quizz->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($quizz->end_date)->format('d M Y') }}</span>
                                </div>
                            </div>
                            <div class="flex gap-5 items-center">
                                <img src="{{ asset('frontend/assets/icons/undo.svg') }}" alt="Icon" class="w-4 h-4">
                                <div class="flex flex-col">
                                    <span class="text-gray-200 text-sm">Attempts:</span>
                                    <span class="text-white text-sm font-semibold">{{ $quizz->attempts_time }}</span>
                                </div>
                            </div>
                            <div class="flex gap-5 items-center">
                                <img src="{{ asset('frontend/assets/icons/clock.svg') }}" alt="Icon" class="w-4 h-4">
                                <div class="flex flex-col">
                                    <span class="text-gray-200 text-sm">Time:</span>
                                    <span class="text-white text-sm font-semibold">{{ $quizz->estimate_time }} mins</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add All Questions Form -->
            <div class="pt-5">
                <form action="{{ route('tutor.quizzes.store-question', $quizz->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-12">
                        @for ($i = 0; $i < $quizz->total_question; $i++)
                        <div class="p-8 bg-gray-1000 rounded-lg border border-gray-900 question-block">
                            <div class="flex items-start gap-10">
                                <div class="text-center">
                                    <h1 class="text-[150px] font-bold leading-none text-white-800">{{ $i + 1 }}</h1>
                                </div>
                                <div class="w-full space-y-6">
                                    <!-- Question Text -->
                                    <div>
                                        <label for="question_text_{{ $i }}" class="block mb-2 text-[15px] font-medium text-gray-200">Question</label>
                                        <textarea name="questions[{{ $i }}][question_text]" id="question_text_{{ $i }}" class="appearance-none bg-gray-950 border border-gray-800 text-gray-200 placeholder:text-gray-500 rounded-[14px] w-full px-4 py-3" placeholder="Enter question #{{ $i + 1 }}" required>{{ old("questions.{$i}.question_text") }}</textarea>
                                        @error("questions.{$i}.question_text") <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <!-- Media Upload -->
                                    <div>
                                        <label for="media_file_{{ $i }}" class="block mb-2 text-[15px] font-medium text-gray-200">Image or Media Attachment (Optional)</label>
                                        <input type="file" name="questions[{{ $i }}][media_file]" id="media_file_{{ $i }}" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-cyan-600 file:text-white hover:file:bg-cyan-700">
                                        <p class="mt-1 text-xs text-gray-500">Allowed: JPG, PNG, GIF, MP4. Max 20MB.</p>
                                        @error("questions.{$i}.media_file") <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    
                                    <!-- Grid for Score and Type of Answer -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Score -->
                                        <div>
                                            <label for="score_{{ $i }}" class="block mb-2 text-[15px] font-medium text-gray-200">Answer Point Mark</label>
                                            <input type="number" name="questions[{{ $i }}][score]" id="score_{{ $i }}" value="{{ old("questions.{$i}.score", 10) }}" class="appearance-none bg-gray-950 border border-gray-800 text-gray-200 placeholder:text-gray-500 rounded-[14px] w-full px-4 py-3" required>
                                            @error("questions.{$i}.score") <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                        </div>
                                        
                                        <!-- Type of Answer -->
                                        <div>
                                            <label for="answer_type_{{ $i }}" class="block mb-2 text-[15px] font-medium text-gray-200">Type of Answer</label>
                                            <select name="questions[{{ $i }}][answer_type]" id="answer_type_{{ $i }}" class="answer-type-select appearance-none bg-gray-950 border border-gray-800 text-gray-200 rounded-[14px] w-full px-4 py-3" data-question-index="{{ $i }}">
                                                <option value="single_choice" @if(old("questions.{$i}.answer_type", 'single_choice') == 'single_choice') selected @endif>Single Choice</option>
                                                <option value="multiple_choice" @if(old("questions.{$i}.answer_type") == 'multiple_choice') selected @endif>Multiple Choice</option>
                                                <option value="true_false" @if(old("questions.{$i}.answer_type") == 'true_false') selected @endif>True/False</option>
                                                <option value="text" @if(old("questions.{$i}.answer_type") == 'text') selected @endif>Text (Essay)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Dynamic Answer Containers -->
                                    <div class="answer-options-wrapper">
                                        <!-- Container for Single/Multiple Choice -->
                                        <div class="answer-type-container choice-options-container">
                                            <label class="block text-[15px] font-medium text-gray-200">Answers</label>
                                            <div class="space-y-3 options-container">
                                                <!-- JavaScript will populate this -->
                                            </div>
                                            @error("questions.{$i}.options") <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                                            @error("questions.{$i}.correct_option") <p class="text-red-500 text-xs mt-1">Please select at least one correct answer for this question.</p> @enderror
                                            <button type="button" class="mt-4 bg-gray-800 hover:bg-gray-700 rounded-full text-sm px-8 py-3 add-option-btn">
                                                <span class="text-white text-[16px] font-semibold">Add Answer</span>
                                            </button>
                                        </div>

                                        <!-- Container for True/False -->
                                        <div class="answer-type-container true-false-container" style="display: none;">
                                            <label class="block mb-2 text-[15px] font-medium text-gray-200">Correct Answer</label>
                                            <div class="flex gap-6 items-center">
                                                <label class="flex items-center gap-2 cursor-pointer">
                                                    <input type="radio" name="questions[{{ $i }}][correct_option]" value="true" class="w-4 h-4 text-cyan-600 bg-gray-700 border-gray-600">
                                                    <span>True</span>
                                                </label>
                                                <label class="flex items-center gap-2 cursor-pointer">
                                                    <input type="radio" name="questions[{{ $i }}][correct_option]" value="false" class="w-4 h-4 text-cyan-600 bg-gray-700 border-gray-600">
                                                    <span>False</span>
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Container for Text/Essay -->
                                        <div class="answer-type-container text-container" style="display: none;">
                                            <label for="text_answer_{{$i}}" class="block mb-2 text-[15px] font-medium text-gray-200">Model Answer (Optional)</label>
                                            <textarea name="questions[{{ $i }}][options]" id="text_answer_{{$i}}" class="appearance-none bg-gray-950 border border-gray-800 text-gray-200 placeholder:text-gray-500 rounded-[14px] w-full px-4 py-3" placeholder="Enter the ideal answer here...">{{ is_string(old("questions.{$i}.options")) ? old("questions.{$i}.options") : '' }}</textarea>
                                            <p class="mt-1 text-xs text-gray-500">For manual grading, you can leave this blank.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endfor
                    </div>

                    <div class="flex justify-end mt-12">
                        <button type="submit" class="bg-gray-50 hover:bg-gray-200 rounded-full text-sm px-8 py-4 w-full lg:w-1/3">
                            <span class="text-black text-[16px] font-semibold">Save All Questions</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    function initializeQuestionBlock(block, questionIndex) {
        const answerTypeSelect = block.querySelector('.answer-type-select');
        const optionsWrapper = block.querySelector('.answer-options-wrapper');
        const choiceContainer = optionsWrapper.querySelector('.choice-options-container');
        const trueFalseContainer = optionsWrapper.querySelector('.true-false-container');
        const textContainer = optionsWrapper.querySelector('.text-container');
        const optionsContainer = choiceContainer.querySelector('.options-container');
        const addOptionBtn = choiceContainer.querySelector('.add-option-btn');
        let optionCounter = 0;

        function createOptionInput(index, value = '', isChecked = false) {
            const div = document.createElement('div');
            div.classList.add('flex', 'items-center', 'gap-3');

            const answerType = answerTypeSelect.value;
            const inputType = answerType === 'single_choice' ? 'radio' : 'checkbox';
            const inputName = `questions[${questionIndex}][correct_option]${inputType === 'checkbox' ? '[]' : ''}`;
            const checkedAttr = isChecked ? 'checked' : '';
            
            div.innerHTML = `
                <input type="text" name="questions[${questionIndex}][options][${index}]" value="${value}" class="appearance-none bg-gray-950 border border-gray-800 text-gray-200 placeholder:text-gray-500 rounded-[14px] w-full px-4 py-3" placeholder="Enter answer ${index + 1}">
                <label class="relative flex items-center justify-center cursor-pointer" title="Tick for correct answer">
                    <input type="${inputType}" name="${inputName}" value="${index}" class="peer hidden" ${checkedAttr}>
                    <span class="w-10 h-10 flex items-center justify-center rounded-[11px] border border-[#C8C8C8] bg-black peer-checked:bg-white transition">
                        <svg class="hidden w-4 h-4 text-black peer-checked:block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </span>
                </label>
            `;
            return div;
        }

        function updateAnswerDisplay() {
            const selectedType = answerTypeSelect.value;

            // PERBAIKAN: Nonaktifkan (disable) semua input di semua container dulu
            choiceContainer.querySelectorAll('input, textarea').forEach(el => el.disabled = true);
            trueFalseContainer.querySelectorAll('input, textarea').forEach(el => el.disabled = true);
            textContainer.querySelectorAll('input, textarea').forEach(el => el.disabled = true);

            // Sembunyikan semua container
            choiceContainer.style.display = 'none';
            trueFalseContainer.style.display = 'none';
            textContainer.style.display = 'none';

            // Tampilkan container yang relevan dan AKTIFKAN inputnya
            if (selectedType === 'single_choice' || selectedType === 'multiple_choice') {
                choiceContainer.style.display = 'block';
                choiceContainer.querySelectorAll('input, textarea').forEach(el => el.disabled = false);
                
                // Render ulang pilihan untuk memastikan tipe input (radio/checkbox) sudah benar
                const currentOptions = Array.from(optionsContainer.querySelectorAll('input[type="text"]')).map(input => input.value);
                optionsContainer.innerHTML = '';
                optionCounter = 0;
                currentOptions.forEach(val => {
                    const newOption = createOptionInput(optionCounter, val);
                    optionsContainer.appendChild(newOption);
                    optionCounter++;
                });

            } else if (selectedType === 'true_false') {
                trueFalseContainer.style.display = 'block';
                trueFalseContainer.querySelectorAll('input, textarea').forEach(el => el.disabled = false);

            } else if (selectedType === 'text') {
                textContainer.style.display = 'block';
                textContainer.querySelectorAll('input, textarea').forEach(el => el.disabled = false);
            }
        }
        
        addOptionBtn.addEventListener('click', function() {
            const newOption = createOptionInput(optionCounter);
            optionsContainer.appendChild(newOption);
            optionCounter++;
            updateAnswerDisplay();
        });

        answerTypeSelect.addEventListener('change', updateAnswerDisplay);
        
        const oldOptionsData = @json(old('questions.' . $i . '.options', null));
        const oldCorrectOption = @json(old('questions.' . $i . '.correct_option', null));

        if (Array.isArray(oldOptionsData)) { 
            oldOptionsData.forEach((optionValue, index) => {
                let isChecked = false;
                if(oldCorrectOption !== null) {
                    if(Array.isArray(oldCorrectOption)) { 
                        isChecked = oldCorrectOption.includes(String(index));
                    } else { 
                        isChecked = String(oldCorrectOption) === String(index);
                    }
                }
                const optionEl = createOptionInput(index, optionValue, isChecked);
                optionsContainer.appendChild(optionEl);
                optionCounter = index + 1;
            });
        }
        
        if (optionsContainer.children.length === 0) {
            addOptionBtn.click();
            addOptionBtn.click();
        }
        updateAnswerDisplay();
    }

    document.querySelectorAll('.question-block').forEach((block, index) => {
        initializeQuestionBlock(block, index);
    });
});
</script>
@endpush
@endsection