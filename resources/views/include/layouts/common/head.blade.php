 <meta charset="utf-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
 <meta http-equiv="X-UA-Compatible" content="ie=edge" />
 <meta name="csrf-token" content="{{ csrf_token() }}">

 <title translate="no">{{ getSetting('APPLICATION_NAME') . ' - ' }} @yield('title')</title>
 <link rel="icon" type="image/png" href="{{ asset('storage/images/' . getSetting('FAVICON')) }}">

 <style>
     :root {
         --tblr-primary: {{ getSetting('PRIMARY_COLOR') }} !important;
     }
 </style>

 @if (getSelectedLanguage()->direction === 'rtl')
     <link href="{{ asset('/css/tabler.rtl.min.css') }}" rel="stylesheet" />
 @else
     <link href="{{ asset('/css/tabler.min.css') }}" rel="stylesheet" />
 @endif


 @if (isDemoMode())
     <link href="{{ asset('/css/demo.css?version=') . getVersion() }}" rel="stylesheet" />
 @endif

 @if (getSetting('PWA') == 'enabled')
     <link rel="manifest" href="/manifest.json">
 @endif

 <style>
     @import url("{{ asset('/css/inter.css') }}");
 </style>
