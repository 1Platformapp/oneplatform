@php
    $stages = \App\Models\ManagementPlanStage::all();
@endphp
@foreach($stages as $key => $stage)
<div class="mt-12 each-stage-det {{$key == 0 ? '' : 'instant_hide'}}" data-id="{{$stage->id}}" data-stage-ref="{{$stage->name}}">
   <ul role="list" class="mt-3 grid grid-cols-1 gap-5 sm:gap-6">
        @foreach($stage->tasks as $index => $task)
        @php $status = $commonMethods->getSubmitData($stage->id, $task->id, $user->id, 'status'); @endphp
        <li data-task="{{$task->id}}" class="flex flex-col each-task">
            <div class="col-span-1 flex rounded-md shadow-sm">
                <div data-status="{{$status && $status != '' ? $status : 'default'}}" class="status-submit cursor-pointer flex w-16 flex-shrink-0 items-center justify-center rounded-l-md text-sm font-medium text-white">{{$index+1}}</div>
                <div class="cursor-pointer relative flex flex-1 items-center justify-between md:truncate rounded-r-md border-b border-r border-t border-gray-200 bg-white each-task-det-nav">
                    <div class="flex-1 md:truncate px-4 py-2 text-sm hover:bg-gray-50">
                        <div class="font-medium text-gray-900 hover:text-gray-600">{{$task->title}}</div>
                        <p class="text-gray-500">{{$task->sub_title}}</p>
                    </div>
                    @if($task->button_text && $task->button_link)
                    <a class="nav" href="{{$task->button_link}}">
                        <span class="absolute right-2 top-2 md:right-6 md:top-4 text-gray-400 hover:text-gray-700">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
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
                <div class="grid grid-cols-1 gap-x-8 gap-y-4 pt-5 md:grid-cols-3">
                    <div class="md:px-4">
                        <h2 class="text-base leading-7 text-gray-900">Platform advice</h2>
                    </div>
                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2 p-6">
                        <p class="text-sm leading-6 text-gray-600">{!! nl2br($advice) !!}</p>
                    </div>
                </div>
                @endif
                @if($task->video_url)
                <div class="grid grid-cols-1 gap-x-8 gap-y-4 pt-5 md:grid-cols-3">
                    <div class="md:px-4">
                        <h2 class="text-base leading-7 text-gray-900">Video</h2>
                    </div>
                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2 p-6">
                        <iframe width="100%" height="400" src="{{$task->video_url}}"></iframe>
                    </div>
                </div>
                @endif
                @if($task->notes)
                <div class="grid grid-cols-1 gap-x-8 gap-y-4 pt-5 md:grid-cols-3 mb-5">
                    <div class="md:px-4">
                        <h2 class="text-base leading-7 text-gray-900">Notes / Storyboard</h2>
                    </div>
                    <div class="md:col-span-2">
                        <div class="col-span-full flex flex-col">
                            <div class="">
                                <textarea rows="3" class="auto-resize-textarea notes block w-full rounded-md border-0 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 outline-none p-2 sm:text-sm sm:leading-6">{{$commonMethods->getSubmitData($stage->id, $task->id, $user->id, 'notes')}}</textarea>
                            </div>
                            <button type="button" class="notes-submit rounded-md ml-auto mt-3 bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                        </div>
                    </div>
                </div>
                @endif
                @if($task->button_text && $task->button_link)
                <div class="grid grid-cols-1 gap-x-8 gap-y-8 pt-10 md:grid-cols-3 mb-5">
                    <div class="md:px-4">
                        <h2 class="text-base leading-7 text-gray-900">Button</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600"></p>
                    </div>
                    <div class="md:col-span-2">
                        <div class="col-span-full">
                            <a href="{{$task->button_link}}" class="rounded w-full block text-center bg-indigo-50 px-2 py-2 text-sm font-semibold text-indigo-600 shadow-sm hover:bg-indigo-100 w-full ring-1 ring-inset ring-indigo-600">
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
