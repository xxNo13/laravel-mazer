<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ranking</title>
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
    
    <h1 class="text-center" style="font-size: 12px;">{{ date('Y') }} RANKING IPCR ( SEMESTRAL )</h1>
    <h1 class="text-center" style="font-size: 12px;">{{ strtoupper(Auth::user()->office->office) }}</h1>

    <table class="main-table bordered">
        <tbody>
            <tr>
                <th>Rank</th>
                <th>Name</th>
                <th>Account Type</th>
                <th>Total Score</th>
                <th>Score Equivalent</th>
            </tr>
        </tbody>
        @foreach ($users as $user)
            @if ($user->account_types->contains(1) || $user->account_types->contains(6))
                @php
                    $totalCF = 0;
                    $totalSTF = 0;
                    $totalSF = 0;
                    $numberCF = 0;
                    $numberSTF = 0;
                    $numberSF = 0;
                    $total1 = 0;
                    $total2 = 0;
                    $total3 = 0;
                @endphp
                @foreach ($functs as $funct)
                    @php
                        $total = 0;
                        $number = 0;
                        $numberSubF = 0;
                    @endphp
                    @if ($funct->subFuncts)
                        @foreach ($funct->subFuncts as $subFunct)
                            @if ($subFunct->user_id == $user->id &&
                                $subFunct->user_type == 'faculty'  &&
                                $subFunct->type == 'ipcr' &&
                                $subFunct->duration_id == $duration->id)
                                @php
                                    $total = 0;
                                    $numberSubF = 0;
                                @endphp
                                @foreach ($percentage->supports as $support)
                                    @if ($subFunct->sub_funct == $support->name && $subFunct->id == $support->sub_funct_id)
                                        @php
                                            $percent = $support->percent;
                                        @endphp
                                    @endif
                                @endforeach
                                @foreach ($subFunct->outputs as $output)
                                    @if ($output->user_id == $user->id &&
                                        $output->user_type == 'faculty'  &&
                                        $output->type == 'ipcr' &&
                                        $output->duration_id == $duration->id)
                                        @forelse ($output->suboutputs as $suboutput)
                                            @if ($suboutput->user_id == $user->id &&
                                            $suboutput->user_type == 'faculty'  &&
                                            $suboutput->type == 'ipcr' &&
                                            $suboutput->duration_id == $duration->id)
                                                @php
                                                    ++$number
                                                @endphp
                                                    @foreach ($suboutput->targets as $target)
                                                        @if ($target->user_id == $user->id &&
                                                            $target->user_type == 'faculty'  &&
                                                            $target->type == 'ipcr' &&
                                                            $target->duration_id == $duration->id)
                                                            @switch($funct->funct)
                                                                @case('Core Function')
                                                                    @php
                                                                        $total += $target->rating->average;
                                                                        $numberSubF++;
                                                                        $numberCF++;
                                                                    @endphp
                                                                    @break
                                                                @case('Strategic Function')
                                                                    @php
                                                                        $total += $target->rating->average;
                                                                        $numberSubF++;
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
                                            @endif
                                        @empty
                                                @foreach ($output->targets as $target)
                                                    @if ($target->user_id == $user->id &&
                                                        $target->user_type == 'faculty'  &&
                                                        $target->type == 'ipcr' &&
                                                        $target->duration_id == $duration->id)
                                                        @switch($funct->funct)
                                                            @case('Core Function')
                                                                @php
                                                                    $total += $target->rating->average;
                                                                    $numberSubF++;
                                                                    $numberCF++;
                                                                @endphp
                                                                @break
                                                            @case('Strategic Function')
                                                                @php
                                                                    $total += $target->rating->average;
                                                                    $numberSubF++;
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
                                        @endforelse
                                    @endif
                                @endforeach
                                        @switch($funct->funct)
                                            @case('Core Function')
                                                @php
                                                    $totalCF += (($total/$numberSubF)*($percent/100))*($percentage->core/100)
                                                @endphp
                                                @break
                                            @case('Strategic Function')
                                                @php
                                                    $totalSTF += (($total/$numberSubF)*($percent/100))*($percentage->strategic/100)
                                                @endphp
                                                @break
                                            @case('Support Function')
                                                @php
                                                    $totalSF += (($total/$numberSubF)*($percent/100))*($percentage->support/100)
                                                @endphp
                                                @break
                                        @endswitch
                            @endif
                        @endforeach
                    @endif
                    @foreach ($funct->outputs as $output)
                        @if ($output->user_id == $user->id &&
                            $output->user_type == 'faculty'  &&
                            $output->type == 'ipcr' &&
                            $output->duration_id == $duration->id)
                            @forelse ($output->suboutputs as $suboutput)
                                @if ($suboutput->user_id == $user->id &&
                                $suboutput->user_type == 'faculty'  &&
                                $suboutput->type == 'ipcr' &&
                                $suboutput->duration_id == $duration->id)
                                    @php
                                        ++$number
                                    @endphp
                                        @foreach ($suboutput->targets as $target)
                                            @if ($target->user_id == $user->id &&
                                                $target->user_type == 'faculty'  &&
                                                $target->type == 'ipcr' &&
                                                $target->duration_id == $duration->id)
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
                                @endif
                            @empty
                                @php
                                    ++$number
                                @endphp
                                    @foreach ($output->targets as $target)
                                        @if ($target->user_id == $user->id &&
                                            $target->user_type == 'faculty'  &&
                                            $target->type == 'ipcr' &&
                                            $target->duration_id == $duration->id)
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
                            @endforelse
                        @endif
                    @endforeach
                    
            @endforeach
                    @foreach ($functs as $funct)
                        @if ($funct->funct == 'Core Function')
                            @forelse ($funct->subFuncts as $sub_funct)
                                @if ($subFunct->user_id == $user->id &&
                                $subFunct->user_type == 'faculty'  &&
                                $subFunct->type == 'ipcr' &&
                                $subFunct->duration_id == $duration->id)
                                    @php
                                        $total1 = $totalCF
                                    @endphp
                                    @break
                                @endif
                            @empty
                                @if ($numberCF == 0)
                                    @php
                                        $total1 = 0
                                    @endphp
                                @else
                                    @php
                                        $total1 = ($totalCF/$numberCF)*($percentage->core/100)
                                    @endphp
                                @endif
                            @endforelse
                        @elseif ($funct->funct == 'Strategic Function')
                            @forelse ($funct->subFuncts as $sub_funct)
                                @if ($subFunct->user_id == $user->id &&
                                $subFunct->user_type == 'faculty'  &&
                                $subFunct->type == 'ipcr' &&
                                $subFunct->duration_id == $duration->id)
                                    @php
                                        $total2 = $totalSTF
                                    @endphp
                                    @break
                                @endif
                            @empty
                                @if ($numberSTF == 0)
                                    @php
                                        $total2 = 0
                                    @endphp
                                @else
                                    @php
                                        $total2 = ($totalSTF/$numberSTF)*($percentage->strategic/100)
                                    @endphp
                                @endif
                            @endforelse
                        @elseif ($funct->funct == 'Support Function')
                            @forelse ($funct->subFuncts as $sub_funct)
                                @if ($subFunct->user_id == $user->id &&
                                $subFunct->user_type == 'faculty'  &&
                                $subFunct->type == 'ipcr' &&
                                $subFunct->duration_id == $duration->id)
                                    @php
                                        $total3 = $totalSF
                                    @endphp
                                    @break
                                @endif
                            @empty
                                @if ($numberSF == 0)
                                    @php
                                        $total3 = 0
                                    @endphp
                                @else
                                    @php
                                        $total3 = ($totalSF/$numberSF)*($percentage->support/100)
                                    @endphp
                                @endif
                            @endforelse
                        @endif
                    @endforeach
                    @php
                        $totals[$user->id . ','. 'faculty'] = round($total1+$total2+$total3, 2);
                    @endphp
            @endif
            @if ($user->account_types->contains(2))
                @php
                    $totalCF = 0;
                    $totalSTF = 0;
                    $totalSF = 0;
                    $numberCF = 0;
                    $numberSTF = 0;
                    $numberSF = 0;
                    $total1 = 0;
                    $total2 = 0;
                    $total3 = 0;
                @endphp
                @foreach ($functs as $funct)
                    @php
                        $total = 0;
                        $number = 0;
                        $numberSubF = 0;
                    @endphp
                    @if ($funct->subFuncts)
                        @foreach ($funct->subFuncts as $subFunct)
                            @if ($subFunct->user_id == $user->id &&
                                $subFunct->user_type == 'staff'  &&
                                $subFunct->type == 'ipcr' &&
                                $subFunct->duration_id == $duration->id)
                                @php
                                    $total = 0;
                                    $numberSubF = 0;
                                @endphp
                                @foreach ($percentage->supports as $support)
                                    @if ($subFunct->sub_funct == $support->name && $subFunct->id == $support->sub_funct_id)
                                        @php
                                            $percent = $support->percent;
                                        @endphp
                                    @endif
                                @endforeach
                                @foreach ($subFunct->outputs as $output)
                                    @if ($output->user_id == $user->id &&
                                        $output->user_type == 'staff'  &&
                                        $output->type == 'ipcr' &&
                                        $output->duration_id == $duration->id)
                                        @forelse ($output->suboutputs as $suboutput)
                                            @if ($suboutput->user_id == $user->id &&
                                            $suboutput->user_type == 'staff'  &&
                                            $suboutput->type == 'ipcr' &&
                                            $suboutput->duration_id == $duration->id)
                                                @php
                                                    ++$number
                                                @endphp
                                                    @foreach ($suboutput->targets as $target)
                                                        @if ($target->user_id == $user->id &&
                                                            $target->user_type == 'staff'  &&
                                                            $target->type == 'ipcr' &&
                                                            $target->duration_id == $duration->id)
                                                            @switch($funct->funct)
                                                                @case('Core Function')
                                                                    @php
                                                                        $total += $target->rating->average;
                                                                        $numberSubF++;
                                                                        $numberCF++;
                                                                    @endphp
                                                                    @break
                                                                @case('Strategic Function')
                                                                    @php
                                                                        $total += $target->rating->average;
                                                                        $numberSubF++;
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
                                            @endif
                                        @empty
                                                @foreach ($output->targets as $target)
                                                    @if ($target->user_id == $user->id &&
                                                        $target->user_type == 'staff'  &&
                                                        $target->type == 'ipcr' &&
                                                        $target->duration_id == $duration->id)
                                                        @switch($funct->funct)
                                                            @case('Core Function')
                                                                @php
                                                                    $total += $target->rating->average;
                                                                    $numberSubF++;
                                                                    $numberCF++;
                                                                @endphp
                                                                @break
                                                            @case('Strategic Function')
                                                                @php
                                                                    $total += $target->rating->average;
                                                                    $numberSubF++;
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
                                        @endforelse
                                    @endif
                                @endforeach
                                        @switch($funct->funct)
                                            @case('Core Function')
                                                @php
                                                    $totalCF += (($total/$numberSubF)*($percent/100))*($percentage->core/100)
                                                @endphp
                                                @break
                                            @case('Strategic Function')
                                                @php
                                                    $totalSTF += (($total/$numberSubF)*($percent/100))*($percentage->strategic/100)
                                                @endphp
                                                @break
                                            @case('Support Function')
                                                @php
                                                    $totalSF += (($total/$numberSubF)*($percent/100))*($percentage->support/100)
                                                @endphp
                                                @break
                                        @endswitch
                            @endif
                        @endforeach
                    @endif
                    @foreach ($funct->outputs as $output)
                        @if ($output->user_id == $user->id &&
                            $output->user_type == 'staff'  &&
                            $output->type == 'ipcr' &&
                            $output->duration_id == $duration->id)
                            @forelse ($output->suboutputs as $suboutput)
                                @if ($suboutput->user_id == $user->id &&
                                $suboutput->user_type == 'staff'  &&
                                $suboutput->type == 'ipcr' &&
                                $suboutput->duration_id == $duration->id)
                                    @php
                                        ++$number
                                    @endphp
                                        @foreach ($suboutput->targets as $target)
                                            @if ($target->user_id == $user->id &&
                                                $target->user_type == 'staff'  &&
                                                $target->type == 'ipcr' &&
                                                $target->duration_id == $duration->id)
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
                                @endif
                            @empty
                                @php
                                    ++$number
                                @endphp
                                    @foreach ($output->targets as $target)
                                        @if ($target->user_id == $user->id &&
                                            $target->user_type == 'staff'  &&
                                            $target->type == 'ipcr' &&
                                            $target->duration_id == $duration->id)
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
                            @endforelse
                        @endif
                    @endforeach
                    
            @endforeach
                    @foreach ($functs as $funct)
                        @if ($funct->funct == 'Core Function')
                            @forelse ($funct->subFuncts as $sub_funct)
                                @if ($subFunct->user_id == $user->id &&
                                $subFunct->user_type == 'staff'  &&
                                $subFunct->type == 'ipcr' &&
                                $subFunct->duration_id == $duration->id)
                                    @php
                                        $total1 = $totalCF
                                    @endphp
                                    @break
                                @endif
                            @empty
                                @if ($numberCF == 0)
                                    @php
                                        $total1 = 0
                                    @endphp
                                @else
                                    @php
                                        $total1 = ($totalCF/$numberCF)*($percentage->core/100)
                                    @endphp
                                @endif
                            @endforelse
                        @elseif ($funct->funct == 'Strategic Function')
                            @forelse ($funct->subFuncts as $sub_funct)
                                @if ($subFunct->user_id == $user->id &&
                                $subFunct->user_type == 'staff'  &&
                                $subFunct->type == 'ipcr' &&
                                $subFunct->duration_id == $duration->id)
                                    @php
                                        $total2 = $totalSTF
                                    @endphp
                                    @break
                                @endif
                            @empty
                                @if ($numberSTF == 0)
                                    @php
                                        $total2 = 0
                                    @endphp
                                @else
                                    @php
                                        $total2 = ($totalSTF/$numberSTF)*($percentage->strategic/100)
                                    @endphp
                                @endif
                            @endforelse
                        @elseif ($funct->funct == 'Support Function')
                            @forelse ($funct->subFuncts as $sub_funct)
                                @if ($subFunct->user_id == $user->id &&
                                $subFunct->user_type == 'staff'  &&
                                $subFunct->type == 'ipcr' &&
                                $subFunct->duration_id == $duration->id)
                                    @php
                                        $total3 = $totalSF
                                    @endphp
                                    @break
                                @endif
                            @empty
                                @if ($numberSF == 0)
                                    @php
                                        $total3 = 0
                                    @endphp
                                @else
                                    @php
                                        $total3 = ($totalSF/$numberSF)*($percentage->support/100)
                                    @endphp
                                @endif
                            @endforelse
                        @endif
                    @endforeach
                    @php
                        $totals[$user->id . ','. 'staff'] = round($total1+$total2+$total3, 2);
                    @endphp
            @endif
        @endforeach
        @php
            arsort($totals);
            $number = 0;
        @endphp
        <tfoot>
            @foreach ($totals as $id => $total)
                @php
                    $index = explode( ',', $id )
                @endphp
                @foreach ($users as $user)
                    @if ($index[0] == $user->id)
                        <tr>
                            <td>{{ ++$number }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ ucfirst($index[1]) }}</td>
                            <td>{{ $totals[$user->id . ','. $index[1]] }}</td>
                            <td>
                                @if ($totals[$user->id . ','. $index[1]] >= $scoreEq->out_from && $totals[$user->id . ','. $index[1]] <= $scoreEq->out_to)
                                    Outstanding
                                @elseif ($totals[$user->id . ','. $index[1]] >= $scoreEq->verysat_from && $totals[$user->id . ','. $index[1]] <= $scoreEq->verysat_to)
                                    Very Satisfactory
                                @elseif ($totals[$user->id . ','. $index[1]] >= $scoreEq->sat_from && $totals[$user->id . ','. $index[1]] <= $scoreEq->sat_to)
                                    Satisfactory
                                @elseif ($totals[$user->id . ','. $index[1]] >= $scoreEq->unsat_from && $totals[$user->id . ','. $index[1]] <= $scoreEq->unsat_to)
                                    Unsatisfactory
                                @elseif ($totals[$user->id . ','. $index[1]] >= $scoreEq->poor_from && $totals[$user->id . ','. $index[1]] <= $scoreEq->poor_to)
                                    Poor
                                @endif
                            </td>
                        </tr>
                        @break
                    @endif
                @endforeach
            @endforeach
        </tfoot>
    </table>
</body>

</html>
