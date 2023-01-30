@extends('layouts.back-end.app')
@section('title', \App\CPU\translate('Attribute'))
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="{{asset('public/assets/back-end/css/croppie.css')}}" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">

        <div class="row">
            <div class="col-md-12" style="margin-bottom: 10px;">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ \App\CPU\translate('update')}} {{ \App\CPU\translate('attribute')}}</h3>
                    </div>
                    <div class="card-body"
                         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                        <form action="{{route('admin.attribute.update',[$attribute['id']])}}" method="post">
                            @csrf
                            @php($language=\App\Model\BusinessSetting::where('type','pnc_language')->first())
                            @php($language = $language->value ?? null)
                            @php($default_lang = 'en')

                            @php($default_lang = json_decode($language)[0])
                            <ul class="nav nav-tabs mb-4">
                                @foreach(json_decode($language) as $lang)
                                    <li class="nav-item">
                                        <a class="nav-link lang_link {{$lang == $default_lang? 'active':''}}"
                                           href="#"
                                           id="{{$lang}}-link">{{\App\CPU\Helpers::get_language_name($lang).'('.strtoupper($lang).')'}}</a>
                                    </li>
                                @endforeach
                            </ul>
                            @foreach(json_decode($language) as $lang)
                                <?php
                                if (count($attribute['translations'])) {
                                    $translate = [];
                                    foreach ($attribute['translations'] as $t) {
                                        if ($t->locale == $lang && $t->key == "name") {
                                            $translate[$lang]['name'] = $t->value;
                                        }
                                    }
                                }
                                ?>
                                <div class="form-group {{$lang != $default_lang ? 'd-none':''}} lang_form"
                                     id="{{$lang}}-form">
                                    <input type="hidden" id="id">
                                    <label
                                        for="name">{{ \App\CPU\translate('Attribute')}} {{ \App\CPU\translate('Name')}}
                                        ({{strtoupper($lang)}})</label>
                                    <input type="text" name="name[]"
                                           value="{{$lang==$default_lang?$attribute['name']:($translate[$lang]['name']??'')}}"
                                           class="form-control" id="name"
                                           placeholder="{{\App\CPU\translate('Enter_Attribute_Name')}}" {{$lang == $default_lang? 'required':''}}>
                                </div>
                                <input type="hidden" name="lang[]" value="{{$lang}}" id="lang">
                            @endforeach
                            <button type="submit" class="btn btn-primary float-right">{{ \App\CPU\translate('update')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div>
            @endsection

            @push('script')
                <script>
                    $(".lang_link").click(function (e) {
                        e.preventDefault();
                        $(".lang_link").removeClass('active');
                        $(".lang_form").addClass('d-none');
                        $(this).addClass('active');

                        let form_id = this.id;
                        let lang = form_id.split("-")[0];
                        console.log(lang);
                        $("#" + lang + "-form").removeClass('d-none');
                        if (lang == '{{$default_lang}}') {
                            $(".from_part_2").removeClass('d-none');
                        } else {
                            $(".from_part_2").addClass('d-none');
                        }
                    });

                    $(document).ready(function () {
                        $('#dataTable').DataTable();
                    });
                </script>
    @endpush
