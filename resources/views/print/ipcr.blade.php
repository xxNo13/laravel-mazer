<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IPCR - {{ Auth::user()->name }}</title>
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
            text-align: end;
        }

        .text-start {
            text-align: start;
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
        <tbody>
            <tr>
                <td colspan="2" rowspan="5" class="bordered">{{ $superior1->name }}</td>
                <td rowspan="5" class="bordered">{{ $approval->superior1_date }}</td>
                <td colspan="2" rowspan="5" class="bordered">{{ $superior2->name }}</td>
                <td rowspan="5" class="bordered">{{ $approval->superior2_date }}</td>
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
        @endphp
        @foreach ($functs as $funct)
            <thead>
                <tr>
                    <th rowspan="2" colspan="2">
                        {{ $funct->funct }}
                        @switch(strtolower($funct->funct))
                            @case('core function')
                                {{ $core }}%
                                @break

                            @case('strategic function')
                                {{ $strategic }}%
                                @break

                            @case('support function')
                                {{ $support }}%
                                @break
                        @endswitch
                    </th>
                    <th rowspan="2">Success Indicator (Target + Measure)</th>
                    <th rowspan="2">Actual Accomplishment</th>
                    <th colspan="4">Rating</th>
                    <th rowspan="2">Remarks</th>
                </tr>
                <tr>
                    <th>Q</th>
                    <th>E</th>
                    <th>T</th>
                    <th>A</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $number = 0;
                    $total = 0;
                @endphp
                @foreach ($funct->outputs as $output)
                    @php
                        $boolOutput = true;
                    @endphp
                    @if ($output->user_id == Auth::user()->id && $output->type == 'ipcr' && $output->duration_id == $duration->id && $output->user_type == $userType)
                        @forelse ($output->suboutputs as $suboutput)
                            @if ($suboutput->user_id == Auth::user()->id &&
                            $suboutput->type == 'ipcr' &&
                            $suboutput->duration_id == $duration->id && $output->user_type == $userType)
                                @if ($boolOutput)
                                    @php
                                        $boolOutput = false
                                    @endphp
                                    <tr>
                                        <td>{{ $output->code }} {{ ++$number }}</td>
                                        <td>{{ $output->output }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="2" rowspan="{{ count($suboutput->targets)+1 }}">{{ $suboutput->suboutput }}</td>
                                    @foreach ($suboutput->targets as $target)
                                        @if ($target->user_id == Auth::user()->id && $target->type == 'ipcr' && $target->duration_id == $duration->id && $output->user_type == $userType)
                                            <tr>
                                                <td>{{ $target->target }}</td>
                                                @if ($target->rating)
                                                    <td>{{ $target->rating->accomplishment }}</td>
                                                    <td>{{ $target->rating->quality }}</td>
                                                    <td>{{ $target->rating->efficiency }}</td>
                                                    <td>{{ $target->rating->timeliness }}</td>
                                                    <td>{{ $target->rating->average }}</td>
                                                    <td>{{ $target->rating->remarks }}</td>
                                                    @php
                                                        $total += $target->rating->average
                                                    @endphp
                                                @else
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                @endif
                                            </tr>
                                        @endif
                                    @endforeach
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td rowspan="{{ count($output->targets)+1 }}">{{ $output->code }} {{ ++$number }}</td>
                                <td rowspan="{{ count($output->targets)+1 }}">{{ $output->output }}</td>
                                @foreach ($output->targets as $target)
                                    @if ($target->user_id == Auth::user()->id && $target->type == 'ipcr' && $target->duration_id == $duration->id && $output->user_type == $userType)
                                        <tr>
                                            <td>{{ $target->target }}</td>
                                            @if ($target->rating)
                                                <td>{{ $target->rating->accomplishment }}</td>
                                                <td>{{ $target->rating->quality }}</td>
                                                <td>{{ $target->rating->efficiency }}</td>
                                                <td>{{ $target->rating->timeliness }}</td>
                                                <td>{{ $target->rating->average }}</td>
                                                <td>{{ $target->rating->remarks }}</td>
                                                @php
                                                    $total += $target->rating->average
                                                @endphp
                                            @else
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            @endif
                                        </tr>
                                    @endif
                                @endforeach
                            </tr>
                        @endforelse
                    @endif
                @endforeach
                <tr>
                    <td colspan="7" class="text-end">Total {{ $funct->funct }}</td>
                    <td>
                        {{ $total }}
                        @switch(strtolower($funct->funct))
                            @case('core function')
                                @php
                                    $totalCF = $total;
                                @endphp
                                @break
                            @case('strategic function')
                                @php
                                    $totalSTF = $total;
                                @endphp
                                @break
                            @case('support function')
                                @php
                                    $totalSF = $total;
                                @endphp
                                @break
                            @default
                                
                        @endswitch
                    </td>
                    <td></td>
                </tr>
            </tbody>
        @endforeach

        <tfoot>
            <tr>
                <th colspan="3">Category</th>
                <th>Average</th>
                <th colspan="3">MFO (tot. no.)</th>
                <th>Percentage</th>
                <th>Total</th>
            </tr>
            <tr>
                <td colspan="3" class="text-start">Core Function</td>
                <td>5</td>
                <td>/</td>
                <td>3</td>
                <td>X</td>
                <td>.40</td>
                <td>30</td>
            </tr>
            <tr>
                <td colspan="3" class="text-start">Strategic Function</td>
                <td>5</td>
                <td>/</td>
                <td>3</td>
                <td>X</td>
                <td>.30</td>
                <td>30</td>
            </tr>
            <tr>
                <td colspan="3" class="text-start">Support Function</td>
                <td>5</td>
                <td>/</td>
                <td>3</td>
                <td>X</td>
                <td>.30</td>
                <td>30</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td colspan="7" class="text-start">Total/Final Overall Rating</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td colspan="7" class="text-start">Final Average Rating</td>
            </tr>
            <tr>
                <td colspan="4">Adjectival Rating Equivalence</td>
                <td></td>
                <td colspan="4" class="text-start">Adjectival Rating</td>
            </tr>
            <tr>
                <td colspan="2">Range</td>
                <td colspan="2">Adjectival Rating</td>
                <td></td>
                <td colspan="4"></td>
            </tr>
            <tr>
                <td colspan="2">(For the Faculty and Staff, Refer to the SPMPS rating)</td>
                <td colspan="2">Outstanding</td>
                <td></td>
                <td colspan="4"></td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td colspan="2">Very Satisfactory</td>
                <td></td>
                <td colspan="4"></td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td colspan="2">Staisfactory</td>
                <td rowspan="3"></td>
                <td rowspan="3" colspan="4" class="text-start">Comments and Recommendations for Development
                    Purposes:</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td colspan="2">Unsatisfactory</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td colspan="2">Poor</td>
            </tr>
            <tr>
                <td colspan="4">Discussed with:</td>
                <td colspan="5">Assessed by:</td>
            </tr>
            <tr>
                <td colspan="2">
                    <p><u>Milbourne Villegas</u></p>
                    <p>Student</p>
                </td>
                <td>Date: August 13, 2022</td>
                <td>
                    <p>I certify that I discussed my assessment of the performance with the employee.</p>
                    <p><u>Rich Johnfrill Lacia</u></p>
                    <p>Boss Amo Manager</p>
                </td>
                <td>Date: August 13, 2022</td>
                <td colspan="3">
                    <p class="text-start">Final rating by:</p>
                    <p><u>Harly Dave Batoon</u></p>
                    <p>Boss Amo Manager</p>
                </td>
                <td>Date: August 13, 2022</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
