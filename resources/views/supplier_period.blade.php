@php $title='فترة المورد';@endphp
@extends('layouts.app')
@section('content')
    <script>
        function printClintes() {
            let divContents = document.getElementById("div_printer").innerHTML;
            document.getElementsByTagName("BODY")[0].innerHTML = divContents
            window.print();
            location.reload();
        }
        function printOwner(){
            let divContents = document.getElementById("printerPage").innerHTML;
            document.getElementsByTagName("BODY")[0].innerHTML = divContents
            window.print();
            location.reload();
        }
        // function changeToatal(){
        //     let element = document.getElementById("borrowValue");
        //     let totalCheck = document.getElementById("totalCheck").innerHTML;
        //     let newBorrow = document.getElementById("borrowValue").value;
        //     let borrow = element.getAttribute("borrow");
        //     let decTotal = (+totalCheck) - (+borrow);
        //     let newToatal = (+decTotal) + (+newBorrow);
        //     console.log(totalCheck)
        // }
    </script>
    <section class="component_items d-block p-5" id="printerPage">
        <div class="row">
            <div class="col-4">
                <div class="d-flex gap-2 mt-2">
                    <span>الاسم : </span>
                    <span>{{$dataCustomer['name']}}</span>
                </div>
                <div class="d-flex gap-2 mt-2">
                    <span>المنطقة : </span>
                    <span>{{$dataCustomer['location']}}</span>
                </div>
                <div class="d-flex gap-2 mt-2">
                    <span>الرصيد : </span>
                    <span>{{$dataCustomer['money']}}</span>
                </div>
            </div>
            <div class="col-4">
                <div class="d-flex gap-2 mt-2">
                    <span>الهاتف : </span>
                    <span>{{$dataCustomer['phone']}}</span>
                </div>
                <div class="d-flex gap-2 mt-2">
                    <span>اجمالى الكمية : </span>
                    <span>{{$dataCustomer['qty']}}</span>
                </div>
                <div class="d-flex gap-2 mt-2">
                    <span>الاجمالي : </span>
                    <span>{{$dataCustomer['total']}}</span>
                </div>
            </div>
            <div class="col-4">
                @if($borrow)
                <div class="d-flex gap-2 mt-2">
                    <span>المتبقي عليه : </span>
                    <span>{{$borrow['borrow'] - $borrow['re_value']}}</span>
                </div>
                <div class="d-flex gap-2 mt-2">
                    <span>  خصم : </span>
                    <input id="borrowValue" borrow="{{$borrow['value']}}" onchange="changeToatal()" type="text" value="{{$borrow['value']}}">
                </div>
                <div class="d-flex gap-2 mt-2">
                    <span>المبلغ المستحق : </span>
                    <span id="totalCheck">{{$dataCustomer['total'] - $borrow['value']}}</span>
                </div>
                @endif
            </div>
        </div>
        <!-- Button trigger modal -->
        <button type="button" onclick="printClintes()" class="btn btn-primary d-print-none">طباعة لعميل</button>
        <button type="button" onclick="printOwner()" class="btn btn-warning d-print-none">طباعة</button>
        <div class="table-responsive mt-3">
            <table class="table table-hover table-striped text-center table-bordered">
                <thead>
                <tr class="table-dark sticky-top">
                    <th rowspan="3">التاريخ</th>
                    <th rowspan="3">اليوم</th>
                    @foreach($currentType as $type)
                        <th colspan="2">{{$type['name']}}</th>
                    @endforeach
                </tr>
                <tr class="table-dark sticky-top">
                    @foreach($currentType as $type)
                        <th>ص</th>
                        <th>م</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($day as $oneday)
                    <tr>
                        <td>{{$oneday['date']}}</td>
                        <td>{{$oneday['day']}}</td>
                        @if($oneday['date'] != null)
                            @foreach($oneday['typeData'] as $type)
                                @foreach($type['shifts'] as $shift)
                                    <td>
                                        @if($shift['qty'] != 0)
                                        <bdi>
                                            {{ $shift['price'] * $shift['qty'] }} = {{$shift['qty']}} x {{ $shift['price'] }}
                                        </bdi>
                                         @endif
                                    </td>
                                @endforeach
                            @endforeach
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
    <div class="modal fade modal-xl" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h1 class="modal-title fs-5" id="exampleModalLabel">طباعة للعميل</h1>
                </div>
                <div class="modal-body" id="div_printer">
                    <div class="row mt-3">
                        <div class="col-3">
                            <img width="100" height="100" src="{{$info->logo}}">
                        </div>
                        <div class="col-3">
                            <div class="d-flex gap-2 mt-2">
                                <span> الشركة: </span>
                                <span>{{$info->name}}</span>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="d-flex gap-2 mt-2">
                                <span> العنوان: </span>
                                <span>{{$info->phone}}</span>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="d-flex gap-2 mt-2">
                                <span> الهاتف: </span>
                                <span>{{$info->location}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="d-flex gap-2 mt-2">
                                <span>الاسم : </span>
                                <span>{{$dataCustomer['name']}}</span>
                            </div>
                            <div class="d-flex gap-2 mt-2">
                                <span>المنطقة : </span>
                                <span>{{$dataCustomer['location']}}</span>
                            </div>
                            <div class="d-flex gap-2 mt-2">
                                <span>الرصيد : </span>
                                <span>{{$dataCustomer['money']}}</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="d-flex gap-2 mt-2">
                                <span>الهاتف : </span>
                                <span>{{$dataCustomer['phone']}}</span>
                            </div>
                            <div class="d-flex gap-2 mt-2">
                                <span>اجمالى الكمية : </span>
                                <span>{{$dataCustomer['qty']}}</span>
                            </div>
                            <div class="d-flex gap-2 mt-2">
                                <span>الاجمالي : </span>
                                <span>{{$dataCustomer['total']}}</span>
                            </div>
                        </div>
                        <div class="col-4">
                            @if($borrow)
                                <div class="d-flex gap-2 mt-2">
                                    <span>المتبقي عليه : </span>
                                    <span>{{$borrow['borrow'] - $borrow['re_value']}}</span>
                                </div>
                                <div class="d-flex gap-2 mt-2">
                                    <span>  خصم : </span>
                                    <span>{{$borrow['value']}}</span>
                                </div>
                                <div class="d-flex gap-2 mt-2">
                                    <span>المبلغ المستحق : </span>
                                    <span>{{$dataCustomer['total'] - $borrow['value']}}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-hover table-striped text-center table-bordered">
                            <thead>
                            <tr class="table-dark sticky-top">
                                <th rowspan="3">التاريخ</th>
                                <th rowspan="3">اليوم</th>
                                @foreach($currentType as $type)
                                    <th colspan="2">{{$type['name']}}</th>
                                @endforeach
                            </tr>
                            <tr class="table-dark sticky-top">
                                @foreach($currentType as $type)
                                    <th>ص</th>
                                    <th>م</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($day as $oneday)
                                <tr>
                                    <td>{{$oneday['date']}}</td>
                                    <td>{{$oneday['day']}}</td>
                                    @if($oneday['date'] != null)
                                        @foreach($oneday['typeData'] as $type)
                                            @foreach($type['shifts'] as $shift)
                                                <td>
                                                    @if($shift['qty'] != 0)
                                                        <bdi>
                                                            {{ $shift['price'] * $shift['qty'] }}
                                                        </bdi>
                                                    @endif
                                                </td>
                                            @endforeach
                                        @endforeach
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="printclients" onclick="printDiv()" class="btn btn-primary"><i class="fa-solid fa-print"></i></button>
                </div>
            </div>
        </div>
    </div>
@stop
