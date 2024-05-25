{{-- 

/**
*
* Created a new component <x-rtl.widgets._w-activity-five/>.
* 
*/

--}}


<div class="widget widget-activity-five">

    <div class="widget-heading">
        <h5 class="">Timeline</h5>

        {{-- <div class="task-action">
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" id="activitylog" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-more-horizontal">
                        <circle cx="12" cy="12" r="1"></circle>
                        <circle cx="19" cy="12" r="1"></circle>
                        <circle cx="5" cy="12" r="1"></circle>
                    </svg>
                </a>

                <div class="dropdown-menu left" aria-labelledby="activitylog" style="will-change: transform;">
                    <a class="dropdown-item" href="javascript:void(0);">View All</a>
                    <a class="dropdown-item" href="javascript:void(0);">Mark as Read</a>
                </div>
            </div>
        </div> --}}
    </div>

    <div class="widget-content">

        <div class="w-shadow-top"></div>

        <div class="mt-container mx-auto">
            <div class="timeline-line">
                @foreach ($timelines as $timeline)
                    <div class="item-timeline timeline-new">
                        <div class="t-dot">
                            <div class="t-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                    <line x1="16" y1="2" x2="16" y2="6" />
                                    <line x1="8" y1="2" x2="8" y2="6" />
                                    <line x1="3" y1="10" x2="21" y2="10" />
                                </svg>
                                {{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg> --}}
                            </div>
                        </div>
                        <div class="t-content">
                            @php
                                if ($timeline->category == 'creat') {
                                    $ket = 'Masa Pembuatan Dipa Definitif';
                                } elseif ($timeline->category == 'pra-creat') {
                                    $ket = 'Masa Pembuatan Dipa Indikatif';
                                } elseif ($timeline->category == 'revison') {
                                    $ket = 'Masa Revisi Dipa';
                                } else {
                                    $ket = ' - ';
                                }
                            @endphp
                            <div class="t-uppercontent">
                                <h5>{{ $ket }} : <a href="javscript:void(0);"><span>[Tahun
                                            {{ $timeline->year }}]</span></a>
                                </h5>
                            </div>
                            <p>{{ substr($timeline->start, 0, 16) . ' s/d ' . substr($timeline->end, 0, 16) }}</p>
                        </div>
                    </div>
                @endforeach


                {{-- <div class="item-timeline timeline-new">
                    <div class="t-dot">
                        <div class="t-dark"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-server">
                                <rect x="2" y="2" width="20" height="8" rx="2" ry="2">
                                </rect>
                                <rect x="2" y="14" width="20" height="8" rx="2" ry="2">
                                </rect>
                                <line x1="6" y1="6" x2="6" y2="6"></line>
                                <line x1="6" y1="18" x2="6" y2="18"></line>
                            </svg></div>
                    </div>
                    <div class="t-content">
                        <div class="t-uppercontent">
                            <h5>Server rebooted successfully</h5>
                            <span class=""></span>
                        </div>
                        <p>10 Apr, 2022</p>
                    </div>
                </div> --}}
            </div>
        </div>

        <div class="w-shadow-bottom"></div>
    </div>
</div>
