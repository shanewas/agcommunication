@extends('layouts.app')

@section('content')
    <div class="container">
        <br><br>
        @if(Auth::user()->clients != 1)
            <input class="form-control" id="search" name="search" placeholder="Start typing here" type="text" data-list=".list" autofocus>
            @foreach(DB::table('clients')->get() as $filter)
                <ul class="list">
                    <span>Name: <a href="/s/{{ $filter->name}}?csrf={{ $filter->id }}">{{ $filter->username }}</a>&nbsp;Address: {{ $filter->PresentAddress }}</span>
                </ul>
            @endforeach
        @endif
        <br><br>
    </div>
    @foreach($profile as $pro)
        <div class="container">
            <div class="row">
                <?php
                    $dates = date("Y/M/d");
                    list($year, $month, $day) = mb_split( '[/.-]', $dates);
                ?>
                <div class="col-xs-8 pull-left">
                    <h2>Personal Info</h2>
                    <div class="col-xs-12"><h4><b>User Name:</b> {{ $pro->username }}</h4></div>
                    <div class="col-xs-12"><h4><b>Password:</b> {{ $pro->password }}</h4></div>
                    <div class="col-xs-12"><h4><b>Present Address:</b> {{ $pro->PresentAddress }}</h4></div>
                    <div class="col-xs-12"><h4><b>Phone Number:</b> {{ $pro->phone }}</h4></div>
                    <div class="col-xs-12"><h4><b>Connected From:</b> {{ $pro->connectedFrom }}</h4></div>
                </div>
                <div class="col-xs-4 pull-right">
                    <h2>Billing info</h2>
                    <div class="col-xs-12"><h4><b>Line:</b> {{ $pro->status }}</h4></div>
                    <div class="col-xs-12"><h4><b>Monthly Bill:</b> {{ $pro->bill }} Tk.</h4></div>
                    <div class="col-xs-12"><h4><b>Payment Date:</b> {{ $pro->payment }}<i>'th</i> {{$month}} {{$year}}</h4></div>
                    <div class="col-xs-12"><h4><b>Bandwidth Scheme:</b> {{ $pro->dataScheme }} Mbps</h4></div>
                    <div class="col-xs-12"><h4><b>Payment Status:</b> {{ $pro->paidStatus }}</h4></div>
                </div>
            </div>
            <br><br>
            <div class="table-responsive">
                <table id="CInfo" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Receipt No.&nbsp;<i class="fa fa-sort" aria-hidden="true"></i></th>
                        <th>Billing Method&nbsp;<i class="fa fa-sort" aria-hidden="true"></i></th>
                        <th>Billing Month&nbsp;<i class="fa fa-sort" aria-hidden="true"></i></th>
                        <th>Bill (TK.)&nbsp;<i class="fa fa-sort" aria-hidden="true"></i></th>
                        @if(Auth::user()->clients != 1)
                            <th>Entry Date&nbsp;<i class="fa fa-sort" aria-hidden="true"></i></th>
                            <th>Comment&nbsp;<i class="fa fa-sort" aria-hidden="true"></i></th>
                            <th>Entry Done By&nbsp;<i class="fa fa-sort" aria-hidden="true"></i></th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1?>
                    @foreach($bStore as $u)
                        @foreach ($u as $user)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $user->receipt }}</td>
                                <td>{{ $user->method }}</td>
                                <td>
                                    {{--{{ $user->Month }}--}}
                                    @if($user->Month == 1)
                                        January
                                    @elseif($user->Month == 2)
                                        February
                                    @elseif($user->Month == 3)
                                        March
                                    @elseif($user->Month == 4)
                                        April
                                    @elseif($user->Month == 5)
                                        May
                                    @elseif($user->Month == 6)
                                        June
                                    @elseif($user->Month == 7)
                                        July
                                    @elseif($user->Month == 8)
                                        August
                                    @elseif($user->Month == 9)
                                        September
                                    @elseif($user->Month == 10)
                                        October
                                    @elseif($user->Month == 11)
                                        November
                                    @elseif($user->Month == 12)
                                        December
                                    @else
                                        Something went wrong
                                    @endif
                                </td>
                                <td>{{ $user->bill }}</td>
                            @if(Auth::user()->clients != 1)
                                    <td>{{ $user->billentrydate }}</td>
                                    <td>{{ $user->comment }}</td>
                                <td>
                                    @if(Auth::user()->clients != 1)
                                        <?php
                                        $json = $user->entrydoneby;
                                        //
                                        //                var_dump(json_decode($json));
                                        //                var_dump(json_decode($json, true));
                                        ?>
                                        {{--<h5><b>Entry Done By : </b></h5>--}}
                                        <h5>{{ (json_decode($json)->name)}}</h5>
                                    @endif
                                @endif
                                </td>
                            </tr>
                            <input type="hidden" value="{{ $sum = $sum + $user->bill }}">
                        @endforeach
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Total: </th>
                            <td class="invisible"></td>
                            <td class="invisible"></td>
                            <td class="invisible"></td>
                            <td><b>{{ $sum }} Tk.</b></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <br><br>
        </div>
    @endforeach
    <script>
        $(document).ready(function() {
            $('#search').hideseek({
                hidden_mode: true,
                highlight: true
            });
        });
    </script>

    {{--<script src="{{ elixir('js/profile_control.js') }}"></script>--}}

    {{--<script>--}}
    {{--function loadstatus(){--}}
    {{--alert($('#tovale').val());--}}
    {{--$('#vale').val($('#tovale').val());--}}
    {{--}--}}
    {{--</script>--}}
@endsection