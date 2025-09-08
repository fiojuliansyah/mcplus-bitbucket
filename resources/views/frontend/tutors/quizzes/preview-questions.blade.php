@extends('frontend.layouts.app')

@section('content')
<section class="w-full bg-primary text-white px-4 py-10">
    <div class="w-full max-w-screen-xl mx-auto pb-10">
        <!-- HEADER -->
        <div class="flex flex-col lg:flex-row justify-between gap-5 lg:items-end border-b border-white/10 pb-5">
            <div class="flex items-center gap-3">
                <img src="{{ asset('frontend/assets/images/student-profile-vector.svg') }}" alt="Tutor Avatar" class="w-28" />
                <div>
                    <span class="text-gray-250">Tutor Dashboard</span>
                    <h1 class="text-4xl font-bold tracking-tight text-white">Quiz Preview</h1>
                </div>
            </div>
            <div class="flex items-center gap-1 mb-3">
                <span class="text-gray-400 text-[15px] font-medium">Home > Quizzes ></span>
                <span class="text-white text-[15px] font-medium">Preview</span>
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

            <!-- Question Previewer -->
            <div class="pt-10">
                <div class="grid grid-cols-12 gap-10">
                    <div class="col-span-12 lg:col-span-2">
                        <div>
                            <div class="flex items-center justify-center gap-2 h-full">
                                <h1 id="question-current-number" class="text-center text-[200px] text-gray-75 font-bold">1</h1>
                                <div id="question-total-number" class="text-[41px] leading-none text-gray-75 mt-[7rem]">/ {{ $quizz->questions->count() }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 lg:col-span-10">
                        <div class="flex flex-col justify-between border border-white gap-10 rounded-[21px] p-12 min-h-[500px]">
                            <!-- Question -->
                            <div>
                                <div class="flex gap-2 mb-5">
                                    <span id="question-number-text" class="text-white">1.</span>
                                    <p id="question-text" class="text-white"></p>
                                </div>
                                <div id="question-media-container"></div>
                            </div>

                            <!-- Answers -->
                            <div id="answers-container" class="flex flex-col gap-5"></div>

                            <!-- Action -->
                            <div class="flex items-center justify-center gap-5">
                                <button id="prev-question-btn" class="bg-white rounded-full w-8 h-8 flex items-center justify-center cursor-pointer">
                                    <img src="{{ asset('frontend/assets/icons/angle-left.svg') }}" alt="Icon" class="size-3">
                                </button>
                                <button id="next-question-btn" class="bg-white rounded-full w-8 h-8 flex items-center justify-center cursor-pointer">
                                    <img src="{{ asset('frontend/assets/icons/angle-right.svg') }}" alt="Icon" class="size-3">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Publish Form -->
            <div class="pt-10">
                 <form id="publish-form" action="{{ route('tutor.quizzes.publish', $quizz->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" id="action-input">
                    <div class="grid grid-cols-12 gap-10">
                         <div class="col-span-12 lg:col-span-2"></div>
                         <div class="col-span-12 lg:col-span-10">
                             <div class="grid grid-cols-12 gap-10">
                                <div class="col-span-12 md:col-span-6">
                                     <div>
                                         <label for="published_at" class="block mb-2 text-[15px] font-medium text-gray-200">Publish On</label>
                                         <input type="date" name="published_at" id="published_at" min="{{ now()->toDateString() }}" class="appearance-none bg-gray-1000 border border-gray-950 text-gray-75 placeholder:text-gray-500 rounded-[14px] w-full px-4 py-3" required>
                                         @error('published_at') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                     </div>
                                 </div>
                                 <div class="col-span-12 md:col-span-6">
                                     <div class="flex items-end h-full gap-5">
                                         <button type="submit" data-action="publish" class="publish-btn bg-gray-50 hover:bg-gray-200 rounded-full text-sm px-8 py-3 w-full">
                                             <span class="text-black text-[16px] font-semibold">Publish</span>
                                         </button>
                                         <button type="submit" data-action="save_draft" class="publish-btn bg-gray-800 hover:bg-gray-700 rounded-full text-sm px-8 py-3 w-full">
                                             <span class="text-white text-[16px] font-semibold">Save Draft</span>
                                         </button>
                                     </div>
                                 </div>
                             </div>
                         </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const questions = @json($quizz->questions);
    let currentQuestionIndex = 0;

    const currentNumEl = document.getElementById('question-current-number');
    const qNumTextEl = document.getElementById('question-number-text');
    const qTextEl = document.getElementById('question-text');
    const mediaContainerEl = document.getElementById('question-media-container');
    const answersContainerEl = document.getElementById('answers-container');
    const prevBtn = document.getElementById('prev-question-btn');
    const nextBtn = document.getElementById('next-question-btn');

    function renderQuestion(index) {
        if (!questions || questions.length === 0) return;
        const question = questions[index];

        // Update numbers
        currentNumEl.textContent = index + 1;
        qNumTextEl.textContent = `${index + 1}.`;
        qTextEl.textContent = question.question_text;

        // Update Media
        mediaContainerEl.innerHTML = '';
        if (question.media_url) {
            let mediaEl;
            if (question.media_type === 'image') {
                mediaEl = document.createElement('img');
                mediaEl.src = `/storage/${question.media_url}`;
                mediaEl.alt = 'Question Media';
                mediaEl.className = 'w-60 rounded-lg mt-4';
            } else if (question.media_type === 'video') {
                mediaEl = document.createElement('video');
                mediaEl.controls = true;
                mediaEl.className = 'w-full max-w-md rounded-lg mt-4';
                const sourceEl = document.createElement('source');
                sourceEl.src = `/storage/${question.media_url}`;
                sourceEl.type = 'video/mp4';
                mediaEl.appendChild(sourceEl);
            }
            if(mediaEl) mediaContainerEl.appendChild(mediaEl);
        }

        // Update Answers
        answersContainerEl.innerHTML = '';
        if (question.answer_type === 'single_choice' || question.answer_type === 'multiple_choice') {
            question.options.forEach((option, optionIndex) => {
                const isCorrect = question.correct_answer.includes(String(optionIndex));
                const label = document.createElement('label');
                label.className = `flex items-center gap-3 text-white rounded-[15px] py-3 px-6 cursor-not-allowed ${isCorrect ? 'bg-green-800/50 border border-green-500' : 'bg-gray-925'}`;
                
                const inputType = question.answer_type === 'single_choice' ? 'radio' : 'checkbox';
                
                label.innerHTML = `
                    <span class="w-6 h-6 rounded-full border-2 ${isCorrect ? 'border-green-400' : 'border-gray-300'} flex items-center justify-center">
                        ${isCorrect ? '<span class="w-3 h-3 rounded-full bg-green-400"></span>' : ''}
                    </span>
                    <span class="text-base">${option.text}</span>
                `;
                answersContainerEl.appendChild(label);
            });
        } else if(question.answer_type === 'true_false') {
             ['True', 'False'].forEach(optionText => {
                const isCorrect = question.correct_answer.includes(optionText.toLowerCase());
                const label = document.createElement('label');
                label.className = `flex items-center gap-3 text-white rounded-[15px] py-3 px-6 cursor-not-allowed ${isCorrect ? 'bg-green-800/50 border border-green-500' : 'bg-gray-925'}`;
                label.innerHTML = `
                     <span class="w-6 h-6 rounded-full border-2 ${isCorrect ? 'border-green-400' : 'border-gray-300'} flex items-center justify-center">
                        ${isCorrect ? '<span class="w-3 h-3 rounded-full bg-green-400"></span>' : ''}
                    </span>
                    <span class="text-base">${optionText}</span>
                `;
                answersContainerEl.appendChild(label);
             });
        } else if(question.answer_type === 'text') {
            const answerHtml = `
                <div class="text-left">
                    <p class="text-gray-400 text-sm mb-2">Model Answer:</p>
                    <div class="bg-gray-925 p-4 rounded-lg">
                        <p class="text-white italic">${question.options && question.options[0] ? question.options[0].text : 'No model answer provided.'}</p>
                    </div>
                </div>`;
            answersContainerEl.innerHTML = answerHtml;
        }

        // Update button states
        prevBtn.disabled = index === 0;
        nextBtn.disabled = index === questions.length - 1;
        prevBtn.classList.toggle('opacity-50', index === 0);
        nextBtn.classList.toggle('opacity-50', index === questions.length - 1);
    }

    prevBtn.addEventListener('click', () => {
        if (currentQuestionIndex > 0) {
            currentQuestionIndex--;
            renderQuestion(currentQuestionIndex);
        }
    });

    nextBtn.addEventListener('click', () => {
        if (currentQuestionIndex < questions.length - 1) {
            currentQuestionIndex++;
            renderQuestion(currentQuestionIndex);
        }
    });

    // Handle Publish/Draft form submission
    const publishForm = document.getElementById('publish-form');
    const actionInput = document.getElementById('action-input');
    document.querySelectorAll('.publish-btn').forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const action = e.currentTarget.dataset.action;
            actionInput.value = action;
            
            // For 'save_draft', we can remove the 'required' attribute from the date
            const dateInput = document.getElementById('published_at');
            if (action === 'save_draft') {
                dateInput.removeAttribute('required');
            } else {
                dateInput.setAttribute('required', 'required');
            }
            
            publishForm.submit();
        });
    });

    // Initial render
    renderQuestion(currentQuestionIndex);
});
</script>
@endpush