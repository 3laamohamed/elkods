@php $title='فترة معلقة';@endphp
@extends('layouts.app')
@section('content')
    <script src="{{ asset('assets/js/sweetalert2@10.js') }}" ></script>
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
        function closePeriod(){
            let borrow = document.getElementById("borrowValue");
            let valBorrow = 0;
            let priceValue = document.getElementById("totalCheck").value;
            if(borrow){valBorrow = borrow.value}
            Swal.fire({
                title: 'متأكد من قفل المدة!',
                text: "لن تستطيع عمل توريد لبن لهذا العميبل اليوم",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'قفل المدة',
                cancelButtonText: 'الغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/closePeriodPending',{
                        customer:'{{$dataCustomer['id']}}',
                        valBorrow,
                        priceValue
                    }).then((response) =>{
                        if(response.data.status == false){
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: response.data.data,
                                showConfirmButton: true,
                            })
                        }else if(response.data.status == true){
                            // Swal.fire({
                            //     position: 'top-end',
                            //     icon: 'success',
                            //     title: response.data.data,
                            //     showConfirmButton: false,
                            //     timer: 1500
                            // })
                            printClintes()
                        }
                    })
                }
            })


        }
        function changeLocation(){
            let location = document.getElementById("locationId").value;
            let customers = document.getElementById("customerId");
            axios.post('/getCustomersInLocation',{
                id:location
            }).then((response)=>{
                let html = '';
                response.data.customers.forEach((customer)=>{
                    html += `<option value="${customer.id}">${customer.name}</option>`
                })
                customers.innerHTML = html;
            })
        }
        function calcTotal(){
            let test = {{$dataCustomer['total']}}
            let customerMoney = document.getElementById('customer_money').textContent;
            let borrowValueElement = document.getElementById('borrowValue');
            let borrowValue = 0;
            let totalCheck = document.getElementById('totalCheck');
            let totalCashPrint = document.getElementById('totalCashPrint');
            let borrowValuePrint = document.getElementById('borrowValuePrint');
            if(borrowValueElement){borrowValue =borrowValueElement.value}
            let finalTotal = +test - +borrowValue;

            totalCheck.value = finalTotal
            totalCashPrint.innerHTML = finalTotal
            if(borrowValuePrint){
                borrowValuePrint.innerHTML = borrowValue
            }
        }
        document.addEventListener('DOMContentLoaded', calcTotal);
    </script>
    <section class="component_items d-block p-5" id="printerPage">
        <div class="supplier-header d-flex flex-md-row-reverse flex-column gap-2 justify-content-between align-items-end">
            <div class="d-flex gap-2">
{{--                <button type="button" onclick="printClintes()" class="btn btn-primary d-print-none @if($realCounter == 0) disabled @endif">طباعة لعميل</button>--}}
{{--                <button type="button" onclick="printOwner()" class="btn btn-warning d-print-none @if($realCounter == 0) disabled @endif">طباعة</button>--}}
            </div>
            <div class="d-flex gap-2">
                <select class="form-select"  id="locationId" onchange="changeLocation()">
                    @foreach($locations as $location)
                        <option value="{{$location->id}}" @if($location->name == $dataCustomer['location'])selected @endif>{{$location->name}}</option>
                    @endforeach
                </select>
                <form action="{{ route('getCustomerDetails') }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <select class="form-select" id="customerId" name="customer" style="min-width: 200px">
                        @foreach($customersLocation as $customer)
                            <option value="{{$customer->id}}" @if($customer->id == $dataCustomer['id'])selected @endif>{{$customer->name}}</option>
                        @endforeach
                    </select>
                    <button class="search"><i class="fa-solid fa-magnifying-glass fa-lg"></i></button>
                </form>
            </div>
        </div>
        <hr />
        <div class="row customer-info">
            <div class="col-md-3 col-6">
                <div class="d-flex mt-2">
                    <span class="icon"><i class="fa-solid fa-user fa-lg"></i></span>
                    <span>{{$dataCustomer['name']}}</span>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="d-flex mt-2">
                    <span class="icon"><i class="fa-solid fa-location-dot fa-lg"></i></span>
                    <span>{{$dataCustomer['location']}}</span>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="d-flex mt-2">
                    <span class="icon"><i class="fa-solid fa-phone fa-lg"></i></span>
                    <span>{{$dataCustomer['phone']}}</span>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="d-flex mt-2">
                    <span class="icon"><i class="fa-solid fa-sack-dollar fa-lg"></i></span>
                    <span id="customer_money">{{$dataCustomer['money']}}</span>
                </div>
            </div>
        </div>
        <hr />
        <div class="row customer-info" id="dataCal">
            @if($borrow)
                <div class="col-md-3">
                    <div class="d-flex mt-2">
                        <span class="icon text"> المدفوع من السلفه </span>
                        <input id="borrowValue" class="form-control" borrow="{{$borrow['value']}}" onchange="calcTotal()" type="number" value="{{$borrow['value']}}">
                    </div>
                </div>
                <div class=" col-md-3">
                    <div class="d-flex mt-2">
                        <span class="icon text"> المتبقى من السلفه  </span>
                        <span class="text-2">{{$borrow['borrow'] - $borrow['re_value']}}</span>
                    </div>
                </div>
            @endif
            <div class="col-md-3">
                <div class="d-flex mt-2">
                    <span class="icon text">المبلغ المدفوع  </span>
                    <input id="totalCheck" type="number"  class="form-control" value="">
                </div>
            </div>
            <div class="col-md-3">
                <button type="button" onclick="closePeriod()" class="btn btn-warning d-print-none mt-2 @if($realCounter == 0) disabled @endif">قفل المدة</button>
            </div>

        </div>
        <hr />
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
                <tfoot class="table-dark sticky-bottom">
                    <tr>
                        <td colspan="2">الاجمالى</td>
                        <td>الكمية</td>
                        <td>{{$dataCustomer['qty']}}</td>
                        <td>السعر</td>
                        <td>{{$dataCustomer['total']}}</td>
                    </tr>
                </tfoot>
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
                <div class="modal-body mx-2" id="div_printer">
                    <div class="row mt-1 align-items-center">
                        <div class="col-3">
                            <img class="w-100" src="{{$info->logo}}">
                        </div>
                        <div class="col-9 ">
                            <div class="row ">
                                <div class="d-flex mt-2">
                                    <span>{{$info->name}}</span>
                                </div>
                            </div>
                            <div class="row ">
                                    <div class="d-flex gap-2 mt-2">
                                        <span>{{$info->phone}}</span>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <div class="d-flex gap-2 mt-2">
                                        <span>{{$info->location}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="d-flex gap-2 mt-2">
                                <span>الاسم : </span>
                                <span>{{$dataCustomer['name']}}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex gap-2 mt-2 text-center">
                                <span>المنطقة : </span>
                                <span>{{$dataCustomer['location']}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex gap-2 mt-2">
                                <span>الهاتف : </span>
                                <span>{{$dataCustomer['phone']}}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex gap-2 mt-2">
                                <span>الرصيد : </span>
                                <span>{{$dataCustomer['money']}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-hover table-striped text-center table-bordered">
                            <thead>
                            <tr class="table-dark sticky-top">
                                <th rowspan="2">اليوم</th>
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
                            <tfoot class="table-dark sticky-bottom">
                            <tr>
                                <td>الاجمالى</td>
                                <td>الكمية</td>
                                <td>{{$dataCustomer['qty']}}</td>
                                <td>السعر</td>
                                <td>{{$dataCustomer['total']}}</td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <hr />
                    @if($borrow)
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex gap-2 mt-2">
                                    <span> المدفوع من السلفه : </span>
                                    <span id="borrowValuePrint"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex gap-2 mt-2">
                                    <span> المتبقى من السلفه : </span>
                                    <span>{{$borrow['borrow'] - $borrow['re_value']}}</span>
                                </div>
                            </div>
                        </div>
                        <hr />
                    @endif
                    <div class="row">
                        <div class="col-md-4">
                            <div class="d-flex gap-2 mt-2">
                                <span>المبلغ المدفوع : </span>
                                <span id="totalCashPrint"></span>
                            </div>
                        </div>
                    </div>
                    <hr />
                </div>
                <div class="modal-footer">
                    <button type="button" id="printclients" onclick="printDiv()" class="btn btn-primary"><i class="fa-solid fa-print"></i></button>
                </div>
            </div>
        </div>
    </div>
@stop
