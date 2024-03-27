@php
    $stages = \App\Models\ManagementPlanStage::all();
    $skillName = $skill == '' ? $user->skills : $skill;
    $skill = \App\Models\Skill::where(['value' => $skillName])->get()->first();
    $skillTasks = $skill ? \App\Models\SkillManagementPlanTask::where(['skill_id' => $skill->id])->get()->pluck('management_plan_task_id')->toArray() : [];
@endphp
@foreach($stages as $key => $stage)
<div class="mt-12 each-stage-det {{$key == 0 ? '' : 'instant_hide'}}" data-id="{{$stage->id}}" data-stage-ref="{{$stage->name}}">
   <ul role="list" class="grid grid-cols-1 gap-5 mt-3 sm:gap-6">
        @foreach($stage->tasks as $index => $task)
        @if(!in_array($task->id, $skillTasks)) @php continue @endphp @endif
        @php $status = $commonMethods->getSubmitData($stage->id, $task->id, $user->id, 'status'); @endphp
        <li data-task="{{$task->id}}" class="flex flex-col each-task">
            <div class="flex col-span-1 rounded-md shadow-sm">
                <div data-status="{{$status && $status != '' ? $status : 'default'}}" class="flex items-center justify-center flex-shrink-0 w-16 text-sm font-medium text-white cursor-pointer status-submit rounded-l-md">
                    <i class="{{ $commonMethods->getManagementPlanStatusIcon($status) }}"></i>
                </div>
                <div class="relative flex items-center justify-between flex-1 bg-white border-t border-b border-r border-gray-200 cursor-pointer md:truncate rounded-r-md each-task-det-nav">
                    <div class="flex-1 px-4 py-2 text-sm md:truncate hover:bg-gray-50">
                        <div class="font-medium text-gray-900 hover:text-gray-600">{{$task->title}}</div>
                        <p class="text-gray-500">{{$task->sub_title}}</p>
                    </div>
                    @if($task->button_text && $task->button_link)
                    <a class="nav" href="{{$task->button_link}}">
                        <span class="absolute text-gray-400 right-2 top-2 md:right-6 md:top-4 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                            </svg>
                        </span>
                    </a>
                    @endif
                </div>
            </div>
            <div class="each-task-det md:mx-10 instant_hide">
                @if($task->advice)
                @php $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@' @endphp
                @php $advice = preg_replace($url, '<a class="hover:underline" href="$0" target="_blank" title="Click here">$0</a>', $task->advice); @endphp
                <div class="grid grid-cols-1 pt-5 gap-x-8 gap-y-4 md:grid-cols-3">
                    <div class="md:px-4">
                        <h2 class="text-base leading-7 text-gray-900">Platform advice</h2>
                    </div>
                    <div class="p-6 bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                        <p class="text-sm leading-6 text-gray-600">{!! nl2br($advice) !!}</p>
                    </div>
                </div>
                @endif
                @if($task->video_url)
                <div class="grid grid-cols-1 pt-5 gap-x-8 gap-y-4 md:grid-cols-3">
                    <div class="md:px-4">
                        <h2 class="text-base leading-7 text-gray-900">Video</h2>
                    </div>
                    <div class="p-6 bg-white shadow-sm ring-1 xs2:h-280 md:h-400 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                        <iframe class="w-full h-full" src="{{$task->video_url}}"></iframe>
                    </div>
                </div>
                @endif
                @if($task->notes)
                <div class="grid grid-cols-1 pt-5 mb-5 gap-x-8 gap-y-4 md:grid-cols-3">
                    <div class="md:px-4">
                        <h2 class="text-base leading-7 text-gray-900">Notes / Storyboard</h2>
                    </div>
                    <div class="md:col-span-2">
                        <div class="flex flex-col col-span-full">
                            <div class="">
                                <textarea rows="3" class="block w-full p-2 text-gray-900 border-0 rounded-md shadow-sm outline-none auto-resize-textarea notes ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">{{$commonMethods->getSubmitData($stage->id, $task->id, $user->id, 'notes')}}</textarea>
                            </div>
                            <button type="button" class="px-3 py-2 mt-3 ml-auto text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm notes-submit hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                        </div>
                    </div>
                </div>
                @endif
                @if($task->button_text && $task->button_link)
                <div class="grid grid-cols-1 pt-10 mb-5 gap-x-8 gap-y-8 md:grid-cols-3">
                    <div class="md:px-4">
                        <h2 class="text-base leading-7 text-gray-900">Button</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600"></p>
                    </div>
                    <div class="md:col-span-2">
                        <div class="col-span-full">
                            <a href="{{$task->button_link}}" class="block w-full px-2 py-2 text-sm font-semibold text-center text-indigo-600 rounded shadow-sm bg-indigo-50 hover:bg-indigo-100 ring-1 ring-inset ring-indigo-600">
                            {{$task->button_text}}
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </li>
        @endforeach
   </ul>
</div>
@endforeach

<script>
    const textareas = document.querySelectorAll('.auto-resize-textarea');
    function adjustTextareaHeight(textarea) {
        textarea.style.height = 'auto';
        const minHeight = '150px';
        textarea.style.height = Math.max(textarea.scrollHeight, parseInt(minHeight)) + 'px';
    }
    textareas.forEach(textarea => {
        adjustTextareaHeight(textarea);
        textarea.addEventListener('input', () => {
            adjustTextareaHeight(textarea);
        });
    });
</script>
