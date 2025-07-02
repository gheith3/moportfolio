@extends('layouts.app')

@section('title', 'Home - Portfolio')
@section('description', 'Professional portfolio showcasing my work as a developer and designer')
@section('keywords', 'portfolio, developer, designer, web development, creative work')

@section('content')
<!-- ====== Hero Section ======  -->
<livewire:hero-section />

<!-- ====== About Section ======  -->
<livewire:about-section />

<!-- ====== Services Section ======  -->
<livewire:services-section />

<!-- ====== Portfolio Section ======  -->
<livewire:portfolio-section />

<!-- ====== Clients Section ======  -->
<livewire:clients-section />

<!-- ====== Contact Section ======  -->
<livewire:contact-section />
@endsection