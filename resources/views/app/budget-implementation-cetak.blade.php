<html>

<head>
    <style>
        table {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        td {
            vertical-align: top;
            height: 100%;
            /* Set the height of the table cells */
        }
    </style>

</head>

<body>

    <table border="1">
        @foreach ($dataBI as $misi)
            <tr>
                <td rowspan="{{ $misi['parent']['rowspan'] }}">
                    {{ $misi['parent']['description'] }}
                </td>
                @foreach ($misi['child_missi'] as $iku)
                    <td rowspan="{{ $iku['parent']['rowspan'] }}">
                        {{ $iku['parent']['description'] }}
                    </td>
                    @foreach ($iku['child_iku'] as $sasaran)
                        <td rowspan="{{ $sasaran['parent']['rowspan'] }}">
                            {{ $sasaran['parent']['name'] }}
                        </td>
                        @foreach ($sasaran['child_sasaran'] as $ind_perkin)
                            <td rowspan="{{ $ind_perkin['parent']['rowspan'] }}">
                                {{ $ind_perkin['parent']['name'] }}
                            </td>
                            @php
                                $activityIndex = 0;
                            @endphp
                            @foreach ($ind_perkin['child_ind_perkin'] as $activity)
                                <td rowspan="{{ $activity['parent']['rowspan'] }}">
                                    {{ $activity['parent']['code'] }}
                                    ::
                                    {{ $activity['parent']['name'] }}
                                </td>

                                {{--  bi --}}
                                @php
                                    $biIndex = 0;
                                @endphp
                                @foreach ($activity['child_activity'] as $bi)
                                    @php
                                        if ($biIndex != 0) {
                                            echo newRowDipa();
                                        }
                                        $biIndex++;
                                    @endphp
                                    <td rowspan="{{ $bi['bi']['rowspan'] }}">
                                        {{-- @dd($bi['bi']) --}}
                                        {{ $bi['bi']->accountCode->code }}
                                        ::
                                        {{ $biIndex . '-' . $bi['bi']['rowspan'] }}
                                        {{-- {{ $bi['bi']['account_code']['name'] }} --}}
                                    </td>
                                    @foreach ($bi['detail'] as $detail)
                                        <td>
                                            {{ $detail['name'] }}
                                        </td>
                                        <td>
                                            {{ $detail['volume'] }}
                                        </td>
                                        <td>
                                            {{ $detail['price'] }}
                                        </td>
                                        <td>
                                            {{ $detail['total'] }}
                                        </td>
                                        {!! newRowDipa() !!}
                                    @endforeach
                                @endforeach
                                {{-- end bi --}}
                                @php
                                    $activityIndex++;
                                    if ($activityIndex != 0) {
                                        echo newRowDipa();
                                    }
                                @endphp
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
            </tr>
        @endforeach
    </table>
</body>

</html>
