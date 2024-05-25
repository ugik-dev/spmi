{{-- 

/**
*
* Created a new component <x-widgets._w-card-five/>.
* 
*/

--}}


<div class="widget widget-card-five mb-2">
    <div class="widget-content">
        <div class="account-box">

            <div class="info-box">
                <div class="icon">
                    <span>
                        <img src="{{ Vite::asset('resources/images/money-bag.png') }}" alt="money-bag">
                    </span>
                </div>

                <div class="balance-info">
                    <h6>{{ $title . ' [' . $unitBudget->workUnit->name . '] [' . $year . ']' }}</h6>
                    <p>Rp {{ number_format($unitBudget->pagu) }}</p>
                </div>
            </div>
            {{-- 
            <div class="card-bottom-section">
                <div><span
                        class="badge badge-light-success">{{ number_format(($unitBudget->pagu_ins / $unitBudget->pagu) * 100) }}
                        %
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-trending-up">
                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                            <polyline points="17 6 23 6 23 12"></polyline>
                        </svg></span></div>
            </div> --}}
        </div>
    </div>
</div>
