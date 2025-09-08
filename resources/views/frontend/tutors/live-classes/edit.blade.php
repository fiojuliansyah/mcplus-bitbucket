@extends('frontend.layouts.app')

@section('content')
<section class="w-full bg-primary text-white px-4 py-10">
    <div class="w-full max-w-screen-xl mx-auto pb-10">
        <div class="flex flex-col lg:flex-row justify-between gap-5 lg:items-end border-b border-white/10">
            <div class="flex items-center gap-3">
                <img src="/frontend/assets/images/tutor-profile-vector.svg" alt="Tutor Avatar" class="w-28" />
                <div>
                    <span class="text-gray-250">Tutor Dashboard</span>
                    <h1 class="text-4xl font-bold tracking-tight text-white">{{ $title }}</h1>
                </div>
            </div>
            <div class="flex items-center gap-1 mb-3">
                <a href="{{ route('tutor.dashboard') }}" class="text-gray-910 text-[15px] font-medium">Home</a>
                <span class="text-white text-[15px] font-medium">> Edit Class</span>
            </div>
        </div>

        <div class="space-y-10 divide-y divide-zinc-700">
            <div class="w-full pt-10">
                <div class="grid grid-cols-12">
                    <div class="col-span-12">
                        <div class="flex items-center gap-10 mb-10">
                            <a href="{{ url()->previous() }}"
                                class="bg-white rounded-full w-8 h-8 flex items-center justify-center cursor-pointer">
                                <img src="/frontend/assets/icons/arrow-left.svg" alt="Icon" class="size-4">
                            </a>
                            <h6 class="text-[20px] text-gray-75 font-semibold">Edit Class Schedule: {{ $liveClass->subject->name }}</h6>
                        </div>

                        <form action="{{ route('tutor.live-classes.update', $liveClass->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-12 gap-5">
                                <div class="col-span-12 lg:col-span-2">
                                    <div class="flex flex-col gap-3 items-center">
                                        <div class="flex items-center justify-center">
                                            <img src="/frontend/assets/images/sample/image-1.png" alt="Image"
                                                class="w-[154px] h-[186px] rounded-[13px] object-cover" />
                                        </div>
                                        <span class="font-bebas">{{ $liveClass->subject->name }} - {{ $liveClass->subject->grade->name }}</span>
                                    </div>
                                </div>

                                <div class="col-span-12 lg:col-span-9">
                                    <div class="grid grid-cols-12 gap-x-10 gap-y-6">

                                        <div class="col-span-12">
                                            <label for="topic_name" class="block mb-2 text-[15px] font-medium text-gray-200">Topic Name</label>
                                            <input type="text" id="topic_name" name="topic_name" required
                                                class="bg-gray-1000 border border-gray-950 text-gray-75 placeholder:text-gray-500 rounded-[14px] w-full px-4 py-3"
                                                placeholder="Enter a name for the topic" 
                                                value="{{ old('topic_name', $liveClass->topic->name) }}" />
                                        </div>
                                        
                                        <div class="col-span-12">
                                            <label for="agenda" class="block mb-2 text-[15px] font-medium text-gray-200">Agenda</label>
                                            <textarea id="agenda" name="agenda" rows="3" required
                                                class="bg-gray-1000 border border-gray-950 text-gray-75 placeholder:text-gray-500 rounded-[14px] w-full px-4 py-3"
                                                placeholder="Enter class agenda or main points">{{ old('agenda', $liveClass->agenda) }}</textarea>
                                        </div>

                                        <div class="col-span-12 lg:col-span-6">
                                            <label for="start_time" class="block mb-2 text-[15px] font-medium text-gray-200">Start Time</label>
                                            <input type="datetime-local" id="start_time" name="start_time" required
                                                class="bg-gray-1000 border border-gray-950 text-gray-75 placeholder:text-gray-500 rounded-[14px] w-full px-4 py-3"
                                                value="{{ old('start_time', \Carbon\Carbon::parse($liveClass->start_time)->format('Y-m-d\TH:i')) }}" />
                                        </div>

                                        <div class="col-span-12 lg:col-span-6">
                                            <label for="duration" class="block mb-2 text-[15px] font-medium text-gray-200">Duration (Minutes)</label>
                                            <input type="number" id="duration" name="duration" required
                                                class="bg-gray-1000 border border-gray-950 text-gray-75 placeholder:text-gray-500 rounded-[14px] w-full px-4 py-3"
                                                placeholder="e.g. 90" 
                                                value="{{ old('duration', $liveClass->duration) }}" />
                                        </div>

                                        <div class="col-span-12 lg:col-span-6">
                                            <label class="block mb-2 text-[15px] font-medium text-gray-200">Zoom Settings</label>
                                            <div class="space-y-2 mt-2 text-gray-200">
                                                @php
                                                    $settings = $liveClass->settings ?? [];
                                                @endphp
                                                <div class="flex items-center gap-x-3"><input type="checkbox" name="settings[join_before_host]" value="1" class="size-4 bg-gray-950 rounded border-gray-700 text-blue-600" {{ old('settings.join_before_host', $settings['join_before_host'] ?? false) ? 'checked' : '' }}><span>Join Before Host</span></div>
                                                <div class="flex items-center gap-x-3"><input type="checkbox" name="settings[host_video]" value="1" class="size-4 bg-gray-950 rounded border-gray-700 text-blue-600" {{ old('settings.host_video', $settings['host_video'] ?? false) ? 'checked' : '' }}><span>Host Video On</span></div>
                                                <div class="flex items-center gap-x-3"><input type="checkbox" name="settings[participant_video]" value="1" class="size-4 bg-gray-950 rounded border-gray-700 text-blue-600" {{ old('settings.participant_video', $settings['participant_video'] ?? false) ? 'checked' : '' }}><span>Participant Video On</span></div>
                                                <div class="flex items-center gap-x-3"><input type="checkbox" name="settings[mute_upon_entry]" value="1" class="size-4 bg-gray-950 rounded border-gray-700 text-blue-600" {{ old('settings.mute_upon_entry', $settings['mute_upon_entry'] ?? false) ? 'checked' : '' }}><span>Mute Upon Entry</span></div>
                                                <div class="flex items-center gap-x-3"><input type="checkbox" name="settings[waiting_room]" value="1" class="size-4 bg-gray-950 rounded border-gray-700 text-blue-600" {{ old('settings.waiting_room', $settings['waiting_room'] ?? false) ? 'checked' : '' }}><span>Enable Waiting Room</span></div>
                                            </div>
                                        </div>

                                        <div class="col-span-12 lg:col-span-6 space-y-4">
                                            <div>
                                                <label for="audio" class="block mb-2 text-[15px] font-medium text-gray-200">Audio</label>
                                                <select id="audio" name="settings[audio]" class="appearance-none pr-10 bg-gray-1000 border border-gray-950 text-gray-75 rounded-[14px] w-full px-4 py-3">
                                                    <option value="both" {{ old('settings.audio', $settings['audio'] ?? 'both') == 'both' ? 'selected' : '' }}>Both</option>
                                                    <option value="telephony" {{ old('settings.audio', $settings['audio'] ?? 'both') == 'telephony' ? 'selected' : '' }}>Telephony</option>
                                                    <option value="voip" {{ old('settings.audio', $settings['audio'] ?? 'both') == 'voip' ? 'selected' : '' }}>VoIP</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label for="auto_recording" class="block mb-2 text-[15px] font-medium text-gray-200">Auto Recording</label>
                                                <select id="auto_recording" name="settings[auto_recording]" class="appearance-none pr-10 bg-gray-1000 border border-gray-950 text-gray-75 rounded-[14px] w-full px-4 py-3">
                                                    <option value="none" {{ old('settings.auto_recording', $settings['auto_recording'] ?? 'none') == 'none' ? 'selected' : '' }}>None</option>
                                                    <option value="local" {{ old('settings.auto_recording', $settings['auto_recording'] ?? 'none') == 'local' ? 'selected' : '' }}>Local</option>
                                                    <option value="cloud" {{ old('settings.auto_recording', $settings['auto_recording'] ?? 'none') == 'cloud' ? 'selected' : '' }}>Cloud</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label for="approval_type" class="block mb-2 text-[15px] font-medium text-gray-200">Approval Type</label>
                                                <select id="approval_type" name="settings[approval_type]" class="appearance-none pr-10 bg-gray-1000 border border-gray-950 text-gray-75 rounded-[14px] w-full px-4 py-3">
                                                    <option value="0" {{ old('settings.approval_type', $settings['approval_type'] ?? 0) == 0 ? 'selected' : '' }}>Automatically Approve</option>
                                                    <option value="1" {{ old('settings.approval_type', $settings['approval_type'] ?? 0) == 1 ? 'selected' : '' }}>Manually Approve</option>
                                                    <option value="2" {{ old('settings.approval_type', $settings['approval_type'] ?? 0) == 2 ? 'selected' : '' }}>No Registration Required</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-span-12 mt-4">
                                            <button type="submit" class="bg-gray-50 hover:bg-gray-200 rounded-full text-sm px-8 py-3 w-full">
                                                <span class="text-black text-[16px] font-semibold">Update Schedule</span>
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