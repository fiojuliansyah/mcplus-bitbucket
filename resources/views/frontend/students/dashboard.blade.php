@extends('frontend.layouts.app')

@section('content')
<section class="w-full bg-primary text-white px-4 py-10">
	<div class="w-full max-w-screen-xl mx-auto">
		<!-- HEADER -->
		<div class="flex flex-col lg:flex-row justify-between gap-5 lg:items-end border-b border-white/10">
			<!-- LEFT SECTION -->
			<div class="flex items-center gap-3">
				<img src="/frontend/assets/images/student-profile-vector.svg" alt="Tutor Avatar" class="w-28" />
				<div>
					<span class="text-gray-250">Student Dashboard</span>
					<h1 class="text-4xl font-bold tracking-tight text-white">Welcome Back!</h1>
				</div>
			</div>
		</div>

		<!-- CONTENT -->
		<div class="space-y-10 divide-y divide-zinc-700">
			<div class="w-full pt-10">
				<div class="grid grid-cols-12 gap-5">
					<div class="col-span-12 md:col-span-12 lg:col-span-8 pr-5 border-r border-gray-510">
						<!-- UPCOMING CLASSES -->
						<section class="mb-10">
							<!-- HEADING -->
							<div class="flex items-center gap-3 mb-6">
								<img src="/frontend/assets/icons/upcoming-classes.svg" alt="Icon" class="size-6">
								<h6 class="text-[20px] text-gray-75 font-semibold">Upcoming Classes</h6>
							</div>

							<!-- CONTENT -->
							<div class="grid grid-cols-12 gap-8">
								@php
									$firstSub = $subscriptions->first();
									$remainingSubs = $subscriptions->skip(1);
									$mainClass = $firstSub ? $firstSub->liveClass : null;
								@endphp

								<!-- LEFT: Main Class -->
								@if($mainClass)
								<div class="col-span-12 md:col-span-12 lg:col-span-6">
									<div class="grid grid-cols-12 gap-8 border border-white rounded-[21px] p-5">
										<div class="col-span-5">
											<div class="relative h-auto lg:h-[170px] w-[250px] lg:w-[140px] rounded-[13px]">
												<img src="{{ $mainClass->image ?? '/frontend/assets/images/sample/image-1.png' }}" 
													alt="Image" class="h-full w-full rounded-[13px] object-cover">
												<div class="absolute w-full flex items-center gap-3 rounded-b-[13px] bg-gray-800 bottom-0 py-2 px-2">
													<img src="/frontend/assets/icons/clock.svg" alt="Icon" class="size-4">
													<span class="text-white text-[10px]">
														{{ \Carbon\Carbon::parse($mainClass->start_time)->format('d M · H:i') }}
													</span>
												</div>
											</div>
										</div>
										<div class="col-span-7 flex flex-col justify-between">
											<div class="flex flex-col">
												<span class="text-white uppercase font-bebas">{{ $mainClass->subject->name ?? 'Class' }}</span>
												<span class="text-white text-xl uppercase font-bebas">{{ $mainClass->topic->name ?? $mainClass->title }}</span>
											</div>
											<a href="{{ route('user.live-class.show', $mainClass->id) }}" 
											class="bg-gray-50 hover:bg-gray-200 rounded-full text-sm px-5 py-3 cursor-pointer text-black text-[16px] font-semibold flex justify-center">
											Join Now
											</a>
										</div>
									</div>
								</div>
								@endif

								<!-- RIGHT: Carousel -->
								<div class="col-span-12 md:col-span-12 lg:col-span-6 relative">
									<!-- Tombol kiri -->
									<button onclick="scrollLeft()" 
										class="absolute left-0 top-1/2 transform -translate-y-1/2 z-10 bg-white rounded-full w-10 h-10 flex items-center justify-center shadow-md">
										<img src="/frontend/assets/icons/angle-left.svg" alt="Icon" class="size-3">
									</button>

									<!-- Carousel -->
									<div id="upcomingClasses" class="flex gap-4 overflow-x-auto scrollbar-hide px-2">
										@foreach($remainingSubs as $sub)
											@php $class = $sub->liveClass; @endphp
											@if($class)
											<div class="flex-shrink-0 w-[150px] lg:w-[180px] rounded-[21px] p-3">
												<div class="relative h-[170px] rounded-[13px] overflow-hidden">
													
													<img src="{{ $class->image ?? '/frontend/assets/images/sample/image-1.png' }}" 
														alt="Image" class="h-full w-full object-cover rounded-[13px]">

													<!-- Overlay Title di atas start time -->
													<div class="absolute bottom-6 left-0 w-full text-white p-2 flex flex-col rounded-t-[5px]">
														<span class="uppercase font-bebas text-[10px]">{{ $class->subject->name ?? 'Class' }}</span>
														<span class="uppercase font-semibold text-sm truncate">{{ $class->topic->name ?? $class->title }}</span>
													</div>

													<!-- Start Time -->
													<div class="absolute bottom-0 w-full bg-gray-800/80 flex items-center gap-2 py-1 px-2 rounded-b-[13px]">
														<img src="/frontend/assets/icons/clock.svg" alt="Icon" class="size-4">
														<span class="text-white text-[10px]">
															{{ \Carbon\Carbon::parse($class->start_time)->format('d M · H:i') }}
														</span>
													</div>
												</div>
											</div>
											@endif
										@endforeach

									</div>

									<!-- Tombol kanan -->
									<button onclick="scrollRight()" 
										class="absolute right-0 top-1/2 transform -translate-y-1/2 z-10 bg-white rounded-full w-10 h-10 flex items-center justify-center shadow-md">
										<img src="/frontend/assets/icons/angle-right.svg" alt="Icon" class="size-3">
									</button>
								</div>
							</div>
						</section>

						<!-- STILL TO DO -->
						<section>
							<!-- HEADING -->
							<div class="flex items-center gap-3 mb-6">
								<img src="/frontend/assets/icons/file.svg" alt="Icon" class="size-6">
								<h6 class="text-[20px] text-gray-75 font-semibold">Still To Do</h6>
							</div>

							<!-- TABS -->
							<div class="tabs flex rounded-t-[21px]" data-group="group-tabs-1">
								<button type="button"
									class="tab-btn active w-full rounded-tl-[21px] px-2 py-4 text-center cursor-pointer"
									data-tab="#tab1" data-group="group-tabs-1">
									<span class="text-[15px]">Quizzes</span>
								</button>
								<button type="button"
									class="tab-btn w-full rounded-tr-[21px] px-2 py-4 text-center cursor-pointer"
									data-tab="#tab2" data-group="group-tabs-1">
									<span class="text-[15px]">Feedback</span>
								</button>
							</div>

							<!-- TAB ITEM -->
							<div class="h-[60vh] lg:h-[90vh] overflow-y-auto mb-5">
								<!-- Tab Content Quizzes -->
								<div id="tab1" data-group="group-tabs-1"
									class="tab-content flex flex-col bg-gray-975 rounded-b-[21px] py-10 px-5">
									@foreach($subscriptions as $sub)
										@php $class = $sub->liveClass; @endphp
										@if($class)
											<div class="mb-5 border border-gray-510 rounded-[21px] p-5">
												<h6 class="text-white font-semibold mb-3">{{ $class->subject->name ?? 'Class' }} - {{ $class->topic->name ?? 'Topic' }}</h6>

												@if(isset($quizzesByClass[$sub->id]) && $quizzesByClass[$sub->id]->count() > 0)
													@foreach($quizzesByClass[$sub->id] as $quiz)
														<div class="flex gap-5 mb-4 p-4 bg-gray-975 rounded-[21px]">
															<img src="/frontend/assets/icons/quiz.svg" alt="Icon" class="size-14">
															<div class="flex flex-col mt-2">
																<div class="w-full flex items-center gap-2 py-2">
																	<img src="/frontend/assets/icons/clock.svg" alt="Icon" class="size-4">
																	<span class="text-gray-75 text-[12px]">{{ \Carbon\Carbon::parse($quiz->start_time ?? now())->format('d M · H:i') }}</span>
																</div>
																<span class="text-white mb-2">{{ $quiz->title }}</span>
																<button type="button" class="bg-gray-50 hover:bg-gray-200 rounded-full text-sm px-5 py-3 w-[195px]">
																	<span class="text-black text-[16px] font-semibold">Start Quiz</span>
																</button>
															</div>
														</div>
													@endforeach
												@else
													<span class="text-gray-400 text-sm">No quizzes available for this topic.</span>
												@endif
											</div>
										@endif
									@endforeach
								</div>
								<!-- Tab Content Feedback -->
								<div id="tab2" data-group="group-tabs-1" class="tab-content">
									<!-- Empty -->
								</div>
							</div>
						</section>
					</div>

					<!-- REPLAY VIDEOS -->
					<section class="col-span-12 md:col-span-12 lg:col-span-4">
						<!-- HEADING -->
						<div class="flex items-center gap-3 mb-6">
							<img src="/frontend/assets/icons/replay.svg" alt="Icon" class="size-6">
							<h6 class="text-[20px] text-gray-75 font-semibold">Replay Videos</h6>
						</div>
						<!-- CONTENT -->
						<div class="h-[70vh] lg:h-[135vh] overflow-y-auto">
							<div class="space-y-6 pr-4">
								@foreach($subscriptions as $sub)
									@php $class = $sub->liveClass; @endphp
									@if($class && isset($replaysByClass[$sub->id]))
										@forelse($replaysByClass[$sub->id] as $replay)
											<div data-modal-target="modal-{{ $replay->id }}"
												class="flex flex-col items-center justify-center gap-3 bg-black rounded-[21px] border border-gray-850 h-[250px] cursor-pointer">
												<img src="{{ $replay->image ?? '/frontend/assets/icons/replay.svg' }}" alt="Icon" class="w-16">
												<span class="text-[12px] text-white truncate">{{ $replay->title ?? 'Replay Available Soon' }}</span>
											</div>
										@empty
											<div data-modal-target="modal-1" class="flex flex-col items-center justify-center gap-3 bg-black rounded-[21px] border border-gray-850 h-[250px] cursor-pointer">
												<img src="/frontend/assets/icons/replay.svg" alt="Icon" class="w-16">
												<span class="text-[12px] text-white">Replay Available Soon for {{ $class->topic->name }}</span>
											</div>
										@endforelse
									@endif
								@endforeach
							</div>
						</div>
					</section>
				</div>
			</div>

			<!-- STUDENT LOG -->
			<div class="w-full pt-10">
				<div class="grid grid-cols-12">
					<div class="col-span-12 md:col-span-12 lg:col-span-12">
						<!-- HEADING -->
						<div class="flex items-center gap-3 mb-6 pt-5">
							<img src="/frontend/assets/icons/toga.svg" alt="Icon" class="size-6">
							<h6 class="text-[20px] text-gray-75 font-semibold">Student Log</h6>
						</div>

						<!-- CONTENT -->
						<div class="grid grid-cols-12 gap-6 lg:gap-10">
							<!-- TABS -->
							<div class="col-span-12 lg:col-span-8 lg:pr-5">
								<div class="tabs flex rounded-[21px] bg-black w-full py-4"
									data-group="group-tabs-2">
									<button type="button" class="tab-btn w-full text-center cursor-pointer"
										data-tab="#classes-and-notes" data-group="group-tabs-2">
										<span class="text-white">Classes And Notes</span>
									</button>
									<button type="button" class="tab-btn w-full text-center cursor-pointer"
										data-tab="#my-subjects" data-group="group-tabs-2">
										<span class="text-white">My Subjects</span>
									</button>
									<button type="button" class="tab-btn w-full text-center cursor-pointer"
										data-tab="#subscription-info" data-group="group-tabs-2">
										<span class="text-white">Subscription Info</span>
									</button>
								</div>
							</div>

							<!-- FILTER -->
							<div class="col-span-12 lg:col-span-4">
								<div class="flex flex-col lg:flex-row lg:items-center lg:justify-end gap-3">
									<label class="text-gray-200">Filter By:</label>
									<form class="w-full lg:w-[300px]">
										<select
											class="bg-gray-1000 border border-gray-950 text-gray-500 rounded-[14px] block w-full p-4">
											<option selected>Filter</option>
											<option value="" selected>Topic</option>
										</select>
									</form>
								</div>
							</div>
						</div>

						<!-- TAB Classes And Notes Content -->
						<div id="classes-and-notes" data-group="group-tabs-2" class="tab-content flex flex-col gap-10 mt-10">
							@foreach($subscriptions as $sub)
								@php 
									$class = $sub->liveClass;
									$notes = $notesByTopic[$sub->id] ?? collect();
								@endphp
								@if($class && $notes->count())
									@foreach($notes as $note)
										<div class="flex flex-col lg:flex-row gap-5 justify-between border-b border-gray-510 pb-10">
											<div class="flex gap-6">
												<div class="w-[100px] h-full bg-gray-925 p-5 rounded-[21px] text-white text-center">
													<span>{{ \Carbon\Carbon::parse($note->created_at)->format('d M (D)') }}</span>
													<div class="border border-white my-3"></div>
													<span>{{ \Carbon\Carbon::parse($note->created_at)->format('H:i A') }}</span>
												</div>
												<div class="flex flex-col gap-2">
													<h6 class="font-bold text-white">{{ $class->subject->name ?? 'Class' }}</h6>
													<span class="text-white max-w-lg">{{ $note->title ?? $note->description }}</span>
													<div class="flex items-center gap-5 mt-3">
														<span class="text-gray-275">Status :</span>
														<span class="w-[150px] inline-flex items-center justify-center 
															@if($note->status == 'Live') bg-green-900 text-green-100
															@elseif($note->status == 'Upcoming') bg-teal-900 text-blue-200
															@else bg-gray-950 text-yellow-200 @endif
															px-2 py-2 font-medium rounded-full">
															{{ $note->status ?? 'Unknown' }}
														</span>
													</div>
												</div>
											</div>
											<div class="flex flex-col justify-end gap-3">
												<div class="flex items-center gap-2">
													<span class="text-white text-[15px]">
														{{ $note->attachments_count ?? 0 }} Notes ( {{ $note->answer_keys_count ?? 0 }} answer keys)
													</span>
													<img src="/frontend/assets/icons/folder.svg" alt="Icon" class="size-5">
												</div>
												<a href="{{ $note->download_url ?? '#' }}" class="bg-gray-50 hover:bg-gray-200 rounded-full text-sm px-5 py-3 w-[195px] inline-flex items-center justify-center">
													<span class="text-black text-[16px] font-semibold">Download Note</span>
												</a>
											</div>
										</div>
									@endforeach
								@endif
							@endforeach
						</div>

						<!-- TAB My Subjects -->
						<div id="my-subjects" data-group="group-tabs-2" class="tab-content hidden my-10">
							@foreach($subjects as $subjectData)
								@php
									$subject = $subjectData['subject'];
									$topics = $subjectData['topics'];
								@endphp

								<div class="bg-gray-975 rounded-[21px] p-10 mt-10 grid grid-cols-12">
									<div class="col-span-12 lg:col-span-4 lg:pr-10">
										<div class="text-white mb-3">{{ $subject->name }} ({{ date('Y') }})</div>
										<div class="flex flex-col gap-3">
											<span class="text-gray-200">Filter By Topic:</span>
											<form class="w-full">
												<select
													class="bg-gray-1000 border border-gray-950 text-white placeholder:text-gray-500 rounded-[14px] w-full px-4 py-3">
													<option selected>Filter</option>
													@foreach($topics as $topicData)
														<option value="{{ $topicData['topic']->id }}">{{ $topicData['topic']->name }}</option>
													@endforeach
												</select>
											</form>
										</div>
									</div>

									<div class="col-span-12 lg:col-span-4 border-x border-gray-510 lg:px-10">
										@foreach($topics as $topicData)
											@php
												$topic = $topicData['topic'];
											@endphp
											<div>
												<div class="flex items-center gap-2 mb-5">
													<span class="text-gray-275 text-[15px]">Topics Covered:</span>
													<span class="text-white text-[15px]">{{ $topic->completed ?? 0 }}/{{ $topic->total ?? 0 }}</span>
												</div>
												<div class="text-gray-275 text-[15px] mb-2">Progress:</div>
												<div class="w-full lg:border border-[#523E06] rounded-full h-5">
													<div class="bg-[#523E06] h-5 rounded-full flex items-center justify-end px-3"
														style="width: {{ $topic->progress_percent ?? 0 }}%">
														<span class="text-white text-[12px]">{{ $topic->progress_percent ?? 0 }}%</span>
													</div>
												</div>
											</div>
										@endforeach
									</div>

									<div class="col-span-12 lg:col-span-4 lg:ps-10">
										@foreach($topics as $topicData)
											@php $topic = $topicData['topic']; @endphp
											<div class="flex flex-col items-center">
												<span class="text-gray-275 text-[15px]">Avg Quiz Score:</span>
												<span class="text-white text-[56px]">{{ $topic->avg_score ?? '0%' }}</span>
											</div>
										@endforeach
									</div>
								</div>

								<div class="flex justify-center mt-10">
									<button type="button"
										class="bg-gray-50 hover:bg-gray-200 rounded-full text-sm px-5 py-3 w-[40%] cursor-pointer">
										<span class="text-black text-[16px] font-semibold">Continue Learning</span>
									</button>
								</div>
							@endforeach
						</div>

						<!-- TAB Subscription Info -->
						<div id="subscription-info" data-group="group-tabs-2">
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section> 
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const container = document.getElementById('upcomingClasses');

    function scrollLeft() {
        container.scrollBy({ left: -180, behavior: 'smooth' });
    }

    function scrollRight() {
        container.scrollBy({ left: 180, behavior: 'smooth' });
    }
</script>
<script>
	$(".tab-btn").on("click", function () {
		const group = $(this).data("group");  
		const target = $(this).data("tab");

		$(`.tab-content[data-group='${group}']`).addClass("hidden");
		$(target).removeClass("hidden");

		$(`.tab-btn[data-group='${group}']`).removeClass("active");
		$(this).addClass("active");
	});


	document.querySelectorAll("[data-modal-target]").forEach(btn => {
		btn.addEventListener("click", () => {
			const target = btn.getAttribute("data-modal-target");
			document.getElementById(target).classList.remove("hidden");
		});
	});


	document.querySelectorAll("[data-modal-close]").forEach(btn => {
		btn.addEventListener("click", () => {
			btn.closest("div[id^='modal']").classList.add("hidden");
		});
	});

	document.querySelectorAll("div[id^='modal']").forEach(modal => {
		modal.addEventListener("click", e => {
			if (e.target === modal) modal.classList.add("hidden");
		});
	});
</script>
@endpush
