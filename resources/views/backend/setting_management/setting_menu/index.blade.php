 @extends('adminlte::page')

 @section('title', 'System Settings')

 @section('adminlte_css')
     <link rel="stylesheet" href="{{ asset('css/backend/setting_page/setting_base.css') }}">
     <link rel="stylesheet" href="{{ asset('css/backend/setting_page/setting_accordion.css') }}">
     <link rel="stylesheet" href="{{ asset('css/backend/setting_page/setting_items.css') }}">
     <link rel="stylesheet" href="{{ asset('css/backend/setting_page/setting_components.css') }}">
     <link rel="stylesheet" href="{{ asset('css/backend/setting_page/setting_resp.css') }}">
     <link rel="stylesheet" href="{{ asset('css/backend/setting_page/setting_header.css') }}">
     <link rel="stylesheet" href="{{ asset('css/backend/setting_page/setting_security_part.css') }}">
     <link rel="stylesheet" href="{{ asset('css/backend/setting_page/setting_notification_part.css') }}">
     <link rel="stylesheet" href="{{ asset('css/backend/setting_page/setting_system_part.css') }}">
     <link rel="stylesheet" href="{{ asset('css/backend/setting_page/setting_logs_part.css') }}">
     <link rel="stylesheet" href="{{ asset('css/backend/setting_page/setting_ui_part.css') }}">
     <link rel="stylesheet" href="{{ asset('css/backend/setting_page/setting_backup_part.css') }}">
 @stop

 @section('content_header')
     <div class="setting-page-heading">
         <div class="setting-heading-icon">
             <i class="fas fa-sliders-h"></i>
         </div>

         <div class="setting-heading-content">
             <span class="setting-heading-eyebrow">CONTROL CENTER</span>
             <h3>System Settings</h3>
             <p>Manage security, notifications, system preferences and maintenance.</p>
         </div>
     </div>
 @stop

 @section('content')
     <div class="container-fluid setting-page-container">

         <div class="setting-intro">
             <div>
                 <span class="setting-intro-label">CONFIGURATION</span>
                 <h5>Manage Your Workspace</h5>
                 <p>Choose a category below to view and configure its available options.</p>
             </div>

             <div class="setting-intro-icon">
                 <i class="fas fa-cog"></i>
             </div>
         </div>

         <div class="accordion setting-accordion" id="settingsAccordion">

             {{-- Security Settings --}}
             @include('backend.setting_management.setting_menu.partial_pages.part_1')

             {{-- Notification Settings --}}
             @include('backend.setting_management.setting_menu.partial_pages.part_2')

             {{-- System Settings --}}
             @include('backend.setting_management.setting_menu.partial_pages.part_3')

             {{-- Logs --}}
             @include('backend.setting_management.setting_menu.partial_pages.part_4')

             {{-- Integration --}}
             @include('backend.setting_management.setting_menu.partial_pages.part_5')

             {{-- UI Settings --}}
             @include('backend.setting_management.setting_menu.partial_pages.part_6')

             {{-- Backup & Maintenance --}}
             @include('backend.setting_management.setting_menu.partial_pages.part_7')

         </div>
     </div>
 @stop
