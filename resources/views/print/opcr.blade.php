<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OPCR - {{ Auth::user()->name }}</title>
    <style>
        @page {
            margin: 100px 50px 110px 50px;
        }

        #header {
            position: relative;
            left: 0px;
            top: -50px;
            right: 0px;
            text-align: center;
        }

        #footer {
            position: fixed;
            left: 0px;
            bottom:
                -100px;
            right: 0px;
            text-align: center;
        }

        * {
            font-size: 8px;
            font-family: Arial, Helvetica, sans-serif;
        }

        .top-table {
            width: 95%;
            margin: 10rem auto 4rem auto;
            border-collapse: collapse;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
        }

        .main-table td {
            border: 1px solid black;
        }

        th,
        .bordered {
            border: 1px solid black;
        }

        td,
        th {
            padding: 5px;
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .border-right {
            border-right: 1px solid black;
        }

        .border-bottom {
            border-bottom: 1px solid black;
        }

        .text-end {
            text-align: right;
        }

        .text-start {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div id="header">
        <img src="{{ public_path('images/logo/header.jpg') }}">
    </div>
    <div id="footer">
        <img src="{{ public_path('images/logo/footer.jpg') }}">
    </div>
    <div>
        <p style="font-size: 10px;">I, {{ Auth::user()->name }}, Student of IOC, commit to deliver and agree to be rated
            on the attainment of the following targets in accordance with the indicated measures for the period 2022.
        </p>
    </div>
    <div style="margin-top: 1rem; float: right;">
        <div style="text-align: center;">
            <p>______________________</p>
            <p>(Employee's Signature)</p>
            <p>Date: <u>{{ date('m-d-Y') }}</u></p>
        </div>
    </div>
    <table class="top-table">
        <thead>
            <tr>
                <th colspan="2">Reviewed By:</th>
                <th>Date:</th>
                <th colspan="2">Approved By:</th>
                <th>Date:</th>
                <th colspan="2">Rating Legend</th>
                <th colspan="2">Scale and Description</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <tr>
                <td colspan="2" rowspan="5" class="bordered">{{ $superior1->name }}</td>
                <td rowspan="5" class="bordered">{{ date('M d, Y', strtotime($approval->superior1_date)) }}</td>
                <td colspan="2" rowspan="5" class="bordered">{{ $superior2->name }}</td>
                <td rowspan="5" class="bordered">{{ date('M d, Y', strtotime($approval->superior2_date)) }}</td>
                <td class="bold">Q</td>
                <td class="border-right">Quality</td>
                <td class="bold">5</td>
                <td class="border-right">Outstanding</td>
            </tr>
            <tr>
                <td class="bold">E</td>
                <td class="border-right">Efficiency</td>
                <td class="bold">4</td>
                <td class="border-right">Very Satisfactory</td>
            </tr>
            <tr>
                <td class="bold">T</td>
                <td class="border-right">Timliness</td>
                <td class="bold">3</td>
                <td class="border-right">Satisfactory</td>
            </tr>
            <tr>
                <td class="bold">A</td>
                <td class="border-right">Average</td>
                <td class="bold">2</td>
                <td class="border-right">Unsatisfactory</td>
            </tr>
            <tr class="border-bottom">
                <td class="bold">NR</td>
                <td class="border-right">Not Rated</td>
                <td class="bold">1</td>
                <td class="border-right">Poor</td>
            </tr>
        </tbody>
    </table>

    <table class="main-table bordered">
        @php
            $totalCF = 0;
            $totalSTF = 0;
            $totalSF = 0;
            $numberCF = 0;
            $numberSTF = 0;
            $numberSF = 0;
        @endphp
        @foreach ($functs as $funct)
            <tbody>
                <tr>
                    <th rowspan="2" colspan="2">
                        {{ $funct->funct }}
                        @switch(strtolower($funct->funct))
                            @case('core function')
                                {{ $core }} {{ $percentage->core }}%
                            @break

                            @case('strategic function')
                                {{ $strategic }} {{ $percentage->strategic }}%
                            @break

                            @case('support function')
                                {{ $support }} {{ $percentage->support }}%
                            @break
                        @endswitch
                    </th>
                    <th rowspan="2">Success Indicator (Target + Measure)</th>
                    <th rowspan="2">Alloted Budget</th>
                    <th rowspan="2">Responsible Office/Person</th>
                    <th rowspan="2">Actual Accomplishment</th>
                    <th colspan="4">Rating</th>
                    <th rowspan="2">Remarks</th>
                </tr>
                <tr>
                    <th style="width: 50px;">E</th>
                    <th style="width: 50px;">Q</th>
                    <th style="width: 50px;">T</th>
                    <th style="width: 50px;">A</th>
                </tr>
                @php
                    $total = 0;
                    $number = 0;
                    $numberSubF = 0;
                @endphp
                @if ($funct->subFuncts)
                    @foreach ($funct->subFuncts as $subFunct)
                        @if ($subFunct->user_id == Auth::user()->id &&
                            $subFunct->user_type == $userType  &&
                            $subFunct->type == 'opcr' &&
                            $subFunct->duration_id == $duration->id)
                            @php
                                $total = 0;
                                $numberSubF = 0;
                            @endphp
                            <tr>
                                <td colspan="2">
                                    @foreach ($percentage->supports as $support)
                                        @if ($subFunct->sub_funct == $support->name)
                                            {{ $subFunct->sub_funct }} {{ $support->percent }}%
                                            @php
                                                $percent = $support->percent;
                                            @endphp
                                        @endif
                                    @endforeach
                                </td>
                                <td colspan="9">

                                </td>
                            </tr>
                            @foreach ($subFunct->outputs as $output)
                                @if ($output->user_id == Auth::user()->id &&
                                    $output->user_type == $userType  &&
                                    $output->type == 'opcr' &&
                                    $output->duration_id == $duration->id)
                                    @forelse ($output->suboutputs as $suboutput)
                                        @if ($suboutput->user_id == Auth::user()->id &&
                                        $suboutput->user_type == $userType  &&
                                        $suboutput->type == 'opcr' &&
                                        $suboutput->duration_id == $duration->id)
                                            <tr>
                                                <td>
                                                    {{ $output->code }} {{ ++$number }}
                                                </td>
                                                <td>
                                                    {{ $output->output }}
                                                </td>
                                                <td colspan="9"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" rowspan="{{ count($suboutput->targets) }}">
                                                {{ $suboutput->suboutput }}
                                                </td>
            
                                                @php
                                                    $first = true;
                                                @endphp
                                                @foreach ($suboutput->targets as $target)
                                                    @if ($target->user_id == Auth::user()->id &&
                                                        $target->user_type == $userType  &&
                                                        $target->type == 'opcr' &&
                                                        $target->duration_id == $duration->id)
                                                        @if ($first)
                                                            <td>{{ $target->target }}</td>
                                                            <td>{{ $target->rating->alloted_budget }}</td>
                                                            <td>{{ $target->rating->responsible }}</td>
                                                            <td>{{ $target->rating->accomplishment }}</td>
                                                            <td>
                                                                @if ($target->rating->efficiency)
                                                                    {{ $target->rating->efficiency }}
                                                                @else
                                                                    NR
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($target->rating->quality)
                                                                    {{ $target->rating->quality }}
                                                                @else
                                                                    NR
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($target->rating->timeliness)
                                                                    {{ $target->rating->timeliness }}
                                                                @else
                                                                    NR
                                                                @endif
                                                            </td>
                                                            <td>{{ $target->rating->average }}</td>
                                                            <td>{{ $target->rating->remarks }}</td>
                                                            @php
                                                                $first = false;
                                                            @endphp
                                                        @else
                                                            <tr>
                                                                <td>{{ $target->target }}</td>
                                                                <td>{{ $target->rating->alloted_budget }}</td>
                                                                <td>{{ $target->rating->responsible }}</td>
                                                                <td>{{ $target->rating->accomplishment }}</td>
                                                                <td>
                                                                    @if ($target->rating->efficiency)
                                                                        {{ $target->rating->efficiency }}
                                                                    @else
                                                                        NR
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($target->rating->quality)
                                                                        {{ $target->rating->quality }}
                                                                    @else
                                                                        NR
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($target->rating->timeliness)
                                                                        {{ $target->rating->timeliness }}
                                                                    @else
                                                                        NR
                                                                    @endif
                                                                </td>
                                                                <td>{{ $target->rating->average }}</td>
                                                                <td>{{ $target->rating->remarks }}</td>
                                                            </tr>
                                                        @endif
                                                        @switch($funct->funct)
                                                            @case('Core Function')
                                                                @php
                                                                    $totalCF += $target->rating->average;
                                                                    $numberCF++;
                                                                @endphp
                                                                @break
                                                            @case('Strategic Function')
                                                                @php
                                                                    $totalSTF += $target->rating->average;
                                                                    $numberSTF++;
                                                                @endphp
                                                                @break
                                                            @case('Support Function')
                                                                @php
                                                                    $total += $target->rating->average;
                                                                    $numberSubF++;
                                                                    $numberSF++;
                                                                @endphp
                                                                @break
                                                        @endswitch
                                                    @endif
                                                @endforeach
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td rowspan="{{ count($output->targets) }}">
                                                {{ $output->code }} {{ ++$number }}
                                            </td>
                                            <td rowspan="{{ count($output->targets) }}">
                                                {{ $output->output }}
                                            </td>
            
                                            @php
                                                $first = true;
                                            @endphp
                                            @foreach ($output->targets as $target)
                                                @if ($target->user_id == Auth::user()->id &&
                                                    $target->user_type == $userType  &&
                                                    $target->type == 'opcr' &&
                                                    $target->duration_id == $duration->id)
                                                    @if ($first)
                                                        <td>{{ $target->target }}</td>
                                                        <td>{{ $target->rating->alloted_budget }}</td>
                                                        <td>{{ $target->rating->responsible }}</td>
                                                        <td>{{ $target->rating->accomplishment }}</td>
                                                        <td>
                                                            @if ($target->rating->efficiency)
                                                                {{ $target->rating->efficiency }}
                                                            @else
                                                                NR
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($target->rating->quality)
                                                                {{ $target->rating->quality }}
                                                            @else
                                                                NR
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($target->rating->timeliness)
                                                                {{ $target->rating->timeliness }}
                                                            @else
                                                                NR
                                                            @endif
                                                        </td>
                                                        <td>{{ $target->rating->average }}</td>
                                                        <td>{{ $target->rating->remarks }}</td>
                                                        @php
                                                            $first = false;
                                                        @endphp
                                                    @else
                                                        <tr>
                                                            <td>{{ $target->target }}</td>
                                                            <td>{{ $target->rating->alloted_budget }}</td>
                                                            <td>{{ $target->rating->responsible }}</td>
                                                            <td>{{ $target->rating->accomplishment }}</td>
                                                            <td>
                                                                @if ($target->rating->efficiency)
                                                                    {{ $target->rating->efficiency }}
                                                                @else
                                                                    NR
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($target->rating->quality)
                                                                    {{ $target->rating->quality }}
                                                                @else
                                                                    NR
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($target->rating->timeliness)
                                                                    {{ $target->rating->timeliness }}
                                                                @else
                                                                    NR
                                                                @endif
                                                            </td>
                                                            <td>{{ $target->rating->average }}</td>
                                                            <td>{{ $target->rating->remarks }}</td>
                                                        </tr>
                                                    @endif
                                                    @switch($funct->funct)
                                                        @case('Core Function')
                                                            @php
                                                                $totalCF += $target->rating->average;
                                                                $numberCF++;
                                                            @endphp
                                                            @break
                                                        @case('Strategic Function')
                                                            @php
                                                                $totalSTF += $target->rating->average;
                                                                $numberSTF++;
                                                            @endphp
                                                            @break
                                                        @case('Support Function')
                                                            @php
                                                                $total += $target->rating->average;
                                                                $numberSubF++;
                                                                $numberSF++;
                                                            @endphp
                                                            @break
                                                    @endswitch
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endforelse
                                @endif
                            @endforeach
                            <tr>
                                <td colspan="9" class="text-end">Total {{ $subFunct->sub_funct }}</td>
                                <td>{{ $total }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="9" class="text-end">Total / {{ $numberSubF }} x {{ $percent }}% x {{ $percentage->support }}%</td>
                                <td>
                                    {{ (($total/$numberSubF)*($percent/100))*($percentage->support/100) }}
                                    @php
                                        $totalSF += (($total/$numberSubF)*($percent/100))*($percentage->support/100)
                                    @endphp
                                </td>
                                <td></td>
                            </tr>
                        @endif
                        @if ($loop->last)
                            <tr>
                                <td colspan="9" class="text-end">
                                    Total {{ $funct->funct }} (
                                    @foreach ($percentage->supports as $support)
                                        @if ($loop->last)
                                            {{ $support->percent }}%
                                        @else
                                            {{ $support->percent }}% +
                                        @endif
                                    @endforeach
                                    )
                                </td>
                                <td>{{ $totalSF }}</td>
                                <td></td>
                            </tr>
                        @endif
                    @endforeach
                @endif
                @foreach ($funct->outputs as $output)
                    @if ($output->user_id == Auth::user()->id &&
                        $output->user_type == $userType  &&
                        $output->type == 'opcr' &&
                        $output->duration_id == $duration->id)
                        @forelse ($output->suboutputs as $suboutput)
                            @if ($suboutput->user_id == Auth::user()->id &&
                            $suboutput->user_type == $userType  &&
                            $suboutput->type == 'opcr' &&
                            $suboutput->duration_id == $duration->id)
                                <tr>
                                    <td>
                                        {{ $output->code }} {{ ++$number }}
                                    </td>
                                    <td>
                                        {{ $output->output }}
                                    </td>
                                    <td colspan="9"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" rowspan="{{ count($suboutput->targets) }}">
                                       {{ $suboutput->suboutput }}
                                    </td>

                                    @php
                                        $first = true;
                                    @endphp
                                    @foreach ($suboutput->targets as $target)
                                        @if ($target->user_id == Auth::user()->id &&
                                            $target->user_type == $userType  &&
                                            $target->type == 'opcr' &&
                                            $target->duration_id == $duration->id)
                                            @if ($first)
                                                <td>{{ $target->target }}</td>
                                                <td>{{ $target->rating->alloted_budget }}</td>
                                                <td>{{ $target->rating->responsible }}</td>
                                                <td>{{ $target->rating->accomplishment }}</td>
                                                <td>
                                                    @if ($target->rating->efficiency)
                                                        {{ $target->rating->efficiency }}
                                                    @else
                                                        NR
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($target->rating->quality)
                                                        {{ $target->rating->quality }}
                                                    @else
                                                        NR
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($target->rating->timeliness)
                                                        {{ $target->rating->timeliness }}
                                                    @else
                                                        NR
                                                    @endif
                                                </td>
                                                <td>{{ $target->rating->average }}</td>
                                                <td>{{ $target->rating->remarks }}</td>
                                                @php
                                                    $first = false;
                                                @endphp
                                            @else
                                                <tr>
                                                    <td>{{ $target->target }}</td>
                                                    <td>{{ $target->rating->alloted_budget }}</td>
                                                    <td>{{ $target->rating->responsible }}</td>
                                                    <td>{{ $target->rating->accomplishment }}</td>
                                                    <td>
                                                        @if ($target->rating->efficiency)
                                                            {{ $target->rating->efficiency }}
                                                        @else
                                                            NR
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($target->rating->quality)
                                                            {{ $target->rating->quality }}
                                                        @else
                                                            NR
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($target->rating->timeliness)
                                                            {{ $target->rating->timeliness }}
                                                        @else
                                                            NR
                                                        @endif
                                                    </td>
                                                    <td>{{ $target->rating->average }}</td>
                                                    <td>{{ $target->rating->remarks }}</td>
                                                </tr>
                                            @endif
                                            @switch($funct->funct)
                                                @case('Core Function')
                                                    @php
                                                        $totalCF += $target->rating->average;
                                                        $numberCF++;
                                                    @endphp
                                                    @break
                                                @case('Strategic Function')
                                                    @php
                                                        $totalSTF += $target->rating->average;
                                                        $numberSTF++;
                                                    @endphp
                                                    @break
                                                @case('Support Function')
                                                    @php
                                                        $totalSF += $target->rating->average;
                                                        $numberSF++;
                                                    @endphp
                                                    @break
                                            @endswitch
                                        @endif
                                    @endforeach
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td rowspan="{{ count($output->targets) }}">
                                    {{ $output->code }} {{ ++$number }}
                                </td>
                                <td rowspan="{{ count($output->targets) }}">
                                    {{ $output->output }}
                                </td>

                                @php
                                    $first = true;
                                @endphp
                                @foreach ($output->targets as $target)
                                    @if ($target->user_id == Auth::user()->id &&
                                        $target->user_type == $userType  &&
                                        $target->type == 'opcr' &&
                                        $target->duration_id == $duration->id)
                                        @if ($first)
                                            <td>{{ $target->target }}</td>
                                            <td>{{ $target->rating->alloted_budget }}</td>
                                            <td>{{ $target->rating->responsible }}</td>
                                            <td>{{ $target->rating->accomplishment }}</td>
                                            <td>
                                                @if ($target->rating->efficiency)
                                                    {{ $target->rating->efficiency }}
                                                @else
                                                    NR
                                                @endif
                                            </td>
                                            <td>
                                                @if ($target->rating->quality)
                                                    {{ $target->rating->quality }}
                                                @else
                                                    NR
                                                @endif
                                            </td>
                                            <td>
                                                @if ($target->rating->timeliness)
                                                    {{ $target->rating->timeliness }}
                                                @else
                                                    NR
                                                @endif
                                            </td>
                                            <td>{{ $target->rating->average }}</td>
                                            <td>{{ $target->rating->remarks }}</td>
                                            @php
                                                $first = false;
                                            @endphp
                                        @else
                                            <tr>
                                                <td>{{ $target->target }}</td>
                                                <td>{{ $target->rating->alloted_budget }}</td>
                                                <td>{{ $target->rating->responsible }}</td>
                                                <td>{{ $target->rating->accomplishment }}</td>
                                                <td>
                                                    @if ($target->rating->efficiency)
                                                        {{ $target->rating->efficiency }}
                                                    @else
                                                        NR
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($target->rating->quality)
                                                        {{ $target->rating->quality }}
                                                    @else
                                                        NR
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($target->rating->timeliness)
                                                        {{ $target->rating->timeliness }}
                                                    @else
                                                        NR
                                                    @endif
                                                </td>
                                                <td>{{ $target->rating->average }}</td>
                                                <td>{{ $target->rating->remarks }}</td>
                                            </tr>
                                        @endif
                                        @switch($funct->funct)
                                            @case('Core Function')
                                                @php
                                                    $totalCF += $target->rating->average;
                                                    $numberCF++;
                                                @endphp
                                                @break
                                            @case('Strategic Function')
                                                @php
                                                    $totalSTF += $target->rating->average;
                                                    $numberSTF++;
                                                @endphp
                                                @break
                                            @case('Support Function')
                                                @php
                                                    $totalSF += $target->rating->average;
                                                    $numberSF++;
                                                @endphp
                                                @break
                                        @endswitch
                                    @endif
                                @endforeach
                            </tr>
                        @endforelse
                    @endif
                @endforeach
                
                @switch($funct->funct)
                    @case('Core Function')
                        <tr>
                            <td colspan="9" class="text-end">
                                Total {{ $funct->funct }}
                            </td>
                            <td>{{ $totalCF }}</td>
                            <td></td>
                        </tr>
                        @break
                    @case('Strategic Function')
                        <tr>
                            <td colspan="9" class="text-end">
                                Total {{ $funct->funct }}
                            </td>
                            <td>{{ $totalSTF }}</td>
                            <td></td>
                        </tr>
                        @break
                @endswitch
            </tbody>
        @endforeach

        <tfoot>
            <tr>
                <th colspan="5">Category</th>
                <th>Average</th>
                <th colspan="3">MFO (tot. no.)</th>
                <th>Percentage</th>
                <th>Total</th>
            </tr>
            <tr>
                <td colspan="5" class="text-start">Core Function</td>
                <td style="border-right: none;">{{ $totalCF }}</td>
                <td style="border-right: none; border-left: none;">/</td>
                <td style="border-right: none; border-left: none;">{{ $numberCF }}</td>
                <td style="border-left: none;">X</td>
                <td>{{ $percentage->core/100 }}</td>
                <td>
                    @if ($numberCF == 0)
                        {{ $total1 = 0 }}
                    @else
                        {{ $total1 = ($totalCF/$numberCF)*($percentage->core/100) }}
                    @endif
                </td>
            </tr>
            <tr>
                <td colspan="5" class="text-start">Strategic Function</td>
                <td style="border-right: none;">{{ $totalSTF }}</td>
                <td style="border: none;">/</td>
                <td style="border: none;">{{ $numberSTF }}</td>
                <td style="border-left: none;">X</td>
                <td>{{ $percentage->strategic/100 }}</td>
                <td>
                    @if ($numberSTF == 0)
                        {{ $total2 = 0 }}
                    @else
                        {{ $total2 = ($totalSTF/$numberSTF)*($percentage->strategic/100) }}
                    @endif
                </td>
            </tr>
            <tr>
                <td colspan="5" class="text-start">Support Function</td>
                <td style="border-right: none;">0</td>
                <td style="border-right: none; border-left: none;">/</td>
                <td style="border-right: none; border-left: none;">{{ $numberCF }}</td>
                <td style="border-left: none;">X</td>
                <td>{{ $percentage->support/100 }}</td>
                <td>{{ $total3 = $totalSF }}</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td colspan="8" class="text-start">Total/Final Overall Rating</td>
                <td>{{ $total = $total1+$total2+$total3 }}</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td colspan="8" class="text-start">Final Average Rating</td>
                <td>{{ $total = $total1+$total2+$total3 }}</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td colspan="8" class="text-start">Adjectival Rating</td>
                <td>
                    @if ($total == 5)
                        Outstanding
                    @elseif ($total < 5 && $total >= 4)
                        Very Satisfactory
                    @elseif ($total < 4 && $total >= 3)
                        Satisfactory
                    @elseif ($total < 3 && $total >= 2)
                        Unsatisfactory
                    @elseif ($total < 2)
                        Poor
                    @endif
                </td>
            </tr>
            
            <tr>
                <td colspan="6" class="text-start">Discussed with:</td>
                <td colspan="5" class="text-start">Assessed by:</td>
            </tr>
            <tr>
                <td colspan="4">
                    <p><u>{{ Auth::user()->name }}</u></p>
                    <p>{{ Auth::user()->title }}</p>
                </td>
                <td>Date: {{ date('M d, Y') }}</td>
                <td style="width: 300px;">
                    <p style="word-wrap: initial;">I certify that I discussed my assessment of the performance with the employee.</p>
                    <p><u>{{ $assess1->name }}</u></p>
                    <p>{{ $assess1->title }}</p>
                </td>
                <td>Date: {{ date('M d, Y', strtotime($assess->superior1_date)) }}</td>
                <td colspan="3">
                    <p class="text-start">Final rating by:</p>
                    <p><u>{{ $assess2->name }}</u></p>
                    <p>{{ $assess2->title }}</p>
                </td>
                <td>Date: {{ date('M d, Y', strtotime($assess->superior2_date)) }}</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
