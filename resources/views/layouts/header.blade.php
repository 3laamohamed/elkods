    <!-- Start Sidebar -->
    <aside>
      <span id="close_menu" class="close rounded-3  d-block d-sm-none"> <i class="fa-solid fa-xmark"></i> </span>
      <ul>
{{--        <li class="@if(Route::current()->getName() == 'view.stores') active @endif">--}}
{{--          <a href="{{route('view.stores')}}">--}}
{{--              <i class="fa-solid fa-store fa-xl"></i>--}}
{{--              <span>المخازن</span>--}}
{{--          </a>--}}
{{--        </li>--}}
{{--        <li class="@if(Route::current()->getName() == 'view.section') active @endif">--}}
{{--          <a href="{{route('view.section')}}">--}}
{{--            <i class="fa-solid fa-lightbulb fa-xl"></i>--}}
{{--            <span>الاقسام</span>--}}
{{--          </a>--}}
{{--        </li>--}}
{{--        <li class="@if(Route::current()->getName() == 'view.suppliers') active @endif">--}}
{{--          <a href="{{route('view.suppliers')}}">--}}
{{--              <i class="fa-solid fa-users fa-xl"></i>--}}
{{--            <span>الموردين</span>--}}
{{--          </a>--}}
{{--        </li>--}}
{{--        <li>--}}
{{--          <a href="product-services.html">--}}
{{--              <i class="fa-solid fa-weight-scale fa-xl"></i>--}}
{{--            <span>الوحدات</span>--}}
{{--          </a>--}}
{{--        </li>--}}
{{--          <li class="@if(Route::current()->getName() == 'view.main_groups') active @endif">--}}
{{--              <a href="{{route('view.main_groups')}}">--}}
{{--                  <i class="fa-solid fa-folder-open fa-xl"></i>--}}
{{--                  <span>المجموعات الرئيسية</span>--}}
{{--              </a>--}}
{{--          </li>--}}
{{--        <li class="@if(Route::current()->getName() == 'view.groups') active @endif">--}}
{{--          <a href="{{route('view.groups')}}">--}}
{{--            <i class="fa-solid fa-folder-open fa-xl"></i>--}}
{{--            <span>المجموعات الفرعية</span>--}}
{{--          </a>--}}
{{--        </li>--}}
{{--        <li class="@if(Route::current()->getName() == 'view.material') active @endif">--}}
{{--          <a href="{{Route('view.material')}}">--}}
{{--            <i class="fa-solid fa-file-lines fa-xl"></i>--}}
{{--            <span>الخامات</span>--}}
{{--          </a>--}}
{{--        </li>--}}
{{--        <li class="@if(Route::current()->getName() == 'view_components_items') active @endif">--}}
{{--          <a href="{{Route('view_components_items')}}">--}}
{{--            <i class="fa-solid fa-address-book fa-xl"></i>--}}
{{--            <span>مكونات الاصناف</span>--}}
{{--          </a>--}}
{{--        </li>--}}
{{--        <li class="@if(Route::current()->getName() == 'componentDetailsItem') active @endif">--}}
{{--          <a href="{{route('componentDetailsItem')}}">--}}
{{--            <i class="fa-solid fa-briefcase fa-xl"></i>--}}
{{--            <span>مكونات تفاصيل الاصناف</span>--}}
{{--          </a>--}}
{{--        </li>--}}
        <li class="@if(Route::current()->getName() == 'viewInfo') active @endif">
          <a href="{{route('viewInfo')}}">
              <i class="fa-solid fa-circle-info fa-xl"></i>
              <span>معلومات</span>
          </a>
        </li>
          <li class="@if(Route::current()->getName() == 'viewLocations') active @endif">
              <a href="{{route('viewLocations')}}">
                  <i class="fa-solid fa-location-dot fa-xl"></i>
                  <span>المناطف</span>
              </a>
          </li>
      <li class="@if(Route::current()->getName() == 'viewCustomers') active @endif">
          <a href="{{route('viewCustomers')}}">
              <i class="fa-solid fa-users fa-xl"></i>
              <span>العملاء</span>
          </a>
      </li>
        <li class="@if(Route::current()->getName() == 'viewCustomersPrice') active @endif">
          <a href="{{route('viewCustomersPrice')}}">
              <i class="fa-solid fa-sack-dollar fa-xl"></i>
            <span>تغير اسعار</span>
          </a>
        </li>
        <li class="@if(Route::current()->getName() == 'viewMilkSupply') active @endif">
          <a href="{{route('viewMilkSupply')}}">
            <i class="fa-solid fa-truck-droplet fa-xl"></i>
            <span>توريد لبن</span>
          </a>
        </li>
        <li>
          <a href="order.html">
            <i class="fa-solid fa-list-check fa-xl"></i>
            <span>order list</span>
          </a>
        </li>
        <li>
          <a href="memberships.html">
            <i class="fa-solid fa-users fa-xl"></i>
            <span>memberships</span>
          </a>
        </li>
      </ul>
    </aside>
    <!-- End Sidebar -->
