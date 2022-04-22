
 <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
        <div class="inner d-flex justify-content-between m-2">
            <h3>{{ $usersCount }}</h3>
            <x-animations.ballet />
            <select wire:change="getUsersCount($event.target.value)" class="form-control-sm px-1 rounded btn btn-outline-light m-2">
                <option class="form-group" value="today">Today</option>
                <option class="form-group" value="30">30 days</option>
                <option  class="form-group"value="60">60 days</option>
                <option  class="form-group"value="360">360 days</option>
                <option class="form-group" value="MTD">Month to Date</option>
                <option class="form-group" value="YTD">Year to Date</option>
         
            </select>
        </div>
        {{-- <p class="p-2 m-2">Users</p> --}}
        <div class="icon">
            <i class="ion ion-bag"></i>
        </div>
        <a href="{{ route('admin.users')}}" class="small-box-footer">Users &nbsp; <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>


