<style>
    .text-color-1 {
        color: #041562;
    }
</style>

    <div class="mb-3  col-12 col-md-6 col-lg-4" >
        <div class="card card-body card-hover-shadow h-100 text-color-1  text-center" style="background-color: #EEEEEE;">
            <h1 class="p-2 text-color-1">{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($data['commission_given']))}}</h1>
            <div class="text-uppercase">{{\App\CPU\translate('commission_given')}}</div>
        </div>
    </div>

    <div class="mb-3  col-12 col-md-6 col-lg-4" >
        <div class="card card-body card-hover-shadow h-100 text-color-1  text-center" style="background-color: #EEEEEE;">
            <h1 class="p-2 text-color-1">{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($data['pending_withdraw']))}}</h1>
            <div class="text-uppercase">{{\App\CPU\translate('pending_withdraw')}}</div>
        </div>
    </div>

    <div class="mb-3  col-12 col-md-6 col-lg-4" >
        <div class="card card-body card-hover-shadow h-100 text-color-1  text-center" style="background-color: #EEEEEE;">
            <h1 class="p-2 text-color-1">{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($data['delivery_charge_earned']))}}</h1>
            <div class="text-uppercase">{{\App\CPU\translate('delivery_charge_earned')}}</div>
        </div>
    </div>

    <div class="mb-3 mb-lg-0  col-12 col-md-6" >
        <div class="card card-body card-hover-shadow h-100 text-color-1  text-center" style="background-color: #EEEEEE;">
            <h1 class="p-2 text-color-1">{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($data['collected_cash']))}}</h1>
            <div class="text-uppercase">{{\App\CPU\translate('collected_cash')}}</div>
        </div>
    </div>

    <div class="mb-3 mb-lg-0  col-12 col-md-6">
        <div class="card card-body card-hover-shadow h-100 text-color-1  text-center" style="background-color: #EEEEEE;">
            <h1 class="p-2 text-color-1">{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($data['total_tax_collected']))}}</h1>
            <div class="text-uppercase">{{\App\CPU\translate('total_collected_tax')}}</div>
        </div>
    </div>

