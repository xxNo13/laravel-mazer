<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Standard - {{ Auth::user()->name }}</title>
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
    
    <h1 class="text-center" style="font-size: 12px;">{{ date('Y') }} PERFORMANCE STANDARD ( SEMESTRAL )</h1>
    <h1 class="text-center" style="font-size: 12px;">{{ strtoupper(Auth::user()->office->office) }}</h1>

    <table class="main-table bordered">
        <tbody>
            <tr>
                <th colspan="2">Output</th>
                <th>Success Indicator</th>
                <th>Rating</th>
                <th>Effeciency Standard</th>
                <th>Rating</th>
                <th>Quality Standard</th>
                <th>Rating</th>
                <th>Timeliness Standard</th>
            </tr>
            @php
                $number = 0;
            @endphp
            @foreach ($functs as $funct)
                <tr>
                    <td class="text-start" colspan="9">{{ $funct->funct }}</td>
                </tr>
                @forelse ($funct->subFuncts as $subFunct)   
                    @if ($subFunct->user_id == Auth::user()->id &&
                    $subFunct->user_type == $userType  &&
                    $subFunct->type == 'ipcr' &&
                    $subFunct->duration_id == $duration->id)
                        <tr>
                            <td colspan="2">
                                {{ $subFunct->sub_funct }}
                            </td>
                            <td colspan="7"></td>
                        </tr>
                        @foreach ($subFunct->outputs as $output)
                            @if ($output->user_id == Auth::user()->id &&
                                $output->user_type == $userType  &&
                                $output->type == 'ipcr' &&
                                $output->duration_id == $duration->id)
                                @forelse ($output->suboutputs as $suboutput)
                                    @if ($suboutput->user_id == Auth::user()->id &&
                                    $suboutput->user_type == $userType  &&
                                    $suboutput->type == 'ipcr' &&
                                    $suboutput->duration_id == $duration->id)
                                        <tr>
                                            <td>
                                                {{ $output->code }} {{ ++$number }}
                                            </td>
                                            <td>
                                                {{ $output->output }}
                                            </td>
                                            <td colspan="7"></td>
                                        </tr>
                                        <tr style="page-break-inside: avoid;" >
                                            <td colspan="2" rowspan="{{ count($suboutput->targets) * 5 }}">
                                            {{ $suboutput->suboutput }}
                                            </td>
        
                                            @php
                                                $first = true;
                                            @endphp
                                            @foreach ($suboutput->targets as $target)
                                                @if ($target->user_id == Auth::user()->id &&
                                                    $target->user_type == $userType  &&
                                                    $target->type == 'ipcr' &&
                                                    $target->duration_id == $duration->id)
                                                    @if ($first)
                                                    <td rowspan="5">{{ $target->target }}</td>
                                                    <td>5</td>
                                                    <td>{{ $target->standard->eff_5 }}</td>
                                                    <td>5</td>
                                                    <td>{{ $target->standard->qua_5 }}</td>
                                                    <td>5</td>
                                                    <td>{{ $target->standard->time_5 }}</td>
                                                    <tr>
                                                        <td>4</td>
                                                        <td>{{ $target->standard->eff_4 }}</td>
                                                        <td>4</td>
                                                        <td>{{ $target->standard->qua_4 }}</td>
                                                        <td>4</td>
                                                        <td>{{ $target->standard->time_4 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>{{ $target->standard->eff_3 }}</td>
                                                        <td>3</td>
                                                        <td>{{ $target->standard->qua_3 }}</td>
                                                        <td>3</td>
                                                        <td>{{ $target->standard->time_3 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>{{ $target->standard->eff_2 }}</td>
                                                        <td>2</td>
                                                        <td>{{ $target->standard->qua_2 }}</td>
                                                        <td>2</td>
                                                        <td>{{ $target->standard->time_2 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>{{ $target->standard->eff_1 }}</td>
                                                        <td>1</td>
                                                        <td>{{ $target->standard->qua_1 }}</td>
                                                        <td>1</td>
                                                        <td>{{ $target->standard->time_1 }}</td>
                                                    </tr>
                                                    @php
                                                        $first = false;
                                                    @endphp
                                                @else
                                                <tr style="page-break-inside: avoid;" >
                                                    <td rowspan="5">{{ $target->target }}</td>
                                                    <td>5</td>
                                                    <td>{{ $target->standard->eff_5 }}</td>
                                                    <td>5</td>
                                                    <td>{{ $target->standard->qua_5 }}</td>
                                                    <td>5</td>
                                                    <td>{{ $target->standard->time_5 }}</td>
                                                    <tr>
                                                        <td>4</td>
                                                        <td>{{ $target->standard->eff_4 }}</td>
                                                        <td>4</td>
                                                        <td>{{ $target->standard->qua_4 }}</td>
                                                        <td>4</td>
                                                        <td>{{ $target->standard->time_4 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>{{ $target->standard->eff_3 }}</td>
                                                        <td>3</td>
                                                        <td>{{ $target->standard->qua_3 }}</td>
                                                        <td>3</td>
                                                        <td>{{ $target->standard->time_3 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>{{ $target->standard->eff_2 }}</td>
                                                        <td>2</td>
                                                        <td>{{ $target->standard->qua_2 }}</td>
                                                        <td>2</td>
                                                        <td>{{ $target->standard->time_2 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>{{ $target->standard->eff_1 }}</td>
                                                        <td>1</td>
                                                        <td>{{ $target->standard->qua_1 }}</td>
                                                        <td>1</td>
                                                        <td>{{ $target->standard->time_1 }}</td>
                                                    </tr>
                                                </tr>
                                                @endif
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endif
                                @empty
                                    <tr style="page-break-inside: avoid;" >
                                        <td rowspan="{{ count($output->targets)*5 }}">
                                            {{ $output->code }} {{ ++$number }}
                                        </td>
                                        <td rowspan="{{ count($output->targets)*5 }}">
                                            {{ $output->output }}
                                        </td>
        
                                        @php
                                            $first = true;
                                        @endphp
                                        @foreach ($output->targets as $target)
                                            @if ($target->user_id == Auth::user()->id &&
                                                $target->user_type == $userType  &&
                                                $target->type == 'ipcr' &&
                                                $target->duration_id == $duration->id)
                                                @if ($first)
                                                    <td rowspan="5">{{ $target->target }}</td>
                                                    <td>5</td>
                                                    <td>{{ $target->standard->eff_5 }}</td>
                                                    <td>5</td>
                                                    <td>{{ $target->standard->qua_5 }}</td>
                                                    <td>5</td>
                                                    <td>{{ $target->standard->time_5 }}</td>
                                                    <tr>
                                                        <td>4</td>
                                                        <td>{{ $target->standard->eff_4 }}</td>
                                                        <td>4</td>
                                                        <td>{{ $target->standard->qua_4 }}</td>
                                                        <td>4</td>
                                                        <td>{{ $target->standard->time_4 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>{{ $target->standard->eff_3 }}</td>
                                                        <td>3</td>
                                                        <td>{{ $target->standard->qua_3 }}</td>
                                                        <td>3</td>
                                                        <td>{{ $target->standard->time_3 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>{{ $target->standard->eff_2 }}</td>
                                                        <td>2</td>
                                                        <td>{{ $target->standard->qua_2 }}</td>
                                                        <td>2</td>
                                                        <td>{{ $target->standard->time_2 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>{{ $target->standard->eff_1 }}</td>
                                                        <td>1</td>
                                                        <td>{{ $target->standard->qua_1 }}</td>
                                                        <td>1</td>
                                                        <td>{{ $target->standard->time_1 }}</td>
                                                    </tr>
                                                    @php
                                                        $first = false;
                                                    @endphp
                                                @else
                                                <tr style="page-break-inside: avoid;" >
                                                    <td rowspan="5">{{ $target->target }}</td>
                                                    <td>5</td>
                                                    <td>{{ $target->standard->eff_5 }}</td>
                                                    <td>5</td>
                                                    <td>{{ $target->standard->qua_5 }}</td>
                                                    <td>5</td>
                                                    <td>{{ $target->standard->time_5 }}</td>
                                                    <tr>
                                                        <td>4</td>
                                                        <td>{{ $target->standard->eff_4 }}</td>
                                                        <td>4</td>
                                                        <td>{{ $target->standard->qua_4 }}</td>
                                                        <td>4</td>
                                                        <td>{{ $target->standard->time_4 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>{{ $target->standard->eff_3 }}</td>
                                                        <td>3</td>
                                                        <td>{{ $target->standard->qua_3 }}</td>
                                                        <td>3</td>
                                                        <td>{{ $target->standard->time_3 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>{{ $target->standard->eff_2 }}</td>
                                                        <td>2</td>
                                                        <td>{{ $target->standard->qua_2 }}</td>
                                                        <td>2</td>
                                                        <td>{{ $target->standard->time_2 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>{{ $target->standard->eff_1 }}</td>
                                                        <td>1</td>
                                                        <td>{{ $target->standard->qua_1 }}</td>
                                                        <td>1</td>
                                                        <td>{{ $target->standard->time_1 }}</td>
                                                    </tr>
                                                </tr>
                                                @endif
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforelse
                            @endif
                        @endforeach
                    @endif
                @empty
                    @foreach ($funct->outputs as $output)
                        @if ($output->user_id == Auth::user()->id &&
                            $output->user_type == $userType  &&
                            $output->type == 'ipcr' &&
                            $output->duration_id == $duration->id)
                            @forelse ($output->suboutputs as $suboutput)
                                @if ($suboutput->user_id == Auth::user()->id &&
                                $suboutput->user_type == $userType  &&
                                $suboutput->type == 'ipcr' &&
                                $suboutput->duration_id == $duration->id)
                                    <tr>
                                        <td>
                                            {{ $output->code }} {{ ++$number }}
                                        </td>
                                        <td>
                                            {{ $output->output }}
                                        </td>
                                        <td colspan="7"></td>
                                    </tr>
                                    <tr style="page-break-inside: avoid;" >
                                        <td colspan="2" rowspan="{{ count($suboutput->targets) * 5 }}">
                                        {{ $suboutput->suboutput }}
                                        </td>
    
                                        @php
                                            $first = true;
                                        @endphp
                                        @foreach ($suboutput->targets as $target)
                                            @if ($target->user_id == Auth::user()->id &&
                                                $target->user_type == $userType  &&
                                                $target->type == 'ipcr' &&
                                                $target->duration_id == $duration->id)
                                                @if ($first)
                                                <td rowspan="5">{{ $target->target }}</td>
                                                <td>5</td>
                                                <td>{{ $target->standard->eff_5 }}</td>
                                                <td>5</td>
                                                <td>{{ $target->standard->qua_5 }}</td>
                                                <td>5</td>
                                                <td>{{ $target->standard->time_5 }}</td>
                                                <tr>
                                                    <td>4</td>
                                                    <td>{{ $target->standard->eff_4 }}</td>
                                                    <td>4</td>
                                                    <td>{{ $target->standard->qua_4 }}</td>
                                                    <td>4</td>
                                                    <td>{{ $target->standard->time_4 }}</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>{{ $target->standard->eff_3 }}</td>
                                                    <td>3</td>
                                                    <td>{{ $target->standard->qua_3 }}</td>
                                                    <td>3</td>
                                                    <td>{{ $target->standard->time_3 }}</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>{{ $target->standard->eff_2 }}</td>
                                                    <td>2</td>
                                                    <td>{{ $target->standard->qua_2 }}</td>
                                                    <td>2</td>
                                                    <td>{{ $target->standard->time_2 }}</td>
                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td>{{ $target->standard->eff_1 }}</td>
                                                    <td>1</td>
                                                    <td>{{ $target->standard->qua_1 }}</td>
                                                    <td>1</td>
                                                    <td>{{ $target->standard->time_1 }}</td>
                                                </tr>
                                                @php
                                                    $first = false;
                                                @endphp
                                            @else
                                            <tr style="page-break-inside: avoid;" >
                                                <td rowspan="5">{{ $target->target }}</td>
                                                <td>5</td>
                                                <td>{{ $target->standard->eff_5 }}</td>
                                                <td>5</td>
                                                <td>{{ $target->standard->qua_5 }}</td>
                                                <td>5</td>
                                                <td>{{ $target->standard->time_5 }}</td>
                                                <tr>
                                                    <td>4</td>
                                                    <td>{{ $target->standard->eff_4 }}</td>
                                                    <td>4</td>
                                                    <td>{{ $target->standard->qua_4 }}</td>
                                                    <td>4</td>
                                                    <td>{{ $target->standard->time_4 }}</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>{{ $target->standard->eff_3 }}</td>
                                                    <td>3</td>
                                                    <td>{{ $target->standard->qua_3 }}</td>
                                                    <td>3</td>
                                                    <td>{{ $target->standard->time_3 }}</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>{{ $target->standard->eff_2 }}</td>
                                                    <td>2</td>
                                                    <td>{{ $target->standard->qua_2 }}</td>
                                                    <td>2</td>
                                                    <td>{{ $target->standard->time_2 }}</td>
                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td>{{ $target->standard->eff_1 }}</td>
                                                    <td>1</td>
                                                    <td>{{ $target->standard->qua_1 }}</td>
                                                    <td>1</td>
                                                    <td>{{ $target->standard->time_1 }}</td>
                                                </tr>
                                            </tr>
                                            @endif
                                            @endif
                                        @endforeach
                                    </tr>
                                @endif
                            @empty
                                <tr style="page-break-inside: avoid;" >
                                    <td rowspan="{{ count($output->targets)*5 }}">
                                        {{ $output->code }} {{ ++$number }}
                                    </td>
                                    <td rowspan="{{ count($output->targets)*5 }}">
                                        {{ $output->output }}
                                    </td>
    
                                    @php
                                        $first = true;
                                    @endphp
                                    @foreach ($output->targets as $target)
                                        @if ($target->user_id == Auth::user()->id &&
                                            $target->user_type == $userType  &&
                                            $target->type == 'ipcr' &&
                                            $target->duration_id == $duration->id)
                                            @if ($first)
                                                <td rowspan="5">{{ $target->target }}</td>
                                                <td>5</td>
                                                <td>{{ $target->standard->eff_5 }}</td>
                                                <td>5</td>
                                                <td>{{ $target->standard->qua_5 }}</td>
                                                <td>5</td>
                                                <td>{{ $target->standard->time_5 }}</td>
                                                <tr>
                                                    <td>4</td>
                                                    <td>{{ $target->standard->eff_4 }}</td>
                                                    <td>4</td>
                                                    <td>{{ $target->standard->qua_4 }}</td>
                                                    <td>4</td>
                                                    <td>{{ $target->standard->time_4 }}</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>{{ $target->standard->eff_3 }}</td>
                                                    <td>3</td>
                                                    <td>{{ $target->standard->qua_3 }}</td>
                                                    <td>3</td>
                                                    <td>{{ $target->standard->time_3 }}</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>{{ $target->standard->eff_2 }}</td>
                                                    <td>2</td>
                                                    <td>{{ $target->standard->qua_2 }}</td>
                                                    <td>2</td>
                                                    <td>{{ $target->standard->time_2 }}</td>
                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td>{{ $target->standard->eff_1 }}</td>
                                                    <td>1</td>
                                                    <td>{{ $target->standard->qua_1 }}</td>
                                                    <td>1</td>
                                                    <td>{{ $target->standard->time_1 }}</td>
                                                </tr>
                                                @php
                                                    $first = false;
                                                @endphp
                                            @else
                                            <tr style="page-break-inside: avoid;" >
                                                <td rowspan="5">{{ $target->target }}</td>
                                                <td>5</td>
                                                <td>{{ $target->standard->eff_5 }}</td>
                                                <td>5</td>
                                                <td>{{ $target->standard->qua_5 }}</td>
                                                <td>5</td>
                                                <td>{{ $target->standard->time_5 }}</td>
                                                <tr>
                                                    <td>4</td>
                                                    <td>{{ $target->standard->eff_4 }}</td>
                                                    <td>4</td>
                                                    <td>{{ $target->standard->qua_4 }}</td>
                                                    <td>4</td>
                                                    <td>{{ $target->standard->time_4 }}</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>{{ $target->standard->eff_3 }}</td>
                                                    <td>3</td>
                                                    <td>{{ $target->standard->qua_3 }}</td>
                                                    <td>3</td>
                                                    <td>{{ $target->standard->time_3 }}</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>{{ $target->standard->eff_2 }}</td>
                                                    <td>2</td>
                                                    <td>{{ $target->standard->qua_2 }}</td>
                                                    <td>2</td>
                                                    <td>{{ $target->standard->time_2 }}</td>
                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td>{{ $target->standard->eff_1 }}</td>
                                                    <td>1</td>
                                                    <td>{{ $target->standard->qua_1 }}</td>
                                                    <td>1</td>
                                                    <td>{{ $target->standard->time_1 }}</td>
                                                </tr>
                                            </tr>
                                            @endif
                                        @endif
                                    @endforeach
                                </tr>
                            @endforelse
                        @endif
                    @endforeach
                @endforelse
            @endforeach
        </tbody>
    </table>
</body>

</html>
